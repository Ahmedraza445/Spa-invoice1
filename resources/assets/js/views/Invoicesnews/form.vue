<template>
    <div class="panel" v-if="show">
        <div class="panel-heading">
            <h1 class="panel-title">{{ title }} Invoice</h1>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label> Customer </label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="form.customer"
                        />
                        <small class="error-control" v-if="errors.customer">
                            {{ errors.customer[0] }}
                        </small>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Date</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.date"
                        />
                        <small class="error-control" v-if="errors.date">
                            {{ errors.date[0] }}
                        </small>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Due Date</label>
                        <input
                            type="date"
                            class="form-control"
                            v-model="form.due_date"
                        />
                        <small class="error-control" v-if="errors.due_date">
                            {{ errors.due_date[0] }}
                        </small>
                    </div>
                </div>
            </div>
            <hr />
            <table class="form-table">
                <tbody>
                    <tr class="form-group" v-for="(item, index) in form.items">
                        <td class="col-8">
                            <th> Item description </th>
                            <typeahead
                                :url="productURL"
                                :initialize="item.product"
                                @input="onProduct(index, $event)"
                            />
                            <small
                                class="error-control"
                                v-if="errors[`items.${index}.product_id`]"
                            >
                                {{ errors[`items.${index}.product_id`][0] }}
                            </small>
                        </td>
                        <td class="col-2">
                            <th> Quantity </th>
                            <input
                                type="text"
                                class="form-control"
                                v-model="item.qty"
                            />
                            <small
                                class="error-control"
                                v-if="errors[`items.${index}.qty`]"
                            >
                                {{ errors[`items.${index}.qty`][0] }}
                            </small>
                        </td>
                        <td class="col-3">
                            <th> Unit Price </th>
                            <input
                                type="text"
                                class="form-control"
                                v-model="item.unit_price"
                            />
                            <small
                                class="error-control"
                                v-if="errors[`items.${index}.unit_price`]"
                            >
                                {{ errors[`items.${index}.unit_price`][0] }}
                            </small>
                        </td>
                        <td class="w-6"></td>
                        <td class="col-4">
                            <th>Total</th>
                            <span class="form-control d-flex justify-content-end">
                                {{
                                    (Number(item.qty) * Number(item.unit_price))
                                        | formatMoney
                                }}
                            </span>
                        </td>
                        <td>
                            <span class="form-remove" @click="removeItem(index)"
                                >&times;</span
                            >
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <td colspan="2">
                        <button class="btn btn-sm" @click="addNewLine">
                            Add New Line
                        </button>
                    </td>
                    <tr>
                        <td colspan="4" class="form-summary">Sub Total</td>
                        <td class="form-control">{{ subTotal | formatMoney }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="form-summary">Discount</td>
                        <td>
                            <input
                                type="text"
                                class="form-control"
                                v-model="form.discount"
                            />
                            <small class="form-control" v-if="errors.discount">
                                {{ errors.discount[0] }}
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" class="form-summary">Grand Total</td>
                        <td class="form-control">{{ total | formatMoney }}</td>
                    </tr>
                </tfoot>
            </table>
            <hr />
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Terms and Conditions</label>
                        <div class="col-30">
                            <textarea
                                class="form-control"
                                v-model="form.terms_and_conditions"
                            ></textarea>
                            <small
                                class="error-control"
                                v-if="errors.terms_and_conditions"
                            >
                                {{ errors.terms_and_conditions[0] }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer flex-end">
            <div>
                <button
                    class="btn btn-primary"
                    :disabled="isProcessing"
                    @click="onSave"
                >
                    Save
                </button>
                <button class="btn" :disabled="isProcessing" @click="onCancel">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
import Vue from "vue";
import { get, byMethod } from "../../lib/api";
import { Typeahead } from "../../components/typeahead";

function initialize(to) {
    let urls = {
        create: `/api/invoice_new/create`,
        edit: `/api/invoice_new/${to.params.id}/edit`,
    };

    return urls[to.meta.mode] || urls["create"];
}
export default {
    components: { Typeahead },
    data() {
        return {
            form: {},
            errors: {},
            isProcessing: false,
            show: false,
            resource: "/invoice_new",
            store: "/api/invoice_new",
            method: "POST",
            title: "Create",
            productURL: "/api/search/product_new",
        };
    },
    beforeRouteEnter(to, from, next) {
        get(initialize(to)).then((res) => {
            next((vm) => vm.setData(res));
        });
    },
    beforeRouteUpdate(to, from, next) {
        this.show = false;
        get(initialize(to)).then((res) => {
            this.setData(res);
            next();
        });
    },
    computed: {
        subTotal() {
            return this.form.items.reduce((carry, item) => {
                return carry + Number(item.unit_price) * Number(item.qty);
            }, 0);
        },
        total() {
            return this.subTotal - Number(this.form.discount);
        },
    },
    methods: {
        setData(res) {
            Vue.set(this.$data, "form", res.data.form);

            if (this.$route.meta.mode === "edit") {
                this.store = `/api/invoice_new/${this.$route.params.id}`;
                this.method = "PUT";
                this.title = "Edit";
            }

            this.show = true;
            this.$bar.finish();
        },
        addNewLine() {
            this.form.items.push({
                product_id: null,
                product: null,
                unit_price: 0,
                qty: 1,
            });
        },
        onCustomer(e) {
            const customer = e.target.value;
            Vue.set(this.$data.form, "customer", customer);
            Vue.set(this.$data.form, "customer_id", customer.id);
        },
        onProduct(index, e) {
            const product = e.target.value;
            Vue.set(this.form.items[index], "product", product);
            Vue.set(this.form.items[index], "product_id", product.id);

            Vue.set(this.form.items[index], "unit_price", product.price);
        },
        removeItem(index) {
            this.form.items.splice(index, 1);
        },
        onCancel() {
            if (this.$route.meta.mode === "edit") {
                this.$router.push(`${this.resource}`);
            } else {
                this.$router.push(`${this.resource}`);
            }
        },
        onSave() {
            this.errors = {};
            this.isProcessing = true;
            byMethod(this.method, this.store, this.form)
                .then((res) => {
                    if (res.data && res.data.saved) {
                        this.$router.push(`${this.resource}`);
                    }
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                    this.isProcessing = false;
                });
        },
        success(res) {
            this.$router.push(`${this.resource}/${res.data.id}`);
        },
    },
};
</script>
