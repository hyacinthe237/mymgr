<template>
    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
        <li class="title">{{ title }}</li>
        <li v-for="i in items" :class="['item ', i.id == id ? 'active' : '']" @click="select(i)">
            <i :class="icon" v-show="i.id == id"></i>
            {{ i.label }}
        </li>

        <li role="separator" class="divider" v-if="footer"></li>
        <li v-if="footer"><a href="" @click="footerClicked">{{ footer }}</a></li>
    </ul>
</template>

<script>
export default {
    name: 'ticket-menu',

    props: {
        items: {
            type: Array,
            default: () => []
        },

        title: {
            type: String,
            default: 'Select an option'
        },

        footer: {
            type: String,
            default: ''
        },

        id: {
            type: [String, Number],
            default: 0
        },

        icon: {
            type: String,
            default: 'ion-checkmark'
        }
    },

    methods: {
        select (item) {
            this.$emit('selected', item)
        },

        footerClicked (e) {
            e.preventDefault()
            this.$emit('footerClicked')
        }
    }
}
</script>
