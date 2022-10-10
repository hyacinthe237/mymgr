<template>
    <section class="content-body">
        <div class="blocks-items mt-20">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="ion-briefcase"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">#{{ organization.id }}</div>
                                    <div><span>{{ organization.name }}</span></div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <div class="pull-left">
                                    <a href="#" class="item-bottom" >
                                        <i class="ion-android-home"></i> {{ organization.official_name }}
                                    </a>
                                    <p><i class="ion-ios-location"></i>  <span>{{ organization.address }}</span></p>
                                    <p><i class="ion-android-call"></i> {{ organization.phone }}</p>
                                </div>
                                <span class="pull-right"><a href="#" class="btn btn-round btn-primary">
                                    <i class="ion-android-arrow-forward"></i>
                                </a></span>

                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'organization',

    props: ['organization']

}
</script>
