<template>
    <div class="mt-10">
        <h5 class="text-center teal mt-20">Select organization</h5>

        <div class="auth-organization" v-for="o in organizations">
            <a :href="'/organizations/' + o.code + '/set'">
                <i class="ion-log-in"></i> {{ o.name }}
            </a>
        </div>

    </div>
</template>

<script>
export default {
    name: 'auth-organization-select',
    props: ['organizations']
}
</script>
