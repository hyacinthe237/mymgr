export default {
    computed: {
        user () {
            return this.$store.state.user
        }
    },

    methods: {
        async getUser () {
            this.isLoading = true

            let url = `/users/${_uuid}`
    
            const res = await axios.get(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.$store.commit('SET_USER', res.data)
                this.$set(this, 'ghost', res.data)
            }
        }
    }
}