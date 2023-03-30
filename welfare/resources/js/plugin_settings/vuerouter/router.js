//  This file contains all route contain
import Vue from 'vue'
import Router from 'vue-router'
import store from '../vuex/store'

Vue.use(Router)

const router = new Router({

    scrollBehavior() {
        return {
            x: 0,
            y: 0
        }
    },
    routes: [{
            path: '/',
            redirect: {
                name: 'Login'
            },
        },
        {

            path: '/login',
            name: 'Login',
            component:require('../../components/login_components/LoginView.vue').default
        },


        {
            path: '/unauthorized',
            name: 'Unauthorized',
            component:require('../../components/login_components/LoginView.vue').default
        },

        {
            path: '/home',
            component: require('../../components/home_components/HomeView.vue').default,
            name: 'Home',
            meta: {
                requiresAuth: true
            },
            children: [

                // System Setting Roles Permission
                {
                    path: 'system-settings/roles-permissions',
                    component: require('../../components/system_settings_components/RolesPermissionsView.vue').default,
                    name: 'SystemSettingsRolesPermissions',
                    meta: {
                        requiresAuth: true
                    },
                },
                 // System Setting Assign  Permission
            {
                path: 'system-settings/assign-permissions/:roleId',
                component: require('../../components/system_settings_components/AssignPermissionsView.vue').default,
                name: 'SystemSettingsAssignPermissions',
                meta: {
                    requiresAuth: true
                },
                },
                 // System Setting Prefix Setting
                 {
                    path: 'system-settings/prefix/',
                    component: require('../../components/system_settings_components/PrefixView.vue').default,
                    name: 'SystemSettingsPrefix',
                    meta: {
                        requiresAuth: true
                    },
                    },
                 // Human Resources Department
                 {
                    path: 'human-resource/department',
                    component: require('../../components/human_resource_components/DepartmentView.vue').default,
                    name: 'HumanResourceDepartment',
                    meta: {
                        requiresAuth: true
                    },
                },

                  // Human Resources Designation
                  {
                    path: 'human-resource/designation',
                    component: require('../../components/human_resource_components/DesignationView.vue').default,
                    name: 'HumanResourceDesignation',
                    meta: {
                        requiresAuth: true
                    },
                },
                   // Human Resources Staff Directory
                 {
                    path: 'human-resource/staff-directory',
                    component: require('../../components/human_resource_components/StaffDirectoryView.vue').default,
                    name: 'HumanResourceStaffDirectory',
                    meta: {
                        requiresAuth: true
                    },
                },

                    // Human Resources Add Satff
                    {
                        path: 'human-resource/add-staff',
                        component: require('../../components/human_resource_components/AddStaffView.vue').default,
                        name: 'HumanResourceAddStaff',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                    },

                     // Collection Entry
                    {
                        path: 'collection-entry/add-collection-entry',
                        component: require('../../components/entry_components/CollectionEntryView.vue').default,
                        name: 'DailyCollectionEntry',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },

                     // Refund Entry
                    {
                        path: 'refund-entry/add-refund-entry',
                        component: require('../../components/entry_components/refundEntryView.vue').default,
                        name: 'DailyRefundEntry',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },

                     // Refund Entry Advocate
                    {
                        path: 'refund-entry/add-refund-entry-by-number',
                        component: require('../../components/entry_components/refundEntrybyNumberView.vue').default,
                        name: 'DailyRefundEntryByNumber',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },


                     // Refund Entry for Notary
                    {
                        path: 'refund-entry/refund-entry-notary',
                        component: require('../../components/entry_components/refundEntryNotary.vue').default,
                        name: 'RefundEntryNotary',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },


                     // Reports Daily Collection
                    {
                        path: 'collection-report/daily-collection-report',
                        component: require('../../components/report_components/dailyCollectionView.vue').default,
                        name: 'DailyCollectionReport',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },

                     // Col & Ref - Notary
                    {
                        path: 'collection-report/collection-vs-refund-report',
                        component: require('../../components/report_components/CollectionVsRefundView.vue').default,
                        name: 'Collection&RefundReport',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },


                
                     // Col & Ref - Advocate
                     {
                        path: 'collection-report/advovcate-collection-vs-refund-report',
                        component: require('../../components/report_components/advocateCollectionVsRefundView.vue').default,
                        name: 'AdvocateCollection&RefundReport',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },

                     // Reports Head Wise Collection
                    {
                        path: 'collection-report/head-wise-collection-report',
                        component: require('../../components/report_components/headWiseCollectionView.vue').default,
                        name: 'DailyCollectionReport',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },

                    // Reports Head Wise Total Collection
                    {
                        path: 'collection-report/head-wise-total-collection-report',
                        component: require('../../components/report_components/headWiseTotalCollectionView.vue').default,
                        name: 'DailyCollectionReport',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },

                    // Dashboard
                    {
                        path: 'dashboard',
                        component: require('../../components/report_components/dashboardView.vue').default,
                        name: 'DashBoard',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },
                      // Menu
                    {
                        path: 'menu',
                        component: require('../../components/report_components/MenuView.vue').default,
                        name: 'Menu',
                        meta: {
                            requiresAuth: true
                        },
                        props:true
                },




             ]
        },
        //   path: '/home',
        //       component: () => import('./layouts/main/Main.vue'),
        //       name: 'Home',
        //       meta: {
        //         requiresAuth: true
        //     },
        //   children: [

        //     {
        //       path: 'system-settings/roles-permissions',
        //       name: 'SystemSettingsRolesPermissions',
        //           component: () => import('./views/lms_views/roles_permissions_views/ShowRolesPermissionsListView.vue'),
        //           meta: {
        //               requiresAuth: true,
        //               breadcrumb: [
        //                 { title: 'Home', url: '/home' },
        //                 { title: 'System Settings'},
        //                 { title: 'Roles Permissions', active: true }
        //               ],
        //         },
        //     },
        //     {
        //       path: 'page2',
        //       name: 'page-2',
        //       component: () => import('./views/Page2.vue')
        //     }
        //   ]
        // },


        // {
        //       path: '/',
        //     redirect:'login',
        //   component: () => import('@/layouts/full-page/FullPage.vue'),
        //   children: [

        //     {
        //       path: 'login',
        //       name: 'Login',
        //       component: () => import('@/views/lms_views/login_views/LoginView.vue')
        //     },
        //
        //   ]
        // },
        // Redirect to 404 page, if no match found
        //{
        // path: '*',
        //redirect: '/pages/error-404'
        //}
    ]
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
export default router
