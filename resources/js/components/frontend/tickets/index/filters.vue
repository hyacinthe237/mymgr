<template>
    <izy-modal :id="'filtersModal'">
        <form class="_form" @submit.prevent>
            <div class="form-group">
                <label>Project name</label>
                <select class="form-control input-lg"
                    v-model="ghost.project">
                    <option value="">All</option>
                    <option v-for="item in projects" :value="item.id">
                        {{ item.title}}
                    </option>
                </select>
            </div>


            <div class="row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control input-lg"
                            v-model="ghost.is_open">
                            <option value="1">Opened</option>
                            <option value="0">Resolved</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Stage</label>
                        <select class="form-control input-lg"
                            v-model="ghost.category">
                            <option value="">All</option>
                            <option v-for="item in categories" :value="item.id">
                                {{ item.name}}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Assigned to</label>
                        <select class="form-control input-lg"
                            v-model="ghost.user">
                            <option value="">All</option>
                            <option v-for="item in users" :value="item.id">
                                {{ name(item) }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </form>


        <div class="mt-10 pb-10 text-right">
            <button class="btn btn-md btn-teal" data-dismiss="modal">
                Cancel
            </button>

            <button class="btn btn-primary btn-md" @click="close()">
                <i class="ion-android-done-all"></i>
                Apply Filters
            </button>
        </div>
    </izy-modal>
</template>

<script>
export default {

    props: ['users','categories','projects'],

    mounted () {
        this.ghost = {
            user: '',
            category: '',
            project: '',
            is_open: '1'
        }
    },


    methods: {
        close () {
            this.$emit('apply', this.ghost)
            this.closeModal('filtersModal')
        },

        name (m) {
            if (!m.lastname) {
                return m.firstname
            } else {
                return m.firstname + ' ' + m.lastname
            }
        }
    }
}
</script>
