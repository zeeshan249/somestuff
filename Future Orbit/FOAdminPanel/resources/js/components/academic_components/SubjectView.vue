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
                            $t("label_subject")
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

                    <v-container>
                        <v-form
                            ref="saveSubjectForm"
                            v-model="issaveSubjectFormValid"
                            lazy-validation
                        >
                            <v-row dense>
                                <v-col cols="12" md="12" sm="12">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="courseId"
                                        :items="courseItems"
                                        :disabled="isSourceDataLoading"
                                        item-text="lms_course_name"
                                        item-value="lms_course_id"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_course") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-select>
                                </v-col>

                                <v-col cols="12" xs="12" sm="12" md="12">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="subjectCode"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_subject_code") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                            </v-row>

                            <v-row dense>
                                <v-col cols="12" xs="12" sm="12" md="12">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="subjectName"
                                        @keypress="isCharacters"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_subject_name") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-divider class="mx-4"></v-divider>
                            <div dense class="mx-2 text-center mb-2">
                                <v-btn
                                    v-permission="
                                        'Add Subject' | 'Edit Subject'
                                    "
                                    class="ma-2 rounded"
                                    tile
                                    color="primary"
                                    :disabled="
                                        !issaveSubjectFormValid ||
                                        issaveSubjectFormDataProcessing
                                    "
                                    @click="saveSubject"
                                    ><v-icon class="mr-2"
                                        >mdi-content-save</v-icon
                                    >
                                    {{
                                        issaveSubjectFormDataProcessing == true
                                            ? $t("label_processing")
                                            : $t("label_save")
                                    }}</v-btn
                                >

                                <v-btn
                                    v-permission="'Add Course' | 'Edit Course'"
                                    class="ma-2 rounded"
                                    tile
                                    color="error"
                                    @click="
                                        isAddCardVisible = !isAddCardVisible
                                    "
                                >
                                    <v-icon class="mx-2">mdi-cancel</v-icon
                                    >{{ $t("label_cancel") }}</v-btn
                                >
                            </div>
                        </v-form>
                    </v-container>
                </v-card>
            </v-col>
        </transition>
        <transition name="fade" mode="out-in">
            <v-data-table
                dense
                :headers="tableHeader"
                :items="dataTableRowNumbering"
                item-key="lms_subject_id"
                class="elevation-0"
                :loading="tableDataLoading"
                :loading-text="tableLoadingDataText"
                :server-items-length="totalItemsInDB"
                :items-per-page="100"
                @pagination="getAllSubject"
                :footer-props="{
                    itemsPerPageOptions: [100, 200, 300, -1],
                }"
            >
                <template v-slot:no-data>
                    <p class="font-weight-black bold title" style="color: red">
                        {{ $t("label_no_data_found") }}
                    </p>
                </template>
                <template v-slot:item.lms_subject_is_active="{ item }">
                    <v-chip
                        x-small
                        :color="getStatusColor(item.lms_subject_is_active)"
                        dark
                        >{{ item.lms_subject_is_active }}</v-chip
                    >
                </template>
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-text-field
                            v-model="searchText"
                            class="mt-4"
                            label="Search"
                            prepend-inner-icon="mdi-magnify"
                            @input="getAllSubject($event)"
                        ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <v-switch
                            class="pt-4 mx-1"
                            v-if="!tableDataLoading"
                            inset
                            v-model="includeDelete"
                            @change="getAllSubject"
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
                            Add {{ $t("label_subject") }}
                            <v-icon right dark> mdi-plus </v-icon>
                        </v-btn>
                    </v-toolbar>
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-icon
                        v-permission="'Edit Subject'"
                        small
                        class="mr-2"
                        @click="editSubject(item)"
                        color="primary"
                        >mdi-pencil</v-icon
                    >

                    <v-icon
                        v-if="item.lms_subject_is_active == 'Active'"
                        v-permission="'Edit Subject'"
                        small
                        color="error"
                        @click="disableSubject(item)"
                        >mdi-delete</v-icon
                    >
                    <v-icon
                        v-if="item.lms_subject_is_active == 'Inactive'"
                        v-permission="'Edit Subject'"
                        small
                        color="success"
                        @click="disableSubject(item)"
                        >mdi-check-circle</v-icon
                    >
                </template>
            </v-data-table>
        </transition>

        <!-- Card End -->
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
            includeDelete: false,
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
                    text: this.$t("label_subject"),
                    disabled: false,
                },
            ],
            isLoaderActive: false,

            courseId: "",
            subjectName: "",

            issaveSubjectFormValid: true,
            issaveSubjectFormDataProcessing: false,

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
                    text: this.$t("label_subject_code"),
                    value: "lms_subject_code",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: this.$t("label_subject_name"),
                    value: "lms_subject_name",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Stream",
                    value: "lms_course_name",
                    width: "35%",
                    sortable: false,
                },

                {
                    text: this.$t("label_status"),
                    value: "lms_subject_is_active",
                    align: "middle",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "30%",
                    align: "middle",
                },
            ],
            tableItems: [],
            isSaveEditClicked: 1,
            editsubjectId: "",
            courseImageNameForEdit: "",

            //Datatable End
            courseItems: [],
            // For Add Department card
            isAddCardVisible: false,

            // For Excel Download
            excelFields: {
                "Subject Code": "lms_subject_code",
                "Subject Name": "lms_subject_name",
                "Course Name": "lms_course_name",
                Status: "lms_subject_is_active",
            },
            excelData: [],
            excelFileName:
                "SubjectListAsExcel" +
                "_" +
                moment().format("DD/MM/YYYY") +
                ".xls",
        };
    },
    watch: {
        selectedCourseImage(val) {
            this.selectedCourseImage = val;

            this.imageRule =
                this.selectedCourseImage != null
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
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") },
        };
        // Get Active Sources
        this.getAllActiveCourses();
    },

    methods: {
        // Get all active sources
        getAllActiveCourses() {
            this.isSourceDataLoading = true;
            this.$http
                .get(`web_get_all_active_courses_without_pagination`, {
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
                        this.courseItems = data;
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

        editSubject(item) {
            this.isAddCardVisible = true;
            this.editsubjectId = item.lms_subject_id;
            this.isSaveEditClicked = 0;
            this.courseId = item.lms_course_id;
            this.subjectName = item.lms_subject_name;
            this.subjectCode = item.lms_subject_code;
        },
        // Disable Course status
        disableSubject(item, $event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_subject")
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_subject",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            subjectId: item.lms_subject_id,
                            isSubjectActive:
                                item.lms_subject_is_active == "Active" ? 0 : 1,
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
                                    this.$t("label_subject_status_changed")
                                );
                                this.getAllSubject(event);
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
        // Save Subject To DB after validation
        saveSubject($event) {
            if (this.$refs.saveSubjectForm.validate()) {
                this.issaveSubjectFormDataProcessing = true;
                let postData = new FormData();
                if (this.isSaveEditClicked == 1) {
                    postData.append("courseId", this.courseId);
                    postData.append("subjectName", this.subjectName);
                    postData.append("subjectCode", this.subjectCode);
                    postData.append("isSaveEditClicked", 1);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                } else {
                    postData.append("courseId", this.courseId);
                    postData.append("subjectName", this.subjectName);
                    postData.append("subjectCode", this.subjectCode);
                    postData.append("isSaveEditClicked", 0);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));

                    postData.append("subjectId", this.editsubjectId);
                }
                this.$http
                    .post(
                        "web_save_update_subject",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.issaveSubjectFormDataProcessing = false;
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
                                    this.$t("label_subject_exists")
                                );
                            }
                            // Course Saved
                            else if (data.responseData == 2) {
                                this.courseId = "";
                                this.subjectName = "";
                                this.subjectCode = "";

                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_subject_saved")
                                );
                                this.getAllSubject(event);
                                this.isSaveEditClicked = 1;
                            }
                            // Failed to save Course
                            else if (data.responseData == 3) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }

                            // Subject Updated
                            else if (data.responseData == 4) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_subject_updated")
                                );
                                this.getAllSubject(event);
                                this.isSaveEditClicked = 1;
                                this.courseId = "";
                                this.subjectName = "";
                                this.subjectCode = "";
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
                        this.issaveSubjectFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Subject from DB
        getAllSubject(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_subject?page=${e.page}`, {
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
                    { header: "Subject Code", dataKey: "lms_subject_code" },
                    { header: "Subject Name", dataKey: "lms_subject_name" },
                    { header: "Course Name", dataKey: "lms_course_name" },
                    { header: "Status", dataKey: "lms_subject_is_active" },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "SubjectListAsPDF" +
                    "_" +
                    moment().format("DD/MM/YYYY") +
                    ".pdf"
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
