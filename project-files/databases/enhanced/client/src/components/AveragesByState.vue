<template>
    <canvas id="restaurant-averages-by-state"></canvas>
</template>

<script>
import { Chart } from "chart.js";
import { abbrStateMap } from "../util";

export default {
    name: "AveragesByState",
    props: {
        averageRestaurantSpend: {
            type: Array,
            required: true,
        },
    },
    mounted() {
        new Chart(
            document
                .getElementById("restaurant-averages-by-state")
                .getContext("2d"),
            {
                type: "bar",
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: "$ Average",
                            },
                        },
                        x: {
                            title: {
                                display: true,
                                text: "State",
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
                            text: "Average Restaurant Spend by State",
                        },
                        tooltip: {
                            callbacks: {
                                label(tooltipItem) {
                                    // Format the dollar value
                                    return " $" + tooltipItem.formattedValue;
                                },
                                title(items) {
                                    // Show the state's name as the tooltip title
                                    return abbrStateMap[items[0].label];
                                },
                            },
                        },
                    },
                },
                data: {
                    labels: this.averageRestaurantSpend.map(
                        (item) => item.state
                    ),
                    datasets: [
                        {
                            label: "Average Restaurant Spend by State",
                            data: this.averageRestaurantSpend.map(
                                (item) => item.avg
                            ),
                            backgroundColor: ["rgba(54, 162, 235, 0.8)"],
                        },
                    ],
                },
            }
        );
    },
};
</script>
