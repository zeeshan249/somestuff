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
      <v-row class="ml-4 mr-4 pt-4">
        <v-toolbar-title dark color="primary">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h5">
                <strong>Student Batch Transfer</strong>
              </v-list-item-title>
              <v-list-item-subtitle
                >Home <v-icon>mdi-forward</v-icon> Academic
                <v-icon>mdi-forward</v-icon> Batch
                <v-icon>mdi-forward</v-icon> Batch
                Transfer</v-list-item-subtitle
              >
            </v-list-item-content>
          </v-list-item>
        </v-toolbar-title>
        <v-spacer></v-spacer>
         <v-btn
          :disabled="tableDataLoading"
          color="primary"
          class="white--text"
         @click="backToBatch()"
        ><v-icon left dark> mdi-arrow-left </v-icon>
          Back to Batch

        </v-btn>
      </v-row>
</v-sheet>
      <transition name="fade" mode="out-in">
        <v-card>
          <span class="text-button font-weight-medium mx-4 text--primary">
            Course<v-icon class="primary--text">mdi-chevron-right</v-icon> {{ lms_course_name }}
          </span>
          <span class="text-button font-weight-medium mx-4">
            Batch<v-icon class="primary--text">mdi-chevron-right</v-icon> {{ lms_batch_code }}
          </span>
          <v-data-table
            dense
            :headers="tableHeader"
            :items="dataTableRowNumbering"
            item-key="lms_registration_id"
            class="elevation-1"
            :loading="tableDataLoading"
            :loading-text="tableLoadingDataText"
            :server-items-length="totalItemsInDB"
            :items-per-page="50"
            @pagination="getAllStudent"
            :footer-props="{
              itemsPerPageOptions: [25, 50, 100, 200, -1],
            }"
          >
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
              <v-btn   text
      color="success" small class="ma-2 white--text" @click="assignBatch(item)">
               Assign Batch <v-icon class="primary--text">mdi-chevron-right</v-icon> {{  lms_batch_code }}

              </v-btn>
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
  props: ["userPermissionDataProps", "batchTransferDataProps"],

  data() {
    return {
      subjectDataLoading: false,
      searchBatch: "",
      isLoaderActive: false,
      lms_batch_id:
        this.batchTransferDataProps != null
          ? this.batchTransferDataProps.lms_batch_id
          : null,

      lms_course_id:
        this.batchTransferDataProps != null
          ? this.batchTransferDataProps.lms_course_id
          : null,
      lms_course_name:
        this.batchTransferDataProps != null
          ? this.batchTransferDataProps.lms_course_name
          : null,
      lms_batch_code:
        this.batchTransferDataProps != null
          ? this.batchTransferDataProps.lms_batch_code
          : null,
   lms_batch_id: this.batchTransferDataProps != null
          ? this.batchTransferDataProps.lms_batch_id
          : null,
      subjectName: "",

      issaveBatchFormValid: true,
      issaveBatchFormDataProcessing: false,

      authorizationConfig: "",
      tableItems: [],
      isSaveEditClicked: 1,

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

      tableHeader: [
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
          text: "Action",
          value: "actions",
          width: "20%",
          sortable: false,
          align: "center",
        },
      ],

      // For Excel Download
      excelFields: {
        Duration: "lms_exam_card_payment_month_duration",
        "Course Name": "lms_course_name",
        Status: "lms_batch_is_active",
      },
      excelData: [],
      excelFileName:
        "Subscription" + "_" + moment().format("DD/MM/YYYY") + ".xls",
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

    //End
  },

  created() {
    // Token Config
    this.authorizationConfig = {
      headers: { Authorization: "Bearer " + ls.get("token") },
    };
  },

  methods: {
      backToBatch(){ this.$router.push({
        name: "AddBactch",
      });},
    // Change Snack bar message
    changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },
assignBatch(item){

        this.isLoaderActive = true;
        this.$http
          .post(
            "web_student_assign_batch",
            {
              centerId: ls.get("loggedUserCenterId"),
              lms_batch_id: this.lms_batch_id,
              lms_registration_id: item.lms_registration_id,
              lms_batch_mapping_by: ls.get("loggedUserId"),
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
                   console.log("object");
                   console.log(item.index);
                this.tableItems.splice(item.index -1, 1);
                this.snackBarColor = "success";
                this.changeSnackBarMessage(
                  this.$t("label_batch_transfer")
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
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });

},
    // Get all Subject from DB
    getAllStudent(e) {
      console.log("Course");
      console.log("Course", this.lms_course_id);
      this.tableDataLoading = true;

      this.$http
        .get(`web_get_all_students_not_in_batch?page=${e.page}`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            lms_course_id: this.lms_course_id,
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
