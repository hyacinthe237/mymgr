<template>
    <section>
        <div class="mt-60" v-show="isLoading">
            <circle-loader></circle-loader>
        </div>

        <div class="sad-block" v-show="noTicket && !isLoading">
            <i class="ion-ios-box-outline"></i>
            <h5>No ticket found</h5>
        </div>

        <div class="_tickets mt-20">
            <Item v-for="item in tickets" :item="item" :key="item.id"></Item>
        </div>
    </section>
</template>

<script>
import { mapGetters } from 'vuex'
import Item from './item'

export default {
    props: ['project', 'users'],

    components: { Item },

    mounted () {
        this.getTickets(),
        this.$store.dispatch('members/getAll')
        this.$store.dispatch('tickets/getCategories')
    },

    computed: {
        noTicket () {
            return this.tickets.length === 0
        },

        ...mapGetters('tickets', {
            tickets: 'all'
        })
    },

    methods: {
        async getTickets () {
            this.startLoading()

            const url = 'projects/' + this.project.code + '/tickets'
            const response = await axios.get(url)
            .catch(error => console.log(error))

            if (response) {
                this.$store.commit('tickets/SET_TICKETS', response.data.items)
            }

            this.stopLoading()
        },
    }
}
</script>
