<template>
  <v-app>
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
      <v-list>
        <template>

          <v-list-item  to="/home/franchise" class="text-decoration-none" exact-active-class="primary" color="white">
            <v-list-item-action>
              <v-icon medium>mdi-account-multiple</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                <small>
                  <strong>{{$t('label.label_franchise')}}</strong>
                </small>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>


          <v-list-item  to="/home/executive" class="text-decoration-none" exact-active-class="primary" color="white">
            <v-list-item-action>
              <v-icon medium>mdi-account</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                <small>
                  <strong>{{$t('label.label_ex_member')}}</strong>
                </small>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>


         <v-list-item to="/home/certificate"   class="text-decoration-none" exact-active-class="primary" color="white">
            <v-list-item-action>
              <v-icon medium>mdi-certificate</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                <small>
                  <strong>{{$t('label.label_certificate')}}</strong>
                </small>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>

  <v-list-item to="/home/student"   class="text-decoration-none" exact-active-class="primary" color="white">
            <v-list-item-action>
              <v-icon medium>mdi-account-multiple</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                <small>
                  <strong>{{$t('label.label_students')}}</strong>
                </small>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>


<!--

          <v-list-group prepend-icon="mdi-file-chart" icon-alt="mdi-file-chart" append-icon>
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title>
                  <small>
                    <strong>{{$t('label.label_reports')}}</strong>
                  </small>
                </v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item>
              <v-list-item-action>
                <v-icon medium>mdi-certificate</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  <small>
                    <strong>{{$t('label.label_certificate')}}</strong>
                  </small>
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item link>
              <v-list-item-action>
                <v-icon medium>mdi-account-multiple</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  <small>
                    <strong>{{$t('label.label_franchise')}}</strong>
                  </small>
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item link>
              <v-list-item-action>
                <v-icon medium>mdi-account</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  <small>
                    <strong>{{$t('label.label_ex_member')}}</strong>
                  </small>
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>


          <v-list-group prepend-icon="mdi-apps" icon-alt="mdi-apps" append-icon>
            <template v-slot:activator>
              <v-list-item-content>
                <v-list-item-title>
                  <small>
                    <strong>{{$t('label.label_app_settings')}}</strong>
                  </small>
                </v-list-item-title>
              </v-list-item-content>
            </template>

            <v-list-item link>
              <v-list-item-action>
                <v-icon medium>mdi-home</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  <small>
                    <strong>{{$t('label.label_home')}}</strong>
                  </small>
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item link>
              <v-list-item-action>
                <v-icon medium>mdi-book-open-variant</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  <small>
                    <strong>{{$t('label.label_courses')}}</strong>
                  </small>
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>

            <v-list-item link>
              <v-list-item-action>
                <v-icon medium>mdi-file-image</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  <small>
                    <strong>{{$t('label.label_gallery')}}</strong>
                  </small>
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>



          <v-list-item link>
            <v-list-item-action>
              <v-icon medium>mdi-white-balance-sunny</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                <small>
                  <strong>{{$t('label.label_settings')}}</strong>
                </small>
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item> -->
        </template>
      </v-list>
      <template v-slot:append>
        <div class="pa-2">
          <v-btn block tile color="teal" icon @click="logout">
            <v-icon left>mdi-logout</v-icon>
            {{ $t('label.label_logout') }}
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>

    <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app color="blue darken-3" dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
        <span class="hidden-sm-and-down">
          <strong>{{$t('label.label_universal')}}</strong>
          <small>{{$t('label.label_education_hub')}}</small>
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
                  <v-list-item-title>{{$t('label.label_logout')}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
              <v-list-item>
                <v-list-item-icon>
                  <v-icon>mdi-settings</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                  <v-list-item-title>{{$t('label.label_settings')}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>

              <v-list-item @click="toggleTheme" >
                <v-list-item-icon>
                  <v-icon>mdi-invert-colors</v-icon>
                </v-list-item-icon>

                <v-list-item-content>
                  <v-list-item-title>{{themeText}}</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-card>
      </v-menu>
    </v-app-bar>
    <router-view></router-view>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      drawer: null,
      loggedUserName: "",
      loggedUserProfileImage: "",
      loggedUserMobileNumber: "",
      authorizationConfig: "",
      themeText:'',
      userPermission:''
    };
  },
  computed: {
    isIdle() {
      return this.$store.state.idleVue.isIdle;
    }
  },
  created() {
    if (localStorage.getItem("theme") == "dark") {
      this.$vuetify.theme.dark = true;
      this.themeText=this.$t('label.label_light')
    } else {
      this.$vuetify.theme.dark = false;
      this.themeText=this.$t('label.label_dark')
    }
    this.authorizationConfig = {
      headers: { Authorization: "Bearer " + localStorage.getItem("token") }
    };
    axios
      .post("auth/web_get_user_details", "", this.authorizationConfig)
      .then(({ data }) => {
        if (data.error == "Unauthorized") {
          this.$store.dispatch("actionLogout");
        } else {
          this.$store.commit("setLogInDataForHomePage", data);

          this.loggedUserName = data.user_name;
          this.loggedUserMobileNumber = data.user_mobile_number;
          this.loggedUserProfileImage =
            process.env.MIX_USER_PROFILE_IMAGE_URL + data.user_profile_image;
        }
      })
      .catch(error => {
        this.$store.dispatch("actionLogout");
      });


      axios
      .post("auth/web_get_user_permission_details", "", this.authorizationConfig)
      .then(({ data }) => {
        if (data.error == "Unauthorized") {
          this.$store.dispatch("actionLogout");
        } else {
                this.$store.commit('setUserPermission',data)
        }
      })
      .catch(error => {
        this.$store.dispatch("actionLogout");
      });
  },
  methods: {
    logout() {
      axios
        .post("auth/web_logout", "", this.authorizationConfig)
        .then(({ data }) => {
          if (data.error == "Unauthorized") {
            this.$store.dispatch("actionLogout");
          } else {
            this.$store.dispatch("actionLogout");
          }
        })
        .catch(error => {
          this.$store.dispatch("actionLogout");
        });
    },
    toggleTheme() {

      if (localStorage.getItem("theme") == "dark") {
        this.$vuetify.theme.dark = false;
        localStorage.setItem('theme','light')
        this.themeText=this.$t('label.label_dark')
      } else {
        this.$vuetify.theme.dark = true;
        localStorage.setItem('theme','dark')
        this.themeText=this.$t('label.label_light')

      }
    }
  }
};
</script>
