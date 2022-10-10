<template>
    <div class="">
        <div v-if="type == 'AppNotificationsTicketAssigned'" class="alert alert-default">
             <a :href="user_url" class="user-name">{{ item.data.from.firstname }}</a> assigned the ticket <a :href="url" class="task-link">#{{ item.data.ticket.number }} {{ item.data.ticket.title }}</a> to you.
            <span class="time-notify pull-right">{{  created_at }}</span>
        </div>
        <div v-if="type == 'AppNotificationsTicketStatusUpdated'" class="alert alert-default">
             <a :href="user_url" class="user-name">{{ item.data.from.firstname }}</a> updated the status of the ticket <a :href="url" class="task-link">#{{ item.data.ticket.number }} {{ item.data.ticket.title }}</a> to {{ item.data.status }} .
            <span class="time-notify pull-right">{{ created_at }}</span>
        </div>
        <div v-if="type == 'AppNotificationsTicketOpened'" class="alert alert-default">
            <img :src="user_photo" alt="image user">
             <a :href="user_url" class="user-name">{{ item.data.from.firstname }}</a> {{ item.data.ticket_action }} the ticket <a :href="url" class="task-link">#{{ item.data.ticket.number }} {{ item.data.ticket.title }}</a>
            <span class="time-notify pull-right">{{ created_at }}</span>
        </div>
    </div>

</template>

<script>
import moment from 'moment'

export default {
    props: ['item'],
    computed: {
        type () {
            return this.item.type.replace(/\\/g,'')
        },
        url () {
            if (this.item.data.ticket) return `/tickets/${this.item.data.ticket.number}`
            return null

        },
        user_url () {
            return `/members/${this.item.data.from.code}`
        },
        created_at () {
            return moment(this.item.created_at).format('ddd DD MMM YYYY HH:ss')
        },
    },


}

</script>
