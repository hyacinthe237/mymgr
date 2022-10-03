<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />

        <div class="block-container">
            <Tabs :active="'payments'" />

            <table class="table mt-20">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Reference</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
    
</template>

<script>
import Tabs from './components/tabs'
import userMixins from './mixins'

export default {
    name: 'admin-user-payments',
    mixins: [userMixins],
    components: { Tabs },

    mounted () {
        this.getUser()
    },

    methods: {
        
    }
}
</script>