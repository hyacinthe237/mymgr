<template>
    <div class="modal fade" tabindex="-1" role="dialog" :id="'usersModal'">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="">Add project users</h4>


                    <form class="_form mt-20" @submit.prevent="save()">
                        <div class="row">
                            <div class="col-xs-9">
                                <select class="form-control input-lg"
                                    name="user_id"
                                    v-model="ghost.user_id">
                                    <option v-for="item in allMembers" :value="item.id">{{ item.firstname + ' ' + item.lastname }}</option>
                                </select>
                            </div>

                            <div class="col-xs-3">
                                <izy-btn block :size="'lg'">Save</izy-btn>
                            </div>
                        </div>
                    </form>

                    <div class="mt-20 text-center">
                        <button class="btn btn-grey rounder" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

    data: () => ({
        usersTab: [],
        usersPublicTab: []
    }),

    props: ['allMembers', 'privateProject'],

    mounted () {
        this.getUsersTab()
        this.getNotUsersTab()
        // this.getProjectUsers()
        this.$store.commit('projects/SET_PROJECT', this.privateProject)
    },

    computed: {
        ...mapGetters('projects', {
            projectUsers: 'projectUsers'
        }),

        listUsersTab () {
            return this.usersTab.length != 0 ? this.usersTab : ''
        }
    },

    watch: {

    },

    methods: {
        /**
         * Get users from server
         */
        getProjectUsers () {
            this.$store.dispatch(`/getProjectUsers/${this.privateProject.code}`)
        },

        /*
        ** Get usersTab
         */
        async getUsersTab () {
            this.ghost.code = this.privateProject.code
            await axios.get(`/getPrivateUsers/${this.ghost.code}`)
            .then(response => {
                this.usersTab = response.data
            })
            .catch(error => console.log(error))
        },

        /*
        ** Get usersTab
         */
        async getNotUsersTab () {
            await axios.get(`/getNotPrivateUsers/${this.privateProject.code}`)
            .then(response => {
                this.usersPublicTab = response.data
            })
            .catch(error => console.log(error))
        },

        async save () {
            console.log(this.code)
            this.isloading = true
            this.ghost.code = this.privateProject.code

            const response = await axios.post('addprivate', this.ghost)
            .catch(error => {
                console.log(error);
                this.$toastr.error(error.response.data.message)
            })

            if (response) {
                this.ghost = {}
                this.$toastr.success('User successfully added')
                this.$store.dispatch('projects/getNotPrivateUsers', this.privateProject.code)
                this.$store.dispatch('projects/getProjectUsers', this.privateProject.code)
            }

            this.isLoading = false
        },

        deleting (e) {
            this.$emit('deleting-user', e)
        }
    }
}
</script>
