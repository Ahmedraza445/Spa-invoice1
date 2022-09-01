<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <div>
                <router-link to="/customers" class="btn">Back</router-link>
                <router-link :to="`/customers/${model.id}/edit`" class="btn">Edit</router-link>
                <button class="btn btn-error" @click ="deleteItem">Delete</button>
            </div>
        </div>
        <div class="panel-body">
            <div class="document">
                <div class="document-body">
                    <table lcass="table document-table">
                        <thead>
                            <tr>
                                <td>First Name</td>
                                <td>Last Name</td>
                                <td>Email</td>
                                <td>Address</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="w-3">{{model.firstname}}</td>
                                <td class="w-3">{{model.lastname}}</td>
                                <td class="w-3">{{model.email}}</td>
                                <td class="w-3">{{model.address}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import Vue from 'vue'
    import {get, byMethod} from '../../lib/api'
    
    export default {
        data () {
            return {
                show: false,
                model: {
                    // items: [],
                    // customer: {} 
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/customers/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/customers/${to.params.id}`)
                .then((res) => {
                    this.setData(res)
                    next()
                })
        },
        methods: {
            setData(res) {
                Vue.set(this.$data, 'model', res.data.model)

                this.show = true
                this.$bar.finish()
            },
            deleteItem() {
                byMethod('delete', `/api/customers/${this.model.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/customers')
                        }
                    })
            }
        }
    }
</script>
