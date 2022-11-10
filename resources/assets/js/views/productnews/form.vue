<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <span class="panel-title">Add Product</span>
        </div>
        <div class="panel-body">

            <table class="form-table">
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
                        <td class="w-5">
                            <input type="text" class="form-control" v-model="form.product_desc">
                        </td>
                        <td class="w-5">
                            <input type="text" class="form-control" v-model="form.vendor">
                        </td>
                        <td class="w-5">
                            <input type="text" class="form-control" v-model="form.quantity">
                        </td>
                        <td class="w-5">
                            <input type="text" class="form-control" v-model="form.price">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="panel-footer flex-end">
            <div>
                <button class="btn btn-primary" :disabled="isProcessing" @click="onSave">Save</button>
                <button class="btn" :disabled="isProcessing" @click="onCancel">Cancel</button>
            </div>
        </div>
    </div>
</template>
    

<script type="text/javascript">
import Vue from 'vue'
import { get, byMethod } from '../../lib/api'
import { Typeahead } from '../../components/typeahead'

function initialize(to) {
    let urls = {
        'create': `/api/product_new/create`,
        'edit': `/api/product_new/${to.params.id}/edit`
    }

    return (urls[to.meta.mode] || urls['create'])
}
export default {
    components: { Typeahead },
    data() {
        return {
            form: {},
            errors: {},
            isProcessing: false,
            show: false,
            resource: '/product_new',
            store: '/api/product_new',
            method: 'POST',
            title: 'Create',
            productURL: '/api/product_new',
            // vendorURL: '/api/search/vendors',
            //customerURL: '/api/customers'
        }
    },
    beforeRouteEnter(to, from, next) {
        get(initialize(to))
            .then((res) => {
                next(vm => vm.setData(res))
            })
    },
    beforeRouteUpdate(to, from, next) {
        this.show = false
        get(initialize(to))
            .then((res) => {
                this.setData(res)
                next()
            })
    },
    methods: {
        setData(res) {
            // console.log(res.data)
            Vue.set(this.$data, 'form', res.data.form)

            if (this.$route.meta.mode === 'edit') {
                this.store = `/api/product_new/${this.$route.params.id}`
                this.method = 'PUT'
                this.title = 'Edit'
            }

            this.show = true
            this.$bar.finish()
            // console.log(res.data)
        },
        addNewLine() {
            this.form.product_new.push({
                product_desc: null,
                vendor: null,
                quantity: null,
                price: 0,
            })
        },
        removeItem(index) {
            this.form.splice(index, 1)
        },
        // onVendor(e) {
        //     const vendor = e.target.value
        //     Vue.set(this.$data.form, 'vendor', vendor)
        //     Vue.set(this.$data.form, 'vendor_id', vendor.id)
        // },
        onCancel() {
            if (this.$route.meta.mode === 'edit') {
                this.$router.push(`${this.resource}`)
            } else {
                this.$router.push(`${this.resource}`)
            }
        },
        onSave() {
            this.errors = {}
            this.isProcessing = true
            byMethod(this.method, this.store, this.form)

                .then((res) => {
                    if (res.data && res.data.saved) {
                        // this.$router.push(`${this.resource}/${res.data.id}`)
                        this.$router.push(`${this.resource}`)
                        // this.success(res)
                    }
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                    this.isProcessing = false
                })
        },
        success(res) {
            this.$router.push(`${this.resource}/${res.data.id}`)
        }
    }
}
</script>