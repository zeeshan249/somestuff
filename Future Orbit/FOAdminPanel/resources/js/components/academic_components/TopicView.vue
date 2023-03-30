<template>
    <!-- Card Start -->
    <v-container fluid style="max-width: 100% !important">
        <v-overlay :value="isLoaderActive" color="primary">
            <v-progress-circular
                indeterminate
                size="64"
                color="primary"
            ></v-progress-circular>
        </v-overlay>

        <transition name="fade" mode="out-in">
            <v-col class="d-flex flex-column mr-2" v-if="isAddCardVisible">
                <v-card elevation="0">
                    <v-app-bar dark color="primary" flat>
                        <v-toolbar-title color="success">{{
                            $t("label_topic")
                        }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon class="ma-2" outlined small color="white">
                            <v-icon
                                color="white"
                                @click="isAddCardVisible = !isAddCardVisible"
                                >mdi-minus</v-icon
                            >
                        </v-btn>
                    </v-app-bar>

                    <v-container>
                        <v-form
                            ref="saveTopicForm"
                            v-model="issaveTopicFormValid"
                            lazy-validation
                        >
                            <v-row dense>
                                <v-col cols="12" md="12" sm="12">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="courseId"
                                        :items="courseItems"
                                        :disabled="isSourceDataLoading"
                                        item-text="lms_course_name"
                                        item-value="lms_course_id"
                                        @change="
                                            getAllActiveClassBasedonStream()
                                        "
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
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

                                <v-col cols="12" md="12" sm="12">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="classId"
                                        :items="classItems"
                                        item-text="lms_child_course_name"
                                        item-value="lms_child_course_id"
                                        @change="
                                            getAllActiveSubjectBasedonClass()
                                        "
                                        :disabled="isSourceDataLoading"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            Class
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-select>
                                </v-col>

                                <v-col cols="12" md="12" sm="12">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="subjectId"
                                        :items="subjectItems"
                                        :disabled="isSourceDataLoading"
                                        item-text="lms_subject_name"
                                        item-value="lms_subject_id"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_subject") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-select>
                                </v-col>

                                <v-col cols="12" xs="12" sm="12" md="12">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="topicCode"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_topic_code") }}
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
                                <v-col cols="12" xs="12" sm="12" md="12">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="topicName"
                                        @keypress="isCharacters"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_topic_name") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-divider class="mx-4"></v-divider>
                            <div dense class="mx-2 text-center mb-2">
                                <v-btn
                                    v-permission="'Add Topic' | 'Edit Topic'"
                                    class="ma-2 rounded"
                                    tile
                                    color="primary"
                                    :disabled="
                                        !issaveTopicFormValid ||
                                        issaveTopicFormDataProcessing
                                    "
                                    @click="saveTopic"
                                    ><v-icon class="mr-2"
                                        >mdi-content-save</v-icon
                                    >
                                    {{
                                        issaveTopicFormDataProcessing == true
                                            ? $t("label_processing")
                                            : $t("label_save")
                                    }}</v-btn
                                >

                                <v-btn
                                    v-permission="'Add Course' | 'Edit Course'"
                                    class="ma-2 rounded"
                                    tile
                                    color="error"
                                    @click="
                                        isAddCardVisible = !isAddCardVisible
                                    "
                                >
                                    <v-icon class="mx-2">mdi-cancel</v-icon>
                                    {{
                                        isSaveTopicFormDataProcessing == true
                                            ? $t("label_processing")
                                            : $t("label_cancel")
                                    }}</v-btn
                                >
                            </div>
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
                item-key="lms_topic_id"
                class="elevation-0"
                :loading="tableDataLoading"
                :loading-text="tableLoadingDataText"
                :server-items-length="totalItemsInDB"
                :items-per-page="100"
                @pagination="getAllTopic"
                :footer-props="{
                    itemsPerPageOptions: [100, 200, 300, -1],
                }"
            >
                <template v-slot:no-data>
                    <p class="font-weight-black bold title" style="color: red">
                        {{ $t("label_no_data_found") }}
                    </p>
                </template>
                <template v-slot:item.lms_topic_is_active="{ item }">
                    <v-chip
                        x-small
                        :color="getStatusColor(item.lms_topic_is_active)"
                        dark
                        >{{ item.lms_topic_is_active }}</v-chip
                    >
                </template>
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-text-field
                            v-model="searchText"
                            class="mt-4"
                            label="Search"
                            @input="getAllTopic($event)"
                            prepend-inner-icon="mdi-magnify"
                        ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <v-switch
                            class="pt-4 mx-1"
                            v-if="!tableDataLoading"
                            inset
                            v-model="includeDelete"
                            @change="getAllTopic"
                        ></v-switch>

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

                        <v-btn
                            v-permission="'Add Course'"
                            v-if="!isAddCardVisible"
                            color="primary"
                            class="white--text mx-2"
                            @click="isAddCardVisible = !isAddCardVisible"
                        >
                            Add {{ $t("label_topic") }}
                            <v-icon right dark> mdi-plus </v-icon>
                        </v-btn>
                    </v-toolbar>
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-icon
                        v-permission="'Edit Topic'"
                        small
                        class="mr-2"
                        @click="editTopic(item)"
                        color="primary"
                        >mdi-pencil</v-icon
                    >

                    <v-icon
                        v-if="item.lms_topic_is_active == 'Active'"
                        v-permission="'Edit Topic'"
                        small
                        color="error"
                        @click="disableTopic(item)"
                        >mdi-delete</v-icon
                    >
                    <v-icon
                        v-if="item.lms_topic_is_active == 'Inactive'"
                        v-permission="'Edit Topic'"
                        small
                        color="success"
                        @click="disableTopic(item)"
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
            // For Breadcrumb
            breadCrumbItem: [
                {
                    text: this.$t("label_home"),
                    disabled: false,
                },
                {
                    text: this.$t("label_academics"),
                    disabled: false,
                },
                {
                    text: this.$t("label_topic"),
                    disabled: false,
                },
            ],
            isLoaderActive: false,

            courseId: "",
            topicName: "",
            topicCode: "",
            subjectId: "",
            classId: "",
            issaveTopicFormValid: true,
            issaveTopicFormDataProcessing: false,

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
                    text: this.$t("label_topic_code"),
                    value: "lms_topic_code",
                    width: "20%",
                    sortable: false,
                },
                {
                    text: this.$t("label_topic_name"),
                    value: "lms_topic_name",
                    width: "20%",
                    sortable: false,
                },
                {
                    text: "Stream",
                    value: "lms_course_name",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Class",
                    value: "lms_child_course_name",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: this.$t("label_subject_name"),
                    value: "lms_subject_name",
                    width: "15%",
                    sortable: false,
                },

                {
                    text: this.$t("label_status"),
                    value: "lms_topic_is_active",
                    align: "middle",
                    width: "15%",
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
            // classItems: ["Class III", "Class IV", "Class V", "Class VI",
            //              "Class VII", "Class VIII","Class IX","Class X",
            //              "Class XI", "Class XII"],
            classItems: [],
            isSaveEditClicked: 1,
            editTopictId: "",
            courseImageNameForEdit: "",
            // search
            searchText: "",

            //Datatable End
            courseItems: [],
            subjectItems: [],
            // For Add Department card
            isAddCardVisible: false,
            includeDelete: false,

            // For Excel Download
            excelFields: {
                "Topic Code": "lms_topic_code",
                "Topic Name": "lms_topic_name",
                Class: "lms_child_course_name",
                "Subject Name": "lms_subject_name",
                "Course Name": "lms_course_name",
                Status: "lms_topic_is_active",
            },
            excelData: [],
            excelFileName:
                "TopicListAsExcel" +
                "_" +
                moment().format("DD/MM/YYYY") +
                ".xls",
        };
    },
    watch: {},
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
        // this.getAllTopic();
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") },
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
                        this.courseItems = data;
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

        // Get all active class based on stream
        getAllActiveClassBasedonStream() {
            this.isSourceDataLoading = true;
            this.$http
                .get(
                    `web_get_all_active_class_based_on_stream_without_pagination`,
                    {
                        params: {
                            centerId: ls.get("loggedUserCenterId"),
                            courseId: this.courseId,
                        },
                        headers: { Authorization: "Bearer " + ls.get("token") },
                    }
                )
                .then(({ data }) => {
                    this.isSourceDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.classItems = data;
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

        // Get all active subject based on course
        getAllActiveSubjectBasedonClass() {
            this.isSourceDataLoading = true;
            this.$http
                .get(
                    `web_get_all_active_subject_based_on_course_without_pagination`,
                    {
                        params: {
                            centerId: ls.get("loggedUserCenterId"),
                            courseId: this.courseId,
                        },
                        headers: { Authorization: "Bearer " + ls.get("token") },
                    }
                )
                .then(({ data }) => {
                    this.isSourceDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.subjectItems = data;
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

        // Edit Course

        editTopic(item) {
            console.log(item);
            this.isAddCardVisible = true;
            this.editTopictId = item.lms_topic_id;
            this.isSaveEditClicked = 0;
            this.courseId = item.lms_course_id;
            this.classId = item.lms_child_course_id;
            this.getAllActiveClassBasedonStream();
            this.getAllActiveSubjectBasedonClass();
            this.subjectId = item.lms_subject_id;
            this.topicName = item.lms_topic_name;
            this.topicCode = item.lms_topic_code;
        },
        // Disable Course status
        disableTopic(item, $event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_topic")
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_topic",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            topicId: item.lms_topic_id,
                            isTopicActive:
                                item.lms_topic_is_active == "Active" ? 0 : 1,
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
                            // Course Disabled
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_topic_status_changed")
                                );
                                this.getAllTopic(event);
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
                    .catch((error) => {
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
        saveTopic($event) {
            if (this.$refs.saveTopicForm.validate()) {
                this.issaveTopicFormDataProcessing = true;
                let postData = new FormData();
                if (this.isSaveEditClicked == 1) {
                    postData.append("courseId", this.courseId);
                    postData.append("subjectId", this.subjectId);
                    postData.append("topicName", this.topicName);
                    postData.append("topicCode", this.topicCode);
                    postData.append("classId", this.classId);
                    postData.append("isSaveEditClicked", 1);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                } else {
                    postData.append("courseId", this.courseId);
                    postData.append("classId", this.classId);
                    postData.append("subjectId", this.subjectId);
                    postData.append("topicName", this.topicName);
                    postData.append("topicCode", this.topicCode);
                    postData.append("lms_child_course", this.lms_child_course);
                    postData.append("isSaveEditClicked", 0);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));

                    postData.append("topicId", this.editTopictId);
                }
                this.$http
                    .post(
                        "web_save_update_topic",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.issaveTopicFormDataProcessing = false;
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
                                    this.$t("label_topic_exists")
                                );
                            }
                            // Course Saved
                            else if (data.responseData == 2) {
                                this.courseId = "";
                                this.subjectId = "";
                                this.topicName = "";
                                this.topicCode = "";
                                this.classId = "";
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_topic_saved")
                                );
                                this.getAllTopic(event);
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
                                    this.$t("label_topic_updated")
                                );
                                this.getAllTopic(event);
                                this.isSaveEditClicked = 1;
                                this.courseId = "";
                                this.subjectId = "";
                                this.topicName = "";
                                this.topicCode = "";
                                this.classId = "";
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
                    .catch((error) => {
                        this.issaveTopicFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Topic from DB
        getAllTopic(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_topic?page=${e.page}`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        searchText: this.searchText,
                        includeDelete: this.includeDelete,
                        perPage:
                            e.itemsPerPage == -1
                                ? this.totalItemsInDB
                                : e.itemsPerPage,
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

        // searchInfo() {
        //     clearTimeout(this._timerId);
        //     this._timerId = setTimeout(() => {
        //         this.getAllTopic();
        //     }, 500);
        // },
        // Topic Status Color
        getStatusColor(is_course_active) {
            if (is_course_active == "Active") return "success";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    { header: "Course Name", dataKey: "lms_course_name" },
                    { header: "Class", dataKey: "lms_child_course_name" },
                    { header: "Subject Name", dataKey: "lms_subject_name" },
                    { header: "Topic Code", dataKey: "lms_topic_code" },
                    { header: "Topic Name", dataKey: "lms_topic_name" },
                    { header: "Status", dataKey: "lms_topic_is_active" },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "TopicListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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
