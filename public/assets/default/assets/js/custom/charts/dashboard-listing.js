(function ($) {
    "use strict";

    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
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
        maintainAspectRatio: false,
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

    // Properties
    var optsProperties = $.extend({}, defaultOptions);
    optsProperties.elements = {
        line: {
            tension: 0, // disables bezier curves
        }
    };

    var ctxProperties = document.getElementById('chart-properties').getContext('2d');
    new Chart(ctxProperties, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G"],
            datasets: [{
                    label: 'Properties',
                    data: [70, 425, 263, 820, 290, 1060, 230],
                    pointRadius: 0,
                backgroundColor: color('#092453').alpha(0.9).rgbString(),
                borderColor: color('#092453').alpha(0.9).rgbString(),
                hoverBorderColor: color('#092453').alpha(0.9).rgbString(),
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }]
        },
        options: optsProperties
    });

    // Cities
    var optsCities = $.extend({}, defaultOptions);

    var ctxCities = document.getElementById('chart-cities').getContext('2d');
    new Chart(ctxCities, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G"],
            datasets: [{
                    label: 'Cities',
                    data: [70, 325, 163, 620, 190, 860, 230],
                    pointRadius: 0,
                    backgroundColor: color('#b47928').alpha(0.9).rgbString(),
                    borderColor: color('#b47928').alpha(0.9).rgbString(),
                    hoverBorderColor: color('#b47928').alpha(0.9).rgbString(),
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }]
        },
        options: optsCities
    });

    // Online Visits
    var optsOnlineVisits = $.extend({}, defaultOptions);
    optsOnlineVisits.elements = {
        line: {
            tension: 0, // disables bezier curves
        }
    };

    var ctxOnlineVisits = document.getElementById('chart-online-visits').getContext('2d');
    new Chart(ctxOnlineVisits, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G"],
            datasets: [{
                    label: 'Online Visits',
                    data: [170, 450, 163, 720, 190, 860, 230],
                    pointRadius: 0,
                    backgroundColor: color('#078d79').alpha(0.9).rgbString(),
                    borderColor: color('#078d79').alpha(0.9).rgbString(),
                    hoverBorderColor: color('#078d79').alpha(0.9).rgbString(),
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }]
        },
        options: optsOnlineVisits
    });

    // Online Queries
    var optsOnlineQueries = $.extend({}, defaultOptions);
    optsOnlineQueries.elements = {
        line: {
            tension: 0, // disables bezier curves
        }
    };

    var ctxOnlineQueries = document.getElementById('chart-online-queries').getContext('2d');
    new Chart(ctxOnlineQueries, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G"],
            datasets: [{
                    label: 'Online Queries',
                    data: [170, 450, 163, 720, 190, 860, 230],
                    pointRadius: 0,
                    backgroundColor: color('#a14776').alpha(0.9).rgbString(),
                    borderColor: color('#a14776').alpha(0.9).rgbString(),
                    hoverBorderColor: color('#a14776').alpha(0.9).rgbString(),
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }]
        },
        options: optsOnlineQueries
    });

    // Deals
    var ctxDeals = document.getElementById('chart-deals').getContext('2d');

    var optsDeals = $.extend({}, defaultOptions);
    optsDeals.scales = {
        xAxes: [
            {
                gridLines: {
                    display: false
                },
                display: true,
                stacked: true,
                categoryPercentage: 1.0,
                barPercentage: 0.4
            }
        ],
        yAxes: [
            {
                display: false,
                stacked: true
            }
        ]
    };

    optsDeals.tooltips = {
        callbacks: {
            title: function (tooltipItem, data) {
                var tindex = tooltipItem[0].index;
                return months[tindex];
            }
        }
    };

    new Chart(ctxDeals, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Closed Deals',
                    data: [2, 4, 8, 8, 8, 8, 9, 3, 6, 6, 4, 3],
                    backgroundColor: '#038FDE',
                    hoverBackgroundColor: '#038FDE',
                },
                {
                    label: 'Queries',
                    data: [4, 8, 6, 8, 6, 4, 2, 9, 6, 7, 12, 8],
                    backgroundColor: '#FE9E15',
                    hoverBackgroundColor: '#FE9E15',
                }
            ]
        },
        options: optsDeals
    });
    
    $('.dt-chart .action-btn').each(function(){
        $(this).on('click', function(){
            wieldy.addClass(this, '.dt-chart', 'dt-chart__reveal')
        });
    });
    
    $('.dt-chart .close-btn').each(function(){
        $(this).on('click', function(){
            wieldy.removeClass(this, '.dt-chart', 'dt-chart__reveal')
        });
    });
    
    $(".dt-slider .owl-carousel").owlCarousel({
        items: 1
    });
})(jQuery);