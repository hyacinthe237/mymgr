<template>
    <tr>
        <th scope="row">{{ user.name }}</th>
        <td>{{ user.email }}</td>
        <td class="capitalize">{{ role }}</td>
    </tr>
</template>

<script>
export default {
    name: 'UserTableRow',

    props: {
        user: { type: Object, default: () => {}},
    },


    computed: {
        role () {
            return this.user.other === 'chef'
                ? 'Chef'
                : 'Customer'
        }
    }
}
</script>