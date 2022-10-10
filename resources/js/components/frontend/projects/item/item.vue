<template>
    <div class="block-item">
        <div class="row">
            <div class="col-sm-10">
                <div class="item-top">
                    <a :href="projectUrl">{{ project.title }}</a>
                </div>

                <div class="item-bottom">
                    <span>
                        <i class="ion-ios-star"></i> <span class="capitalize">{{ project.status }}</span>
                    </span>

                    <a :href="'/members/' + owner.code" title="member name" class="ml-10">
                        <i class="ion-android-person"></i> {{ name }}
                    </a>

                    <a :href="'/projects/categories/' + category.code" title="Category" class="ml-10">
                        <i class="ion-grid"></i> <span class="capitalize">{{ category.name }}</span>
                    </a>
                </div>
            </div>


            <div class="col-sm-2">
                <div class="item-metas">
                    <ul class="list-inline">
                        <li>
                            <a :href="projectUrl + '/tickets'" class="btn btn-round btn-teal">
                                <i class="ion-social-buffer"></i>
                            </a>
                        </li>
                        <li>
                            <a :href="projectUrl" class="btn btn-round btn-primary">
                                <i class="ion-android-arrow-forward"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['project'],

    computed: {
        owner () {
            return this.project.owner
        },

        name () {
            let str = this.owner.firstname
            return str += this.owner.lastname ? ' ' + this.owner.lastname : ''
            return this.owner.firstname + ' ' + this.owner.lastname
        },

        projectUrl () {
            return `/projects/${this.project.code}`
        },

        category () {
            return this.project.category
        }
    }
}
</script>
