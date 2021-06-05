import Vue from "vue";
import Router from "vue-router";
import SurveyDataTable from "./components/SurveyDataTable.vue";
import Geography from "./components/Geography.vue";
import Customers from "./components/Customers.vue";
import Sales from "./components/Sales.vue";

Vue.use(Router);

// Declare the frontend routes
export default new Router({
    mode: "history",
    base: process.env.BASE_URL,
    routes: [
        {
            path: "/",
            name: "survey-data",
            component: SurveyDataTable,
        },
        {
            path: "/geography",
            name: "geography",
            component: Geography,
        },
        {
            path: "/customers",
            name: "customers",
            component: Customers,
        },
        {
            path: "/sales",
            name: "sales",
            component: Sales,
        },
    ],
});
