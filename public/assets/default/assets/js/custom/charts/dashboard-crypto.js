(function ($) {
    "use strict";

    var color = Chart.helpers.color;

    // creating chart shadow
    var draw = Chart.controllers.line.prototype.draw;
    Chart.controllers.line = Chart.controllers.line.extend({
        draw: function () {
            draw.apply(this, arguments);
            var ctx = this.chart.chart.ctx;

            var showShadow = ($(ctx.canvas).data('shadow')) ? $(ctx.canvas).data('shadow') : 'no';
            var chartType = ($(ctx.canvas).data('type')) ? $(ctx.canvas).data('type') : 'area';

            if (showShadow == 'yes' && chartType == 'area') {
                var _fill = ctx.fill;
                ctx.fill = function () {
                    ctx.save();
                    ctx.shadowColor = color('#5c5c5c').alpha(0.5).rgbString();
                    ctx.shadowBlur = 16;
                    ctx.shadowOffsetX = 0;
                    ctx.shadowOffsetY = 0;
                    _fill.apply(this, arguments);
                    ctx.restore();
                }
            } else if (showShadow == 'yes' && chartType == 'line') {
                var _stroke = ctx.stroke;
                ctx.stroke = function () {
                    ctx.save();
                    ctx.shadowColor = '#07C';
                    ctx.shadowBlur = 10;
                    ctx.shadowOffsetX = 0;
                    ctx.shadowOffsetY = 4;
                    _stroke.apply(this, arguments);
                    ctx.restore();
                }
            }
        }
    });

    var defaultOptions = {
        responsive: true,
        legend: {
            display: false
        },
        layout: {
            padding: 0
        },
        scales: {
            xAxes: [{
                    display: false
                }],
            yAxes: [{
                    display: false
                }]
        }
    };

    // Active users
    var optsActiveUsers = $.extend({}, defaultOptions);
    optsActiveUsers.elements = {
        line: {
            tension: 0, // disables bezier curves
        }
    };

    var ctxActiveUsers = document.getElementById('chart-active-users').getContext('2d');
    var gradientActiveUsers = ctxActiveUsers.createLinearGradient(0, 0, 230, 0);
    gradientActiveUsers.addColorStop(0, color('#163469').alpha(0.9).rgbString());
    gradientActiveUsers.addColorStop(1, color('#FE9E15').alpha(0.9).rgbString());

    new Chart(ctxActiveUsers, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G"],
            datasets: [{
                    label: 'Active users',
                    data: [170, 525, 363, 720, 390, 860, 230],
                    pointRadius: 0,
                    backgroundColor: gradientActiveUsers,
                    borderColor: 'transparent',
                    hoverBorderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }]
        },
        options: optsActiveUsers
    });

    // Extra revenue
    var optsExtraRevenue = $.extend({}, defaultOptions);

    var ctxExtraRevenue = document.getElementById('chart-extra-revenue').getContext('2d');
    var gradientExtraRevenue = ctxExtraRevenue.createLinearGradient(0, 0, 230, 0);
    gradientExtraRevenue.addColorStop(0, color('#4ECDE4').alpha(0.9).rgbString());
    gradientExtraRevenue.addColorStop(1, color('#06BB8A').alpha(0.9).rgbString());

    new Chart(ctxExtraRevenue, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G"],
            datasets: [{
                    label: 'Active users',
                    data: [170, 525, 363, 720, 390, 860, 230],
                    pointRadius: 0,
                    backgroundColor: gradientExtraRevenue,
                    borderColor: 'transparent',
                    hoverBorderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }]
        },
        options: optsExtraRevenue
    });

    // Orders
    var optsOrders = $.extend({}, defaultOptions);
    optsOrders.elements = {
        line: {
            tension: 0, // disables bezier curves
        }
    };

    var ctxOrders = document.getElementById('chart-orders').getContext('2d');
    var gradientOrders = ctxOrders.createLinearGradient(0, 20, 0, 110);
    gradientOrders.addColorStop(0, color('#e81a24').alpha(0.9).rgbString());
    gradientOrders.addColorStop(1, color('#fc8505').alpha(0.4).rgbString());

    new Chart(ctxOrders, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G"],
            datasets: [{
                    label: 'Active users',
                    data: [100, 525, 363, 720, 390, 860, 230],
                    pointRadius: 0,
                    backgroundColor: gradientOrders,
                    borderColor: 'transparent',
                    hoverBorderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }]
        },
        options: optsOrders
    });

    // Traffic raise
    var optsTrafficRaise = $.extend({}, defaultOptions);
    optsTrafficRaise.elements = {
        line: {
            tension: 0, // disables bezier curves
        }
    };

    var ctxTrafficRaise = document.getElementById('chart-traffic-raise').getContext('2d');
    var gradientTrafficRaise = ctxTrafficRaise.createLinearGradient(0, 0, 230, 0);
    gradientTrafficRaise.addColorStop(0, color('#6757de').alpha(0.9).rgbString());
    gradientTrafficRaise.addColorStop(1, color('#ed8faa').alpha(0.4).rgbString());

    new Chart(ctxTrafficRaise, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G"],
            datasets: [{
                    label: 'Active users',
                    data: [100, 525, 363, 720, 390, 860, 230],
                    fill: false,
                    backgroundColor: '#fff',
                    borderColor: '#038FDE',
                    hoverBorderColor: '#038FDE',
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#FEA931',
                    pointBorderWidth: 2,
                    pointHoverBorderWidth: 2,
                }]
        },
        options: optsTrafficRaise
    });

    // Balance History
    var optsBalanceHistory = $.extend({}, defaultOptions);
    optsBalanceHistory.elements = {
        line: {
            tension: 0, // disables bezier curves
        }
    };

    optsBalanceHistory.scales.xAxes = [
        {
            gridLines: {
                display: false
            },
            display: true
        }
    ];

    var ctxBalanceHistory = document.getElementById('chart-balance-history').getContext('2d');
    var gradientBalanceHistory = ctxBalanceHistory.createLinearGradient(0, 20, 0, 250);
    gradientBalanceHistory.addColorStop(0, color('#38AAE5').alpha(0.9).rgbString());
    gradientBalanceHistory.addColorStop(1, color('#F5FCFD').alpha(0.9).rgbString());

    new Chart(ctxBalanceHistory, {
        type: 'line',
        data: {
            labels: ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', ''],
            datasets: [{
                    label: 'Active users',
                    data: [100, 250, 150, 400, 1000, 400, 1100, 800, 750, 1200, 1000, 1200, 500, 1400],
                    pointRadius: 0,
                    backgroundColor: gradientBalanceHistory,
                    borderWidth: 2,
                    borderColor: '#10316B',
                    hoverBorderColor: '#10316B',
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }]
        },
        options: optsBalanceHistory
    });
})(jQuery);