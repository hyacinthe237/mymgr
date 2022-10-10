<template>
    <section class="content-body">
        <div class="mt-60" v-show="isLoading">
            <circle-loader></circle-loader>
        </div>

        <div class="sad-block" v-show="noTicket && !isLoading">
            <i class="ion-ios-box-outline"></i>
            <h5>No ticket found</h5>
        </div>

        <div class="blocks-items mt-20">
            <Item v-for="item in tickets" :item="item" :key="item.id"></Item>
        </div>
    </section>
</template>

<script>


import Item from '../tickets-list/tickets-list'

export default {

    components: { Item },

    props: ['tickets'],

    computed: {
        noTicket () {
            return this.tickets.length === 0
        }
    }
}
</script>
