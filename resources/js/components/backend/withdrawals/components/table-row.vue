<template>
    <tr>
        <td scope="row">{{ clientName }}</td>
        <td class="capitalize">
            <div :class="['status', model.status]">{{ model.status }}</div>
        </td>
        <td scope="row" class="text-right">{{ model.amount | aud }}</td>
        <td scope="row">{{ requestedDAte }}</td>
        <td scope="row">{{ dateCleared }}</td>

        <td class="text-right deco-none">
            <a :href="`/admin/withdrawals/${model.code}`">
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
        client () {
            return this.model.user || {}
        },

        clientName () {
            return this.client.firstname + ' ' + this.client.lastname
        },

        requestedDAte () {
            return moment(this.model.created_at).format('DD/MM/YYYY HH:mm')
        },

        dateCleared () {
            if (!this.model.updated_at)
                return '--'
            return moment(this.model.updated_at).format('DD/MM/YYYY HH:mm')
        }
    }
}
</script>