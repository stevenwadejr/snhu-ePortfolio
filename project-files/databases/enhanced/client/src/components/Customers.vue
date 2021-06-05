<template>
    <div class="row">
        <div class="col-6 mb-5">
            <customer-income
                v-if="customerIncome.length"
                :customerIncome="customerIncome"
            ></customer-income>
        </div>
        <div class="col-6 mb-5">
            <customer-age
                v-if="customersByAge.length"
                :customersByAge="customersByAge"
            ></customer-age>
        </div>
        <div class="col-6 mb-5">
            <customer-marital-status
                v-if="Object.keys(customerMaritalStatus).length"
                :customerMaritalStatus="customerMaritalStatus"
            ></customer-marital-status>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import CustomerIncome from "./CustomerIncome";
import CustomerAge from "./CustomerAge";
import CustomerMaritalStatus from "./CustomerMaritalStatus";

export default {
    name: "Customers",
    components: {
        "customer-income": CustomerIncome,
        "customer-age": CustomerAge,
        "customer-marital-status": CustomerMaritalStatus,
    },
    data() {
        return {
            customersByAge: [],
            customerIncome: [],
            customerMaritalStatus: {},
            loading: false,
        };
    },
    async mounted() {
        this.loading = true;
        const response = await axios.get(`http://localhost:9000/api/customers`);

        this.loading = false;

        if (response && response.data) {
            const res = response.data;
            this.customersByAge = res.data.customersByAge;
            this.customerIncome = res.data.customerIncome;
            this.customerMaritalStatus = res.data.customerMaritalStatus;
        }
    },
};
</script>
