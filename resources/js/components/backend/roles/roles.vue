<template>
    <div class="component-wrapper">
        <Role 
            v-for="r in roles" :key="r.id" :role="r" 
            @getRoles="getRoles"
            @addDocument="addDocument"
            @editDocument="editDocument"
            @removeDocument="removeDocument"
        />

        <AddDocModal 
            :r="role"
            @getRoles="getRoles"
        />

        <EditDocModal 
            :doc="document"
            @getRoles="getRoles"
        />

        <izy-confirm 
            :confirmMessage="deleteConfirmMessage"
            :confirmButton="'Yes, Delete'"
            :id="'removeDocConfirm'"
            @confirmed="deleteDoc"
        />
    </div>
    
</template>

<script>
import Role from './components/role' 
import AddDocModal from './components/add-modal'
import EditDocModal from './components/edit-modal'

export default {
    name: 'admin-roles',
    components: { Role, AddDocModal, EditDocModal },

    data: () => ({
        role: {},
        roles: [],
        document: {},
        deleteConfirmMessage: ''
    }),

    mounted () {
        this.getRoles()
    },

    methods: {
        async getRoles () {
            this.isLoading = true

            let url = `/roles?include=documents`
    
            const res = await axios.get(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.roles = res.data
            }
        },


        addDocument (role) {
            this.role = Object.assign({}, role)

            setTimeout(() => {
                $('#addDocModal').modal('show')
            }, 250)
        },

        editDocument (doc) {
            this.document = Object.assign({}, doc)

            setTimeout(() => {
                $('#editDocModal').modal('show')
            }, 250)
        },

        removeDocument (doc) {
            this.document = Object.assign({}, doc)
            this.deleteConfirmMessage = `Are you sure you want to remove ${doc.name} from the list of required documents?`

            setTimeout(() => {
                $('#removeDocConfirm').modal('show')
            }, 250)
        },


        /**
         * Delete a document from a role
         * 
         * @return {void}
         */
        async deleteDoc () {
            this.isLoading = true

            let url = `/documents/${this.document.code}`
    
            const res = await axios.delete(url)
                .catch (e => {
                    console.log(e)
                    const message = e.response.data.message || e.response.data.msg || e.response.data
                    this.$swal.error(message)
                })

            this.isLoading = false

            if (res) {
                this.$toastr.success('Document successfully deleted')
                this.getRoles()
            }
        }
    }
}
</script>