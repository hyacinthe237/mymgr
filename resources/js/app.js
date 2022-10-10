
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
require('./commons')

Vue.use(swal)
Vue.use(toastr)
Vue.use(VeeValidate)
Vue.use(VueTranslate)
Vue.mixin(GlobalMixins)

Vue.component('auth-signin', require('./components/frontend/auth/signin').default)
Vue.component('auth-signup', require('./components/frontend/auth/signup').default)
Vue.component('auth-organization-create', require('./components/frontend/auth/organization/create').default)
Vue.component('auth-organization-select', require('./components/frontend/auth/organization/select').default)

Vue.component('circle-loader', require('./components/frontend/loaders/circle').default)
Vue.component('auth-signup', require('./components/frontend/auth/signup').default)
Vue.component('organization-create', require('./components/frontend/organizations/create').default)
Vue.component('organization', require('./components/frontend/organizations/index').default)
Vue.component('mytickets', require('./components/frontend/mypage/mytickets').default)
Vue.component('team-create', require('./components/frontend/teams/create').default)
Vue.component('dashbord', require('./components/frontend/dashbord/home').default)
Vue.component('projects', require('./components/frontend/projects/projects').default)
Vue.component('project-edit', require('./components/frontend/projects/edit/project').default)
Vue.component('project-tickets', require('./components/frontend/projects/tickets/tickets').default)
Vue.component('comments', require('./components/frontend/comments/comments').default)
Vue.component('members', require('./components/frontend/members/index/members').default)
Vue.component('member', require('./components/frontend/members/show/member').default)
Vue.component('tickets', require('./components/frontend/tickets/index/list').default)
Vue.component('ticket-create', require('./components/frontend/tickets/create/create').default)
Vue.component('ticket-edit', require('./components/frontend/tickets/edit/edit').default)
Vue.component('project-stats', require('./components/frontend/projects/stats/stats').default)
Vue.component('search', require('./components/frontend/search/search').default)
Vue.component('notifications', require('./components/frontend/notifications/notifications').default)
Vue.component('notifications-badge', require('./components/frontend/notifications/item/badge').default)
Vue.component('ticket-activity', require('./components/frontend/activity/ticket').default)

const app = new Vue({
    el: '#app',
    store
});
