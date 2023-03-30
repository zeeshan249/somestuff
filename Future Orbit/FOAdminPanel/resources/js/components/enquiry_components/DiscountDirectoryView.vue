<template>
    <div  id="app">
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
            <v-row  justify="space-around"
           style="margin-right: 1px !important; margin-left: -1px !important"
           class="mb-4 mt-1"
           dense>
                <v-toolbar-title dark color="primary">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                <strong>Discounts</strong>
                            </v-list-item-title>
                            <v-list-item-subtitle
                                >{{ $t("label_home")
                                }}<v-icon>mdi-forward</v-icon>
                                Accounts
                                <v-icon>mdi-forward</v-icon>
                                Discounts
                            </v-list-item-subtitle>
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
                    @click="addDiscount"
                >
                    Add Discounts
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
                    @pagination="getAllDiscount"
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
                    <template v-slot:item.status="{ item }">
                        <v-chip
                            x-small
                            :color="getStatusColor(item.status)"
                            dark
                            >{{ item.status }}</v-chip
                        >
                    </template>
                    <template v-slot:top>
                        <v-toolbar flat class="mt-1">
                            <v-select
                                class="mx-2"
                                v-model="selectedSource"
                                :disabled="isSourceDataLoading"
                                :items="sourceData"
                                dense
                                outlined
                                :label="lblSelectSource"
                                item-text="discount_type"
                                item-value="discount_type"
                                @change="
                                    isSearchBySource = true;
                                    getAllDiscount($event);
                                "
                            ></v-select>

                            <v-text-field
                                class="mx-2"
                                outlined
                                dense
                                v-model="staffSearchCriteria"
                                :label="lblSearchStaffCriteria"
                            ></v-text-field>
                            <v-btn
                                class="mx-2 mb-2"
                                dense
                                rounded
                                color="primary"
                                @click="
                                    isSearchBySource = false;
                                    getAllDiscount($event);
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
                                    v-bind="attrs"
                                    v-on="on"
                                    small
                                    @click="editDiscount(item)"
                                    color="primary"
                                    >mdi-pencil</v-icon
                                >
                            </template>
                            <span>Edit Enquiry</span>
                        </v-tooltip>

                        <v-tooltip>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    v-bind="attrs"
                                    v-on="on"
                                    small
                                    color="error"
                                    @click="enableDisableEnquiry(item)"
                                    >mdi-delete</v-icon
                                >
                            </template>
                            <span>Delete Discounts</span>
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
            lblSelectSource: "Search by Discount Type",
            selectedSource: "",
            isDataProcessing: false,
            staffSearchCriteria: "",
            lblSearchStaffCriteria: "Search by Discount Description | Price",
            isSourceDataLoading: false,
            sourceData: ["Percentage", "Amount"],
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
                    text: "Description",
                    value: "description",
                    width: "20%",
                    sortable: false,
                },
                {
                    text: "Amount",
                    value: "amount",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Valid From",
                    value: "valid_from",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Valid To",
                    value: "valid_to",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Discount Details",
                    value: "discount_details",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Discount Type",
                    value: "discount_type",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Status",
                    value: "status",
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

            //Datatable End

            // For Excel Download
            excelFields: {
                description: "description",
                amount: "amount",
                valid_from: "valid_from",
                valid_to: "valid_to",
                discount_details: "discount_details",
                discount_type: "discount_type",
                status: "status",
            },
            excelData: [],
            excelFileName:
                "Discounts" + "_" + moment().format("DD/MM/YYYY") + ".xls",
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
    },

    methods: {
        // Get all active sources

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

        addDiscount() {
            this.$router.push({
                name: "AddDiscount",
            });
        },
        // Edit Staff

        editDiscount(item) {
            console.log(item);
            this.$router.push({
                name: "AddDiscount",
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
                                this.getAllDiscount(event);
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
        getAllDiscount(e) {
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
                .get(`web_get_all_discounts?page=${e.page}`, {
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
                    { header: "description", dataKey: "description" },
                    { header: "amount", dataKey: "amount" },
                    { header: "valid_from", dataKey: "valid_from" },
                    { header: "valid_to", dataKey: "valid_to" },
                    { header: "discount_details", dataKey: "discount_details" },
                    { header: "discount_type", dataKey: "discount_type" },
                    { header: "status", dataKey: "status" },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "Discounts" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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
