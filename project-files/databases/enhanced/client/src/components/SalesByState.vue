<template>
    <div>
        <div v-if="loading">
            <div class="text-center m-5">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <canvas id="sales-by-state-map"></canvas>
    </div>
</template>

<script>
import axios from "axios";
// import { Chart } from "chart.js";
import { ChoroplethChart, topojson } from "chartjs-chart-geo";
import { stateAbbrMap } from "../util";

export default {
    name: "SalesByState",
    props: {
        salesByState: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            loading: false,
        };
    },
    async mounted() {
        this.loading = true;
        const response = await axios.get(
            "https://unpkg.com/us-atlas/states-10m.json"
        );

        this.loading = false;

        const us = response.data;

        const nation = topojson.feature(us, us.objects.nation).features[0];
        const states = topojson.feature(us, us.objects.states).features;

        // Map pulled from: https://codepen.io/sgratzl/pen/gOaBQep
        new ChoroplethChart(
            document.getElementById("sales-by-state-map").getContext("2d"),
            {
                type: "choropleth",
                data: {
                    labels: states.map((d) => d.properties.name),
                    datasets: [
                        {
                            label: "Total Sales by State",
                            outline: nation,
                            data: states.map((d) => {
                                const stateAbbr =
                                    stateAbbrMap[d.properties.name];
                                const stateSales =
                                    this.salesByState[stateAbbr] || 0;

                                return {
                                    feature: d,
                                    value: stateSales,
                                };
                            }),
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "top",
                        },
                    },
                    scales: {
                        xy: {
                            projection: "albersUsa",
                        },
                        color: {
                            quantize: 10,
                            legend: {
                                position: "bottom-right",
                                align: "bottom",
                            },
                        },
                    },
                },
            }
        );
    },
};
</script>
