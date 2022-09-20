<template>
    <div class="panel">
        <!-- <div class="panel-heading">
            <div>
                <router-link to="/customers" class="btn btn-primary">Customers</router-link>
            </div>
        </div> -->
        <!-- <div class="panel-heading">
            <div>
                <router-link to="/products" class="btn btn-primary">Products</router-link>
            </div>
        </div> -->
        <div class="panel-heading">
            <div>
                <router-link to="/invoices" class="btn btn-primary">Invoices</router-link>
            </div>
        </div>
        <!-- <div class="panel-heading">
            <div>
                <router-link to="/vendors" class="btn btn-primary">Vendors</router-link>
            </div>
        </div> -->
        <div class="panel-heading">
            <!-- <div>
                <router-link to="/dashboard" class="btn btn-primary">Dashboard</router-link>
            </div> -->
            <button class="btn btn-primary" @click="toggle">Dashboard</button>
            <div v-if="active">
                <div class="panel-heading">
                    <div>
                        <router-link to="/vendors">Vendors</router-link>
                    </div>
                </div>

                <div class="panel-heading">
                    <div>
                        <router-link to="/products">Products</router-link>
                    </div>
                </div>

                <div class="panel-heading">
                    <div>
                        <router-link to="/customers">Customers</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            active: false
        }
    },
    methods: {
        toggle() {
            this.active = !this.active
        }
    }
}
</script>