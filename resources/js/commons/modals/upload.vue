<template>
    <izy-modal :id="'uploadModal'">
        <div class="form-group">
            <label>{{ title }}</label>

            <vue-dropzone
                ref="dropzone"
                v-if="dropOptions.url"
                @vdropzone-complete="fileUploaded"
                id="attachments" :options="dropOptions">
            </vue-dropzone>
        </div>


        <div class="mt-10 pb-10 text-right">
            <button class="btn btn-success btn-md" @click="removeAllFiles()">
                <i class="ion-close-circled"></i>
                Remove all files
            </button>

            <button class="btn btn-primary btn-md" @click="close()">
                <i class="ion-android-done-all"></i>
                Finish
            </button>
        </div>
    </izy-modal>
</template>

<script>
import vueDropzone from "vue2-dropzone"

export default {
    name: 'upload',

    props: {
        title: {
            type: String,
            default: 'Upload attachments'
        },

        uploadUrl: {
            type: String,
            default: '/'
        },

        maxFilesize: {
            type: Number,
            default: 2
        },

        maxFiles: {
            type: Number,
            default: 10
        },
        acceptedFiles: {
            type: String,
            default: null
        }
    },

    components: { vueDropzone },

    data: () => ({
        dropOptions: {}
    }),

    mounted () {
        this.$nextTick(() => {
            this.dropOptions = {
                url: this.uploadUrl,
                maxFilesize: this.maxFilesize,
                maxFiles: this.maxFiles,
                acceptedFiles: this.acceptedFiles,
                chunking: false,
                chunkSize: 5000, // Bytes
                thumbnailWidth: 100, // px
                thumbnailHeight: 100,
                addRemoveLinks: true,
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content
                }
            }
        })
    },

    methods: {
        /**
         * Remove files from dropzone
         */
        removeAllFiles() {
            this.$refs.dropzone.removeAllFiles();
        },

        /**
         * Close modal
         */
        close () {
            this.removeAllFiles()
            window.$('.modal').modal('hide')
        },

        fileUploaded (file) {
            this.$emit('uploaded', file)
        }
    }
}
</script>
