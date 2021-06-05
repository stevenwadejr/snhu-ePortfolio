<template>
    <canvas id="customer-marital-status"></canvas>
</template>

<script>
import { Chart } from "chart.js";

export default {
    name: "CustomerMaritalStatus",
    props: {
        customerMaritalStatus: {
            type: Object,
            required: true,
        },
    },
    mounted() {
        new Chart(
            document.getElementById("customer-marital-status").getContext("2d"),
            {
                type: "bar",
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            title: {
                                display: true,
                                text: "Customers",
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
                            text: "Marital Status",
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
                                    // Don't show a tooltip title
                                    return "";
                                },
                            },
                        },
                    },
                },
                data: {
                    labels: Object.keys(this.customerMaritalStatus),
                    datasets: [
                        {
                            label: "Marital Status",
                            data: Object.values(this.customerMaritalStatus),
                            backgroundColor: [
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
