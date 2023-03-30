<template>
    <div id="app">
        <v-container
            fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
        >
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
                                    <strong>{{
                                        $t("label_information_source")
                                    }}</strong>
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    >Home <v-icon>mdi-forward</v-icon> Enquiry
                                    <v-icon>mdi-forward</v-icon>
                                    {{
                                        $t("label_information_source")
                                    }}</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-permission="'Add Information Source'"
                        :disabled="tableDataLoading"
                        class="ma-2"
                        color="primary"
                        @click="isAddCardVisible = !isAddCardVisible"
                    >
                        <v-icon class="mr-2" color="white"
                            >mdi-source-fork</v-icon
                        >
                        Add Source
                    </v-btn>
                </v-row>
            </v-sheet>
            <transition name="fade" mode="out-in">
                <v-card v-if="isAddCardVisible">
                    <v-app-bar dark color="primary">
                        <v-spacer></v-spacer>
                        <v-btn icon class="ma-2" small color="white">
                            <v-icon
                                color="white"
                                @click="isAddCardVisible = !isAddCardVisible"
                                >mdi-close-circle-outline</v-icon
                            >
                        </v-btn>
                    </v-app-bar>

                    <v-container>
                        <v-form
                            ref="saveInformationSourceForm"
                            v-model="isSaveInformationSourceFormValid"
                            lazy-validation
                        >
                            <v-row dense class="m-2">
                                <v-col cols="12" xs="12" sm="12" md="8">
                                    <v-text-field
                                        outlined
                                        v-model="informationSourceName"
                                        @keypress="isCharacters"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{
                                                $t(
                                                    "label_information_source_name"
                                                )
                                            }}
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
                                        v-permission="
                                            'Add Information Source' |
                                                'Edit Information Source'
                                        "
                                        class="ma-2 rounded"
                                        tile
                                        color="primary"
                                        :disabled="
                                            !isSaveInformationSourceFormValid ||
                                            isSaveInformationSourceFormDataProcessing
                                        "
                                        @click="saveInformationSource"
                                        >{{
                                            isSaveInformationSourceFormDataProcessing ==
                                            true
                                                ? $t("label_processing")
                                                : $t("label_save")
                                        }}</v-btn
                                    >
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-container>
                </v-card>
            </transition>
            <transition name="fade" mode="out-in">
                <v-data-table
                    dense
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    item-key="lms_information_source_id"
                    class="elevation-1"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="100"
                    @pagination="getAllInformationSource"
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
                    <template
                        v-slot:item.is_lms_information_source_active="{ item }"
                    >
                        <v-chip
                            x-small
                            :color="
                                getStatusColor(
                                    item.is_lms_information_source_active
                                )
                            "
                            dark
                            >{{ item.is_lms_information_source_active }}</v-chip
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
                            v-permission="'Edit Information Source'"
                            small
                            class="mr-2"
                            @click="editInformationSource(item)"
                            color="primary"
                            >mdi-pencil</v-icon
                        >

                        <v-icon
                            v-if="
                                item.is_lms_information_source_active ==
                                'Active'
                            "
                            v-permission="'Delete Information Source'"
                            small
                            color="error"
                            @click="disableInformationSource(item)"
                            >mdi-check-circle</v-icon
                        >
                        <v-icon
                            v-if="
                                item.is_lms_information_source_active ==
                                'Inactive'
                            "
                            v-permission="'Delete Information Source'"
                            small
                            color="success"
                            @click="disableInformationSource(item)"
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
            isLoaderActive: false,

            informationSourceName: "",

            isSaveInformationSourceFormValid: true,
            isSaveInformationSourceFormDataProcessing: false,

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
                    text: this.$t("label_information_source_name"),
                    value: "lms_information_source_name",
                    width: "55%",
                    sortable: false,
                },

                {
                    text: this.$t("label_status"),
                    value: "is_lms_information_source_active",
                    align: "end",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "20%",
                    align: "end",
                },
            ],
            tableItems: [],
            isSaveEditClicked: 1,
            editInformationSourceId: "",

            //Datatable End

            isAddCardVisible: false,

            // For Excel Download
            excelFields: {
                "Information Source": "lms_information_source_name",
                Status: "is_lms_information_source_active",
            },
            excelData: [],
            excelFileName:
                "InformationSourceListAsExcel" +
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

        // Edit Information Source

        editInformationSource(item) {
            this.isAddCardVisible = true;
            this.editInformationSourceId = item.lms_information_source_id;
            this.isSaveEditClicked = 0;
            this.informationSourceName = item.lms_information_source_name;
        },

        // Disable Information Source
        async disableInformationSource(item, $event) {
            // let userDecision = confirm(
            //     this.$t("label_are_you_sure_change_status_infomation_source")
            // );

            const result = await Global.showConfirmationAlert(
                "Are you sure, you want to change Infomation Source status?",
                "You can make active anytime!",
                "warning"
            );
            if (result.isConfirmed) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_information_source",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            informationSourceId: item.lms_information_source_id,
                            isInformationSourceActive:
                                item.is_lms_information_source_active ==
                                "Active"
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
                            // Information Source Disabled
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t(
                                        "label_information_source_status_changed"
                                    )
                                );
                                this.getAllInformationSource(event);
                            }
                            // Information Source Disabled failed
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

        // To ensure Information Source name is character and space only
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
        // Save Information Source To DB after validation
        saveInformationSource($event) {
            if (this.$refs.saveInformationSourceForm.validate()) {
                this.isSaveInformationSourceFormDataProcessing = true;
                let postData = new FormData();
                if (this.isSaveEditClicked == 1) {
                    postData.append(
                        "informationSourceName",
                        this.informationSourceName
                    );
                    postData.append("isSaveEditClicked", 1);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                } else {
                    postData.append(
                        "informationSourceName",
                        this.informationSourceName
                    );
                    postData.append("isSaveEditClicked", 0);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                    postData.append(
                        "informationSourceId",
                        this.editInformationSourceId
                    );
                }
                this.$http
                    .post(
                        "web_save_update_information_source",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isSaveInformationSourceFormDataProcessing = false;
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
                            // Information Source  Name Exists
                            else if (data.responseData == 1) {
                                this.snackBarColor = "info";
                                this.changeSnackBarMessage(
                                    this.$t(
                                        "label_information_source_name_exists"
                                    )
                                );
                            }
                            // Information Source Saved
                            else if (data.responseData == 2) {
                                this.informationSourceName = "";
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_information_source_saved")
                                );
                                this.getAllInformationSource(event);
                                this.isSaveEditClicked = 1;
                            }
                            // Failed to save Information Source
                            else if (data.responseData == 3) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }

                            // Information Source Updated
                            else if (data.responseData == 4) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_information_source_updated")
                                );
                                this.getAllInformationSource(event);
                                this.isSaveEditClicked = 1;
                                this.informationSourceName = "";
                            }
                            // Information Source update failed
                            else if (data.responseData == 5) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch((error) => {
                        this.isSaveInformationSourceFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Information source from DB
        getAllInformationSource(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_information_source?page=${e.page}`, {
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
        getStatusColor(is_information_source_active) {
            if (is_information_source_active == "Active") return "success";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    {
                        header: "Information Source Name",
                        dataKey: "lms_information_source_name",
                    },
                    {
                        header: "Status",
                        dataKey: "is_lms_information_source_active",
                    },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "InformationSourceListAsPDF" +
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
