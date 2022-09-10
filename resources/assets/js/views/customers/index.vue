<template>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Customers</span>
            <div>
                <!-- <button class="btn btn-primary" @click="search">
                    Search
                </button> -->
                <!-- <input type="search" placeholder="Search" aria-label="Search" v-model="firstname"> -->
                <router-link to="/customers/create" class="btn btn-primary">
                    New Customer
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
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in model.data" :key="item.data" @click="detailsPage(item)">
                        <td class="w-1">{{item.id}}</td>
                        <td class="w-3">{{item.firstname}}</td>
                        <td class="w-3">{{item.lastname}}</td>
                        <td class="w-9">{{item.email}}</td>
                        <td class="w-3">{{item.address}}</td>
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
import { get } from '../../lib/api'
// import { byMethod, get } from '../../lib/api'
export default {
    data() {
        return {
            // param: "",
            // firstname: "",
            model: {
                data: []
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        get('/api/customers', to.query)
            .then((res) => {
                next(vm => vm.setData(res))
            })
    },
    beforeRouteUpdate(to, from, next) {
        get('/api/customers', to.query)
            .then((res) => {
                this.setData(res)
                next()
            })
    },
    methods: {
        search() {
            this.param = "?="
            if (this.firstname) {
                this.param = this.param + "&firstname=" + this.firstname;
            }
            byMethod('GET', `api/customers/${this.param}`)
        },
        detailsPage(item) {
            this.$router.push(`/customers/${item.id}`)
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
                    path: '/customers',
                    query: query
                })
            }
        },
        prevPage() {
            if (this.model.prev_page_url) {
                const query = Object.assign({}, this.$route.query)
                query.page = query.page ? (Number(query.page) - 1) : 1

                this.$router.push({
                    path: '/customers',
                    query: query
                })
            }
        }
    }
}
</script>
