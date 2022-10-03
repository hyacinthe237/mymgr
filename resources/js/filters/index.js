import Vue from 'vue'
import moment from 'moment'

Vue.filter('date', function (value, formatted = 'DD/MM/YYYY') {
    if (value) {
        return moment(String(value)).format(formatted)
    }
})

Vue.filter('datetime', function (value, formatted = 'DD/MM/YYYY HH:ss') {
    if (value) {
        return moment(String(value)).format(formatted)
    }
})

Vue.filter('duration', function (value) {
    if (value) {
        return moment(String(value)).fromNow()
    }
})

Vue.filter('time', function (value) {
    if (value) {
        return moment(String(value)).format('hh:mm')
    }
})

Vue.filter('age', function (value) {
    if (value) {
        return moment().diff(String(value), 'years')
    }
})

Vue.filter('capitalize', function (string) {
    if (string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
})

Vue.filter('aud', function (value) {
    if (value) {
        return new Intl.NumberFormat("en-AU", {
            style: "currency",
            currency: "AUD",
            minimumFractionDigits: 2
        }).format(value)
    } return '$0.00'
})