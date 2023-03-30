/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
// For Localization
import i18n from './plugin_settings/vuei18n/i18n'

// For axios
import axios from './plugin_settings/axios/axios'
Vue.prototype.$http = axios

// For Router
import router from './plugin_settings/vuerouter/router'

// For Vuex Store
import store from './plugin_settings/vuex/store'

// Moment for JS Date time
import moment from 'moment';
window.moment = moment;

// Vuetify

import Vuetify from 'vuetify';
Vue.use(Vuetify);
const vuetify = new Vuetify({
    theme: {
      themes: {
            light: {
                primary : '#3F51B5',
                success : '#28C76F',
                danger  : '#EA5455',
                warning : '#FF9F43',

            },
            dark:
            {
                primary : '#673AB7',
                success : '#28C76F',
                danger  : '#EA5455',
                warning : '#FF9F43',
          }
      },
    },
  })

// Ideal vue
import IdleVue from "idle-vue";
const eventsHub = new Vue();
Vue.use(IdleVue, {
    eventEmitter: eventsHub,
    store,
    idleTime: 60000000,
    startAtIdle: false
});

// Vue permission
import LaravelPermissions from 'laravel-permissions';
Vue.use(LaravelPermissions);

// Excel Export
import Vue from 'vue'
import JsonExcel from 'vue-json-excel'
Vue.component('downloadExcel', JsonExcel)

// Perfect Scroll Bar
import PerfectScrollbar from 'vue2-perfect-scrollbar'
import 'vue2-perfect-scrollbar/dist/vue2-perfect-scrollbar.css'
Vue.use(PerfectScrollbar)

//Print Command
import VueHtmlToPaper from 'vue-html-to-paper';

const options = {
  name: '_blank',
  specs: [
    'fullscreen=yes',
    'titlebar=yes',
    'scrollbars=yes'
  ],
  styles: [
    'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
    'https://unpkg.com/kidlat-css/css/kidlat.css'
  ]
}

Vue.use(VueHtmlToPaper, options);

// or, using the defaults with no stylesheet
//Vue.use(VueHtmlToPaper);


// All Registered components
Vue.component('app-component', require('./components/app_components/AppComponent.vue').default);
Vue.component('idle-dialog-component', require('./components/home_components/IdleDialogView').default);

const app = new Vue({
    el: '#app',
    i18n,
    router,
    store,
    vuetify,
});


