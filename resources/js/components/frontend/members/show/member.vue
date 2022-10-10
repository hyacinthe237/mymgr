<template>
    <div class="">
        <section class="content-body pt-20">
            <div class="row">
                <div class="col-sm-4">
                    <div class="_block _block-radius">
                        <div class="_block-content">
                            <div class="profile-picture">
                                <img :src="photo" class="img-responsive">
                            </div>

                            <div class="pt-20 text-center" v-if="isProfile">
                                <button class="btn btn-dark" @click="showUpload()">
                                    <i class="ion-camera"></i> Change picture
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-8">
                    <div class="">
                        <div class="_block _block-radius">
                            <div class="_block-content">
                                <ProfileForm :user="ghost" :userconnect="userconnect" ref="profileform" @save="saveData('profileform', $event)"></ProfileForm>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <commons-upload
                :uploadUrl="uploadUrl"
                @uploaded="uploaded"
                :title="'Upload photo'"
                :maxFiles="1"
                :acceptedFiles="'image/*'">
            </commons-upload>

            <deleteModal @confirmed="confirmDeleteUser"></deleteModal>
            <blockModal @blocked="confirmBlockUser"></blockModal>
        </section>

        <div class="clearfix"></div>
        <section class="content-body pt-20">
            <div class="row">
                <div class="col-sm-4"></div>

                <div class="col-sm-8">
                    <div class="">
                        <h5>Change password</h5>
                        <div class="_block _block-radius">
                            <div class="_block-content">
                                <PasswordForm :user="ghost" ref="passwordform" @save="saveData('passwordform', $event)"></PasswordForm>
                            </div>
                        </div>
                    </div>

                    <div class="mt-20" v-if="isProfile">
                        <a @click.prevent="showBlockModal()" class="btn btn-dark">
                            <i></i>
                            Block
                        </a>

                        <a @click.prevent="showDeleteModal()" class="btn btn-danger">
                            <i></i>
                            Delete
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'

import ProfileForm from '../forms/profile'
import PasswordForm from '../forms/password'

import deleteModal from '../modals/delete'
import blockModal from '../modals/block'

export default {
    props: {
        member: {
            type: Object,
            default: () => {}
        },

        userconnect: {
            type: Object,
            default: () => {}
        },

        organization: {
            type: Object,
            default: () => {}
        },

        isProfile: {
            type: Boolean,
            default: false
        }
    },

    components: { ProfileForm, PasswordForm, deleteModal, blockModal },

    mounted () {
        this.uploadUrl = '/uploads/members/' + this.member.code
        this.$store.commit('members/SET_MEMBER', this.member)
    },

    data: () => ({
        uploadUrl: '',
        showBtn: true
    }),

    watch: {
        user (val) {
            this.ghost = _.cloneDeep(val)
        }
    },

    computed: {
        photo () {
            if (this.ghost.photo) return this.ghost.photo
            return '/assets/images/default-user.png'
        },

        ...mapGetters('members', {
            user: 'member'
        })
    },

    methods: {
        async saveData(form,user) {
            let isvalid = false

            isvalid = await this.$refs[form].validateForm()

            if (!isvalid ) return false;

            this.$refs[form].startLoading()

            const response = await axios.put('/users/' + this.ghost.id, user)
            .catch(error => {
                console.log(error);
                return this.$swal.error(error.response.data)
            })

            if (response) {
                // this.ghost = response.data
                this.$store.commit('members/SET_MEMBER', response.data)
                this.$toastr.success('Member profile updated !')
                this.$refs[form].stopLoading()
            }

        },

        async confirmDeleteUser () {
          if(!this.isLoading) {
            this.isLoading = true

            try {
                const response = await axios.delete('users/' + this.user.id)
                if (response) {
                    this.$swal.success("Operation successful")
                    window.location = '/members/'
                }
            } catch (e) {
                this.$swal.error(e.response.data)
            }

            this.isLoading = false
          }
        },

        showDeleteModal () {
          setTimeout(() => {
               window.$('#deleteUserConfirm').modal({ show: true })
           }, 250)
        },

        showBlockModal () {
          setTimeout(() => {
               window.$('#blockUserConfirm').modal({ show: true })
           }, 250)
        },

        async confirmBlockUser () {
          if (!this.isLoading) {
            this.isLoading = true

            try {
                const response = await axios.get('/users/' + this.user.id + '/blocked')
                if (response) {
                    this.$swal.success("User successfully blocked")
                    this.closeAllModals()
                }
            } catch (e) {
                this.$swal.error(e.response.data)
            }

            this.isLoading = false
          }

      },

        /**
         * Show file upload modal
         */
        showUpload () {
            window.$('#uploadModal').modal('show')
        },

        uploaded (e) {
            this.$store.dispatch('members/getOne', this.member.id)
        }
    }
}
</script>
