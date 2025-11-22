(function () {
    "use strict";

    if ($(".material-requests-line-chart").length && typeof Chart !== "undefined") {
        $(".material-requests-line-chart").each(function () {
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

            const data = [
                pending,
                inProgress,
                approved,
                rejected,
                completed,
            ];

            const chart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: "Material requests",
                            data: data,
                            borderWidth: 2,
                            borderColor: getColor("slate.900"),
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
                                color: getColor("slate.500", 0.8),
                            },
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
                                    size: 12,
                                },
                                color: getColor("slate.500", 0.8),
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
                                font: {
                                    size: 12,
                                },
                                color: getColor("slate.500", 0.8),
                            },
                            grid: {
                                color: function () {
                                    return $("html").hasClass("dark")
                                        ? getColor("slate.500", 0.3)
                                        : getColor("slate.300");
                                },
                            },
                            border: {
                                dash: [2, 2],
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
