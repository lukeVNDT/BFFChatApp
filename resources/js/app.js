
require('./bootstrap');

window.Vue = require('vue').default;


// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('chat-section', require('./components/ChatSection.vue').default);
// Vue.component('layout-component', require('./layout/LayoutComponent').default);
Vue.component('side-chat', require('./components/SideChat.vue').default);
// Vue.component('chat-component', require('./components/ChatComponent.vue').default);
// Vue.component('master-layout', require('./components/MasterLayout.vue').default);
Vue.component('profile-component', require('./components/ProfileComponent.vue').default);
Vue.component('other-profile', require('./components/OtherProfile.vue').default);


import moment from 'moment';

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('MM/DD/YYYY hh:mm')
    }
});



import Swal from 'sweetalert2';
import Vue from 'vue';
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  });

window.Toast = Toast;



import VueRouter from 'vue-router';
import routes from './routes';

// use router
Vue.use(VueRouter);

// define to use this routes
const router = new VueRouter({
    routes,
    mode: 'history'
});





const app = new Vue({
    el: '#app',
    router
});
