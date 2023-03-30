<template>
  <div id="app">
      <v-container
          style="background-color: #e4e8e4; max-width: 100% !important"
      >
          <v-overlay :value="alertMessage == ''" color="primary">
              <v-progress-circular
                  indeterminate
                  size="64"
                  color="primary"
              ></v-progress-circular>
          </v-overlay>
          <v-card>
              <v-toolbar-title dark color="primary">
                  <v-list-item two-line>
                      <v-list-item-content>
                          <v-list-item-title class="text-h5">
                              <strong>Generate New Fees</strong>
                          </v-list-item-title>
                          <v-list-item-subtitle
                              >{{ $t("label_home")
                              }}<v-icon>mdi-forward</v-icon>
                              Accounts
                              <v-icon>mdi-forward</v-icon>
                              Generate New Fees</v-list-item-subtitle
                          >
                      </v-list-item-content>
                  </v-list-item>
              </v-toolbar-title>

              <v-spacer></v-spacer>

              <v-card class="mx-2" elevation="0">
                  <v-card class="mx-auto" color="grey lighten-4 ma-4">
                      <v-row class="ml-2">
                          <v-col cols="12" md="2">
                              <v-list-item-avatar
                                  color="grey darken-3"
                                  rounded
                                  size="100"
                              >
                                  <img
                                      :src="
                                          buildCoverImages(buildProfileImage)
                                      "
                                      :lazy-src="
                                          buildCoverImages(buildProfileImage)
                                      "
                                  />
                              </v-list-item-avatar>
                          </v-col>
                          <v-col cols="12" md="10">
                              <v-row dense>
                                  <v-col cols="12" md="12">
                                      <span
                                          class="text-h6 font-weight-black text-uppercase"
                                          >{{ lms_student_full_name }}</span
                                      ></v-col
                                  >
                              </v-row>
                              <v-row dense>
                                  <v-col cols="5">
                                      Student ID:
                                      {{ lms_student_code }}
                                  </v-col>
                                  <v-col cols="5">
                                      Stream: {{ lms_course_name }}
                                  </v-col>
                              </v-row>
                              <v-row dense>
                                  <v-col cols="5">
                                      Registration ID:
                                      {{ lms_registration_code }}
                                  </v-col>

                                  <v-col cols="5">
                                      Course Enrolled:
                                      {{ lms_child_course_name }}
                                  </v-col>
                              </v-row>
                          </v-col>
                      </v-row>

                      <v-sheet color="transparent"> </v-sheet>
                  </v-card>
                  <v-form ref="holdingFormBasic" lazy-validation>
                      <v-list-item class="grow">
                          <v-list-item-avatar
                              color="grey darken-3"
                              v-if="false"
                          >
                              <v-img
                                  class="elevation-6"
                                  alt=""
                                  src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
                              ></v-img>
                          </v-list-item-avatar>
                          <v-row align="center" justify="end" class="mt-2">
                              <v-col cols="12" md="3" class="mt-2">
                                  <v-text-field
                                      regular
                                      dense
                                      v-model="lms_child_course_name"
                                      readonly
                                  >
                                      <template #label>
                                          Student Course
                                      </template>
                                  </v-text-field>
                              </v-col>
                              <v-col cols="12" md="3" class="mt-2">
                                  <v-text-field
                                      regular
                                      dense
                                      v-model="lms_child_course_fees"
                                      @blur="calculateFee"
                                  >
                                      <template #label>
                                          <span> Course Fees </span>
                                      </template>
                                  </v-text-field>
                              </v-col>

                              <v-col cols="12" md="3">
                                  <v-text-field
                                      regular
                                      dense
                                      v-model="lms_child_course_duration"
                                      @keypress="isDigit"
                                      @blur="calculateFee"
                                  >
                                      <template #label
                                          >No of Installment
                                          <span class="red--text">
                                              <strong>{{
                                                  $t("label_star")
                                              }}</strong>
                                          </span>
                                      </template>
                                  </v-text-field>
                              </v-col>

                              <v-col cols="12" md="3">
                                  <v-dialog
                                      ref="dialogDOB"
                                      v-model="modalStart"
                                      :return-value.sync="startDate"
                                      persistent
                                      width="290px"
                                  >
                                      <template
                                          v-slot:activator="{ on, attrs }"
                                      >
                                          <v-text-field
                                              regular
                                              dense
                                              v-model="startDate"
                                              prepend-inner-icon="mdi-calendar"
                                              readonly
                                              v-bind="attrs"
                                              v-on="on"
                                              :rules="[
                                                  (v) =>
                                                      !!v ||
                                                      $t('label_required'),
                                              ]"
                                          >
                                              <template #label>
                                                  Start Date
                                                  <span class="red--text">
                                                      <strong>{{
                                                          $t("label_star")
                                                      }}</strong>
                                                  </span>
                                              </template>
                                          </v-text-field>
                                      </template>
                                      <v-date-picker
                                          v-model="startDate"
                                          scrollable
                                      >
                                          <v-spacer></v-spacer>
                                          <v-btn
                                              text
                                              color="primary"
                                              @click="modalStart = false"
                                              >{{ $t("label_cancel") }}</v-btn
                                          >
                                          <v-btn
                                              text
                                              color="primary"
                                              @click="
                                                  $refs.dialogDOB.save(
                                                      startDate
                                                  )
                                              "
                                              >{{ $t("label_ok") }}</v-btn
                                          >
                                      </v-date-picker>
                                  </v-dialog>
                              </v-col>
                          </v-row>
                      </v-list-item>

                      <v-row dense class="mx-2">
                          <v-col cols="12" md="4">
                              <v-select
                                  regular
                                  dense
                                  v-model="discountType"
                                  :items="discountTypeItems"
                                  item-text="description"
                                  item-value="lms_discount_id"
                                  :disabled="isSchoolDataLoading"
                                  :rules="[
                                      (v) => !!v || $t('label_required'),
                                  ]"
                                  @change="changeDiscountType"
                              >
                                  <template #label>
                                      Selected Discount Type
                                      <span class="red--text">
                                          <strong>{{
                                              $t("label_star")
                                          }}</strong>
                                      </span>
                                  </template>
                              </v-select>
                          </v-col>

                          <v-col cols="12" md="2">
                              <v-text-field
                                  regular
                                  dense
                                  v-model="discountAmount"
                                  readonly
                              >
                                  <template #label> Discount (₹/%) </template>
                              </v-text-field>
                          </v-col>
                          <v-col cols="12" md="2">
                              <v-text-field
                                  regular
                                  dense
                                  v-model="discountIn"
                                  readonly
                              >
                                  <template #label>
                                      Discount Type
                                      <span class="red--text">
                                          <strong>{{
                                              $t("label_star")
                                          }}</strong>
                                      </span>
                                  </template>
                              </v-text-field>
                          </v-col>
                          <v-col cols="12" md="2">
                              <v-text-field
                                  regular
                                  dense
                                  v-model="actualFees"
                                  readonly
                              >
                                  <template #label>
                                      Actual Fees
                                      <span class="red--text">
                                          <strong>{{
                                              $t("label_star")
                                          }}</strong>
                                      </span>
                                  </template>
                              </v-text-field>
                          </v-col>

                          <v-col cols="12" md="2">
                              <v-text-field
                                  regular
                                  dense
                                  v-model="monthlyFee"
                                  readonly
                              >
                                  <template #label>
                                      Monthly Fees
                                      <span class="red--text">
                                          <strong>{{
                                              $t("label_star")
                                          }}</strong>
                                      </span>
                                  </template>
                              </v-text-field>
                          </v-col>
                      </v-row>
                  </v-form>
                  <v-divider class="mx-4"></v-divider>
                  <v-card-actions>
                      <v-list-item class="grow">
                          <v-row align="center" justify="start">
                              <v-btn
                                  color="primary"
                                  :disabled="
                                      isStudentUpdateFormDataProcessing
                                  "
                                  @click="saveBasicInfo()"
                              >
                                  {{
                                      isBasicFormDataProcessing == true
                                          ? $t("label_processing")
                                          : "Generate New Fee"
                                  }}</v-btn
                              >
                          </v-row>
                      </v-list-item>
                  </v-card-actions>
              </v-card>
          </v-card>

          <v-snackbar
              v-model="isSnackBarVisible"
              :color="snackBarColor"
              multi-line="multi-line"
              right="right"
              :timeout="3000"
              top="top"
              vertical="vertical"
              >{{ snackBarMessage }}</v-snackbar
          >
      </v-container>
  </div>
</template>
<script>
// Secure Local Storage
import SecureLS from "secure-ls";
import { Global } from "../../components/helpers/global";
const ls = new SecureLS({ encodingType: "aes" });
export default {
  props: ["userPermissionDataProps", "enquiryDataProps"],
  data() {
      console.log(this.enquiryDataProps);
      return {
          lms_student_id:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_student_id
                  : "",
          lms_student_full_name:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_student_full_name
                  : "",
          lms_student_code:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_student_code
                  : "",
          lms_registration_code:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_registration_code
                  : "",
          lms_child_course_id:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_child_course_id
                  : "",
          lms_course_id:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_course_id
                  : "",
          lms_course_name:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_course_name
                  : "",
          lms_child_course_name:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_child_course_name
                  : "",
          lms_child_course_fees:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_child_course_fees
                  : "",
          lms_child_course_duration:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_child_course_duration
                  : "",
          discountAmount:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.amount
                  : "",
          actualFees:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_actual_fee
                  : "",
          startDate:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_actual_fee_start_date
                  : new Date().toISOString().substr(0, 10),
          // lms_discount_id:
          //     this.enquiryDataProps != null
          //         ? this.enquiryDataProps.lms_discount_id
          //     : "",
          discountType:
              this.enquiryDataProps != null
                  ? this.enquiryDataProps.lms_discount_id
                  : "",
          discountTypeItems: [],

          buildProfileImage:
              this.enquiryDataProps.lms_student_profile_image != null
                  ? this.enquiryDataProps.lms_student_profile_image
                  : "",
          monthlyFee: null,
          discountIn: null,
          isStudentUpdateFormDataProcessing: false,
          profileImagesUrl: "",
          altprofileImagesUrl: "",
          modalStart: false,
          alertType: "",
          alertMessage: "",
          // Snack Bar
          isSnackBarVisible: false,
          snackBarMessage: "",
          snackBarColor: "",

          // Form Data
          authorizationConfig: "",

          stepperInfo: 1,

          isSourceDataLoading: false,

          isSchoolDataLoading: false,
          isBasicHoldingFormValid: true,
          isBasicFormDataProcessing: false,

          modalFromDate: false,
          modalToDate: false,
          discountAmountTotal: "",
      };
  },

  created() {
      if (this.enquiryDataProps == null) {
          this.$router.push({
              name: "FeeGenerator",
          });
      }
      console.log(this.enquiryDataProps);
      // Token Config
      this.authorizationConfig = {
          headers: { Authorization: "Bearer " + ls.get("token") },
      };
      this.getPrefixModuleWise();
      this.getAllActiveDiscount();
      this.profileImagesUrl = process.env.MIX_PROFILE_URL;
      this.altprofileImagesUrl = this.profileImagesUrl + "NotAvailable.jpg";
  },
  methods: {
      // Get all active school
      getAllActiveDiscount() {
          this.isSchoolDataLoading = true;
          this.$http
              .get(`web_discount_fetch_without_pagination`, {
                  params: {
                      centerId: ls.get("loggedUserCenterId"),
                  },
                  headers: { Authorization: "Bearer " + ls.get("token") },
              })
              .then(({ data }) => {
                  this.isSchoolDataLoading = false;
                  //User Unauthorized
                  if (
                      data.error == "Unauthorized" ||
                      data.permissionError == "Unauthorized"
                  ) {
                      this.$store.dispatch("actionUnauthorizedLogout");
                  } else {
                      this.discountTypeItems = data;
                  }
              })
              .catch((error) => {
                  this.isSchoolDataLoading = false;
                  this.snackBarColor = "error";
                  this.changeSnackBarMessage(
                      this.$t("label_something_went_wrong")
                  );
              });
      },
      changeDiscountType() {
          this.isSchoolDataLoading = true;
          this.$http
              .get(`web_discount_fetch_without_pagination`, {
                  params: {
                      discountId: this.discountType,
                  },
                  headers: { Authorization: "Bearer " + ls.get("token") },
              })
              .then(({ data }) => {
                  this.isSchoolDataLoading = false;
                  //User Unauthorized
                  if (
                      data.error == "Unauthorized" ||
                      data.permissionError == "Unauthorized"
                  ) {
                      this.$store.dispatch("actionUnauthorizedLogout");
                  } else {
                      console.log(data[0].discount_type);
                      this.discountIn = data[0].discount_type;
                      this.discountAmount = data[0].amount;
                      this.calculateFee();
                  }
              })
              .catch((error) => {
                  this.isSchoolDataLoading = false;
                  this.snackBarColor = "error";
                  this.changeSnackBarMessage(
                      this.$t("label_something_went_wrong")
                  );
              });
      },

      calculateFee() {
          if (this.discountIn != null) {
              if (this.discountIn == "Amount") {
                  this.actualFees = Math.round(
                      this.lms_child_course_fees - this.discountAmount
                  );
                  this.monthlyFee = Math.round(
                      this.actualFees / this.lms_child_course_duration
                  );

                  this.discountAmountTotal = Math.round(
                      this.lms_child_course_fees - this.discountAmount
                  );
              } else {
                  this.actualFees = Math.round(
                      this.lms_child_course_fees -
                          (this.lms_child_course_fees * this.discountAmount) /
                              100
                  );

                  this.monthlyFee = Math.round(
                      this.actualFees / this.lms_child_course_duration
                  );

                  this.discountAmountTotal = Math.round(
                      (this.lms_child_course_fees * this.discountAmount) / 100
                  );
              }
          } else {
              console.log("object");
              this.snackBarColor = "error";
              this.changeSnackBarMessage("Please select discount type");
          }
      },
      buildCoverImages(images) {
          return images != ""
              ? this.profileImagesUrl + images
              : this.altprofileImagesUrl;
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

      // To ensure name is character with space only
      isCharactersWithSpace(evt) {
          var regex = new RegExp("^[a-zA-Z ]+$");
          var key = String.fromCharCode(
              !evt.charCode ? evt.which : evt.charCode
          );
          if (!regex.test(key)) {
              evt.preventDefault();
              return false;
          }
      },
      // Change Snack bar message
      changeSnackBarMessage(data) {
          this.isSnackBarVisible = true;
          this.snackBarMessage = data;
      },
      // Get Prefix Setting
      getPrefixModuleWise() {
          this.isBasicFormDataProcessing = true;
          this.$http
              .get(`web_get_prefix_module_wiseq`, {
                  params: {
                      centerId: ls.get("loggedUserCenterId"),
                      prefixModuleName: "Enquiry Code",
                  },
                  headers: { Authorization: "Bearer " + ls.get("token") },
              })
              .then(({ data }) => {
                  this.isBasicFormDataProcessing = false;
                  if (
                      data.error == "Unauthorized" ||
                      data.permissionError == "Unauthorized"
                  ) {
                      this.$store.dispatch("actionUnauthorizedLogout");
                  } else {
                      // If prefix set
                      if (data[0].lms_is_prefix_assigned == "1") {
                          this.alertType = "success";
                          this.alertMessage =
                              "Here you can enter Fee Information";
                      }
                      // If prefix not set
                      else {
                          this.alertType = "error";
                          this.alertMessage = this.$t(
                              "label_prefix_pattern_not_set_for_enquiry"
                          );
                      }
                  }
              })
              .catch((error) => {
                  this.snackBarColor = "error";
                  this.changeSnackBarMessage(
                      this.$t("label_something_went_wrong")
                  );
              });
      },

      //Save basic info
      saveBasicInfo() {
          if (this.$refs.holdingFormBasic.validate()) {
              // Save/Edit Basic Info
              this.authorizationConfig = {
                  headers: {
                      Authorization: "Bearer " + ls.get("token"),
                      "content-type": "multipart/form-data",
                  },
              };
              this.isBasicFormDataProcessing = true;
              let basicFormData = new FormData();
              basicFormData.append("studentId", this.lms_student_id);

              // basicFormData.append("lms_student_full_name", this.lms_student_full_name);

              basicFormData.append(
                  "courseRegistrationCode",
                  this.lms_registration_code
              );

              basicFormData.append("discountId", this.discountType);

              basicFormData.append("courseId", this.lms_child_course_id);
              basicFormData.append("streamId", this.lms_course_id);
              basicFormData.append("courseFees", this.lms_child_course_fees);

              basicFormData.append(
                  "feeDuration",
                  this.lms_child_course_duration
              );

              basicFormData.append(
                  "totalFeeDiscount",
                  this.discountAmountTotal
              );
              basicFormData.append("actualFee", this.actualFees);
              basicFormData.append("monthlyFee", this.monthlyFee);
              basicFormData.append("startDate", this.startDate);

              this.$http
                  .post(
                      "web_save_fees",
                      basicFormData,
                      this.authorizationConfig
                  )
                  .then(({ data }) => {
                      this.isBasicFormDataProcessing = false;
                      //User Unauthorized
                      if (
                          data.error == "Unauthorized" ||
                          data.permissionError == "Unauthorized"
                      ) {
                          this.$store.dispatch("actionUnauthorizedLogout");
                      } else {
                          // Server side validation fails
                          if (data.responseData == 0) {
                              this.snackBarColor = "error";
                              this.changeSnackBarMessage(data.error);
                          }
                          // Profile Image uppload failed
                          else if (data.responseData == 1) {
                              this.snackBarColor = "error";
                              this.changeSnackBarMessage(
                                  this.$t("label_image_upload_failed")
                              );
                          }
                          // Email exists
                          else if (data.responseData == 2) {
                              this.snackBarColor = "error";
                              this.changeSnackBarMessage(
                                  "Fee Already Generated for This Student Course"
                              );
                          }

                          // Enquiry Saved
                          else if (data.responseData == 4) {
                              this.snackBarColor = "success";
                              this.changeSnackBarMessage(
                                  "New Discount Added"
                              );
                              // this.isEnquiryBasicEdit = 1;
                              // this.lms_discount_id = data.lms_discount_id;

                              // setTimeout(() => {
                              //     this.$router.push({
                              //         name: "Discounts",
                              //     });
                              // }, 2000);

                              Global.showSuccessAlert(
                                  true,
                                  "success",
                                  `Fee generated Successfully for Student With Reg Id :${this.lms_registration_code}`
                              );

                                setTimeout(() => {
                                  this.$router.push({
                                      name: "FeeGenerator",
                                  });
                              }, 1000);
                          }
                          // Enquiry save failed
                          else if (data.responseData == 5) {
                              this.snackBarColor = "error";
                              this.changeSnackBarMessage(
                                  this.$t("label_something_went_wrong")
                              );
                          }
                          // Edit Success
                          else if (data.responseData == 6) {
                              this.snackBarColor = "success";
                              this.changeSnackBarMessage(
                                  "Discount Details Updated"
                              );

                              setTimeout(() => {
                                  this.$router.push({
                                      name: "Discounts",
                                  });
                              }, 2000);
                              // this.stepperInfo = 2;
                          } else if (data.responseData == 7) {
                              this.snackBarColor = "error";
                              this.changeSnackBarMessage(
                                  this.$t("label_something_went_wrong")
                              );
                          }
                      }
                  })
                  .catch((error) => {
                      this.isBasicFormDataProcessing = false;
                      this.snackBarColor = "error";
                      this.changeSnackBarMessage(
                          this.$t("label_something_went_wrong")
                      );
                  });
          }
      },
  },
};
</script>
