require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import {routes} from './routes';


 // Import User Class
 import User from './Helpers/User';
 window.User = User

 //notification
 import Notification from './Helpers/Notification';
 window.Notification = Notification

 window.Reload = new Vue();

 
//sweet alert
import Swal from 'sweetalert2'
window.Swal = Swal

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
})
window.Toast = Toast


//end sweet alert2

const router = new VueRouter({
    routes,
    mode:'history'
  })

const app = new Vue({
    el:'#app',
    router
});