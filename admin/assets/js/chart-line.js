// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// window.addEventListener('load', function() {
//     var ctx = document.getElementById('myLineChart');
//     var myLineChart = new Chart(ctx, {

//     })
// })

$(document).ready(function() {
    showLineChart();
})

function showLineChart() {
    var myLineChart = $('#myLineChart');
    $.post("data.php", function(data) {
        var newData = $.parseJSON(data).visitors;

        var arrDate = [];
        var arrVisitors = [];

        for (const key in newData) {
            arrDate.push(newData[key].date);
            arrVisitors.push(newData[key].visitors);
        }

        new Chart(myLineChart, {
            type: 'line',
            data: {
                labels: arrDate,
                datasets: [{
                    label: 'Lượt truy cập: ',
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "rgba(0,0,255,1.0)",
                    borderColor: "rgba(0,0,255,0.1)",
                    data: arrVisitors
                }],
            },
            options: {
                title: {
                    display: false,
                    text: 'Lượt truy cập: '
                },
                legend: {display: false},
                scales: {
                    xAxes: [{
                        display: false,
                    }],
                    yAxes: [{ticks: {min: 0, stepSize: 1}}]
                }
            }
        })
    })
}