<template>
    <form class="_form mt-10" @submit.prevent="save()">

        <h5 class="text-center teal mt-20">New organization</h5>

        <div class="form-group">
            <label>Organization name</label>
            <input type="text"
                name="name"
                placeholder="Organization name"
                class="form-control input-lg"
                v-model="ghost.name"
                v-validate="'required|min:2'">
        </div>

        <div class="form-group">
            <label>Official name</label>
            <input type="text"
                name="official_name"
                placeholder="Official name"
                class="form-control input-lg"
                v-model="ghost.official_name"
                data-vv-as="'Official name'"
                v-validate="'required|min:2'">
        </div>


        <div class="form-group">
            <label>Address</label>
            <input type="text"
                name="address"
                placeholder="Address"
                class="form-control input-lg"
                v-model="ghost.address">
        </div>


        <div class="form-group">
            <label>Phone</label>
            <input type="text"
                name="phone"
                placeholder="Phone"
                class="form-control input-lg"
                v-model="ghost.phone">
        </div>


        <div class="mt-20 text-center">
            <izy-btn :loading="isLoading" block elevated>
                <i class="ion-android-done-all"></i>
                Continue
            </izy-btn>
        </div>

    </form>
</template>

<script>
export default {
    name: 'auth-organization-select',

    methods: {
        async save () {
            const isvalid = await this.validateForm()

            if (isvalid) {
                this.isLoading = true

                try {
                    const response = await axios.post('/organizations', this.ghost)
                    if (response) {
                        window.location = '/organizations/' + response.data.code + '/set'
                    }
                } catch (e) {
                    this.$swal.error(e.response.data)
                }

                this.isLoading = false
            }
        }
    }
}
</script>
