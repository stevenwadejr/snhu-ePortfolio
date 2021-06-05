<template>
    <div class="row">
        <div class="col-6">
            <customer-income :customerIncome="customerIncome"></customer-income>
        </div>
        <div class="col-6">
            <customer-age :customersByAge="customersByAge"></customer-age>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import CustomerIncome from "./CustomerIncome";
import CustomerAge from "./CustomerAge";

export default {
    name: "Customers",
    components: {
        "customer-income": CustomerIncome,
        "customer-age": CustomerAge,
    },
    data() {
        return {
            customersByAge: [],
            customerIncome: [],
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
        }
    },
};
</script>
