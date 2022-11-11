import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        // {path: '/', redirect: '/invoices'},
        // { path: '/', component: require('../views/page/form.vue').default },
        { path: '/page', component: require('../views/page/form.vue').default },
        { path: '/page/create', component: require('../views/page/form.vue').default},

        // { path: '/page/:id/edit', component: require('../views/page/form.vue').default, meta: { mode: 'edit' } },
        // { path: '/page/:id/edit', component: require('../views/page/form.vue').default, meta: { mode: 'edit' } },

        { path: '/invoices', component: require('../views/Invoices/index.vue').default },
        { path: '/invoices/create', component: require('../views/Invoices/form.vue').default },
        { path: '/invoices/:id/edit', component: require('../views/Invoices/form.vue').default, meta: { mode: 'edit' } },
        { path: '/invoices/:id', component: require('../views/Invoices/show.vue').default },

        { path: '/invoice_new', component: require('../views/Invoicesnews/index.vue').default },
        { path: '/invoice_new/create', component: require('../views/Invoicesnews/form.vue').default },
        { path: '/invoice_new/:id/edit', component: require('../views/Invoicesnews/form.vue').default, meta: { mode: 'edit' } },
        { path: '/invoice_new/:id', component: require('../views/Invoicesnews/show.vue').default },

        // {path: '/', redirect: '/customers'},
        { path: '/customers', component: require('../views/customers/index.vue').default },
        { path: '/customers/create', component: require('../views/customers/form.vue').default },
        { path: '/customers/:id/edit', component: require('../views/customers/form.vue').default, meta: { mode: 'edit' } },
        { path: '/customers/:id', component: require('../views/customers/show.vue').default },

        
        { path: '/stock', component: require('../views/stock/index.vue').default },

        // {path: '/', redirect: '/products'},
        { path: '/products', component: require('../views/products/index.vue').default },
        { path: '/products/create', component: require('../views/products/form.vue').default },
        { path: '/products/:id/edit', component: require('../views/products/form.vue').default, meta: { mode: 'edit' } },
        { path: '/products/:id', component: require('../views/products/show.vue').default },

        { path: '/product_new', component: require('../views/productnews/index.vue').default },
        { path: '/product_new/create', component: require('../views/productnews/form.vue').default },
        { path: '/product_new/:id/edit', component: require('../views/productnews/form.vue').default, meta: { mode: 'edit' } },
        { path: '/product_new/:id', component: require('../views/productnews/show.vue').default },

        { path: '/vendors', component: require('../views/vendors/index.vue').default },
        { path: '/vendors/create', component: require('../views/vendors/form.vue').default },
        { path: '/vendors/:id/edit', component: require('../views/vendors/form.vue').default, meta: { mode: 'edit' } },
        { path: '/vendors/:id', component: require('../views/vendors/show.vue').default },

        { path: '/', redirect: '/dashboard' },
        { path: '/dashboard', component: require('../views/Dashboard/index.vue').default },
    ]
})
export default router