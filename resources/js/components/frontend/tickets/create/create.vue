<template>
    <section class="content-body pt-20">

        <div class="_block _block-radius">
            <div class="_block-content">
                <form class="_form mt-10" @submit.prevent="save()">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title"
                                    v-model="ghost.title"
                                    v-validate="'required|min:3'"
                                    placeholder="Ticket title"
                                    class="form-control input-lg">
                                <span class="has-error">{{ errors.first('title') }}</span>
                            </div>
                        </div>

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
                                        {{ item.firstname + ' ' + item.lastname }}
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
                                    <option v-for="item in tickets" :value="item.id">{{ item.title }}</option>
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

                        <izy-btn :loading="isLoading"
                            :bg="'dark'"
                            @clicked="saveAndContinue()">
                            <i class="ion-android-arrow-forward"></i>
                            Save & Continue
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
    </section>
</template>

<script>
import moment from 'moment'
import { mapGetters } from 'vuex'
import CategoriesModal from '../categories/categories'

export default {
    name: 'ticket-create',
    props: ['project', 'members', 'statuses'],
    components: { CategoriesModal },

    mounted () {
        this.resetGhost()
        this.tickets = this.project.tickets.slice()
        this.$store.commit('categories/SET_TICKET_CATEGORIES', this.statuses)
    },

    data: () => ({
        priorities: ['low', 'medium', 'high', 'critical'],
        complexities: ['low', 'medium', 'high', 'critical'],
        estimates: ['Hour(s)', 'Day(s)', 'Week(s)', 'Month(s)', 'Year(s)'],
        startDate: {},
        endDate: {},
        deletingCategory: {},
        tickets: []
    }),
    computed: {
        ...mapGetters('categories', {
            categories: 'ticketCategories'
        })
    },

    methods: {
        async save () {
            const response = await this.saveTicket()
            if (response) window.location = '/tickets/' + response.data.number
        },

        async saveAndContinue () {
            const response = await this.saveTicket()
            if (response) {
                this.tickets.push(response.data)
            }
        },

        resetGhost () {
            this.ghost = {}
            this.ghost = {
                priority: 'low',
                complexity: 'low',
                assignee_id: '',
                status: this.statuses[0].id,
                project_id: this.project.id,
            }
        },

        async saveTicket () {
            let result = {}
            const isvalid = await this.validateForm()
            if (!isvalid ) return false;

            this.startLoading()

            this.ghost.project_id = this.project.id

            const response = await axios.post('/tickets', this.ghost)
            .catch(error => {
                console.log(error);
                this.$swal.error(error.response.data)
            })

            if (response) {
                this.$toastr.success('Ticket successfully created')
                result = response
            }

            this.stopLoading()
            return result
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


        startDateChanged (e) {
            this.ghost.start_date = moment(e).format('YYYY-MM-DD')
        },

        endDateChanged (e) {
            this.ghost.end_date = moment(e).format('YYYY-MM-DD')
        },
        /*
         * Show categories modal
         */
        showCategories (e) {
            e.preventDefault()
            this.openModal({ id: 'categoriesModal' })
        }
    }
}
</script>
