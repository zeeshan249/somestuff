<template>
    <div  id="app">
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
            <v-row   justify="space-around"
           style="margin-right: 1px !important; margin-left: -1px !important"
           class="mb-4 mt-1"
           dense>
                <v-toolbar-title dark color="primary">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                <strong>Subscription</strong>
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                Home
                                <v-icon>mdi-forward</v-icon>
                                Accounts
                                <v-icon>mdi-forward</v-icon> Subscription
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                    v-permission="'Add Subscription'"
                    v-if="!isAddCardVisible"
                    :disabled="tableDataLoading"
                    color="primary"
                    class="white--text"
                    @click="isAddCardVisible = !isAddCardVisible"
                >
                    Add Subscription Card
                    <v-icon right dark> mdi-plus </v-icon>
                </v-btn>
            </v-row>
            </v-sheet>
            <transition name="fade" mode="out-in">
                <v-col v-if="isAddCardVisible">
                    <v-card>
                        <v-app-bar dark color="primary">
                            <v-toolbar-title color="success">{{
                                $t("label_subscription")
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
                                        isAddCardVisible = !isAddCardVisible
                                    "
                                    >mdi-minus</v-icon
                                >
                            </v-btn>
                        </v-app-bar>

                        <v-container>
                            <v-form
                                ref="saveSubscriptionForm"
                                v-model="issaveSubscriptionFormValid"
                                lazy-validation
                            >
                                <v-row dense>
                                    <v-col
                                        cols="12"
                                        md="6"
                                        sm="12"
                                        class="pl-4 pr-2"
                                    >
                                        <v-select
                                            outlined
                                            dense
                                            v-model="courseId"
                                            :items="courseItems"
                                            :disabled="isSourceDataLoading"
                                            item-text="lms_course_name"
                                            item-value="lms_course_id"
                                            :rules="[
                                                v => !!v || $t('label_required')
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

                                    <v-col
                                        cols="12"
                                        xs="12"
                                        sm="12"
                                        md="6"
                                        class="pl-2 pr-4"
                                    >
                                        <v-text-field
                                            outlined
                                            dense
                                            v-model="lms_exam_card_name"
                                            :rules="[
                                                v => !!v || $t('label_required')
                                            ]"
                                        >
                                            <template #label>
                                                {{
                                                    $t(
                                                        "label_subscription_title"
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

                                    <v-col
                                        cols="12"
                                        xs="12"
                                        sm="12"
                                        md="6"
                                        class="pl-4 pr-2"
                                    >
                                        <v-text-field
                                            outlined
                                            dense
                                            v-model="
                                                lms_exam_card_payment_month_duration
                                            "
                                            @keypress="isDigit"
                                            :rules="[
                                                v => !!v || $t('label_required')
                                            ]"
                                        >
                                            <template #label>
                                                {{
                                                    $t(
                                                        "label_subscription_duration"
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

                                    <v-col
                                        cols="12"
                                        xs="12"
                                        sm="12"
                                        md="6"
                                        class="pl-2 pr-4"
                                    >
                                        <v-text-field
                                            outlined
                                            dense
                                            v-model="
                                                lms_exam_card_charge_per_month
                                            "
                                            @keypress="isDigit"
                                            :rules="[
                                                v => !!v || $t('label_required')
                                            ]"
                                        >
                                            <template #label>
                                                {{
                                                    $t(
                                                        "label_subscription_value"
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
                                </v-row>

                                <v-row dense>
                                    <v-col
                                        cols="12"
                                        xs="12"
                                        sm="12"
                                        md="12"
                                        class="pl-4 pr-4"
                                    >
                                        <v-btn
                                            class="ma-2 rounded"
                                            tile
                                            color="primary"
                                            :disabled="
                                                !issaveSubscriptionFormValid ||
                                                    issaveSubscriptionFormDataProcessing
                                            "
                                            @click="saveSubscription"
                                            >{{
                                                issaveSubscriptionFormDataProcessing ==
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
                </v-col>
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
                    @pagination="getAllSubscription"
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
                    <template
                        v-slot:item.lms_exam_card_card_is_active="{
                            item
                        }"
                    >
                        <v-chip
                            x-small
                            :color="
                                getStatusColor(
                                    item.lms_exam_card_card_is_active
                                )
                            "
                            dark
                            >{{ item.lms_exam_card_card_is_active }}</v-chip
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
                            v-permission="'Add Subscription'"
                            small
                            class="mr-2"
                            @click="addQuestionToExam(item)"
                            color="teal"
                            >mdi-account-plus</v-icon
                        >
                        <v-icon
                            v-permission="'Edit Subscription'"
                            small
                            class="mr-2"
                            @click="editSubscription(item)"
                            color="primary"
                            >mdi-pencil</v-icon
                        >

                        <v-icon
                            v-if="item.lms_exam_card_card_is_active == 'Active'"
                            v-permission="'Delete Subscription'"
                            small
                            color="error"
                            @click="disableSubscription(item)"
                            >mdi-delete</v-icon
                        >
                        <v-icon
                            v-if="
                                item.lms_exam_card_card_is_active == 'Inactive'
                            "
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

//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
    props: ["userPermissionDataProps"],

    data() {
        return {
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
            totalItemsInDB: 0,
            tableLoadingDataText: this.$t("label_loading_data"),

            tableHeader: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: this.$t("label_subscription"),
                    value: "lms_exam_card_name",
                    width: "20%",
                    sortable: false
                },
                {
                    text: "Stream",
                    value: "lms_course_name",
                    width: "20%",
                    sortable: false
                },
                {
                    text: this.$t("label_subscription_duration"),
                    value: "lms_exam_card_payment_month_duration",
                    width: "10%",
                    sortable: false
                },
                {
                    text: this.$t("label_subscription_value"),
                    value: "lms_exam_card_charge_per_month",
                    width: "10%",
                    sortable: false
                },

                {
                    text: this.$t("label_status"),
                    value: "lms_exam_card_card_is_active",
                    align: "middle",
                    width: "15%",
                    sortable: false
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "20%",
                    align: "middle"
                }
            ],
            tableItems: [],
            isSaveEditClicked: 1,
            editSubscriptionId: "",
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
                Status: "lms_exam_card_card_is_active"
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
        }
    },

    created() {
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") }
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
                        centerId: ls.get("loggedUserCenterId")
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
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
                .catch(error => {
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
        // Push to new module
        addQuestionToExam(item) {
            this.$router.push({
                name: "AssignSubscription",
                params: { subscriptionDataProps: item }
            });
        },
        // Edit

        editSubscription(item) {
            this.isAddCardVisible = true;
            this.editSubscriptionId = item.lms_exam_card_id;
            this.isSaveEditClicked = 0;
            this.courseId = item.lms_course_id;
            this.lms_exam_card_name = item.lms_exam_card_name;
            //  this.lms_course_id = item.lms_course_id;
            this.lms_exam_card_payment_month_duration =
                item.lms_exam_card_payment_month_duration;
            this.lms_exam_card_charge_per_month =
                item.lms_exam_card_charge_per_month;
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
                        "web_enable_disable_subscription",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            lms_exam_card_id: item.lms_exam_card_id,
                            lms_exam_card_card_is_active:
                                item.lms_exam_card_card_is_active == "Active"
                                    ? 0
                                    : 1,
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
                                this.getAllSubscription(event);
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
        // Save Subject To DB after validation
        saveSubscription($event) {
            if (this.$refs.saveSubscriptionForm.validate()) {
                this.issaveSubscriptionFormDataProcessing = true;
                let postData = new FormData();
                if (this.isSaveEditClicked == 1) {
                    postData.append("lms_course_id", this.courseId);
                    postData.append(
                        "lms_exam_card_name",
                        this.lms_exam_card_name
                    );
                    postData.append(
                        "lms_exam_card_payment_month_duration",
                        this.lms_exam_card_payment_month_duration
                    );
                    postData.append(
                        "lms_exam_card_charge_per_month",
                        this.lms_exam_card_charge_per_month
                    );

                    postData.append("isSaveEditClicked", 1);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                } else {
                    postData.append("lms_course_id", this.courseId);
                    postData.append(
                        "lms_exam_card_name",
                        this.lms_exam_card_name
                    );
                    postData.append(
                        "lms_exam_card_payment_month_duration",
                        this.lms_exam_card_payment_month_duration
                    );
                    postData.append(
                        "lms_exam_card_charge_per_month",
                        this.lms_exam_card_charge_per_month
                    );
                    postData.append("isSaveEditClicked", 0);
                    postData.append("centerId", ls.get("loggedUserCenterId"));

                    postData.append("loggedUserId", ls.get("loggedUserId"));

                    postData.append(
                        "lms_exam_card_id",
                        this.editSubscriptionId
                    );
                }
                this.$http
                    .post(
                        "web_save_update_subscription",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.issaveSubscriptionFormDataProcessing = false;
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
                                    this.$t("label_subscription_exists")
                                );
                            }
                            // Course Saved
                            else if (data.responseData == 2) {
                                this.courseId = "";
                                this.lms_exam_card_name = "";
                                this.lms_exam_card_payment_month_duration = "";
                                this.lms_exam_card_charge_per_month = "";
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_subscription_saved")
                                );
                                this.getAllSubscription(event);
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
                                    this.$t("label_subscription_updated")
                                );
                                this.getAllSubscription(event);
                                this.isSaveEditClicked = 1;
                                this.courseId = "";
                                this.lms_exam_card_name = "";
                                this.lms_exam_card_payment_month_duration = "";
                                this.lms_exam_card_charge_per_month = "";
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
                    .catch(error => {
                        this.issaveSubscriptionFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Subject from DB
        getAllSubscription(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_subscription?page=${e.page}`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
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
                        dataKey: "lms_exam_card_card_is_active"
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
