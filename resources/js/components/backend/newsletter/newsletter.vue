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

                            <div class="col-sm-9">
                                <div class="text-right">
                                    <button
                                        class="btn btn-primary w-150"
                                        :disabled="isLoading"
                                        @click="downloadCsv()"
                                    >{{ isLoading ? 'Loading...' : 'Download CSV' }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                    </tr>
                </thead>
                <tbody>
                    <UserTableRow 
                        v-for="u in users" :key="u.code"
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
    </div>
    
</template>

<script>
import _ from 'lodash'
import UserTableRow from './components/user-table-row.vue'

export default {
    name: 'admin-newsletter',
    components: { UserTableRow },

    data: () => ({
        users: [],
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

    mounted () {
        this.getUsers()
    },

    watch: {
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

            let url = `/newsletter?page=${page}&keywords=${this.keywords}`
    
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


        downloadCsv () {
            window.open('/admin/acl/newsletter/download-csv', '_blank').focus();
        }
    }
}
</script>