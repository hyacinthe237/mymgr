<template>
    <tr>
        <th scope="row">{{ model.name }}</th>
        <td scope="row">{{ cuisine.name }}</td>
        <td scope="row">{{ model.serves }}</td>
        <td scope="row">{{ model.price | aud }}</td>
        <td scope="row" class="text-right">{{ model.duration }} min</td>

        <td class="text-right deco-none">
            <a :href="`/admin/lists/dishes/${model.code}`">
                <i class="feather icon-eye pointer mr-10"></i>
            </a>
        </td>
    </tr>
</template>


<script>
export default {
    name: 'DishTableRow',

    props: {
        model: { type: Object, default: () => {}}
    },

    computed: {
        cuisine () {
            return this.model.cuisine || {}
        }
    }
}
</script>