<template>
    <tr>
        <th scope="row">{{ user.username }}</th>
        <td>{{ user.firstname }} {{ user.lastname }}</td>
        <td>{{ user.email }}</td>
        <td class="capitalize">{{ role.display_name }}</td>
        <td class="capitalize">
            <div :class="['status', user.status]">{{ user.status }}</div>
        </td>
        <td class="text-right deco-none">
            <a :href="`/admin/acl/users/${user.code}`">
                <i class="feather icon-eye pointer mr-10"></i>
            </a>

            <a :href="`/admin/acl/users/${user.code}/edit`">
                <i class="feather icon-edit-2 pointer mr-10"></i>
            </a>
            
            <i class="feather icon-slash pointer" @click="blockUser(user.code)"></i>
        </td>
    </tr>
</template>

<script>
export default {
    name: 'UserTableRow',

    props: {
        user: { type: Object, default: () => {}},
        roles: { type: Array, default: () => []}
    },


    computed: {
        role () {
            return this.roles.find(r => r.id === this.user.role_id) || {}
        }
    },

    methods: {
        viewUser (uuid) {
            this.$emit('viewUser', uuid)
        },

        editUser (uuid) {
            this.$emit('editUser', uuid)
        },

        blockUser (uuid) {
            this.$emit('blockUser', uuid)
        },
    }
}
</script>