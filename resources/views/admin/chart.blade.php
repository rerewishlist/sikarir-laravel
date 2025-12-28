<section class="section">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Siswa Per Kelas</h5>

                    <!-- Bar Chart -->
                    <canvas id="kelasChart" style="max-height: 400px;"></canvas>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const siswaPerKelas = @json($siswaPerKelas);

                            const backgroundColors = [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                // Tambahkan lebih banyak warna jika diperlukan
                            ];

                            const borderColors = [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(201, 203, 207, 1)',
                                // Tambahkan lebih banyak warna jika diperlukan
                            ];

                            new Chart(document.querySelector('#kelasChart'), {
                                type: 'bar',
                                data: {
                                    labels: Object.keys(siswaPerKelas).map(kelas => `Kelas ${kelas}`),
                                    datasets: [{
                                        label: 'Jumlah Siswa',
                                        data: Object.values(siswaPerKelas),
                                        backgroundColor: backgroundColors,
                                        borderColor: borderColors,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Jumlah Siswa'
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                    <!-- End Bar Chart -->

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Siswa Per Jurusan</h5>

                    <!-- Bar Chart -->
                    <canvas id="jurusanChart" style="max-height: 400px;"></canvas>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const siswaPerJurusan = @json($siswaPerJurusan);

                            const backgroundColors = [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                // Tambahkan lebih banyak warna jika diperlukan
                            ];

                            const borderColors = [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(201, 203, 207, 1)',
                                // Tambahkan lebih banyak warna jika diperlukan
                            ];

                            new Chart(document.querySelector('#jurusanChart'), {
                                type: 'bar',
                                data: {
                                    labels: Object.keys(siswaPerJurusan).map(jurusan => `${jurusan}`),
                                    datasets: [{
                                        label: 'Jumlah Siswa',
                                        data: Object.values(siswaPerJurusan),
                                        backgroundColor: backgroundColors,
                                        borderColor: borderColors,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Jumlah Siswa'
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                    <!-- End Bar Chart -->

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aktivitas Berita per Bulan</h5>

                    <!-- Doughnut Chart -->
                    <div id="trafficChart" style="min-height: 500px;" class="echart"></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            var beritaPerBulan = @json($beritaPerBulan);
                            var data = [];
                            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                            for (var i = 1; i <= 12; i++) {
                                data.push({
                                    value: beritaPerBulan[i] ? beritaPerBulan[i] : 0,
                                    name: months[i - 1]
                                });
                            }

                            echarts.init(document.querySelector("#trafficChart")).setOption({
                                tooltip: {
                                    trigger: 'item'
                                },
                                legend: {
                                    top: '5%',
                                    left: 'center'
                                },
                                series: [{
                                    name: 'Aktivitas Berita',
                                    type: 'pie',
                                    radius: ['40%', '70%'],
                                    avoidLabelOverlap: false,
                                    label: {
                                        show: false,
                                        position: 'center'
                                    },
                                    emphasis: {
                                        label: {
                                            show: true,
                                            fontSize: '18',
                                            fontWeight: 'bold'
                                        }
                                    },
                                    labelLine: {
                                        show: false
                                    },
                                    data: data
                                }]
                            });
                        });
                    </script>
                    <!-- End Doughnut Chart -->

                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aktivitas Forum per Bulan</h5>

                    <!-- Doughnut Chart -->
                    <div id="forumPerBulan" style="min-height: 500px;" class="echart"></div>
                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            var forumPerBulan = @json($forumPerBulan);
                            var data = [];
                            var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

                            for (var i = 1; i <= 12; i++) {
                                data.push({
                                    value: forumPerBulan[i] ? forumPerBulan[i] : 0,
                                    name: months[i - 1]
                                });
                            }

                            echarts.init(document.querySelector("#forumPerBulan")).setOption({
                                tooltip: {
                                    trigger: 'item'
                                },
                                legend: {
                                    top: '5%',
                                    left: 'center'
                                },
                                series: [{
                                    name: 'Aktivitas Forum',
                                    type: 'pie',
                                    radius: ['40%', '70%'],
                                    avoidLabelOverlap: false,
                                    label: {
                                        show: false,
                                        position: 'center'
                                    },
                                    emphasis: {
                                        label: {
                                            show: true,
                                            fontSize: '18',
                                            fontWeight: 'bold'
                                        }
                                    },
                                    labelLine: {
                                        show: false
                                    },
                                    data: data
                                }]
                            });
                        });
                    </script>
                    <!-- End Doughnut Chart -->

                </div>
            </div>
        </div>

    </div>
</section>
