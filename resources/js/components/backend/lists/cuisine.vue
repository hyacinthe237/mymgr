<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />


        <div class="row">
            <div class="col-6">
                <div class="block-container">
                    <div class="pd-20">
                        <form class="_form mb mt-10" @submit.prevent="save">
                            <div class="form-group">
                                <div class="field-wrapper">
                                    <div class="field-placeholder">
                                        <span>{{ t('Cuisine name') }}</span>
                                    </div>

                                    <input 
                                        type="text"
                                        name="name"
                                        autocomplete="off" 
                                        placeholder="Cuisine name"
                                        v-model="ghost.name"
                                        v-validate="'required|min:2'"
                                    >
                                    <izy-error :name="'name'" :show="showErrors" :err="errors"/>
                                </div>
                            </div>


                            <div class="text-right">
                                <button
                                    class="btn btn-primary w-150"
                                    :disabled="isLoading"
                                    type="submit"
                                >{{ isLoading ? 'Loading...' : 'Save Cuisine' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-6">
                <div class="block-container">
                    <div class="pd-20">
                        <img :src="model.cover" class="img-fluid"/>


                        <div class="text-right mt-20">
                            <vue-dropzone 
                                ref="myVueDropzone" 
                                id="dropzone" 
                                :options="dropzoneOptions" 
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'

export default {
    name: 'admin-cuisine',

    components: {
        vueDropzone: vue2Dropzone
    },

    data: () => ({
        model: {},
        dropzoneOptions: {}
    }),

    created () {
        this.setupDropzone()
    },


    mounted () {
        this.getModel()
    },


    methods: {
        async getModel () {
            this.isLoading = true
    
            let url = `/cuisines/${_uuid}`
    
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


        async save () {
            this.isLoading = true
    
            let url = `/cuisines/${_uuid}`
    
            const res = await axios.patch(url, this.ghost)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.getModel()
                this.$toastr.success('Update successful', 'The cuisine has been successfully updaed')
            }
        },


        setupDropzone () {
            const self = this

            this.dropzoneOptions = {
                dictDefaultMessage: this.$translate.text('Click or Drop a file here to upload (Max: 5MB)'),
                url: '/api/v1/upload',
                thumbnailWidth: 180,
                uploadMultiple: true,
                acceptedFiles: ".png,.jpg,.jpeg",
                paramName: 'file',
                addRemoveLinks: false,
                maxFilesize: 5,
                maxFiles: 1,
                timeout: 0,
                headers: {
                    'Authorization': 'Bearer ' + _auth
                },
                sending: () => {
                    self.isLoading = true
                },
                complete: (file) => {
                    self.isLoading = false
                    self.$refs.myVueDropzone.removeFile(file)
                },
                success: function (file, response) {
                    self.$set(self.ghost, 'cover', response)
                    self.save()
                }
            }
        },


        async uplaod () {
            console.log('Uploading....')
        }
    }
}
</script>