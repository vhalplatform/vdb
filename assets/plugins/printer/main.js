
function exportToPDF() {
  var tableToExport = document.getElementById("00001010");
  var opt = {
    margin: 10,
    filename: 'data.pdf',
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
  };

  html2pdf().from(tableToExport).set(opt).save();
}




function printTable() {
    exportToPDF();
}