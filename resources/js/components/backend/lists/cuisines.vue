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


                            <div class="col-sm-9 text-right">
                                <a 
                                    href="/admin/lists/cuisines/create" 
                                    class="btn btn-primary"
                                >Add Cuisine</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col" class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <CuisineTableRow 
                        v-for="u in models" :key="u.code"
                        @viewUser="viewModel"
                        @editUser="editModel"
                        :model="u"
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
                        @clicked="getModels"
                    />
                </div>

                <div class="col-sm-4">
                    <div class="text-right">
                        Showing {{ from }} - {{ to }} of {{ totalModels }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import _ from 'lodash'
import CuisineTableRow from './components/cuisine-table-row.vue'

export default {
    name: 'admin-cuisines',
    components: { CuisineTableRow },

    data: () => ({
        models: [],
        selectedModel: {},
        keywords: '',
        currentPage: 1,
        totalModels: 1,
        totalPages: 1,
        page: 1,
        from: 1,
        to: 1
    }),


    mounted () {
        this.getModels()
    },


    watch: {
        keywords: function () {
            this.search()
        }
    },


    methods: {
        search: _.debounce ( function () {
            this.getModels()
        }, 500),


        async getModels (page = 1) {
            this.isLoading = true
            this.page = page

            let url = `/cuisines?page=${page}&keywords=${this.keywords}`
    
            const res = await axios.get(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.models = res.data.data
                this.currentPage = res.data.current_page
                this.totalPages = res.data.last_page
                this.totalModels = res.data.total
                this.from = res.data.from
                this.to = res.data.to
            }
        },


        async viewModel (uuid) {
            console.log('View user ==> ', uuid)
            window.location.href = '/admin/acl/users/' + uuid
        },


        async editModel (uuid) {
            console.log('Edit user ==> ', uuid)
        }
    }
}
</script>