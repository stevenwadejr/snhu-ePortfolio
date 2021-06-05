<template>
  <div class="d-grid gap-5">
    <div>
      <sales-by-state
        v-if="Object.keys(salesByState).length"
        :salesByState="salesByState"
      ></sales-by-state>
    </div>
    <div>
      <averages-by-state
        v-if="averageRestaurantSpend.length"
        :averageRestaurantSpend="averageRestaurantSpend"
      ></averages-by-state>
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
    };
  },
  async mounted() {
    this.loading = true;
    const response = await axios.get(`http://localhost:9000/api/geography`);

    this.loading = false;

    if (response && response.data) {
      const res = response.data;
      this.salesByState = res.data.salesByState;
      this.averageRestaurantSpend = res.data.averageRestaurantSpend;
    }
  },
};
</script>
