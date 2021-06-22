/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');


import './helpers/Helpers.js'
import './helpers/DateFns.js'
import './helpers/Socket.js'
import './helpers/VeeValidate.js'
import store from './store/store.js'
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import ProductIndex from './pages/Product.vue'
import ProductForm from './pages/ProductForm.vue'
import OrderIndex from './pages/Order.vue'
import NotifNav from './components/NotifNav.vue'
import PaymentIndex from './pages/Payment.vue'
import DashboardIndex from './pages/Dashboard/DashboardIndex.vue'
import ProductDetails from './pages/ProductDetails.vue'
import './helpers/Swall.js'

Vue.component('product-index', ProductIndex);
Vue.component('product-form', ProductForm);
Vue.component('order-index', OrderIndex);
Vue.component('notif-nav', NotifNav);
Vue.component('payment-index', PaymentIndex);
Vue.component('dashboard-index', DashboardIndex);
Vue.component('product-details', ProductDetails);

const app = new Vue({
    store,
    el: '#app',
    sockets: {
        connect() {
            console.log('socket connected')
        },
        MSG_NEW_ORDER(arg) {
            this.$store.dispatch('playNotif', arg)
        }
    },
});