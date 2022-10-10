<template>
    <izy-modal :id="'inviteModal'">
        <h5 class="bold">Invite member to join {{ organization.name }}</h5>


        <form class="_form mt-20" @submit.prevent>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>First name *</label>
                        <input type="text"
                            name="firstname"
                            placeholder="First name"
                            class="form-control input-lg"
                            v-model="ghost.firstname"
                            data-vv-as="'First name'"
                            v-validate="'required|min:2'">
                            <span class="has-error">{{ errors.first('firstname') }}</span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Last name *</label>
                        <input type="text"
                            name="lastname"
                            placeholder="Last name"
                            class="form-control input-lg"
                            v-model="ghost.lastname"
                            data-vv-as="'Last name'"
                            v-validate="'required|min:2'">
                            <span class="has-error">{{ errors.first('lastname') }}</span>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email"
                            name="email"
                            placeholder="Email"
                            class="form-control input-lg"
                            v-model="ghost.email"
                            v-validate="'required|email'">
                            <span class="has-error">{{ errors.first('email') }}</span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text"
                            placeholder="Mobile phone"
                            class="form-control input-lg"
                            v-model="ghost.phone">
                    </div>
                </div>
            </div>

            <div class="mt-20">
                <button class="btn btn-md btn-teal" data-dismiss="modal">
                    Cancel
                </button>

                <izy-btn :loading="isLoading"
                    @clicked="invite()"
                    :class="'pull-right'">
                    <i class="ion-android-done-all"></i>
                    Send Invitation
                </izy-btn>

            </div>
        </form>

    </izy-modal>
</template>

<script>
export default {

    data () {
        return {
            organization: {}
        }
    },

    mounted () {
        this.organization = _org
    },

    methods: {
        async invite () {
            const isValid = await this.$validator.validate()
            if (!isValid ) return false;

            this.isLoading = true

            const response = await axios.post('/invitations', this.ghost)
            .catch(error => {
                this.$toastr.error(error.response.data.message)
            })

            this.isLoading = false

            if (response) {
                this.$swal.success('Invitation successfully sent!')
                this.closeModal('inviteModal')
            }
        }
    }
}
</script>
