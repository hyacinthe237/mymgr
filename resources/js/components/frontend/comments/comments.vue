<template>
    <section class="_comments">
        <Item v-for="item in items" :key="item.id" :comment="item" />

        <CommentInput
            :commentable-id="commentableId"
            :commentable-type="commentableType"
            @created="addComment">
        </CommentInput>
    </section>
</template>

<script>

import Item from './item/item'
import CommentInput from './input/input'

export default {
    name: 'comment-box',

    components: {  CommentInput, Item },

    props: {
        commentableId: Number,
        commentableType: String
    },

    data: () => ({
        items: []
    }),

    computed: {
        commentTitle () {
            if (this.items.length === 0) return 'Leave a comment'
            let str = this.items.length + ' comment'
            str += this.items.length > 1 ? 's' : ''
            return str
        }
    },

    mounted () {
        this.getComments()
    },

    methods: {
        async getComments () {
            this.startLoading()

            this.url=this.commentableType+'/'+this.commentableId+'/comments';

            const response = await axios.get(this.url)
            .catch(error => console.log(error))

            if (response) {
                this.items = response.data.items
            }

            this.stopLoading()
        },

        addComment (comment) {
            this.items.push(comment)
        },
    }

}
</script>
