<template>
    <tr>
        <th scope="row">{{ model.name }}</th>
        <td class="text-right deco-none">
            <a :href="`/admin/lists/cuisines/${model.code}`">
                <i class="feather icon-eye pointer mr-10"></i>
            </a>
        </td>
    </tr>
</template>


<script>
export default {
    name: 'CuisineTableRow',

    props: {
        model: { type: Object, default: () => {}}
    },
}
</script>