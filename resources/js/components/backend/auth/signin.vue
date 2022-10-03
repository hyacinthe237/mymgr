<template>
    <section class="signin-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 m-auto">

                    <div class="login-form">
                        <div class="logo-name text-center">Sign In</div>

                         <form class="_form mt-20" @submit.prevent="signin()" id="signinForm">
                            <div class="form-group">
                                <div class="inner-addon left-addon">
                                    <i class="glyphicon feather icon-user"></i>

                                    <input type="email"
                                        name="email"
                                        :placeholder="t('Email')"
                                        class="form-control form-control-lg input-white"
                                        v-model="ghost.email"
                                        v-validate="'required|min:6'"
                                        autocomplete="on"
                                    >
                                    <span class="has-error">{{ errors.first('email') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="inner-addon left-addon">
                                    <i class="glyphicon feather icon-lock"></i>

                                    <input type="password"
                                        name="password"
                                        :placeholder="t('Password')"
                                        :data-vv-as="t('Password')"
                                        v-validate="'required|min:6'"
                                        v-model="ghost.password"
                                        autocomplete="on"
                                        class="form-control form-control-lg input-white"
                                    >
                                    <span class="has-error">{{ errors.first('password') }}</span>
                                </div>
                            </div>

                            <div class="mt-20">
                                <izy-btn :loading="isLoading" :size="'lg'" block>
                                    <i class="feather icon-arrow-right pull-right"></i>
                                    {{ t('Sign in') }}
                                </izy-btn>
                            </div>

                            <div class="links">
                                <a href="">{{ t('Forgot password') }}</a>
                            </div>
                       </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'admin-auth-signin',

    methods: {
        async signin () {
            const isValid = await this.$validator.validate()
            if (!isValid ) return false;

            this.isLoading = true

            try {
                const response = await webAxios.post('/admin/login', this.ghost)
                window.location = response.data.route
            } catch (e) {
                console.log(e)
                const message = e.response.data.message || e.response.data.msg || e.response.data
                this.$swal.error(message)
            }

            this.isLoading = false
        }
    }
}
</script>