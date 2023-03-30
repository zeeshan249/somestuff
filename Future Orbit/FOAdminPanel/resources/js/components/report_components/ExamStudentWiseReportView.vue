<template>
    <div style="background-color: #d7d8db; height:100%" id="app">
        <!-- Card Start -->
        <v-container
            fluid
            style="background-color: #fff"
            class="ma-4 pa-0 width-100"
        >
            <v-progress-linear
                :active="isDataProcessing"
                :indeterminate="isDataProcessing"
                height="10"
                absolute
                top
                color="primary"
                background-color="primary lighten-3"
                striped
            ></v-progress-linear>
            <v-sheet class="pa-4 mb-4" color="text-white">
            <v-row class="ml-4 mr-4 pt-4">
                <v-toolbar-title dark color="primary">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                <strong>Exam Detail Report</strong>
                            </v-list-item-title>
                            <v-list-item-subtitle
                                >Home <v-icon>mdi-forward</v-icon> Report
                                <v-icon>mdi-forward</v-icon>
                                <strong @click="PrevScreen()" class="pointer"
                                    >Exam Report</strong
                                >
                                <v-icon>mdi-forward</v-icon> Exam Detail
                                Report</v-list-item-subtitle
                            >
                        </v-list-item-content>
                    </v-list-item>
                </v-toolbar-title>
                <v-spacer></v-spacer>

                <v-btn class="ma-2" color="primary" @click="PrevScreen()">
                    <v-icon class="mr-2" color="white"
                        >mdi-arrow-left-thick</v-icon
                    >
                    Back to Exam Report
                </v-btn>
            </v-row>
            </v-sheet>
            <transition name="fade" mode="out-in">
                <v-data-table
                    max-width="100%"
                    dense
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    item-key="lms_exam_schedule_id"
                    class="elevation-1 width-100"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="200"
                    @pagination="getAllExamSchedule"
                    :footer-props="{
                        itemsPerPageOptions: [50, 200, 500, 1000, -1]
                    }"
                >
                    <template v-slot:no-data>
                        <p
                            class="font-weight-black bold title"
                            style="color: red"
                        >
                            {{ $t("label_no_data_found") }}
                        </p>
                    </template>
                    <template
                        v-slot:item.lms_exam_result_details_is_active="{ item }"
                    >
                        <v-chip
                            x-small
                            :color="
                                getStatusColor(
                                    item.lms_exam_result_details_is_active
                                )
                            "
                            dark
                            >{{
                                item.lms_exam_result_details_is_active
                            }}</v-chip
                        >
                    </template>

                    <template v-slot:item.lms_total_marks_scored="{ item }">
                        <v-chip
                            x-small
                            :color="getPassFailStatusColor(item)"
                            dark
                            >{{ item.lms_total_marks_scored }}</v-chip
                        >
                    </template>

                    <template v-slot:top>
                        <v-toolbar flat>
                            <!-- <v-text-field
                                dense
                                class="mt-4 mx-4"
                                v-model="examSearchCriteria"
                                :label="lblSearchExamCriteria"
                                @input="searchTable($event)"
                                prepend-inner-icon="mdi-magnify"
                            ></v-text-field> -->
                            <v-spacer></v-spacer>
                            <v-card-text class="text--primary">
                                <div class="mx-2">
                                    <strong>Exam: </strong>
                                    {{ lms_exam_schedule_name }}
                                </div>
                                <div class="mx-2">
                                    <strong>Course: </strong>
                                    {{ lms_course_name }}
                                </div>
                            </v-card-text>
                            <!-- <v-select
                                v-model="selectedExamType"
                                :disabled="isexamTypeDataLoading"
                                :items="examTypeData"
                                class="mt-4 mx-4"
                                dense
                                :label="lblSelectExamType"
                                item-text="lms_exam_schedule_type"
                                item-value="lms_exam_schedule_type"
                                @change="
                                    isSearchByExamType = true;
                                    getAllExamSchedule($event);
                                "
                            ></v-select> -->

                            <v-btn
                                icon
                                small
                                color="teal"
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
                                class="mr-2"
                                icon
                                small
                                color="red"
                                @click="savePDF"
                            >
                                <v-icon dark>mdi-file-pdf</v-icon>
                            </v-btn>
                        </v-toolbar>
                    </template>

                    <template v-slot:item.actions="{ item }" v-if="false">
                        <v-icon
                            @click="ViewStudentDetails(item)"
                            color="primary"
                        >
                            mdi-eye-outline
                        </v-icon>
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

            <!-- //Set Dialog -->
            <v-dialog v-model="dialog" hide-overlay persistent width="500">
                <v-card color="error" dark>
                    <v-card-title class="headline">
                        Updating Data!!! Please Wait...
                    </v-card-title>

                    <v-card-text>
                        Your request is processing!!! I will automatically close
                        when done.
                        <v-progress-linear
                            indeterminate
                            color="white"
                            class="mb-0"
                        ></v-progress-linear>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </v-container>
    </div>
</template>
<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });

//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
    props: ["userPermissionDataProps", "examReportDataProps"],

    data() {
        return {
            // For Breadcrumb
            breadCrumbItem: [
                {
                    text: this.$t("label_home"),
                    disabled: false
                },
                {
                    text: this.$t("label_exam_schedule"),
                    disabled: false
                },
                {
                    text: this.$t("label_exam_schedule_directory"),
                    disabled: false
                }
            ],

            viewExamScheduleDialog: false,
            // Form Data
            lblSelectExamType: this.$t("label_select_exam_type"),
            selectedExamType: "",
            isDataProcessing: false,
            examSearchCriteria: "",
            lblSearchExamCriteria: "Search by Name",
            isexamTypeDataLoading: false,
            examTypeData: [],
            isSearchByExamType: false,
            authorizationConfig: "",
            dialog: false,

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
                    text: "Student",
                    value: "lms_student_full_name",
                    width: "20%",
                    sortable: false
                },
                {
                    text: "Scheduled",
                    value: "lms_exam_schedule_no_of_question",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Attempted",
                    value: "lms_total_answer_attempted",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Pass Marks",
                    value: "lms_exam_schedule_pass_marks",
                    align: "middle",
                    width: "5%",
                    sortable: false
                },
                {
                    text: "Score",
                    value: "lms_total_marks_scored",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Start Time",
                    value: "lms_exam_result_created_at",
                    width: "15%",
                    sortable: false
                },
                {
                    text: "End Time",
                    value: "lms_exam_result_details_submitted_at",
                    width: "15%",
                    sortable: false
                },

                {
                    text: this.$t("label_status"),
                    value: "lms_exam_result_details_is_active",
                    align: "middle",
                    width: "5%",
                    sortable: false
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "10%",
                    align: "middle"
                }
            ],
            tableItems: [],
            isDataProcessing: false,

            //Datatable End

            //View props
            lms_exam_schedule_id: "",
            lms_exam_schedule_type: "",
            lms_exam_schedule_name:
                this.examReportDataProps != null
                    ? this.examReportDataProps.lms_exam_schedule_name
                    : "",
            lms_exam_schedule_description: "",
            lms_exam_schedule_negative_marking: "",
            lms_exam_schedule_result_display_type: "",
            lms_exam_schedule_no_of_question: "",
            lms_exam_schedule_max_marks: "",
            lms_exam_schedule_total_time_alloted: "",
            lms_exam_schedule_is_free_paid_status: "",
            lms_exam_schedule_pass_marks: "",
            lms_exam_schedule_has_negative_marking_status: "",
            lms_exam_schedule_image: "",
            lms_exam_schedule_image_alt: "",
            lms_exam_instruction_title: "",
            lms_course_name:
                this.examReportDataProps != null
                    ? this.examReportDataProps.lms_course_name
                    : "",
            lms_topic_name: "",
            lms_subject_name: "",
            lms_exam_instruction: "",
            lms_exam_schedule_is_active_status: "",
            lms_exam_schedule_live_from: "",
            lms_exam_schedule_live_to: "",
            lms_exam_schedule_is_active_live: "",

            // For Excel Download
            excelFields: {
                Code: "lms_enquiry_code",
                Date: "lms_enquiry_date",
                Source: "source_name",
                Name: "lms_enquiry_full_name",
                Mobile: "lms_enquiry_mobile",
                Email: "lms_enquiry_email",
                School: "lms_enquiry_school_name",
                Remarks: "lms_enquiry_remarks",
                Status: "lms_enquiry_status"
            },
            excelData: [],
            excelFileName:
                "EnquiryListAsExcel" +
                "_" +
                moment().format("DD/MM/YYYY") +
                ".xls"
        };
    },
    computed: {
        // For numbering the Data Table Rows
        dataTableRowNumbering() {
            return this.tableItems.map((items, index) => ({
                ...items,
                index: index + 1
            }));
        }

        //End
    },

    created() {
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") }
        };

        // Get all active sources
        //  this.getAllActiveExamType();

        if (this.examReportDataProps != null) {
            this.lms_exam_schedule_id =
                this.examReportDataProps != null
                    ? this.examReportDataProps.lms_exam_schedule_id
                    : "";
        } else {
            this.PrevScreen();
        }
    },

    methods: {
        PrevScreen() {
            this.$router.push({ name: "ExamReport" });
        },
        searchTable(e) {
            clearTimeout(this._timerId);
            this._timerId = setTimeout(() => {
                this.isSearchByExamType = false;
                this.getAllExamSchedule(e);
            }, 500);
        },
        // Get all active sources
        getAllActiveExamType() {
            this.isexamTypeDataLoading = true;
            this.$http
                .get(`web_get_all_active_exam_type_without_pagination`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId")
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
                })
                .then(({ data }) => {
                    this.isexamTypeDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.examTypeData = data;
                    }
                })
                .catch(error => {
                    this.isexamTypeDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },

        // Edit Exam Schedule
        viewExamSchedule(item) {
            this.$router.push({
                name: "ViewExamSchedule",
                params: { examReportDataProps: item }
            });
        },

        // Get all Staff from DB
        getAllExamSchedule(e) {
            this.tableDataLoading = true;
            let postData = "";
            if (this.isSearchByExamType == true) {
                postData = {
                    centerId: ls.get("loggedUserCenterId"),
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDB
                            : e.itemsPerPage,
                    filterBy: this.selectedExamType,
                    lms_exam_schedule_id: this.lms_exam_schedule_id
                };
            } else {
                postData = {
                    centerId: ls.get("loggedUserCenterId"),
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDB
                            : e.itemsPerPage,
                    filterBy: this.examSearchCriteria,
                    lms_exam_schedule_id: this.lms_exam_schedule_id
                };
            }

            this.$http
                .get(`web_get_all_exam_student_wise_report?page=${e.page}`, {
                    params: postData,
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
                        this.tableItems = data.data;
                        this.totalItemsInDB = data.total;
                        this.excelData = data.data;
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
        // Source Status Color
        getStatusColor(is_source_acive) {
            if (is_source_acive == "Active") return "success";
            if (is_source_acive == "Submitted") return "primary";
            else return "error";
        },

        // Source Status Color
        getPassFailStatusColor(item) {
            if (
                parseInt(item.lms_total_marks_scored) >=
                parseInt(item.lms_exam_schedule_pass_marks)
            )
                return "success";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF({ orientation: "landscape" });

            pdfDoc.autoTable({
                columns: [
                    { header: "Course", dataKey: "lms_course_name" },
                    { header: "Type", dataKey: "lms_exam_schedule_type" },
                    { header: "Name", dataKey: "lms_exam_schedule_name" },
                    {
                        header: "Live From",
                        dataKey: "lms_exam_schedule_live_from"
                    },
                    { header: "Live To", dataKey: "lms_exam_schedule_live_to" },

                    {
                        header: "Total Question",
                        dataKey: "lms_exam_schedule_no_of_question"
                    },
                    {
                        header: "Total Marks",
                        dataKey: "lms_exam_schedule_max_marks"
                    },
                    {
                        header: "Total Time",
                        dataKey: "lms_exam_schedule_total_time_alloted"
                    },
                    {
                        header: "Free/Paid",
                        dataKey: "lms_exam_schedule_is_free_paid"
                    },
                    {
                        header: "Pass Marks",
                        dataKey: "lms_exam_schedule_pass_marks"
                    },
                    {
                        header: "Status",
                        dataKey: "lms_exam_schedule_is_active_live"
                    }
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 }
            });
            pdfDoc.save(
                "EnquiryListAsPDF" +
                    "_" +
                    moment().format("DD/MM/YYYY") +
                    ".pdf"
            );
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

.v-sheet--offset {
    top: -24px;
    position: relative;
}
.pointer {
    cursor: pointer;
}
</style>
