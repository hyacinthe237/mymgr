<template>
    <section class="content-body pt-20">
        <div class="_block _block-radius">
            <div class="_block-content">
                <form class="_form mt-10" @submit.prevent>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title"
                                    v-model="ghost.title"
                                    v-validate="'required|min:3'"
                                    class="form-control input-lg">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Visibility</label>
                                <select class="form-control input-lg"
                                    name="is_public"
                                    v-model="ghost.is_public">
                                    <option v-for="item in visibilities" :value="item.id">{{ item.label }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control input-lg"
                                    name="status"
                                    v-model="ghost.status">
                                    <option v-for="item in statuses" :value="item">{{ item }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Project owner</label>
                                <select class="form-control input-lg"
                                    name="owner_id"
                                    v-model="ghost.owner_id">
                                    <option v-for="item in users" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-10">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control input-lg"
                                    name="category_id"
                                    v-model="ghost.category_id">
                                    <option v-for="item in categories" :value="item.id">{{ item.name }}</option>
                                </select>
                            </div>

                            <div class="fs-15 bold">
                                <a href="" @click="showCategories">
                                    <i class="ion-ios-keypad"></i> Categories
                                </a>
                            </div>
                        </div>

                         <div class="col-sm-3">
                            <div class="form-group">
                                <label>Slack channel</label>
                                <input type="text" name="slack_channel"
                                    v-model="ghost.slack_channel"
                                    class="form-control input-lg">
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <label>Start date</label>
                            <izy-datepicker format="DD/MM/YYYY"
                                :classDesign="'form-control input-lg'"
                                :disable-passed-days="false"
                                :initial-date="startDate"
                                :id="'startDate'"
                                :placeholder="'Start date'"
                                @changed="startDateChanged"
                                :name="'start_date'">
                            </izy-datepicker>
                        </div>

                        <div class="col-sm-3">
                            <label>Due date</label>
                            <izy-datepicker format="DD/MM/YYYY"
                                :classDesign="'form-control input-lg'"
                                :disable-passed-days="false"
                                :initial-date="endDate"
                                :id="'endDate'"
                                :placeholder="'Due date'"
                                @changed="endDateChanged"
                                :name="'end_date'">
                            </izy-datepicker>
                        </div>

                    </div>

                    <div class="row mt-10" v-if="checkId">
                        <div class="col-sm-12">
                            <div class="fs-15">
                                <a href="" @click="showUsers">
                                    <i class="ion-android-people"></i> Users
                                </a>
                            </div>

                            <ul class="list-inline project-users mt-10">
                                <li v-for="u in projectUsers" :key="u.id" @click="setDeletingUser(u)">
                                    <i class="ion-close"></i>
                                    {{ u.firstname }}
                                </li>

                                <li @click="showUsers">
                                    <i class="ion-plus"></i> Add
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group mt-20">
                        <label>Project Description</label>
                        <izy-textarea v-model="ghost.description" :placeholder="'Project description'"></izy-textarea>
                    </div>


                    <div class="form-group mt-40">
                        <label>Project Objectives</label>
                        <izy-textarea v-model="ghost.goal" :placeholder="'Project objectives'"></izy-textarea>
                    </div>

                    <div class="clearfix"></div>



                    <div class="attachments">
                        <h5 class="bold">
                            <i class="ion-android-attach mr-5"></i> Attachments
                        </h5>

                        <button class="btn btn-teal" @click="showUpload()">
                            <i class="ion-android-upload"></i> Upload file
                        </button>

                        <Files
                            :files="files"
                            :project="project"
                            @fileDeleted="refreshProject">
                        </Files>
                    </div>


                    <div class="mt-10 text-right">
                        <izy-btn :loading="isLoading" @clicked="save()">
                            <i class="ion-android-done-all"></i>
                            Save
                        </izy-btn>
                    </div>

                </form>

            </div>
        </div>

        <CategoriesModal @deleting-category="setDeletingCategory"></CategoriesModal>
        <UsersModal @deleting-user="setDeletingUser" :allMembers="projectNonUsers" :privateProject="project"></UsersModal>

        <commons-confirm
            @confirmed="deleteCategory()"
            :confirmMessage="'Delete permanently'"
            :message="'Are you sure you want to delete this category'"
            id="categoryRemove"
            :category="deletingCategory">
        </commons-confirm>

        <commons-confirm
            @confirmed="removeUser()"
            :confirmMessage="'Remove permanently'"
            :message="'Are you sure you want to remove this user?'"
            :id="'userRemove'"
            :member="deletingUser">
        </commons-confirm>

        <commons-upload
            :uploadUrl="uploadUrl"
            @uploaded="refreshProject"
            :title="'Upload attachments'"
            :maxFiles="1">
        </commons-upload>
    </section>
</template>

<script>
import moment from 'moment'
import { mapGetters } from 'vuex'
import CategoriesModal from './categories/categories'
import UsersModal from './categories/users'
import Files from './files/files'

export default {
    name: 'edit',
    props: ['project', 'users', 'connected'],
    components: { CategoriesModal, UsersModal, Files },

    data: () => ({
        visibilities: [{ id: 0, label: 'Private'}, { id: 1, label: 'Public' }],
        statuses: ['pending', 'active', 'canceled', 'complete'],
        startDate: {},
        endDate: {},
        uploadUrl: '',
        deletingCategory: {},
        deletingUser: {},
        allMembers: {},
        usersPublic: {},
        isAdmin: false
    }),

    mounted () {
        this.ghost = Object.assign({}, this.project)
        this.uploadUrl = '/uploads/project/' + this.project.code
        this.makeDates()
        this.getCategories()
        this.getUsers()
        this.getNonPrivateUsers()
        this.$store.commit('projects/SET_PROJECT', this.project)
    },

    computed: {
        ...mapGetters('categories', {
            categories: 'projectCategories'
        }),

        ...mapGetters('projects', {
            projectUsers: 'projectUsers'
        }),

        ...mapGetters('projects', {
            projectNonUsers: 'projectNonUsers'
        }),

        ...mapGetters('projects', {
            files: 'files'
        }),

        checkId () {
            return this.project.organization.admin_id === this.connected.id
        }
    },

    methods: {
        /**
         * Save editing project
         */
        async save () {
            const isvalid = await this.validateForm()
            if (!isvalid ) return false;

            this.isLoading = true
            const response = await axios.put('/projects/' + this.ghost.code, this.ghost)
            .catch(error => {
                this.$swal.error(error.response.data.message)
            })

            if (response) {
                this.$toastr.success('Project successfully updated')
            }

            this.isLoading = false
        },

        async getNotUsersTab () {
            await axios.get(`/getNotPrivateUsers/${this.privateProject.code}`)
            .then(response => {
                this.usersPublic = response.data
            })
            .catch(error => console.log(error))
        },

        /**
         * Get categories from server
         */
        getCategories () {
            this.$store.dispatch('categories/getProjectCategories')
        },

        /**
         * Get users from server
         */
        getUsers () {
            this.$store.dispatch('projects/getProjectUsers', this.project.code)
        },

        /**
         * Get nonPrivateUsers from server
         */
        getNonPrivateUsers () {
            this.$store.dispatch('projects/getNotPrivateUsers', this.project.code)
        },


        /**
         * Build dates from project dates
         */
        makeDates () {
            if (this.project.start_date) {
                this.startDate = moment(this.project.start_date)
            }

            if (this.project.end_date) {
                this.endDate = moment(this.project.end_date)
            }
        },

        startDateChanged (e) {
            this.ghost.start_date = moment(e).format('YYYY-MM-DD')
        },

        endDateChanged (e) {
            this.ghost.end_date = moment(e).format('YYYY-MM-DD')
        },

        /**
         * Show file upload modal
         */
        showUpload () {
            window.$('#uploadModal').modal('show')
        },

        /*
         * Show categories modal
         */
        showCategories (e) {
            e.preventDefault()
            this.openModal({ id: 'categoriesModal' })
        },

        /*
         * Show users modal
         */
        showUsers (e) {
            this.allMembers = this.users
            e.preventDefault()
            this.openModal({ id: 'usersModal' })
        },

        /**
         * Set the category to be deleted
         */
        setDeletingCategory (e) {
            this.deletingCategory = Object.assign({}, e)
            this.openModal({ id: 'categoryRemove', timeout: 300 })
        },

        /**
         * Set the user to be removed
         */
        setDeletingUser (e) {
            this.deletingUser = Object.assign({}, e)
            this.openModal({ id: 'userRemove', timeout: 300 })
        },

        /**
         * Dermanently delete a category
         */
        async deleteCategory () {
            const response = await axios.delete('/project-categories/' + this.deletingCategory.id)
            .catch(error => {
                this.$swal.error(error.response.data.message)
            })

            if (response) {
                this.getCategories()
                this.$toastr.success('Category successfully deleted')
            }
        },

        /**
         * Removing a user
         */
        async removeUser () {
            this.deletingUser.project_id = this.project.id
            const response = await axios.post('removePrivateUsers', this.deletingUser)
            .catch(error => {
                this.$swal.error(error.response.data.message)
            })

            if (response) {
                this.getUsers()
                this.getNonPrivateUsers()
                this.$toastr.success('User successfully removed')
            }
        },

        async refreshProject (e) {
            this.$store.dispatch('projects/getOne', this.project.id)
        }
    }
}
</script>
