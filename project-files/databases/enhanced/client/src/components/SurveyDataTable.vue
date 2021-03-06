<template>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Age</th>
                <th scope="col">Married</th>
                <th scope="col">Income</th>
                <th scope="col">Location</th>
                <th scope="col">Restaurant Visits</th>
                <th scope="col">Web Visits</th>
                <th scope="col">3rd-Party Visits</th>
                <th scope="col">Restaurant Spend</th>
                <th scope="col">Web Spend</th>
                <th scope="col">3rd-Party Spend</th>
            </tr>
        </thead>
        <tbody v-if="loading">
            <tr>
                <td colspan="11">
                    <div class="text-center m-5">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
        <tbody v-if="!loading">
            <table-row
                v-for="item in currentPage"
                :key="item._id"
                :row="item"
            ></table-row>
        </tbody>
        <tfoot v-if="totalPages > 1">
            <tr>
                <td colspan="11">
                    <button
                        type="button"
                        class="btn btn-dark me-2"
                        :disabled="page == 1"
                        v-on:click="page -= 1"
                    >
                        <i class="bi bi-caret-left-fill"></i> Previous
                    </button>
                    <button
                        type="button"
                        class="btn btn-dark"
                        :disabled="page == totalPages"
                        v-on:click="page += 1"
                    >
                        Next <i class="bi bi-caret-right-fill"></i>
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
import axios from "axios";
import TableRow from "./TableRow";

export default {
    name: "SurveyDataTable",
    components: {
        "table-row": TableRow,
    },
    data() {
        return {
            page: 1,
            total: 0,
            totalPages: 1,
            pageSize: 0,
            cache: {},
            loading: false,
        };
    },
    async mounted() {
        // Perform the initial fetch
        await this.fetchData();
    },
    computed: {
        currentPage() {
            // Fetch the cached page
            return this.cache[this.getCurrentCacheKey()] || [];
        },
    },
    watch: {
        page() {
            // When the page changes, only fetch new data for that page if it isn't already cached
            if (this.cache.hasOwnProperty(this.getCurrentCacheKey())) {
                return;
            }
            this.fetchData();
        },
    },
    methods: {
        updatePage(value) {
            let newPage = this.page + value;

            // Prevent going to a zero or negative page
            if (newPage < 1) {
                newPage = 1;
            }

            this.page = newPage;
        },
        async fetchData() {
            this.loading = true;

            // Fetch the data for this page
            const response = await axios.get(
                `?page=${this.page}&limit=${this.pageSize}`
            );

            this.loading = false;

            // Update the model values with the data from the response
            if (response && response.data) {
                const res = response.data;
                this.page = res.metadata.page;
                this.total = res.metadata.total;
                this.totalPages = res.metadata.totalPages;
                this.pageSize = res.metadata.pageSize;

                // Cache the response and return the cached value
                this.saveCache(res.data);
                return this.cache[this.getCurrentCacheKey()];
            }

            return [];
        },
        getCurrentCacheKey() {
            // Create a cache key made up of the total number of pages,
            // the current page, and the size of each page.
            return [this.totalPages, this.page, this.pageSize].join(".");
        },
        saveCache(results) {
            // Cache the given results
            this.cache[this.getCurrentCacheKey()] = results;
        },
    },
};
</script>
