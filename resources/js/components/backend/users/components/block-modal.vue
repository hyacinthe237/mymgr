<template>
    <div class="modal fade" id="blockConfirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h2 class="text-center" v-translate>Block User</h2>

                    <h5 class="mt-20">
                        Are you sure you want to block {{ user.firstname }} {{ user.lastname }}?
                    </h5>
                </div>

                <div class="modal-footer mt-20">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" @click="confirm()">Yes, Block User</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'BlockConfirmModal',

    props: {
        user: { type: Object, default: () => {}}
    },

    methods: {
        confirm () {
            this.$emit('confirmed')
            $('#blockConfirmModal').modal('hide')
        }
    }
}
</script>