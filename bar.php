<!DOCTYPE html>
<html>
<head>
    <title>Contoh Penggunaan BarsGraph</title>
    <style type="text/css">
        BODY {
            width: 550px;
        }

        #chart-container {
            width: 100%;
            height: auto;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>
    <div id="chart-container">
        <canvas id="graphCanvas"></canvas>
    </div>

    <script>
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
    </script>
</body>
</html>
