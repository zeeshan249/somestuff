<template>
    <div style="background-color: #d7d8db; height: 100%" id="app">
        <v-container
            style="background-color: #fff"
            class="ma-4 pa-0"
            width="100%"
            fluid
        >
            <v-overlay :value="isLoaderActive" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
            <v-row class="ml-4 mr-4 pt-4">
                <v-toolbar-title dark color="primary">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                <strong>Add Subscription</strong>
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                Home
                                <v-icon>mdi-forward</v-icon>
                                Accounts
                                <v-icon>mdi-forward</v-icon> Subscription
                                <v-icon>mdi-forward</v-icon> Add Subscription
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                    v-permission="'Add Subscription'"
                    :disabled="tableDataLoading"
                    color="primary"
                    class="white--text"
                    @click="isAddCardVisible = !isAddCardVisible"
                >
                    Subscribe Student
                    <v-icon right dark> mdi-plus </v-icon>
                </v-btn>
            </v-row>
            <transition name="fade" mode="out-in" v-if="isAddCardVisible">
                <v-data-table
                    dense
                    :headers="tableHeaderStudents"
                    :items="dataTableStudentsRowNumbering"
                    class="elevation-0"
                    :loading="tableDataLoadingStudent"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDBStudent"
                    :items-per-page="100"
                    :footer-props="{
                        itemsPerPageOptions: [100, 200, 300, -1]
                    }"
                >
                    <template v-slot:no-data>
                        <p
                            class="font-weight-black bold title"
                            style="color:red"
                        >
                            Enter Name in Search Box and Press Enter Button
                        </p>
                    </template>
                    <template
                        v-slot:item.lms_student_registration_type="{
                            item
                        }"
                    >
                        <v-chip
                            x-small
                            :color="
                                getStudenttatusColor(
                                    item.lms_student_registration_type
                                )
                            "
                            dark
                            >{{ item.lms_student_registration_type }}</v-chip
                        >
                    </template>

                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-text-field
                                prepend-inner-icon="mdi-magnify"
                                class="mt-4 mx-4"
                                v-model="studentSearchCriteria"
                                label="Press Enter to Search"
                                @keyup.enter="
                                    isSearchBySource = false;
                                    getAllStudents($event);
                                "
                            ></v-text-field>
                            <v-spacer></v-spacer>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <v-chip
                            x-small
                            color="primary"
                            dark
                            @click="SubscribeStudent(item)"
                            >Subscribe</v-chip
                        >
                    </template>
                </v-data-table>
            </transition>

            <transition name="fade" mode="out-in">
                <v-data-table
                    dense
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    item-key="lms_subject_id"
                    class="elevation-1"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="15"
                    @pagination="getAllAssignedSubscription"
                    :footer-props="{
                        itemsPerPageOptions: [15, 25, 50, -1]
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
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-spacer></v-spacer>
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

                    <template v-slot:item.actions="{ item }">
                        <v-chip
                            v-permission="'Delete Subscription'"
                            v-if="item.card_active == 'Active'"
                            x-small
                            color="error"
                            @click="disableSubscription(item)"
                            dark
                            >Inactive</v-chip
                        >

                        <v-icon
                            v-if="item.card_active == 'Inactive'"
                            v-permission="'Delete Subscription'"
                            small
                            color="success"
                            @click="disableSubscription(item)"
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
    </div>
</template>
<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });
import { Global } from "../../components/helpers/global";
//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
    props: ["userPermissionDataProps", "subscriptionDataProps"],

    data() {
        return {
            // For Breadcrumb
            breadCrumbItem: [
                {
                    text: this.$t("label_home"),
                    disabled: false
                },
                {
                    text: this.$t("label_accounts"),
                    disabled: false
                },
                {
                    text: this.$t("label_subscription"),
                    disabled: false
                }
            ],
            isSearchBySource: false,
            studentSearchCriteria: "",
            lblSearchStudentCriteria: this.$t("label_search_student_criteria"),
            isLoaderActive: false,
            lms_exam_card_name: "",
            lms_exam_card_payment_month_duration: "",
            lms_exam_card_charge_per_month: "",

            courseId: "",
            subjectName: "",

            issaveSubscriptionFormValid: true,
            issaveSubscriptionFormDataProcessing: false,

            authorizationConfig: "",

            // Snack Bar

            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",

            //   Datatable Start

            tableDataLoading: false,
            tableDataLoadingStudent: false,
            totalItemsInDB: 0,
            totalItemsInDBStudent: 0,
            tableLoadingDataText: this.$t("label_loading_data"),
            tableHeaderStudents: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: this.$t("label_code"),
                    value: "lms_registration_code",
                    width: "10%",
                    sortable: false
                },
                {
                    text: this.$t("label_date"),
                    value: "lms_student_course_mapping_created_at",
                    width: "10%",
                    sortable: false
                },
                {
                    text: this.$t("label_name"),
                    value: "lms_student_full_name",
                    width: "15%",
                    sortable: false
                },
                {
                    text: this.$t("label_course"),
                    value: "lms_child_course_name",
                    width: "20%",
                    sortable: false
                },
                {
                    text: this.$t("label_mobile"),
                    value: "lms_student_mobile_number",
                    width: "10%",
                    sortable: false
                },

                {
                    text: this.$t("label_batch_name"),
                    value: "lms_batch_code",
                    width: "10%",
                    sortable: false
                },
                {
                    text: this.$t("label_status"),
                    value: "lms_student_registration_type",
                    align: "end",
                    width: "5%",
                    sortable: false
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "15%",
                    align: "middle",
                    visible: "false"
                }
            ],
            tableHeader: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: "Subscriber",
                    value: "lms_student_full_name",
                    width: "25%",
                    sortable: false
                },
                {
                    text: "Card Name",
                    value: "lms_exam_card_name",
                    width: "20%",
                    sortable: false
                },
                {
                    text: "Stream",
                    value: "lms_course_name",
                    width: "10%",
                    sortable: false
                },
                {
                    text: this.$t("label_subscription_duration"),
                    value: "lms_exam_card_payment_month_duration",
                    width: "5%",
                    sortable: false
                },
                {
                    text: "Expire On",
                    value: "lms_exam_card_expiry_date",
                    width: "25%",
                    sortable: false
                },

                {
                    text: this.$t("label_subscription_value"),
                    value: "lms_exam_card_charge_per_month",
                    width: "5%",
                    sortable: false
                },

                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "5%",
                    align: "middle"
                }
            ],
            tableItems: [],
            tableItemsStudent: [],
            isSaveEditClicked: 1,
            courseImageNameForEdit: "",

            //Datatable End
            courseItems: [],
            // For Add Department card
            isAddCardVisible: false,

            // For Excel Download
            excelFields: {
                Subscription: "lms_exam_card_name",
                Duration: "lms_exam_card_payment_month_duration",
                "Course Name": "lms_course_name",
                Status: "card_active"
            },
            excelData: [],
            excelFileName:
                "Subscription" + "_" + moment().format("DD/MM/YYYY") + ".xls"
        };
    },
    watch: {
        selectedCourseImage(val) {
            this.selectedCourseImage = val;

            this.imageRule =
                this.selectedCourseImage != null
                    ? [
                          v =>
                              !v ||
                              v.size <= 1048576 ||
                              this.$t("label_file_size_criteria_1_mb")
                      ]
                    : [];
        }
    },
    computed: {
        // For numbering the Data Table Rows
        dataTableRowNumbering() {
            return this.tableItems.map((items, index) => ({
                ...items,
                index: index + 1
            }));
        },
        dataTableStudentsRowNumbering() {
            return this.tableItemsStudent.map((items, index) => ({
                ...items,
                index: index + 1
            }));
        }

        //End
    },

    created() {
        if (this.subscriptionDataProps == null) {
            this.$router.push({
                name: "Subscription"
            });
        }
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") }
        };
    },

    methods: {
        // Get all Students from DB
        getAllStudents(e) {
            this.tableDataLoadingStudent = true;
            let postData = "";

            if (this.isSearchBySource == true) {
                postData = {
                    centerId: ls.get("loggedUserCenterId"),
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDBStudent
                            : e.itemsPerPage,
                    filterBy: this.selectedSource
                };
            } else {
                postData = {
                    centerId: ls.get("loggedUserCenterId"),
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDBStudent
                            : e.itemsPerPage,
                    filterBy: this.studentSearchCriteria
                };
            }

            this.$http
                .get(`web_get_all_students_all?page=${e.page}`, {
                    params: postData,
                    headers: { Authorization: "Bearer " + ls.get("token") }
                })
                .then(({ data }) => {
                    this.tableDataLoadingStudent = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.tableItemsStudent = data.data;
                        this.totalItemsInDBStudent = data.total;
                    }
                })
                .catch(error => {
                    this.tableDataLoadingStudent = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },

        // Source Status Color
        getStudenttatusColor(is_source_acive) {
            if (is_source_acive == "Active") return "success";
            if (is_source_acive == "Online") return "primary";
            if (is_source_acive == "Internal") return "success";
            if (is_source_acive == "Closed") return "warning";
            else return "error";
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

        SubscribeStudent(item) {
            console.log(item, this.subscriptionDataProps);
            let userDecision = confirm(
                "Are you sure you want to add subscription"
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_assign_subscription",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            loggedUserId: ls.get("loggedUserId"),

                            lms_student_id: item.lms_student_id,
                            lms_user_id: item.lms_user_id,
                            lms_registration_id: item.lms_registration_id,

                            lms_exam_card_id: this.subscriptionDataProps
                                .lms_exam_card_id,
                            lms_exam_card_payment_month_duration: this
                                .subscriptionDataProps
                                .lms_exam_card_payment_month_duration,
                            lms_exam_card_charge_per_month: this
                                .subscriptionDataProps
                                .lms_exam_card_charge_per_month
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
                                Global.showSuccessAlert(
                                    true,
                                    "success",
                                    "Student Subscribed Successfully",
                                    null
                                );
                                this.getAllAssignedSubscription(event);
                            }
                            // Course Disabled failed
                            else if (data.responseData == 2) {
                                Global.showErrorAlert(
                                    true,
                                    "error",
                                    this.$t("label_something_went_wrong"),
                                    null
                                );
                            }
                            // Course Disabled failed
                            else if (data.responseData == 3) {
                                Global.showErrorAlert(
                                    true,
                                    "error",
                                    "Student already having active subscription",
                                    null
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isLoaderActive = false;
                        Global.showErrorAlert(
                            true,
                            "error",
                            this.$t("label_something_went_wrong"),
                            null
                        );
                    });
            }
        },
        // Disable Course status
        disableSubscription(item, $event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_subscription")
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_student_subscription",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            lms_exam_card_user_wise_id:
                                item.lms_exam_card_user_wise_id,
                            lms_exam_card_applied_is_active:
                                item.card_active == "Active" ? 0 : 1,
                            loggedUserId: ls.get("loggedUserId")
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
                                    this.$t("label_subscription_status_changed")
                                );
                                this.getAllAssignedSubscription(event);
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
                    .catch(error => {
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

        // Get all Subject from DB
        getAllAssignedSubscription(e) {
            this.tableDataLoading = true;
            this.$http
                .get(`web_get_all_assigned_subscription?page=${e.page}`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        lms_course_id: this.subscriptionDataProps.lms_course_id,
                        lms_exam_card_id: this.subscriptionDataProps
                            .lms_exam_card_id,
                        perPage:
                            e.itemsPerPage == -1
                                ? this.totalItemsInDB
                                : e.itemsPerPage
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
                    { header: "Subscription", dataKey: "lms_exam_card_name" },
                    {
                        header: "Duration",
                        dataKey: "lms_exam_card_payment_month_duration"
                    },
                    { header: "Course Name", dataKey: "lms_course_name" },
                    {
                        header: "Status",
                        dataKey: "card_active"
                    }
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 }
            });
            pdfDoc.save(
                "Subscription" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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
</style>
