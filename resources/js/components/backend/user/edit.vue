<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />

        <div class="block-container">
            <div class="pd-20">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="profile-photo pb-20">
                            <img :src="profile" class="img-fluid">

                            <!-- <button 
                                class="btn btn-primary btn-round mt-20 w-200"
                            >
                                <i class="feather icon-image"></i> Change Photo
                            </button> -->
                        </div>
                    </div>

                    <div class="col-sm-9">
                        <form class="_form mb mt-10" @submit.prevent="save">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Status') }}</span>
                                            </div>

                                            <select name="status" v-model="ghost.status">
                                                <option 
                                                    v-for="(r, index) in statuses"
                                                    :key="index + 1"
                                                    :value="r" v-translate
                                                >{{ r }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Usertype') }}</span>
                                            </div>

                                            <select name="role" v-model="ghost.role_id">
                                                <option 
                                                    v-for="r in roles"
                                                    :key="r.id"
                                                    :value="r.id" v-translate
                                                >{{ r.display_name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Sex') }}</span>
                                            </div>

                                            <select name="role" v-model="ghost.sex">
                                                <option 
                                                    v-for="gender in genders" 
                                                    :value="gender.name" 
                                                    :key="gender.name"
                                                >{{ gender.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of dropdown  -->


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('First name') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="firstname"
                                                autocomplete="off" 
                                                placeholder="First name"
                                                v-model="ghost.firstname"
                                                v-validate="'required|min:2'"
                                            >
                                            <izy-error :name="'firstname'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Middle name') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="middlename"
                                                autocomplete="off" 
                                                placeholder="Middle name"
                                                v-model="ghost.middlename"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Last name') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="lastname"
                                                autocomplete="off" 
                                                placeholder="Last name"
                                                v-model="ghost.lastname"
                                                v-validate="'required|min:2'"
                                            >
                                            <izy-error :name="'lastname'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of names  -->


                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Username') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="username"
                                                autocomplete="off" 
                                                placeholder="Username"
                                                v-model="ghost.username"
                                                v-validate="'required|min:3'"
                                            >
                                            <izy-error :name="'username'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Email') }}</span>
                                            </div>

                                            <input 
                                                type="email"
                                                name="email"
                                                autocomplete="off" 
                                                placeholder="Email"
                                                v-model="ghost.email"
                                                v-validate="'required|email'"
                                            >
                                            <izy-error :name="'email'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Mobile') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="mobile"
                                                autocomplete="off" 
                                                placeholder="Mobile"
                                                v-model="ghost.mobile"
                                                v-validate="'required|min:3'"
                                            >
                                            <izy-error :name="'mobile'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of contacts  -->

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Address') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="address"
                                                autocomplete="off" 
                                                placeholder="Address"
                                                v-model="ghost.address"
                                                v-validate="'required|min:2'"
                                            >
                                            <izy-error :name="'address'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Suburb') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="suburb"
                                                autocomplete="off" 
                                                placeholder="Suburb"
                                                v-model="ghost.suburb"
                                                v-validate="'required|min:2'"
                                            >
                                            <izy-error :name="'suburb'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('State') }}</span>
                                            </div>

                                            <select name="state" v-model="ghost.state">
                                                <option 
                                                    v-for="(r, index) in states"
                                                    :key="index + 1"
                                                    :value="r.short" v-translate
                                                >{{ r.short.toUpperCase() }}</option>
                                            </select>
                                            <izy-error :name="'address'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <div class="field-wrapper">
                                            <div class="field-placeholder">
                                                <span>{{ t('Postcode') }}</span>
                                            </div>

                                            <input 
                                                type="text"
                                                name="postcode"
                                                autocomplete="off" 
                                                placeholder="Postcode"
                                                v-model="ghost.postcode"
                                                v-validate="'required|min:2'"
                                            >
                                            <izy-error :name="'postcode'" :show="showErrors" :err="errors"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            


                            <div class="text-right">
                                <button
                                    class="btn btn-primary w-150"
                                    :disabled="isLoading"
                                    type="submit"
                                >{{ isLoading ? 'Loading...' : 'Save Profile' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</template>

<script>
import userMixins from './mixins'

export default {
    name: 'admin-user-profile',
    mixins: [userMixins],

    data: () => ({
        showErrors: true,
        statuses: [],
        lists: [],
        roles: [],
        genders: [{ name: 'Female' }, { name: 'Male' }, { name: 'Other' }],
    }),

    mounted () {
        this.getUser()
        this.getRoles()
        this.getLists()

        this.statuses = [
            'active', 'blocked', 'pending'
        ]
    },

    computed: {
        states () {
            return this.lists['states']
        },

        profile () {
            return this.user.profile || '/profile.jpg'
        },

        role () {
            return this.user.role || {}
        },
    },

    methods: {
        async getRoles () {
            const res = await axios.get('/roles')
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            if (res) {
                this.roles = res.data
            }
        },


        async getLists () {
            const res = await axios.get('/lists')
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            if (res) {
                this.lists = res.data
            }
        },


        async save () {
            this.isLoading = true

            let url = `/users/${this.user.code}`
    
            const res = await axios.patch(url, this.ghost)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$toastr.error(message)
                })

            this.isLoading = false

            if (res) {
                this.$toastr.success('User successfully updated')
            }
        }
    }
}
</script>