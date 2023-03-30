<template>
    <div id="app">
        <v-container
            fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
        >
            <v-sheet class="pa-4 mb-4" color="text-white">
                <v-row class="ml-4 mr-4 pt-4">
                    <v-toolbar-title dark color="primary">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">
                                    <strong>Add Register</strong>
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    >{{ $t("label_home")
                                    }}<v-icon>mdi-forward</v-icon>
                                    Add Register
                                    <v-icon>mdi-forward</v-icon>
                                    Add Register</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-row>
            </v-sheet>
            <v-overlay :value="alertMessage == ''" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
            <v-alert
                class="mx-4"
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
                            <v-card
                                class="mx-auto mt-2"
                                max-width="100%"
                                outlined
                            >
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
                                                (v) =>
                                                    !!v || $t('label_required'),
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
                                            item-value="lms_school_id"
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
                                            @change="
                                                getAllActiveChildCourse(this)
                                            "
                                        >
                                            <template #label
                                                >{{ $t("label_stream") }}
                                                <span class="red--text">
                                                    <strong>{{
                                                        $t("label_star")
                                                    }}</strong>
                                                </span></template
                                            >
                                        </v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="6"
                                        sm="12"
                                        class="px-2"
                                    >
                                        <v-select
                                            outlined
                                            dense
                                            v-model="lms_child_course_id"
                                            :items="childCourseItems"
                                            :disabled="isSourceDataLoading"
                                            item-text="lms_child_course_name"
                                            item-value="lms_child_course_id"
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                            ]"
                                        >
                                            <template #label>
                                                Course/Class
                                                <span class="red--text">
                                                    <strong>{{
                                                        $t("label_star")
                                                    }}</strong>
                                                </span>
                                            </template>
                                        </v-select>
                                    </v-col>
                                </v-row>

                                <v-row dense class="ml-2 mr-2 mt-2">
                                    <v-col cols="12" md="4" sm="6">
                                        <v-select
                                            outlined
                                            dense
                                            v-model="lms_enquiry_class"
                                            :items="classItems"
                                            item-text="lms_enquiry_class"
                                            item-value="lms_enquiry_class"
                                        >
                                            <template #label> Class </template>
                                        </v-select>
                                    </v-col>

                                    <v-col cols="12" md="4" sm="6">
                                        <v-select
                                            outlined
                                            dense
                                            v-model="lms_enquiry_section"
                                            :items="sectionItems"
                                        >
                                            <template #label>
                                                Section
                                            </template>
                                        </v-select>
                                    </v-col>

                                    <v-col cols="12" md="4" sm="6">
                                        <v-text-field
                                            v-model="lms_roll_no"
                                            outlined
                                            dense
                                        >
                                            <template #label>
                                                Roll No
                                            </template>
                                        </v-text-field>
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
                                                (v) =>
                                                    !!v || $t('label_required'),
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
                                                (v) =>
                                                    !!v || $t('label_required'),
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
                                                (v) =>
                                                    !!v || $t('label_required'),
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
                                                        (v) =>
                                                            !!v ||
                                                            $t(
                                                                'label_required'
                                                            ),
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
                                                    >{{
                                                        $t("label_cancel")
                                                    }}</v-btn
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
                                                    <template #label>
                                                        {{ $t("label_doj") }}
                                                        <span class="red--text">
                                                            <strong>{{
                                                                $t("label_star")
                                                            }}</strong>
                                                        </span>
                                                    </template>
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
                                                    >{{
                                                        $t("label_cancel")
                                                    }}</v-btn
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
                                                (v) =>
                                                    !!v ||
                                                    $t(
                                                        'label_provide_valid_mobile_number'
                                                    ),
                                                (v) =>
                                                    (v && v.length >= 10) ||
                                                    $t(
                                                        'label_mobile_number_10_digits'
                                                    ),
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
                                            :rules="[
                                                (v) =>
                                                    !!v ||
                                                    $t(
                                                        'label_provide_valid_mobile_number'
                                                    ),
                                                (v) =>
                                                    (v && v.length >= 10) ||
                                                    $t(
                                                        'label_mobile_number_10_digits'
                                                    ),
                                            ]"
                                        >
                                            <template #label>{{
                                                $t("label_whatsapp")
                                            }}</template>
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            outlined
                                            dense
                                            v-model="email"
                                            type="email"
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                                (v) =>
                                                    !v ||
                                                    /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(
                                                        v
                                                    ) ||
                                                    $t(
                                                        'label_provide_valid_email'
                                                    ),
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

                                <v-row dense class="ml-2 mr-2">
                                    <v-col
                                        cols="12"
                                        md="1"
                                        sm="12"
                                        class="pl-4"
                                    >
                                        <v-avatar color="indigo">
                                            <img :src="preview" />
                                        </v-avatar>
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
                                            @change="checkFile($event)"
                                        >
                                            <template
                                                v-slot:selection="{
                                                    index,
                                                    text,
                                                }"
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
                                : "Register"
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
        return {
            preview: null,
            lms_enquiry_class:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_class
                    : "",

            classItems: [
                "II",
                "III",
                "IV",
                "V",
                "VI",
                "VII",
                "VIII",
                "IX",
                "X",
                "XI",
                "XII",
            ],

            lms_enquiry_section:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_enquiry_section
                    : "",
            lms_roll_no:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_roll_no
                    : "",
            sectionItems: ["A", "B", "C", "D", "E", "F", "G"],

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
                    ? this.enquiryDataProps.lms_school_id
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
                "Not specified",
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

            fileRule: [],
        };
    },
    watch: {
        whatsAppNumber(val) {
            this.whatsAppNumber = val;
            this.mobileRules =
                this.whatsAppNumber != ""
                    ? [
                          (v) =>
                              (v && v.length >= 10) ||
                              this.$t("label_whatsapp_mobile_number_10_digits"),
                      ]
                    : [];
        },
        selectedProfilePicture(val) {
            this.selectedProfilePicture = val;

            this.imageRule =
                this.selectedProfilePicture != null
                    ? [
                          (v) =>
                              !v ||
                              v.size <= 1048576 ||
                              this.$t("label_file_size_criteria_1_mb"),
                      ]
                    : $t("label_required");
        },
        whatsApp(val) {
            this.whatsApp = val;
            this.whatsAppMobileRules =
                this.whatsApp != " "
                    ? [
                          (v) =>
                              (v && v.length >= 10) ||
                              this.$t("label_whatsapp_mobile_number_10_digits"),
                      ]
                    : [];
        },
    },
    created() {
        if (this.enquiryDataProps == null) {
            this.$router.push({
                name: "EnquiryDirectory",
            });
        }
        console.log(this.enquiryDataProps);
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") },
        };
        // Get Prefix Setting
        this.getPrefixModuleWise();

        // Get Active Sources
        this.getAllActiveSources();

        // Get Active Course
        this.getAllActiveCourse();

        // Get Active school
        this.getAllActiveSchool();

        if (this.selectedCourseId != null) {
            this.getAllActiveChildCourse();
        }
    },
    methods: {
        checkFile(file) {
            let reader = new FileReader();

            reader.onload = (event) => {
                this.preview = event.target.result;
            };
            reader.readAsDataURL(file);
        },

        // Send Whatsapp Message
        getSendWhatsappMessage(details) {
            var WAMessage = `
        ✨ Greetings from Future Orbit ✨

Welcome Dear ${details.name},
Your registration details as follows,
 👉 Student ID:   ${details.studentCode}%0A
 👉 Registration ID:   ${details.registrationCode}%0A
 👉 Course:  ${details.courseName}%0A
 👉 Course Duration:  ${details.courseDuration}%0A%0A
You can download our App from Play Store and login with following details:%0A
 👉  Login User ID:  ${details.mobile}%0A 
 👉  Password : ${details.password}%0A
Regards,%0A
Future Orbit - Admission Cell%0A%0A

To download our app from Play Store click here👉`;

            this.isSourceDataLoading = true;
            this.$http
                .get(`web_send_whatsapp/${details.whatsapp}/` + WAMessage, {
                    headers: { Authorization: "Bearer " + ls.get("token") },
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
                        this.sourceData = data;
                    }
                })
                .catch((error) => {
                    this.isSourceDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        // Get all active child course based on course
        getAllActiveChildCourse() {
            this.subjectDataLoading = true;
            this.$http
                .get(`web_get_all_active_child_course_wp`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        courseId: this.selectedCourseId,
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
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
                .catch((error) => {
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
                .catch((error) => {
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
                        centerId: ls.get("loggedUserCenterId"),
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
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
                .catch((error) => {
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
                        this.schoolItems = data;
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

                basicFormData.append("centerId", ls.get("loggedUserCenterId"));
                if (this.enquiryId != "") {
                    basicFormData.append("enquiryId", this.enquiryId);
                }
                basicFormData.append("loggedUserId", ls.get("loggedUserId"));

                basicFormData.append("enquirySourceId", this.selectedSourceId);
                if (this.selectedCourseId != "") {
                    basicFormData.append("courseId", this.selectedCourseId);
                }
                if (this.lms_child_course_id != "") {
                    basicFormData.append(
                        "lms_child_course_id",
                        this.lms_child_course_id
                    );
                }
                if (this.selectedProfilePicture != "") {
                    basicFormData.append(
                        "selectedProfilePicture",
                        this.selectedProfilePicture
                    );
                }

                basicFormData.append("enquiryFirstName", this.firstName);
                basicFormData.append("enquiryLastName", this.lastName);

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
                basicFormData.append(
                    "enquiryCurrentAddress",
                    this.currentAddress
                );
                basicFormData.append(
                    "enquiryPermanentAddress",
                    this.permanentAddress
                );
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
                if (this.whatsAppNumber != null) {
                    basicFormData.append(
                        "enquiryWhatsAppNumber",
                        this.whatsAppNumber
                    );
                }
                if (this.selectedDOJ != "") {
                    basicFormData.append("enquiryDOJ", this.selectedDOJ);
                }
                basicFormData.append(
                    "enquiryContactNumber",
                    this.contactNumber
                );
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
                basicFormData.append("enquiryEmail", this.email);

                this.$http
                    .post(
                        "web_register_user",
                        basicFormData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isBasicFormDataProcessing = false;
                        //User Unauthorizeddd
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            // Server side validation fails
                            if (data.responseData == 1) {
                                let details = {
                                    name: this.firstName.toUpperCase(),
                                    studentCode: data.studentCode,
                                    registrationCode: data.registrationCode,
                                    appUrl: data.appUrl,
                                    mobile: data.phoneNo,
                                    password: data.password,
                                    courseName: data.courseName,
                                    courseDuration: data.courseDuration,
                                    whatsapp: "91" + data.whatsapp,
                                };
                                this.getSendWhatsappMessage(details);
                                // );
                                const result = Global.showConfirmationAlert(
                                    ` Registration ID ${data.registrationCode}

                                        Course ID ${data.studentCode}
                                        `,
                                    "Student Registered Successfully",
                                    "success"
                                );
                                if (result) {
                                    this.$router.push({
                                        name: "EnquiryDirectory",
                                    });
                                }
                            } else if (data.responseData == 3) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_email_exists")
                                );
                            } else if (data.responseData == 4) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_mobile_exists")
                                );
                            } else if (data.responseData == 2) {
                                console.log("Error");
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
            } else {
                Global.showErrorAlert(
                    true,
                    "error",
                    "Please update student Information from Edit Section for Registering"
                );
            }
        },
    },
};
</script>
