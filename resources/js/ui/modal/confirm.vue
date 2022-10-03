<template>
    <div class="modal fade" tabindex="-1" role="dialog" :id="id">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="text-center">{{ title }}</h4>

                    <h5 class="mt-10">{{ confirmMessage }}</h5>

                    <div class="mt-20 text-right">
                        <button 
                            type="button" 
                            class="btn btn-outline-primary" 
                            data-dismiss="modal"
                        ><i class="feather icon-x"></i> {{ cancelButton }}</button>
                        
                        <button 
                            class="btn btn-danger" 
                            @click="confirm()"
                        ><i class="feather icon-check"></i> {{ confirmButton }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            default: 'confirmModal',
        },

        title: { type: String, default: 'Confirmation'},
        cancelButton: { type: String, default: 'Cancel'},
        confirmButton: { type: String, default: 'Confirm'},
        confirmMessage: { type: String, default: 'Are you sure you want to continue?'},
    },

    methods: {
        confirm () {
            this.$emit('confirmed')
            this.closeModal(this.id)
        },
    }
}
</script>
