<?php
$zip = new ZipArchive;
$file = 'AACCUP TECHNICAL REVIEW and RECOMMENDED BOARD ACTION.xlsx';

if ($zip->open($file) === TRUE) {
    $sharedStrings = [];
    $ssContent = $zip->getFromName('xl/sharedStrings.xml');
    if ($ssContent !== false) {
        $xml = simplexml_load_string($ssContent);
        if ($xml) {
            foreach ($xml->si as $si) {
                if (isset($si->t)) {
                    $sharedStrings[] = (string)$si->t;
                } else {
                    $text = '';
                    foreach ($si->r as $r) {
                        if (isset($r->t)) $text .= (string)$r->t;
                    }
                    $sharedStrings[] = $text;
                }
            }
        }
    }
    
    $wbContent = $zip->getFromName('xl/workbook.xml');
    $sheetNames = [];
    if ($wbContent !== false) {
        $xml = simplexml_load_string($wbContent);
        foreach ($xml->sheets->sheet as $sheet) {
            $sheetNames[(string)$sheet['sheetId']] = (string)$sheet['name'];
        }
    }

    $result = [];
    for ($i = 1; $i <= 10; $i++) {
        $sheetContent = $zip->getFromName('xl/worksheets/sheet' . $i . '.xml');
        if ($sheetContent !== false) {
            $sheetName = $sheetNames[$i] ?? 'Sheet'.$i;
            $xml = simplexml_load_string($sheetContent);
            $rows = [];
            $rowCount = 0;
            foreach ($xml->sheetData->row as $row) {
                if ($rowCount++ > 100) break;
                $rowData = [];
                // Initialize array to fill empty cells if they are missing from XML (basic approximation)
                foreach ($row->c as $c) {
                    $val = (string)$c->v;
                    if (isset($c['t']) && $c['t'] == 's') {
                        $val = $sharedStrings[(int)$val] ?? $val;
                    }
                    $rowData[] = $val;
                }
                $rows[] = implode(" | ", $rowData);
            }
            $result[$sheetName] = $rows;
        }
    }
    $zip->close();
    
    header('Content-Type: application/json');
    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    echo json_encode(["error" => "Failed to open ZIP."]);
}
?>
