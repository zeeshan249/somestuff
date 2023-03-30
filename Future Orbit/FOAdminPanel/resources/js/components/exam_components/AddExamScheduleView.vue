<template>
  <!-- Card Start -->
  <v-container
        fluid
        style="background-color: #e4e8e4; max-width: 100% !important"
        
  >
  <v-sheet class="pa-4 mb-4" >
    <v-breadcrumbs :items="breadCrumbItem">
      <template v-slot:divider>
        <v-icon>mdi-forward</v-icon>
      </template>
    </v-breadcrumbs>
  </v-sheet>
    <v-overlay :value="alertMessage == ''" color="primary">
      <v-progress-circular
        indeterminate
        size="64"
        color="primary"
      ></v-progress-circular>
    </v-overlay>
    <v-alert
      dense
      v-if="alertMessage != ''"
      text
      :type="alertType"
      elevation="2"
      dismissible
      transition="fade-transition"
      >{{ alertMessage }}</v-alert
    >

    <v-stepper v-model="stepperInfo" vertical>
      <v-stepper-step :complete="stepperInfo > 1" step="1">{{
        $t("label_add_exam_schedule")
      }}</v-stepper-step>

      <v-stepper-content step="1">
        <v-card color="grey lighten-1" class="mb-12">
          <v-form
            ref="holdingFormBasic"
            v-model="isBasicHoldingFormValid"
            lazy-validation
          >
            <v-card class="mx-auto mt-2" max-width="100%" outlined>
              <v-app-bar dark color="primary">
                <v-toolbar-title color="success">{{
                  $t("label_add_exam_schedule")
                }}</v-toolbar-title>
              </v-app-bar>

              <v-row dense class="ml-2 mr-2 mt-2">
                <v-col cols="12" md="3" sm="6" v-if="false">
                  <v-text-field v-model="scheduleId" outlined dense disabled>
                    <template #label>{{ $t("label_code") }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-select
                    outlined
                    dense
                    v-model="selectedInstructionId"
                    :items="instructionItems"
                    :disabled="isInstructionDataLoading"
                    item-text="lms_exam_instruction_title"
                    item-value="lms_exam_instruction_id"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_instruction") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-select>
                </v-col>
                <v-col cols="12" md="3" sm="12">
                  <v-select
                    outlined
                    dense
                    v-model="selectedCourseId"
                    :items="courseItems"
                    :disabled="isCourseDataLoading"
                    item-text="lms_course_name"
                    item-value="lms_course_id"
                     @change="getAllActiveChildCourse(this)"
                  >
                    <template #label
                      >{{ $t("label_stream") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span></template
                    >
                  </v-select>
                </v-col>


                <v-col cols="12" md="3" sm="12" class="px-2">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="lms_child_course_id"
                                        :items="childCourseItems"
                                        :disabled="isSourceDataLoading"
                                        item-text="lms_child_course_name"
                                        item-value="lms_child_course_id"
                                        :rules="[
                                            v => !!v || $t('label_required')
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_child_course") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-select>
                                </v-col>


                <v-col cols="12" md="3" sm="12">
                  <v-select
                    outlined
                    dense
                    v-model="selectedScheduleTypeId"
                    :items="scheduleTypeItems"
                    :disabled="isScheduleTypeDataLoading"
                    item-text="lms_exam_schedule_type"
                    item-value="lms_exam_schedule_type"
                  >
                    <template #label
                      >{{ $t("label_exam_type") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span></template
                    >
                  </v-select>
                </v-col>
              </v-row>

              <v-row dense class="ml-2 mr-2">
                <v-col cols="12" md="6">
                  <v-text-field
                    outlined
                    dense
                    v-model="examName"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_exam_name")  }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    outlined
                    dense
                    v-model="examDescription"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_exam_description") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
              </v-row>

              <v-row dense class="ml-2 mr-2">
                <v-col cols="12" md="3">
                  <v-select
                    outlined
                    dense
                    v-model="isNegativeMarking"
                    :items="NegativeMarkingItems"
                    item-text="lms_exam_schedule_has_negative_marking"
                    item-value="lms_exam_schedule_has_negative_marking_value"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_exam_is_negative_marking") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-select>
                </v-col>

                <v-col cols="12" md="4">
                  <v-select
                    outlined
                    dense
                    v-model="selectedResultDisplay"
                    :items="selectedResultItems"
                    item-text="lms_exam_schedule_result_display_type"
                    item-value="lms_exam_schedule_result_display_type_value"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label
                      >{{ $t("label_exam_result_display") }}
                      <span class="red--text"
                        ><strong>{{ $t("label_star") }}</strong></span
                      ></template
                    >
                  </v-select>
                </v-col>

                <v-col cols="12" md="3">
                  <v-select
                    outlined
                    dense
                    v-model="selectedExamFreePaid"
                    :items="FreePaidItems"
                    item-text="lms_exam_schedule_is_free_paid"
                    item-value="lms_exam_schedule_is_free_paid_value"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label
                      >{{ $t("label_exam_free_paid") }}
                      <span class="red--text"
                        ><strong>{{ $t("label_star") }}</strong></span
                      ></template
                    >
                  </v-select>
                </v-col>


                <v-col cols="12" md="2">
                  <v-select
                    outlined
                    dense
                    v-model="selectedSolutionDisplayType"
                    :items="SolutionDisplayItems"
                    item-text="lms_exam_schedule_solution_display_type"
                    item-value="lms_exam_schedule_solution_display_type_value"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label
                      >{{ $t("label_exam_solution_display_type") }}
                      <span class="red--text"
                        ><strong>{{ $t("label_star") }}</strong></span
                      ></template
                    >
                  </v-select>
                </v-col>
              </v-row>

              <v-row dense class="ml-2 mr-2">
                <v-col cols="12" md="3">
                  <v-text-field
                    outlined
                    dense
                    v-model="noOfQuestion"
                    @keypress="isDigit"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label
                      >{{ $t("label_exam_no_of_question") }}
                      <span class="red--text"
                        ><strong>{{ $t("label_star") }}</strong></span
                      ></template
                    >
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    outlined
                    dense
                    v-model="maxMarks"
                    @keypress="isDigit"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label
                      >{{ $t("label_exam_max_marks") }}
                      <span class="red--text"
                        ><strong>{{ $t("label_star") }}</strong></span
                      ></template
                    >
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                    <template>
                      <v-datetime-picker label="Live From" v-model="selectedLiveFrom" outlined
                    :time-picker-props="timeProps" time-format="HH:mm:ss"  date-format="yyyy-MM-dd"
                    :text-field-props="textFieldProps"
                    > </v-datetime-picker>

                 </template>
                </v-col>

                <v-col cols="12" md="3">
                 <template>
                      <v-datetime-picker label="Live To" v-model="selectedLiveTo" outlined
                    :time-picker-props="timeProps" time-format="HH:mm:ss"  date-format="yyyy-MM-dd"
                    :text-field-props="textFieldProps"
                    > </v-datetime-picker>

                 </template>

                </v-col>
              </v-row>

              <v-row dense class="ml-2 mr-2">
                <v-col cols="12" md="4">
                  <v-text-field
                    outlined
                    dense
                    v-model="totalTime"
                    maxlength="3"
                    :counter="3"
                    @keypress="isDigit"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_exam_total_time") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    outlined
                    dense
                    v-model="passMarks"
                    :counter="3"
                    maxlength="3"
                    @keypress="isDigit"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label
                      >{{ $t("label_exam_pass_marks") }}
                      <span class="red--text"
                        ><strong>{{ $t("label_star") }}</strong></span
                      >
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field
                    outlined
                    dense
                    v-model="negativeMarks"
                    :counter="3"
                    maxlength="3"
                    @keypress="isDigit"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_exam_negative_marks") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
              </v-row>


                <v-row dense class="ml-2 mr-2">
                <v-col cols="12" md="8">
                  <v-file-input
                    v-model="selectedScheduleExamImage"
                    color="primary"
                    outlined
                    dense
                    show-size
                    accept="image/*"
                    :rules="imageRule"
                  >
                    <template v-slot:selection="{ index, text }">
                      <v-chip
                        v-if="index < 2"
                        color="primary"
                        dark
                        label
                        small
                        >{{ text }}</v-chip
                      >
                    </template>
                    <template #label
                      >Exam Image
                      <span class="red--text"
                        ><strong>{{ $t("label_star") }}</strong></span
                      ></template
                    >
                  </v-file-input>
                </v-col>
                <v-col cols="12" md="4">
                  <v-avatar>
                    <img
                       :src="ExamScheduleProfileImage"
                       alt=""
                    />
                  </v-avatar>
                </v-col>
              </v-row>
            </v-card>
          </v-form>
        </v-card>

        <v-btn
          color="primary"
          :disabled="
            !isBasicHoldingFormValid ||
            isBasicFormDataProcessing ||
            alertMessage == ''
          "
          @click="saveExamSchedule()"
          >{{
            isBasicFormDataProcessing == true
              ? $t("label_processing")
              : $t("label_save")
          }}</v-btn
        >
        <!-- <v-btn
          color="primary" @click="stepperInfo=2">{{$t('label_skip')}}</v-btn> -->
      </v-stepper-content>
    </v-stepper>

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
</template>
<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });
import DatetimePicker from 'vuetify-datetime-picker';
import Vue from 'vue';
Vue.use(DatetimePicker);
export default {
  props: ["userPermissionDataProps", "examScheduleDataProps"],
  data() {
    return {
      // For Breadcrumb
      breadCrumbItem: [
        {
          text: this.$t("label_home"),
          disabled: false,
        },
        {
          text: this.$t("label_exam_schedule"),
          disabled: false,
        },
        {
          text: this.$t("label_add_exam_schedule"),
          disabled: false,
        },
      ],
      timeProps:{useSeconds:true},
      textFieldProps:{outlined:true, dense:true,  prependInnerIcon:"mdi-calendar"},
      alertType: "",
      alertMessage: "",
      // Snack Bar
      isSnackBarVisible: false,
      snackBarMessage: "",
      snackBarColor: "",

      // Form Data
      authorizationConfig: "",

      stepperInfo: 1,
      scheduleId:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_id
          : "",

      selectedInstructionId:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_instruction_id
          : "",
      instructionItems: [],
      isInstructionDataLoading: false,

      selectedCourseId:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_course_id
          : "",
 lms_child_course_id:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_child_course_id
          : "",

      courseItems: [],
      isCourseDataLoading: false,

      selectedScheduleTypeId:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_type
          : "",
      scheduleTypeItems: [],
      isScheduleTypeDataLoading: false,
      isBasicHoldingFormValid: true,
      isBasicFormDataProcessing: false,
      examName:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_name
          : "",
      examDescription:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_description
          : "",
      noOfQuestion:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_no_of_question
          : "",
      maxMarks:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_max_marks
          : "",

      NegativeMarkingItems: [
        {
          lms_exam_schedule_has_negative_marking: "Not Required",
          lms_exam_schedule_has_negative_marking_value: "0",
        },
        {
          lms_exam_schedule_has_negative_marking: "Required",
          lms_exam_schedule_has_negative_marking_value: "1",
        },
      ],
      isNegativeMarking:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_has_negative_marking
          : "",

      selectedResultItems: [
        {
          lms_exam_schedule_result_display_type:
            "Display Result Just After Submission",
          lms_exam_schedule_result_display_type_value: "0",
        },
        {
          lms_exam_schedule_result_display_type:
            "Display Result After Exam End Date",
          lms_exam_schedule_result_display_type_value: "1",
        },
        {
          lms_exam_schedule_result_display_type:
            "Display Result on Manual Publish",
          lms_exam_schedule_result_display_type_value: "2",
        },
      ],
      selectedResultDisplay:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_result_display_type
          : "",

      FreePaidItems: [
        {
          lms_exam_schedule_is_free_paid: "Paid",
          lms_exam_schedule_is_free_paid_value: "0",
        },
        {
          lms_exam_schedule_is_free_paid: "Free",
          lms_exam_schedule_is_free_paid_value: "1",
        },
      ],
SolutionDisplayItems: [
        {
          lms_exam_schedule_solution_display_type: "Visible",
          lms_exam_schedule_solution_display_type_value: "1",
        },
        {
          lms_exam_schedule_solution_display_type: "Not Visible",
          lms_exam_schedule_solution_display_type_value: "0",
        },
      ],


      selectedExamFreePaid:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_is_free_paid
          : "",

 selectedSolutionDisplayType:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_solution_display_type
          : "",


      // this.examScheduleDataProps != null ? this.examScheduleDataProps.lms_enquiry_gender : "",

      //this.examScheduleDataProps != null? this.examScheduleDataProps.lms_enquiry_marital_status: "",
      modalLiveFrom: false,
      modalLiveTo: false,
      selectedLiveFrom:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_live_from_date
          : moment(new Date()).format('YYYY-MM-DD HH:mm:ss'),
      selectedLiveTo:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_live_to_date
          : moment(new Date()).format('YYYY-MM-DD HH:mm:ss'),
      totalTime:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_total_time_alloted
          : null,
      passMarks:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_pass_marks
          : null,
      negativeMarks:
        this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_negative_marking
          : "",

      imageRule: [],
      selectedScheduleExamImage:null,

      // selectedScheduleExamImage: this.examScheduleDataProps != null
      //     ? this.examScheduleDataProps.lms_exam_schedule_image
      //     : "",

           ExamScheduleProfileImage: this.examScheduleDataProps != null
          ? process.env.MIX_EXAM_PROFILE_IMAGE_URL + this.examScheduleDataProps.lms_exam_schedule_image
          : "",





      isExamScheduleEdit: this.examScheduleDataProps != null ? 1 : 0,
      whatsAppMobileRules: [],

      isUploadDocumentFormValid: true,
      isUploadDocumentFormDataProcessing: false,

      fileRule: [],
        childCourseItems: [],


    };


  },
  watch: {
    selectedScheduleExamImage(val) {
      this.selectedScheduleExamImage = val;

      this.imageRule =
        this.selectedScheduleExamImage != null
          ? [
              (v) =>
                !v ||
                v.size <= 1048576 ||
                this.$t("label_file_size_criteria_1_mb"),
            ]
          : [];
    },
  },
  created() {




    // Token Config
    this.authorizationConfig = {
      headers: { Authorization: "Bearer " + ls.get("token") },
    };
    // Get Prefix Setting
    this.getPrefixModuleWise();

    // Get Active Sources
    this.getAllActiveInstruction();

    // Get Active Course
    this.getAllActiveCourse();

    // Get Active school
    this.getAllActiveScheduleType();

    if(this.selectedCourseId != null) {
    this. getAllActiveChildCourse();
}
  },
  methods: {
       // Get all active child course based on course
        getAllActiveChildCourse() {
            this.subjectDataLoading = true;
            this.$http
                .get(`web_get_all_active_child_course_wp`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        courseId: this.selectedCourseId
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
                })
                .then(({ data }) => {
                    this.subjectDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.childCourseItems = data;
                    }
                })
                .catch(error => {
                    this.isSourceDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
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
    // Ensure Digit Input with Decimal
    isDigitWithDecimal(evt) {
      evt = evt ? evt : window.event;
      var charCode = evt.which ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    // To ensure name is character without space only
    isCharacters(evt) {
      var regex = new RegExp("^[a-zA-Z]+$");
      var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
      if (!regex.test(key)) {
        evt.preventDefault();
        return false;
      }
    },
    // To ensure name is character with space only
    isCharactersWithSpace(evt) {
      var regex = new RegExp("^[a-zA-Z ]+$");
      var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
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
      this.$http
        .get(`web_get_prefix_module_wise`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            prefixModuleName: "Enquiry Code",
          },
          headers: { Authorization: "Bearer " + ls.get("token") },
        })
        .then(({ data }) => {
          //User Unauthorized
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
                this.$t("label_exam_will_be_generated") +
                this.$t("label_exam_next_step");
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
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Get all active sources
    getAllActiveInstruction() {
      this.isInstructionDataLoading = true;
      this.$http
        .get(`web_get_all_active_instruction_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
          },
          headers: { Authorization: "Bearer " + ls.get("token") },
        })
        .then(({ data }) => {
          this.isInstructionDataLoading = false;
          //User Unauthorized
          if (
            data.error == "Unauthorized" ||
            data.permissionError == "Unauthorized"
          ) {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.instructionItems = data;
          }
        })
        .catch((error) => {
          this.isInstructionDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },

    // Get all active course
    getAllActiveCourse() {
      this.isCourseDataLoading = true;
      this.$http
        .get(`web_get_active_course_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
          },
          headers: { Authorization: "Bearer " + ls.get("token") },
        })
        .then(({ data }) => {
          this.isCourseDataLoading = false;
          //User Unauthorized
          if (
            data.error == "Unauthorized" ||
            data.permissionError == "Unauthorized"
          ) {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.courseItems = data;
          }
        })
        .catch((error) => {
          this.isCourseDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },

    // Get all active school
    getAllActiveScheduleType() {
      this.isScheduleTypeDataLoading = true;
      this.$http
        .get(`web_get_active_schedule_type_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
          },
          headers: { Authorization: "Bearer " + ls.get("token") },
        })
        .then(({ data }) => {
          this.isScheduleTypeDataLoading = false;
          //User Unauthorized
          if (
            data.error == "Unauthorized" ||
            data.permissionError == "Unauthorized"
          ) {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.scheduleTypeItems = data;
          }
        })
        .catch((error) => {
          this.isScheduleTypeDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    //Save basic info
    saveExamSchedule() {
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
        basicFormData.append("isExamScheduleEdit", this.isExamScheduleEdit);

        basicFormData.append("centerId", ls.get("loggedUserCenterId"));

        if (this.scheduleId != "") {
          basicFormData.append("scheduleId", this.scheduleId);
        }

        basicFormData.append("loggedUserId", ls.get("loggedUserId"));

        basicFormData.append(
          "lms_exam_instruction_id",
          this.selectedInstructionId
        );
        if (this.selectedCourseId != "") {
          basicFormData.append("lms_course_id", this.selectedCourseId);
            basicFormData.append("lms_child_course_id", this.lms_child_course_id);

        }
        if (this.selectedScheduleTypeId != "") {
          basicFormData.append(
            "lms_exam_schedule_type",
            this.selectedScheduleTypeId
          );
        }
        basicFormData.append("lms_exam_schedule_name", this.examName);
        basicFormData.append(
          "lms_exam_schedule_description",
          this.examDescription
        );
        if (this.noOfQuestion != "") {
          basicFormData.append(
            "lms_exam_schedule_no_of_question",
            this.noOfQuestion
          );
        }
        if (this.maxMarks != "") {
          basicFormData.append("lms_exam_schedule_max_marks", this.maxMarks);
        }

        basicFormData.append(
          "lms_exam_schedule_has_negative_marking",
          this.isNegativeMarking
        );

        if (this.selectedResultDisplay != "") {
          basicFormData.append(
            "lms_exam_schedule_result_display_type",
            this.selectedResultDisplay
          );
        }

        if (this.selectedExamFreePaid != "") {
          basicFormData.append(
            "lms_exam_schedule_is_free_paid",
            this.selectedExamFreePaid
          );
        }

 if (this.selectedSolutionDisplayType != "") {
          basicFormData.append(
            "lms_exam_schedule_solution_display_type",
            this.selectedSolutionDisplayType
          );
        }


        basicFormData.append(
          "lms_exam_schedule_live_from",

          moment(new Date(this.selectedLiveFrom)).format("YYYY-MM-DD HH:mm:ss")
        );

        if (this.selectedLiveTo != "") {
          basicFormData.append(
            "lms_exam_schedule_live_to",
           moment(new Date(this.selectedLiveTo)).format("YYYY-MM-DD HH:mm:ss")
          );
        }
        basicFormData.append(
          "lms_exam_schedule_total_time_alloted",
          this.totalTime
        );
        if (this.passMarks != null) {
          basicFormData.append("lms_exam_schedule_pass_marks", this.passMarks);
        }
        basicFormData.append(
          "lms_exam_schedule_negative_marking",
          this.negativeMarks
        );








        if (this.selectedScheduleExamImage != null) {

basicFormData.append("lms_exam_schedule_image",this.selectedScheduleExamImage);
        }
        else
        {
          basicFormData.append("examImageName", this.examScheduleDataProps.lms_exam_schedule_image);
        }

        this.$http
          .post(
            "web_save_edit_exam_schedule",
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
              // Image uppload failed
              else if (data.responseData == 1) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_image_upload_failed")
                );
              }

              // Exam Saved
              else if (data.responseData == 4) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(
                  this.$t("label_exam_details_details_saved")
                );

                this.isExamScheduleEdit = 1;
                this.scheduleId = data.lms_exam_schedule_id;
                this.$router.push({name: "ExamDirectory"});
              }
              // Exam Data save failed
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
                  this.$t("label_exam_details_details_updates")

                );

                this.$router.push({name: "ExamDirectory"});

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
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },
  },
};
</Script>

