<template>
    <!-- Card Start -->
    <v-container fluid style="max-width: 100% !important">
        <v-overlay :value="isLoaderActive" color="primary">
            <v-progress-circular
                indeterminate
                size="64"
                color="primary"
            ></v-progress-circular>
        </v-overlay>
        <transition name="fade" mode="out-in">
            <v-col class="d-flex flex-column pa-0 ma-0" v-if="isAddCardVisible">
                <v-card elevation="0">
                    <v-app-bar dark color="primary" flat>
                        <v-toolbar-title color="success">{{
                            $t("label_child_course")
                        }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon class="ma-2" outlined small color="white">
                            <v-icon
                                color="white"
                                @click="isAddCardVisible = !isAddCardVisible"
                                >mdi-minus</v-icon
                            >
                        </v-btn>
                    </v-app-bar>
                    <v-form
                        ref="saveChildCourseForm"
                        v-model="isSaveChildCourseFormValid"
                        lazy-validation
                    >
                        <v-row dense class="mx-2 mt-2">
                            <v-col cols="12" xs="12" sm="12" md="12">
                                <v-select
                                    v-model="selectedCourseId"
                                    :disabled="iscourseItemsLoading"
                                    :items="courseItems"
                                    dense
                                    outlined
                                    item-text="lms_course_name"
                                    item-value="lms_course_id"
                                >
                                    <template #label>
                                        Select Stream
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template></v-select
                                >
                            </v-col>
                        </v-row>
                        <v-row dense class="mx-2">
                            <v-col cols="12" xs="12" sm="12" md="6">
                                <v-select
                                    v-model="lms_child_course_is_online"
                                    :disabled="iscourseItemsLoading"
                                    :items="lms_child_course_is_online_items"
                                    dense
                                    outlined
                                    item-text="text"
                                    item-value="id"
                                >
                                    <template #label>
                                        Select Course Type
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template></v-select
                                >
                            </v-col>
                            <v-col cols="12" xs="12" sm="12" md="6">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="childCourseCode"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_course_code") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>

                        <v-row dense class="mx-2">
                            <v-col cols="12" xs="12" sm="12" md="12">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="childCourseName"
                                    @keypress="isCharacters"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_course_name") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>

                        <v-row dense class="mx-2">
                            <v-col cols="12" xs="12" sm="12" md="12">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="childCourseDescription"
                                >
                                    <template #label>
                                        {{ $t("label_course_description") }}
                                        <span class="red--text"></span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>

                        <v-row dense class="mx-2">
                            <v-col cols="12" xs="12" sm="12" md="6">
                                <v-text-field
                                    outlined
                                    dense
                                    @keypress="isDigitWithDecimal"
                                    v-model="childCourseFees"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_course_fees") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" xs="12" sm="12" md="6">
                                <v-text-field
                                    outlined
                                    dense
                                    @keypress="isDigit"
                                    v-model="childCourseDuration"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_course_duration") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row dense class="mx-2">
                            <v-col cols="12" xs="12" sm="12" md="12">
                                <v-file-input
                                    v-model="selectedChildCourseImage"
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
                                        $t("label_course_image")
                                    }}</template>
                                </v-file-input>
                            </v-col>
                        </v-row>
                        <v-divider class="mx-4"></v-divider>
                        <div dense class="mx-2 text-center mb-2">
                            <v-btn
                                v-permission="'Add Course' | 'Edit Course'"
                                class="ma-2 rounded"
                                tile
                                color="primary"
                                :disabled="
                                    !isSaveChildCourseFormValid ||
                                    isSaveChildCourseFormDataProcessing
                                "
                                @click="saveChildCourse"
                                ><v-icon class="mr-2">mdi-content-save</v-icon>
                                {{
                                    isSaveChildCourseFormDataProcessing == true
                                        ? $t("label_processing")
                                        : "Save Course"
                                }}</v-btn
                            >

                            <v-btn
                                v-permission="'Add Course' | 'Edit Course'"
                                class="ma-2 rounded"
                                tile
                                color="error"
                                :disabled="
                                    !isSaveChildCourseFormValid ||
                                    isSaveCourseFormDataProcessing
                                "
                                @click="isAddCardVisible = !isAddCardVisible"
                            >
                                <v-icon class="mx-2">mdi-cancel</v-icon
                                >{{
                                    isSaveCourseFormDataProcessing == true
                                        ? $t("label_processing")
                                        : $t("label_cancel")
                                }}</v-btn
                            >
                        </div>
                    </v-form>
                </v-card>
            </v-col>
        </transition>
        <transition name="fade" mode="out-in">
            <v-data-table
                dense
                :headers="tableHeader"
                :items="dataTableRowNumbering"
                item-key="lms_child_course_id"
                class="elevation-0 ma-0 pa-0"
                :loading="tableDataLoading"
                :loading-text="tableLoadingDataText"
                :server-items-length="totalItemsInDB"
                :items-per-page="100"
                @pagination="getAllChildCourse"
                :footer-props="{
                    itemsPerPageOptions: [100, 200, 300, - 1],
                }"
            >
                <template v-slot:no-data>
                    <p class="font-weight-black bold title" style="color: red">
                        {{ $t("label_no_data_found") }}
                    </p>
                </template>
                <template v-slot:item.lms_child_course_is_active="{ item }">
                    <v-chip
                        x-small
                        :color="getStatusColor(item.lms_child_course_is_active)"
                        dark
                        >{{ item.lms_child_course_is_active }}</v-chip
                    >
                </template>
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-text-field
                            v-model="searchText"
                            class="mt-4"
                            label="Search"
                            prepend-inner-icon="mdi-magnify"
                            @input="getAllChildCourse($event)"
                        ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <v-switch
                            class="pt-4 mx-1"
                            v-if="!tableDataLoading"
                            inset
                            v-model="includeDelete"
                            @change="getAllChildCourse"
                        ></v-switch>

                        <v-btn
                            icon
                            small
                            color="teal"
                            class="mx-1"
                            v-if="!tableDataLoading"
                        >
                            <download-excel
                                :data="excelData"
                                :fields="excelFields"
                                :name="excelFileName"
                            >
                                <v-icon dark>mdi-file-excel</v-icon>
                            </download-excel>
                        </v-btn>

                        <v-btn
                            v-if="!tableDataLoading"
                            class="mx-1"
                            icon
                            small
                            color="red"
                            @click="savePDF"
                        >
                            <v-icon dark>mdi-file-pdf</v-icon>
                        </v-btn>

                        <v-btn
                            v-permission="'Add Course'"
                            v-if="!isAddCardVisible"
                            color="primary"
                            class="white--text mx-2"
                            @click="isAddCardVisible = !isAddCardVisible"
                        >
                            Add Course
                            <v-icon right dark> mdi-plus </v-icon>
                        </v-btn>
                    </v-toolbar>
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-icon
                        v-permission="'Edit Course'"
                        small
                        class="mr-2"
                        @click="editCourse(item)"
                        color="primary"
                        >mdi-pencil</v-icon
                    >

                    <v-icon
                        v-if="item.lms_child_course_is_active == 'Active'"
                        v-permission="'Edit Course'"
                        small
                        color="error"
                        @click="disableCourse(item)"
                        >mdi-delete</v-icon
                    >
                    <v-icon
                        v-if="item.lms_child_course_is_active == 'Inactive'"
                        v-permission="'Edit Course'"
                        small
                        color="success"
                        @click="disableCourse(item)"
                        >mdi-check-circle</v-icon
                    >
                </template>
            </v-data-table>
        </transition>

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

//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
    props: ["userPermissionDataProps"],

    data() {
        return {
            // For Breadcrumb
            breadCrumbItem: [
                {
                    text: this.$t("label_home"),
                    disabled: false,
                },
                {
                    text: this.$t("label_academics"),
                    disabled: false,
                },
                {
                    text: this.$t("label_child_course"),
                    disabled: false,
                },
            ],
            lms_child_course_is_online: "",
            lms_child_course_is_online_items: [
                {
                    id: 1,
                    text: "Online & Offline",
                },
                {
                    id: 0,
                    text: "Offline",
                },
            ],
            includeDelete: false,
            selectedCourseId: null,
            iscourseItemsLoading: false,
            courseItems: [],
            isLoaderActive: false,
            imageRule: [],
            childCourseCode: "",
            childCourseName: "",
            childCourseDescription: "",
            childCourseDuration: "",
            childCourseFees: "",
            selectedChildCourseImage: null,

            isSaveChildCourseFormValid: true,
            isSaveChildCourseFormDataProcessing: false,

            authorizationConfig: "",

            // Snack Bar

            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",

            //   Datatable Start

            tableDataLoading: false,
            totalItemsInDB: 0,
            tableLoadingDataText: this.$t("label_loading_data"),

            tableHeader: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: this.$t("label_course_code"),
                    value: "lms_child_course_code",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Stream",
                    value: "lms_course_name",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Course",
                    value: "lms_child_course_name",
                    width: "25%",
                    sortable: false,
                },
                {
                    text: this.$t("label_course_fees"),
                    value: "lms_child_course_fees",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: this.$t("label_course_duration"),
                    value: "lms_child_course_duration",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: this.$t("label_status"),
                    value: "lms_child_course_is_active",
                    align: "middle",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "15%",
                    align: "middle",
                },
            ],
            tableItems: [],
            isSaveEditClicked: 1,
            editChildCourseId: "",
            courseImageNameForEdit: "",
            //Datatable End

            // For Add Course card
            isAddCardVisible: false,

            // For Excel Download
            excelFields: {
                "Course Code": "lms_child_course_code",
                "Course Name": "lms_child_course_name",
                "Course Description": "lms_child_course_description",
                "Course Duration(Months)": "lms_child_course_duration",
                "Course Fees": "lms_child_course_fees",
                Status: "lms_child_course_is_active",
            },
            excelData: [],
            excelFileName:
                "CourseListAsExcel" +
                "_" +
                moment().format("DD/MM/YYYY") +
                ".xls",
        };
    },
    watch: {
        selectedChildCourseImage(val) {
            this.selectedChildCourseImage = val;

            this.imageRule =
                this.selectedChildCourseImage != null
                    ? [
                          (v) =>
                              !v ||
                              v.size <= 1048576 ||
                              this.$t("label_file_size_criteria_1_mb"),
                      ]
                    : [];
        },
    },
    computed: {
        // For numbering the Data Table Rows
        dataTableRowNumbering() {
            return this.tableItems.map((items, index) => ({
                ...items,
                index: index + 1,
            }));
        },

        //End
    },

    created() {
        this.getAllActiveCourse();
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") },
        };
    },

    methods: {
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
        // Ensure Digit Input Field
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
        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },

        // Edit Course

        editCourse(item) {
            this.isAddCardVisible = true;
            this.editChildCourseId = item.lms_child_course_id;
            this.selectedCourseId = item.lms_course_id;
            this.lms_child_course_is_online = item.lms_child_course_is_online;
            this.isSaveEditClicked = 0;
            this.childCourseCode = item.lms_child_course_code;
            this.childCourseName = item.lms_child_course_name;
            this.childCourseDescription = item.lms_child_course_description;
            this.childCourseFees = item.lms_child_course_fees;
            this.childCourseDuration = item.lms_child_course_duration;
            this.courseImageNameForEdit = item.lms_child_course_image;
        },
        // Disable Course status
        disableCourse(item, $event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_course")
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_child_course",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            childCourseId: item.lms_child_course_id,
                            isCourseActive:
                                item.lms_child_course_is_active == "Active"
                                    ? 0
                                    : 1,
                            loggedUserId: ls.get("loggedUserId"),
                        },
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isLoaderActive = false;
                        //User Unauthorized
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            // Course Disabled
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_course_status_changed")
                                );
                                this.getAllChildCourse(event);
                            }
                            // Course Disabled failed
                            else if (data.responseData == 2) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch((error) => {
                        this.isLoaderActive = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },
        // To ensure course name is character and space only
        isCharacters(evt) {
            var regex = new RegExp("^[a-zA-Z ]+$");
            var key = String.fromCharCode(
                !evt.charCode ? evt.which : evt.charCode
            );
            if (!regex.test(key)) {
                evt.preventDefault();

                return false;
            }
        },
        // Save Course To DB after validation
        saveChildCourse($event) {
            if (this.$refs.saveChildCourseForm.validate()) {
                this.isSaveChildCourseFormDataProcessing = true;
                let postData = new FormData();
                if (this.isSaveEditClicked == 1) {
                    postData.append("courseId", this.selectedCourseId);
                    postData.append(
                        "lms_child_course_is_online",
                        this.lms_child_course_is_online
                    );
                    postData.append("childCourseCode", this.childCourseCode);
                    postData.append("childCourseName", this.childCourseName);
                    if (this.childCourseDescription != "") {
                        postData.append(
                            "childCourseDescription",
                            this.childCourseDescription
                        );
                    }

                    postData.append("childCourseFees", this.childCourseFees);
                    postData.append(
                        "childCourseDuration",
                        this.childCourseDuration
                    );
                    if (this.selectedChildCourseImage != null) {
                        postData.append(
                            "courseImage",
                            this.selectedChildCourseImage
                        );
                    }

                    postData.append("isSaveEditClicked", 1);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                } else {
                    postData.append("courseId", this.selectedCourseId);
                    postData.append(
                        "lms_child_course_is_online",
                        this.lms_child_course_is_online
                    );
                    postData.append("childCourseCode", this.childCourseCode);
                    postData.append("childCourseName", this.childCourseName);
                    if (this.childCourseDescription != "") {
                        postData.append(
                            "childCourseDescription",
                            this.childCourseDescription
                        );
                    }

                    postData.append("childCourseFees", this.childCourseFees);
                    postData.append(
                        "childCourseDuration",
                        this.childCourseDuration
                    );
                    if (this.selectedChildCourseImage != null) {
                        postData.append(
                            "courseImage",
                            this.selectedChildCourseImage
                        );
                    }

                    postData.append("isSaveEditClicked", 0);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                    
                    if (this.courseImageNameForEdit != "") {
                    postData.append(
                        "courseImageNameForEdit",
                        this.courseImageNameForEdit
                    );
                    }
                    postData.append("childCourseId", this.editChildCourseId);
                }
                this.$http
                    .post(
                        "web_save_update_child_course",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isSaveChildCourseFormDataProcessing = false;
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
                            // Course Code Exists
                            else if (data.responseData == 1) {
                                this.snackBarColor = "info";
                                this.changeSnackBarMessage(
                                    this.$t("label_course_exists")
                                );
                            }
                            // Course Saved
                            else if (data.responseData == 2) {
                                this.childCourseCode = "";
                                this.childCourseName = "";
                                this.childCourseDescription = "";
                                this.childCourseFees = "";
                                this.childCourseDuration = "";
                                this.selectedChildCourseImage = null;
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_course_saved")
                                );
                                this.getAllChildCourse(event);
                                this.isSaveEditClicked = 1;
                            }
                            // Failed to save Course
                            else if (data.responseData == 3) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }

                            // Course Updated
                            else if (data.responseData == 4) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_course_updated")
                                );
                                this.getAllChildCourse(event);
                                this.isSaveEditClicked = 1;
                                this.childCourseCode = "";
                                this.childCourseName = "";
                                this.childCourseDescription = "";
                                this.childCourseFees = "";
                                this.childCourseDuration = "";
                                this.selectedChildCourseImage = null;
                            }
                            // Course update failed
                            else if (data.responseData == 5) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                            // Image upload failed
                            else if (data.responseData == 6) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_image_upload_failed")
                                );
                            }
                        }
                    })
                    .catch((error) => {
                        this.isSaveChildCourseFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Course from DB
        getAllChildCourse(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_child_course?page=${e.page}`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        searchText: this.searchText,
                        includeDelete: this.includeDelete,
                        perPage:
                            e.itemsPerPage == -1
                                ? this.totalItemsInDB
                                : e.itemsPerPage,
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
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
                        this.tableItems = data.data;
                        this.totalItemsInDB = data.total;
                        this.excelData = data.data;
                    }
                })
                .catch((error) => {
                    this.tableDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        // Course Status Color
        getStatusColor(is_course_active) {
            if (is_course_active == "Active") return "success";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    { header: "Course Code", dataKey: "lms_child_course_code" },
                    { header: "Course Name", dataKey: "lms_child_course_name" },
                    {
                        header: "Course Description",
                        dataKey: "lms_child_course_description",
                    },
                    {
                        header: "Course Duration(Months)",
                        dataKey: "lms_child_course_duration",
                    },
                    { header: "Course Fees", dataKey: "lms_child_course_fees" },
                    { header: "Status", dataKey: "lms_child_course_is_active" },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "CourseListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
            );
        },
    },
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
</style>
