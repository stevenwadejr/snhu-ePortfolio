<template>
    <canvas id="customer-income"></canvas>
</template>

<script>
import { Chart } from "chart.js";

export default {
    name: "CustomerIncome",
    props: {
        customerIncome: {
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
        customerIncome() {
            this.chart.update();
        },
    },
    mounted() {
        this.chart = new Chart(
            document.getElementById("customer-income").getContext("2d"),
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
                            text: "Customers Annual Income",
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
                    labels: this.customerIncome.map((item) => {
                        return `${item.lowerBound} - ${item.upperBound}`;
                    }),
                    datasets: [
                        {
                            label: "Customers Annual Income",
                            data: this.customerIncome.map((item) => {
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
