<template>

<form class="_form mt-10" @submit.prevent="saveProfile()">

    <!-- Aligne les inputs 2 par column -->
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label>Last password</label>
                <input type="password"
                    name="old_password"
                    placeholder="Password"
                    class="form-control input-lg"
                    v-model="user.old_password"
                    v-validate="'required|min:6'">
                <span class="has-error">{{ errors.first('password') }}</span>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>New password</label>
                <input type="password"
                    name="password"
                    placeholder=" New Password"
                    class="form-control input-lg"
                    v-model="user.password"
                    v-validate="'required|min:6'">
                <span class="has-error">{{ errors.first('new-password') }}</span>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="form-group">
                <label>Confirm password</label>
                <input type="password"
                    name="password_confirm"
                    placeholder="Confirm password"
                    class="form-control input-lg"
                    v-validate="'required|confirmed:password'">
                <span class="has-error">{{ errors.first('new-password') }}</span>
            </div>
        </div>

    </div>


    <div class="text-right mt-20">
        <izy-btn :loading="isLoading" elevated>
            <i class="ion-android-done-all"></i>
            Change Password
        </izy-btn>
    </div>
</form>


</template>

<script>

export default {
    props: {
        user: {
            type: Object,
            default: () => {}
        }
    },

    methods: {
        async saveProfile () {
            this.$emit('save', this.user)

        },

    }
}
</script>
