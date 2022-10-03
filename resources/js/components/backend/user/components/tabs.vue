<template>
    <div class="_block-tabs">
            <div :class="['_block-tab', active == 'profile' ? 'active' : '' ]">
                <a :href="`/admin/acl/users/${user.code}`">
                    <i class="feather icon-user"></i> 
                    <span>Profile</span>   
                </a>
            </div>
            <div :class="['_block-tab', active == 'bookings' ? 'active' : '' ]">
                <a :href="`/admin/acl/users/${user.code}/bookings`">
                    <i class="feather icon-calendar"></i> 
                    <span>Bookings</span>   
                </a>
            </div>
            <div :class="['_block-tab', active == 'payments' ? 'active' : '' ]">
                <a :href="`/admin/acl/users/${user.code}/payments`">
                    <i class="feather icon-shopping-cart"></i> 
                    <span>Payments</span>   
                </a>
            </div>
            <div :class="['_block-tab', active == 'documents' ? 'active' : '' ]">
                <a :href="`/admin/acl/users/${user.code}/documents`">
                    <i class="feather icon-paperclip"></i> 
                    <span>Documents</span>   
                </a>
            </div>
        </div>
</template>

<script>
export default {
    name: 'admin-user-tabs',

    props: {
        active: { type: String, default: 'profile' }
    },

    computed: {
        user () {
            return this.$store.state.user
        }
    }
}
</script>
