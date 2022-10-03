<template>
    <tr>
        <th scope="row">
            <a :href="`/admin/bookings/${item.code}`">
                {{ item.number }}
            </a> 
        </th>
        <td>{{ clientName }}</td>
        <td>{{ chefName }}</td>
        <td>{{ dishName }}</td>
        <td>{{ item.amount | aud }}</td>
        <td>{{ item.start_time | datetime }}</td>

        <td class="capitalize">
            <div :class="['status', item.status]">{{ item.status }}</div>
        </td>
        <td class="text-right deco-none">
            <a :href="`/admin/bookings/${item.code}`">
                <i class="feather icon-eye pointer mr-10"></i>
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

        chef () {
            return this.item.chef || {}
        },

        chefName () {
            return this.chef.code    
                ? this.chef.firstname + ' ' + this.chef.lastname
                : '--'
        },

        dish () {
            return this.item.dish || {}
        },

        dishName () {
            return this.dish.code    
                ? this.dish.name
                : '--'
        },

        chefName () {
            return this.chef.code    
                ? this.chef.firstname + ' ' + this.chef.lastname
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
    }
}
</script>