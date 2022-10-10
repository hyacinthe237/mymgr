<template>
    <div class="list-item">
        <div class="row">
            <div class="col-sm-9">
                <div class="item-top">
                    <a :href="url">
                        #{{ item.number }} {{ item.title }}
                    </a>
                </div>

                <div class="item-bottom">
                    <div class="item-bottom">
                        <ul class="list-inline">
                            <li class="bold">
                                <i class="ion-checkmark"></i> {{ status }}
                            </li>

                            <li>
                                <a href="#" title="assignee">
                                    <i class="ion-android-person"></i> {{ assignee }}
                                </a>
                            </li>

                            <li v-show="dueDate">
                                <a href="#" title="date butoire">
                                    <i class="ion-calendar"></i> {{ dueDate }}
                                </a>
                            </li>

                            <li>
                                <i class="ion-android-arrow-up"></i> {{ item.priority | capitalize }}
                            </li>

                            <li>
                                <i class="ion-information-circled"></i> {{ isOpen }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
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
import ticketMixins from '../../tickets/mixins'
import ticketMenu from '../../../../commons/dropdowns/ticket-menu'

export default {
    props: ['item'],
    components: { ticketMenu },
    mixins: [ticketMixins]
}
</script>
