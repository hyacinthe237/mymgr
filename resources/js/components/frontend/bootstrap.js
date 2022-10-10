
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    // window.$ = window.jQuery = require('jquery');
    global.$ = global.jQuery = require('jquery');
    require('bootstrap-sass');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios')
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
window.axios.defaults.baseURL = '/api'
window.webAxios = axios.create({ baseURL: '/' })


/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    window.webAxios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

    if (typeof _auth !== 'undefined')
        window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + _auth;

    if (typeof _org !== 'undefined')
        window.axios.defaults.headers.common['organization'] = _org.code;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

import Echo from "laravel-echo"
import Pusher from "pusher-js"

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '49846bc99be3c7960983',
    cluster: 'eu',
    encrypted: true
});
