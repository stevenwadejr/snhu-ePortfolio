<template>
    <canvas id="total-sales-by-source"></canvas>
</template>

<script>
import { Chart } from "chart.js";

const keyMap = {
    restaurant: "Restaurant",
    web: "Web",
    third_party: "Third-Party",
};

export default {
    name: "TotalSalesBySource",
    props: {
        totalSalesBySource: {
            type: Object,
            required: true,
        },
    },
    mounted() {
        new Chart(
            document.getElementById("total-sales-by-source").getContext("2d"),
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
                            display: false,
                            position: "top",
                        },
                        title: {
                            display: true,
                            text: "Total Sales by Source",
                        },
                        tooltip: {
                            callbacks: {
                                label(tooltipItem) {
                                    return " $" + tooltipItem.formattedValue;
                                },
                                title() {
                                    return "";
                                },
                            },
                        },
                    },
                },
                data: {
                    labels: Object.keys(this.totalSalesBySource).map(
                        (key) => keyMap[key]
                    ),
                    datasets: [
                        {
                            label: "Total Sales by Source",
                            data: Object.values(this.totalSalesBySource),
                            backgroundColor: [
                                "rgba(54, 162, 235, 0.8)",
                                "rgba(255, 99, 132, 0.8)",
                                "rgba(75, 192, 192, 0.8)",
                            ],
                        },
                    ],
                },
            }
        );
    },
};
</script>
