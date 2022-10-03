<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />

        
        <div class="row">
            <div class="col-6">
                <div class="block-container">
                    <div class="pd-20">
                        <a class="float-right" :href="'/admin/acl/users/' + chef.code">
                            <i class="feather icon-external-link"></i>
                        </a>
                        <h4 class="">Chef Details</h4>

                        <table class="table table-striped mt-20">
                            <tbody>
                                <tr>
                                    <td class="text-right teal">Balance</td>
                                    <td>{{ balance | aud }}</td>
                                </tr>
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


            <div class="col-6">
                <div class="block-container">
                    <div class="pd-20">
                        <h4>Withdrawal details</h4>

                        <table class="table table-striped mt-20">
                            <tbody>
                                <tr>
                                    <td class="text-right teal">Amount</td>
                                    <td>{{ model.amount | aud }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Date Requested</td>
                                    <td>{{ model.created_at | datetime }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right teal">Status</td>
                                    <td class="capitalize">{{ model.status }}</td>
                                </tr>
                            </tbody>
                        </table>


                        <div class="mt-20 text-right">
                            <button
                                class="btn btn-secondary mr-10"
                                @click="confirmDeny()"
                                :disabled="!isPending"
                            >Deny</button>

                            <button
                                class="btn btn-primary"
                                @click="confirmApprove()"
                                :disabled="!isPending"
                            >Approve</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import Swal from 'sweetalert2'

export default {
    name: 'AdminWithdrawal',

    data: () => ({
        model: {},
    }),


    mounted () {
        this.getModel()
    },


    computed: {
        chef () {
            return this.model.user || {}
        },

        balance () {
            return this.chef.balance || 0
        },

        isPending () {
            return this.model.status === 'pending'
        }
    },

    methods: {
        async getModel () {
            this.isLoading = true
    
            let url = `/withdrawals/${_uuid}`
    
            const res = await axios.get(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.model = res.data
                this.$store.commit('SET_MODEL', res.data)
                this.$set(this, 'ghost', res.data)
            }
        },


        /**
         * Deny withdrawal
         * 
         * @return {void}
         */
        confirmDeny () {
            console.log('confirm deny ============== ')
            const _that = this

            Swal.fire({
                title: 'Are you sure you want to deny this withdrawal',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Not sure',
                confirmButtonText: 'Yes, deny withdrawal!'
            }).then((result) => {
                if (result.isConfirmed) {
                    _that.denyWithdrawal()
                }
            })
        },


        async denyWithdrawal () {
            console.log('Denying requrest..................')
            this.ghost.status = 'denied'
            this.updateWithdrawal()
        },


        /**
         * Approve withdrawal 
         * 
         * @return {void}
         */
        confirmApprove () {
            console.log('confirm approve ============== ')
            const _that = this

            Swal.fire({
                title: 'Are you sure you want to approve this withdrawal',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Not sure',
                confirmButtonText: 'Yes, approve withdrawal!'
            }).then((result) => {
                if (result)
                    _that.approveWithdrawal()
            })
        },


        async approveWithdrawal () {
            console.log('Approving requrest..................')
            this.ghost.status = 'approved'
            this.updateWithdrawal()
        },


        /**
         * Update withdrawal 
         * 
         * @return {void}
         */
        async updateWithdrawal () {
            console.log('updating withdrawal =======================')
            
            this.isLoading = true
    
            let url = `/withdrawals/${_uuid}`

            const payload = {
                code: this.ghost.code,
                status: this.ghost.status
            }
    
            const res = await axios.patch(url, payload)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.model = res.data
                this.$store.commit('SET_MODEL', res.data)
                this.$set(this, 'ghost', res.data)
            }
        }
    }
}
</script>