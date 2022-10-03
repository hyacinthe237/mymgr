<template>
    <div class="block-container">
        <div class="pd-20">
            <h5 class="bold">Chat</h5>

            <div class="conversation mt-20">
                <div 
                    v-for="c in comments"
                    :key="c.code"
                    :class="c.user_code == client.code ? 'them' : 'me'"
                >
                    <div class="content">{{ c.content }}</div>
                    <div class="meta">{{ c.user_name }} {{ c.created_at | datetime }}</div>
                </div>
            </div>

            <hr>

            <div class="mt-40">
                <form class="_form mt-10" @submit.prevent>
                    <div class="form-group">
                        <div class="field-wrapper">
                            <div class="field-placeholder">
                                <span>{{ t('Message') }}</span>
                            </div>

                            <textarea
                                rows="3"
                                name="message"
                                placeholder="Message"
                                v-model="ghost.message"
                                v-validate="'required|min:2'"
                            ></textarea>

                            <izy-error :name="'message'" :show="showErrors" :err="errors"/>
                        </div>
                    </div>
                </form>

                <div class="text-right">
                    <button
                        class="btn btn-success"
                        :disabled="isLoading"
                        type="button"
                        @click="save"
                    >{{ isLoading ? 'Sending...' : 'Send' }}</button>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
export default {
    name: 'TicketChat',

    props: {
        ticket: { type: Object, default: () => {}}
    },

    computed: {
        client () {
            return this.ticket.client || {}
        },

        clientName () {
            return this.client.firstname + ' ' + this.client.lastname
        },

        comments () {
            return this.ticket.comments || []
        },
    },

    methods: {
        async save () {
            const isValid = await this.$validator.validate()
            if (!isValid ) return false;

            const payload = {
                commentable_id: this.ticket.id,
                commentable_type: 'App\\Models\\Ticket',
                content: this.ghost.message
            }

            console.log('Chat save comment', payload)
            this.$set(this.ghost, 'message', '')
            this.$emit('comment', payload)
        }
    },
}
</script>