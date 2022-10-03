<template>
    <div class="modal fade" id="editDocModal" tabindex="-1" role="dialog" aria-labelledby="editDocModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="text-center" v-translate>Edit Document</h4>


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
    name: 'editDocModal',

    props: {
        doc: { type: Object, default: () => {}}
    },

    data: () => ({
        ghost: {
            name: ''
        }
    }),

    watch: {
        doc: {
            immediate: true,
            handler: function (val) {
                if (val) {
                    this.$set(this.ghost, 'name', val.name)
                }
            }
        }
    },

    methods: {
        close () {
            $('#editDocModal').modal('hide')
        },

        async save () {
            this.isLoading = true

            let url = `/documents/${this.doc.code}`
    
            const res = await axios.patch(url, this.ghost)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$toastr.error(message)
                })

            this.isLoading = false

            if (res) {
                this.$emit('getRoles')
                this.$set(this.ghost, 'name', '')
                this.$toastr.success('Document successfully updated')
                this.close()
            }
        }
    }
}
</script>