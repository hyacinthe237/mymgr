<template>
   <section class="content-body">

    <div class="blocks-team-items mt-20">

            <div class="_block _block-radius">
                <div class="_block-content">
                    <!--block du projet nouvellement creer -->
                    <form class="_form mt-10" @submit.prevent="create()">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input type="text"
                                    name="firstname"
                                    placeholder="Please fill First Name here"
                                    class="form-control input-lg"
                                    v-model="ghost.firstname"
                                    v-validate="'required'">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name">Last Name</label>
                                <input type="text"
                                    name="lastname"
                                    placeholder="Please fill Last Name here"
                                    class="form-control input-lg"
                                    v-model="ghost.lastname"
                                    v-validate="'required'">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name">Phone Number</label>
                                <input type="text"
                                    name="phone"
                                    placeholder="Please fill Phone Number here"
                                    class="form-control input-lg"
                                    v-model="ghost.phone">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Email address</label>
                                <input type="email"
                                    name="email"
                                    placeholder="Email"
                                    class="form-control input-lg"
                                    v-model="ghost.email"
                                    v-validate="'required|email'">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label for="name">Password</label>
                            <input type="password"
                                    name="password"
                                    placeholder="Password"
                                    class="form-control input-lg"
                                    v-model="ghost.password"
                                    v-validate="'required|min:6'">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                             <label for="status">Gender</label>
                            <div class="form-group">
                                <select class="form-control input-lg"  v-model="ghost.gender">
                                    <option disabled value="">Please select one</option>
                                    <option>male</option>
                                   <option>female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="name">Position</label>
                                <input type="text"
                                    name="position"
                                    placeholder="Please fill Position here"
                                    class="form-control input-lg"
                                    v-model="ghost.position">
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-right mt-20">
                        <izy-btn :loading="isLoading" elevated>
                                <i class="ion-android-done-all"></i>
                                Save Team
                        </izy-btn>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>


export default {

    name: 'team-create',

    methods: {
        async create () {
            const isValid = await this.$validator.validate()
            if (!isValid ) return false;

            this.isLoading = true

             axios.post('/invitations', this.ghost).then(
               function(response){;
                 window.location.href = "/teams";
               }

             ).catch(function(error){ console.log(error.message); });

            this.isLoading = false
        }
    }
}
</script>
