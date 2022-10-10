<template>
    <div class="">
        <ul class="list-inline attachments-list mt-20">
            <li v-for="f in files">
                <span class="_delete" @click="deleteFile(f)">
                    <i class="ion-android-delete"></i>
                </span>
                <a :href="f.link" target="_blank">
                    {{ f.name }}
                </a>
            </li>
        </ul>




        <izy-modal :id="'deleteFileModal'">

            <h4 >Are you sure you want to delete the attachment:</h4>

            <strong>{{ deletingFile.name }}</strong>


            <div class="mt-20">
                <button class="btn btn-md btn-teal" data-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-md btn-danger pull-right" @click="deleteFileConfirmed()">
                    Delete permanently
                </button>
            </div>
        </izy-modal>

    </div>

</template>

<script>
export default {
    props: ['files', 'ticket'],

    data: () => ({
        deletingFile: {},
    }),

    methods: {
        async deleteFileConfirmed () {
            const file = this.deletingFile
            let url = 'tickets/' + this.ticket.number + '/remove/attachments/' + file.code

            const response = await axios.get(url)
            .catch(error => {
                this.$swal.error(error.response.data.message)
            })

            if (response) {
                this.$toastr.success('File successfully deleted')
                this.closeModal('deleteFileModal')
                this.$emit('fileDeleted')
            }
        },

        deleteFile (file) {
            this.deletingFile = Object.assign({}, file)
            this.openModal({ id: 'deleteFileModal' })
        },
    }
}
</script>
