import Vue from "vue";
import Router from "vue-router";
import SurveyDataTable from "./components/SurveyDataTable.vue";
import Geography from "./components/Geography.vue";

Vue.use(Router);

export default new Router({
  mode: "history",
  base: process.env.BASE_URL,
  routes: [
    {
      path: "/",
      name: "survey-data",
      component: SurveyDataTable
    },
    {
      path: "/geography",
      name: "geography",
      component: Geography
    },
  ]
});
