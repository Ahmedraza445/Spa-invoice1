<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <span class="panel-title">Add Product</span>
        </div>
        <div class="panel-body">
            
            <table class="form-table">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Product</th>
                        <th>Unit Price</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="w-5">
                            <input type="text" class="form-control" v-model="form.item_code">
                        </td>

                        <td class="w-5">
                            <input type="text" class="form-control" v-model="form.description">
                        </td>

                        <td class="w-5">
                            <input type="text" class="form-control" v-model="form.unit_price">
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
import {get, byMethod} from '../../lib/api'
import {Typeahead} from '../../components/typeahead'

function initialize(to) {
    let urls = {
        'create': `/api/products/create`,
        'edit': `/api/products/${to.params.id}/edit`
    }

    return (urls[to.meta.mode] || urls['create'])
}
export default {
    components: {Typeahead},
    data () {
        return {
            form: {},
            errors: {},
            isProcessing: false,
            show: false,
            resource: '/products',
            store: '/api/products',
            method: 'POST',
            title: 'Create',
            productURL: '/api/products',
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
            Vue.set(this.$data, 'form', res.data.form)

            if(this.$route.meta.mode === 'edit') {
                this.store = `/api/products/${this.$route.params.id}`
                this.method = 'PUT'
                this.title = 'Edit'
            }

            this.show = true
            this.$bar.finish()
        },
        addNewLine() {
            this.form.products.push({
                item_code: null,
                description: null,
                unit_price: 0,
            })
        },
        removeItem(index){
            this.form.splice(index, 1)
        },
        onCancel(){
            if(this.$route.meta.mode === 'edit') {
                this.$router.push(`${this.resource}`)
            } else {
                this.$router.push(`${this.resource}`)
            }
        },
        onSave(){
            this.errors = {}
            this.isProcessing = true
            byMethod(this.method, this.store, this.form)
          
            .then((res) => {
                if(res.data && res.data.saved) {
                    // this.$router.push(`${this.resource}/${res.data.id}`)
                    this.$router.push(`${this.resource}`)
                    // this.success(res)
                }
            })
            .catch((error) => {
                if(error.response.status === 422) {
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