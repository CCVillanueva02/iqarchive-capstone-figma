const xlsx = require('xlsx');
const fs = require('fs');

const wb = xlsx.readFile('AACCUP TECHNICAL REVIEW and RECOMMENDED BOARD ACTION.xlsx');
let output = 'Sheets: ' + wb.SheetNames.join(', ') + '\n\n';

wb.SheetNames.forEach(name => {
    const sheet = wb.Sheets[name];
    const json = xlsx.utils.sheet_to_json(sheet, {header: 1});
    output += `\n=== Sheet: ${name} ===\n`;
    const rows = json.slice(0, 15); // first 15 rows
    output += JSON.stringify(rows, null, 2) + '\n';
});

fs.writeFileSync('excel_output.txt', output);
console.log('Successfully written to excel_output.txt');
