<template>
  <v-app>
       <v-overlay :value="isLoaderActive" color="primary">
      <v-progress-circular indeterminate size="64"
      color="primary"

      ></v-progress-circular>
    </v-overlay>

    <idle-dialog-component :isIdleDialogProp="isIdle"></idle-dialog-component>

    <v-navigation-drawer v-model="drawer" :clipped="$vuetify.breakpoint.lgAndUp" app>
      <v-list dense>
        <v-list-item class="px-2">
          <v-list-item-avatar size="48">
            <v-img :src="loggedUserProfileImage" :lazy-src="loggedUserProfileImage">
              <template v-slot:placeholder>
                <v-row class="fill-height ma-0" align="center" justify="center">
                  <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                </v-row>
              </template>
            </v-img>
          </v-list-item-avatar>

          <v-list-item link class="pl-0">
            <v-list-item-content>
              <v-list-item-title class="m-0 p-o">
                <h5>{{ loggedUserName}}</h5>
              </v-list-item-title>
              <v-list-item-subtitle>
                <v-icon small color="gray darken-2">mdi-phone</v-icon>
                {{ loggedUserMobileNumber}}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-list-item>
      </v-list>

      <v-divider class="mt-0 mb-0"></v-divider>
      <perfect-scrollbar>
      <v-list shaped dense>


<template>

              <v-list-group prepend-icon="mdi-file-tree" icon-alt="mdi-file-tree" append-icon >
            <template v-slot:activator>
              <v-list-item-content>

                <v-list-item-title  v-text="labelHumanResource"></v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item v-permission="'Department'" to="/home/human-resource/department"
            class="text-decoration-none  mb-1"
            exact-active-class="primary"
            color="white"
            ><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title v-text="labelDepartment"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item v-permission="'Designation'" to="/home/human-resource/designation"
            class="text-decoration-none  mb-1"
             exact-active-class="primary"
            color="white"
            ><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title v-text="labelDesignation"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>


             <v-list-item v-permission="'Staff'" to="/home/human-resource/staff-directory"

              class="text-decoration-none  mb-1"
               exact-active-class="primary"
            color="white"
              ><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title v-text="labelStaffDirectory"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>


            <v-list-item v-permission="'Edit Enquiry'" to="/home/system-settings/roles-permissions" class="text-decoration-none  mb-1"
             exact-active-class="primary"
            color="white"
            ><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Edit Roles</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

          </v-list-group></template>


<template>
          <v-list-group prepend-icon="mdi-reorder-horizontal" icon-alt="mdi-reorder-horizontal" append-icon >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title>Entry</v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item v-permission="'Add Enquiry'" to="/home/collection-entry/add-collection-entry" class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white"><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Collection Entry</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item v-permission="'Delete Enquiry'" to="/home/refund-entry/add-refund-entry" class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white"><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Refund Entry - LA</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

             <v-list-item v-permission="'Delete Enquiry'" to="/home/refund-entry/add-refund-entry-by-number" class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white"><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Advocate Refund- Barcode</v-list-item-title>
              </v-list-item-content>
            </v-list-item>


             <v-list-item v-permission="'Delete Enquiry'" to="/home/refund-entry/refund-entry-notary" class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white"><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Notary Refund- Barcode</v-list-item-title>
              </v-list-item-content>
            </v-list-item>


          </v-list-group></template>
          <template>
          <v-list-group prepend-icon="mdi-database" icon-alt="mdi-database" append-icon >
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title>Reports</v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item v-permission="'Add Enquiry'" to="/home/collection-report/daily-collection-report" class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white" ><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content >
                <v-list-item-title>Daily Collection</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item v-permission="'Delete Enquiry'" to="/home/collection-report/head-wise-collection-report" class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white"><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Head Wise Collection</v-list-item-title>
              </v-list-item-content>
            </v-list-item>


             <v-list-item v-permission="'Delete Enquiry'" to="/home/collection-report/head-wise-total-collection-report" class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white"><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Daily Refund</v-list-item-title>
              </v-list-item-content>
            </v-list-item>



             <v-list-item v-permission="'Add Enquiry'" to="/home/collection-report/collection-vs-refund-report" class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white" ><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content >
                <v-list-item-title>Col & Ref - Notary</v-list-item-title>
              </v-list-item-content>
            </v-list-item>


        <v-list-item v-permission="'Add Enquiry'" to="/home/collection-report/advovcate-collection-vs-refund-report" class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white" ><v-list-item-action>

              </v-list-item-action>
              <v-list-item-content >
                <v-list-item-title>Col & Ref - Advocate</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group></template>







        <template>
          <v-list-group prepend-icon="mdi-flower" icon-alt="mdi-flower" append-icon >
                       <template v-slot:activator>
              <v-list-item-content>

                <v-list-item-title v-text="labelSystemSettings"></v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item v-permission="'Roles Permissions'"
                to="/home/system-settings/roles-permissions"
            class="text-decoration-none mb-1"
            exact-active-class="primary"
            color="white">
              <v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title v-text="labelRolesAndPermissions"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>

 <v-list-item v-permission="'Prefix'"
                to="/home/system-settings/prefix"
            class="text-decoration-none mb-1"
            exact-active-class="primary"
            color="white">
              <v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title v-text="labelPrefix"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item v-permission="'General Setting'"
                to="/home/system-settings/roles-permissions"
            class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white"
        >
              <v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>General Setting</v-list-item-title>
              </v-list-item-content>
            </v-list-item>


            <v-list-item v-permission="'Session Setting'"
                to="/home/system-settings/roles-permissions"
            class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white"
   >
              <v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Session Setting</v-list-item-title>
              </v-list-item-content>
            </v-list-item>


            <v-list-item v-permission="'SMS Setting'"
                to="/home/system-settings/roles-permissions"
            class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white"
         >
              <v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>SMS Setting</v-list-item-title>
              </v-list-item-content>
            </v-list-item>


            <v-list-item v-permission="'Email Setting'"
                to="/home/system-settings/roles-permissions"
            class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white"
      >
              <v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Email Setting</v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item v-permission="'User Status'"
                to="/home/dashboard"
            class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white">
              <v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Dashboard</v-list-item-title>
              </v-list-item-content>
            </v-list-item>


            <v-list-item v-permission="'User Status'"
                to="/home/menu"
            class="text-decoration-none  mb-1"  exact-active-class="primary"
            color="white">
              <v-list-item-action>

              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Menu</v-list-item-title>
              </v-list-item-content>
            </v-list-item>





          </v-list-group>




        </template>

      </v-list>
</perfect-scrollbar>
    </v-navigation-drawer>


    <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app color="primary" dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
        <span class="hidden-sm-and-down">
          <strong>{{$t('label_company_name')}}</strong>

        </span>
      </v-toolbar-title>

      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>mdi-apps</v-icon>
      </v-btn>
      <v-btn icon>
        <v-badge color="green" content="6" left>
          <v-icon>mdi-bell</v-icon>
        </v-badge>
      </v-btn>

      <v-menu transition="slide-y-transition" bottom max-width="250px">
        <template v-slot:activator="{ on }">
          <v-btn icon large v-on="on">
            <v-avatar size="32px" item>
              <v-img :src="loggedUserProfileImage" :lazy-src="loggedUserProfileImage">
                <template v-slot:placeholder>
                  <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                  </v-row>
                </template>
              </v-img>
            </v-avatar>
          </v-btn>
        </template>

        <v-card>
          <v-list>
            <v-list-item>
              <v-list-item-avatar>
                <v-img :src="loggedUserProfileImage" :lazy-src="loggedUserProfileImage">
                  <template v-slot:placeholder>
                    <v-row class="fill-height ma-0" align="center" justify="center">
                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                    </v-row>
                  </template>
                </v-img>
              </v-list-item-avatar>

              <v-list-item-content>
                <v-list-item-title class="m-0 p-o">
                  <h5>{{ loggedUserName}}</h5>
                </v-list-item-title>
                <v-list-item-subtitle>
                  <v-icon small color="gray darken-2">mdi-phone</v-icon>
                  {{ loggedUserMobileNumber}}
                </v-list-item-subtitle>
              </v-list-item-content>
            </v-list-item>
          </v-list>

          <v-divider class="p-0 m-0"></v-divider>

          <v-list dense>
            <v-list-item-group>
              <v-list-item @click="logout">
                <v-list-item-icon>
                  <v-icon>mdi-exit-to-app</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                  <v-list-item-title>{{$t('label_logout')}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item>
                <v-list-item-icon>
                  <v-icon>mdi-dots-vertical-circle</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                  <v-list-item-title>{{this.$t("label_system_settings")}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-card>
      </v-menu>
    </v-app-bar>
 <transition
        name="fade"
        mode="out-in"
      >
    <router-view :userPermissionDataProps="userPermissionData" v-if="userPermissionData!=null"></router-view>
 </transition>

  </v-app>

</template>

<script>
// To secure local storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });


export default {

  data() {
    return {

// Authorization token
      authorizationConfig: "",
      // For loader

      isLoaderActive: false,


      // Navigation Drawer & App Bar

       drawer: null,
      loggedUserName: "",
      loggedUserProfileImage: "",
      loggedUserMobileNumber: "",
      labelSystemSettings:this.$t('label_system_settings'),
      labelRolesAndPermissions:this.$t('label_roles_and_permissions'),
      labelHumanResource:this.$t('label_human_resource'),
      labelDepartment:this.$t('label_department'),
      labelDesignation:this.$t('label_designation'),
      labelPrefix:this.$t('label_prefix'),
      labelStaffDirectory:this.$t('label_staff_directory'),


      // Form Data processing
      userPermissionData:null,
      isFormDataProcessing:true,

    };
  },
  computed: {
      // For Idle Componenet
    isIdle() {
      return this.$store.state.idleVue.isIdle;
    }
  },
  created() {


      // Enable loader
    this.isLoaderActive = true;
    // Set authorization token
    this.authorizationConfig = {
      headers: { Authorization: "Bearer " + ls.get("token") }
    };
    // Get Logged User Permission & role

    this.$http
      .post(
        "auth/web_get_logged_user_details_with_role_permission",
        "",
        this.authorizationConfig
      )
      .then(({ data }) => {
        this.isLoaderActive = false;
         if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
            // Unauthorized logout
          this.$store.dispatch("actionUnauthorizedLogout");
        } else {

            // Set logged user details with permissions
          this.loggedUserName = data.userData.lms_user_full_name;
          this.loggedUserMobileNumber = data.userData.lms_user_mobile;
          this.loggedUserProfileImage=data.userData.lms_user_profile_image!=null?process.env.MIX_USER_PROFILE_IMAGE_URL +
            data.userData.lms_user_profile_image:process.env.MIX_USER_PROFILE_IMAGE_URL +
            'default.png'



            this.$laravel.setPermissions(data.userPermission);
            this.userPermissionData=data.userPermission


        }
      })
      .catch(error => {
        this.isLoaderActive = false;
        this.$store.dispatch("actionLogout");
      });
  },
  methods: {
      // Logout user
    logout() {
        this.isLoaderActive=true
      this.$http
        .post("auth/web_logout", "", this.authorizationConfig)
        .then(({ data }) => {
            this.isLoaderActive=false
           if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.$store.dispatch("actionLogout");
          }
        })
        .catch(error => {
            this.isLoaderActive=false
          this.$store.dispatch("actionLogout");
        });
    }
  }
};
</script>
<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition-duration: 0.9s;
  transition-property: opacity;
  transition-timing-function: ease;
}

.fade-enter,
.fade-leave-active {
  opacity: 0
}
.ps {
  height: 500px;
}
</style>

