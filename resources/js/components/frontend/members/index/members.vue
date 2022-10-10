<template>
    <div class="">
        <div class="content-title">
            <div class="row">
                <div class="col-sm-6">
                    Members
                </div>

                <div class="col-sm-6">
                    <div class="content-title">
                        <button class="btn btn-primary btn-md pull-right elevated" @click="showInvite()">
                            <i class="ion-android-person-add mr-10"></i> Invite
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-12" id="bc">

            </div>
        </div>

        <section class="content-body">
            <div class="mt-60" v-show="isLoading">
                <circle-loader></circle-loader>
            </div>

            <div class="blocks-team-items mt-20">
                <div class="row">
                    <div class="col-sm-3" v-for="m in members">
                        <Member :member="m" @activate="activate"></Member>
                    </div>
                </div>
            </div>
        </section>

        <InviteModal></InviteModal>
        <ActivateModal @activated="confirmActivateUser()"></ActivateModal>
    </div>
</template>

<script>
import Member from './member'
import InviteModal from './invite'
import ActivateModal from '../modals/activate'

export default {
    name: 'members',
    components: { Member, InviteModal, ActivateModal },

    data: () => ({
        members: [],
        invitations: [],
        currentMember: {}
    }),

    props: {
        breadcrumbs: {
            type: String,
            default: ''
        },
    },

    mounted () {
        this.getMembers()
    },

    methods: {
        showInvite () {
            this.openModal({ id: 'inviteModal' })
        },

        async getMembers () {
            this.startLoading()

            const response = await axios.get('members')
            .catch(error => console.log(error))

            this.members = response.data.members
            this.invitations = response.data.invitations

            this.stopLoading()
        },

        activate (e) {
            this.currentMember = e
            setTimeout(() => {
                 window.$('#activateUserConfirm').modal({ show: true })
             }, 350)
        },

        async confirmActivateUser () {
            await axios.get('/users/' + this.currentMember.id + '/blocked')
            .catch(error => {
                this.$swal.error(e.response.data)
            })
            .then(response => {
                this.$swal.success("Operation successful")
                this.closeAllModals()
                this.getMembers()
            })
        }
    }

}
</script>
