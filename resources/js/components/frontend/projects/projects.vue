<template>
    <section>
        <div class="content-title">
            <ProjectHeader></ProjectHeader>
        </div>

        <section class="content-body mt-20">
            <div class="projects-list">
                <div class="blocks-items mt-20">
                    <Item v-for="item in projects" :key="item.id" :project="item" />
                </div>
            </div>
        </section>


        <div class="sad-block" v-show="noProject && !isLoading">
            <i class="ion-ios-box-outline"></i>
            <h5>No project could be found</h5>
        </div>


        <div class="mt-40" v-show="isLoading">
            <Placeholder class="mt-10"></Placeholder>
            <Placeholder class="mt-10"></Placeholder>
            <Placeholder class="mt-10"></Placeholder>
        </div>

        <CreateModal></CreateModal>
    </section>
</template>

<script>
import { mapGetters } from 'vuex'
import Placeholder from './loader/placeholder'
import ProjectHeader from './header/header'
import CreateModal from './create/create'
import Item from './item/item'

export default {
    name: 'projects',
    components: { ProjectHeader, CreateModal, Placeholder, Item },

    mounted () {
        this.getProjects()
    },

    computed: {
        noProject () {
            return this.projects.length === 0
        },

        ...mapGetters('projects', {
            projects: 'all'
        })
    },

    methods: {
        async getProjects () {
            this.startLoading()
            await this.$store.dispatch('projects/getAll')
            this.stopLoading()
        }
    }
}
</script>
