
window.Vue = require('vue');
window.eventBus = new Vue()

import VeeValidate from 'vee-validate'
import VueTranslate from 'vue-translate-plugin'

import store from './store/'
import GlobalMixins from './mixins/global'
import swal from './plugins/swal'
import toastr from './plugins/toastr'

require('./bootstrap')
require('./filters')
require('./ui')

Vue.use(swal)
Vue.use(toastr)
Vue.use(VeeValidate)
Vue.use(VueTranslate)
Vue.mixin(GlobalMixins)

Vue.component('admin-auth-signin', require('./components/backend/auth/signin').default)
Vue.component('admin-users-index', require('./components/backend/users/users').default)

Vue.component('admin-user-edit', require('./components/backend/user/edit').default)
Vue.component('admin-user-profile', require('./components/backend/user/profile').default)
Vue.component('admin-user-bookings', require('./components/backend/user/bookings').default)
Vue.component('admin-user-payments', require('./components/backend/user/payments').default)
Vue.component('admin-user-documents', require('./components/backend/user/documents').default)

Vue.component('admin-newsletter', require('./components/backend/newsletter/newsletter').default)
Vue.component('admin-roles-documents', require('./components/backend/roles/roles').default)

Vue.component('admin-support-ticket', require('./components/backend/support/ticket').default)
Vue.component('admin-support-tickets', require('./components/backend/support/tickets').default)

Vue.component('admin-bookings', require('./components/backend/bookings/bookings').default)
Vue.component('admin-booking', require('./components/backend/bookings/booking').default)

Vue.component('admin-cuisine-create', require('./components/backend/lists/cuisine-create').default)
Vue.component('admin-cuisines', require('./components/backend/lists/cuisines').default)
Vue.component('admin-cuisine', require('./components/backend/lists/cuisine').default)
Vue.component('admin-dishes', require('./components/backend/lists/dishes').default)
Vue.component('admin-dish', require('./components/backend/lists/dish').default)

Vue.component('admin-payments', require('./components/backend/payments/payments').default)
Vue.component('admin-payment', require('./components/backend/payments/payment').default)

Vue.component('admin-withdrawals', require('./components/backend/withdrawals/withdrawals').default)
Vue.component('admin-withdrawal', require('./components/backend/withdrawals/withdrawal').default)

const app = new Vue({
    el: '#app',
    store
});
