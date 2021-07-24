require('./bootstrap');

window.Vue = require('vue').default;

import AOS from 'aos';
import 'aos/dist/aos.css';
import Vue from 'vue';
AOS.init();

window.axios = require('axios');
const metas = document.getElementsByTagName('meta');
for (let i = 0; i < metas.length; i++) {
  if (metas[i].getAttribute('name') === "csrf-token") {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = metas[i].getAttribute('content');
  }
}

Vue.use(require('vue-moment'));

Vue.component('Home', require('./components/home/Home.vue').default);
Vue.component('Login', require('./components/auth/Login.vue').default);
Vue.component('Register', require('./components/auth/Register.vue').default);

Vue.component('AdminCreate', require('./components/admin/subcomponents/Create.vue').default);

Vue.component('Request', require('./components/buyer/request/Request.vue').default);
Vue.component('CreateRequest', require('./components/buyer/request/Create.vue').default);
Vue.component('SellerRequest', require('./components/seller/request/Request.vue').default);
Vue.component('SellerShow', require('./components/seller/request/Show.vue').default);

Vue.component('Profile', require('./components/auth/Profile.vue').default);

Vue.component('User', require('./components/admin/user/User.vue').default);

Vue.component('SellerOverview', require('./components/seller/Overview.vue').default);
Vue.component('AdminOverview', require('./components/admin/Overview.vue').default);

Vue.component('Product', require('./components/seller/product/Product.vue').default);
Vue.component('CreateProduct', require('./components/seller/product/Create.vue').default);

Vue.component('Feedback', require('./components/feedback/Feedback.vue').default);
Vue.component('CreateFeedback', require('./components/feedback/Create.vue').default);

Vue.component('Offer', require('./components/seller/offer/Offer.vue').default);
Vue.component('ShowOffer', require('./components/buyer/offer/Show.vue').default);

Vue.component('Order', require('./components/buyer/order/Order.vue').default);
Vue.component('SellerOrder', require('./components/seller/order/Order.vue').default);

Vue.component('Payment', require('./components/payment/Payment.vue').default);



const app = new Vue({
    el: '#app',
});
