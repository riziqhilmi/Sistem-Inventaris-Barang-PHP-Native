<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualisasi Barang Masuk</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h2>Pie Chart Kondisi Barang</h2>
    <canvas id="pieChart" width="400" height="400"></canvas>
    <h2>Bar Chart Jumlah Barang</h2>
    <canvas id="graphCanvas" width="400" height="400"></canvas>

    <script>
        $(document).ready(function() {
            showPieChart();
            showBar();
        });

        function showPieChart() {
            $.post("../visual/pie_encode_b.php", function(data) {
                console.log(data);
                var kondisi = [];
                var jumlah = [];

                for (var i in data) {
                    kondisi.push(data[i].kondisi);
                    jumlah.push(data[i].jumlah);
                }

                var chartdata = {
                    labels: kondisi,
                    datasets: [{
                        label: 'Kondisi Barang',
                        backgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56'
                        ],
                        hoverBackgroundColor: [
                            '#FF6384',
                            '#36A2EB',
                            '#FFCE56'
                        ],
                        data: jumlah
                    }]
                };

                var pieGraph = new Chart($("#pieChart"), {
                    type: 'pie',
                    data: chartdata,
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        aspectRatio: 4,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12
                                }
                            }
                        }
                    }
                });
            });
        }

        function showBar() {
            $.post("../visual/bar_encode_b.php", function(data) {
                console.log(data);
                var id = [];
                var jual = [];

                for (var i in data) {
                    id.push(data[i].nama);
                    jual.push(data[i].jumlah_akhir);
                }

                var chartdata = {
                    labels: id,
                    datasets: [{
                        label: 'Nama Barang',
                        backgroundColor: '#49e2ff',
                        hoverBackgroundColor: '#CCCCCC',
                        hoverBorderColor: '#666666',
                        data: jual
                    }]
                };

                var barGraph = new Chart($("#graphCanvas"), {
                    type: 'bar',
                    data: chartdata,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        }
    </script>
</body>
</html>