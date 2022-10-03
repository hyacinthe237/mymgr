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
                                            <span>{{ t('Role') }}</span>
                                        </div>
                                        
                                        <select name="role" v-model="ghost.role">
                                            <option value="" v-translate>All</option>
                                            <option 
                                                v-for="r in roles"
                                                :key="r.id"
                                                :value="r.id" v-translate
                                            >{{ r.display_name }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <div class="field-wrapper">
                                        <div class="field-placeholder">
                                            <span>{{ t('Status') }}</span>
                                        </div>

                                        <select name="status" v-model="ghost.status">
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
                        <th scope="col">Username</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <UserTableRow 
                        v-for="u in users" :key="u.code"
                        @viewUser="viewUser"
                        @editUser="editUser"
                        @blockUser="blockUser"
                        :roles="roles"
                        :user="u"
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
                        @clicked="getUsers"
                    />
                </div>

                <div class="col-sm-4">
                    <div class="text-right">
                        Showing {{ from }} - {{ to }} of {{ totalUsers }}
                    </div>
                </div>
            </div>
        </div>

        <BlockConfirmModal 
            :user="selectedUser"
            @confirmed="blockConfirmed"
        />
    </div>
    
</template>

<script>
import _ from 'lodash'
import UserTableRow from './components/user-table-row.vue'
import BlockConfirmModal from './components/block-modal.vue'

export default {
    name: 'admin-users',
    components: { UserTableRow, BlockConfirmModal },

    data: () => ({
        users: [],
        roles: [],
        statuses: [],
        selectedUser: {},
        keywords: '',
        currentPage: 1,
        totalUsers: 1,
        totalPages: 1,
        page: 1,
        from: 1,
        to: 1,

        ghost: {
            role: '',
            status: '',
        }
    }),

    created () {
        this.ghost.role = _request.role || ''
        this.ghost.status = _request.status || ''
    },

    mounted () {
        this.getUsers()
        this.getRoles()

        this.statuses = [
            'Active', 'Blocked', 'Pending'
        ]
    },

    watch: {
        'ghost.status': function (val) {
            this.getUsers()
        },

        'ghost.role': function (val) {
            this.getUsers()
        },

        keywords: function () {
            this.search()
        }
    },

    methods: {
        search: _.debounce ( function () {
            this.getUsers()
        }, 500),

        async getUsers (page = 1) {
            this.isLoading = true
            this.page = page

            let url = `/users?page=${page}&status=${this.ghost.status}&role=${this.ghost.role}&keywords=${this.keywords}`
    
            const res = await axios.get(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.users = res.data.data
                this.currentPage = res.data.current_page
                this.totalPages = res.data.last_page
                this.totalUsers = res.data.total
                this.from = res.data.from
                this.to = res.data.to
            }
        },

        async getRoles () {
            const res = await axios.get('/roles')
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            if (res) {
                this.roles = res.data
            }
        },


        async viewUser (uuid) {
            console.log('View user ==> ', uuid)
            window.location.href = '/admin/acl/users/' + uuid
        },

        async editUser (uuid) {
            console.log('Edit user ==> ', uuid)
        },

        async blockUser (uuid) {
            console.log('Block user ==> ', uuid)
            this.selectedUser = this.users.find(u => u.code === uuid)
            console.log('selectedUser', this.selectedUser)
            $('#blockConfirmModal').modal('show')
        },

        /**
         * Block confirmed 
         * 
         * @return {void}
         */
        async blockConfirmed () {
            console.log('Confirmed to block ', this.selectedUser)
            this.isLoading = true
            const payload = Object.assign({}, this.selectedUser, { status: 'blocked' })

            const res = await axios.put(`/users/${payload.code}`, payload)
                .catch(e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.getUsers(this.page)
            }
        }
    }
}
</script>