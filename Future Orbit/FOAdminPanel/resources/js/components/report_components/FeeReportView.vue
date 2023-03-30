<template>
  <div id="app">
    <!-- Card Start -->
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

      <v-row
        justify="space-around"
        style="margin-right: 1px !important; margin-left: -1px !important"
        class="mb-4 mt-1"
        dense
      >
        <v-card width="100%" elevation="0">
          <v-card-text>
            <v-toolbar-title dark color="primary">
              <v-list-item two-line>
                <v-list-item-content>
                  <v-list-item-title class="text-h5">
                    <strong>Fee Report</strong>
                  </v-list-item-title>
                  <v-list-item-subtitle
                    >Home <v-icon>mdi-forward</v-icon> Report
                    <v-icon>mdi-forward</v-icon> Fee
                    Report</v-list-item-subtitle
                  >
                </v-list-item-content>
              </v-list-item>
            </v-toolbar-title>
            <v-spacer></v-spacer>
          </v-card-text>
        </v-card>
      </v-row>

      <transition name="fade" mode="out-in">
        <v-data-table
          dense
          :headers="tableHeader"
          :items="dataTableRowNumbering"
          item-key="lms_exam_schedule_id"
          :loading="tableDataLoading"
          :loading-text="tableLoadingDataText"
          :server-items-length="totalItemsInDB"
          :items-per-page="200"
          @pagination="getAllExamSchedule"
          :footer-props="{
            itemsPerPageOptions: [200, 500, 1000, -1],
          }"
        >
          <template v-slot:no-data>
            <p class="font-weight-black bold title" style="color: red">
              {{ $t("label_no_data_found") }}
            </p>
          </template>

          <template v-slot:item.status="{ item }">
            <v-chip x-small :color="getStatusColor(item.status)" dark>{{
              item.status
            }}</v-chip>
          </template>

          <template v-slot:top>
            <v-toolbar flat>
              <v-text-field
                dense
                class="mt-4 mx-4"
                v-model="examSearchCriteria"
                :label="lblSearchExamCriteria"
                @input="searchTable($event)"
                prepend-inner-icon="mdi-magnify"
              ></v-text-field>

              <v-spacer></v-spacer>
              <v-btn icon small color="teal" v-if="!tableDataLoading">
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
            <v-row class="mx-4 pt-4">
              <v-col cols="12" md="3" class="mb-4 p-0">
                <v-select
                  v-model="selectedExamType"
                  :disabled="isexamTypeDataLoading"
                  :items="examTypeData"
                  class="mt-4 mx-4"
                  dense
                  :label="lblSelectExamType"
                  item-text="text"
                  item-value="value"
                  @change="
                    isSearchByExamType = true;
                    getAllExamSchedule($event);
                  "
                ></v-select>
              </v-col>
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
                      getAllExamSchedule($event);
                    "
              >
                <v-icon class="mr-2" small>mdi-magnify</v-icon> Search Fee Report
              </v-btn>
              </v-col>
            </v-row>
          </template>
          >
          <template slot="body.append">
            <tr class="success--text">
              <th class="title">Total</th>
              <th class="title">-</th>
              <th class="title">-</th>
              <th class="title">-</th>
              <th class="title">-</th>
              <th class="title">
                {{ sumField("total_amount") }}
              </th>
              <th class="title">
                {{ sumField("due_amount") }}
              </th>
              <th class="title">
                {{ sumField("lms_cash_receipt") }}
              </th>
              <th class="title">
                {{ sumField("lms_voucher_adjusted") }}
              </th>
            </tr>
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

      <!-- //Set Dialog -->
      <v-dialog v-model="dialog" hide-overlay persistent width="500">
        <v-card color="error" dark>
          <v-card-title class="headline">
            Updating Data!!! Please Wait...
          </v-card-title>

          <v-card-text>
            Your request is processing!!! I will automatically close when done.
            <v-progress-linear
              indeterminate
              color="white"
              class="mb-0"
            ></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>

      <!-- View Exam Schedule Doalig Start-->
      <v-dialog
        v-model="viewExamScheduleDialog"
        transition="dialog-bottom-transition"
        elevation="0"
        max-width="500"
      >
        <template>
          <v-card class="mt-8 mx-auto" max-width="500">
            <v-sheet
              class="v-sheet--offset mx-auto"
              color="primary"
              elevation="12"
              max-width="calc(100% - 32px)"
              height="120px"
            >
              <div>
                <div class="float-left ml-2">
                  <v-avatar class="profile mt-2" size="100" rounded>
                    <img :src="lms_exam_schedule_image" alt="" />
                  </v-avatar>
                </div>
                <div class="float-right mr-2">
                  <p class="ml-4 mt-2" style="color: white">
                    <strong>Course: &nbsp; </strong>
                    {{ lms_course_name }}
                  </p>
                  <p class="ml-4" style="color: white">
                    <strong>Instruction: &nbsp; </strong>
                    {{ lms_exam_instruction_title }}
                  </p>
                  <p class="ml-4" style="color: white">
                    <strong>Exam Type: &nbsp; </strong>
                    {{ lms_exam_schedule_type }}
                  </p>
                </div>
              </div>
            </v-sheet>

            <v-card-text class="pt-0">
              <div class="h5 text-center font-weight-light mb-2 black--text">
                <strong>Exam: &nbsp;{{ lms_exam_schedule_name }} </strong>
              </div>

              <div class="text-center">
                <strong
                  >Description: &nbsp;{{ lms_exam_schedule_description }}
                </strong>
              </div>
              <div class="mt-2">
                <div class="float-left">
                  <v-icon class="ml-2 text-center" small>mdi-calendar</v-icon
                  ><strong
                    >Start Date: &nbsp;{{ lms_exam_schedule_live_from }}
                  </strong>
                </div>

                <div class="float-right">
                  <v-icon class="ml-2 text-center" small>mdi-calendar</v-icon
                  ><strong
                    >End Date: &nbsp;{{ lms_exam_schedule_live_to }}
                  </strong>
                </div>
              </div>
              <br />

              <div class="mt-2">
                <div class="float-left">
                  <v-icon class="ml-2" small
                    >mdi-comment-question-outline</v-icon
                  ><strong
                    >Questions: &nbsp;{{ lms_exam_schedule_no_of_question }}
                  </strong>
                </div>
                <div class="float-right">
                  <v-icon class="ml-2" small>mdi-clock</v-icon
                  ><strong
                    >Total Time(m): &nbsp;{{
                      lms_exam_schedule_total_time_alloted
                    }}
                  </strong>
                </div>
              </div>
              <br />
              <div class="mt-2">
                <div class="float-left">
                  <v-icon class="ml-2 text-center" small
                    >mdi-bookmark-plus-outline</v-icon
                  ><strong
                    >Total Marks: &nbsp;{{ lms_exam_schedule_max_marks }}
                  </strong>
                </div>
                <div class="float-right">
                  <v-icon class="ml-2 text-center" small
                    >mdi-bookmark-check</v-icon
                  ><strong
                    >Pass Marks: &nbsp;{{ lms_exam_schedule_pass_marks }}
                  </strong>
                </div>
              </div>
            </v-card-text>
            <v-card-text>
              <v-divider class="my-2"></v-divider>

              <v-icon class="mr-2 text-center" small>mdi-minus-circle</v-icon>
              <span class="caption text-center"
                ><strong
                  >Negative Marking: &nbsp;{{
                    lms_exam_schedule_has_negative_marking_status
                  }}
                </strong>
              </span>
              <span>&nbsp;|</span>
              <v-icon class="ml-2 text-center" small>mdi-currency-inr</v-icon>
              <span class="caption text-center"
                ><strong
                  >Subscription: &nbsp;{{
                    lms_exam_schedule_is_free_paid_status
                  }}
                </strong>
              </span>

              <template>
                <v-chip
                  class="ml-4 float-right"
                  x-small
                  :color="getStatusColor(lms_exam_schedule_is_active_live)"
                  dark
                  ><strong>{{
                    lms_exam_schedule_is_active_live
                  }}</strong></v-chip
                >
              </template>
            </v-card-text>
          </v-card>
        </template>
      </v-dialog>
      <!-- View Exam Schedule Doalig End -->
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
import { Global } from "../helpers/global";

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
          text: this.$t("label_exam_schedule"),
          disabled: false,
        },
        {
          text: this.$t("label_exam_schedule_directory"),
          disabled: false,
        },
      ],
      date : new Date(),
      selectedStartDate: moment().startOf('month').format('YYYY-MM-DD'),
     
      selectedEndDate:moment().endOf('month').format("YYYY-MM-DD"),
      viewExamScheduleDialog: false,
      // Form Data
      lblSelectExamType: "Filter By Status",
      selectedExamType: "",
      isDataProcessing: false,
      examSearchCriteria: "",
      lblSearchExamCriteria: "Search By Student Name | Course | Reg No",
      isexamTypeDataLoading: false,
      modalStartDate: false,
      modalEndDate: false,
      examTypeData: [
        {
          value: 2,
          text: "All",
        },
        {
          value: 1,
          text: "Paid",
        },
        {
          value: 0,
          text: "Not Paid",
        },
      ],
      isSearchByExamType: false,
      authorizationConfig: "",
      dialog: false,

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
          text: "Student Name",
          value: "lms_student_full_name",
          width: "20%",
          sortable: false,
        },
        {
          text: "Receipt No",
          value: "lms_receipt_no",
          width: "10%",
          sortable: false,
        },

      
        {
          text: "Course/Class",
          value: "lms_child_course_name",
          width: "10%",
          sortable: false,
        },
        {
          text: "Month",
          value: "month",
          width: "10%",
          sortable: false,
        },

        {
          text: "Total (₹)",
          value: "total_amount",
          width: "5%",
          sortable: false,
        },
        {
          text: "Due (₹)",
          value: "due_amount",
          width: "5%",
          sortable: false,
        },

        {
          text: "Paid (₹)",
          value: "lms_cash_receipt",
          width: "5%",
          sortable: false,
        },
        {
          text: "Voucher (₹)",
          value: "lms_voucher_adjusted",
          width: "5%",
          sortable: false,
        },

        {
          text: "Due",
          value: "due_date",
          width: "10%",
          sortable: false,
        },
        {
          text: "Paid",
          value: "paid_date",
          align: "middle",
          width: "10%",
          sortable: false,
        },
        {
          text: "Status",
          value: "status",
          sortable: false,
          width: "10%",
          align: "end",
        },
      ],
      tableItems: [],
      isDataProcessing: false,

      //Datatable End

      //View props
      lms_exam_schedule_id: "",
      lms_exam_schedule_type: "",
      lms_exam_schedule_name: "",
      lms_exam_schedule_description: "",
      lms_exam_schedule_negative_marking: "",
      lms_exam_schedule_result_display_type: "",
      lms_exam_schedule_no_of_question: "",
      lms_exam_schedule_max_marks: "",
      lms_exam_schedule_total_time_alloted: "",
      lms_exam_schedule_is_free_paid_status: "",
      lms_exam_schedule_pass_marks: "",
      lms_exam_schedule_has_negative_marking_status: "",
      lms_exam_schedule_image: "",
      lms_exam_schedule_image_alt: "",
      lms_exam_instruction_title: "",
      lms_course_name: "",
      lms_topic_name: "",
      lms_subject_name: "",
      lms_exam_instruction: "",
      lms_exam_schedule_is_active_status: "",
      lms_exam_schedule_live_from: "",
      lms_exam_schedule_live_to: "",
      lms_exam_schedule_is_active_live: "",

      // For Excel Download
      excelFields: {
        StudentName: "lms_student_full_name",
        Mobile_number: "lms_student_mobile_number",
        RegistrationId: "lms_student_reg_id",
        Manual_Receipt_No: "lms_manual_receipt_no",
        "Course/Class": "lms_child_course_name",
        Month: "month",
        TotalAmount: "total_amount",
        DueAmount: "due_amount",
        PaidAmount: "lms_cash_receipt",
        DueDate: "due_date",
        PaidDate: "paid_date",
        Status: "status",
      },
      excelData: [],
      excelFileName:
        "FeesMonthlyReport" + "_" + moment().format("DD/MM/YYYY") + ".xls",
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
    this.getAllActiveExamType();
  },

  methods: {
    sumField(key) {
      // sum data in give key (property)
      return this.tableItems.reduce(
        (a, b) => parseInt(a) + (parseInt(b[key]) || 0),
        0
      );
    },
    searchTable(e) {
      clearTimeout(this._timerId);
      this._timerId = setTimeout(() => {
        this.isSearchByExamType = false;
        this.getAllExamSchedule(e);
      }, Global.SearchTimeOut);
    },
    // Get all active sources
    // getAllActiveExamType() {
    //     this.isexamTypeDataLoading = true;
    //     this.$http
    //         .get(`web_get_all_active_exam_type_without_pagination`, {
    //             params: {
    //                 centerId: ls.get("loggedUserCenterId"),
    //             },
    //             headers: { Authorization: "Bearer " + ls.get("token") },
    //         })
    //         .then(({ data }) => {
    //             this.isexamTypeDataLoading = false;
    //             //User Unauthorized
    //             if (
    //                 data.error == "Unauthorized" ||
    //                 data.permissionError == "Unauthorized"
    //             ) {
    //                 this.$store.dispatch("actionUnauthorizedLogout");
    //             } else {
    //                 this.examTypeData = data;
    //             }
    //         })
    //         .catch((error) => {
    //             this.isexamTypeDataLoading = false;
    //             this.snackBarColor = "error";
    //             this.changeSnackBarMessage(
    //                 this.$t("label_something_went_wrong")
    //             );
    //         });
    // },
    // Change Snack bar message
    changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },
    // View Staff
    viewExamSchedule(item) {
      this.lms_exam_schedule_id = item.lms_exam_schedule_id;
      this.lms_exam_schedule_type = item.lms_exam_schedule_type;
      this.lms_exam_schedule_name = item.lms_exam_schedule_name;
      this.lms_exam_schedule_description = item.lms_exam_schedule_description;
      this.lms_exam_schedule_negative_marking =
        item.lms_exam_schedule_negative_marking;
      this.lms_exam_schedule_result_display_type =
        item.lms_exam_schedule_result_display_type;
      this.lms_exam_schedule_no_of_question =
        item.lms_exam_schedule_no_of_question;
      this.lms_exam_schedule_max_marks = item.lms_exam_schedule_max_marks;
      this.lms_exam_schedule_total_time_alloted =
        item.lms_exam_schedule_total_time_alloted;
      this.lms_exam_schedule_is_free_paid_status =
        item.lms_exam_schedule_is_free_paid_status;
      this.lms_exam_schedule_pass_marks = item.lms_exam_schedule_pass_marks;
      this.lms_exam_schedule_has_negative_marking_status =
        item.lms_exam_schedule_has_negative_marking_status;
      this.lms_exam_schedule_image =
        process.env.MIX_EXAM_PROFILE_IMAGE_URL + item.lms_exam_schedule_image;
      this.lms_exam_schedule_image_alt =
        process.env.MIX_EXAM_PROFILE_IMAGE_URL + "Exams.jpg";
      this.lms_course_name = item.lms_course_name;
      this.lms_exam_instruction_title = item.lms_exam_instruction_title;
      this.lms_exam_instruction = item.lms_exam_instruction;
      this.lms_exam_schedule_is_active_status =
        item.lms_exam_schedule_is_active_status;
      this.lms_exam_schedule_live_from = item.lms_exam_schedule_live_from;
      this.lms_exam_schedule_live_to = item.lms_exam_schedule_live_to;
      this.lms_exam_schedule_is_active_live =
        item.lms_exam_schedule_is_active_live;

      this.viewExamScheduleDialog = true;
    },

    // Edit Exam Schedule
    ViewStudentDetails(item) {
      this.$router.push({
        name: "ViewStudentDetailsExamReport",
        params: { examReportDataProps: item },
      });
    },

    // Get all Staff from DB
    getAllExamSchedule(e) {
      this.tableDataLoading = true;
      let postData = "";
      if (this.isSearchByExamType == true) {
        postData = {
          centerId: ls.get("loggedUserCenterId"),
          perPage: e.itemsPerPage == -1 ? this.totalItemsInDB : e.itemsPerPage,
          isPaid: this.selectedExamType,
          startDate: this.selectedStartDate,
          endDate: this.selectedEndDate,
        };
      } else {
        postData = {
          centerId: ls.get("loggedUserCenterId"),
          perPage: e.itemsPerPage == -1 ? this.totalItemsInDB : e.itemsPerPage,
          filterBy: this.examSearchCriteria,
          startDate: this.selectedStartDate,
          endDate: this.selectedEndDate,
        };
      }

      this.$http
        .get(`web_generate_monthly_fee_report?page=${e.page}`, {
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
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Source Status Color
    getStatusColor(status) {
      if (status == "Paid") return "success";
      if (status == "Not Paid") return "error";
      else return "primary";
    },
    // Export to PDF
    savePDF() {
      const pdfDoc = new jsPDF({ orientation: "landscape" });

      pdfDoc.autoTable({
        columns: [
          { header: "StudentName", dataKey: "lms_student_full_name" },
          { header: "RegistrationId", dataKey: "lms_student_reg_id" },

          {
            header: "Mobile_number",
            dataKey: "lms_student_mobile_number",
          },
          {
            header: "Manual_Receipt_No",
            dataKey: "lms_manual_receipt_no",
          },
          {
            header: "Course/Class",
            dataKey: "lms_child_course_name",
          },
          { header: "Month", dataKey: "month" },
          { header: "Fee", dataKey: "lms_actual_fee" },
          { header: "DueDate", dataKey: "due_date" },
          { header: "PaidDate", dataKey: "paid_date" },
          { header: "Status", dataKey: "status" },
          { header: "TotalAmount", dataKey: "total_amount" },
          { header: "DueAmount", dataKey: "due_amount" },
          { header: "PaidAmount", dataKey: "lms_cash_receipt" },
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 },
      });
      pdfDoc.save("FeeReport" + "_" + moment().format("DD/MM/YYYY") + ".pdf");
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

.v-sheet--offset {
  top: -24px;
  position: relative;
}
.v-data-table > .v-data-table__wrapper > table > tbody > tr > td,
.v-data-table > .v-data-table__wrapper > table > tbody > tr > th,
.v-data-table > .v-data-table__wrapper > table > tfoot > tr > td,
.v-data-table > .v-data-table__wrapper > table > tfoot > tr > th,
.v-data-table > .v-data-table__wrapper > table > thead > tr > td,
.v-data-table > .v-data-table__wrapper > table > thead > tr > th {
  padding: 0 2px !important;
}
</style>
