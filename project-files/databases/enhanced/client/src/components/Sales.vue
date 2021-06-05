<template>
    <div class="row">
        <div class="col-6 mb-5">
            <total-sales-by-source
                v-if="Object.keys(totalSalesBySource).length"
                :totalSalesBySource="totalSalesBySource"
            ></total-sales-by-source>
        </div>
        <div class="col-6 mb-5">
            <average-sales-by-source
                v-if="Object.keys(averageSalesBySource).length"
                :averageSalesBySource="averageSalesBySource"
            ></average-sales-by-source>
        </div>
        <div class="col-6 mb-5">
            <average-spend-per-source-by-marital-status
                v-if="Object.keys(averageSpendPerSourceByMaritalStatus).length"
                :averageSpendPerSourceByMaritalStatus="
                    averageSpendPerSourceByMaritalStatus
                "
            ></average-spend-per-source-by-marital-status>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import TotalSalesBySource from "./TotalSalesBySource";
import AverageSalesBySource from "./AverageSalesBySource";
import AverageSpendPerSourceByMaritalStatus from "./AverageSpendPerSourceByMaritalStatus";

export default {
    name: "Sales",
    components: {
        "total-sales-by-source": TotalSalesBySource,
        "average-sales-by-source": AverageSalesBySource,
        "average-spend-per-source-by-marital-status": AverageSpendPerSourceByMaritalStatus,
    },
    data() {
        return {
            totalSalesBySource: {},
            averageSalesBySource: {},
            averageSpendPerSourceByMaritalStatus: {},
            loading: false,
        };
    },
    async mounted() {
        this.loading = true;

        // Fetch the data for this page
        const response = await axios.get("/sales");

        this.loading = false;

        // Update the model values with the data from the response
        if (response && response.data) {
            const res = response.data;
            this.totalSalesBySource = res.data.totalSalesBySource;
            this.averageSalesBySource = res.data.averageSalesBySource;
            this.averageSpendPerSourceByMaritalStatus =
                res.data.averageSpendPerSourceByMaritalStatus;
        }
    },
};
</script>
