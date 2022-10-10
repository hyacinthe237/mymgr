<template>

    <div class="">
        <div class="content-title">
            Notifications
        </div>

        <section class="content-body mt-10">
            <Item v-for="item in items" :item="item" :key="item.id"> </Item>
        </section>
    </div>

</template>

<script>
import Item from './item/item'

export default {
    name: 'notifications',

    props: ['notifications'],

    components: { Item },

    data: () => ({
        items:null
    }),

    mounted () {
        this.items = jQuery.parseJSON(this.notifications)
    },


    methods: {

    }
}
</script>
