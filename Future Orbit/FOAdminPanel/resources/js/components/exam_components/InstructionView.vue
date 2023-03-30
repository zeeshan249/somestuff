<template>
    <div id="app">
    <!-- Card Start -->
    <v-container 
            fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
       
    >
        <v-progress-linear
            :active="isDepartmentDataProcessing"
            :indeterminate="isDepartmentDataProcessing"
            height="10"
            absolute
            top
            color="primary"
            background-color="primary lighten-3"
            striped
        ></v-progress-linear>


        <v-sheet class="pa-4 mb-4" >
        <v-breadcrumbs :items="breadCrumbItem">
            <template v-slot:divider>
                <v-icon>mdi-forward</v-icon>
            </template>
        </v-breadcrumbs>
    </v-sheet>

        <v-row dense>
            <transition name="fade" mode="out-in">
                <v-col class="d-flex flex-column ml-2">
                    <!-- Card Start -->
                    <v-card>
                        <v-app-bar dark color="primary">
                            <v-toolbar-title color="success">{{
                                $t("label_instruction")
                            }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn
                                v-permission="'Exam Schedule'"
                                icon
                                class="ma-2"
                                outlined
                                small
                                color="white"
                                v-if="!isAddInstructionCardVisible"
                            >
                                <v-icon
                                    color="white"
                                    @click="
                                        isAddInstructionCardVisible = !isAddInstructionCardVisible
                                    "
                                    >mdi-plus</v-icon
                                >
                            </v-btn>
                        </v-app-bar>

                        <v-container
                        fluid
        style="background-color: #e4e8e4; max-width: 100% !important"
                        >
                            <v-card class="mx-auto" max-width="100%">
                                <v-data-table
                                    dense
                                    :headers="tableHeader"
                                    :items="dataTableRowNumbering"
                                    item-key="lms_exam_instruction_id"
                                    class="elevation-1"
                                    :loading="tableDataLoading"
                                    :loading-text="tableLoadingDataText"
                                    :server-items-length="totalItemsInDB"
                                    :items-per-page="15"
                                    @pagination="getAllInstruction"
                                    :footer-props="{
                                        itemsPerPageOptions: [5, 10, 15]
                                    }"
                                >
                                    <template v-slot:no-data>
                                        <p
                                            class="font-weight-black bold title"
                                            style="color:red"
                                        >
                                            {{ $t("label_no_data_found") }}
                                        </p>
                                    </template>
                                    <template
                                        v-slot:item.lms_exam_instruction_content="{
                                            item
                                        }"
                                    >
                                        <div
                                            v-html="
                                                item.lms_exam_instruction_content
                                            "
                                            style="align-content: center;"
                                        ></div>
                                    </template>
                                    <template
                                        v-slot:item.lms_exam_instruction_is_active="{
                                            item
                                        }"
                                    >
                                        <v-chip
                                            x-small
                                            :color="
                                                getDepartmentStatusColor(
                                                    item.lms_exam_instruction_is_active
                                                )
                                            "
                                            dark
                                            >{{
                                                item.lms_exam_instruction_is_active
                                            }}</v-chip
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
                                                    <v-icon dark
                                                        >mdi-file-excel</v-icon
                                                    >
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
                                                <v-icon dark
                                                    >mdi-file-pdf</v-icon
                                                >
                                            </v-btn>
                                        </v-toolbar>
                                    </template>

                                    <template v-slot:item.actions="{ item }">
                                        <v-icon
                                            v-permission="'Edit Exam Schedule'"
                                            small
                                            class="mr-2"
                                            @click="editInstruction(item)"
                                            color="primary"
                                            >mdi-pencil</v-icon
                                        >

                                        <v-icon
                                            v-if="
                                                item.lms_exam_instruction_is_active ==
                                                    'Active'
                                            "
                                            v-permission="'Edit Exam Schedule'"
                                            small
                                            color="error"
                                            @click="disableInstruction(item)"
                                            >mdi-delete</v-icon
                                        >
                                        <v-icon
                                            v-if="
                                                item.lms_exam_instruction_is_active ==
                                                    'Inactive'
                                            "
                                            v-permission="'Edit Exam Schedule'"
                                            small
                                            color="success"
                                            @click="disableInstruction(item)"
                                            >mdi-check-circle</v-icon
                                        >
                                    </template>
                                </v-data-table>
                            </v-card>
                        </v-container>
                    </v-card>
                    <!-- Card End -->
                </v-col>
            </transition>
            <transition name="fade" mode="out-in">
                <v-col
                    class="d-flex flex-column mr-2"
                    v-if="isAddInstructionCardVisible"
                >
                    <v-card>
                        <v-app-bar dark color="primary">
                            <v-toolbar-title color="success">{{
                                $t("label_instruction")
                            }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn
                                icon
                                class="ma-2"
                                outlined
                                small
                                color="white"
                            >
                                <v-icon
                                    color="white"
                                    @click="
                                        isAddInstructionCardVisible = !isAddInstructionCardVisible
                                    "
                                    >mdi-minus</v-icon
                                >
                            </v-btn>
                        </v-app-bar>

                        <v-container fluid>
                            <v-form
                                ref="saveInstructionForm"
                                v-model="isSaveInstructionFormValid"
                                lazy-validation
                            >
                                <v-row dense>
                                    <v-col cols="12" xs="12" sm="12" md="12">
                                        <v-text-field
                                            :label="instructionNameLabel"
                                            :hint="instructionNameHint"
                                            class="ml-4"
                                            v-model="instructionName"
                                            :rules="instructionRules"
                                            type="text"
                                            clearable
                                            @keypress="isCharacters"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>

                                <v-row dense>
                                    <v-col cols="12" xs="12" sm="12" md="12">
                                        <div id="app">
                                            <vue-editor
                                                v-model="instructionContentName"
                                                :editor-toolbar="customToolbar"
                                            ></vue-editor>
                                        </div>
                                    </v-col>
                                </v-row>
                                <v-row dense>
                                    <v-col cols="12" xs="12" sm="12" md="4">
                                        <v-btn
                                            width="150"
                                            v-permission="'Exam Schedule'"
                                            class="ma-2 rounded"
                                            tile
                                            color="primary"
                                            :disabled="
                                                !isSaveInstructionFormValid ||
                                                    isSaveInstructionFormDataProcessing
                                            "
                                            @click="saveInstruction"
                                            >{{
                                                isSaveInstructionFormDataProcessing ==
                                                true
                                                    ? $t("label_processing")
                                                    : $t("label_save")
                                            }}</v-btn
                                        >
                                    </v-col>
                                    <v-col cols="12" xs="12" sm="12" md="4">
                                        <v-btn
                                            width="150"
                                            v-permission="'Exam Schedule'"
                                            class="ma-2 rounded"
                                            tile
                                            color="primary"
                                            @click="
                                                isAddInstructionCardVisible = !isAddInstructionCardVisible
                                            "
                                            >Cancel</v-btn
                                        >
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-container>
                    </v-card>
                </v-col>
            </transition>
            <!-- Card End -->
        </v-row>

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

//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

import { VueEditor } from "vue2-editor";
import katex from "katex";
import "katex/dist/katex.min.css";

export default {
    components: {
        VueEditor
    },
    props: ["userPermissionDataProps"],

    data() {
        return {
            // For Breadcrumb
            breadCrumbItem: [
                {
                    text: this.$t("label_home"),
                    disabled: false
                },
                {
                    text: this.$t("label_exam"),
                    disabled: false
                },
                {
                    text: this.$t("label_instruction"),
                    disabled: false
                }
            ],

            // Form Labels
            instructionNameLabel: this.$t("label_instruction_name"),
            instructionNameHint: this.$t("label_instruction_name_hint"),

            instructionContectNameLabel: this.$t("label_instruction_content"),
            instructionContectNameHint: this.$t("label_instruction_content"),

            // Form Inputs and Validation Authorization
            isSaveInstructionFormValid: true,
            isSaveInstructionFormDataProcessing: false,
            instructionName: "",
            instructionContentName: "",
            instructionRules: [
                v => !!v || this.$t("label_instruction_title_required")
            ],
            instructionContentRules: [
                v => !!v || this.$t("label_instruction_content_required")
            ],
            authorizationConfig: "",
            //content:'',

            customToolbar: [
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                ["bold", "italic", "underline", "strike", { align: [] }],

                ["blockquote", "code-block"],

                [{ list: "ordered" }, { list: "bullet" }],
                [{ script: "sub" }, { script: "super" }],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ direction: "rtl" }],

                [{ color: [] }, { background: [] }],
                ["clean"],

                ["link", "formula", "image", "video"]
            ],

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
                    text: this.$t("label_instruction_name"),
                    value: "lms_exam_instruction_title",
                    width: "20%",
                    sortable: false
                },
                {
                    text: this.$t("label_instruction_content"),
                    value: "lms_exam_instruction_content",
                    width: "60%",
                    sortable: false
                },

                {
                    text: this.$t("label_status"),
                    value: "lms_exam_instruction_is_active",
                    align: "middle",
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
            isDepartmentDataProcessing: false,
            isSaveEditClicked: 1,
            editInstructionId: "",
            //Datatable End

            // For Exam Schedule card
            isAddInstructionCardVisible: false,

            // For Excel Download
            excelFields: {
                "Instruction Name": "lms_exam_instruction_title",
                "Instruction Contect": "lms_exam_instruction_content",
                Status: "lms_exam_instruction_is_active"
            },
            excelData: [],
            excelFileName:
                "InstructionListAsExcel" +
                "_" +
                moment().format("DD/MM/YYYY") +
                ".xls"
        };
    },
    mounted() {
        window.katex = katex;
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
    },

    methods: {
        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },

        // Edit Instruction Name

        editInstruction(item) {
            this.isAddInstructionCardVisible = true;
            this.editInstructionId = item.lms_exam_instruction_id;
            this.isSaveEditClicked = 0;
            this.instructionName = item.lms_exam_instruction_title;
            this.instructionContentName = item.lms_exam_instruction_content;
        },
        // Disable Instruction status
        disableInstruction(item, $event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_instruction")
            );
            if (userDecision) {
                this.isDepartmentDataProcessing = true;
                this.$http
                    .post(
                        "web_enable_disable_instruction",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            instructionId: item.lms_exam_instruction_id,
                            isInstructionActive:
                                item.lms_exam_instruction_is_active == "Active"
                                    ? 0
                                    : 1,
                            loggedUserId: ls.get("loggedUserId")
                        },
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isDepartmentDataProcessing = false;
                        //User Unauthorized
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            // Instruction Disabled
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_instruction_name_updated")
                                );
                                this.getAllInstruction(event);
                            }
                            // Instruction Disabled failed
                            else if (data.responseData == 2) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isDepartmentDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },
        // To ensure Instruction name is character and space only
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
        // Save Instruction To DB after validation
        saveInstruction($event) {
            if (this.$refs.saveInstructionForm.validate()) {
                this.isSaveInstructionFormDataProcessing = true;
                let postData;
                if (this.isSaveEditClicked == 1) {
                    postData = {
                        instructionName: this.instructionName,
                        instructionContentName: this.instructionContentName,
                        isSaveEditClicked: 1,
                        centerId: ls.get("loggedUserCenterId"),
                        loggedUserId: ls.get("loggedUserId")
                    };
                } else {
                    postData = {
                        instructionName: this.instructionName,
                        instructionContentName: this.instructionContentName,
                        instructionId: this.editInstructionId,
                        isSaveEditClicked: 0,
                        centerId: ls.get("loggedUserCenterId"),
                        loggedUserId: ls.get("loggedUserId")
                    };
                }
                this.$http
                    .post(
                        "web_save_instruction",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isSaveInstructionFormDataProcessing = false;
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
                            // Instruction Exists
                            else if (data.responseData == 1) {
                                this.snackBarColor = "info";
                                this.changeSnackBarMessage(
                                    this.$t("label_instruction_exists")
                                );
                            }
                            // Instruction Saved
                            else if (data.responseData == 2) {
                                this.instructionName = "";
                                this.instructionContentName = "";
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_instruction_saved")
                                );
                                this.getAllInstruction(event);
                                this.isSaveEditClicked = 1;
                            }
                            // Failed to save Instruction
                            else if (data.responseData == 3) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }

                            // Instruction Updated
                            else if (data.responseData == 4) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_instruction_name_updated")
                                );
                                this.getAllInstruction(event);
                                this.isSaveEditClicked = 1;
                                this.instructionName = "";
                                this.instructionContentName = "";
                            }
                            // Instruction update failed
                            else if (data.responseData == 5) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isSaveInstructionFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Instruction from DB
        getAllInstruction(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_instruction?page=${e.page}`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        perPage: e.itemsPerPage
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
        // Instruction Status Color
        getDepartmentStatusColor(is_department_acive) {
            if (is_department_acive == "Active") return "success";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    {
                        header: "Instruction Title",
                        dataKey: "lms_exam_instruction_title"
                    },
                    {
                        header: "Instruction Content",
                        dataKey: "lms_exam_instruction_content"
                    },
                    {
                        header: "Status",
                        dataKey: "lms_exam_instruction_is_active"
                    }
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 }
            });
            pdfDoc.save(
                "InstructionListAsPDF" +
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
</style>
