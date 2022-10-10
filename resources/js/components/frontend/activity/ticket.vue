<template>
    <div class="activity-log" v-if="hasLogs">
        <h4>Activity</h4>

        <Log v-for="l in logs" :log="l" :key="l.id" :number="number"/>
    </div>
</template>

<script>
import Log from './log'

export default {
    props: {
        number: {
            type: Number,
            required: true
        }
    },

    components: { Log },

    data: () => ({
        logs: []
    }),

    beforeMount () {
        this.$store.dispatch('members/getAll')
        this.$store.dispatch('tickets/getCategories')
    },

    mounted () {
        this.getTicketLogs()
    },


    computed: {
        hasLogs () {
            return this.logs.length
        }
    },

    methods: {
        async getTicketLogs () {
            this.isLoading = true

            const response = await axios.get('/tickets/' + this.number + '/activity')
            .catch(error => console.log(error))

            if (response) {
                this.logs = response.data
            }

            this.isLoading = false
        }
    }
}
</script>
