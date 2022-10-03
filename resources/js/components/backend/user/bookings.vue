<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />

        <div class="block-container">
            <Tabs :active="'bookings'" />

            <table class="table mt-20">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Reference</th>
                        <th scope="col">Dish</th>
                        <th scope="col">Chef</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Created</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
    
</template>

<script>
import Tabs from './components/tabs'
import userMixins from './mixins'

export default {
    name: 'admin-user-profile',
    mixins: [userMixins],
    components: { Tabs },

    mounted () {
        this.getUser()
        this.getUserBookings()
    },

    methods: {
        async getUserBookings () {
            this.isLoading = true

            let url = `/users/${_uuid}/bookings?page=1`
    
            const res = await axios.get(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.$store.commit('SET_BOOKINGS', res.data.data)
            }
        }
    }
}
</script>