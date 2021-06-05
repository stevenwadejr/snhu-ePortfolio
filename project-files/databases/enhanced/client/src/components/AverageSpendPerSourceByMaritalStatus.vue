<template>
    <canvas id="average-spend-per-source-by-marital-status"></canvas>
</template>

<script>
import { Chart } from "chart.js";

const keyMap = {
    restaurant: "Restaurant",
    web: "Web",
    third_party: "Third-Party",
};

export default {
    name: "AverageSalesBySource",
    props: {
        averageSpendPerSourceByMaritalStatus: {
            type: Object,
            required: true,
        },
    },
    mounted() {
        // Build the data array used in each dataset
        const data = Object.keys(
            this.averageSpendPerSourceByMaritalStatus
        ).reduce((acc, maritalStatus) => {
            // Push an object containing the data to display and specifying the name of the
            // x-axis this data will be displayed along (ie: Married or Not Married).
            acc.push({
                ...this.averageSpendPerSourceByMaritalStatus[maritalStatus],
                x: maritalStatus,
            });
            return acc;
        }, []);

        // The multi-bar chart was figured out through the following documentation
        // and was tested with a fiddle:
        //   - Documentation: https://www.chartjs.org/docs/latest/general/data-structures.html#parsing
        //   - Fiddle: https://jsfiddle.net/914hu80b/1/
        new Chart(
            document
                .getElementById("average-spend-per-source-by-marital-status")
                .getContext("2d"),
            {
                type: "bar",
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            title: {
                                display: true,
                                text: "Sales ($)",
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: "Source",
                            },
                        },
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: "top",
                        },
                        title: {
                            display: true,
                            text: "Average Sales by Source",
                        },
                        tooltip: {
                            callbacks: {
                                label(tooltipItem) {
                                    return " $" + tooltipItem.formattedValue;
                                },
                                title(items) {
                                    return items[0].label;
                                },
                            },
                        },
                    },
                },
                data: {
                    labels: ["Married", "Not Married"],
                    datasets: [
                        {
                            label: "Restaurant",
                            data,
                            backgroundColor: "rgba(54, 162, 235, 0.8)",
                            parsing: {
                                yAxisKey: "restaurant",
                            },
                        },
                        {
                            label: "Web",
                            data,
                            backgroundColor: "rgba(255, 99, 132, 0.8)",
                            parsing: {
                                yAxisKey: "web",
                            },
                        },
                        {
                            label: "Third-Party",
                            data,
                            backgroundColor: "rgba(75, 192, 192, 0.8)",
                            parsing: {
                                yAxisKey: "third_party",
                            },
                        },
                    ],
                },
            }
        );
    },
};
</script>
