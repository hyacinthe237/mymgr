<template>
    <tr>
        <th scope="row">{{ booking.number }}</th>
        <td scope="row">{{ clientName }}</td>
        <td scope="row" class="capitalize">{{ model.status }}</td>
        <td scope="row" class="text-right">{{ model.amount | aud }}</td>
        <td scope="row">{{ paymentDate }}</td>
        <td scope="row">{{ dateCleared }}</td>

        <td class="text-right deco-none">
            <a :href="`/admin/bookings/${booking.code}`">
                <i class="feather icon-eye pointer mr-10"></i>
            </a>
        </td>
    </tr>
</template>


<script>
export default {
    name: 'TableRow',

    props: {
        model: { type: Object, default: () => {}}
    },

    computed: {
        booking () {
            return this.model.booking || {}
        },

        client () {
            return this.model.user || {}
        },

        clientName () {
            return this.client.firstname + ' ' + this.client.lastname
        },

        paymentDate () {
            return moment(this.model.created_at).format('DD/MM/YYYY HH:mm')
        },

        dateCleared () {
            if (!this.model.cleared_at)
                return '--'
            return moment(this.model.cleared_at).format('DD/MM/YYYY HH:mm')
        }
    }
}
</script>