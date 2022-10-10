<template>
    <div class="modal fade" tabindex="-1" role="dialog" id="newProjectModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form class="_form mt-10" @submit.prevent="save()">

                        <div class="form-group">
                            <label>Project title</label>
                            <input type="text"
                                name="title"
                                v-model="ghost.title"
                                v-validate="'required|min:3'"
                                placeholder="Project title"
                                class="form-control input-lg">
                        </div>


                        <div class="mt-10 pb-10 text-right">
                            <a class="btn btn-grey btn-md" data-dismiss="modal">Cancel</a>

                            <izy-btn :loading="isLoading">
                                <i class="ion-android-done-all"></i>
                                Continue
                            </izy-btn>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'project-create',

    methods: {

        async save () {
            const isvalid = await this.validateForm()
            if (!isvalid ) return false;

            this.isLoading = true
            const response = await axios.post('/projects', this.ghost)
            .catch(error => {
                console.log(error);
                this.$swal.error(error.response.data)
            })

            if (response) {
                window.location = '/projects/' + response.data.code + '/edit'
            }

            this.isLoading = false
        }
    }
}
</script>
