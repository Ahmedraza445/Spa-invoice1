import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {path: '/', redirect: '/invoices'},
        {path: '/invoices', component: require('../views/Invoices/index.vue').default},
        {path: '/invoices/create', component: require('../views/Invoices/form.vue').default},
        {path: '/invoices/:id/edit', component: require('../views/Invoices/form.vue').default, meta: {mode: 'edit'}},
        {path: '/invoices/:id', component: require('../views/Invoices/show.vue').default},

        // {path: '/', redirect: '/customers'},
        // {path: '/customers', component: require('../views/customers/index.vue').default},
        // {path: '/customers/create', component: require('../views/customers/form.vue').default},
        // {path: '/customers/:id/edit', component: require('../views/customers/form.vue').default, meta: {mode: 'edit'}},
        // {path: '/customers/:id', component: require('../views/customers/show.vue').default}

        // {path: '/', redirect: '/products'},
        // {path: '/products', component: require('../views/products/index.vue').default},
        // {path: '/products/create', component: require('../views/products/form.vue').default},
        // {path: '/products/:id/edit', component: require('../views/products/form.vue').default, meta: {mode: 'edit'}},
        // {path: '/products/:id', component: require('../views/products/show.vue').default}
        // {path: '/', redirect: '/dashboard'},
        // {path: '/dashboard', component: require('../views/Dashboard/dashboard.vue').default},
    ]
})
export default router