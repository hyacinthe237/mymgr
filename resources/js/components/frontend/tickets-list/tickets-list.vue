<template>

    <div class="block-item">
        <div class="row">
            <div class="col-sm-2">
                <div class="item-top bold">
                    <a :href="url">#{{ item.number }}</a>
                </div>

                <div class="item-bottom">
                    <a href="" title="item statut">
                       <i class="ion-ios-star"></i> {{ status }}
                    </a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="item-top">
                    <span>{{ item.title }}</span>
                </div>

                <div class="item-bottom">
                    <a href="#" title="project name">
                        <i class="ion-briefcase"></i>{{ item.project.title}}
                    </a>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="item-top" >
                    <i class="ion-android-person"></i> {{ assignee }}
                </div>

                <div class="item-bottom">
                    <div class="item-left">
                        <span v-if="dueDate"><i class="ion-calendar"></i> {{ dueDate }}</span>
                        <i class="ion-ios-time"></i> {{ item.priority }}
                        <i class="ion-information-circled"></i> {{ isOpen }}
                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="item-metas">
                    <ul class="list-inline">
                        <li>
                            <a ref="#" data-toggle="dropdown" class="dropdown-toggle btn btn-round btn-dark">
                                <i class="ion-close"></i>
                            </a>

                            <ticketMenu
                                @footerClicked="closeTicket"
                                :footer="closeFooterMessage"
                                :title="'Close/Reopen ticket'">
                            </ticketMenu>
                        </li>

                        <li>
                            <a ref="#" data-toggle="dropdown" class="dropdown-toggle btn btn-round btn-success">
                                <i class="ion-checkmark"></i>
                            </a>

                            <ticketMenu
                                :items="formattedCategories"
                                :id="item.status"
                                @selected="statusChanged"
                                :title="'Set status'">
                            </ticketMenu>
                        </li>

                        <li class="context-menu dropdown">
                            <a ref="#" data-toggle="dropdown" class="dropdown-toggle btn btn-round btn-primary">
                                <i class="ion-android-person"></i>
                            </a>

                            <ticketMenu
                                :items="formattedMembers"
                                :active="{}"
                                :id="item.assignee_id"
                                :footer="'Unassign'"
                                @selected="assigned"
                                @footerClicked="footerClicked"
                                :icon="'ion-android-person'"
                                :title="'Assigned to'">
                            </ticketMenu>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import moment from 'moment'
import ticketMixins from '../tickets/mixins'
import ticketMenu from '../../../commons/dropdowns/ticket-menu'

export default {

    props: ['item'],
    components: { ticketMenu },
    mixins: [ticketMixins],

    computed: {
        url () {
            return `/tickets/${this.item.number}`
        },

        status () {
            return this.item.category ? this.item.category.name : ''
        },

        assignee () {
            let str = 'Unassigned'
            if (this.item.assignee !== null & this.item.assignee !== undefined) {
                str = this.item.assignee.firstname + ' ' + this.item.assignee.lastname
            }
            return str
        },

        dueDate () {
            let date = ''
            if (this.item.end_date) {
                date = moment(this.item.end_date).format('DD/MM/YYYY')
            }
            return date
        },

        noTicket () {
            return this.item.length === 0
        },

        isOpen () {
            let isopen = ''
            if (this.item.is_open !== false) {
                isopen = 'Open'
            } else {
                isopen = 'Resolved'
            }
            return isopen
        }
    }
}

</script>
