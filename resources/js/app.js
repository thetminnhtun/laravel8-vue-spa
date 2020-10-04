require('./bootstrap');
window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform';
import Swal from 'sweetalert2';
import VueProgressBar from 'vue-progressbar';
import Loading from 'vue-loading-overlay';

Vue.use(Loading, {
    color: '#3490dc',
    width: '45px',
    height: '45px'
});

Vue.use(VueProgressBar, {
    color: '#3490dc',
    failedColor: 'red',
    thickness: '5px'
})


Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('product-component', require('./components/ProductComponent.vue').default);

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
})

window.Form = Form;
window.Swal = Swal;


const app = new Vue({
    el: '#app',
});
