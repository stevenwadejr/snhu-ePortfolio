<template>
  <tr>
    <td>{{ name }}</td>
    <td>{{ row.age }}</td>
    <td>{{ row.married }}</td>
    <td>{{ income }}</td>
    <td>{{ address }}</td>
    <td>{{ row.restaurant }}</td>
    <td>{{ row.restaurant_visits }}</td>
    <td>{{ row.web_visits }}</td>
    <td>{{ row.third_party_visits }}</td>
    <td>{{ row.web_spend }}</td>
    <td>{{ row.third_party_spend }}</td>
  </tr>
</template>

<script>
export default {
  props: {
    row: {
      type: Object,
      required: true,
    },
  },
  computed: {
    name() {
      return [this.row.first_name, this.row.last_name].join(" ");
    },
    income() {
      var formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
        maximumFractionDigits: 0,
      });
      return this.row.income ? formatter.format(this.row.income * 1000) : "N/A";
    },
    address() {
      return [this.row.city, this.row.state].join(", ");
    },
  },
};
</script>
