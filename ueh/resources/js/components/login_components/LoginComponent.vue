<template>
  <v-app id="inspire">
    <v-content>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="12" md="6">
            <v-card class="mx-auto">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>{{ $t("label.label_sign_in") }}</v-toolbar-title>

                <v-progress-linear
                  :active="isFormDataProcessing"
                  :indeterminate="isFormDataProcessing"
                  absolute
                  top
                  color="white"
                ></v-progress-linear>

                <v-spacer></v-spacer>
              </v-toolbar>

              <v-card-text>
                <v-form ref="holdingForm" v-model="isholdingFormValid" lazy-validation>
                  <v-text-field
                    :label="mobileNumberLabel"
                    prepend-inner-icon="mdi-cellphone-android"
                    outlined
                    clearable
                    :counter="10"
                    autofocus
                    maxlength="10"
                    type="text"
                    v-model="mobile"
                    :rules="mobileRules"
                    @keypress="isDigit"
                  ></v-text-field>

                  <v-text-field
                    :label="passwordLabel"
                    prepend-inner-icon="mdi-lock"
                    outlined
                    clearable
                    v-model="password"
                    :append-icon="isPasswordVisible? 'mdi-eye' : 'mdi-eye-off'"
                    :type="isPasswordVisible ? 'text' : 'password'"
                    @click:append="isPasswordVisible = !isPasswordVisible"
                    :rules="passwordRules"
                  ></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-btn text small color="primary">{{$t('label.label_forgot_password')}}</v-btn>
                <v-divider></v-divider>

                <div class="text-center">
                  <v-btn
                    class="ma-2"
                    filled
                    color="primary"
                    :disabled="!isholdingFormValid || isFormDataProcessing"
                    @click="validateLogin"
                  >{{isFormDataProcessing==true?$t("label.label_checking") : $t("label.label_sign_in") }}</v-btn>
                </div>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>

    <v-snackbar
      v-model="isSnackBarVisible"
      :color="snackBarColor"
      multi-line="multi-line"
      right="right"
      :timeout="3000"
      top="top"
      vertical="vertical"
    >{{ snackBarMessage }}</v-snackbar>

    <v-footer color="primary" padless >
      <v-row justify="center" no-gutters >
        <v-col class="primary lighten-2 py-4 text-center white--text" cols="12"

        >
          {{ new Date().getFullYear() }} —
          <strong>{{$t('label.label_company_name')}}</strong>
        </v-col>
      </v-row>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  data() {
    return {
      // All Form Labels
      mobileNumberLabel: this.$t("label.label_mobile"),
      passwordLabel: this.$t("label.label_password"),

      //End

      //All Form Inputs

      mobile: "",
      password: "",
      isPasswordVisible: false,
      isholdingFormValid: true,
      isFormDataProcessing: false,
      //End

      // All Validation Rules

      mobileRules: [
        v => !!v || this.$t("validation.custom.mobile.required"),
        v => (v && v.length >= 10) || this.$t("validation.custom.mobile.min")
      ],

      passwordRules: [
        v => !!v || this.$t("validation.custom.password.required")
      ],

      //End

      // Snack Bar

      isSnackBarVisible: false,
      snackBarColor: "",
      snackBarMessage: ""

      //End
    };
  },
created()
{
 if (localStorage.getItem("theme") == "dark") {
      this.$vuetify.theme.dark = true;
    } else {
      this.$vuetify.theme.dark = false;
    }
},
  methods: {
    // Displaying Snackbar Message

    changeSnackBarMessage(data, isServerError) {
      this.isSnackBarVisible = true;
      this.snackBarColor = "error";
      if (isServerError == true) {
        this.snackBarMessage = data;
      }

      if (isServerError == false) {
        this.snackBarMessage = data.error;
      }
    },

    //End

    // User Validation Server+Client Side

    validateLogin() {
      if (this.$refs.holdingForm.validate()) {
        this.isFormDataProcessing = true;
        axios
          .post("auth/web_login", {
            mobile: this.mobile,
            password: this.password
          })
          .then(({ data }) => {
            this.isFormDataProcessing = false;

            if (data.login_flag == 1) {
                // server side validation fails
              this.changeSnackBarMessage(data, false);
            }
             else if (data.login_flag == 2)
             {
                 // Login Success
                this.$store.commit('setLogInUserData',data)

            } else if (data.login_flag == 0) {
                //Invalid Login
              this.changeSnackBarMessage(data, false);
            }
          })
          .catch(error => {
            this.isFormDataProcessing = false;
            this.changeSnackBarMessage(error, true);
          });
      }
    },

    //End

    // Ensure Digit Input in Mobile Number Field
    isDigit(evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;
      if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        evt.preventDefault();
      } else {
        return true;
      }
    },

    //End
  },

};
</script>
