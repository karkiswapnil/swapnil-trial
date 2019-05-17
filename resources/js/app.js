/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue');
import { Form, HasError, AlertError } from 'vform';
import moment from 'moment';

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);


window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, options)
const options = {
  color: '#bffaf3',
  failedColor: '#874b4b',
  thickness: '5px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'left',
  inverse: false
}

import Swal from 'sweetalert2'
window.Swal=Swal;

Vue.component('pagination', require('laravel-vue-pagination'));



const routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default},
    { path: '/developer', component: require('./components/Developer.vue').default},
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/userPosts', component: require('./components/UserPosts.vue').default },
    { path: '/mailSubscribers', component: require('./components/MailSubscribers.vue').default },
    
    //keep at last
    //not found page for unknown routes
    { path: '*', component: require('./components/NotFound.vue').default }
  ]

  const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
  })

  Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
  })

  Vue.filter('myDate',function (created){
    return moment(created).format("MMM Do YY");
  })

window.Fire = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
  'not-found',
  require('./components/NotFound.vue').default
);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data:{
      search: ''
    },
    methods:{
      searchIt: _.debounce(()=>{
        Fire.$emit("searching");
        console.log('searching...');
      },1000),

      printMe(){
          window.print();
      }
    }
});
