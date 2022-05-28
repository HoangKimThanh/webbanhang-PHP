// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

$(document).ready(function () {
    showMultiLine();
})

function showMultiLine() {
    var myMultiLine = $('#myMultiLine');
    $.post("data.php", function (data) {
        console.log(data);
        let newData = $.parseJSON(data).compare;
        console.log(newData);

        let last = newData.last;
        let current = newData.current;

        let arrRevenueLast = [];

        let arrDayOfWeek = [0, 1, 2, 3, 4, 5, 6];

        for (const key in arrDayOfWeek) {
            typeof current[key] !== 'undefined' ? arrRevenueLast.push(last[key]) : arrRevenueLast.push(0);
        }

        /**
         * day => value
         * for(const day in week)
         * arrRevenue.push(last[day])
         */

        let arrDay = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        let arrRevenueCurrent = [];

        for (const key in arrDayOfWeek) {
            typeof current[key] !== 'undefined' ? arrRevenueCurrent.push(current[key]) : arrRevenueCurrent.push(0);
        }

        console.log(arrRevenueCurrent, arrRevenueLast)

        new Chart(myMultiLine, {
            type: "line",
            data: {
                labels: arrDay,
                datasets: [{
                    data: arrRevenueCurrent,
                    borderColor: "red",
                    fill: false
                }, {
                    data: arrRevenueLast,
                    borderColor: "green",
                    fill: false
                }]
            },
            options: {
                legend: { display: false }
            }
        });
    })
}