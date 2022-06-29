// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Area Chart Example

$(document).ready(function() {
    showChart();
})


function showChart() {
    var ctx = document.getElementById("myLineChart");
    $.post("data.php", function(data) {
        var lbs = [];
        var datas = [];

        for (const key in data) {
            lbs.push(data[key].date);
            datas.push(data[key].renevue);
        }
        var myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: lbs,
            datasets: [{
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(0,0,255,1.0)",
                borderColor: "rgba(0,0,255,0.1)",
                data: datas
              }],
          },
          options: {
            legend: {display: false},
            scales: {
              yAxes: [{ticks: {min: 0, max:100000000}}],
            }
          }
        });
    })

}

