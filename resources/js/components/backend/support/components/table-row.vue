<template>
    <tr>
        <th scope="row">{{ item.number }}</th>
        <td>{{ item.title }}</td>
        <td>{{ clientName }}</td>
        <td class="pointer" @click="showAssigneeModal()">{{ assigneeName }}</td>
        <td class="capitalize">
            <div :class="['status', item.status]">{{ item.status }}</div>
        </td>
        <td class="text-right deco-none">
            <a :href="`/admin/tickets/${item.code}`">
                <i class="feather icon-eye pointer mr-10"></i>
            </a>

            <a @click.prevent="showAssigneeModal()">
                <i class="feather icon-user pointer mr-10"></i>
            </a>
        </td>
    </tr>
</template>

<script>
export default {
    name: 'TableRow',

    props: {
        item: { type: Object, default: () => {}},
    },

    computed: {
        client () {
            return this.item.client || {}
        },

        clientName () {
            return this.client.code
                ? this.client.firstname + ' ' + this.client.lastname
                : '--'
        },

        assignee () {
            return this.item.assignee || {}
        },

        assigneeName () {
            return this.assignee.code    
                ? this.assignee.firstname + ' ' + this.assignee.lastname
                : '--'
        },

        updater () {
            return this.item.updater || {}
        },

        updaterName () {
            return this.updater.code
                ? this.updater.firstname + ' ' + this.updater.lastname
                : '--'
        }
    },

    methods: {
        view () {
            this.$emit('viewUser', this.item.code)
        },

        editUser (uuid) {
            this.$emit('editUser', uuid)
        },

        blockUser (uuid) {
            this.$emit('blockUser', uuid)
        },

        showAssigneeModal () {
            console.log('showing assignee for ticket', this.item)
            this.$emit('assign', this.item)
        }
    }
}
</script>