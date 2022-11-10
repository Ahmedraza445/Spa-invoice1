<template>
    <div class="panel">
        <div class="panel-heading">
            <!-- <span class="panel-title">Invoices</span> -->
            <span class="panel-title">Invoices</span>
            <div class="form-group">
                <!-- <typeahead :url="customerURL" :initialize="form.customer" @input="onCustomer" />
                <small class="error-control" v-if="errors.customer_id">
                    {{errors.customer_id[0]}}
                </small> -->
                <!-- <button class="btn btn-primary">
                    Customer
                </button>
                <button class="btn btn-primary">
                    Due date
                </button> -->
                <button class="btn btn-primary" @click="disableButton" id="Button">Due date</button>
                <button class="btn btn-primary" @click="disable" id="theButton">Customer</button>
                <button class="btn btn-primary" @click="refresh">Refresh</button>
                <!-- <button class="btn btn-primary" @click="disable" id="theButton">Enable Customer & Disable Due
                    date</button> -->
                <!-- <button class="btn btn-primary" @click="search">
                    Search
                </button> -->
                <!-- <input type="search" placeholder="Search" aria-label="Search" v-model="customer"> -->
                <router-link to="/invoices/create" class="btn btn-primary">
                    New Invoice
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
                        <th>Date</th>
                        <th>Number</th>
                        <th>Customer</th>
                        <th>Due Date</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in model.data" :key="item.data" @click="detailsPage(item)">
                        <td class="w-1">{{item.id}}</td>
                        <td class="w-3">{{item.date}}</td>
                        <td class="w-3">{{item.number}}</td>
                        <td class="w-3">{{item.customer ? item.customer.text : ""}}</td>
                        <td class="w-3">{{item.due_date}}</td>
                        <td class="w-3">{{item.total | formatMoney}}</td>
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
        'index': `/api/invoices`,
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
            customer: "",
            
            active: true,
            customerURL: '/api/search/customers',
            model: {
                data: []
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        get('/api/invoices', to.query)
            .then((res) => {
                next(vm => vm.setData(res))
            })
    },
    beforeRouteUpdate(to, from, next) {
        get('/api/invoices', to.query)
            .then((res) => {
                this.setData(res)
                next()
            })
    },
    methods: {
        // search() {
        //     this.param = "?="
        //     if (this.form.customer_id) {
        //         this.param = this.param + "&ahmed=" + this.form.customer_id;
        //     }
        //     // if (this.customer) {
        //     //     this.param = this.param + "&customer=" + this.customer;
        //     // }
        //     byMethod('GET', `api/invoices/${this.param}`).then((res) => {
        //         this.setData(res)
        //     })
        // },
        disableButton() {
            if (this.active == true) {
                // Select the element with id "theButton" and disable it
                document.getElementById("theButton").disabled = true;
                // document.getElementById("Button").disabled = false;
            }
        },
        disable() {
            if (this.active == true) {
                // Select the element with id "theButton" and disable it
                // document.getElementById("Button").disabled = true;
                document.getElementById("Button").disabled = true;
                // document.getElementById("theButton").disabled = false;
            }
        },
        refresh() {
            document.getElementById("Button").disabled = false;
            document.getElementById("theButton").disabled = false;
        },
        onCustomer(e) {
            const customer = e.target.value
            Vue.set(this.$data.form, 'customer', customer)
            Vue.set(this.$data.form, 'customer_id', customer.id)
        },
        detailsPage(item) {
            this.$router.push(`/invoices/${item.id}`)
        },
        setData(res) {
            // console.log(res);
            Vue.set(this.$data, 'model', res.data.results)
            this.page = this.model.current_page
            this.$bar.finish()
            // console.log(res.data.results.data[0].customer.text)
            // console.log(res.data.results.data)
        },
        nextPage() {
            if (this.model.next_page_url) {
                const query = Object.assign({}, this.$route.query)
                query.page = query.page ? (Number(query.page) + 1) : 2

                this.$router.push({
                    path: '/invoices',
                    query: query
                })
            }
        },
        prevPage() {
            if (this.model.prev_page_url) {
                const query = Object.assign({}, this.$route.query)
                query.page = query.page ? (Number(query.page) - 1) : 1

                this.$router.push({
                    path: '/invoices',
                    query: query
                })
            }
        }
    }
}
</script>