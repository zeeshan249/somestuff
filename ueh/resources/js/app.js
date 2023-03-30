/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const eventsHub = new Vue();
import IdleVue from "idle-vue";


// Use vuetify

import Vuetify from 'vuetify';
Vue.use(Vuetify);

//End

window.axios.defaults.baseURL = process.env.MIX_BASE_URL + "/api/";
//Vue Router

import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [{
        path: '/',
        redirect: {
            name: 'Login'
        },

    },
    {
        path: '/login',
        name: 'Login',
        component: require('./components/login_components/LoginComponent.vue').default,


    },
    {
        path: '/home',
        component: require('./components/home_components/HomeComponent.vue').default,
        name: 'Home',
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: 'executive',
                component: require('./components/executive_member_components/ExecutivePendingApprovedRejectedMasterComponent.vue').default,
                name: 'Executive',
                meta: {
                    requiresAuth: true
                },
            },
            {
                path: 'franchise',
                component: require('./components/franchise_components/FranchisePendingApprovedRejectedMasterComponent.vue').default,
                name: 'Franchise',
                meta: {
                    requiresAuth: true
                },
            },
            {
                path: 'certificate',
                component: require('./components/certificate_components/CertificateFromNavigationComponent.vue').default,
                name: 'Certificate',
                meta: {
                    requiresAuth: true
                },
            },
            {
                path: 'student',
                component: require('./components/student_components/StudentFromNavigationComponent.vue').default,
                name: 'Student',
                meta: {
                    requiresAuth: true
                },
            },

        ]
    },


]

const router = new VueRouter({

    routes // short for `routes: routes`
})
router.beforeEach((to, from, next) => {

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.loginState.isLoggedIn) {
        // redirect to login page
        next({ name: 'Login' })
        return
    }

    // if logged in redirect to dashboard
    if (to.path === '/login' && store.state.loginState.isLoggedIn)
    {

        next({ name: 'Home' })
        return
    }

    next()
})
// Vue router End


// Translation

import Vuex from 'vuex';
import vuexI18n from 'vuex-i18n';
import Locales from './vue-i18n-locales.generated.js';
const store = new Vuex.Store({
    state: {

        loginState: {
            isLoggedIn: !!localStorage.getItem('token'),
            logInUserData: null,



        },
        permissionState: {
            userPermissionData: null,

        }
    },
    mutations: {
        setLogInUserData(state, data) {
            state.loginState.isLoggedIn = true;
            localStorage.setItem('token', data.access_token);
            localStorage.setItem('loggedUserId', data.user_data.user_id);
            localStorage.setItem('theme', 'light');
            router
                .push({
                    path: "/home/franchise"
                });
        },
        setLogoutUserData(state) {
            state.loginState.isLoggedIn = false
            localStorage.removeItem('token')
            localStorage.removeItem('loggedUserId')
            localStorage.removeItem('theme')
            router.push({
                name: 'Login'
            })
        },
        setLogInDataForHomePage(state,data) {
            state.loginState.isLoggedIn = true
            localStorage.setItem('loggedUserId', data.user_id);
            state.loginState.logInUserData = data;

        },
        setUserPermission(state,data) {

                state.permissionState.userPermissionData=data
        },
    },
    actions: {

        actionLogout({ commit }) {

            axios
            .post("auth/web_logout")
                .then(({ data }) =>
                {
                commit('setLogoutUserData')
            })
            .catch(error => {});
        },

    },
    getters: {
        getUserPermission(state)
        {

                return state.permissionState.userPermissionData

        }

    }
});
Vue.use(vuexI18n.plugin, store);
Vue.i18n.add('en', Locales.en);
Vue.i18n.add('de', Locales.de);
Vue.i18n.set('en');

//Translation End


Vue.use(IdleVue, {
    eventEmitter: eventsHub,
    store,
    idleTime: 600000,
    startAtIdle: false
});

import moment from 'moment';
window.moment = moment;
// Excel export Start

import Vue from 'vue'
import JsonExcel from 'vue-json-excel'
Vue.component('downloadExcel', JsonExcel)

//Excel export End
Vue.directive('can', function (el, binding, vnode) {

    if(store.getters.getUserPermission.indexOf(binding.value) !== -1){
       return vnode.elm.hidden = false;
    }else{
       return vnode.elm.hidden = true;
    }
})
// All Registered Component
Vue.component('app-component', require('./components/app_components/AppComponent.vue').default);
Vue.component('idle-dialog-component', require('./components/home_components/IdleDialogComponent.vue').default);

Vue.component('franchise-pending-approved-rejected-component', require('./components/franchise_components/FranchisePendingApprovedRejectedMasterComponent.vue').default);
Vue.component('franchise-applied-component', require('./components/franchise_components/FranchiseAppliedComponent.vue').default);
Vue.component('franchise-approve-reject-dialog-component', require('./components/franchise_components/FranchiseApproveRejectDialogComponent.vue').default);
Vue.component('franchise-view-details-dialog-component', require('./components/franchise_components/FranchiseViewDetailsDialogComponent.vue').default);
Vue.component('franchise-approved-component', require('./components/franchise_components/FranchiseApprovedComponent.vue').default);
Vue.component('franchise-rejected-component', require('./components/franchise_components/FranchiseRejectedComponent.vue').default);


Vue.component('executive-pending-approved-rejected-component', require('./components/executive_member_components/ExecutivePendingApprovedRejectedMasterComponent.vue').default);
Vue.component('executive-applied-component', require('./components/executive_member_components/ExecutiveAppliedComponent.vue').default);
Vue.component('executive-approve-reject-dialog-component', require('./components/executive_member_components/ExecutiveApproveRejectDialogComponent.vue').default);
Vue.component('executive-view-details-dialog-component', require('./components/executive_member_components/ExecutiveViewDetailsDialogComponent.vue').default);
Vue.component('executive-approved-component', require('./components/executive_member_components/ExecutiveApprovedComponent.vue').default);
Vue.component('executive-rejected-component', require('./components/executive_member_components/ExecutiveRejectedComponent.vue').default);




Vue.component('student-active-certified-master-component', require('./components/student_components/StudentActiveCertifiedMasterComponent.vue').default);
Vue.component('student-active-component', require('./components/student_components/StudentActiveComponent.vue').default);
Vue.component('student-certified-component', require('./components/student_components/StudentCertifiedComponent.vue').default);
Vue.component('student-certificate-request-generated-component', require('./components/student_components/StudentCertificateRequestGeneratedComponent.vue').default);
Vue.component('student-view-details-dialog-component', require('./components/student_components/StudentViewDetailsDialogComponent.vue').default);




Vue.component('certificate-generated-processed-rejected-master-component', require('./components/certificate_components/CertificateGeneratedProcessedRejectedMasterComponent.vue').default);
Vue.component('certificate-generated-component', require('./components/certificate_components/CertificateGeneratedComponent.vue').default);
Vue.component('certificate-processed-component', require('./components/certificate_components/CertificateProcessedComponent.vue').default);
Vue.component('certificate-rejected-component', require('./components/certificate_components/CertificateRejectedComponent.vue').default);



// Registered component end


const app = new Vue({
    el: '#app',
    router,
    store,
    vuetify: new Vuetify(),
});
