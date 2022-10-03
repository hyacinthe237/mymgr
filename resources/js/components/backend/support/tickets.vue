<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />

        <div class="block-container">
            <div class="header">
                <div class="table-filters">
                    <form class="_form" @submit.prevent>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="field-wrapper">
                                        <div class="field-placeholder">
                                            <span>{{ t('Search') }}</span>
                                        </div>

                                        <input 
                                            type="text"
                                            name="keywords"
                                            autocomplete="off" 
                                            placeholder="Type to search"
                                            v-model="keywords"
                                        >
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="field-wrapper">
                                        <div class="field-placeholder">
                                            <span>{{ t('Status') }}</span>
                                        </div>

                                        <select name="status" v-model="status">
                                            <option value="" v-translate>All</option>
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
                    </form>
                </div>
            </div>

            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">User</th>
                        <th scope="col">Assignee</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <TableRow 
                        v-for="u in tickets" :key="u.code"
                        @viewUser="viewItem"
                        @assign="assign"
                        :item="u"
                    />
                </tbody>
            </table>
        </div>

        <div class="mt-20">
            <div class="row">
                <div class="col-sm-8">
                    <izy-pagination 
                        :current="currentPage"
                        :last="totalPages"
                        @clicked="getTickets"
                    />
                </div>

                <div class="col-sm-4">
                    <div class="text-right">
                        Showing {{ from }} - {{ to }} of {{ totalItems }}
                    </div>
                </div>
            </div>
        </div>


        <AssignModal 
            :model="selectedTicket"
            :admins="admins"
            @assigned="assigned"
        />
    </div>
    
</template>

<script>
import _ from 'lodash'
import TableRow from './components/table-row'
import AssignModal from './components/assign-modal'

export default {
    name: 'admin-tickets',
    components: { TableRow, AssignModal },

    data: () => ({
        tickets: [],
        statuses: [],
        admins: [],
        selectedTicket: {},
        keywords: '',
        currentPage: 1,
        totalItems: 1,
        totalPages: 1,
        perPage: 1,
        status: '',
        page: 1
    }),

    created () {
        this.status = _request.status || ''
    },

    mounted () {
        this.getAdmins()
        this.getTickets()

        this.statuses = [
            'Closed', 'Pending'
        ]
    },

    watch: {
        'ghost.status': function (val) {
            this.getTickets()
        },

        keywords: function () {
            this.search()
        }
    },


    computed: {
        from () {
            if (this.perPage && this.perPage) {
                const from = this.currentPage * this.perPage - (this.perPage - 1)
                return from >= this.totalItems ? this.totalItems : from
            }

            return 0
        },

        to () {
            if (this.perPage && this.perPage) {
                const to = this.currentPage * this.perPage
                return to >= this.totalItems ? this.totalItems : to
            }
                
            return 0
        }
    },

    methods: {
        search: _.debounce ( function () {
            this.getTickets()
        }, 500),


        /**
         ** Get tickets with pagination 
         **
         ** @param Integer {page}
         ** @return {void}
         */
        async getTickets (page = 1) {
            this.isLoading = true
            this.page = page

            let url = `/tickets?page=${page}&status=${this.status}&keywords=${this.keywords}`
    
            const res = await axios.get(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.tickets = res.data.data
                this.currentPage = res.data.current_page
                this.totalPages = res.data.last_page
                this.totalItems = res.data.total
                this.perPage = res.data.per_page
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


        viewItem (uuid) {
            window.location.href = '/admin/tickets/' + uuid
        },


        assign (model) {
            this.selectedTicket = Object.assign({}, model) 
            $('#assignModal').modal({ show: true })
        },


        assigned (user) {
            if (user) {
                const payload = Object.assign({}, this.selectedTicket, {
                    assignee_id: user.id
                })

                this.updateTicket(payload)
            }
        },


        /**
         ** Update ticket 
         **
         ** @param {Object} ticket
         ** @return {void}
         */
        async updateTicket (ticket) {
            const res = await axios.patch(`/tickets/${ticket.code}`, ticket)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            if (res) {
                this.getTickets()
            }
        }
    }
}
</script>