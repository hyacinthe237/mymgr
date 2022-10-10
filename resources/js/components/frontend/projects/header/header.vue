<template>
    <div class="">
        <button @click="openNewProjectModal()"
            class="btn btn-primary btn-md pull-right">
            <i class="ion-plus"></i> Project
        </button>

        Projects
    </div>
</template>

<script>
export default {
    name: 'projects-header',

    methods: {
        openNewProjectModal  () {
            $('#newProjectModal').modal('show')
        }
    }
}
</script>
