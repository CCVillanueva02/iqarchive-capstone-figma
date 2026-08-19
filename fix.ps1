$text = Get-Content C:\php84\php.ini
$text = $text[0..($text.Length-3)]
$text += 'extension=mbstring'
$text | Out-File -Encoding utf8 C:\php84\php.ini
