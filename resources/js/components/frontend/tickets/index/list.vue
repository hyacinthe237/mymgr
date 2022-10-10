<template>
    <div class="">
        <div class="content-title">
            <button class="btn btn-teal pull-right" @click="showFilters()">
                <i class="ion-android-funnel"></i> Filters
            </button>

            <span v-if="tickets.length !== 0">{{ tickets.length }}</span> Tickets
        </div>

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

        <FiltersModal :users="users" :categories="categories" :projects="projects" @apply="applyFilters"></FiltersModal>
    </div>

</template>

<script>


import Item from './item'
import FiltersModal from './filters'
import { mapGetters } from 'vuex'

export default {
    name: 'ticket-list',

    props: ['users','categories','projects'],

    components: { Item, FiltersModal },

    data: () => ({
        pockets: [],
        previousUrls: [],
        filters: { 'project':'','category':'','user':'','is_open':'1'}
    }),

    beforeMount() {
        this.url = 'tickets'
        this.url=this.urlWithFilters()
    },

    mounted () {
        this.scroll()
        this.getTickets()
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
        resetData () {
            this.pockets =[]
            this.previousUrls =[]
            this.url = 'tickets'

        },
        async getTickets () {
            this.isLoading = true

            if ((this.url) && (!this.previousUrls.includes(this.url))) {
                this.previousUrls.push(this.url);
                const response = await axios.get(this.url)
                .catch(error => console.log(error))

                if (response) {
                    this.pockets.push.apply(this.pockets, response.data.items);
                    this.url = response.data.links.next
                    this.url=this.urlWithFilters()
                    this.$store.commit('tickets/SET_TICKETS', this.pockets)
                }
            }

            this.isLoading = false
        },


        scroll () {
            window.onscroll = () => {
                let bottomOfWindow = document.documentElement.scrollTop + window.innerHeight === document.documentElement.offsetHeight;

                if (bottomOfWindow) {
                    this.getTickets();
                }
            };
        },

        showFilters () {
            this.openModal({ id: 'filtersModal' })
        },

        applyFilters (filters) {
            this.resetData()
            this.filters=filters
            this.url=this.urlWithFilters()
            this.getTickets()
        },
        urlWithFilters () {
            var join= /.\?./.test(this.url)? '&' :'?'

            if ((!this.filters)||(!this.url)) {
                return this.url
            }

            return  `${this.url}${join}search=project_id:${this.filters.project};status:${this.filters.category};assignee_id:${this.filters.user};is_open:${this.filters.is_open}&searchJoin=and`
        },

    }
}
</script>
