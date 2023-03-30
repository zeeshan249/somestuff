<template>
    <!-- Card Start -->
    <v-container>
        <v-breadcrumbs :items="breadCrumbItem">
            <template v-slot:divider>
                <v-icon>mdi-forward</v-icon>
            </template>
        </v-breadcrumbs>
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
                $t("label_basic_info")
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
                                    $t("label_basic_info")
                                }}</v-toolbar-title>
                            </v-app-bar>

                            <v-row dense class="ml-2 mr-2 mt-2">
                                <v-col cols="12" md="4" sm="6">
                                    <v-text-field
                                        v-model="enquiryCode"
                                        outlined
                                        dense
                                        disabled
                                    >
                                        <template #label>{{
                                            $t("label_code")
                                        }}</template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="4" sm="6">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="selectedSourceId"
                                        :items="sourceItems"
                                        :disabled="isSourceDataLoading"
                                        item-text="lms_information_source_name"
                                        item-value="lms_information_source_id"
                                        :rules="[
                                            v => !!v || $t('label_required')
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_source") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-select>
                                </v-col>
                                <v-col cols="12" md="4" sm="6">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="selectedSchoolId"
                                        :items="schoolItems"
                                        :disabled="isSchoolDataLoading"
                                        item-text="lms_school_name"
                                        item-value="lms_school_name"
                                    >
                                        <template #label
                                            >{{ $t("label_school") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span></template
                                        >
                                    </v-select>
                                </v-col>
                            </v-row>
                            <v-row dense class="mx-2">
                                <v-col cols="12" md="6" sm="6">
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
                                            >{{ $t("label_course") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span></template
                                        >
                                    </v-select>
                                </v-col>
                                <v-col cols="12" md="6" sm="12" class="px-2">
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
                            </v-row>

                            <v-row dense class="ml-2 mr-2">
                                <v-col cols="12" md="3">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="firstName"
                                        @keypress="isCharacters"
                                        :rules="[
                                            v => !!v || $t('label_required')
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_first_name") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="3">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="lastName"
                                        @keypress="isCharacters"
                                        :rules="[
                                            v => !!v || $t('label_required')
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_last_name") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="3">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="fatherName"
                                        @keypress="isCharactersWithSpace"
                                    >
                                        <template #label>{{
                                            $t("label_father_name")
                                        }}</template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="3">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="motherName"
                                        @keypress="isCharactersWithSpace"
                                    >
                                        <template #label>{{
                                            $t("label_mother_name")
                                        }}</template>
                                    </v-text-field>
                                </v-col>
                            </v-row>

                            <v-row dense class="ml-2 mr-2">
                                <v-col cols="12" md="3">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="selectedGender"
                                        :items="genderItems"
                                        :rules="[
                                            v => !!v || $t('label_required')
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_gender") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-select>
                                </v-col>
                                <v-col cols="12" md="3">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="selectedMaritalStatus"
                                        :items="maritalStatusItems"
                                    >
                                        <template #label>{{
                                            $t("label_marital_status")
                                        }}</template>
                                    </v-select>
                                </v-col>

                                <v-col cols="12" md="3">
                                    <v-dialog
                                        ref="dialogDOB"
                                        v-model="modalDOB"
                                        :return-value.sync="selectedDOB"
                                        persistent
                                        width="290px"
                                    >
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-text-field
                                                outlined
                                                dense
                                                v-model="selectedDOB"
                                                prepend-inner-icon="mdi-calendar"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                                :rules="[
                                                    v =>
                                                        !!v ||
                                                        $t('label_required')
                                                ]"
                                            >
                                                <template #label>
                                                    {{ $t("label_dob") }}
                                                    <span class="red--text">
                                                        <strong>{{
                                                            $t("label_star")
                                                        }}</strong>
                                                    </span>
                                                </template>
                                            </v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="selectedDOB"
                                            scrollable
                                        >
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                text
                                                color="primary"
                                                @click="modalDOB = false"
                                                >{{ $t("label_cancel") }}</v-btn
                                            >
                                            <v-btn
                                                text
                                                color="primary"
                                                @click="
                                                    $refs.dialogDOB.save(
                                                        selectedDOB
                                                    )
                                                "
                                                >{{ $t("label_ok") }}</v-btn
                                            >
                                        </v-date-picker>
                                    </v-dialog>
                                </v-col>

                                <v-col cols="12" md="3">
                                    <v-dialog
                                        ref="dialogDOJ"
                                        v-model="modalDOJ"
                                        :return-value.sync="selectedDOJ"
                                        persistent
                                        width="290px"
                                    >
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-text-field
                                                outlined
                                                dense
                                                v-model="selectedDOJ"
                                                prepend-inner-icon="mdi-calendar"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                            >
                                                <template #label>{{
                                                    $t("label_doj")
                                                }}</template>
                                            </v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="selectedDOJ"
                                            scrollable
                                        >
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                text
                                                color="primary"
                                                @click="modalDOJ = false"
                                                >{{ $t("label_cancel") }}</v-btn
                                            >
                                            <v-btn
                                                text
                                                color="primary"
                                                @click="
                                                    $refs.dialogDOJ.save(
                                                        selectedDOJ
                                                    )
                                                "
                                                >{{ $t("label_ok") }}</v-btn
                                            >
                                        </v-date-picker>
                                    </v-dialog>
                                </v-col>
                            </v-row>

                            <v-row dense class="ml-2 mr-2">
                                <v-col cols="12" md="3">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="contactNumber"
                                        maxlength="10"
                                        :counter="10"
                                        @keypress="isDigit"
                                        :rules="[
                                            v =>
                                                !!v ||
                                                $t(
                                                    'label_provide_valid_mobile_number'
                                                ),
                                            v =>
                                                (v && v.length >= 10) ||
                                                $t(
                                                    'label_mobile_number_10_digits'
                                                )
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_contact_number") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="3">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="whatsAppNumber"
                                        :counter="10"
                                        maxlength="10"
                                        @keypress="isDigit"
                                        :rules="mobileRules"
                                    >
                                        <template #label>{{
                                            $t("label_whatsapp")
                                        }}</template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="3">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="email"
                                        type="email"
                                        :rules="[
                                            v => !!v || $t('label_required'),
                                            v =>
                                                !v ||
                                                /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(
                                                    v
                                                ) ||
                                                $t('label_provide_valid_email')
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_email") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="3">
                                    <v-file-input
                                        v-model="selectedProfilePicture"
                                        color="primary"
                                        outlined
                                        dense
                                        show-size
                                        accept="image/*"
                                        :rules="imageRule"
                                    >
                                        <template
                                            v-slot:selection="{ index, text }"
                                        >
                                            <v-chip
                                                v-if="index < 2"
                                                color="primary"
                                                dark
                                                label
                                                small
                                                >{{ text }}</v-chip
                                            >
                                        </template>
                                        <template #label>{{
                                            $t("label_profile_image")
                                        }}</template>
                                    </v-file-input>
                                </v-col>
                            </v-row>

                            <!-- New Row Start -->
                            <v-row dense class="ml-2 mr-2">
                                <v-col cols="12" md="6">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="currentAddress"
                                    >
                                        <template #label>{{
                                            $t("label_current_address")
                                        }}</template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="permanentAddress"
                                    >
                                        <template #label>{{
                                            $t("label_permanent_address")
                                        }}</template>
                                    </v-text-field>
                                </v-col>
                            </v-row>

                            <!-- New Row Start -->
                            <v-row dense class="ml-2 mr-2">
                                <v-col cols="12" md="3">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="qualification"
                                    >
                                        <template #label>{{
                                            $t("label_qualification")
                                        }}</template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="3">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="workExperience"
                                    >
                                        <template #label>{{
                                            $t("label_work_experience")
                                        }}</template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="aboutEnquiry"
                                    >
                                        <template #label>{{
                                            $t("label_about_enquiry")
                                        }}</template>
                                    </v-text-field>
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
                    @click="saveBasicInfo()"
                    >{{
                        isBasicFormDataProcessing == true
                            ? $t("label_processing")
                            : $t("label_save")
                    }}</v-btn
                >
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
export default {
    props: ["userPermissionDataProps", "enquiryDataProps"],
    data() {
        return {
            // For Breadcrumb
            breadCrumbItem: [
                {
                    text: this.$t("label_home"),
                    disabled: false
                },
                {
                    text: this.$t("label_enquiry"),
                    disabled: false
                },
                {
                    text: this.$t("label_add_enquiry"),
                    disabled: false
                }
            ],
            childCourseItems: [],

            alertType: "",
            alertMessage: "",
            // Snack Bar
            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",

            // Form Data
            authorizationConfig: "",

            stepperInfo: 1,
            enquiryCode:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_code
                    : "",

            selectedSourceId:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_information_source_id
                    : "",
            sourceItems: [],
            isSourceDataLoading: false,
            lms_child_course_id:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_child_course_id
                    : "",
            selectedCourseId:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_course_id
                    : "",
            courseItems: [],
            isCourseDataLoading: false,

            selectedSchoolId:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_school_name
                    : "",
            schoolItems: [],
            isSchoolDataLoading: false,
            isBasicHoldingFormValid: true,
            isBasicFormDataProcessing: false,
            firstName:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_first_name
                    : "",
            lastName:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_last_name
                    : "",
            fatherName:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_father_name
                    : "",
            motherName:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_mother_name
                    : "",
            genderItems: ["Male", "Female", "Transgender"],
            maritalStatusItems: [
                "Single",
                "Married",
                "Widowed",
                "Seprated",
                "Not specified"
            ],
            selectedGender:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_gender
                    : "",
            selectedMaritalStatus:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_marital_status
                    : "",
            modalDOB: false,
            modalDOJ: false,
            selectedDOB:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_date_of_birth
                    : new Date().toISOString().substr(0, 10),
            selectedDOJ:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_date_of_joining
                    : new Date().toISOString().substr(0, 10),
            contactNumber:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_mobile
                    : null,
            whatsAppNumber:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_whatsapp_contact
                    : null,
            email:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_email
                    : "",
            mobileRules: [],
            imageRule: [],

            selectedProfilePicture: null,
            currentAddress:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_local_address
                    : "",
            permanentAddress:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_permanent_address
                    : "",
            qualification:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_qualification
                    : "",
            workExperience:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_work_experience
                    : "",
            aboutEnquiry:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_about
                    : "",
            enquiryId:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_id
                    : "",
            enquiryUserId:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_user_id
                    : "",
            isEnquiryBasicEdit: this.enquiryDataProps != null ? 1 : 0,
            whatsAppMobileRules: [],
            isUploadDocumentFormValid: true,
            isUploadDocumentFormDataProcessing: false,

            fileRule: []
        };
    },
    watch: {
        whatsAppNumber(val) {
            this.whatsAppNumber = val;
            this.mobileRules =
                this.whatsAppNumber != ""
                    ? [
                          v =>
                              (v && v.length >= 10) ||
                              this.$t("label_whatsapp_mobile_number_10_digits")
                      ]
                    : [];
        },
        selectedProfilePicture(val) {
            this.selectedProfilePicture = val;

            this.imageRule =
                this.selectedProfilePicture != null
                    ? [
                          v =>
                              !v ||
                              v.size <= 1048576 ||
                              this.$t("label_file_size_criteria_1_mb")
                      ]
                    : [];
        },
        whatsApp(val) {
            this.whatsApp = val;
            this.whatsAppMobileRules =
                this.whatsApp != " "
                    ? [
                          v =>
                              (v && v.length >= 10) ||
                              this.$t("label_whatsapp_mobile_number_10_digits")
                      ]
                    : [];
        }
    },
    created() {
        console.log(this.enquiryDataProps);
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") }
        };
        // Get Prefix Setting
        this.getPrefixModuleWise();

        // Get Active Sources
        this.getAllActiveSources();

        // Get Active Course
        this.getAllActiveCourse();

        // Get Active school
        this.getAllActiveSchool();
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
            if (
                charCode != 46 &&
                charCode > 31 &&
                (charCode < 48 || charCode > 57)
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        // To ensure name is character without space only
        isCharacters(evt) {
            var regex = new RegExp("^[a-zA-Z]+$");
            var key = String.fromCharCode(
                !evt.charCode ? evt.which : evt.charCode
            );
            if (!regex.test(key)) {
                evt.preventDefault();
                return false;
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
            this.$http
                .get(`web_get_prefix_module_wise`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        prefixModuleName: "Enquiry Code"
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
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
                                this.$t(
                                    "label_enquiry_code_will_be_generated"
                                ) +
                                data[0].lms_prefix_pattern +
                                this.$t("label_if_want_to_change_enquiry_code");
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
                .catch(error => {
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        // Get all active sources
        getAllActiveSources() {
            this.isSourceDataLoading = true;
            this.$http
                .get(`web_get_all_active_sources_without_pagination`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId")
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
                })
                .then(({ data }) => {
                    this.isSourceDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.sourceItems = data;
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

        // Get all active course
        getAllActiveCourse() {
            this.isCourseDataLoading = true;
            this.$http
                .get(`web_get_active_course_without_pagination`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId")
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
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
                .catch(error => {
                    this.isCourseDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },

        // Get all active school
        getAllActiveSchool() {
            this.isSchoolDataLoading = true;
            this.$http
                .get(`web_get_active_school_without_pagination`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId")
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
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
                        this.schoolItems = data;
                    }
                })
                .catch(error => {
                    this.isSchoolDataLoading = false;
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
                        "content-type": "multipart/form-data"
                    }
                };
                this.isBasicFormDataProcessing = true;
                let basicFormData = new FormData();
                basicFormData.append(
                    "isEnquiryBasicEdit",
                    this.isEnquiryBasicEdit
                );

                basicFormData.append("centerId", ls.get("loggedUserCenterId"));
                if (this.enquiryId != "") {
                    basicFormData.append("enquiryId", this.enquiryId);
                }
                basicFormData.append("loggedUserId", ls.get("loggedUserId"));
                if (this.enquiryUserId != "") {
                    basicFormData.append("enquiryUserId", this.enquiryUserId);
                }
                basicFormData.append("enquirySourceId", this.selectedSourceId);
                if (this.selectedCourseId != "") {
                    basicFormData.append(
                        "enquiryCourseId",
                        this.selectedCourseId
                    );
                }
                if (this.selectedSchoolId != "") {
                    basicFormData.append(
                        "enquirySchoolId",
                        this.selectedSchoolId
                    );
                }
                basicFormData.append("enquiryFirstName", this.firstName);
                basicFormData.append("enquiryLastName", this.lastName);
                if (this.fatherName != "") {
                    basicFormData.append("enquiryFathersName", this.fatherName);
                }
                if (this.motherName != "") {
                    basicFormData.append("enquiryMothersName", this.motherName);
                }

                basicFormData.append("enquiryGender", this.selectedGender);
                if (this.selectedMaritalStatus != "") {
                    basicFormData.append(
                        "enquiryMaritalStatus",
                        this.selectedMaritalStatus
                    );
                }
                basicFormData.append("enquiryDOB", this.selectedDOB);
                if (this.selectedDOJ != "") {
                    basicFormData.append("enquiryDOJ", this.selectedDOJ);
                }
                basicFormData.append(
                    "enquiryContactNumber",
                    this.contactNumber
                );
                if (this.whatsAppNumber != null) {
                    basicFormData.append(
                        "enquiryWhatsAppNumber",
                        this.whatsAppNumber
                    );
                }
                basicFormData.append("enquiryEmail", this.email);
                if (this.selectedProfilePicture != null) {
                    basicFormData.append(
                        "enquiryProfileImage",
                        this.selectedProfilePicture
                    );
                }

                basicFormData.append(
                    "enquiryCurrentAddress",
                    this.currentAddress
                );
                basicFormData.append(
                    "enquiryPermanentAddress",
                    this.permanentAddress
                );
                basicFormData.append(
                    "enquiryQualification",
                    this.qualification
                );
                basicFormData.append("enquiryWorkExp", this.workExperience);
                basicFormData.append("enquiryAbout", this.aboutEnquiry);

                this.$http
                    .post(
                        "web_save_edit_enquiry_basic_info",
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
                                    this.$t("label_email_exists")
                                );
                            }
                            // Mobile exists
                            else if (data.responseData == 3) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_mobile_exists")
                                );
                            }

                            // Enquiry Saved
                            else if (data.responseData == 4) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_enquiry_details_saved")
                                );
                                this.isEnquiryBasicEdit = 1;
                                this.enquiryId = data.enquiryId;
                                this.enquiryUserId = data.enquiryUserId;
                                this.enquiryCode = data.enquiryCode;

                                // this.stepperInfo = 2;
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
                                    this.$t("label_enquiry_details_updated")
                                );

                                // this.stepperInfo = 2;
                            } else if (data.responseData == 7) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isBasicFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        }
    }
};
</script>
