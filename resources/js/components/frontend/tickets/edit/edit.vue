<template>
        <section class="content-body pt-20">
            <div class="_block _block-radius">
                <div class="_block-content">
                    <form class="_form mt-10" @submit.prevent>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title"
                                        v-model="ghost.title"
                                        v-validate="'required|min:3'"
                                        class="form-control input-lg">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control input-lg"
                                            v-model="ghost.status">
                                            <option v-for="item in categories" :value="item.id">{{ item.name }}</option>
                                        </select>
                                    </div>
                                    <div class="fs-15 bold">
                                        <a href="" @click="showCategories">
                                            <i class="ion-ios-keypad"></i> Status
                                        </a>
                                    </div>
                                </div>

                            <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Priority</label>
                                        <select class="form-control input-lg"
                                            name="priority"
                                            v-model="ghost.priority">
                                            <option v-for="item in priorities" :value="item">{{ item }}</option>
                                        </select>
                                    </div>
                                </div>

                            <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Complexity</label>
                                        <select class="form-control input-lg"
                                            name="complexity"
                                            v-model="ghost.complexity">
                                            <option v-for="item in complexities" :value="item">{{ item }}</option>
                                        </select>
                                    </div>
                                </div>

                            <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Estimate</label>
                                        <input type="text" name="estimate"
                                            v-model="ghost.estimate"
                                            placeholder="Estimate in time/effort"
                                            class="form-control input-lg">
                                    </div>
                                </div>
                        </div>


                            <div class="row mt-10">

                                <div class="col-sm-2">
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

                                <div class="col-sm-2">
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

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Assigned to</label>
                                        <select class="form-control input-lg"
                                            v-model="ghost.assignee_id">
                                            <option value="">Select a member</option>
                                            <option v-for="item in members" :value="item.id">
                                                {{ name(item) }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Ticket parent</label>
                                        <select class="form-control input-lg"
                                            name="parent"
                                            v-model="ghost.parent_id">
                                            <option value="">Select a ticket parent</option>
                                             <option v-for="item in ticket.project.tickets" :value="item.id">{{ item.title }}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="clearfix"></div>


                            <div class="row mt-10">
                                <div class="col-sm-7">
                                    <div class="attachments">
                                        <h5 class="bold">
                                            <i class="ion-android-attach mr-5"></i> Attachments
                                        </h5>

                                        <button class="btn btn-teal" @click="showUpload()">
                                            <i class="ion-android-upload"></i> Upload file
                                        </button>

                                        <Files
                                            :files="files"
                                            :ticket="ticket"
                                            @fileDeleted="refreshTicket">
                                        </Files>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label>Assigned project</label>
                                        <select class="form-control input-lg"
                                            name="parent"
                                            v-model="ghost.project_id">
                                            <option value="">Select a project</option>
                                             <option v-for="item in projects" :value="item.id">{{ item.title }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-20">
                                <label>Ticket Description</label>
                                <izy-textarea v-model="ghost.description" :placeholder="'Ticket description'"></izy-textarea>
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

            <CategoriesModal @deleting="setDeletingCategory"></CategoriesModal>
             <commons-confirm
                    @confirmed="deleteCategory()"
                    :confirmMessage="'Delete permanently'"
                    :message="'Are you sure you want to delete this category'"
                    :category="deletingCategory">
                </commons-confirm>

                <commons-upload
                    :uploadUrl="uploadUrl"
                    @uploaded="refreshTicket"
                    :title="'Upload attachments'"
                    :maxFiles="1">
                </commons-upload>

        </section>
</template>

<script>

import moment from 'moment'
import { mapGetters } from 'vuex'
import CategoriesModal from '../categories/categories'
import Files from './files/files'


export default {
    name: 'ticket-edit',

    props: ['ticket', 'members', 'statuses'],

    components: { CategoriesModal, Files },

    mounted () {
        this.tickets = _tickets
        this.projects = _projects

        this.$store.commit('tickets/SET_TICKET', this.ticket)
        this.$store.commit('categories/SET_TICKET_CATEGORIES', this.statuses)

        this.uploadUrl = '/uploads/ticket/' + this.ticket.id
        this.makeDates()

        this.ghost = Object.assign({}, this.ticket)
    },

    data: () => ({
        priorities: ['low', 'medium', 'high', 'critical'],
        complexities: ['low', 'medium', 'high', 'critical'],
        estimates: ['Hour(s)', 'Day(s)', 'Week(s)', 'Month(s)', 'Year(s)'],
        startDate: {},
        endDate: {},
        deletingCategory: {},
        tickets: [],
        projects: [],
        uploadUrl: ''
    }),

    computed: {
        ...mapGetters('categories', {
            categories: 'ticketCategories'
        }),

        ...mapGetters('tickets', {
            files: 'files'
        })
    },

    methods: {

        async save () {
            const isvalid = await this.validateForm()
            if (!isvalid ) return false;

            this.isLoading = true

            const response = await axios.put('/tickets/'+this.ghost.id, this.ghost)
            .catch(error => {
                console.log(error);
                this.$swal.error(error.response.data)
            })

            if (response) {
                this.$toastr.success('Ticket successfully updated')
            }

            this.isLoading = false
        },

        name (m) {
            if (!m.lastname) {
                return m.firstname
            } else {
                return m.firstname + ' ' + m.lastname
            }
        },


        /*
         * Show categories modal
         */
        showCategories (e) {
            e.preventDefault()
            this.openModal({ id: 'categoriesModal' })
        },

        /**
         * Get categories from server
         */
        getCategories () {
            this.$store.dispatch('categories/getTicketCategories')
        },


        /**
         * Set the category to be deleted
         */
        setDeletingCategory (e) {
            this.deletingCategory = Object.assign({}, e)
            this.openModal({ id: 'confirmModal', timeout: 300 })
        },

        /**
         * Dermanently delete a category
         */
        async deleteCategory () {
            const response = await axios.delete('/ticket-categories/' + this.deletingCategory.id)
            .catch(error => {
                this.$swal.error(error.response.data.message)
            })

            if (response) {
                this.getCategories()
                this.$toastr.success('Category successfully deleted')
            }
        },

        /**
         * Build dates from project dates
         */
        makeDates () {
            if (this.ticket.start_date) {
                this.startDate = moment(this.ticket.start_date)
            }

            if (this.ticket.end_date) {
                this.endDate = moment(this.ticket.end_date)
            }
        },

        /**
         * Show file upload modal
         */
        showUpload () {
            window.$('#uploadModal').modal('show')
        },

        startDateChanged (e) {
            this.ghost.start_date = moment(e).format('YYYY-MM-DD')
        },

        endDateChanged (e) {
            this.ghost.end_date = moment(e).format('YYYY-MM-DD')
        },

        async refreshTicket (e) {
            this.$store.dispatch('tickets/getOne', this.ticket.id)
        }
    }
}
</script>
