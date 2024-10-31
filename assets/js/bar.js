$(document).ready(function () {
    showGraph();
});

function showGraph() {
    $.post("bar_encode.php", function (data) {
        console.log(data);
        var id = [];
        var jual = [];

        for (var i in data) {
            id.push(data[i].nama);
            jual.push(data[i].jumlah_akhir);
        }

        var chartdata = {
            labels: id,
            datasets: [
                {
                    label: 'Nama Barang',
                    backgroundColor: '#49e2ff',
                    hoverBackgroundColor: '#CCCCCC',
                    hoverBorderColor: '#666666',
                    data: jual
                }
            ]
        };

        var graphTarget = $("#graphCanvas");

        var barGraph = new Chart(graphTarget, {
            type: 'bar',
            data: chartdata
        });
    });
}
