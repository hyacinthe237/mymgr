<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />


        <div class="row">
            <div class="col-6">
                <div class="block-container">
                    <div class="pd-20">
                        <form class="_form mb mt-10" @submit.prevent="save">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Dish name') }}</span>
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
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Serves') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="serves"
                                                autocomplete="off" 
                                                placeholder="Number of serves"
                                                v-model="ghost.serves"
                                                v-validate="'required'"
                                                class="text-center"
                                            >
                                            <izy-error :name="'serves'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Duration') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="duration"
                                                autocomplete="off" 
                                                placeholder="Duration"
                                                v-model="ghost.duration"
                                                v-validate="'required'"
                                                class="text-center"
                                            >
                                            <izy-error :name="'duration'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Cost') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="price"
                                                autocomplete="off" 
                                                placeholder="Cost"
                                                v-model="ghost.price"
                                                v-validate="'required'"
                                                class="text-center"
                                            >
                                            <izy-error :name="'price'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           


                            <div class="text-right">
                                <button
                                    class="btn btn-primary w-150"
                                    :disabled="isLoading"
                                    type="submit"
                                >{{ isLoading ? 'Loading...' : 'Save Dish' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="col-6">
                <div class="block-container">
                    <div class="pd-20">
                        <img :src="model.photo" class="img-fluid"/>


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
    
            let url = `/dishes/${_uuid}`
    
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
            this.showErrors = true

            const isValid = await this.$validator.validate()
            if (!isValid ) return false;
    
            let url = `/dishes/${_uuid}`
    
            const res = await axios.patch(url, this.ghost)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.getModel()
                this.$toastr.success('Update successful', 'The dish has been successfully updaed')
            }
        },


        async saveImage (base64) {
            this.isLoading = true
    
            let url = `/dishes/${_uuid}/image`
    
            const res = await axios.patch(url, { image: base64 })
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.getModel()
                this.$toastr.success('Update successful', 'The dish photo has been successfully updaed')
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
                    console.log('dropzone success ==> ', file)
                    self.saveImage(file.dataURL)
                }
            }
        },


        async uplaod () {
            console.log('Uploading....')
        }
    }
}
</script>