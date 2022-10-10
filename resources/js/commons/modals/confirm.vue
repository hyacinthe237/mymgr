<template>
    <izy-modal :id="'confirmModal'">

        <h4 v-html="message"></h4>

        <div class="mt-20">
            <button class="btn btn-md btn-teal" data-dismiss="modal">
                Cancel
            </button>

            <button class="btn btn-md btn-danger pull-right" @click="confirm()">
                {{ confirmMessage }}
            </button>
        </div>
    </izy-modal>
</template>

<script>
export default {
    name: 'confirm-modal',
    props: {
        showConfirm: {
            type: Boolean,
            default: true
        },

        confirmMessage: {
            type: String,
            default: 'Confirm'
        },

        message: {
            type: String,
            default: 'Are you sure you want to continue?'
        },
    },


    methods: {
        confirm () {
            this.$emit('confirmed')
            this.closeModal('categoryRemove')
            this.closeModal('userRemove')
        }
    }
}
</script>
