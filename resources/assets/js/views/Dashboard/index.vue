<template>
    <div class="panel">
        <div class="panel-heading">
            <div>
                <router-link to="/invoice_new" class="btn btn-primary"
                    >Invoices</router-link
                >
            </div>
        </div>
        <div class="panel-heading">
            <div>
                <router-link to="/vendors" class="btn btn-primary"
                    >Vendors</router-link
                >
            </div>
        </div>

        <div class="panel-heading">
            <div>
                <router-link to="/product_new" class="btn btn-primary"
                    >Products</router-link
                >
            </div>
        </div>

        <div class="panel-heading">
            <div>
                <router-link to="/customers" class="btn btn-primary"
                    >Customers</router-link
                >
            </div>
        </div>
        <div class="panel-heading">
            <div>
                <router-link to="/stock" class="btn btn-primary"
                    >Stock Reports</router-link
                >
            </div>
        </div>
        <div class="panel-heading">
            <div>
                <router-link to="/page" class="btn btn-primary"
                    >Single Pages</router-link
                >
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            active: false,
        };
    },
    methods: {
        toggle() {
            this.active = !this.active;
        },
    },
};
</script>
