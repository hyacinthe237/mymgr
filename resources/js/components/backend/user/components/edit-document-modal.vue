<template>
    <div class="modal fade" id="editDocModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center">Edit {{ doc.name }}</h2>

                    <form class="_form mt-40" @submit.prevent>
                        <div class="form-group">
                            <div class="field-wrapper">
                                <div class="field-placeholder">
                                    <span>{{ t('Status') }}</span>
                                </div>
                                
                                <select name="role" v-model="ghost.status">
                                    <option 
                                        v-for="(r, index) in statuses"
                                        :key="index + 1"
                                        :value="r" v-translate
                                    >{{ r | capitalize }}</option>
                                </select>
                            </div>
                        </div>
                    </form>

                    <div class="mt-40 text-right">
                        <button type="button" 
                            class="btn btn-outline-primary" 
                            data-dismiss="modal"
                        >Cancel</button>

                        <button 
                            type="button" 
                            class="btn btn-primary w-150" 
                            @click="save()"
                            :disabled="isLoading"
                        >{{ isLoading ? 'Saving...' : 'Save'}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'EditDocModal',

    props: {
        doc: { type: Object, default: () => {}}
    },

    data: () => ({
        ghost: {
            status: ''
        },

        statuses: ['pending', 'approved', 'rejected']
    }),

    watch: {
        doc: {
            immediate: true,
            handler: function (val) {
                if (val.code) {
                    this.$set(this.ghost, 'status', val.status)
                }
            }
        }
    },

    methods: {
        confirm () {
            this.$emit('confirmed')
            $('#editDocModal').modal('hide')
        },

        async save () {
            this.isLoading = true

            let url = `/users/${_uuid}/documents/${this.doc.code}`

            const res = await axios.patch(url, this.ghost)
                .catch(e => this.catchAlert(e))

            this.isLoading = false

            if (res) {
                this.$toastr.success('Document successfully updated')
                this.confirm()
            }
        }
    }
}
</script>