<template>
    <div id="app">
        <v-container
            fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
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
                                    <strong>{{
                                        $t("label_enquiry_directory")
                                    }}</strong>
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    >{{ $t("label_home")
                                    }}<v-icon>mdi-forward</v-icon>
                                    {{ $t("label_enquiry") }}
                                    <v-icon>mdi-forward</v-icon>
                                    {{
                                        $t("label_enquiry_directory")
                                    }}</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-permission:all="'Add Enquiry'"
                        v-if="!isAddCardVisible"
                        :disabled="tableDataLoading"
                        color="primary"
                        class="white--text"
                        @click="addEnquiry"
                    >
                        {{ $t("label_add_enquiry") }}
                        <v-icon right dark> mdi-plus </v-icon>
                    </v-btn>
                </v-row>
            </v-sheet>
            <transition name="fade" mode="out-in">
                <v-data-table
                    max-width="100%"
                    dense
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    item-key="lms_enquiry_id"
                    class="elevation-0"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="100"
                    @pagination="getAllEnquiry"
                    :footer-props="{
                        itemsPerPageOptions: [100, 200, 300, -1],
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
                    <template v-slot:item.lms_enquiry_status="{ item }">
                        <v-chip
                            x-small
                            :color="getStatusColor(item.lms_enquiry_status)"
                            dark
                            >{{ item.lms_enquiry_status }}</v-chip
                        >
                    </template>

                    <template v-slot:top>
                        <v-toolbar flat class="pt-4">
                            <v-select
                                class="mx-2"
                                v-model="selectedSource"
                                :disabled="isSourceDataLoading"
                                :items="sourceData"
                                dense
                                :label="lblSelectSource"
                                item-text="lms_information_source_name"
                                item-value="lms_information_source_name"
                                @change="
                                    isSearchBySource = true;
                                    getAllEnquiry($event);
                                "
                            ></v-select>

                            <v-text-field
                                class="mx-2"
                                dense
                                v-model="staffSearchCriteria"
                                :label="lblSearchStaffCriteria"
                            ></v-text-field>
                            <v-btn
                                class="mx-2 mb-6"
                                dense
                                rounded
                                color="primary"
                                @click="
                                    isSearchBySource = false;
                                    getAllEnquiry($event);
                                "
                                :disabled="tableDataLoading"
                                >{{ $t("label_search") }}</v-btn
                            >
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
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    v-bind="attrs"
                                    v-on="on"
                                    v-if="item.lms_enquiry_status == 'Active'"
                                    v-permission="'Add Enquiry|Edit Enquiry'"
                                    small
                                    class="mr-2"
                                    @click="registerUser(item)"
                                    color="teal"
                                    >mdi-account-plus</v-icon
                                >
                            </template>
                            <span>Register User</span>
                        </v-tooltip>
                        <v-icon
                            v-if="item.lms_enquiry_status != 'Active'"
                            v-permission="'Add Enquiry|Edit Enquiry'"
                            small
                            class="mr-2"
                            color="white"
                            >mdi-checkbox-blank-circle-outline</v-icon
                        >
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    v-bind="attrs"
                                    v-on="on"
                                    v-permission="'Edit Enquiry'"
                                    small
                                    class="mr-2"
                                    @click="editEnquiry(item)"
                                    color="primary"
                                    >mdi-pencil</v-icon
                                >
                            </template>
                            <span>Edit Enquiry</span>
                        </v-tooltip>

                        <v-icon
                            v-permission="'Add Enquiry'"
                            small
                            class="mr-2"
                            @click="viewEnquiry(item)"
                            color="info"
                            >mdi-eye</v-icon
                        >
                        <v-icon
                            v-if="item.lms_enquiry_status == 'Active'"
                            v-permission="'Delete Enquiry'"
                            small
                            color="error"
                            @click="enableDisableEnquiry(item)"
                            >mdi-delete</v-icon
                        >
                        <v-icon
                            v-if="item.lms_enquiry_status == 'Inactive'"
                            v-permission="'Delete Enquiry'"
                            small
                            color="success"
                            @click="enableDisableEnquiry(item)"
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
    props: ["userPermissionDataProps"],

    data() {
        return {
            // Form Data
            lblSelectSource: this.$t("label_select_source"),
            selectedSource: "",
            isDataProcessing: false,
            staffSearchCriteria: "",
            lblSearchStaffCriteria: this.$t("label_search_enquiry_criteria"),
            isSourceDataLoading: false,
            sourceData: [],
            isSearchBySource: false,
            authorizationConfig: "",
            isAddCardVisible: "",

            // Snack Bar

            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",

            //   Datatable Start

            tableDataLoading: false,
            totalItemsInDB: 0,
            tableLoadingDataText: this.$t("label_loading_data"),

            tableHeader: [
                {
                    text: "#",
                    value: "index",
                    width: "5%",
                    sortable: false,
                    align: "start",
                },
                {
                    text: this.$t("label_code"),
                    value: "lms_enquiry_code",
                    width: "7%",
                    sortable: false,
                },
                {
                    text: this.$t("label_date"),
                    value: "lms_enquiry_created_at",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: this.$t("label_name"),
                    value: "lms_enquiry_full_name",
                    width: "20%",
                    sortable: false,
                },
                {
                    text: "Class",
                    value: "lms_enquiry_class",
                    width: "5%",
                    sortable: false,
                },

                {
                    text: "Course/Class",
                    value: "lms_child_course_name",
                    width: "5%",
                    sortable: false,
                },
                {
                    text: this.$t("label_source"),
                    value: "source_name",
                    width: "5%",
                    sortable: false,
                },
                {
                    text: this.$t("label_mobile"),
                    value: "lms_enquiry_mobile",
                    width: "8%",
                    sortable: false,
                },

                {
                    text: this.$t("label_status"),
                    value: "lms_enquiry_status",
                    align: "middle",
                    width: "5%",
                    sortable: false,
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "25%",
                    align: "end",
                },
            ],
            tableItems: [],
            isDataProcessing: false,

            //Datatable End

            // For Excel Download
            excelFields: {
                Code: "lms_enquiry_code",
                Date: "lms_enquiry_created_at",
                Name: "lms_enquiry_full_name",
                Class: "lms_enquiry_class",
                Section: "lms_enquiry_section",
                RollNo: "lms_roll_no",
                Course: "lms_child_course_name",
                Source: "source_name",
                Mobile: "lms_enquiry_mobile",
                Status: "lms_enquiry_status",
            },
            excelData: [],
            excelFileName:
                "EnquiryListAsExcel" +
                "_" +
                moment().format("DD/MM/YYYY") +
                ".xls",
        };
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

        // Get all active sources
        this.getAllActiveSources();
    },

    methods: {
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
        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },
        // View Staff
        viewEnquiry(item) {
            this.$router.push({
                name: "AddEnquiry",
                params: { enquiryDataProps: item },
            });
        },
        // Edit Staff

        editEnquiry(item) {
            console.log(item);
            this.$router.push({
                name: "AddEnquiry",
                params: { enquiryDataProps: item },
            });
        },

        registerUser(item) {
            console.log(item);
            this.$router.push({
                name: "AddRegister",
                params: { enquiryDataProps: item },
            });
        },
        // Add Staff
        addEnquiry() {
            this.$router.push({
                name: "AddEnquiry",
            });
        },

        // Enable  Disable Staff Status
        // registerUser(item, $event) {
        //     let userDecision = confirm(this.$t("label_student_admission"));
        //     if (userDecision) {
        //         this.isDataProcessing = true;
        //         this.$http
        //             .post(
        //                 "web_register_user",
        //                 {
        //                     centerId: ls.get("loggedUserCenterId"),
        //                     loggedUserId: ls.get("loggedUserId"),
        //                     courseId: item.lms_course_id,
        //                     childCourseId: item.lms_child_course_id,
        //                     firstName: item.lms_enquiry_first_name,
        //                     lastName: item.lms_enquiry_last_name,
        //                     mobileNumber: item.lms_enquiry_mobile,
        //                     enquiryEmail: item.lms_enquiry_email,
        //                     lms_enquiry_id: item.lms_enquiry_id,
        //                     password: "123456",
        //                 },
        //                 this.authorizationConfig
        //             )
        //             .then(({ data }) => {
        //                 console.log(data.responseData);
        //                 this.isDataProcessing = false;
        //                 //User Unauthorized
        //                 if (
        //                     data.error == "Unauthorized" ||
        //                     data.permissionError == "Unauthorized"
        //                 ) {
        //                     this.$store.dispatch("actionUnauthorizedLogout");
        //                 } else {
        //                     // Staff Status changed
        //                     if (data.responseData == 1) {
        //                         this.snackBarColor = "success";
        //                         this.changeSnackBarMessage(
        //                             this.$t("label_staff_status_changed")
        //                         );
        //                         this.getAllEnquiry(event);
        //                     } else if (data.responseData == 3) {
        //                         this.snackBarColor = "error";
        //                         this.changeSnackBarMessage(
        //                             this.$t("label_email_exists")
        //                         );
        //                         this.getAllEnquiry(event);
        //                     } else if (data.responseData == 4) {
        //                         this.snackBarColor = "error";
        //                         this.changeSnackBarMessage(
        //                             this.$t("label_mobile_exists")
        //                         );
        //                         this.getAllEnquiry(event);
        //                     } else if (data.responseData == 2) {
        //                         console.log("Error");
        //                         this.snackBarColor = "error";
        //                         this.changeSnackBarMessage(
        //                             this.$t("label_something_went_wrong")
        //                         );
        //                     }
        //                 }
        //             })
        //             .catch((error) => {
        //                 this.isDataProcessing = false;
        //                 this.snackBarColor = "error";
        //                 this.changeSnackBarMessage(
        //                     this.$t("label_something_went_wrong")
        //                 );
        //             });
        //     }
        // },

        // Enable  Disable Staff Status
        async enableDisableEnquiry(item, $event) {
            const result = await Global.showConfirmationAlert(
                `Are you sure you want to disable`,
                "You won't be able to revert this!",
                "warning"
            );
            if (result.isConfirmed) {
                this.isDataProcessing = true;
                this.$http
                    .post(
                        "web_enable_disable_enquiry",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            loggedUserId: ls.get("loggedUserId"),
                            lms_enquiry_id: item.lms_enquiry_id,
                            lms_enquiry_status:
                                item.lms_enquiry_status == "Active" ? 0 : 1,
                        },
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isDataProcessing = false;
                        //User Unauthorized
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            // Staff Status changed
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_status_enquiry")
                                );
                                this.getAllEnquiry(event);
                            }
                            // Staff Status changed failed
                            else if (data.responseData == 2) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch((error) => {
                        this.isDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Staff from DB
        getAllEnquiry(e) {
            this.tableDataLoading = true;
            let postData = "";

            if (this.isSearchBySource == true) {
                postData = {
                    centerId: ls.get("loggedUserCenterId"),
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDB
                            : e.itemsPerPage,
                    filterBy: this.selectedSource,
                };
            } else {
                postData = {
                    centerId: ls.get("loggedUserCenterId"),
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDB
                            : e.itemsPerPage,
                    filterBy: this.staffSearchCriteria,
                };
            }

            this.$http
                .get(`web_get_all_enquiry?page=${e.page}`, {
                    params: postData,
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
        // Source Status Color
        getStatusColor(is_source_acive) {
            if (is_source_acive == "Active") return "success";
            if (is_source_acive == "Mobile-R") return "primary";
            if (is_source_acive == "Internal-R") return "danger";
            if (is_source_acive == "Closed") return "warning";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    { header: "Code", dataKey: "lms_enquiry_code" },
                    { header: "Name", dataKey: "lms_enquiry_full_name" },
                    { header: "Class", dataKey: "lms_enquiry_class" },
                    { header: "Section", dataKey: "lms_enquiry_section" },
                    { header: "RollNo", dataKey: "lms_roll_no" },
                    { header: "Course", dataKey: "lms_child_course_name" },
                    { header: "Source", dataKey: "source_name" },
                    { header: "Mobile", dataKey: "lms_enquiry_mobile" },
                    { header: "Status", dataKey: "lms_enquiry_status" },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "EnquiryListAsPDF" +
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
