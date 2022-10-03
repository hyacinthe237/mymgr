<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />


        <div class="row">
            <div class="col-sm-8">
                <div class="block-container">
                    <div class="pd-20">
                        <div class="text-right pointer" @click="showAssigneeModal()">
                            <div class="teal">Assignee</div>
                            <div class="bold">{{ assigneeName }}</div>
                        </div>


                        <div class="mt-40">
                            <form class="_form mb mt-10" @submit.prevent="save(ghost)">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <div class="field-wrapper">
                                                <div class="field-placeholder">
                                                    <span>{{ t('Title') }}</span>
                                                </div>

                                                <input 
                                                    type="text"
                                                    name="title"
                                                    autocomplete="off" 
                                                    placeholder="Title"
                                                    v-model="ghost.title"
                                                    v-validate="'required|min:2'"
                                                >
                                                <izy-error :name="'title'" :show="showErrors" :err="errors"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="field-wrapper">
                                                <div class="field-placeholder">
                                                    <span>{{ t('Status') }}</span>
                                                </div>

                                                <select name="status" v-model="ghost.status">
                                                    <option 
                                                        v-for="(r, index) in statuses"
                                                        :key="index + 1"
                                                        :value="r" v-translate
                                                    >{{ r }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="mt-20">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Description') }}</span>
                                            </div>

                                            <textarea
                                                rows="3"
                                                name="description"
                                                placeholder="Description"
                                                v-model="ghost.description"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                            

                                <div class="text-right">
                                    <button
                                        class="btn btn-primary w-150"
                                        :disabled="isLoading"
                                        type="submit"
                                    >{{ isLoading ? 'Loading...' : 'Update Ticket' }}</button>
                                </div>
                            </form>
                        </div>


                        <div class="teal fs-14">
                            <div class="bold">Last update</div>
                            <div class="">
                                {{ ticket.updated_at | date('DD/MM/YYYY HH:mm') }} 
                                <span v-show="updater">By {{ updaterName }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <TicketChat 
                    :ticket="ticket"
                    @comment="saveComment"
                />
            </div>
        </div>


        <AssignModal 
            :model="ticket"
            :admins="admins"
            @assigned="assigned"
        />
    </div>
    
</template>

<script>
import _ from 'lodash'
import AssignModal from './components/assign-modal'
import TicketChat from './components/chat'

export default {
    name: 'admin-ticket',
    components: { AssignModal, TicketChat },

    data: () => ({
        chat: {},
        statuses: [],
        admins: [],
    }),

    mounted () {
        this.getAdmins()
        this.getTicket()

        this.statuses = [
            'Closed', 'Pending'
        ]
    },

    watch: {
        ticket: {
            immediate: true, 
            handler: function (val) {
                if (val.id) {
                    this.ghost = {
                        id: val.id,
                        code: val.code,
                        title: val.title,
                        status: val.status,
                        description: val.description,
                        assignee_id: val.assignee.id,
                    }
                }
            }
        }
    },

    computed: {
        ticket () {
            return this.$store.state.ticket || {}
        },

        assignee () {
            if (this.ticket.assignee)
                return this.ticket.assignee
            return {}
        },

        assigneeName () {
            if (this.assignee.code)
                return this.assignee.firstname + ' ' + this.assignee.lastname
            return '--'
        },

        updater () {
            return this.ticket.updater || {}
        },

        updaterName () {
            if (this.updater.code)
                return this.updater.firstname + ' ' + this.updater.lastname
            return '--'
        },
    },

    methods: {
        /**
         ** Get tickets with pagination 
         **
         ** @param Integer {page}
         ** @return {void}
         */
        async getTicket () {
            this.isLoading = true

            let url = `/tickets/${_uuid}`
    
            const res = await axios.get(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.$store.commit('SET_TICKET', res.data)
            }
        },


        /**
         ** Get admin users
         **
         ** @return {void}
         */
        async getAdmins () {
            const res = await axios.get(`/users/admins`)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            if (res) {
                this.admins = res.data
            }
        },

        showAssigneeModal () {
            $('#assignModal').modal({ show: true })
        },


        assigned (user) {
            if (user) {
                const payload = Object.assign({}, this.ticket, {
                    assignee_id: user.id
                })

                this.save(payload)
            }
        },


        /**
         ** Update ticket 
         **
         ** @param {Object} ticket
         ** @return {void}
         */
        async save (ticket) {
            const isValid = await this.$validator.validate()
            if (!isValid ) return false;

            this.isLoading = true

            const res = await axios.patch(`/tickets/${this.ticket.code}`, ticket)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.getTicket()
            }
        },


        /**
         **
         */
        async saveComment (payload) {
            this.isLoading = true 

            const res = await axios.post(`/comments`, payload)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false 
            
            if (res) {
                this.getTicket()
            }
        }
    }
}
</script>