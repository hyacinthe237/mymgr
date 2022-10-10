<template>
    <section class="signin-page">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 m-auto">
                    <div class="login-form">
                          <div class="logo-name text-center">MyMgr Connect</div>

                          <h4 class="bold">Become a member</h4>

                         <form class="_form mt-20" @submit.prevent="signup()" id="signinForm">
                            <div class="form-group">
                                <div class="inner-addon left-addon">
                                    <i class="glyphicon feather icon-user"></i>

                                    <input type="text"
                                        name="firstname"
                                        placeholder="First name"
                                        class="form-control input-lg"
                                        v-model="ghost.firstname"
                                        v-validate="'required'">
                                    <span class="has-error">{{ errors.first('firstname') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="inner-addon left-addon">
                                    <i class="glyphicon feather icon-user"></i>

                                    <input type="text"
                                        name="lastname"
                                        placeholder="Last name"
                                        class="form-control input-lg"
                                        v-model="ghost.lastname"
                                        v-validate="'required'">
                                    <span class="has-error">{{ errors.first('lastname') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="inner-addon left-addon">
                                    <i class="glyphicon feather icon-user"></i>

                                    <input type="email"
                                        name="email"
                                        placeholder="Email"
                                        class="form-control input-lg"
                                        v-model="ghost.email"
                                        v-validate="'required|email'">
                                    <span class="has-error">{{ errors.first('email') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="inner-addon left-addon">
                                    <i class="glyphicon feather icon-lock"></i>

                                    <input type="password"
                                        name="password"
                                        placeholder="Password"
                                        class="form-control input-lg"
                                        v-model="ghost.password"
                                        v-validate="'required|min:6'">
                                    <span class="has-error">{{ errors.first('password') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="inner-addon left-addon">
                                    <i class="glyphicon feather icon-lock"></i>

                                    <input type="password"
                                        name="password_confirm"
                                        placeholder="Confirm password"
                                        class="form-control input-lg"
                                        v-validate="'required|confirmed:password'">
                                    <span class="has-error">{{ errors.first('password_confirm') }}</span>
                                </div>
                            </div>

                            <div class="mt-20">
                                <izy-btn :loading="isLoading" :size="'lg'" block>
                                    <i class="feather icon-arrow-right pull-right"></i>
                                    {{ t('Sign up') }}
                                </izy-btn>
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
    name: 'auth-signup',

    methods: {
        async signup () {
            const isValid = await this.$validator.validate()
            if (!isValid ) return false;

            this.isLoading = true

            try {
                const response = await webAxios.post('/auth/signup', this.ghost)
                window.location = response.data.route
            } catch (e) {
                console.log(e)
                this.$swal.error(e.response.data)
            }

            this.isLoading = false
        }
    }
}
</script>
