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
                                            placeholder="Enter number"
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
                                                :value="r.value" v-translate
                                            >{{ r.label }}</option>
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
                        <th scope="col">Client</th>
                        <th scope="col">Chef</th>
                        <th scope="col">Dish</th>
                        <th scope="col">Cost</th>
                        <th scope="col">Date & time</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <TableRow 
                        v-for="u in bookings" :key="u.code"
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
                        @clicked="getBookings"
                    />
                </div>

                <div class="col-sm-4">
                    <div class="text-right">
                        Showing {{ from }} - {{ to }} of {{ totalItems }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import TableRow from './components/table-row'

export default {
    name: 'AdminBookings',
    components: { TableRow },

    data: () => ({
        bookings: [],
        statuses: [],
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
        this.getBookings()

        this.statuses = [
            { value: 'pending', label: 'Pending' },
            { value: 'approved', label: 'Approved' },
            { value: 'declined', label: 'Declined' }
        ]
    },

    watch: {
        status: function (val) {
            this.getBookings()
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
            this.getBookings()
        }, 500),


        /**
         ** Get tickets with pagination 
         **
         ** @param Integer {page}
         ** @return {void}
         */
        async getBookings (page = 1) {
            this.isLoading = true
            this.page = page

            let url = `/bookings?page=${page}&status=${this.status}&keywords=${this.keywords}`
    
            const res = await axios.get(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.bookings = res.data.data
                this.currentPage = res.data.current_page
                this.totalPages = res.data.last_page
                this.totalItems = res.data.total
                this.perPage = res.data.per_page
            }
        }
    }
}
</script>