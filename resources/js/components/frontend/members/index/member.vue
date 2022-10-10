<template>
    <div class="block-team-item pointer">
        <div class="team-image circle" @click="open()">
            <img :src="thumbnail" class="img-responsive">
        </div>

        <div class="team-name text-center" @click="open()">
            <span>{{ name }}</span>
        </div>

        <div class="team-function text-center" @click="open()">
            <span>{{ position }}</span>
        </div>

        <div class="">
            <div class="text-center mt-20" v-show="isBlocked">
                <a @click.prevent="activate" class="btn btn-primary btn-sm">
                    Activate
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['member'],

    data: () => ({
        lname: '',
        select: {}
    }),

    computed: {
        memberid () {
            return this.member.id
        },

        name () {
            if (!this.member.lastname) {
                return this.member.firstname + ' ' + this.lname
            } else {
                return this.member.firstname + ' ' + this.member.lastname
            }
        },

        position () {
            return this.member.pivot.position || 'N/A'
        },

        thumbnail () {
            if (this.member.thumbnail) return this.member.thumbnail
            if (this.member.photo) return this.member.photo
            return '/assets/images/default-user.png'
        },

        url () {
            return '/members/' + this.member.code
        },

        isBlocked () {
            return this.member.status === 'blocked'
        }
    },

    methods: {
        open () {
            window.location = this.url
        },

        activate () {
            this.$emit('activate', this.member)
        }
    }
}
</script>
