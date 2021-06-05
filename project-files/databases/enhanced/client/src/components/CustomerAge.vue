<template>
    <canvas id="customer-age"></canvas>
</template>

<script>
import { Chart } from "chart.js";

export default {
    name: "CustomerAge",
    props: {
        customersByAge: {
            type: Array,
            required: true,
        },
    },
    data() {
        return {
            chart: null,
        };
    },
    watch: {
        customersByAge() {
            this.chart.update();
        },
    },
    mounted() {
        this.chart = new Chart(
            document.getElementById("customer-age").getContext("2d"),
            {
                type: "bar",
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                            position: "top",
                        },
                        title: {
                            display: true,
                            text: "Customer By Age",
                        },
                        tooltip: {
                            callbacks: {
                                label(tooltipItem) {
                                    return (
                                        " " +
                                        tooltipItem.formattedValue +
                                        " customers"
                                    );
                                },
                                title() {
                                    return "";
                                },
                            },
                        },
                    },
                },
                data: {
                    labels: this.customersByAge.map((item) => {
                        return `${item.lowerBound} - ${item.upperBound}`;
                    }),
                    datasets: [
                        {
                            label: "Customers By Age",
                            data: this.customersByAge.map((item) => {
                                return item.count;
                            }),
                            backgroundColor: ["rgba(54, 162, 235, 0.8)"],
                        },
                    ],
                },
            }
        );
    },
};
</script>
