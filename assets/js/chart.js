import helper from "./helper";
import colors from "./colors";
import Chart from "chart.js/auto";

(function () {
    "use strict";

    if ($("#report-donut-chart-1").length) {
        const ctx = $("#report-donut-chart-1")[0].getContext("2d");
        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: [
                    "17 - 30 Years old",
                    "31 - 50 Years old",
                    ">= 50 Years old",
                ],
                datasets: [
                    {
                        data: [15, 10, 65],
                        backgroundColor: [
                            colors.pending(0.5),
                            colors.warning(0.5),
                            colors.primary(0.5),
                        ],
                        hoverBackgroundColor: [
                            colors.pending(0.5),
                            colors.warning(0.5),
                            colors.primary(0.5),
                        ],
                        borderWidth: 1,
                        borderColor: [
                            colors.pending(0.75),
                            colors.warning(0.9),
                            colors.primary(0.5),
                        ],
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                cutout: "90%",
            },
        });
    }

    if ($("#report-line-chart-1").length) {
        const ctx = $("#report-line-chart-1")[0].getContext("2d");
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, colors.primary(0.11));
        gradient.addColorStop(
            1,
            $("html").hasClass("dark") ? "#28344e00" : "#ffffff01"
        );
        new Chart(ctx, {
            type: "line",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [
                    {
                        data: [
                            0, 350, 250, 200, 500, 450, 850, 1050, 950, 1100,
                            900, 1200,
                        ],
                        borderWidth: 1,
                        borderColor: colors.primary(0.7),
                        pointRadius: 3.5,
                        pointBorderColor: colors.primary(0.7),
                        pointBackgroundColor: $("html").hasClass("dark")
                            ? colors.darkmode["400"]()
                            : "#ffffff",
                        backgroundColor: gradient,
                        tension: 0.3,
                        fill: true,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: colors.slate["500"](0.8),
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                    },
                    y: {
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: colors.slate["500"](0.8),
                            callback: function (value, index, values) {
                                return "$" + value;
                            },
                        },
                        grid: {
                            color: $("html").hasClass("dark")
                                ? colors.slate["500"](0.3)
                                : colors.slate["300"](),
                            borderDash: [2, 2],
                            drawBorder: false,
                        },
                    },
                },
            },
        });
    }

    if ($("#report-bar-chart-1").length) {
        const ctx = $("#report-bar-chart-1")[0].getContext("2d");
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
                datasets: [
                    {
                        barPercentage: 0.35,
                        data: [4, 7, 5, 4, 9, 7, 5],
                        borderWidth: 1,
                        borderColor: colors.primary(0.7),
                        backgroundColor: colors.primary(0.11),
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            display: false,
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                    },
                    y: {
                        ticks: {
                            display: false,
                            beginAtZero: true,
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                    },
                },
            },
        });
    }

    if ($(".report-line-chart-2").length) {
        const data = [
            [
                0, 3, 1, 9, 18, 20, 10, 13, 21, 29, 23, 14, 16, 9, 11, 16, 7,
                10, 15, 23, 30, 28, 33, 36, 30, 26, 35, 32, 26, 35, 27, 31, 39,
                41, 43, 51, 45, 49, 58, 63, 54, 56, 53, 50, 42, 45, 48, 58, 54,
                59, 63, 55, 51, 42, 40, 48, 58, 56, 54, 48, 56, 62, 57, 65, 55,
                47, 57, 67, 75, 68,
            ],
            [
                0, 3, 9, 11, 19, 25, 15, 8, 14, 16, 20, 16, 10, 4, 10, 16, 20,
                26, 28, 21, 18, 28, 37, 34, 32, 34, 24, 32, 41, 37, 40, 42, 40,
                35, 45, 37, 34, 42, 34, 28, 30, 22, 16, 21, 24, 28, 30, 40, 47,
                54, 61, 69, 62, 59, 51, 49, 55, 51, 41, 33, 37, 44, 53, 49, 56,
                58, 48, 40, 34, 38,
            ],
            [
                0, 7, 3, 2, 4, 14, 8, 10, 16, 14, 18, 23, 20, 13, 9, 13, 10, 8,
                3, 3, 6, 4, 6, 4, 1, 2, 11, 17, 23, 19, 17, 23, 27, 17, 20, 24,
                22, 16, 23, 32, 22, 28, 35, 37, 29, 21, 18, 24, 18, 24, 21, 18,
                14, 17, 15, 7, 16, 6, 13, 15, 24, 30, 33, 42, 48, 38, 32, 27,
                34, 30,
            ],
            [
                0, 3, 1, 9, 18, 20, 10, 13, 21, 29, 23, 14, 16, 9, 11, 16, 7,
                10, 15, 23, 30, 28, 33, 36, 30, 26, 35, 32, 26, 35, 27, 31, 39,
                41, 43, 51, 45, 49, 58, 63, 54, 56, 53, 50, 42, 45, 48, 58, 54,
                59, 63, 55, 51, 42, 40, 48, 58, 56, 54, 48, 56, 62, 57, 65, 55,
                47, 57, 67, 75, 68,
            ],
        ];

        $(".report-line-chart-2").each(function (key, el) {
            const ctx = $(this)[0].getContext("2d");
            const gradient = ctx.createLinearGradient(0, 4, 0, 45);
            gradient.addColorStop(0, colors.primary(0.3));
            gradient.addColorStop(
                1,
                $("html").hasClass("dark") ? "#28344e00" : "#ffffff01"
            );
            new Chart(ctx, {
                type: "line",
                data: {
                    labels: data[key],
                    datasets: [
                        {
                            data: data[key],
                            borderWidth: 0.8,
                            borderColor: colors.primary(0.6),
                            pointRadius: 0,
                            backgroundColor: gradient,
                            tension: 0,
                            fill: true,
                        },
                    ],
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                display: false,
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                        },
                        y: {
                            ticks: {
                                display: false,
                            },
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                        },
                    },
                },
            });
        });
    }

    if ($("#report-pie-chart-1").length) {
        const ctx = $("#report-pie-chart-1")[0].getContext("2d");
        new Chart(ctx, {
            type: "pie",
            data: {
                labels: [
                    "17 - 30 Years old",
                    "31 - 50 Years old",
                    ">= 50 Years old",
                ],
                datasets: [
                    {
                        data: [15, 10, 65],
                        backgroundColor: [
                            colors.pending(0.5),
                            colors.warning(0.5),
                            colors.primary(0.5),
                        ],
                        hoverBackgroundColor: [
                            colors.pending(0.5),
                            colors.warning(0.5),
                            colors.primary(0.5),
                        ],
                        borderWidth: 1,
                        borderColor: [
                            colors.pending(0.75),
                            colors.warning(0.9),
                            colors.primary(0.5),
                        ],
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });
    }

    // Chart widget page
    if ($("#vertical-bar-chart-widget").length) {
        let ctx = $("#vertical-bar-chart-widget")[0].getContext("2d");
        let myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                ],
                datasets: [
                    {
                        label: "Html Template",
                        barPercentage: 0.4,
                        borderWidth: 1,
                        data: [0, 200, 250, 200, 500, 450, 850, 1050],
                        borderColor: colors.primary(0.7),
                        backgroundColor: colors.primary(0.2),
                    },
                    {
                        label: "VueJs Template",
                        barPercentage: 0.4,
                        borderWidth: 1,
                        data: [0, 300, 400, 560, 320, 600, 720, 850],
                        borderColor: $("html").hasClass("dark")
                            ? colors.darkmode["200"]()
                            : colors.slate["400"](),
                        backgroundColor: $("html").hasClass("dark")
                            ? colors.darkmode["200"](0.1)
                            : colors.slate["400"](0.1),
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: colors.slate["500"](0.8),
                        },
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: colors.slate["500"](0.8),
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                    },
                    y: {
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: colors.slate["500"](0.8),
                            callback: function (value, index, values) {
                                return "$" + value;
                            },
                        },
                        grid: {
                            color: $("html").hasClass("dark")
                                ? colors.slate["500"](0.3)
                                : colors.slate["400"](),
                            borderDash: [2, 2],
                            drawBorder: false,
                        },
                    },
                },
            },
        });
    }

    if ($("#horizontal-bar-chart-widget").length) {
        let ctx = $("#horizontal-bar-chart-widget")[0].getContext("2d");
        let myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                ],
                datasets: [
                    {
                        label: "Html Template",
                        barPercentage: 0.4,
                        borderWidth: 1,
                        data: [0, 200, 250, 200, 500, 450, 850, 1050],
                        borderColor: colors.primary(0.7),
                        backgroundColor: colors.primary(0.2),
                    },
                    {
                        label: "VueJs Template",
                        barPercentage: 0.4,
                        borderWidth: 1,
                        data: [0, 300, 400, 560, 320, 600, 720, 850],
                        borderColor: $("html").hasClass("dark")
                            ? colors.darkmode["200"]()
                            : colors.slate["400"](),
                        backgroundColor: $("html").hasClass("dark")
                            ? colors.darkmode["200"](0.1)
                            : colors.slate["400"](0.1),
                    },
                ],
            },
            options: {
                indexAxis: "y",
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: colors.slate["500"](0.8),
                        },
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: colors.slate["500"](0.8),
                            callback: function (value, index, values) {
                                return "$" + value;
                            },
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                    },
                    y: {
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: colors.slate["500"](0.8),
                        },
                        grid: {
                            color: $("html").hasClass("dark")
                                ? colors.slate["500"](0.3)
                                : colors.slate["400"](),
                            borderDash: [2, 2],
                            drawBorder: false,
                        },
                    },
                },
            },
        });
    }

    if ($("#stacked-bar-chart-widget").length) {
        let ctx = $("#stacked-bar-chart-widget")[0].getContext("2d");
        let myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [
                    {
                        label: "Html Template",
                        barPercentage: 0.4,
                        borderWidth: 1,
                        borderColor: colors.primary(0.7),
                        backgroundColor: colors.primary(0.2),
                        data: helper.randomNumbers(-100, 100, 12),
                    },
                    {
                        label: "VueJs Template",
                        barPercentage: 0.4,
                        borderWidth: 1,
                        borderColor: $("html").hasClass("dark")
                            ? colors.darkmode["200"]()
                            : colors.slate["400"](),
                        backgroundColor: $("html").hasClass("dark")
                            ? colors.darkmode["200"](0.1)
                            : colors.slate["400"](0.1),
                        data: helper.randomNumbers(-100, 100, 12),
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: colors.slate["500"](0.8),
                        },
                    },
                },
                scales: {
                    x: {
                        stacked: true,
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: colors.slate["500"](0.8),
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                    },
                    y: {
                        stacked: true,
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: colors.slate["500"](0.8),
                            callback: function (value, index, values) {
                                return "$" + value;
                            },
                        },
                        grid: {
                            color: $("html").hasClass("dark")
                                ? colors.slate["500"](0.3)
                                : colors.slate["400"](),
                            borderDash: [2, 2],
                            drawBorder: false,
                        },
                    },
                },
            },
        });
    }

    if ($("#line-chart-widget").length) {
        let ctx = $("#line-chart-widget")[0].getContext("2d");
        let myChart = new Chart(ctx, {
            type: "line",
            data: {
                labels: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec",
                ],
                datasets: [
                    {
                        label: "Html Template",
                        data: [
                            0, 200, 250, 200, 500, 450, 850, 1050, 950, 1100,
                            900, 1200,
                        ],
                        borderWidth: 2,
                        borderColor: colors.primary(0.7),
                        backgroundColor: "transparent",
                        pointBorderColor: "transparent",
                        tension: 0.4,
                    },
                    {
                        label: "VueJs Template",
                        data: [
                            0, 300, 400, 560, 320, 600, 720, 850, 690, 805,
                            1200, 1010,
                        ],
                        borderWidth: 2,
                        borderDash: [2, 2],
                        borderColor: $("html").hasClass("dark")
                            ? colors.darkmode["200"]()
                            : colors.slate["400"](),
                        backgroundColor: "transparent",
                        pointBorderColor: "transparent",
                        tension: 0.4,
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: colors.slate["500"](0.8),
                        },
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: colors.slate["500"](0.8),
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                    },
                    y: {
                        ticks: {
                            font: {
                                size: 12,
                            },
                            color: colors.slate["500"](0.8),
                            callback: function (value, index, values) {
                                return "$" + value;
                            },
                        },
                        grid: {
                            color: $("html").hasClass("dark")
                                ? colors.slate["500"](0.3)
                                : colors.slate["300"](),
                            borderDash: [2, 2],
                            drawBorder: false,
                        },
                    },
                },
            },
        });
    }

    if ($("#donut-chart-widget").length) {
        let ctx = $("#donut-chart-widget")[0].getContext("2d");
        let myDoughnutChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: ["Html", "Vuejs", "Laravel"],
                datasets: [
                    {
                        data: [15, 10, 65],
                        backgroundColor: [
                            colors.pending(0.6),
                            colors.warning(0.6),
                            colors.primary(0.6),
                        ],
                        hoverBackgroundColor: [
                            colors.pending(0.6),
                            colors.warning(0.6),
                            colors.primary(0.6),
                        ],
                        borderWidth: 1,
                        borderColor: [
                            colors.pending(0.75),
                            colors.warning(0.9),
                            colors.primary(0.5),
                        ],
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: colors.slate["500"](0.8),
                        },
                    },
                },
                cutout: "80%",
            },
        });
    }

    if ($("#pie-chart-widget").length) {
        let ctx = $("#pie-chart-widget")[0].getContext("2d");
        let myPieChart = new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Html", "Vuejs", "Laravel"],
                datasets: [
                    {
                        data: [15, 10, 65],
                        backgroundColor: [
                            colors.pending(0.6),
                            colors.warning(0.6),
                            colors.primary(0.6),
                        ],
                        hoverBackgroundColor: [
                            colors.pending(0.6),
                            colors.warning(0.6),
                            colors.primary(0.6),
                        ],
                        borderWidth: 1,
                        borderColor: [
                            colors.pending(0.75),
                            colors.warning(0.9),
                            colors.primary(0.5),
                        ],
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: colors.slate["500"](0.8),
                        },
                    },
                },
            },
        });
    }
})();
