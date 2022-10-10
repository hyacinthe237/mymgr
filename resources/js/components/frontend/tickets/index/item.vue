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
                    <a :href="url">{{ item.title }}</a>
                </div>

                <div class="item-bottom">
                    <a href="#" title="project name">
                        <i class="ion-briefcase"></i>{{ item.project.title }}
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
                        <i class="ion-android-arrow-up"></i> {{ item.priority | capitalize }}
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
                                @footerClicked="closeTicket"
                                :footer="closeFooterMessage"
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
import ticketMixins from '../mixins'
import ticketMenu from '../../../../commons/dropdowns/ticket-menu'

export default {
    props: ['item'],
    components: { ticketMenu },
    mixins: [ticketMixins]
}
</script>
