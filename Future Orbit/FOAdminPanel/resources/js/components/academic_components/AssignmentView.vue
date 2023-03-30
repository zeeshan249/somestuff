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
                    style="  margin-right: 1px !important;
                        margin-left: -1px !important;
                    "
                    class="mb-4 mt-1"
                    dense
                >
                    <v-toolbar-title dark color="primary">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">
                                    <strong>
                                        {{
                                            this.$t("label_assignment")
                                        }}</strong
                                    >
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    >Home <v-icon>mdi-forward</v-icon> Academics
                                    <v-icon>mdi-forward</v-icon>
                                    {{ this.$t("label_assignment") }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-permission="'Add Assignment'"
                        v-if="!isAddCardVisible"
                        :disabled="tableDataLoading"
                        color="primary"
                        class="white--text mt-6 left"
                        @click="isAddCardVisible = !isAddCardVisible"
                    >
                        Add Assignment
                        <v-icon right dark> mdi-plus </v-icon>
                    </v-btn>
                </v-row>
            </v-sheet>

            <transition name="fade" mode="out-in">
                <v-card v-if="isAddCardVisible">
                    <v-app-bar dark color="grey" flat>
                        <v-toolbar-title color="success">{{
                            $t("label_assignment")
                        }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon dark>
                            <v-icon
                                @click="isAddCardVisible = !isAddCardVisible"
                                >mdi-close</v-icon
                            >
                        </v-btn>
                    </v-app-bar>

                    <v-form
                        ref="saveAssignmentForm"
                        v-model="isSaveAssignmentFormValid"
                        lazy-validation
                    >
                        <v-row dense class="mx-2 mt-2">
                            <v-col cols="12" md="3">
                                <v-select
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                    v-model="selectedCourseId"
                                    :disabled="iscourseItemsLoading"
                                    :items="courseItems"
                                    dense
                                    outlined
                                    label="Select Stream"
                                    item-text="lms_course_name"
                                    item-value="lms_course_id"
                                    @change="getAllActiveClassBasedonStream()"
                                >
                                    <template #label>
                                        Select Stream
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-select>
                            </v-col>

                            <v-col cols="12" md="3">
                                <v-select
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                    outlined
                                    dense
                                    v-model="classId"
                                    :items="classItems"
                                    item-text="lms_child_course_name"
                                    item-value="lms_child_course_id"
                                    :disabled="isSourceDataLoading"
                                    @change="getAllActiveSubjectBasedonCourse()"
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
                            <v-col cols="12" md="3">
                                <v-select
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                    outlined
                                    dense
                                    v-model="lms_subject_id"
                                    :items="subjectItems"
                                    :disabled="subjectDataLoading"
                                    item-text="lms_subject_name"
                                    item-value="lms_subject_id"
                                    @change="getAllActiveTopicBasedonSubject()"
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
                            <v-col cols="12" md="3">
                                <v-select
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                    outlined
                                    dense
                                    v-model="lms_topic_id"
                                    :items="topicItems"
                                    :disabled="topicDataLoading"
                                    item-text="lms_topic_name"
                                    item-value="lms_topic_id"
                                >
                                    <template #label
                                        >{{ $t("label_topic") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span></template
                                    >
                                </v-select>
                            </v-col>
                        </v-row>
                        <v-row dense class="mx-2">
                            <v-col cols="12" md="5" sm="12">
                                <v-select
                                    outlined
                                    dense
                                    v-model="lms_batch_id"
                                    :items="batchItems"
                                    :disabled="isSourceDataLoading"
                                    item-text="lms_batch_code_name"
                                    item-value="lms_batch_id"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        Select Batch
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-select>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-datetime-picker
                                    label="Live From"
                                    v-model="selectedLiveTill"
                                    outlined
                                    :time-picker-props="timeProps"
                                    time-format="HH:mm:ss"
                                    date-format="yyyy-MM-dd"
                                    :text-field-props="textFieldProps"
                                >
                                </v-datetime-picker>
                            </v-col>
                            <v-col cols="12" xs="12" sm="12" md="3">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="lms_assignment_score"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        Score
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row dense class="mx-2">
                            <v-col cols="12" xs="12" sm="12" md="12">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="lms_assignment_title"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        Assignment Title
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row dense class="mx-2">
                            <v-col cols="12" xs="12" sm="12" md="12">
                                <div id="app">
                                    <vue-editor
                                        v-model="lms_assignment_description"
                                        :editor-toolbar="customToolbar"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        ></vue-editor
                                    >
                                </div>
                            </v-col>
                        </v-row>

                        <v-card-actions>
                            <v-btn
                                class="ma-2 rounded"
                                tile
                                color="primary"
                                :disabled="
                                    !isSaveAssignmentFormValid ||
                                    isSaveAssignmentFormDataProcessing
                                "
                                @click="saveNotice"
                                >{{
                                    isSaveAssignmentFormDataProcessing == true
                                        ? $t("label_processing")
                                        : $t("label_save")
                                }}</v-btn
                            >
                            <v-btn
                                class="ma-2 rounded"
                                tile
                                color="error"
                                :disabled="
                                    !isSaveAssignmentFormValid ||
                                    isSaveAssignmentFormDataProcessing
                                "
                                @click="
                                    isAddCardVisible = !isAddCardVisible;
                                    resetForm();
                                "
                                >{{
                                    isSaveAssignmentFormDataProcessing == true
                                        ? $t("label_processing")
                                        : $t("label_cancel")
                                }}</v-btn
                            >
                        </v-card-actions>
                    </v-form>
                </v-card>
            </transition>
            <transition name="fade" mode="out-in">
                <v-data-table
                    dense
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    item-key="lms_assignment_id"
                    class="elevation-1"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="100"
                    :single-expand="singleExpand"
                    :expanded.sync="expanded"
                    show-expand
                    @pagination="getAllActiveAssignment"
                    :footer-props="{
                        itemsPerPageOptions: [100, 200, 300, -1],
                    }"
                >
                    <template
                        v-slot:item.data-table-expand="{
                            item,
                            isExpanded,
                            expand,
                        }"
                    >
                        <v-icon
                            small
                            @click="expand(false)"
                            v-if="isExpanded"
                            size="22"
                            class="mr-2"
                            color="primary"
                            >mdi-arrow-up-circle-outline</v-icon
                        >

                        <v-icon
                            small
                            @click="
                                expand(true);
                                getDocumentAssignmentWise(
                                    item.lms_assignment_id
                                );
                            "
                            v-if="!isExpanded"
                            size="22"
                            class="mr-2"
                            color="success"
                            >mdi-arrow-down-circle-outline</v-icon
                        >
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <v-icon
                                    v-bind="attrs"
                                    v-on="on"
                                    small
                                    class="mr-2"
                                    @click="editAssignment(item)"
                                    color="primary"
                                    >mdi-eye</v-icon
                                >
                            </template>
                            <span>Submitted Assignment</span>
                        </v-tooltip>
                        
                    </template>
                    <template v-slot:expanded-item="{ headers, item }">
                        <td :colspan="headers.length" style="bgcolor: red">
                            <br />
                            <v-row dense class="mx-2 my-2">
                                <v-col cols="12" md="6">
                                    <v-card
                                        :disabled="isSourceDataLoading"
                                        elevation="2"
                                    >
                                        <v-toolbar color="light-blue" dark>
                                            <v-btn icon>
                                                <v-icon
                                                    >mdi-file-document-multiple-outline</v-icon
                                                >
                                            </v-btn>
                                            <v-toolbar-title
                                                >Assignment(s)</v-toolbar-title
                                            >

                                            <v-spacer></v-spacer>
                                        </v-toolbar>

                                        <v-card-text>
                                            <v-form
                                                ref="uploadAssignmentForm"
                                                v-model="
                                                    isUploadAssignmentFormValid
                                                "
                                                lazy-validation
                                            >
                                                <v-row>
                                                    <v-file-input
                                                        class="px-4"
                                                        v-model="
                                                            selectedAssignmentImage
                                                        "
                                                        color="primary"
                                                        outlined
                                                        dense
                                                        show-size
                                                        accept=".pdf,.jpg,.png,.docx,.jpeg"
                                                        :rules="imageRule"
                                                    >
                                                        <template
                                                            v-slot:selection="{
                                                                index,
                                                                text,
                                                            }"
                                                        >
                                                            <v-chip
                                                                v-if="index < 2"
                                                                color="primary"
                                                                dark
                                                                label
                                                                small
                                                                >{{
                                                                    text
                                                                }}</v-chip
                                                            >
                                                        </template>
                                                        <template #label
                                                            >Assignment
                                                            <span
                                                                class="red--text"
                                                                ><strong>{{
                                                                    $t(
                                                                        "label_star"
                                                                    )
                                                                }}</strong></span
                                                            ></template
                                                        >
                                                    </v-file-input>
                                                    <div
                                                        class="float-right mr-4"
                                                    >
                                                        <v-btn
                                                            v-permission="
                                                                'Add Assignment' |
                                                                    'Edit Assignment'
                                                            "
                                                            depressed
                                                            color="primary"
                                                            :disabled="
                                                                !isUploadAssignmentFormValid ||
                                                                isUploadAssignmentFormDataProcessing
                                                            "
                                                            @click="
                                                                uploadAssignment
                                                            "
                                                        >
                                                            <v-icon
                                                                dark
                                                                class="mr-2"
                                                            >
                                                                mdi-cloud-upload
                                                            </v-icon>
                                                            Upload
                                                        </v-btn>
                                                    </div>
                                                </v-row>
                                            </v-form>
                                        </v-card-text>
                                        <v-divider class="mx-4"></v-divider>
                                        <v-list subheader two-line>
                                            <v-list-item
                                                v-for="folder in documentItems"
                                                :key="
                                                    folder.lms_assignment_document_id
                                                "
                                            >
                                                <v-list-item-avatar>
                                                    <v-icon class="info" dark>
                                                        mdi-file-document
                                                    </v-icon>
                                                </v-list-item-avatar>

                                                <v-list-item-content>
                                                    <v-list-item-title
                                                        v-text="
                                                            folder.lms_assignment_document_path
                                                        "
                                                    ></v-list-item-title>

                                                    <v-list-item-subtitle
                                                        v-text="
                                                            folder.lms_assignment_document_created_at
                                                        "
                                                    ></v-list-item-subtitle>
                                                </v-list-item-content>

                                                <v-list-item-action>
                                                    <div>
                                                        <v-btn
                                                            icon
                                                            @click="
                                                                downloadAssignment(
                                                                    folder.lms_assignment_document_path
                                                                )
                                                            "
                                                        >
                                                            <v-icon
                                                                color="success lighten-1"
                                                                >mdi-download-circle</v-icon
                                                            >
                                                        </v-btn>
                                                        <v-btn
                                                            v-permission="
                                                                'Delete Assignment'
                                                            "
                                                            icon
                                                            @click="
                                                                deleteAssignment(
                                                                    folder.lms_assignment_document_id
                                                                )
                                                            "
                                                        >
                                                            <v-icon
                                                                color="danger lighten-1"
                                                                >mdi-delete-circle</v-icon
                                                            >
                                                        </v-btn>
                                                    </div>
                                                </v-list-item-action>
                                            </v-list-item>
                                        </v-list>
                                    </v-card>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-card
                                        :disabled="isSourceDataLoading"
                                        elevation="2"
                                    >
                                        <v-toolbar color="light-blue" dark>
                                            <v-btn icon>
                                                <v-icon
                                                    >mdi-comment-text-multiple-outline</v-icon
                                                >
                                            </v-btn>
                                            <v-toolbar-title
                                                >Assignment
                                                Description</v-toolbar-title
                                            >

                                            <v-spacer></v-spacer>
                                        </v-toolbar>
                                        <div
                                            class="px-2 pt-2"
                                            v-html="
                                                item.lms_assignment_description
                                            "
                                            style="align-content: center"
                                        ></div>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </td>
                    </template>
                    <template v-slot:no-data>
                        <p
                            class="font-weight-black bold title"
                            style="color: red"
                        >
                            {{ $t("label_no_data_found") }}
                        </p>
                    </template>

                    <template v-slot:item.lms_subject_name="{ item }">
                        <div>
                            <div class="font-weight-normal">
                                <strong>{{ item.lms_subject_name }}</strong>
                            </div>
                            <div>{{ item.lms_topic_name }}</div>
                        </div>
                    </template>

                    <template
                        v-slot:item.lms_assignment_upload_status="{ item }"
                    >
                        <v-chip
                            x-small
                            :color="
                                getStatusColor(
                                    item.lms_assignment_upload_status
                                )
                            "
                            dark
                            >{{ item.lms_assignment_upload_status }}</v-chip
                        >
                    </template>
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-text-field
                                prepend-inner-icon="mdi-magnify"
                                class="mt-4 mx-4"
                                :disabled="isSourceDataLoading"
                                v-model="txtSearchCriteria"
                                label="Search Here"
                                @keydown.enter="
                                    isSearchBySource = false;
                                    getAllActiveAssignment($event);
                                "
                            ></v-text-field>
                            <v-spacer></v-spacer>
                            <v-switch
                                v-model="singleExpand"
                                class="mt-6"
                                v-if="false"
                            ></v-switch>

                            <v-switch
                                v-model="includeDelete"
                                class="mt-6"
                                v-if="!tableDataLoading"
                                @change="getAllActiveAssignment"
                            ></v-switch>
                            <v-divider
                                class="ml-6 mr-6"
                                v-if="!tableDataLoading"
                                inset
                                vertical
                            ></v-divider>
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
                            v-permission="'Edit Notice'"
                            small
                            class="mr-2"
                            @click="editNotice(item)"
                            color="primary"
                            >mdi-pencil</v-icon
                        >

                        <v-icon
                
                        v-if="item.lms_assignment_upload_status == 'Created'"
                            small
                            color="error"
                            @click="changeStatus(item)"
                            >mdi-check-circle</v-icon
                        >

                        <v-icon
                            v-if="item.lms_assignment_status == 'Inactive'"
                            v-permission="'Delete Assignment'"
                            small
                            color="info"
                            @click="disableAssignment(item)"
                            >mdi-reply</v-icon
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
import { Global } from "../../components/helpers/global"
const ls = new SecureLS({ encodingType: "aes" });

//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

import { VueEditor } from "vue2-editor";
import katex from "katex";
import "katex/dist/katex.min.css";

export default {
    components: {
        VueEditor,
    },
    props: ["userPermissionDataProps"],

    data() {
        return {
            files: [],
            imageRule: [],
            selectedAssignmentImage: null,
            customToolbar: [
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                ["bold", "italic", "underline", "strike", { align: [] }],

                ["blockquote", "code-block"],

                [{ list: "ordered" }, { list: "bullet" }],
                [{ script: "sub" }, { script: "super" }],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ direction: "rtl" }],

                [{ color: [] }, { background: [] }],
            ],
            timeProps: { useSeconds: true },
            textFieldProps: {
                outlined: true,
                dense: true,
                prependInnerIcon: "mdi-calendar",
            },
            lms_assignment_description: null,
            lms_assignment_title: null,
            lms_assignment_score: null,
            selectedLiveTill: null,
            expanded: [],
            singleExpand: true,
            isLoaderActive: false,
            noticeId: "",
            isSearchBySource: false,
            txtSearchCriteria: null,
            lms_notice_description: "",
            lms_notice_title: "",
            isSaveAssignmentFormValid: true,
            isSaveAssignmentFormDataProcessing: false,
            authorizationConfig: "",
            roleItems: [],
            roleId: [],
            isUploadAssignmentFormValid: true,
            isUploadAssignmentFormDataProcessing: false,
            isAddCardVisible: false,

            // Snack Bar

            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",

            //   Datatable Start

            tableDataLoading: false,
            selectedAssignmentId: null,
            totalItemsInDB: 0,
            tableLoadingDataText: this.$t("label_loading_data"),
            iscourseItemsLoading: false,
            courseItems: [],
            selectedCourseId: "",
            subjectItems: [],
            topicItems: [],
            includeDelete: false,
            subjectDataLoading: false,
            isSourceDataLoading: false,
            topicDataLoading: false,
            lms_subject_id: "",
            lms_topic_id: "",
            lms_batch_id: "",
            batchItems: [],
            documentItems: [],
            tableHeader: [
                {
                    text: "#",
                    value: "index",
                    width: "5%",
                    sortable: false,
                    groupable: true,
                },
                {
                    text: "Title",
                    value: "lms_assignment_title",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Subject",
                    value: "lms_subject_name",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Class",
                    value: "lms_child_course_name",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Batch",
                    value: "lms_batch_name",
                    width: "15%",
                    sortable: false,
                },
                
                {
                    text: "Last Date",
                    value: "lms_assignment_submission_last_date",
                    width: "10%",
                    sortable: false,
                },

                {
                    text: this.$t("label_status"),
                    value: "lms_assignment_upload_status",
                    align: "middle",
                    width: "5%",
                    sortable: false,
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "5%",
                    align: "end",
                },
                

                {
                    text: "Description",
                    value: "data-table-expand",
                    sortable: false,
                    width: "5%",
                    align: "end",
                },
            
            ],
            classId: "",
            classItems: [],
            tableItems: [],
            isSaveEditClicked: 1,
            lms_assignment_id: "",
            noticeImageNameForEdit: "",

            // For Excel Download
            excelFields: {
                Title: "lms_assignment_title",
                Subject: "lms_subject_name",
                Class: "lms_child_course_name",
                LastDate: "lms_assignment_submission_last_date",
                Status: "lms_assignment_upload_status",
            },
            excelData: [],
            excelFileName:
                "Assignment" + "_" + moment().format("DD/MM/YYYY") + ".xls",
        };
    },
    watch: {
        selectedAssignmentImage(val) {
            this.selectedAssignmentImage = val;

            this.imageRule =
                this.selectedAssignmentImage != null
                    ? [
                          (v) =>
                              !v ||
                              v.size <= 1048576 ||
                              this.$t("label_file_size_criteria_1_mb"),
                      ]
                    : [];
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
        // Get Active Sources
        this.getAllBatch();
        this.getAllActiveCourse();
    },

    methods: {
        async changeStatus(item, $event) {
            const result = await Global.showConfirmationAlert(
                "Are you sure, To Confirm Submission of Assignment",
                
            
            );
            if (result.isConfirmed) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_assignment",
                        {
                         
                            lms_assignment_id: item.lms_assignment_id,
                            lms_assignment_upload_status: 1,
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
                            console.log(data.responseData);
                            // School Source Disabled
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    "Assignment Submitted"
                                );
                              //  this.dialogAddSchool = false;
                               
                            }
                            this.getAllActiveAssignment(event);
                           
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
        editAssignment(item) {
         
            this.$router.push({
                name: "ViewSubmittedAssignment",
                params: { assignmentDataProps: item },
            });
        },
        deleteAssignment(lms_assignment_document_id) {
            let userDecision = confirm(
                "Are you sure you want to delete Assignment"
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_delete_assignment",
                        {
                            lms_assignment_document_id:
                                lms_assignment_document_id,
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
                                    "Assignment deleted!!!"
                                );
                                this.getDocumentAssignmentWise(
                                    this.selectedAssignmentId
                                );
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

        downloadAssignment(imageUrl) {
            console.log(imageUrl);
            this.isLoaderActive = true;
            this.downloadImageUrl = process.env.MIX_ASSIGNMENT_URL + imageUrl;
            axios({
                url: this.downloadImageUrl,
                method: "GET",
                responseType: "blob",
                headers: {
                    Authorization: "Bearer " + ls.get("token"),
                },
            })
                .then((response) => {
                    var fileURL = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    var fileLink = document.createElement("a");
                    fileLink.href = fileURL;
                    fileLink.setAttribute("download", imageUrl);

                    document.body.appendChild(fileLink);
                    fileLink.click();
                    this.isLoaderActive = false;
                })
                .catch((error) => {
                    this.isLoaderActive = true;
                });
        },

        // UploadAssignment
        uploadAssignment($event) {
            if (this.$refs.uploadAssignmentForm.validate()) {
                this.isUploadAssignmentFormDataProcessing = true;
                let postData = new FormData();
                {
                    if (this.selectedAssignmentImage != null) {
                        postData.append(
                            "assignmentImage",
                            this.selectedAssignmentImage
                        );
                    }

                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                    postData.append(
                        "lms_assignment_id",
                        this.selectedAssignmentId
                    );

                    this.$http
                        .post(
                            "web_upload_assignment",
                            postData,
                            this.authorizationConfig
                        )
                        .then(({ data }) => {
                            this.isUploadAssignmentFormDataProcessing = false;
                            //User Unauthorized
                            if (
                                data.error == "Unauthorized" ||
                                data.permissionError == "Unauthorized"
                            ) {
                                this.$store.dispatch(
                                    "actionUnauthorizedLogout"
                                );
                            } else {
                                // Server side validation fails
                                if (data.responseData == 0) {
                                    this.snackBarColor = "error";
                                    this.changeSnackBarMessage(data.error);
                                }
                                // Course Code Exists
                                else if (data.responseData == 1) {
                                    this.snackBarColor = "success";
                                    this.changeSnackBarMessage(
                                        "Assignment Uploaded"
                                    );
                                    this.getDocumentAssignmentWise(
                                        this.selectedAssignmentId
                                    );
                                    this.selectedAssignmentImage = null;
                                }
                                // Course Saved
                                else if (data.responseData == 2) {
                                    this.selectedAssignmentImage = null;
                                    this.snackBarColor = "error";
                                    this.changeSnackBarMessage(
                                        "Assignment not saved"
                                    );
                                }
                                // Failed to save Course
                                else if (data.responseData == 3) {
                                    this.snackBarColor = "error";
                                    this.changeSnackBarMessage(
                                        "Assignment upload failed"
                                    );
                                }
                            }
                        })
                        .catch((error) => {
                            this.isUploadAssignmentFormDataProcessing = false;
                            this.snackBarColor = "error";
                            this.changeSnackBarMessage(
                                this.$t("label_something_went_wrong")
                            );
                        });
                }
            }
        },
        // Get all Subject from DB
        getDocumentAssignmentWise(lms_assignment_id) {
            this.files = [];
            console.log(lms_assignment_id);

            this.selectedAssignmentId = lms_assignment_id;
            this.isLoaderActive = true;

            this.$http
                .get(`web_get_all_assignment_documents`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        lms_assignment_id: lms_assignment_id,
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
                })
                .then(({ data }) => {
                    this.isLoaderActive = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        console.log(data.data);
                        this.documentItems = data.data;
                    }
                })
                .catch((error) => {
                    this.isLoaderActive = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        getFileIcon(item) {
            item.lms_assignment_document_path.split(".").slice(0, -1).join(".");
            console.log(
                item.lms_assignment_document_path
                    .split(".")
                    .slice(0, -1)
                    .join(".")
            );
        },
        resetForm() {
            this.$refs.saveAssignmentForm.reset();
            this.lms_assignment_description = null;
        },
        // Get all active course
        getAllActiveCourse() {
            this.isCourseDataLoading = true;
            this.$http
                .get(`web_get_active_course_without_pagination`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
                })
                .then(({ data }) => {
                    this.isCourseDataLoading = false;
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
                    this.isCourseDataLoading = false;
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
                            courseId: this.selectedCourseId,
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
        getAllActiveSubjectBasedonCourse() {
            this.subjectDataLoading = true;
            this.$http
                .get(
                    `web_get_all_active_subject_based_on_course_without_pagination`,
                    {
                        params: {
                            centerId: ls.get("loggedUserCenterId"),
                            courseId: this.selectedCourseId,
                        },
                        headers: { Authorization: "Bearer " + ls.get("token") },
                    }
                )
                .then(({ data }) => {
                    this.subjectDataLoading = false;
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

        // Get all active subject based on course
        getAllActiveTopicBasedonSubject() {
            this.topicDataLoading = true;
            this.$http
                .get(
                    `web_get_all_active_topic_based_on_subject_without_pagination`,
                    {
                        params: {
                            centerId: ls.get("loggedUserCenterId"),
                            selectedSubjectId: this.lms_subject_id,
                        },
                        headers: { Authorization: "Bearer " + ls.get("token") },
                    }
                )
                .then(({ data }) => {
                    this.topicDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.topicItems = data;
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
        getAllBatch() {
            this.isSourceDataLoading = true;
            this.$http
                .get(`web_get_all_batch_without_pagination`, {
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
                        this.batchItems = data;
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

        // Edit Course

        editNotice(item) {
            console.log(item);
            this.isAddCardVisible = true;
            this.lms_assignment_id = item.lms_assignment_id;
            this.isSaveEditClicked = 0;
            this.lms_assignment_title = item.lms_assignment_title;
            this.selectedCourseId = item.lms_course_id;
            this.classId = item.lms_child_course_id;
            this.getAllActiveClassBasedonStream();
            this.getAllActiveSubjectBasedonCourse();
            this.lms_assignment_description = item.lms_assignment_description;
            this.lms_batch_id = item.lms_batch_id;

            this.lms_subject_id = item.lms_subject_id;
            this.getAllActiveTopicBasedonSubject();
            this.lms_topic_id = item.lms_topic_id;

            this.selectedLiveTill =
                item.lms_assignment_submission_last_date + " 00:00:00";
            this.lms_assignment_score = item.lms_assignment_score;
        },
        // Disable Course status
        disableAssignment(item, $event) {
            let userDecision = confirm(
                "Are you sure you want to change status"
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_assignment",
                        {
                            lms_assignment_id: item.lms_assignment_id,
                            lms_assignment_upload_status:
                                item.lms_assignment_upload_status == "Active"
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
                            // Course Disabled
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    "Assignment status changed!!!"
                                );
                                this.getAllActiveAssignment(event);
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
        saveNotice($event) {
            if (this.$refs.saveAssignmentForm.validate()) {
                this.isSaveAssignmentFormDataProcessing = true;
                let postData = new FormData();
                if (this.isSaveEditClicked == 1) {
                    postData.append(
                        "lms_assignment_title",
                        this.lms_assignment_title
                    );
                    postData.append(
                        "lms_assignment_description",
                        this.lms_assignment_description
                    );
                    postData.append("lms_batch_id", this.lms_batch_id);
                    postData.append("classId", this.classId);
                    postData.append("lms_course_id", this.selectedCourseId);
                    postData.append("lms_subject_id", this.lms_subject_id);
                    postData.append("lms_topic_id", this.lms_topic_id);
                    postData.append("isSaveEditClicked", 1);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                    postData.append(
                        "lms_assignment_score",
                        this.lms_assignment_score
                    );
                    postData.append(
                        "lms_assignment_submission_last_date",
                        moment(new Date(this.selectedLiveTill)).format(
                            "YYYY-MM-DD HH:mm:ss"
                        )
                    );
                } else {
                    postData.append(
                        "lms_assignment_title",
                        this.lms_assignment_title
                    );
                    postData.append(
                        "lms_assignment_description",
                        this.lms_assignment_description
                    );
                    postData.append("classId", this.classId);
                    postData.append("lms_course_id", this.selectedCourseId);
                    postData.append("lms_batch_id", this.lms_batch_id);
                    postData.append("lms_subject_id", this.lms_subject_id);
                    postData.append("lms_topic_id", this.lms_topic_id);
                    postData.append("isSaveEditClicked", 0);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                    postData.append(
                        "lms_assignment_id",
                        this.lms_assignment_id
                    );
                    postData.append(
                        "lms_assignment_score",
                        this.lms_assignment_score
                    );
                    postData.append(
                        "lms_assignment_id",
                        this.lms_assignment_id
                    );
                    postData.append(
                        "lms_assignment_score",
                        this.lms_assignment_score
                    );
                    postData.append(
                        "lms_assignment_submission_last_date",
                        moment(new Date(this.selectedLiveTill)).format(
                            "YYYY-MM-DD HH:mm:ss"
                        )
                    );
                }
                this.$http
                    .post(
                        "web_save_update_assignment",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isSaveAssignmentFormDataProcessing = false;
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
                                this.changeSnackBarMessage("Assignment Exist");
                            }
                            // Course Saved
                            else if (data.responseData == 2) {
                                this.lms_notice_title = "";
                                this.lms_notice_description = null;
                                this.isSaveEditClicked = 1;
                                this.roleId = [];
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage("Assignment Saved");
                                this.getAllActiveAssignment(event);
                                this.resetForm();
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
                                    "Assignment Updated"
                                );
                                this.getAllActiveAssignment(event);
                                this.resetForm();
                                this.isSaveEditClicked = 0;
                                this.lms_notice_title = "";
                                this.lms_notice_description = "";
                                this.roleId = [];
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
                        this.isSaveAssignmentFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Topic from DB
        getAllActiveAssignment(e) {
            this.tableDataLoading = true;
            let postData = "";
            if (this.isSearchBySource == true) {
                postData = {
                    includeDelete: this.includeDelete,
                    centerId: ls.get("loggedUserCenterId"),
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDB
                            : e.itemsPerPage,
                    filterBy: this.txtSearchCriteria,
                };
            } else {
                postData = {
                    includeDelete: this.includeDelete,
                    centerId: ls.get("loggedUserCenterId"),
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDB
                            : e.itemsPerPage,
                    filterBy: this.txtSearchCriteria,
                };
            }
            this.$http
                .get(`web_get_all_assignment?page=${e.page}`, {
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
        // Topic Status Color
        getStatusColor(is_course_active) {
            if (is_course_active == "Submitted") return "success";
            else return "info";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    { header: "Title", dataKey: "lms_assignment_title" },
                    { header: "Subject", dataKey: "lms_subject_name" },
                    { header: "Course", dataKey: "lms_child_course_name" },
                    {
                        header: "Last Date",
                        dataKey: "lms_assignment_submission_last_date",
                    },
                    {
                        header: "Status",
                        dataKey: "lms_assignment_upload_status",
                    },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "AssignmentListAsPDF" +
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
