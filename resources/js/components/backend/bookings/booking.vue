<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />

        <div class="row">
            <div class="col-sm-6">
                <div class="block-container mb-40">
                    <div class="pd-20">
                        <h4 class="bold">Booking Details</h4>

                        <table class="table table-striped mt-20">
                            <tbody>
                                <tr>
                                    <td class="text-right teal">Number</td>
                                    <td>{{ booking.number }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Status</td>
                                    <td class="capitalize">{{ booking.status }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Date & time</td>
                                    <td>{{ booking.start_time | datetime }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Cost</td>
                                    <td>{{ booking.amount | aud }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="block-container mb-40">
                    <div class="pd-20">
                        <a class="float-right" :href="'/admin/acl/users/' + client.code">
                            <i class="feather icon-external-link"></i>
                        </a>
                        <h4 class="bold">Client Details</h4>

                        <table class="table table-striped mt-20">
                            <tbody>
                                <tr>
                                    <td class="text-right teal">Username</td>
                                    <td>{{ client.username }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">First name</td>
                                    <td>{{ client.firstname }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Last name</td>
                                    <td>{{ client.lastname }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Address</td>
                                    <td>{{ clientAddress }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="block-container mb-40">
                    <div class="pd-20">
                        <a class="float-right" :href="'/admin/acl/users/' + chef.code">
                            <i class="feather icon-external-link"></i>
                        </a>
                        <h4 class="bold">Chef Details</h4>

                        <table class="table table-striped mt-20">
                            <tbody>
                                <tr>
                                    <td class="text-right teal">Username</td>
                                    <td>{{ chef.username }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">First name</td>
                                    <td>{{ chef.firstname }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Last name</td>
                                    <td>{{ chef.lastname }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Sex</td>
                                    <td>{{ chef.sex }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="col-sm-6">
                <div class="block-container mb-40">
                    <div class="pd-20">
                        <a class="float-right" :href="'/admin/lists/dishes/' + dish.code">
                            <i class="feather icon-external-link"></i>
                        </a>
                        <h4 class="bold">Dish Details</h4>

                        <table class="table table-striped mt-20">
                            <tbody>
                                <tr>
                                    <td class="text-right teal">Name</td>
                                    <td>{{ dishName }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Serves</td>
                                    <td>{{ dish.serves }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Duration</td>
                                    <td>{{ dish.duration }} minutes</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Ingredients</td>
                                    <td class="capitalize">{{ dishIngredients }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import _ from 'lodash'

export default {
    name: 'admin-booking',
    components: {  },

    data: () => ({
        chat: {},
        statuses: [],
        admins: [],
    }),

    mounted () {
        this.getBooking()

        this.statuses = [
            { value: 'pending', label: 'Pending' },
            { value: 'approved', label: 'Approved' },
            { value: 'declined', label: 'Declined' }
        ]
    },

    watch: {
        booking: {
            immediate: true, 
            handler: function (val) {
                if (val.id) {
                    this.ghost = {
                        id: val.id,
                        code: val.code,
                        status: val.status
                    }
                }
            }
        }
    },

    computed: {
        booking () {
            return this.$store.state.booking
        },


        client () {
            return this.booking.client || {}
        },


        clientAddress () {
            return this.client.code
                ? this.client.address + ', ' + this.client.suburb + ', ' + this.client.state.toUpperCase() + ', ' + this.client.postcode
                : '--'
        },

        chef () {
            return this.booking.chef || {}
        },

        chefName () {
            return this.chef.code    
                ? this.chef.firstname + ' ' + this.chef.lastname
                : '--'
        },

        dish () {
            return this.booking.dish || {}
        },

        dishName () {
            return this.dish.code    
                ? this.dish.name
                : '--'
        },

        dishIngredients () {
            return this.dish.code    
                ? this.dish.ingredients.split(',').join(', ')
                : '--'
        }
    },

    methods: {
        /**
         ** Get tickets with pagination 
         **
         ** @param Integer {page}
         ** @return {void}
         */
        async getBooking () {
            this.isLoading = true

            let url = `/bookings/${_uuid}`
    
            const res = await axios.get(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.$store.commit('SET_BOOKING', res.data)
            }
        },

        /**
         ** Update ticket 
         **
         ** @param {Object} ticket
         ** @return {void}
         */
        async save (ticket) {
            const isValid = await this.$validator.validate()
            if (!isValid ) return false;

            this.isLoading = true

            const res = await axios.patch(`/tickets/${this.ticket.code}`, ticket)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.getTicket()
            }
        }
    }
}
</script>