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
                                    <strong>Batch Creation</strong>
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    >Home <v-icon>mdi-forward</v-icon> Academic
                                    <v-icon>mdi-forward</v-icon> Batch
                                    Creation</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-if="!isAddCardVisible"
                        :disabled="tableDataLoading"
                        color="primary"
                        class="white--text"
                        @click="isAddCardVisible = !isAddCardVisible"
                    >
                        Launch New Batch
                        <v-icon right dark> mdi-plus </v-icon>
                    </v-btn>
                </v-row>
            </v-sheet>
            <transition name="fade" mode="out-in">
                <v-col v-if="isAddCardVisible">
                    <v-card class="mx-auto">
                        <v-app-bar dark color="primary">
                            <v-toolbar-title color="success">{{
                                $t("label_batch")
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

                        <v-form
                            ref="saveBatchForm"
                            v-model="issaveBatchFormValid"
                            lazy-validation
                        >
                            <v-row dense class="mx-auto mt-4">
                                <v-col cols="12" md="4" sm="12" class="px-2">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="lms_course_id"
                                        :items="courseItems"
                                        :disabled="isSourceDataLoading"
                                        item-text="lms_course_name"
                                        item-value="lms_course_id"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                        @change="
                                            getAllActiveSubjectBasedonCourse(
                                                this
                                            );
                                            getAllActiveChildCourse(this);
                                        "
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
                                <v-col cols="12" md="4" sm="12" class="px-2">
                                    <v-select
                                        outlined
                                        dense
                                        v-model="lms_child_course_id"
                                        :items="childCourseItems"
                                        :disabled="isSourceDataLoading"
                                        item-text="lms_child_course_name"
                                        item-value="lms_child_course_id"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_child_course") }}
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
                                    md="4"
                                    class="px-2"
                                >
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="lms_batch_name"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_batch_title") }}
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
                                    class="px-2"
                                >
                                    <template>
                                        <v-datetime-picker
                                            label="Start Date"
                                            v-model="lms_batch_start_date"
                                            outlined
                                            :time-picker-props="timeProps"
                                            time-format="HH:mm:ss"
                                            date-format="yyyy-MM-dd"
                                            :text-field-props="textFieldProps"
                                        >
                                        </v-datetime-picker>
                                    </template>
                                </v-col>
                                <v-col
                                    cols="12"
                                    xs="12"
                                    sm="12"
                                    md="6"
                                    class="px-2"
                                >
                                    <template>
                                        <v-datetime-picker
                                            label="End Date"
                                            v-model="lms_batch_end_date"
                                            outlined
                                            :time-picker-props="timeProps"
                                            time-format="HH:mm:ss"
                                            date-format="yyyy-MM-dd"
                                            :text-field-props="textFieldProps"
                                        >
                                        </v-datetime-picker>
                                    </template>
                                </v-col>
                                <v-col
                                    cols="12"
                                    xs="12"
                                    sm="12"
                                    md="6"
                                    class="px-2"
                                    v-if="false"
                                >
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="lms_batch_code"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_batch_code") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                            </v-row>
                            <v-app-bar
                                color="grey"
                                elevation="0"
                                dark
                                height="60"
                            >
                                <v-toolbar-title color="success">
                                    Add Class Timing</v-toolbar-title
                                >
                                <v-spacer></v-spacer>
                                <v-btn
                                    @click="addSlot"
                                    :disabled="tableDataLoading"
                                    color="success"
                                    class="white--text"
                                >
                                    Add Class
                                    <v-icon right dark> mdi-plus </v-icon>
                                </v-btn>
                            </v-app-bar>

                            <v-row
                                v-for="(slot, index) in slotDetails"
                                :key="index"
                                class="work-experiences mx-auto mt-4"
                                cols="12"
                            >
                                <v-col cols="12" md="2">
                                    <v-text-field
                                        v-mask="`##:##`"
                                        dense
                                        v-model="slot.lms_batch_slot_start_time"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_batch_start_time") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-text-field
                                        v-mask="`##:##`"
                                        dense
                                        v-model="slot.lms_batch_slot_end_time"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        <template #label>
                                            {{ $t("label_batch_end_time") }}
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-select
                                        dense
                                        label="Day"
                                        v-model="slot.lms_batch_slot_day"
                                        :items="dayItems"
                                        :disabled="isSourceDataLoading"
                                        item-text="day"
                                        item-value="lms_batch_slot_day"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                    </v-select>
                                </v-col>
                                <v-col cols="12" md="3">
                                    <v-select
                                        dense
                                        label="Subject"
                                        v-model="slot.lms_subject_id"
                                        :items="subjectItems"
                                        :disabled="subjectDataLoading"
                                        item-text="lms_subject_name"
                                        item-value="lms_subject_id"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                    </v-select>
                                </v-col>
                                <v-col cols="12" md="2">
                                    <v-select
                                        dense
                                        label="Faculty"
                                        v-model="slot.lms_user_id"
                                        :items="facultiesItems"
                                        :disabled="isSourceDataLoading"
                                        item-text="lms_staff_full_name"
                                        item-value="lms_user_id"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                    </v-select>
                                </v-col>
                                <v-col cols="12" md="1">
                                    <v-btn
                                        icon
                                        color="error"
                                        @click="
                                            remove(
                                                index,
                                                slot.lms_batch_slot_id
                                            )
                                        "
                                        v-show="
                                            index ||
                                            (!index && slotDetails.length > 1)
                                        "
                                        ><v-icon dark>
                                            mdi-minus-circle
                                        </v-icon></v-btn
                                    >
                                </v-col>
                            </v-row>
                            <v-row dense>
                                <v-col
                                    cols="12"
                                    xs="12"
                                    sm="12"
                                    md="12"
                                    class="px-2 text-center"
                                >
                                    <v-btn
                                        class="ma-2 rounded"
                                        tile
                                        color="primary"
                                        :disabled="
                                            !issaveBatchFormValid ||
                                            issaveBatchFormDataProcessing
                                        "
                                        @click="saveBatch"
                                        >{{
                                            issaveBatchFormDataProcessing ==
                                            true
                                                ? $t("label_processing")
                                                : $t("label_save")
                                        }}</v-btn
                                    >

                                    <v-btn
                                        class="ma-2 rounded"
                                        tile
                                        color="error"
                                        :disabled="
                                            !issaveBatchFormValid ||
                                            issaveBatchFormDataProcessing
                                        "
                                        @click="resetForm"
                                        >Reset</v-btn
                                    >
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card>
                </v-col>
            </transition>
            <!-- Card End -->

            <transition name="fade" mode="out-in">
                <v-card>
                    <v-data-table
                        dense
                        :headers="tableHeader"
                        :items="dataTableRowNumbering"
                        item-key="lms_batch_id"
                        class="elevation-1"
                        :loading="tableDataLoading"
                        :loading-text="tableLoadingDataText"
                        :server-items-length="totalItemsInDB"
                        :items-per-page="100"
                        @pagination="getAllBatch"
                        show-expand
                        :expanded.sync="expanded"
                        :single-expand="singleExpand"
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
                                    getAllStudentBatchWise(item);
                                "
                                v-if="!isExpanded"
                                size="22"
                                class="mr-2"
                                color="success"
                                >mdi-arrow-down-circle-outline</v-icon
                            >
                        </template>
                        <template v-slot:expanded-item="{ headers, item }">
                            <td :colspan="headers.length" class="pa-4">
                                <v-data-table
                                    dense
                                    :headers="tableHeaderStudent"
                                    :items="dataTableRowNumberingStudent"
                                    item-key="lms_registration_id"
                                    class="elevation-0"
                                    :loading-text="tableLoadingDataText"
                                    hide-default-footer
                                >
                                    <template v-slot:no-data>
                                        <p
                                            class="font-weight-black bold title"
                                            style="color: red"
                                        >
                                            No Student Found
                                        </p>
                                    </template>
                                </v-data-table>
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
                        <template v-slot:item.lms_batch_is_active="{ item }">
                            <v-chip
                                x-small
                                :color="
                                    getStatusColor(item.lms_batch_is_active)
                                "
                                dark
                                >{{ item.lms_batch_is_active }}</v-chip
                            >
                        </template>
                        <template v-slot:top>
                            <v-toolbar flat>
                                <v-text-field
                                v-model="searchBatch"  
                                class="mt-4"
                                    label="Search"
                                    prepend-inner-icon="mdi-magnify"
                                    @input="getAllBatch($event)"
                                ></v-text-field>
                                <v-spacer></v-spacer>
                                <v-spacer></v-spacer>

                                <v-switch
                                    class="pt-4 mx-1"
                                    v-if="!tableDataLoading"
                                    inset
                                    v-model="includeDelete"
                                    @change="getAllBatch"
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
                            </v-toolbar>
                        </template>

                        <template v-slot:item.actions="{ item }">
                            <v-icon
                                small
                                class="mr-2"
                                @click="assignStudentToBatch(item)"
                                color="primary"
                                >mdi-account-plus</v-icon
                            >
                            <v-icon
                                small
                                class="mr-2"
                                @click="batchSlotDetails(item)"
                                color="primary"
                                >mdi-format-align-bottom</v-icon
                            >
                            <v-icon
                                small
                                class="mr-2"
                                @click="editBatch(item)"
                                color="primary"
                                >mdi-lead-pencil</v-icon
                            >

                            <v-icon
                                small
                                v-if="item.lms_batch_is_active == 'Active'"
                                v-permission="'Edit Subject'"
                                color="error"
                                @click="disableBatch(item)"
                                >mdi-delete</v-icon
                            >
                            <v-icon
                                small
                                v-if="item.lms_batch_is_active == 'Inactive'"
                                v-permission="'Edit Subject'"
                                color="success"
                                @click="disableBatch(item)"
                                >mdi-check-circle</v-icon
                            >
                        </template>
                    </v-data-table>
                </v-card>
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

            <!-- Dialog Start -->
            <v-dialog
                v-model="dialogBatchDetails"
                fullscreen
                hide-overlay
                transition="dialog-bottom-transition"
            >
                <v-card>
                    <v-card-title class="text-h5 grey lighten-2">
                        Details of {{ batchDetails }}
                    </v-card-title>

                    <v-card-text>
                        <v-data-table
                            dense
                            :headers="tableHeaderBatchSlotDetails"
                            :items="dataTableRowNumberingBatchSlotDetails"
                            item-key="lms_batch_slot_id"
                            :loading="tableDataLoading"
                            :loading-text="tableLoadingDataText"
                            :server-items-length="totalItemsInDB"
                            :items-per-page="15"
                            :footer-props="{
                                itemsPerPageOptions: [15, 25, 50, -1],
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
                                v-slot:item.lms_batch_slot_is_active="{ item }"
                            >
                                <v-chip
                                    x-small
                                    :color="
                                        getStatusColor(
                                            item.lms_batch_slot_is_active
                                        )
                                    "
                                    dark
                                    >{{ item.lms_batch_slot_is_active }}</v-chip
                                >
                            </template>
                        </v-data-table>
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="primary"
                            text
                            @click="dialogBatchDetails = false"
                        >
                            Close
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!-- Dialog End -->
        </v-container>
    </div>
</template>
<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });
import DatetimePicker from "vuetify-datetime-picker";
//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";
import Vue from "vue";
import { createLogger } from "vuex";
Vue.use(DatetimePicker);

import VueMask from "v-mask";
Vue.use(VueMask);

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
                    text: this.$t("label_accounts"),
                    disabled: false,
                },
                {
                    text: this.$t("label_subscription"),
                    disabled: false,
                },
            ],
            dayItems: [
                {
                    day: "Sunday",
                    lms_batch_slot_day: 1,
                },
                {
                    day: "Monday",
                    lms_batch_slot_day: 2,
                },
                {
                    day: "Tuesday",
                    lms_batch_slot_day: 3,
                },
                {
                    day: "Wednesday",
                    lms_batch_slot_day: 4,
                },
                {
                    day: "Thursday",
                    lms_batch_slot_day: 5,
                },
                {
                    day: "Friday",
                    lms_batch_slot_day: 6,
                },
                {
                    day: "Saturday",
                    lms_batch_slot_day: 7,
                },
            ],
            lms_child_course_id: null,
            childCourseItems: [],
            expanded: [],
            singleExpand: true,
            includeDelete: false,
            dialogBatchDetails: false,
            batchDetails: "",
            startTimeMenu: false,
            endTimeMenu: false,
            startDate: "",
            endDate: "",
            subjectDataLoading: false,

            timeProps: { useSeconds: true },
            textFieldProps: {
                outlined: true,
                dense: true,
                prependInnerIcon: "mdi-calendar",
            },

            searchBatch: "",
            isLoaderActive: false,
            lms_batch_name: "",
            lms_exam_card_payment_month_duration: "",
            lms_batch_code: "",

            lms_course_id: "",
            subjectName: "",
            lms_batch_start_date: "",
            lms_batch_end_date: "",

            issaveBatchFormValid: true,
            issaveBatchFormDataProcessing: false,

            authorizationConfig: "",
            tableItems: [],
            isSaveEditClicked: 1,
            lms_batch_id: "",
            courseImageNameForEdit: "",

            courseItems: [],
            facultiesItems: [],
            lms_user_id: "",
            // For Add Department card
            isAddCardVisible: false,
            subjectItems: [],
            lms_subject_id: "",

            // Snack Bar

            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",

            //   Datatable Start

            tableDataLoading: false,
            totalItemsInDB: 0,
            tableLoadingDataText: this.$t("label_loading_data"),

            tableHeaderBatchSlotDetails: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: "Subject Name",
                    value: "lms_subject_name",
                    width: "20%",
                    sortable: false,
                    align: "start",
                },

                {
                    text: "Start Time",
                    value: "lms_batch_slot_start_time",
                    width: "10%",
                    sortable: false,
                    align: "end",
                },
                {
                    text: "End Time",
                    value: "lms_batch_slot_end_time",
                    width: "10%",
                    sortable: false,
                    align: "end",
                },
                {
                    text: "Day",
                    value: "lms_batch_slot_day_text",
                    width: "10%",
                    sortable: false,
                    align: "end",
                },
                {
                    text: "Faculty",
                    value: "lms_staff_full_name",
                    width: "15%",
                    sortable: false,
                    align: "center",
                },
                {
                    text: "Mobile",
                    value: "lms_staff_mobile_number",
                    width: "10%",
                    sortable: false,
                    align: "center",
                },
                {
                    text: "Status",
                    value: "lms_batch_slot_is_active",
                    width: "10%",
                    sortable: false,
                    align: "end",
                },
            ],

            tableHeaderStudent: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: "Student Name",
                    value: "lms_student_full_name",
                    width: "35%",
                    sortable: false,
                    align: "start",
                },
                {
                    text: "Student Code",
                    value: "lms_student_code",
                    width: "20%",
                    sortable: false,
                    align: "center",
                },
                {
                    text: "Registration Code",
                    value: "lms_registration_code",
                    width: "20%",
                    sortable: false,
                    align: "center",
                },

                {
                    text: "Start Date",
                    value: "lms_batch_mapping_date",
                    width: "20%",
                    sortable: false,
                    align: "end",
                },
            ],
            tableHeader: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: "Batch Code",
                    value: "lms_batch_code",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Name",
                    value: "lms_batch_name",
                    width: "25%",
                    sortable: false,
                },
                {
                    text: "Stream",
                    value: "lms_course_name",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Start Date",
                    value: "lms_batch_start_date_edit",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "End Date",
                    value: "lms_batch_end_date_edit",
                    width: "10%",
                    sortable: false,
                },

                {
                    text: this.$t("label_status"),
                    value: "lms_batch_is_active",
                    align: "middle",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "20%",
                    align: "Centre",
                },
                {
                    text: "Students",
                    value: "data-table-expand",
                    width: "10%",
                    sortable: false,
                    align: "center",
                },
            ],

            // For Excel Download
            excelFields: {
                Subscription: "lms_batch_name",
                Duration: "lms_exam_card_payment_month_duration",
                "Course Name": "lms_course_name",
                Status: "lms_batch_is_active",
            },
            excelData: [],
            excelFileName:
                "Subscription" + "_" + moment().format("DD/MM/YYYY") + ".xls",

            slotDetails: [
                {
                    lms_batch_slot_id: null,
                    lms_batch_slot_start_time: "17:00",
                    lms_batch_slot_end_time: "21:00",
                    lms_batch_slot_day: 1,
                    lms_user_id: 2,
                    lms_subject_id: 1,
                },
            ],
            tableItemsBatchWiseStudent: [],
            tableItemsBatchSlotDetails: [],
        };
    },
    watch: {
        selectedCourseImage(val) {
            this.selectedCourseImage = val;

            this.imageRule =
                this.selectedCourseImage != null
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
        // For numbering the Data Table Rows
        dataTableRowNumberingStudent() {
            return this.tableItemsBatchWiseStudent.map((items, index) => ({
                ...items,
                index: index + 1,
            }));
        },

        // For numbering the Data Table Rows
        dataTableRowNumberingBatchSlotDetails() {
            return this.tableItemsBatchSlotDetails.map((items, index) => ({
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
        this.getAllActiveCourses();
        this.getAllActiveFaculties();
    },

    methods: {
        resetForm() {
            this.$refs.saveBatchForm.reset();
            this.isSaveEditClicked = 1;
            this.slotDetails = [
                {
                    lms_batch_slot_id: null,
                    lms_batch_slot_start_time: "11:00",
                    lms_batch_slot_end_time: "13:00",
                    lms_batch_slot_day: 1,
                    lms_user_id: 2,
                    lms_subject_id: 1,
                },
            ];
        },

        remove(index, lms_batch_slot_id) {
            if (this.isSaveEditClicked == 0) {
                console.log(lms_batch_slot_id);
                this.disableSlot(lms_batch_slot_id);
                this.slotDetails.splice(index, 1);
            } else {
                this.slotDetails.splice(index, 1);
            }
        },
        addSlot() {
            this.slotDetails.push({
                lms_batch_slot_id: null,
                lms_batch_slot_start_time: "",
                lms_batch_slot_end_time: "",
                lms_batch_slot_day: "",
                lms_user_id: "",
            });
        },
        //get all data including deleted data

        // Get all active faculties
        getAllActiveFaculties() {
            this.isSourceDataLoading = true;
            this.$http
                .get(`web_get_all_active_faculties_without_pagination`, {
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
                        this.facultiesItems = data;
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

        editBatch(item) {
            this.isSaveEditClicked = 0;
            this.isAddCardVisible = true;
            this.lms_batch_id = item.lms_batch_id;
            this.lms_course_id = item.lms_course_id;
            this.getAllActiveSubjectBasedonCourse(item.lms_course_id);
            this.getAllActiveChildCourse();
            this.lms_batch_name = item.lms_batch_name;
            this.lms_batch_start_date = item.lms_batch_start_date;
            this.lms_batch_end_date = item.lms_batch_end_date;
            this.lms_batch_code = item.lms_batch_code;
            this.getSlotDetailsByBatchId(item.lms_batch_id);
            this.lms_child_course_id = item.lms_child_course_id;
        },
        //Assign Student to batch
        assignStudentToBatch(item) {
            this.$router.push({
                name: "BatchTransfer",
                params: { batchTransferDataProps: item },
            });
        },
        //BatchSlotDetails
        batchSlotDetails(item) {
            this.dialogBatchDetails = true;
            this.getAllBatchWiseSlotDetails(item.lms_batch_id);
            this.batchDetails =
                item.lms_course_name +
                " of Batch: " +
                item.lms_batch_code +
                " - " +
                item.lms_batch_name;
            this.lms_batch_id = item.lms_batch_id;
        },
        // Get all active sources
        getSlotDetailsByBatchId(lms_batch_id) {
            this.isSourceDataLoading = true;
            this.$http
                .get(`web_get_slot_details_by_Batch_without_pagination`, {
                    params: {
                        lms_batch_id: lms_batch_id,
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
                        this.slotDetails = data;
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
        // Disable Slot
        disableSlot(lms_batch_slot_id) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_slot")
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_disable_slot",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            lms_batch_slot_id: lms_batch_slot_id,
                            lms_batch_slot_is_active: 0,
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
                                    this.$t("label_batch_status_changed")
                                );
                                this.getAllBatch(event);
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

        // Disable batch status
        disableBatch(item, $event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_batch")
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_batch",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            lms_batch_id: item.lms_batch_id,
                            lms_batch_is_active:
                                item.lms_batch_is_active == "Active" ? 0 : 1,
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
                                    this.$t("label_batch_status_changed")
                                );
                                this.getAllBatch(event);
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
        // Get all active subject based on course
        getAllActiveSubjectBasedonCourse(src) {
            console.log("Username: " + this.lms_course_id.text);
            this.subjectDataLoading = true;
            this.$http
                .get(
                    `web_get_all_active_subject_based_on_course_without_pagination`,
                    {
                        params: {
                            centerId: ls.get("loggedUserCenterId"),
                            courseId: this.lms_course_id,
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

        // Get all active child course based on course
        getAllActiveChildCourse() {
            this.subjectDataLoading = true;
            this.$http
                .get(`web_get_all_active_child_course_wp`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        courseId: this.lms_course_id,
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
                })
                .then(({ data }) => {
                    this.subjectDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.childCourseItems = data;
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
        // Save Subject To DB after validation
        saveBatch($event) {
            if (this.$refs.saveBatchForm.validate()) {
                this.issaveBatchFormDataProcessing = true;
                let postData = new FormData();
                if (this.isSaveEditClicked == 1) {
                    postData.append("lms_batch_code", this.lms_batch_code);
                    postData.append("lms_batch_name", this.lms_batch_name);
                    postData.append("lms_course_id", this.lms_course_id);
                    postData.append(
                        "lms_child_course_id",
                        this.lms_child_course_id
                    );

                    postData.append(
                        "lms_batch_start_date",
                        moment(new Date(this.lms_batch_start_date)).format(
                            "YYYY-MM-DD HH:mm:ss"
                        )
                    );
                    postData.append(
                        "lms_batch_end_date",
                        moment(new Date(this.lms_batch_end_date)).format(
                            "YYYY-MM-DD HH:mm:ss"
                        )
                    );

                    postData.append(
                        "slotDetails",
                        JSON.stringify(this.slotDetails, null, 2)
                    );
                    postData.append("isSaveEditClicked", 1);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                } else {
                    //Edit
                    postData.append("lms_batch_id", this.lms_batch_id);
                    postData.append("lms_batch_code", this.lms_batch_code);
                    postData.append("lms_batch_name", this.lms_batch_name);
                    postData.append("lms_course_id", this.lms_course_id);
                    postData.append(
                        "lms_child_course_id",
                        this.lms_child_course_id
                    );
                    postData.append(
                        "lms_batch_start_date",
                        moment(new Date(this.lms_batch_start_date)).format(
                            "YYYY-MM-DD HH:mm:ss"
                        )
                    );
                    postData.append(
                        "lms_batch_end_date",
                        moment(new Date(this.lms_batch_end_date)).format(
                            "YYYY-MM-DD HH:mm:ss"
                        )
                    );
                    postData.append(
                        "slotDetails",
                        JSON.stringify(this.slotDetails, null, 2)
                    );
                    postData.append("isSaveEditClicked", 0);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                }
                this.$http
                    .post(
                        "web_save_update_batch",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.issaveBatchFormDataProcessing = false;
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
                                    this.$t("label_batch_exists")
                                );
                            }
                            // Course Saved
                            else if (data.responseData == 2) {
                                this.$refs.saveBatchForm.reset();
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_batch_saved")
                                );
                                this.getAllBatch(event);
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
                                    this.$t("label_batch_updated")
                                );
                                this.getAllBatch(event);
                                this.isSaveEditClicked = 1;
                                this.$refs.saveBatchForm.reset();
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
                        this.issaveBatchFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Subject from DB
        getAllBatch(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_batch?page=${e.page}`, {
                    params: {
                        includeDelete: this.includeDelete,
                        searchText: this.searchBatch,
                        centerId: ls.get("loggedUserCenterId"),
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
        // Get all Subject from DB
        getAllBatchWiseSlotDetails(batchId) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_batch_wise_slot_details`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        batchId: batchId,
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
                        this.tableItemsBatchSlotDetails = data.data;
                        console.log(data.data);
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
        // Get all Subject from DB
        getAllStudentBatchWise(item) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_get_all_student_batch_wise`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        lms_batch_id: item.lms_batch_id,
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
                        console.log(data);
                        this.tableItemsBatchWiseStudent = data;
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
                    { header: "Subscription", dataKey: "lms_batch_name" },
                    {
                        header: "Duration",
                        dataKey: "lms_exam_card_payment_month_duration",
                    },
                    { header: "Course Name", dataKey: "lms_course_name" },
                    {
                        header: "Status",
                        dataKey: "lms_batch_is_active",
                    },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save("Batch" + "_" + moment().format("DD/MM/YYYY") + ".pdf");
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

.fluid-background {
    background-color: blue;
}

.work-experiences > div {
    margin: 2px 0;
    padding-bottom: 2px;
}
.work-experiences > div:not(:last-child) {
    border-bottom: 0px solid rgb(206, 212, 218);
}
</style>
