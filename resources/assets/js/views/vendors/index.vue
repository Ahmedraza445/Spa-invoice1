<template>
    <div class="panel">
        <div class="panel-heading">
            <span class="panel-title">Vendors</span>
            <div>
                <router-link to="/vendors/create" class="btn btn-primary">
                    New Vendor
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
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Store</th>
                        <th>Email</th>
                        <th>Active</th>

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in model.data" :key="item.data">
                        <td class="w-2">{{item.id}}</td>
                        <td class="w-3">{{item.name}}</td>
                        <td class="w-3">{{item.phone}}</td>
                        <td class="w-3">{{item.store}}</td>
                        <td class="w-4">{{item.email}}</td>
                        <!-- if (item.active == 1) { -->
                        <!-- <td class="w-3">{{item.active == 1}}<button class="btn btn-primary">Active</button> -->
                        <!-- {{item.active == 0}}<button class="btn b6n-primary">Non-Active</button></td> -->
                        <!-- <td class="w-3">{{item.active == 0}}
                            <button class="btn btn-primary">Non-Active</button>
                        </td> -->
                        <!-- } -->
                        <td>
                            <button v-if="item.active ==1" class="btn btn-primary"
                                @click="onActive(item,0)">Active</button>
                            <button v-else class="btn btn-primary" @click="onActive(item,1)">InActive</button>
                        </td>
                        <!-- </td> -->
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
export default {
    data() {
        return {
            isProcessing: false,
            errors: {},
            model: {
                data: [],
                checkedNames: []
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        get('/api/vendors', to.query)
            .then((res) => {
                next(vm => vm.setData(res))
            })
    },
    beforeRouteUpdate(to, from, next) {
        get('/api/vendors', to.query)
            .then((res) => {
                this.setData(res)
                next()
            })
    },
    methods: {
        detailsPage(item) {
            this.$router.push(`/vendors/${item.id}`)
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
                    path: '/vendors',
                    query: query
                })
            }
        },
        prevPage() {
            if (this.model.prev_page_url) {
                const query = Object.assign({}, this.$route.query)
                query.page = query.page ? (Number(query.page) - 1) : 1

                this.$router.push({
                    path: '/vendors',
                    query: query
                })
            }
        },
        onActive(e, active) {
            e.active = active;
            byMethod('PUT', `api/vendors/${e.id}?methods=PUT`, e)
        },

    }
}
</script>
