<template>
    <div :class="['block-container mb-40', isAdmin ? 'd-none' : '']">
        <izy-loader v-show="isLoading" />

        <div class="header">
            <button 
                class="btn btn-primary float-right"
                @click="addDocument()"
            >Add Document</button>

            <h4 class="bold">
                <i class="feather icon-user"></i>
                {{ role.display_name }}
            </h4>
        </div>

        <table class="table mt-10">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Document Name</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d in documents" :key="d.code">
                    <td>{{ d.name }}</td>

                    <td class="text-right">
                        <button class="btn btn-outline-primary" @click="editDoc(d)">
                            <i class="feather icon-edit-2" ></i>
                            Edit
                        </button>

                        <button class="btn btn-outline-danger" @click="deleteDoc(d)">
                            <i class="feather icon-trash-2" ></i>
                            Remove
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script> 
export default {
    name: 'AdminRole',

    props: {
        role: { type: Object, default: () => {}}
    },


    computed: {
        isAdmin () {
            return this.role.id === 1
        },

        documents () {
            return this.role.documents
        }
    },

    methods: {
        addDocument () {
            this.$emit('addDocument', this.role)
        },

        async editDoc (doc) {
            this.$emit('editDocument', doc)
        },


        async deleteDoc (doc) {
            console.log('Deleting document...', doc)
            this.$emit('removeDocument', doc)
        }
    }

}
</script>