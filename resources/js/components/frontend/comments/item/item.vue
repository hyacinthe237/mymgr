<template>
    <div class="comment-container">
        <div class="_badge">
             <img :src="photo" />
        </div>

        <div class="comment-content">
            <div class="name">{{ name }}</div>
            <div class="ago">{{ created_at }}</div>
            <div class="text">{{ comment.body }}</div>
        </div>
    </div>
</template>

<script>
import moment from 'moment'

export default {
    props: ['comment'],

    computed: {
        created_at () {
            return moment(this.comment.created_at).format('ddd DD MMM YYYY HH:ss')
        },

        owner () {
            return this.comment.owner
        },

        photo () {
            return this.owner.thumbnail ? this.owner.thumbnail : '/assets/images/default-user.png'
        },

        name () {
            let str = this.owner.firstname
            return str += this.owner.lastname ? ' ' + this.owner.lastname : ''
        }
    }
}
</script>
