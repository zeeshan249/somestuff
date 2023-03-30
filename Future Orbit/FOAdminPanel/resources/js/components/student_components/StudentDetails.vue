<template>
    <div style=" margin:auto; padding:auto; width:1200px;" id="app">
        <v-container
            style="background-color: #fff"
            class="ma-4 pa-0"
            width="100%"
        >
            <!-- Card Start -->
            <v-overlay :value="isLoaderActive" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
            <!-- Details Start -->
            <v-card>
                <v-toolbar color="primary" dark flat>
                    <v-toolbar-title>Student Information</v-toolbar-title>

                    <v-spacer></v-spacer>

                    <v-btn icon dark>
                        <v-icon @click="previousPage">mdi-close</v-icon>
                    </v-btn>

                    <template v-slot:extension>
                        <v-tabs v-model="tab" align-with-title>
                            <v-tabs-slider color="yellow"></v-tabs-slider>

                            <v-tab v-for="item in items" :key="item">
                                {{ item }}
                            </v-tab>
                        </v-tabs>
                    </template>
                </v-toolbar>

                <v-tabs-items v-model="tab">
                    <v-tab-item BasicInfo>
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
                                                    buildCoverImages(
                                                        buildProfileImage
                                                    )
                                                "
                                                :lazy-src="
                                                    buildCoverImages(
                                                        buildProfileImage
                                                    )
                                                "
                                            />
                                
                                        </v-list-item-avatar>
                                    </v-col>
                                    <v-col cols="12" md="10">
                                        <v-row dense>
                                            <v-col cols="12" md="12">
                                                <span
                                                    class="text-h4 font-weight-black text-uppercase"
                                                    >{{
                                                        lms_student_full_name
                                                    }}</span
                                                ></v-col
                                            >
                                        </v-row>
                                        <v-row dense>
                                            <v-col cols="12">
                                                Student ID:
                                                {{ lms_student_code }}
                                            </v-col>
                                        </v-row>
                                        <v-row dense>
                                            <v-col cols="12">
                                                Registration ID:
                                                {{ lms_registration_code }}
                                            </v-col>
                                        </v-row>
                                    </v-col>
                                </v-row>

                                <v-sheet color="transparent"> </v-sheet>
                            </v-card>
                            <v-form
                                ref="holdingFormUpdateStudent"
                                v-model="isUpdateStudentHoldingFormValid"
                                lazy-validation
                            >
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
                                    <v-row
                                        align="center"
                                        justify="end"
                                        class="mt-2"
                                    >
                                        <v-col cols="12" md="6" class="mt-2">
                                            <v-text-field
                                                regular
                                                dense
                                                v-model="firstName"
                                                @keypress="isCharacters"
                                                :rules="[
                                                    v =>
                                                        !!v ||
                                                        $t('label_required')
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
                                        <v-col cols="12" md="6" class="mt-2">
                                            <v-text-field
                                                regular
                                                dense
                                                v-model="lastName"
                                                @keypress="isCharacters"
                                                :rules="[
                                                    v =>
                                                        !!v ||
                                                        $t('label_required')
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
                                    </v-row>
                                </v-list-item>

                                <v-row dense class="mx-2">
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            regular
                                            dense
                                            v-model="fatherName"
                                            @keypress="isCharactersWithSpace"
                                        >
                                            <template #label>{{
                                                $t("label_father_name")
                                            }}</template>
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            regular
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

                                <v-row dense class="mx-2">
                                    <v-col cols="12" md="4">
                                        <v-select
                                            regular
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
                                    <v-col cols="12" md="4">
                                        <v-select
                                            regular
                                            dense
                                            v-model="selectedMaritalStatus"
                                            :items="maritalStatusItems"
                                        >
                                            <template #label>{{
                                                $t("label_marital_status")
                                            }}</template>
                                        </v-select>
                                    </v-col>

                                    <v-col cols="12" md="4">
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
                                                    regular
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
                                </v-row>

                                <v-row dense class="mx-2">
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            regular
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
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            regular
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
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            regular
                                            dense
                                            v-model="email"
                                            type="email"
                                            :rules="[
                                                v =>
                                                    !!v || $t('label_required'),
                                                v =>
                                                    !v ||
                                                    /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(
                                                        v
                                                    ) ||
                                                    $t(
                                                        'label_provide_valid_email'
                                                    )
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
                                    <v-col cols="12" md="3" v-if="false">
                                        <v-file-input
                                            v-model="selectedProfilePicture"
                                            color="primary"
                                            regular
                                            dense
                                            show-size
                                            accept="image/*"
                                            :rules="imageRule"
                                        >
                                            <template
                                                v-slot:selection="{
                                                    index,
                                                    text
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

                                <!-- New Row Start -->
                                <v-row dense class="mx-2">
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            regular
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
                                            regular
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
                                <v-row dense class="mx-2">
                                    <v-col cols="12" md="3">
                                        <v-text-field
                                            regular
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
                                            regular
                                            dense
                                            v-model="workExperience"
                                        >
                                            <template #label>{{
                                                $t("label_work_experience")
                                            }}</template>
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="3">
                                        <v-text-field
                                            regular
                                            dense
                                          readonly
                                          v-model="password_normal"
                                          :append-icon="isPasswordVisible ? 'mdi-eye' : 'mdi-eye-off'"
                                         :type="isPasswordVisible ? 'text' : 'password'"  
                                         @click:append="isPasswordVisible = !isPasswordVisible"
                                        >
                                            <template #label>
                                               Password 
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                            </v-form>
                            <v-divider class="mx-4"></v-divider>
                            <v-card-actions>
                                <v-list-item class="grow">
                                    <v-row align="center" justify="start">
                                        <v-switch
                                            class="mx-2"
                                            inset
                                            :label="
                                                lms_user_can_change_profile_image
                                                    ? 'Profile Image Unlocked'
                                                    : 'Profile Image Locked'
                                            "
                                            v-model="
                                                lms_user_can_change_profile_image
                                            "
                                        >
                                        </v-switch>
                                    </v-row>
                                    <v-row align="center" justify="end">
                                        <v-btn
                                            color="primary"
                                            :disabled="
                                                !isUpdateStudentHoldingFormValid ||
                                                    isStudentUpdateFormDataProcessing
                                            "
                                            @click="updateStudentDetails()"
                                            >{{
                                                isStudentUpdateFormDataProcessing ==
                                                true
                                                    ? $t("label_processing")
                                                    : "Update Details"
                                            }}</v-btn
                                        >
                                    </v-row>
                                </v-list-item>
                            </v-card-actions>
                        </v-card>
                    </v-tab-item>

                    <v-tab-item Course>
                        <v-card flat>
                            <v-card-text class="py-0">
                                <v-timeline align-top dense>
                                    <v-timeline-item
                                        fill-dot
                                        dark
                                        color="orange"
                                        large
                                    >
                                        <template v-slot:icon>
                                            <span class="white--text text-h6"
                                                >CR</span
                                            > </template
                                        ><v-row class="pt-1 white--black">
                                            <v-col cols="3">
                                                <strong>Stream: </strong>
                                                <strong>{{
                                                    lms_course_name
                                                }}</strong>
                                            </v-col>

                                            <v-col cols="3">
                                                <strong>Course: </strong>
                                                <strong>{{
                                                    lms_child_course_name
                                                }}</strong>
                                            </v-col>
                                            <v-col cols="3">
                                                <strong>Joined on: </strong>
                                                <strong>{{
                                                    lms_student_course_mapping_created_at
                                                }}</strong>
                                            </v-col>
                                        </v-row></v-timeline-item
                                    >
                                    <v-timeline-item
                                        fill-dot
                                        dark
                                        color="cyan"
                                        large
                                    >
                                        <template v-slot:icon>
                                            <span class="white--text text-h6"
                                                >BT</span
                                            > </template
                                        ><v-row class="pt-1 white--black">
                                            <v-col cols="3">
                                                <strong>Batch: </strong>
                                                <strong>{{
                                                    lms_batch_name
                                                }}</strong>
                                            </v-col>

                                            <v-col cols="3">
                                                <strong>Code: </strong>
                                                <strong>{{
                                                    lms_batch_code
                                                }}</strong>
                                            </v-col>
                                            <v-col cols="3">
                                                <strong>Joined on: </strong>
                                                <strong>{{
                                                    lms_batch_mapping_date
                                                }}</strong>
                                            </v-col>
                                        </v-row></v-timeline-item
                                    >
                                </v-timeline>
                            </v-card-text>
                        </v-card>
                    </v-tab-item>

                    <v-tab-item Exam
                        ><StudentExamDetails :studentId="lms_student_id" />
                    </v-tab-item>
                    <v-tab-item CourseWare>
                        <v-card flat>
                            <v-card-text></v-card-text>
                        </v-card>
                    </v-tab-item>

                    <v-tab-item Attendance @click="getAttendanceDateWise">
                        <div class="text-center ma-4">
                            <span class="mx-4"
                                ><strong>
                                    Name: {{ lms_student_full_name }}
                                </strong></span
                            >
                            <span class="mx-4"
                                ><strong>
                                    Code: {{ lms_student_code }}
                                </strong></span
                            >
                        </div>
                        <v-data-table
                            dense
                            :headers="tableHeaderStudent"
                            :items="dataTableRowNumberingStudent"
                            item-key="lms_attendance_Id"
                            class="elevation-0 mt-4"
                            :loading-text="tableLoadingDataText"
                        >
                            <template v-slot:no-data>
                                <p
                                    class="font-weight-black bold title"
                                    style="color: red"
                                >
                                    No Student Found
                                </p>
                            </template>

                            <template v-slot:item.AttendanceStatus="{ item }">
                                <v-chip
                                    x-small
                                    :color="
                                        getStatusColor(item.AttendanceStatus)
                                    "
                                    dark
                                    >{{ item.AttendanceStatus }}</v-chip
                                >
                            </template>
                        </v-data-table>
                    </v-tab-item>
                </v-tabs-items>
            </v-card>
            <!-- Details End -->
        </v-container>
    </div>
</template>
<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });
import DatetimePicker from "vuetify-datetime-picker";
import { Global } from "../../components/helpers/global";
import { StudentExamDetails } from "../../components/report_components/StudentExamDetails";
//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";
import Vue from "vue";
Vue.use(DatetimePicker);
import VueMask from "v-mask";
Vue.use(VueMask);
export default {
    components: {
        StudentExamDetails
    },
    props: ["userPermissionDataProps", "studentDetailsDataProps"],

    data() {
        return {
            isPasswordVisible:false,
            url: process.env.MIX_PROFILE_URL,
            
            authorizationConfig: "",
            testProp: "Test",
            isLoaderActive: false,
            tab: null,
            isUpdateStudentHoldingFormValid: true,
            isStudentUpdateFormDataProcessing: false,
            maritalStatusItems: [
                "Single",
                "Married",
                "Widowed",
                "Seprated",
                "Not specified"
            ],
            selectedDOB: new Date().toISOString().substr(0, 10),
            modalDOB: false,
            mobileRules: [],
            items: ["Basic Info", "Course", "Exam", "Courseware", "Attendance"],
            text: "",
            genderItems: ["Male", "Female", "Transgender"],
        
            selectedDOB:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_date_of_birth
                    : "",

            lms_user_id:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_user_id
                    : "",
            lms_enquiry_id:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_id
                    : "",
            firstName:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_first_name
                    : "",
            lastName:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_last_name
                    : "",
            fatherName:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_father_name
                    : "",

            motherName:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_mother_name
                    : "",
            selectedGender:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_gender
                    : "",
            selectedMaritalStatus:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_marital_status
                    : "",
            contactNumber:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_mobile
                    : "",
            currentAddress:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_local_address
                    : "",
            whatsAppNumber:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_whatsapp_contact
                    : "",
            qualification:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_qualification
                    : "",
            password_normal:this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.password_normal
                    : "",
            workExperience:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_work_experience
                    : "",
            email:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_email
                    : "",
            permanentAddress:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_enquiry_permanent_address
                    : "",
            lms_student_course_mapping_created_at:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps
                          .lms_student_course_mapping_created_at
                    : "",
            lms_course_name:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_course_name
                    : "",
            lms_child_course_name:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_child_course_name
                    : "",
            lms_batch_name:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_batch_name
                    : "Not yet joined",
            lms_batch_code:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_batch_code
                    : "NA",
            lms_batch_mapping_date:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_batch_mapping_date
                    : "NA",
            lms_student_full_name:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_student_full_name
                    : "na",
            lms_user_can_change_profile_image:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps
                          .lms_user_can_change_profile_image
                    : false,
            lms_registration_code:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_registration_code
                    : "NA",
            lms_student_code:
                this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_student_code
                    : "NA",
                  lms_student_id:
                  this.studentDetailsDataProps != null
                    ? this.studentDetailsDataProps.lms_student_id
                    : "",

             buildProfileImage :
             this.studentDetailsDataProps.lms_student_profile_image!=null
             ? this.studentDetailsDataProps.lms_student_profile_image:'',
             

             profileImagesUrl:"",
             altprofileImagesUrl:"",
            
            tableItemsBatchWiseStudent: [],
            tableLoadingDataText: this.$t("label_loading_attendance_data"),
            tableHeaderStudent: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: "Batch",
                    value: "lms_batch_code",
                    width: "15%",
                    sortable: false,
                    align: "center"
                },
                {
                    text: "Date",
                    value: "lms_attendance_date",
                    width: "15%",
                    sortable: false,
                    align: "center"
                },
                {
                    text: "Subject",
                    value: "lms_subject_name",
                    width: "15%",
                    sortable: false,
                    align: "center"
                },
                {
                    text: "Start Time",
                    value: "lms_batch_slot_start_time",
                    width: "10%",
                    sortable: false,
                    align: "center"
                },

                {
                    text: "End Time",
                    value: "lms_batch_slot_end_time",
                    width: "10%",
                    sortable: false,
                    align: "center"
                },
                {
                    text: "Status",
                    value: "AttendanceStatus",
                    width: "20%",
                    sortable: false,
                    align: "center"
                }
            ]
        };
    },
    watch: {},
    computed: {
        dataTableRowNumberingStudent() {
            return this.tableItemsBatchWiseStudent.map((items, index) => ({
                ...items,
                index: index + 1
            }));
        }
    },
    created() {
                if (this.studentDetailsDataProps == null) {
          this.$router.push({
              name: "StudentDirectory",
          });
      }
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") }
        };
        this.getAttendanceDateWise();
        // if (this.studentDetailsDataProps == null) this.previousPage();
        // if (this.studentDetailsDataProps != null)
        //     console.log(JSON.stringify(this.studentDetailsDataProps));
        // else this.previousPage();
        this.profileImagesUrl = process.env.MIX_PROFILE_URL;
        this.altprofileImagesUrl = this.profileImagesUrl + "NotAvailable.jpg";
    },
    methods: {
        getStatusColor(is_course_active) {
            if (is_course_active == "Present") return "success";
            else return "error";
        },
        //Get student attendance details
        getAttendanceDateWise() {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_student_attendance_date_wise`, {
                    params: {
                        lms_user_id: this.lms_user_id
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
                })
                .then(({ data }) => {
                    this.tableDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.tableItemsBatchWiseStudent = data;
                    }
                })
                .catch(error => {
                    this.tableDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        // Save Student To DB after validation
        async updateStudentDetails() {
            const result = await Global.showConfirmationAlert(
                `Are you sure you want to update student`,
                "You won't be able to revert this!",
                "warning"
            );
            if (result.isConfirmed) {
                if (this.$refs.holdingFormUpdateStudent.validate()) {
                    this.isStudentUpdateFormDataProcessing = true;
                    let postData = new FormData();
                    postData.append("lms_user_id", this.lms_user_id);
                    postData.append("lms_enquiry_id", this.lms_enquiry_id);
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                    postData.append("lms_student_first_name", this.firstName);
                    postData.append("lms_student_last_name", this.lastName);
                    postData.append(
                        "lms_student_mobile_number",
                        this.contactNumber
                    );
                    postData.append(
                        "lms_enquiry_local_address",
                        this.currentAddress
                    );
                    postData.append(
                        "lms_enquiry_date_of_birth",
                        this.selectedDOB
                    );
                    postData.append("lms_enquiry_father_name", this.fatherName);
                    postData.append("lms_enquiry_mother_name", this.motherName);
                    postData.append("lms_enquiry_gender", this.selectedGender);
                    postData.append(
                        "lms_enquiry_marital_status",
                        this.selectedMaritalStatus
                    );
                    postData.append(
                        "lms_enquiry_whatsapp_contact",
                        this.whatsAppNumber
                    );
                    postData.append(
                        "lms_enquiry_qualification",
                        this.qualification
                    );
                    postData.append("lms_enquiry_email", this.email);
                    postData.append(
                        "lms_enquiry_permanent_address",
                        this.permanentAddress
                    );
                    postData.append(
                        "lms_user_can_change_profile_image",
                        this.lms_user_can_change_profile_image
                    );

                    postData.append("centerId", ls.get("loggedUserCenterId"));

                    console.log(postData);
                    this.$http
                        .post(
                            "web_update_student_details",
                            postData,
                            this.authorizationConfig
                        )
                        .then(({ data }) => {
                            this.isStudentUpdateFormDataProcessing = false;
                            //User Unauthorized
                            if (
                                data.error == "Unauthorized" ||
                                data.permissionError == "Unauthorized"
                            ) {
                                this.$store.dispatch(
                                    "actionUnauthorizedLogout"
                                );
                            } else {
                                // Updated
                                if (data.responseData == 1) {
                                    Global.showSuccessAlert(
                                        true,
                                        "success",
                                        "Student details updated successfully",
                                        null
                                    );
                                }
                                // Error
                                else if (data.responseData == 2) {
                                    this.isStudentUpdateFormDataProcessing = false;
                                    Global.showErrorAlert(
                                        true,
                                        "error",
                                        this.$t("label_something_went_wrong"),
                                        null
                                    );
                                }
                            }
                        })
                        .catch(error => {
                            this.isStudentUpdateFormDataProcessing = false;
                            Global.showErrorAlert(
                                true,
                                "error",
                                this.$t("label_something_went_wrong"),
                                null
                            );
                        });
                }
            }
        },
     //#region [buildCoverImages]
          buildCoverImages(images) {
           
            return images !='' 
                ? this.profileImagesUrl+images
                : this.altprofileImagesUrl;
        },
        //#endregion
        previousPage() {
            this.$router.push({
                name: "StudentDirectory"
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
    opacity: 0;
}

.fluid-background {
    background-color: blue;
}

.work-experiences > div {
    margin: 2px 0;
    padding-bottom: 2px;
}
.work-experiences > div:not(:last-child) {
    border-bottom: 0px solid rgb(206, 212, 218);
}
</style>
