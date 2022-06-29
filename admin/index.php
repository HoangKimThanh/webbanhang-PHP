<?php 
    require_once './partials/header.php';
    require_once './partials/sidenav.php';

    require_once 'statistics.php';
?>

<style>
    .sb-nav-fixed #layoutSidenav #layoutSidenav_content {
        padding-left: 225px;
        top: 12px;
    }
</style>
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card text-white bg-info mb-4">
                                    <div class="card-body">Lượt truy cập: <?php echo total_visitor($conn) ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#myLineChart">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card text-white bg-secondary mb-4">
                                    <div class="card-body">Khách hàng: <?php echo total_customer($conn) ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="customers-show.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Hóa đơn: <?php echo total_invoice($conn) ?></div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="invoices-show.php">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Doanh thu: <?php echo number_format(total_profit($conn)) ?>đ</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#myBarChart">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Lượt truy cập
                                    </div>
                                    <div class="card-body"><canvas id="myLineChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Doanh thu
                                    </div>
                                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        So sánh doanh thu:
                                        <select name="period" id="period">
                                            <option value="0">Tuần này với tuần trước</option>
                                            <option value="1">Tháng này với tháng trước</option>
                                            <option value="2">Năm này với năm trước</option>
                                        </select>
                                    </div>
                                    <div class="card-body"><canvas id="myMultiLine" width="100%" height="40"></canvas></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="./assets/js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
        <script src="./assets/js/chart-line.js"></script>
        <script src="./assets/js/chart-bar.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

        <script>
            $(document).ready(function() {
                function create_chart() {
                    let period = $('#period').val();
                    $.ajax({
                        url: 'data.php',
                        type: 'POST',
                        data: {
                            period: period
                        },
                        dataType: 'json',
                        success: function(data) {
                            let newData = data.compare;
                            let last = newData.last ?? {};
                            let current = newData.current ?? {};
                            
                            let arrDayOfWeek = [0, 1, 2, 3, 4, 5, 6];
                            let arrDateOfMonth = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15
                            , 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
                            let arrMonthOfYear = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
        
                            let arrIndex = [];
                            let arrAlterIndex = [];

                            let textLabelLast = '';
                            let textLabelCurrent = '';
                            let textLabelString = '';
        
                            switch (period) {
                                case '0':
                                    textLabelLast = 'Tuần trước: ';
                                    textLabelCurrent = 'Tuần này: ';
                                    textLabelString = 'Thứ'
                                    arrIndex = arrDayOfWeek;
                                    arrAlterIndex = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                    break;
        
                                case '1':
                                    textLabelLast = 'Tháng trước: ';
                                    textLabelCurrent = 'Tháng này: ';
                                    textLabelString = 'Ngày';
                                    arrIndex = arrDateOfMonth;
                                    arrAlterIndex = arrIndex;
                                    break;
        
                                case '2':
                                    textLabelString = 'Năm'
                                    textLabelLast = 'Năm trước: ';
                                    textLabelCurrent = 'Năm này: ';
                                    arrIndex = arrMonthOfYear;
                                    arrAlterIndex = [
                                        'January',
                                        'February', 
                                        'March', 
                                        'April', 
                                        'May', 
                                        'June', 
                                        'July', 
                                        'August', 
                                        'September',
                                        'October', 
                                        'November',
                                        'December'
                                    ];
                                    break;
                            
                                default:
                                    break;
                            }
        
                            let arrRevenueLast = [];
                            let arrRevenueCurrent = [];
        
                            for (const value of arrIndex) {
                                if (typeof last == 'undefined') {
                                    arrRevenueLast.push(0);
                                } else {
                                    if (typeof last[value] == 'undefined') {
                                        arrRevenueLast.push(0);
                                    } else {
                                        arrRevenueLast.push(last[value])
                                    }
                                }

                                if (typeof current == 'undefined') {
                                    arrRevenueCurrent.push(0);
                                } else {
                                    if (typeof current[value] == 'undefined') {
                                        arrRevenueCurrent.push(0);
                                    } else {
                                        arrRevenueCurrent.push(current[value]);
                                    }
                                }
                            }
        
                            new Chart(myMultiLine, {
                                type: "line",
                                data: {
                                    labels: arrAlterIndex,
                                    datasets: [{
                                        label: textLabelCurrent,
                                        data: arrRevenueCurrent,
                                        borderColor: "green",
                                        fill: false
                                    }, {
                                        label: textLabelLast,
                                        data: arrRevenueLast,
                                        borderColor: "red",
                                        fill: false
                                    }]
                                },
                                options: {
                                    legend: { display: true },
                                    scales: {
                                        xAxes: [{
                                            scaleLabel: {
                                                display: true,
                                                labelString: textLabelString,
                                            }
                                        }],
                                    }
                                }
                            });
                        }
                    })
                }
                $('#period').change(create_chart);
    
                create_chart();
            })
        </script>
    </body>
</html>
