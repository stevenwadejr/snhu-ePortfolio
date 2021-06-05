<template>
    <div class="row">
        <div class="col-2 position-fixed">
            <button
                type="button"
                class="btn btn-outline-dark d-block mb-3 w-100"
                @click="goto('sales-by-state')"
                v-bind:class="[
                    activeButton == 'sales-by-state' ? 'active' : '',
                ]"
            >
                Sales by State
            </button>
            <button
                type="button"
                class="btn btn-outline-dark d-block mb-3 w-100"
                @click="goto('averages-by-state')"
                v-bind:class="[
                    activeButton == 'averages-by-state' ? 'active' : '',
                ]"
            >
                Averages by State
            </button>
        </div>
        <div class="col-10 offset-2">
            <div class="d-grid gap-5">
                <div ref="sales-by-state" data-top="true">
                    <sales-by-state
                        v-if="Object.keys(salesByState).length"
                        :salesByState="salesByState"
                    ></sales-by-state>
                </div>
                <div ref="averages-by-state">
                    <averages-by-state
                        v-if="averageRestaurantSpend.length"
                        :averageRestaurantSpend="averageRestaurantSpend"
                    ></averages-by-state>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import SalesByState from "./SalesByState";
import AveragesByState from "./AveragesByState";

export default {
    name: "Geography",
    components: {
        "sales-by-state": SalesByState,
        "averages-by-state": AveragesByState,
    },
    data() {
        return {
            salesByState: {},
            averageRestaurantSpend: [],
            loading: false,
            offsetTop: 0,
            activeButton: "sales-by-state",
        };
    },
    async mounted() {
        // Set the initial top offset accounting for the height of the header
        this.offsetTop = Object.values(this.$refs)[0].offsetTop;
        this.loading = true;

        // Fetch the data for this page
        const response = await axios.get("/geography");

        this.loading = false;

        // Update the model values with the data from the response
        if (response && response.data) {
            const res = response.data;
            this.salesByState = res.data.salesByState;
            this.averageRestaurantSpend = res.data.averageRestaurantSpend;
        }
    },
    methods: {
        // Scrolls to the given chart
        // Retrieved from https://shouts.dev/vuejs-scroll-to-elements-on-the-page
        goto(refName) {
            this.activeButton = refName;
            window.scrollTo(0, this.$refs[refName].offsetTop - this.offsetTop);
        },
    },
};
</script>
