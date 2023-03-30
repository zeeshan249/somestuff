<template>
  <v-app id="inspire">
    <v-main>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="12" md="6">
            <v-card class="mx-auto">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>{{ $t("label_login") }}</v-toolbar-title>

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
                <v-form
                  ref="holdingForm"
                  v-model="isholdingFormValid"
                  lazy-validation
                >
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
                    :append-icon="isPasswordVisible ? 'mdi-eye' : 'mdi-eye-off'"
                    :type="isPasswordVisible ? 'text' : 'password'"
                    @click:append="isPasswordVisible = !isPasswordVisible"
                    @keyup.enter="validateLogin"
                    :rules="passwordRules"
                  ></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-btn text small color="primary">{{
                  $t("label_forgot_password")
                }}</v-btn>
                <v-divider></v-divider>

                <div class="text-center">
                  <v-btn
                    class="ma-2"
                    filled
                    color="primary"
                    :disabled="!isholdingFormValid || isFormDataProcessing"
                    @click="validateLogin"
                  >
                    {{
                      isFormDataProcessing == true
                        ? $t("label_validating")
                        : $t("label_login")
                    }}</v-btn
                  >
                </div>
              </v-card-actions>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-main>

    <v-snackbar
      v-model="isSnackBarVisible"
      color="error"
      multi-line="multi-line"
      right="right"
      :timeout="3000"
      top="top"
      vertical="vertical"
      >{{ snackBarMessage }}</v-snackbar
    >

    <v-footer color="primary" padless>
      <v-row justify="center" no-gutters>
        <v-col class="primary lighten-2 py-4 text-center white--text" cols="12">
          {{ new Date().getFullYear() }} —
          <strong>{{ $t("label_company_name") }}</strong>
        </v-col>
      </v-row>
    </v-footer>
  </v-app>
</template>

<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });
export default {
  data() {
    return {
      // All Form Labels
      mobileNumberLabel: this.$t("label_mobile"),
      passwordLabel: this.$t("label_password"),

      //All Form Inputs
      mobile: "",
      password: "",
      isPasswordVisible: false,
      isholdingFormValid: true,
      isFormDataProcessing: false,

      // All Validation Rules
      mobileRules: [
        (v) => !!v || this.$t("label_provide_valid_mobile_number"),
        (v) =>
          (v && v.length >= 10) || this.$t("label_mobile_number_10_digits"),
      ],

      passwordRules: [
        (v) => !!v || this.$t("label_provide_valid_password"),
        (v) => (v && v.length > 5) || this.$t("label_password_min_char"),
      ],

      // Snack Bar
      isSnackBarVisible: false,
      snackBarMessage: "",
    };
  },
  created() {},
  methods: {
    // Displaying Snackbar Message
    changeSnackBarMessage(data, isServerError) {
      this.isSnackBarVisible = true;
      if (isServerError == true) {
        this.snackBarMessage = data;
      }

      if (isServerError == false) {
        this.snackBarMessage = data.error;
      }
    },

    // User Validation Server+Client Side
    validateLogin() {
      if (navigator.onLine) {
        if (this.$refs.holdingForm.validate()) {
          this.isFormDataProcessing = true;
          this.$http
            .post("auth/web_login", {
              mobile: this.mobile,
              password: this.password,
            })
            .then(({ data }) => {
              this.isFormDataProcessing = false;

              if (data.login_flag == 1) {
                // server side validation fails
                this.changeSnackBarMessage(data, false);
              } else if (data.login_flag == 2) {
                // Login Success and Save data in local storage and inform vuex store
                ls.set("token", data.access_token);
                ls.set("loggedUserId", data.user_data[0].lms_user_id);
                ls.set(
                  "lms_staff_first_name",
                  data.user_data[0].lms_staff_first_name
                );
                ls.set(
                  "lms_staff_last_name",
                  data.user_data[0].lms_staff_last_name
                );
                ls.set(
                  "lms_staff_full_name",
                  data.user_data[0].lms_staff_full_name
                );
                ls.set(
                  "lms_user_last_login_date",
                  data.user_data[0].lms_user_last_login_date
                );
                ls.set(
                  "lms_staff_profile_image",
                  data.user_data[0].lms_staff_profile_image
                );
                ls.set("role_id", data.user_data[0].role_id);
                ls.set("role_name", data.user_data[0].name);
                ls.set("loggedUserCenterId", "1");
                this.$store.commit("COMMIT_USER_LOGGED_IN");
                this.$router.push({
                  path: "home/dashboard",
                });
              } else if (data.login_flag == 0) {
                //Invalid Login
                this.changeSnackBarMessage(data, false);
              }
            })
            .catch((error) => {
              this.isFormDataProcessing = false;
              this.changeSnackBarMessage(error, true);
            });
        }
      } else {
        // Internet not found

        this.changeSnackBarMessage(this.$t("label_internet_not_found"), true);
      }
    },

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
  },
};
</script>
