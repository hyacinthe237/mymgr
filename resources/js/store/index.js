import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        auth: {},
        user: {},
        model: {},
        ticket: {},
        booking: {},
        bookings: {},
    },

    mutations: {
        SET_AUTH (state, payload) {
            state.auth = payload
        },

        SET_USER (state, payload) {
            state.user = payload
        },

        SET_MODEL (state, payload) {
            state.model = payload
        },

        SET_TICKET (state, payload) {
            state.ticket = payload
        },

        SET_BOOKING (state, payload) {
            state.booking = payload
        },

        SET_BOOKINGS (state, payload) {
            state.bookings = payload
        },
    }
})