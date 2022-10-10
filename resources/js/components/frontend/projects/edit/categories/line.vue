<template>
    <div class="">
        <div class="_category">

            <div v-show="!isEditing">
                <div class="buttons">
                    <button class="btn btn-sm btn-teal" @click="edit(true)">
                        Edit
                    </button>
                </div>

                <div class="title">
                    {{ ghost.name }}
                </div>
            </div>
            <!-- Show  -->

            <div v-show="isEditing">
                <form class="_form" @submit.prevent>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="form-group">
                                <input type="text" v-model="ghost.name" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-xs-4 text-right">
                            <button class="btn btn-danger btn-sm round" @click="confirm()">
                                <i class="ion-trash-b"></i>
                            </button>

                            <izy-btn :loading="isLoading"
                                :size="'sm'"
                                @clicked="save()"
                                :bg="'primary'">
                                Save
                            </izy-btn>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Edit  -->

        </div>
    </div>
</template>

<script>
export default {
    props: ['category'],

    data: () => ({
        isEditing: false,
    }),

    mounted () {
        this.ghost = Object.assign({}, this.category)
    },

    watch: {
        category (val) {
            this.ghost = Object.assign({}, val)
        }
    },


    methods: {
        edit (val) {
            this.isEditing = val
        },

        async save () {
            this.isLoading = true

            const res = await axios.put('project-categories/' + this.ghost.id, this.ghost)
            .catch(error => {
                this.$toastr.error(error.response.data.message)
            })

            if (res) {
                this.$store.dispatch('categories/getProjectCategories')
                this.$toastr.success('Category successfully updated!')
                this.isEditing = false
            }

            this.isLoading = false
        },

        confirm () {
            this.closeModal('categoriesModal')
            this.$emit('deleting', this.ghost)
        }
    }
}
</script>
