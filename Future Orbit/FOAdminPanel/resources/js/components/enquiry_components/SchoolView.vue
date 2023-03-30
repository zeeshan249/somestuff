<template>
    <div id="app">
        <v-container
            fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
        >
            <!-- Card Start -->
            <v-overlay :value="isLoaderActive" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
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
                                    <strong>School Directory</strong>
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    >Home <v-icon>mdi-forward</v-icon> Enquiry
                                    <v-icon>mdi-forward</v-icon>
                                    School</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-permission="'Add School'"
                        :disabled="tableDataLoading"
                        class="ma-2"
                        color="primary"
                        @click="dialogAddSchool = !dialogAddSchool"
                    >
                        <v-icon class="mr-2" color="white">mdi-school</v-icon>
                        Add School
                    </v-btn>
                </v-row>
            </v-sheet>
            <transition name="fade" mode="out-in">
                <v-data-table
                    dense
                    max-width="100%"
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    item-key="lms_school_id"
                    class="elevation-1 width-100"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="100"
                    @pagination="getAllSchool"
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
                    <template v-slot:item.is_lms_school_active="{ item }">
                        <v-chip
                            x-small
                            :color="getStatusColor(item.is_lms_school_active)"
                            dark
                            >{{ item.is_lms_school_active }}</v-chip
                        >
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
                        <v-icon
                            v-permission="'Edit School'"
                            small
                            class="mr-2"
                            @click="editSchool(item)"
                            color="primary"
                            >mdi-pencil</v-icon
                        >

                        <v-icon
                            v-if="item.is_lms_school_active == 'Active'"
                            v-permission="'Delete School'"
                            small
                            color="error"
                            @click="disableSchool(item)"
                            >mdi-check-circle</v-icon
                        >
                        <v-icon
                            v-if="item.is_lms_school_active == 'Inactive'"
                            v-permission="'Delete School'"
                            small
                            color="success"
                            @click="disableSchool(item)"
                            >mdi-check-circle</v-icon
                        >
                    </template>
                </v-data-table>
            </transition>

            <!-- Card End -->
        </v-container>
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

        <v-dialog v-model="dialogAddSchool" width="500">
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    Add School
                </v-card-title>
                <v-card-text>
                    <v-form
                        ref="saveSchoolForm"
                        v-model="isSaveSchoolFormValid"
                        lazy-validation
                    >
                        <v-row dense class="pt-4 pl-4">
                            <v-col cols="12" xs="12" sm="12" md="8">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="schoolName"
                                    @keypress="isCharacters"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        School Name
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" xs="12" sm="12" md="4">
                                <v-btn
                                    v-permission="'Add School' | 'Edit School'"
                                    class="rounded"
                                    tile
                                    color="primary"
                                    :disabled="
                                        !isSaveSchoolFormValid ||
                                        isSaveSchoolFormDataProcessing
                                    "
                                    @click="saveSchool"
                                    >{{
                                        isSaveSchoolFormDataProcessing == true
                                            ? $t("label_processing")
                                            : $t("label_save")
                                    }}</v-btn
                                >
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        text
                        @click="dialogAddSchool = false"
                    >
                        Cancel
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
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
            // For Breadcrumb

            isLoaderActive: false,

            schoolName: "",

            isSaveSchoolFormValid: true,
            isSaveSchoolFormDataProcessing: false,

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
                { text: "#", value: "index", width: "10%", sortable: false },
                {
                    text: "Name",
                    value: "lms_school_name",
                    width: "40%",
                    sortable: false,
                },

                {
                    text: this.$t("label_status"),
                    value: "is_lms_school_active",
                    align: "middle",
                    width: "25%",
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
            isSaveEditClicked: 1,
            editSchoolId: "",

            //Datatable End

            dialogAddSchool: false,

            // For Excel Download
            excelFields: {
                "School Source": "lms_school_name",
                Status: "is_lms_school_active",
            },
            excelData: [],
            excelFileName:
                "SchoolListAsExcel" +
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
    },

    methods: {
        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },

        // Edit School Source

        editSchool(item) {
            this.dialogAddSchool = true;
            this.editSchoolId = item.lms_school_id;
            this.isSaveEditClicked = 0;
            this.schoolName = item.lms_school_name;
        },
        // Disable School Source
        async disableSchool(item, $event) {
            const result = await Global.showConfirmationAlert(
                "Are you sure, you want to change School status?",
                "You can make active anytime!",
                "warning"
            );
            if (result.isConfirmed) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_school",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            SchoolId: item.lms_school_id,
                            isSchoolActive:
                                item.is_lms_school_active == "Active" ? 0 : 1,
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
                            // School Source Disabled
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    "School Status Changed"
                                );
                                this.dialogAddSchool = false;
                                this.getAllSchool(event);
                            }
                            // School Source Disabled failed
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
        // To ensure School Source name is character and space only
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
        // Save School Source To DB after validation
        saveSchool($event) {
            if (this.$refs.saveSchoolForm.validate()) {
                this.isSaveSchoolFormDataProcessing = true;
                let postData = new FormData();
                if (this.isSaveEditClicked == 1) {
                    postData.append("SchoolName", this.schoolName);
                    postData.append("isSaveEditClicked", 1);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                } else {
                    postData.append("SchoolName", this.schoolName);
                    postData.append("isSaveEditClicked", 0);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                    postData.append("editSchoolId", this.editSchoolId);
                }
                this.$http
                    .post(
                        "web_save_update_school",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isSaveSchoolFormDataProcessing = false;
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
                            // School Source  Name Exists
                            else if (data.responseData == 1) {
                                this.snackBarColor = "info";
                                this.changeSnackBarMessage(
                                    "School Name Already Exists"
                                );
                            }
                            // School Source Saved
                            else if (data.responseData == 2) {
                                this.schoolName = "";
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage("School Saved");
                                this.dialogAddSchool = false;
                                this.getAllSchool(event);
                                this.isSaveEditClicked = 1;
                            }
                            // Failed to save School Source
                            else if (data.responseData == 3) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }

                            // School Source Updated
                            else if (data.responseData == 4) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    "School Name Updated"
                                );
                                this.dialogAddSchool = false;
                                this.getAllSchool(event);
                                this.isSaveEditClicked = 1;
                                this.schoolName = "";
                            }
                            // School Source update failed
                            else if (data.responseData == 5) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch((error) => {
                        this.isSaveSchoolFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all School source from DB
        getAllSchool(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_school?page=${e.page}`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        perPage: e.itemsPerPage,
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
        //  Status Color
        getStatusColor(is_lms_school_active) {
            if (is_lms_school_active == "Active") return "success";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    {
                        header: "School Source Name",
                        dataKey: "lms_school_name",
                    },
                    { header: "Status", dataKey: "is_lms_school_active" },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "SchoolListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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
