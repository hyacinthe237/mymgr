<template>
    <div class="component-wrapper">
        <izy-loader v-show="isLoading" />

        <div class="block-container">
            <Tabs :active="'documents'" />

            <table class="table mt-20">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="d in documents" :key="d.code">
                        <td scope="row">{{ d.name }}</td>
                        <td class="capitalize">{{ d.status }}</td>

                        <td class="text-right deco-none">
                            <a :href="d.link" target="_blank">
                                <i class="feather icon-external-link pointer mr-10"></i>
                            </a>

                            <i class="feather icon-edit-2 pointer" @click="editDoc(d)"></i>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <EditDocModal 
            :doc="document" 
            @confirmed="getDocuments"
        />
    </div>
    
</template>

<script>
import Tabs from './components/tabs'
import EditDocModal from './components/edit-document-modal'
import userMixins from './mixins'

export default {
    name: 'admin-user-documents',
    mixins: [userMixins],
    components: { Tabs, EditDocModal },

    data: () => ({
        document: {},
        documents: [],
    }),

    mounted () {
        this.getUser()
        this.getDocuments()
    },

    methods: {
        /**
         * Get documents 
         * 
         * @return {void}
         */
        async getDocuments () {
            this.isLoading = true

            let url = `/users/${_uuid}/documents`
    
            const res = await axios.get(url)
                .catch(e => this.catchAlert(e))

            this.isLoading = false

            if (res) {
                let roleDocuments = res.data.roleDocuments
                let userDocuments = res.data.userDocuments

                this.documents = roleDocuments.map(d => {
                    let userDocs = userDocuments.filter(ud => ud.code === d.code)
                    let userDoc = userDocs[userDocs.length - 1] || {}

                    return {
                        id: d.id,
                        name: d.name,
                        code: d.code,
                        link: userDoc.pivot ? userDoc.pivot.link : '--',
                        status: userDoc.pivot ? userDoc.pivot.status : 'requested'
                    }
                })
            }
        },

        /**
         * Edit doc status 
         * 
         * @return {void}
         */
        editDoc (doc) {
            this.document = doc
            $('#editDocModal').modal({ show: true })
        }
    }
}
</script>