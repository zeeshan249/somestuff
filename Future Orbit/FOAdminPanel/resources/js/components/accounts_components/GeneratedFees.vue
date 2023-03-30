<template>
    <div id="app">
        <v-container
            fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
        >
            <v-overlay :value="isDialogLoaderActive" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
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
                <v-row
                    justify="space-around"
                    style="
                        margin-right: 1px !important;
                        margin-left: -1px !important;
                    "
                    class="mb-4 mt-1"
                    dense
                >
                    <v-toolbar-title dark color="primary">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">
                                    <strong>Fee Collection</strong>
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    >{{ $t("label_home")
                                    }}<v-icon>mdi-forward</v-icon>
                                    Accounts
                                    <v-icon>mdi-forward</v-icon>
                                    Fee Collection</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-permission:all="'Add Enquiry'"
                        :disabled="tableDataLoading"
                        color="primary"
                        class="white--text"
                        @click="addEnquiry"
                    >
                        Generate New Fees
                        <v-icon right dark> mdi-plus </v-icon>
                    </v-btn>
                </v-row>
            </v-sheet>
            <transition name="fade" mode="out-in">
                <v-data-table
                    dense
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    item-key="lms_enquiry_id"
                    class="elevation-0"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="25"
                    @pagination="getAllEnquiry"
                    :footer-props="{
                        itemsPerPageOptions: [25, 50, 100, 200, -1],
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
                    <template v-slot:item.lms_student_is_active="{ item }">
                        <v-chip
                            x-small
                            :color="getStatusColor(item.lms_student_is_active)"
                            dark
                            >{{ item.lms_student_is_active }}</v-chip
                        >
                    </template>
                    <template v-slot:top>
                        <v-toolbar flat class="mt-4">
                            <v-text-field
                                class="mx-2 mt-6"
                                outlined
                                dense
                                v-model="staffSearchCriteria"
                                :label="lblSearchStaffCriteria"
                            ></v-text-field>
                            <v-btn
                                class="mx-2"
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
                        <v-tooltip>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="viewEnquiry(item)"
                                    color="info"
                                    >mdi-cash</v-icon
                                >
                            </template>
                            <span>Generated New Fees</span>
                        </v-tooltip>

                        <v-tooltip>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    @click="showAddEditDialog(item)"
                                    color="info"
                                    >mdi-ticket-percent</v-icon
                                >
                            </template>
                            <span>Assign New Voucher</span>
                        </v-tooltip>
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

            <v-dialog
                transition="dialog-top-transition"
                v-model="addEditDialog"
                max-width="400"
                scrollable
                :fullscreen="$vuetify.breakpoint.smAndDown"
                persistent
            >
                <template v-slot:default="dialog">
                    <v-overlay :value="isDialogLoaderActive" color="primary">
                        <v-progress-circular
                            indeterminate
                            size="50"
                            color="primary"
                        ></v-progress-circular>
                    </v-overlay>
                    <v-card>
                        <v-toolbar
                            color="primary"
                            dark
                            :max-height="
                                $vuetify.breakpoint.smAndDown ? 56 : '20vh'
                            "
                        >
                            <v-toolbar-title class="popup-header">{{
                                addEditText
                            }}</v-toolbar-title>
                            <v-spacer></v-spacer><v-spacer></v-spacer>
                            <v-btn icon dark @click="addEditDialog = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text class="py-4 px-2">
                            <v-form
                                ref="holdingFormBasic"
                                v-model="isFormAddEditValid"
                                lazy-validation
                            >
                                <v-row class="mx-auto d-flex" dense>
                                    <v-col cols="12" md="12" class="pt-5">
                                        <strong> Student Name: </strong>
                                        <strong>
                                            {{
                                                item.lms_student_full_name
                                            }}</strong
                                        >
                                    </v-col>

                                    <v-col cols="12" md="12" class="pt-5">
                                        <strong> Student Code: </strong>
                                        <strong>
                                            {{ item.lms_student_code }}</strong
                                        >
                                    </v-col>
                                </v-row>
                                <v-row class="mx-auto d-flex" dense>
                                    <v-col cols="12" md="12" class="mt-5">
                                        <v-select
                                            v-model="item.voucher_id"
                                            :items="voucherItems"
                                            label="Select Voucher"
                                            item-text="voucher_description"
                                            item-value="voucher_id"
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                            ]"
                                            dense
                                            @change="changeVoucherType(item)"
                                        >
                                            <template #label>
                                                Select Voucher
                                                <span class="red--text">
                                                    <strong>*</strong>
                                                </span>
                                            </template></v-select
                                        >
                                    </v-col>
                                </v-row>
                                <v-row class="mx-auto d-flex" dense>
                                    <v-col cols="12" md="12" class="pt-5">
                                        <v-text-field
                                            v-model="voucherAmount"
                                            dense
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                            ]"
                                            readonly
                                        >
                                            <template #label>
                                                Amount
                                                <span class="red--text">
                                                    <strong>*</strong>
                                                </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row class="mx-auto d-flex" dense>
                                    <v-col cols="12" md="12" class="pt-5">
                                        <v-text-field
                                            v-model="validityDays"
                                            dense
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                            ]"
                                            readonly
                                        >
                                            <template #label>
                                                Validity Days
                                                <span class="red--text">
                                                    <strong>*</strong>
                                                </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row class="mx-auto d-flex" dense>
                                    <v-col cols="12" md="12" class="pt-5">
                                        <v-text-field
                                            v-model="item.totalVouchers"
                                            dense
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                            ]"
                                            numeric
                                        >
                                            <template #label>
                                                No of Vouchers to Be Given
                                                <span class="red--text">
                                                    <strong>*</strong>
                                                </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions class="justify-end pt-4 pb-6">
                            <v-btn
                                class="mx-2 secondary-button"
                                @click="close()"
                                >Close</v-btn
                            >
                            <v-btn
                                class="mx-2 primary-button"
                                @click="saveBasicInfo(item)"
                                :disabled="!isFormAddEditValid"
                            >
                                Assign Voucher
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-dialog>
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
            lblSearchStaffCriteria: "Search",
            isSourceDataLoading: false,
            sourceData: [],
            voucherItems: [],
            isSearchBySource: false,
            authorizationConfig: "",
            isDialogLoaderActive: false,
            // Snack Bar
            voucherAmount: "",
            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",
            isFormAddEditValid: false,
            //   Datatable Start
            validityDays: "",
            tableDataLoading: false,
            totalItemsInDB: 0,
            tableLoadingDataText: this.$t("label_loading_data"),

            tableHeader: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: "Registration Code",
                    value: "lms_registration_code",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Student Code",
                    value: "lms_student_code",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Full Name",
                    value: "lms_student_full_name",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Mobile No",
                    value: "lms_student_mobile_number",
                    width: "10%",
                    sortable: false,
                },

                {
                    text: "Course Enrolled",
                    value: "lms_child_course_name",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Status",
                    value: "lms_student_is_active",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "20%",
                    align: "middle",
                },
            ],
            tableItems: [],
            isDataProcessing: false,
            addEditText: "Add",
            addEditDialog: false,
            addUpdateButtonText: "Update",
            //Datatable End

            // For Excel Download
            excelFields: {
                RegistrationCode: "lms_registration_code",
                StudentCode: "lms_student_code",
                FullName: "lms_student_full_name",
                Mobile: "lms_student_mobile_number",
                CourseEnrolled: "lms_child_course_name",
            },

            excelData: [],
            excelFileName:
                "FeeListAsExcel" + "_" + moment().format("DD/MM/YYYY") + ".xls",
        };
    },
    watch: {
        addEditDialog(value) {
            return value ? true : this.close();
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

        // Get all active sources
        this.getAllActiveSources();
        this.getAllActiveVoucher();
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
                name: "PayGeneratedFees",
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
                name: "AddFeeGenerator",
            });
        },

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
                .get(
                    `web_discount_get_all_student_fee_generated?page=${e.page}`,
                    {
                        params: postData,
                        headers: { Authorization: "Bearer " + ls.get("token") },
                    }
                )
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
        getStatusColor(lms_student_is_active) {
            if (lms_student_is_active == "Active") return "success";
            if (lms_student_is_active == "Mobile-R") return "primary";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    {
                        header: "Registration Code",
                        dataKey: "lms_registration_code",
                    },
                    { header: "Student Code", dataKey: "lms_student_code" },
                    { header: "Full Name", dataKey: "lms_student_full_name" },
                    { header: "Mobile", dataKey: "lms_student_mobile_number" },
                    {
                        header: "Course Enrolled",
                        dataKey: "lms_child_course_name",
                    },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "FeeListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
            );
        },

        showAddEditDialog(item) {
            this.item = Object.assign({}, item);
            this.addEditText = `Assign Voucher `;
            this.addEditDialog = true;
            this.addUpdateButtonText = "Update";
            console.log("Dialog Items", this.item);
        },

        getAllActiveVoucher() {
            this.isSchoolDataLoading = true;
            this.$http
                .get(`web_voucher_details_get_without_pagination`, {
                    params: {},
                    headers: { Authorization: "Bearer " + ls.get("token") },
                })
                .then(({ data }) => {
                    console.log(data.data);
                    this.isSchoolDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.voucherItems = data.data;
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
        changeVoucherType(item) {
            this.isDialogLoaderActive = true;
            this.$http
                .get(`web_voucher_details_get_without_pagination`, {
                    params: {
                        voucherId: item.voucher_id,
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
                })
                .then(({ data }) => {
                    this.isDialogLoaderActive = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.voucherAmount = data.data[0].voucher_amount;
                        this.validityDays = data.data[0].validity_days;
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
        saveBasicInfo(item) {
            console.log("To Be Saved", item);
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
                basicFormData.append("studentId", item.lms_student_id);
                basicFormData.append("voucherId", item.voucher_id);
                basicFormData.append("voucherAmount", this.voucherAmount);
                basicFormData.append("totalVouchers", item.totalVouchers);

                basicFormData.append("validityDays", this.validityDays);
                basicFormData.append(
                    "studentRegistrationCode",
                    item.lms_student_code
                );
                basicFormData.append("userId", item.lms_user_id);

                this.isDialogLoaderActive = true;
                this.$http
                    .post(
                        "web_voucher_generate_for_student",
                        basicFormData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isDialogLoaderActive = false;
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
                                    "Voucher already assigned for this student"
                                );
                                this.close();
                            }

                            // Enquiry Saved
                            else if (data.responseData == 4) {
                                // this.isEnquiryBasicEdit = 1;
                                // this.lms_discount_id = data.lms_discount_id;

                                // setTimeout(() => {
                                //     this.$router.push({
                                //         name: "Discounts",
                                //     });
                                // }, 2000);

                                Global.showSuccessAlert(
                                    true,
                                    "success",
                                    `Voucher Assigned Successfully For Student with Registration Id :${item.lms_registration_code}`
                                );
                                this.close();
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
                                    "Discount Details Updated"
                                );

                                setTimeout(() => {
                                    this.$router.push({
                                        name: "Discounts",
                                    });
                                }, 2000);
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
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        close() {
            this.addEditDialog = false;
            setTimeout(() => {
                this.item = Object.assign({}, this.defaultItem);
            }, 300);
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
