<template>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Products</span>
            <div>
                <typeahead :url="vendorURL" :initialize="form.vendor" @input="onVendor" />
                <small class="error-control" v-if="errors.vendor_id">
                    {{errors.vendor_id[0]}}
                </small>
                <button class="btn btn-primary" @click="search">
                    Search
                </button>
                <router-link to="/products/create" class="btn btn-primary">
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
                        <th>Vendor</th>
                        <th>Item Code</th>
                        <th>Description</th>
                        <th>Unit Price</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in model.data" :key="item.data" @click="detailsPage(item)">
                        <td class="w-1">{{item.id}}</td>
                        <td class="w-3">{{item.vendor ? item.vendor.text : ""}}</td>
                        <td class="w-1">{{item.item_code}}</td>
                        <td class="w-3">{{item.description}}</td>
                        <td class="w-3">{{item.unit_price}}</td>
                        <!-- <td class="w-9">{{item.qty}}</td> -->
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-footer flex-between">
            <div>
                <small>Showing {{model.from}} - {{model.to}} of {{model.total}}</small>
            </div>
            <div>
                <button class="btn btn-sm" :disabled="!model.prev_page_url" @click="prevPage">
                    Prev
                </button>
                <button class="btn btn-sm" :disabled="!model.prev_page_url" @click="nextPage">
                    Next
                </button>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
import Vue from 'vue'
import { byMethod, get } from '../../lib/api'
import { Typeahead } from '../../components/typeahead'

function initialize(to) {
    let urls = {
        'index': `/api/products`,
        // 'edit': `/api/invoices/${to.params.id}/edit`
    }

    return (urls[to.meta.mode] || urls['index'])
}
export default {
    components: { Typeahead },
    data() {
        return {
            form: {},
            errors: {},
            param: "",
            vendor: "",
            vendorURL: '/api/search/vendors',
            model: {
                data: []
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        get('/api/products', to.query)
            .then((res) => {
                next(vm => vm.setData(res))
            })
    },
    beforeRouteUpdate(to, from, next) {
        get('/api/products', to.query)
            .then((res) => {
                this.setData(res)
                next()
            })
    },
    methods: {
        search() {
            this.param = "?="
            if (this.form.vendor_id) {
                this.param = this.param + "&vendor=" + this.form.vendor_id;
            }
            byMethod('GET', `api/products/${this.param}`).then((res) => {
                this.setData(res)
            })
        },
        onVendor(e) {
            const vendor = e.target.value
            Vue.set(this.$data.form, 'vendor', vendor)
            Vue.set(this.$data.form, 'vendor_id', vendor.id)
        },
        detailsPage(item) {
            this.$router.push(`/products/${item.id}`)
        },
        setData(res) {
            //console.log(res)
            Vue.set(this.$data, 'model', res.data.results)
            this.page = this.model.current_page
            this.$bar.finish()
        },
        nextPage() {
            if (this.model.next_page_url) {
                const query = Object.assign({}, this.$route.query)
                query.page = query.page ? (Number(query.page) + 1) : 2
                this.$router.push({
                    path: '/products',
                    query: query
                })
            }
        },
        prevPage() {
            if (this.model.prev_page_url) {
                const query = Object.assign({}, this.$route.query)
                query.page = query.page ? (Number(query.page) - 1) : 1

                this.$router.push({
                    path: '/products',
                    query: query
                })
            }
        }
    }
}
</script>
