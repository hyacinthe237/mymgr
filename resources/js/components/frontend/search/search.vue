<template>
    <section class="search-page">

        <div class="search-container">

            <div class="search-container" v-if="result.projects.length">
                <h4>Projects</h4>
                <div class="projects-list">
                    <div class="blocks-items mt-20">
                        <ItemProject v-for="item in result.projects" :key="item.id" :project="item" />
                    </div>
                </div>
            </div>
            <div class="search-container" v-if="result.members.length">
                <h4>Members</h4>
                <div class="blocks-team-items mt-20">
                    <div class="row">
                        <div class="col-sm-3" v-for="item in result.members">
                            <ItemMember :member="item" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="search-container" v-if="result.tickets.length">
                <h4>Tickets</h4>
                <div class="blocks-items mt-20">
                    <ItemTicket v-for="item in result.tickets" :key="item.id" :item="item" />
                </div>
            </div>

            <div class="" v-else>
                <div class="sad-block" v-show="noResult && !isLoading">
                    <i class="ion-ios-box-outline"></i>
                    <h5>No result found</h5>
                </div>
            </div>

        </div>



    </section>

</template>

<script>
import ItemMember from '../members/index/member'
import ItemProject from '../projects/item/item'
import ItemTicket from '../tickets/index/item'

export default {
    name: 'search',

    props: ['result'],

    components:{ ItemMember, ItemProject, ItemTicket },

    mounted(){
        console.log(this.result);
    },

    computed: {
        noResult () {
            return this.result.length === 0
        }
    },

    methods: {

    }
}
</script>
