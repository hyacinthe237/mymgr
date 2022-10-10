<template>
   <section class="content-body">
        <div class="blocks-items mt-20">

            <!--block de l'organisation nouvellement creer -->
            <div class="block-item">
                 <form class="_form mt-10" @submit.prevent="create()">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                 <input type="text"
                                        name="name"
                                        placeholder="Please fill name here"
                                        class="form-control input-lg"
                                        v-model="ghost.name"
                                        v-validate="'required'"
                                        :disabled="!show">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="official_name">Official Name</label>
                                <input type="text"
                                        name="official_name"
                                        placeholder="Please fill Official Name  here"
                                        class="form-control input-lg"
                                        v-model="ghost.official_name"
                                        v-validate="'required'"
                                        :disabled="!show">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text"
                                        name="address"
                                        placeholder="Please fill address here"
                                        class="form-control input-lg"
                                        v-model="ghost.address"
                                        v-validate="'required'"
                                        :disabled="!show">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text"
                                        name="phone"
                                        placeholder="Please fill phone here"
                                        class="form-control input-lg"
                                        v-model="ghost.phone"
                                        :disabled="!show">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right mt-20">
                        <izy-btn :loading="isLoading" elevated :disabled="!show">
                            <i class="ion-android-done-all"></i>
                            Save Organisation
                        </izy-btn>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'organization-create',
    props: {
        adminId: Number ,
        organization: Object ,
        user: Object ,
    },

    data: () => ({
        show: false
    }),

    mounted() {
        this.checkID()
        this.ghost = this.organization
    },

    methods: {
        async create () {
            if (!this.show) return false;

            const isvalid = await this.validateForm()
            if (!isvalid ) return false;

            this.isLoading = true

             const response = await axios.put('/organizations/'+this.ghost.id, this.ghost)
             .catch(error => {
                 console.log(error);
                 this.$swal.error(error.response.data)
             })

             if (response) {
                 this.$toastr.success('Organization successfully updated')
             }

             this.isLoading = false
        },

        checkID () {
            this.show = this.user.id === this.adminId
        }
    }
}
</script>
