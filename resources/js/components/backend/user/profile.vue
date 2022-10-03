<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />

        <div class="block-container">
            <Tabs :active="'profile'"/>

            <div class="header">
                <h5 class="text-right capitalize">
                    Status: <span :class="`profile-status ${user.status}`">{{ user.status}}</span>
                </h5>
            </div>


            <div class="pl-20 pr-20">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="profile-photo pb-20">
                            <img :src="profile" class="img-fluid">

                            <a 
                                class="btn btn-primary btn-round mt-20 w-200"
                                :href="`/admin/acl/users/${user.code}/edit`"
                            >
                                <i class="feather icon-edit-2"></i> Edit Profile
                            </a>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="data-row">
                            <div class="label">Usertype</div>
                            <div class="value">{{ role.display_name }}</div>
                        </div>

                        <div class="data-row">
                            <div class="label">Username</div>
                            <div class="value">@{{ user.username }}</div>
                        </div>

                        <div class="data-row">
                            <div class="label">Name</div>
                            <div class="value">{{ name }}</div>
                        </div>

                        <div class="data-row">
                            <div class="label">Born</div>
                            <div class="value">{{ user.date_of_birth | date('DD MMMM YYYY') }}</div>
                        </div>

                            <div class="data-row">
                            <div class="label">Sex</div>
                            <div class="value capitalize">{{ user.sex }}</div>
                        </div>
                    </div>

                        <div class="col-sm-5">
                            <div class="data-row">
                            <div class="label">Email</div>
                            <div class="value">{{ user.email }}</div>
                        </div>

                        <div class="data-row">
                            <div class="label">Mobile</div>
                            <div class="value">{{ user.mobile }}</div>
                        </div>

                        <div class="data-row">
                            <div class="label">Address</div>
                            <div class="value">{{ address }}</div>
                        </div>

                        <div class="data-row">
                            <div class="label">Ratings</div>
                            <div class="value">
                                <i class="feather icon-star"></i> {{ user.ratings || 'None' }}
                            </div>
                        </div>

                        <div class="data-row">
                            <div class="label">Joined</div>
                            <div class="value">{{ user.created_at | date('DD MMMM YYYY') }}</div>
                        </div>
                    </div>
                </div>

                <div class="pb-20"></div>
            </div>
        </div>
    </div>
    
</template>

<script>
import Tabs from './components/tabs'
import userMixins from './mixins'

export default {
    name: 'admin-user-profile',
    mixins: [userMixins],
    components: { Tabs },

    mounted () {
        this.getUser()
    },

    computed: {
        profile () {
            return this.user.profile || '/profile.jpg'
        },

        name () {
            let str = ''
            if (this.user.firstname) str += this.user.firstname 
            if (this.user.middle_name) str += ' ' + this.user.middle_name 
            if (this.user.lastname) str += ' ' + this.user.lastname 
            return str
        },

        role () {
            return this.user.role || {}
        },

        address () {
            let str = ''
            if (this.user.address) str += this.user.address
            if (this.user.suburb) str += ', ' + this.user.suburb
            if (this.user.state) str += ', ' + this.user.state.toUpperCase()
            if (this.user.postcode) str += ', ' + this.user.postcode
            return str
        }
    },

    methods: {
        
    }
}
</script>