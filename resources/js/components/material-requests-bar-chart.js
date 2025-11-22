(function () {
    "use strict";

    if ($(".material-requests-bar-chart").length && typeof Chart !== "undefined") {
        $(".material-requests-bar-chart").each(function () {
            const el = $(this)[0];
            const ctx = el.getContext("2d");

            const pending = parseInt(el.dataset.pending || "0", 10);
            const inProgress = parseInt(el.dataset.inProgress || "0", 10);
            const approved = parseInt(el.dataset.approved || "0", 10);
            const rejected = parseInt(el.dataset.rejected || "0", 10);
            const completed = parseInt(el.dataset.completed || "0", 10);

            const labels = [
                "Pending",
                "In progress",
                "Approved",
                "Rejected",
                "Completed",
            ];

            const data = [pending, inProgress, approved, rejected, completed];

            const chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Material requests",
                            data: data,
                            barPercentage: 0.6,
                            borderRadius: 6,
                            backgroundColor: [
                                getColor("warning"), // pending
                                getColor("primary"), // in progress
                                getColor("success"), // approved
                                getColor("danger"),  // rejected
                                getColor("slate.500"), // completed
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
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    const label = context.label || "";
                                    const value = context.parsed.y ?? context.parsed;
                                    return label + ": " + value;
                                },
                            },
                        },
                    },
                    scales: {
                        x: {
                            ticks: {
                                font: {
                                    size: 11,
                                },
                                color: getColor("slate.100", 0.9),
                            },
                            grid: {
                                display: false,
                            },
                            border: {
                                display: false,
                            },
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: {
                                    size: 10,
                                },
                                color: getColor("slate.200", 0.9),
                            },
                            grid: {
                                color: getColor("slate.700", 0.4),
                                borderDash: [2, 2],
                            },
                            border: {
                                display: false,
                            },
                        },
                    },
                },
            });

            helper.watchClassNameChanges($("html")[0], () => {
                chart.update();
            });
        });
    }
})();
