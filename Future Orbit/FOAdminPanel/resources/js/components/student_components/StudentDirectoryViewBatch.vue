<template>
    <!-- Card Start -->
    <v-container
        fluid
        style="max-width: 100% !important;"
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
        <transition name="fade" mode="out-in">
            <v-data-table
                dense
                :headers="tableHeader"
                :items="dataTableRowNumbering"
                class="elevation-0"
                :loading="tableDataLoading"
                :loading-text="tableLoadingDataText"
                :server-items-length="totalItemsInDB"
                :items-per-page="100"
                @pagination="getAllStudents"
                :footer-props="{
                    itemsPerPageOptions: [100, 200, 300, -1],
                }"
            >
                <template v-slot:no-data>
                    <p class="font-weight-black bold title" style="color: red">
                        {{ $t("label_no_data_found") }}
                    </p>
                </template>
                <template v-slot:item.lms_student_registration_type="{ item }">
                    <v-chip
                        x-small
                        :color="
                            getStatusColor(item.lms_student_registration_type)
                        "
                        dark
                        >{{ item.lms_student_registration_type }}</v-chip
                    >
                </template>

                <template v-slot:top>
                    <v-toolbar flat>
                        <v-select
                            v-if="false"
                            class="mt-4"
                            v-model="selectedSource"
                            :disabled="isSourceDataLoading"
                            :items="sourceData"
                            prepend-inner-icon="mdi-filter-outline"
                            dense
                            :label="lblSelectSource"
                            item-text="lms_information_source_name"
                            item-value="lms_information_source_name"
                            @change="
                                isSearchBySource = true;
                                getAllStudents($event);
                            "
                        ></v-select>
                        <v-text-field
                            prepend-inner-icon="mdi-magnify"
                            class="mt-4 mx-4"
                            :disabled="isSourceDataLoading"
                            v-model="studentSearchCriteria"
                            :label="lblSearchStudentCriteria"
                            @input="
                                isSearchBySource = false;
                                getAllStudents($event);
                            "
                        ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
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
                    </v-toolbar>
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-icon
                        v-permission="'Staff'"
                        small
                        class="mr-2"
                        @click="viewStudentDetails(item)"
                        color="info"
                        >mdi-eye</v-icon
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
            enquiryCode: "",
            studentViewEditDialog: false,
            // Form Data
            lblSelectSource: this.$t("label_select_source"),
            selectedSource: "",
            isDataProcessing: false,
            studentSearchCriteria: "",
            lblSearchStudentCriteria: this.$t("label_search_student_criteria"),
            isSourceDataLoading: false,
            sourceData: [],
            isSearchBySource: false,
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
                    text: this.$t("label_code"),
                    value: "lms_registration_code",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: this.$t("label_date"),
                    value: "lms_student_course_mapping_created_at",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: this.$t("label_name"),
                    value: "lms_student_full_name",
                    width: "25%",
                    sortable: false,
                },
                {
                    text: this.$t("label_course"),
                    value: "lms_child_course_name",
                    width: "20%",
                    sortable: false,
                },
                {
                    text: this.$t("label_mobile"),
                    value: "lms_student_mobile_number",
                    width: "10%",
                    sortable: false,
                },

                {
                    text: this.$t("label_batch_name"),
                    value: "lms_batch_code",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: this.$t("label_status"),
                    value: "lms_student_registration_type",
                    align: "end",
                    width: "5%",
                    sortable: false,
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "5%",
                    align: "end",
                    visible: "false",
                },
            ],
            tableItems: [],
            isDataProcessing: false,

            //Datatable End

            // For Excel Download
            excelFields: {
                Code: "lms_registration_code",
                Date: "lms_student_course_mapping_created_at",
                Name: "lms_student_full_name",
                Mobile: "lms_student_mobile_number",
                StudetId: "lms_student_code",
            },
            excelData: [],
            excelFileName:
                "StudentListAsExcel" +
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
        // View Student Details
        viewStudentDetails(item) {
            this.$router.push({
                name: "StudentDetails",
                params: { studentDetailsDataProps: item },
            });
        },
        // Get all Students from DB
        getAllStudents(e) {
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
                    filterBy: this.studentSearchCriteria,
                };
            }

            this.$http
                .get(`web_get_all_students_batch?page=${e.page}`, {
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
            if (is_source_acive == "Online") return "primary";
            if (is_source_acive == "Internal") return "success";
            if (is_source_acive == "Closed") return "warning";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    {
                        header: "Registration",
                        dataKey: "lms_registration_code",
                    },
                    { header: "Name", dataKey: "lms_student_full_name" },
                    {
                        header: "Date",
                        dataKey: "lms_student_course_mapping_created_at",
                    },
                    {
                        header: "Mobile Number",
                        dataKey: "lms_student_mobile_number",
                    },
                    { header: "Status", dataKey: "lms_student_is_active" },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "StudentListAsPDF" +
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
