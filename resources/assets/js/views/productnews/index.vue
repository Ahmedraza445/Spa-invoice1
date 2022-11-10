<template>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Products</span>
            <div>
                <!-- <typeahead :url="vendorURL" :initialize="form.vendor" @input="onVendor" />
                <small class="error-control" v-if="errors.vendor_id">
                    {{errors.vendor_id[0]}}
                </small> -->
                <!-- <button class="btn btn-primary" @click="search">
                    Search
                </button> -->
                <router-link to="/product_new/create" class="btn btn-primary">
                    New Product
                </router-link>
                <router-link to="/dashboard" class="btn btn-primary">
                    back
                </router-link>
            </div>
        </div>
        <div class="panel-body">
            <table class="table table-link">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Vendor</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(item, index) in model"
                        :key="item.data"
                        @click="detailsPage(item)"
                    >
                        <td class="w-1">{{ index + 1 }}</td>
                        <td class="w-3">{{ item.product_desc }}</td>
                        <td class="w-1">{{ item.vendor }}</td>
                        <td class="w-3">{{ item.quantity }}</td>
                        <td class="w-3">{{ item.price }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-footer flex-between">
            <div>
                <small
                    >Showing {{ model.from }} - {{ model.to }} of
                    {{ model.total }}</small
                >
            </div>
            <div>
                <button
                    class="btn btn-sm"
                    :disabled="!model.prev_page_url"
                    @click="prevPage"
                >
                    Prev
                </button>
                <button
                    class="btn btn-sm"
                    :disabled="!model.prev_page_url"
                    @click="nextPage"
                >
                    Next
                </button>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
import Vue from "vue";
import { byMethod, get } from "../../lib/api";
import { Typeahead } from "../../components/typeahead";

function initialize(to) {
    let urls = {
        index: `/api/product_new`,
        // 'edit': `/api/invoices/${to.params.id}/edit`
    };

    return urls[to.meta.mode] || urls["index"];
}
export default {
    components: { Typeahead },
    data() {
        return {
            form: {},
            // errors: {},
            // param: "",
            model: {
                data: [],
            },
        };
    },
    beforeRouteEnter(to, from, next) {
        get("/api/product_new", to.query).then((res) => {
            next((vm) => vm.setData(res));
        });
    },
    beforeRouteUpdate(to, from, next) {
        get("/api/product_new", to.query).then((res) => {
            this.setData(res);
            next();
        });
    },
    methods: {
        // search() {
        //     this.param = "?="
        //     if (this.form.vendor_id) {
        //         this.param = this.param + "&vendor=" + this.form.vendor_id;
        //     }
        //     byMethod('GET', `api/products/${this.param}`).then((res) => {
        //         this.setData(res)
        //     })
        // },
        // onVendor(e) {
        //     const vendor = e.target.value
        //     Vue.set(this.$data.form, 'vendor', vendor)
        //     Vue.set(this.$data.form, 'vendor_id', vendor.id)
        // },
        detailsPage(item) {
            this.$router.push(`/product_new/${item.id}`);
        },
        setData(res) {
            // console.log(res.data.result)
            Vue.set(this.$data, "model", res.data.result);
            this.page = this.model.current_page;
            this.$bar.finish();
        },
        nextPage() {
            if (this.model.next_page_url) {
                const query = Object.assign({}, this.$route.query);
                query.page = query.page ? Number(query.page) + 1 : 2;
                this.$router.push({
                    path: "/product_new",
                    query: query,
                });
            }
        },
        prevPage() {
            if (this.model.prev_page_url) {
                const query = Object.assign({}, this.$route.query);
                query.page = query.page ? Number(query.page) - 1 : 1;

                this.$router.push({
                    path: "/product_new",
                    query: query,
                });
            }
        },
    },
};
</script>
