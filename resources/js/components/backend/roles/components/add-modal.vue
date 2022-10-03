<template>
    <div class="modal fade" id="addDocModal" tabindex="-1" role="dialog" aria-labelledby="addRoleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="text-center">Add document for {{ r.name }}</h4>


                    <form class="_form mt-20" @submit.prevent>
                        <div class="form-group">
                            <div class="field-wrapper">
                                <div class="field-placeholder">
                                    <span>{{ t('Name') }}</span>
                                </div>

                                <input 
                                    type="text"
                                    name="name"
                                    autocomplete="off" 
                                    placeholder="Document name"
                                    v-model="ghost.name"
                                >
                            </div>
                        </div>

                         <div class="mt-20 text-right">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                            <button 
                                class="btn btn-primary" 
                                :disabled="isLoading"
                                @click="save()"
                            >Save Document</button>
                        </div>
                    </form>                    
                </div>

               
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AddDocModal',

    props: {
        r: { type: Object, default: () => {}}
    },

    methods: {
        close () {
            $('#addDocModal').modal('hide')
        },

        async save () {
            this.isLoading = true

            let url = `/roles/documents`
            this.ghost.role_id = this.r.id
    
            const res = await axios.post(url, this.ghost)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$toastr.error(message)
                })

            this.isLoading = false

            if (res) {
                this.$emit('getRoles')
                this.$set(this.ghost, 'name', '')
                this.$toastr.success('Document successfully added')
                this.close()
            }
        }
    }
}
</script>