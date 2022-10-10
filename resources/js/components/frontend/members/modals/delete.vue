<template>
   <div class="modal animated fadeIn" id="deleteUserConfirm">
       <div class="modal-dialog" role="document">
           <div class="modal-content">

               <!-- Deleting -->
               <div class="_modal-content">
                   <h5 class="text-center">{{ message }}</h5>

                   <div class="mt-20">
                       <div class="col-s12 pull-right">
                           <button class="btn btn-primary btn-margin" @click="confirm()">
                               <i class="feather icon-check"></i>
                              Confirmer
                           </button>

                           <button class="btn btn-grey pull-right" @click="closeAllModals()">
                               <i class="feather icon-corner-up-left"></i>
                               Annuler
                           </button>
                       </div>
                   </div>
               </div>

           </div>
       </div>
   </div>
</template>

<script>
export default {
   props: {
       message: {
           type: String,
           default: 'Voulez vous vraiment supprimer cet utilisateur ?'
       }
   },

   methods: {
       confirm () {
           this.$emit('confirmed')
       }
   }
}
</script>
