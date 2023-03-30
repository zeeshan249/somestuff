<template>
  <div  id="app">
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
        style="margin-right: 1px !important; margin-left: -1px !important"
        class="mb-4 mt-1"
        dense
        >
        <v-toolbar-title dark color="primary">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h5">
                <strong>Attendance Report</strong>
              </v-list-item-title>
              <v-list-item-subtitle
                >Home <v-icon>mdi-forward</v-icon> Report
                <v-icon>mdi-forward</v-icon>
                Attendance Report</v-list-item-subtitle
              >
            </v-list-item-content>
          </v-list-item>
        </v-toolbar-title>
        <v-spacer></v-spacer>
      </v-row>
    </v-sheet>

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
            :items-per-page="50"
            @pagination="getAllBatch"
            show-expand
            :expanded.sync="expanded"
            :single-expand="singleExpand"
            :footer-props="{
              itemsPerPageOptions: [25, 50, 100, 200, -1],
            }"
          >
            <template
              v-slot:item.data-table-expand="{ item, isExpanded, expand }"
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
                    <p class="font-weight-black bold title" style="color: red">
                      No Student Found
                    </p>
                  </template>
                </v-data-table>
              </td>
            </template>
            <template v-slot:no-data>
              <p class="font-weight-black bold title" style="color: red">
                {{ $t("label_no_data_found") }}
              </p>
            </template>
            <template v-slot:item.lms_batch_is_active="{ item }">
              <v-chip
                x-small
                :color="getStatusColor(item.lms_batch_is_active)"
                dark
                >{{ item.lms_batch_is_active }}</v-chip
              >
            </template>
            <template v-slot:top>
              <v-toolbar flat>
                <v-text-field
                  class="mt-4"
                  label="Search"
                  prepend-inner-icon="mdi-magnify"
                  @input="searchBatch"
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
             
              <v-row class="mx-4 pt-4">
              <v-col cols="12" md="3">
                <v-dialog
                  ref="dialogStartDate"
                  v-model="modalStartDate"
                  :return-value.sync="selectedStartDate"
                  persistent
                  width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      class="ml-5"
                      dense
                      v-model="selectedStartDate"
                      prepend-inner-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                      :rules="[(v) => !!v || $t('label_required')]"
                    >
                      <template #label>
                        Start Date
                        <span class="red--text">
                          <strong>{{ $t("label_star") }}</strong>
                        </span>
                      </template>
                    </v-text-field>
                  </template>
                  <v-date-picker v-model="selectedStartDate" scrollable>
                    <v-spacer></v-spacer>
                    <v-btn
                      text
                      color="primary"
                      @click="modalStartDate = false"
                      >{{ $t("label_cancel") }}</v-btn
                    >
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.dialogStartDate.save(selectedStartDate)"
                      >{{ $t("label_ok") }}</v-btn
                    >
                  </v-date-picker>
                </v-dialog>
              </v-col>

              <v-col cols="12" md="3">
                <v-dialog
                  ref="dialogEndDate"
                  v-model="modalEndDate"
                  :return-value.sync="selectedEndDate"
                  width="290px"
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      class="ml-5"
                      dense
                      v-model="selectedEndDate"
                      prepend-inner-icon="mdi-calendar"
                      readonly
                      v-bind="attrs"
                      v-on="on"
                    >
                      <template #label>End Date</template>
                    </v-text-field>
                  </template>
                  <v-date-picker
                    v-model="selectedEndDate"
                    scrollable
                
                  >
                    <v-spacer></v-spacer>
                    <v-btn text color="primary" @click="modalEndDate = false">{{
                      $t("label_cancel")
                    }}</v-btn>
                    <v-btn
                      text
                      color="primary"
                      @click="$refs.dialogEndDate.save(selectedEndDate)"
                      >{{ $t("label_ok") }}</v-btn
                    >
                  </v-date-picker>
                </v-dialog>
         
              </v-col>

              <v-col cols="12" md="3">
                <v-btn
                class="ma-0"
                outlined
                color="indigo"
                rounded
                small
                @click="
                      isSearchByExamType = true;
                      getAllBatch($event);
                    "
              >
                <v-icon class="mr-2" small>mdi-magnify</v-icon> Search Attendance Report
              </v-btn>
              </v-col>
            </v-row>

            </template>

            <template v-slot:item.actions="{ item }">
              <v-icon
                small
                v-if="item.lms_batch_is_active == 'Active'"
                v-permission="'Edit Subject'"
                color="primary"
                @click="viewAttendance(item)"
                >mdi-eye-outline</v-icon
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
      includeDelete: false,
      subjectDataLoading: false,
      expanded: [],
      singleExpand: true,

      searchBatch: "",
      isLoaderActive: false,
      lms_batch_name: "",
      lms_batch_code: "",

      lms_course_id: "",
      subjectName: "",

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
      selectedStartDate: moment().startOf('month').format('YYYY-MM-DD'),
      selectedEndDate:moment().endOf('month').format("YYYY-MM-DD"),
      modalStartDate: false,
      modalEndDate: false,
      tableLoadingDataText: this.$t("label_loading_data"),
      tableItemsBatchWiseStudent: [],
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
          width: "15%",
          sortable: false,
        },
        {
          text: "End Date",
          value: "lms_batch_end_date_edit",
          width: "15%",
          sortable: false,
        },
        {
          text: "Total Attendance",
          value: "totalAttendance",
          width: "15%",
          sortable: false,
          align: "center"
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
          width: "10%",
          align: "end",
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
        batch_code: "lms_batch_code",
        lms_batch_name: "lms_batch_name",
        lms_course_name: "lms_course_name",
        lms_batch_start_date_edit: "lms_batch_start_date_edit",
        lms_batch_end_date_edit: "lms_batch_end_date_edit",
        Total_Attendance: "totalAttendance",
        Status: "lms_batch_is_active"
      },
      excelData: [],
      excelFileName:
        "AttendanceReport" + "_" + moment().format("DD/MM/YYYY") + ".xls",
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
    dataTableRowNumberingStudent() {
      return this.tableItemsBatchWiseStudent.map((items, index) => ({
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
            this.tableItemsBatchWiseStudent = data;
          }
        })
        .catch((error) => {
          this.tableDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Change Snack bar message
    changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },

    // Get all Subject from DB
    getAllBatch(e) {
      this.tableDataLoading = true;

      this.$http
        .get(`web_get_all_batch_attendance?page=${e.page}`, {
          params: {
            includeDelete: this.includeDelete,
            centerId: ls.get("loggedUserCenterId"),
            startDate:this.selectedStartDate,
            endDate:this.selectedEndDate,
            perPage:
              e.itemsPerPage == -1 ? this.totalItemsInDB : e.itemsPerPage,
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
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
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
          { header: "batch_code", dataKey: "lms_batch_code" },
          {
            header: "lms_batch_name",
            dataKey: "lms_batch_name",
          },
          { header: "Course Name", dataKey: "lms_course_name" },
          {
            header: "lms_course_name",
            dataKey: "lms_course_name",
          },
          {
            header: "lms_batch_start_date_edit",
            dataKey: "lms_batch_start_date_edit",
          },
          {
            header: "lms_batch_end_date_edit",
            dataKey: "lms_batch_end_date_edit",
          },
          {
            header: "Total_Attendance",
            dataKey: "totalAttendance",
          },
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
      pdfDoc.save("Attendance" + "_" + moment().format("DD/MM/YYYY") + ".pdf");
    },

    viewAttendance(item) {
      this.$router.push({
        name: "AttendanceView",
        params: { attendanceDataProps: item ,
        startDate:this.selectedStartDate,
        endDate:this.selectedEndDate
        },
      });
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
