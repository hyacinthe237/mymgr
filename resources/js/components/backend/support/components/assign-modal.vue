<template>
    <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="text-center" v-translate>Assign Ticket Handler</h4>

                    <form class="_form mt-40" @submit.prevent>
                        <div class="form-group">
                            <div class="field-wrapper">
                                <div class="field-placeholder">
                                    <span>{{ t('Name') }}</span>
                                </div>

                                <input 
                                    type="text"
                                    name="name"
                                    autocomplete="off" 
                                    placeholder="Filter admins"
                                    v-model="keywords"
                                >
                            </div>
                        </div>
                    </form>


                    <div class="list mt-20">
                        <div
                            v-for="item in filteredUsers"
                            :key="item.code"
                            class="list-item border-top pointer"
                            @click="toggleUser(item)"
                        >
                            <i 
                                class="feather icon-check-circle"
                                v-show="item.code == selectedUser.code"
                            ></i>
                            {{ item.firstname }} {{ item.lastname }}
                        </div>
                    </div>
                </div>

                <div class="modal-footer mt-20">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" @click="assign()">Save & Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'AssignModal',

    props: {
        user: { type: Object, default: () => {}},
        model: { type: Object, default: () => {}},
        admins: { type: Array, default: () => []},
    },

    data: () => ({
        keywords: '',
        selectedUser: {}
    }),

    watch: {
        model: {
            immediate: true,
            handler: function (val) {
                if (val && val.assignee) 
                    this.selectedUser = val.assignee
            }
        }
    },

    computed: {
        filteredUsers () {
            let filtered = this.admins.slice()
            
            if (this.keywords === '') 
                return filtered.slice(0, 10)
            
            return filtered.filter(s => {
                return (
                    s.firstname.toLowerCase().startsWith(this.keywords.toLowerCase())
                    || s.lastname.toLowerCase().startsWith(this.keywords.toLowerCase())
                )
            }).slice(0, 10)
        }
    },

    methods: {
        assign () {
            this.$emit('assigned', this.selectedUser)
            $('#assignModal').modal('hide')
        },

        toggleUser (user) {
            console.log('Toggling user ===> ', user.code, this.selectedUser.code)
            if (this.selectedUser.code === user.code)
                return this.selectedUser = {}
            this.selectedUser = user
        }
    }
}
</script>