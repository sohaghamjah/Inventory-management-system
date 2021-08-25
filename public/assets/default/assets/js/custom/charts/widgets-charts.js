(function ($) {
    "use strict";

    var color = Chart.helpers.color;

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

    var ctxProductivity = document.getElementById('chart-productivity').getContext('2d');
    new Chart(ctxProductivity, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G"],
            datasets: [{
                    label: '# of Votes',
                    data: [200, 800, 600, 2100, 1000, 2860, 1960],
                    pointRadius: 0,
                    backgroundColor: '#038FDE',
                    borderWidth: 0,
                    borderColor: '#038FDE',
                    hoverBorderWidth: 0,
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }]
        },
        options: defaultOptions
    });

    var ctxWorkStatus = document.getElementById('chart-work-status').getContext('2d');
    new Chart(ctxWorkStatus, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G", "Page K", "Page M", "Page R"],
            datasets: [{
                    label: 'Work Status',
                    data: [1900, 1300, 1850, 1680, 3600, 1400, 2200, 1300, 1880, 2290],
                    pointRadius: 0,
                    backgroundColor: '#038FDE',
                    borderWidth: 0,
                    borderColor: '#038FDE',
                    hoverBorderWidth: 0,
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                },
                {
                    label: 'Financial Status',
                    data: [3200, 4100, 2500, 3000, 2560, 2700, 2000, 2000, 3408, 2960],
                    pointRadius: 0,
                    backgroundColor: '#FE9E15',
                    borderWidth: 0,
                    borderColor: '#FE9E15',
                    hoverBorderWidth: 0,
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }
            ]
        },
        options: defaultOptions
    });

    var ctxActiveUsers = document.getElementById('chart-active-users').getContext('2d');
    var gradientActiveUsers = ctxActiveUsers.createLinearGradient(0, 0, 180, 0);
    gradientActiveUsers.addColorStop(0.4, color('#ed8faa').alpha(0.9).rgbString());
    gradientActiveUsers.addColorStop(1, color('#6757de').alpha(0.9).rgbString());

    var optsActiveUsers = defaultOptions;
    optsActiveUsers.elements = {
        line: {
            tension: 0, // disables bezier curves
        }
    };

    new Chart(ctxActiveUsers, {
        type: 'line',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G"],
            datasets: [{
                    label: 'Active Users',
                    data: [170, 525, 363, 720, 390, 860, 230],
                    pointRadius: 0,
                    backgroundColor: gradientActiveUsers,
                    hoverBackgroundColor: gradientActiveUsers,
                    borderWidth: 0,
                    borderColor: 'transparent',
                    hoverBorderColor: 'transparent',
                    hoverBorderWidth: 0,
                    pointBorderWidth: 0,
                    pointHoverBorderWidth: 0,
                }]
        },
        options: optsActiveUsers
    });

    // Campaign Stats
    var optsCampaignStats = defaultOptions;
    optsCampaignStats.scales = {
        xAxes: [
            {
                display: false,
                stacked: true,
                categoryPercentage: 1.0,
                barPercentage: 0.6
            }
        ],
        yAxes: [
            {
                display: false,
                stacked: true
            }
        ]
    };

    var ctxCampaignStats = document.getElementById('chart-campaign-stats');
    new Chart(ctxCampaignStats, {
        type: 'bar',
        data: {
            labels: ["Page A", "Page B", "Page C", "Page D", "Page E", "Page F", "Page G", "Page K", "Page M"],
            datasets: [
                {
                    label: 'Stats',
                    data: [500, 700, 900, 1600, 1200, 1000, 700, 500, 900],
                    backgroundColor: '#10316B'
                },
                {
                    label: 'Stats',
                    data: [600, 800, 1400, 1800, 1000, 1000, 600, 500, 800],
                    backgroundColor: '#FE9E15'
                },
                {
                    label: 'Stats',
                    data: [800, 1400, 2000, 1800, 1800, 1200, 1200, 700, 1400],
                    backgroundColor: '#038FDE'
                }
            ]
        },
        options: optsCampaignStats
    });
})(jQuery);