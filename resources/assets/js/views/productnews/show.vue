<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <div>
                <router-link to="/product_new" class="btn">Back</router-link>
                <router-link :to="`/product_new/${model.id}/edit`" class="btn">Edit</router-link>
                <button class="btn btn-error" @click ="deleteItem">Delete</button>
            </div>
        </div>
        <div class="panel-body">
            <div class="document">
                <div class="row">
                    <div class="col-2">
                        <table class="document-summary">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="document-title">Product</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="document-body">
                    <table class="table document-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Vendor</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="w-3">{{model.product_desc}}</td>
                                <td class="w-3">{{model.vendor}}</td>
                                <td class="w-3">{{model.quantity}}</td>
                                <td class="w-3">{{model.price}}</td>
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
                }
            }
        },
        beforeRouteEnter(to, from, next) {
            get(`/api/product_new/${to.params.id}`)
                .then((res) => {
                    next(vm => vm.setData(res))
                })
        },
        beforeRouteUpdate(to, from, next) {
            this.show = false
            get(`/api/product_new/${to.params.id}`)
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
                byMethod('delete', `/api/product_new/${this.model.id}`)
                    .then((res) => {
                        if(res.data.deleted) {
                            this.$router.push('/product_new')
                        }
                    })
            }
        }
    }
</script>

