<template>
    <div class="_log">
        <div class="text">
            <span class="date">{{ date }}</span>
            <strong>{{ userName }}</strong>
            {{ log.description }} {{ type }}
            <a :href="`/tickets/${number}`">{{ name }}</a>
        </div>

        <div class="changes" >
            <ul v-if="log.description == 'created'">
                <li v-for="c in initialValues">
                    <span class="capitalize">{{ mapKey(c.key) }}</span>
                    set to <strong>{{ mapValue(c.key, c.attribute) }}</strong>
                </li>
            </ul>

            <ul v-if="log.description == 'updated'">
                <li v-for="c in changes">
                    <span class="capitalize">{{ mapKey(c.key) }}</span>
                    changed from
                    <strong>{{ mapValue(c.key, c.old) }}</strong>
                    to <strong>{{ mapValue(c.key, c.attribute) }}</strong>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
import moment from 'moment'
import { mapGetters } from 'vuex'

export default {
    props: {
        log: {
            type: Object,
            default: () => {}
        },

        number: {
            type: Number,
            default: 0
        }
    },


    computed: {
        ...mapGetters('members', {
            members: 'all',
        }),

        ...mapGetters('tickets', {
            categories: 'categories'
        }),

        user () {
            return _.find(this.members, { id: this.log.causer_id })
        },

        userName () {
            return this.user ? this.user.name : ''
        },

        type () {
            return this.number ? 'ticket' : 'project'
        },

        name () {
            return this.number ? this.number : ''
        },

        date () {
            return moment(this.log.created_at).format('DD/MM/YYYY HH:mm')
        },

        changes () {
            let old = this.log.properties.old
            let attributes = this.log.properties.attributes
            let changes = []

            for (let k in attributes) {
                changes.push({
                    key: k,
                    old: old[k],
                    attribute: attributes[k]
                })
            }

            return changes
        },

        initialValues () {
            const displays = [
                'title', 'priority', 'complexity', 'start_date', 'end_date',
                'assignee_id', 'status'
            ]

            let attributes = this.log.properties.attributes
            let changes = []
            for (let k in attributes) {
                if (displays.includes(k)) {
                    changes.push({
                        key: k,
                        attribute: attributes[k]
                    })
                }
            }
            return changes
        }
    },

    methods: {
        mapKey (key) {
            let str = key
            switch (key) {
                case 'status' :
                    str = 'stage'; break;
                case 'is_open' :
                    str = 'status'; break;
                case 'start_date' :
                    str = 'start date'; break;
                case 'end_date' :
                    str = 'end date'; break;
                case 'assignee_id' :
                    str = 'assignee'; break;
                default: key
            }
            return str
        },

        mapValue (key, value) {
            if (key === 'status') {
                let category = _.find(this.categories, { id: value })
                return category ? category.name : ''
            }

            if (key === 'end_date' || key === 'start_date') {
                if (!value) return 'empty'
                return moment(value).format('DD/MM/YYYY')
            }

            if (key === 'is_open') {
                return value == 1 ? 'Open' : 'Resolved'
            }

            if (key === 'assignee_id') {
                if (!value) return 'Unassigned'
                let user = _.find(this.members, { id: value })
                return user ? user.name : 'Unassigned'
            }

            return value
        }
    }
}
</script>
