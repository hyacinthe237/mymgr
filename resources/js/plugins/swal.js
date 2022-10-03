
import Swal from 'sweetalert2'
var Al = {}

Al.install = function (Vue) {
    Vue.prototype.$swal = {
        success(title, msg) {
            return Swal.fire({
                title,
                text: msg ? msg : '',
                type: 'success'
            })
        },

        error(title, text) {
            Swal.fire({
                type: 'error',
                icon: 'error',
                title,
                text
            })
        }
    }
}

export default Al