<template>
    <i v-if="unread" class="badge badge-danger" id="badge">{{unread}}</i>
</template>

<script>

export default {
    name: 'badge',

    props: ['user'],

    data: () => ({
        unread:null,
        options:null
    }),

    mounted () {
        this.getBadge()
        this.notification()

        // Request permission to display notifications on browser
        // Does not work without SSL
        Notification.requestPermission(function(status) {
            console.log('Notification permission status:', status);
        });

        this.options={
            icon: 'images/example.png',
            vibrate: [100, 50, 100],
            data: {
                dateOfArrival: Date.now(),
                primaryKey: 1
            }
        }
    },


    methods: {
        async getBadge () {
            try {
                const response = await webAxios.get('/notifications/unread')
                this.unread = response.data.count
            } catch (e) {
                console.log(e)
            }
        },

        /**
         * Function description
         */
        async notification () {
            try {
                await Echo.private('App.User.' + this.user.id)
                .notification((notification) => {
                    this.unread += 1
                    this.flash(notification.message, 'success');
                    if (Notification.permission == 'granted') {
                        this.options.body = notification.message
                        var notification = new Notification('Hi ' +this.user.firstname,this.options);
                    }
                });
            } catch (e) {
                console.log(e)
            }
        }
    }
}
</script>
