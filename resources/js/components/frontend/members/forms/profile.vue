<template>

<form class="_form mt-10" @submit.prevent>

    <!-- Aligne les inputs 2 par column -->
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label>First Name</label>
                <input type="text"
                    name="firstname"
                    v-model="user.firstname"
                    class="form-control input-lg"
                    data-vv-as="'First name'"
                    v-validate="'required|min:2'">
                <span class="has-error">{{ errors.first('firstname') }}</span>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label>Last Name</label>
                <input type="text"
                    name="lastname"
                    v-model="user.lastname"
                    class="form-control input-lg"
                    data-vv-as="'Last name'">
                <span class="has-error">{{ errors.first('lastname') }}</span>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label>Email</label>
                <input type="email"
                    name="email"
                    class="form-control input-lg"
                    v-model="user.email"
                    v-validate="'required|email'">
                <span class="has-error">{{ errors.first('email') }}</span>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label>Mobile Number</label>
                <input type="text"
                    name="phone"
                    v-model="user.phone"
                    class="form-control input-lg">
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label>Position</label>
                <input type="text" name="position"
                                   v-model="user.position"
                                   class="form-control input-lg"
                                   data-vv-as="'Position'">
                <span class="has-error">{{ errors.first('position') }}</span>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                      <label>Gender</label>
                      <select class="form-control input-lg" v-model="user.gender">
                          <option v-for="o in genders" :selected="o == o.id" :value="o.id">{{ o.label }}</option>
                      </select>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                      <label>Status</label>
                      <select class="form-control input-lg" v-model="user.status">
                          <option v-for="s in status" :selected="s == s.id" :value="s.id">{{ s.label }}</option>
                      </select>
                  </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="text-right mt-20" pull-right>
                <izy-btn :loading="isLoading" @clicked="saveProfile()" elevated>
                    <i class="ion-android-done-all"></i>
                Save
                </izy-btn>
            </div>
        </div>

    </div>

</form>

</template>

<script>

export default {
  components: { },

    props: {
        user: {
            type: Object,
            default: () => {}
        }
    },

    data: () => ({
        genders: [{ id: 'female', label: 'Female'}, { id: 'male', label: 'Male'}],
        status: [
          { id: 'pending', label: 'Pending'},
          { id: 'active', label: 'Active'},
          { id: 'blocked', label: 'Blocked'}
        ]
    }),

    methods: {
        async saveProfile () {
            this.$emit('save', this.user)

        },
    }
}
</script>
