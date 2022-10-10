<template>
    <div class="modal fade" tabindex="-1" role="dialog" :id="'categoriesModal'">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h4 class="">Project categories</h4>


                    <form class="_form mt-20" @submit.prevent="save()">
                        <div class="row">
                            <div class="col-xs-9">
                                <div class="form-group">
                                    <input type="text"
                                        class="form-control input-lg"
                                        v-model="ghost.name"
                                        placeholder="Category title"
                                        required>
                                </div>
                            </div>

                            <div class="col-xs-3">
                                <izy-btn block :size="'lg'">Save</izy-btn>
                            </div>
                        </div>
                    </form>


                    <div class="_categories-list mt-20">
                        <LineComponent
                            @deleting="deleting"
                            v-for="c in categories"
                            :key="c.id"
                            :category="c" />
                    </div>


                    <div class="mt-20 text-center">
                        <button class="btn btn-grey rounder" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'
import LineComponent from './line'

export default {
    components: { LineComponent },

    mounted () {

    },

    computed: {
        ...mapGetters('categories', {
            categories: 'projectCategories'
        })
    },

    methods: {
        async save () {
            this.isloading = true

            const response = await axios.post('project-categories', this.ghost)
            .catch(error => {
                console.log(error);
                this.$toastr.error(error.response.data.message)
            })

            if (response) {
                this.ghost = {}
                this.$toastr.success('Project successfully updated')
                this.$store.dispatch('categories/getProjectCategories')
            }

            this.isLoading = false
        },

        deleting (e) {
            this.$emit('deleting-category', e)
        }
    }
}
</script>
