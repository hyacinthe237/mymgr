import moment from 'moment'
import { mapGetters } from 'vuex'

export default {
    computed: {
        url () {
            return `/tickets/${this.item.number}`
        },

        status () {
            return this.item.category ? this.item.category.name : ''
        },

        assignee () {
            let str = 'Unassigned'
            if (this.item.assignee !== null && this.item.assignee !== undefined) {
                if (!this.item.assignee.lastname) {
                    str = this.item.assignee.firstname
                } else {
                    str = this.item.assignee.firstname + ' ' + this.item.assignee.lastname
                }
            }
            return str
        },

        dueDate () {
            let date = ''
            if (this.item.end_date) {
                date = moment(this.item.end_date).format('DD/MM/YYYY')
            }
            return date
        },

        noTicket () {
            return this.item.length === 0
        },

        formattedMembers () {
            let items = []
            for (let m of Object.entries(this.members)) {
                for (let [key, value] of Object.entries(m)) {
                    let item = {
                        id: value.id,
                        label: value.firstname
                    }

                    item.label += value.lastname ? ' ' + value.lastname : ''
                    if (value.status == 'active') {
                        items.push(item)
                    }
                }
            }

            return items
        },

        formattedCategories () {
            return this.categories.map(c => ({ id: c.id, label: c.name }))
        },

        ...mapGetters('members', {
            members: 'all',
        }),

        ...mapGetters('tickets', {
            categories: 'categories'
        }),

        isOpen () {
            return this.item.is_open ? 'Open' : 'Resolved'
        },

        closeFooterMessage () {
            return this.item.is_open ? 'Close ticket' : 'Reopen ticket'
        }
    },

    methods: {
        /**
         * Assign a ticket to a member
         */
        assigned (e) {
            let item = Object.assign({}, this.item)
            item.assignee_id = e.id
            this.$store.dispatch('tickets/update', item)
        },

        /**
         * Remove assigne member
         */
        footerClicked (e) {
            let item = Object.assign({}, this.item)
            item.assignee_id = null
            this.$store.dispatch('tickets/assigned', item)
        },

        /**
         * Change a ticket status
         */
        statusChanged (e) {
            let item = Object.assign({}, this.item)
            item.status = e.id
            this.$store.dispatch('tickets/update', item)
        },

        /**
         * Close / Reopen ticket
         */
        closeTicket (e) {
            let item = Object.assign({}, this.item)
            item.is_open = item.is_open === 1 ? 0 : 1;
            this.$store.dispatch('tickets/update', item)
        },
    }
}
