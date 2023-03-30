r<template>
  <div id="app">
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

      <v-sheet class="pa-4" color="text-white">
        <v-row
          justify="space-around"
          style="margin-right: 1px !important; margin-left: -1px !important"
          dense
        >
          <v-toolbar-title dark color="primary">
            <v-list-item two-line>
              <v-list-item-content>
                <v-list-item-title class="text-h5">
                  <strong>Generate Fees</strong>
                </v-list-item-title>
                <v-list-item-subtitle
                  >{{ $t("label_home") }}<v-icon>mdi-forward</v-icon>
                  Accounts
                  <v-icon>mdi-forward</v-icon>
                  Generate Fees</v-list-item-subtitle
                >
              </v-list-item-content>
            </v-list-item>
          </v-toolbar-title>
          <v-spacer></v-spacer>
          <v-btn
            v-permission:all="'Add Enquiry'"
            :disabled="tableDataLoading"
            color="primary"
            class="white--text mt-2 mr-2"
            @click="addEnquiry"
          >
            Generate New Fees
            <v-icon right dark> mdi-plus </v-icon>
          </v-btn>
        </v-row></v-sheet
      >

      <transition name="fade" mode="out-in">
        <v-data-table
          dense
          :headers="tableHeader"
          :items="dataTableRowNumbering"
          item-key="lms_enquiry_id"
          class="elevation-0"
          :loading="tableDataLoading"
          :loading-text="tableLoadingDataText"
          :server-items-length="totalItemsInDB"
          :items-per-page="25"
          @pagination="getAllEnquiry"
          :footer-props="{
            itemsPerPageOptions: [25, 50, 100, 200, -1],
          }"
        >
          <template v-slot:no-data>
            <p class="font-weight-black bold title" style="color: red">
              {{ $t("label_no_data_found") }}
            </p>
          </template>
          <template v-slot:item.lms_student_is_active="{ item }">
            <v-chip
              x-small
              :color="getStatusColor(item.lms_student_is_active)"
              dark
              >{{ item.lms_student_is_active }}</v-chip
            >
          </template>
          <template v-slot:top>
            <v-toolbar flat class="mt-4">
              <v-text-field
                class="mx-2 mt-8"
                outlined
                dense
                v-model="staffSearchCriteria"
                :label="lblSearchStaffCriteria"
              ></v-text-field>
              <v-btn
                class="mx-2 mt-8 mb-6"
                dense
                rounded
                color="primary"
                @click="
                  isSearchBySource = false;
                  getAllEnquiry($event);
                "
                :disabled="tableDataLoading"
                >{{ $t("label_search") }}</v-btn
              >
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
          </template>

          <template v-slot:item.actions="{ item }">
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <v-icon
                  v-bind="attrs"
                  v-on="on"
                  v-if="item.lms_enquiry_status == 'Active'"
                  v-permission="'Add Enquiry|Edit Enquiry'"
                  small
                  class="mr-2"
                  @click="registerUser(item)"
                  color="teal"
                  >mdi-account-plus</v-icon
                >
              </template>
              <span>Register User</span>
            </v-tooltip>

            <v-icon small class="mr-2" @click="viewEnquiry(item)" color="info"
              >mdi-eye</v-icon
            >
            <v-icon
              v-if="item.lms_enquiry_status == 'Active'"
              v-permission="'Delete Enquiry'"
              small
              color="error"
              @click="enableDisableEnquiry(item)"
              >mdi-delete</v-icon
            >
            <v-icon
              v-if="item.lms_enquiry_status == 'Inactive'"
              v-permission="'Delete Enquiry'"
              small
              color="success"
              @click="enableDisableEnquiry(item)"
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
import { Global } from "../../components/helpers/global";
//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
  props: ["userPermissionDataProps"],

  data() {
    return {
      // Form Data
      lblSelectSource: this.$t("label_select_source"),
      selectedSource: "",
      isDataProcessing: false,
      staffSearchCriteria: "",
      lblSearchStaffCriteria: "Search",
      isSourceDataLoading: false,
      sourceData: [],
      isSearchBySource: false,
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
          text: "Registration Code",
          value: "lms_registration_code",
          width: "20%",
          sortable: false,
        },
        {
          text: "Full Name",
          value: "lms_student_full_name",
          width: "15%",
          sortable: false,
        },
        {
          text: "Mobile No",
          value: "lms_student_mobile_number",
          width: "15%",
          sortable: false,
        },

        {
          text: "Course Enrolled",
          value: "lms_child_course_name",
          width: "15%",
          sortable: false,
        },
        {
          text: "Status",
          value: "lms_student_is_active",
          width: "10%",
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
      isDataProcessing: false,

      //Datatable End

      // For Excel Download
      excelFields: {
        Code: "lms_enquiry_code",
        Date: "lms_enquiry_created_at",
        Name: "lms_enquiry_full_name",
        Class: "lms_enquiry_class",
        Section: "lms_enquiry_section",
        RollNo: "lms_roll_no",
        Course: "lms_child_course_name",
        Source: "source_name",
        Mobile: "lms_enquiry_mobile",
        Status: "lms_enquiry_status",
      },
      excelData: [],
      excelFileName:
        "EnquiryListAsExcel" + "_" + moment().format("DD/MM/YYYY") + ".xls",
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
    this.getAllActiveSources();
  },

  methods: {
    // Get all active sources
    getAllActiveSources() {
      this.isSourceDataLoading = true;
      this.$http
        .get(`web_get_all_active_sources_without_pagination`, {
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
            this.sourceData = data;
          }
        })
        .catch((error) => {
          this.isSourceDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Change Snack bar message
    changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },
    // View Staff
    viewEnquiry(item) {
      this.$router.push({
        name: "AddFeeGenerator",
        params: { enquiryDataProps: item },
      });
    },
    // Edit Staff

    editEnquiry(item) {
      console.log(item);
      this.$router.push({
        name: "AddEnquiry",
        params: { enquiryDataProps: item },
      });
    },

    registerUser(item) {
      console.log(item);
      this.$router.push({
        name: "AddRegister",
        params: { enquiryDataProps: item },
      });
    },
    // Add Staff
    addEnquiry() {
      this.$router.push({
        name: "AddFeeGenerator",
      });
    },

    // Enable  Disable Staff Status
    // registerUser(item, $event) {
    //     let userDecision = confirm(this.$t("label_student_admission"));
    //     if (userDecision) {
    //         this.isDataProcessing = true;
    //         this.$http
    //             .post(
    //                 "web_register_user",
    //                 {
    //                     centerId: ls.get("loggedUserCenterId"),
    //                     loggedUserId: ls.get("loggedUserId"),
    //                     courseId: item.lms_course_id,
    //                     childCourseId: item.lms_child_course_id,
    //                     firstName: item.lms_enquiry_first_name,
    //                     lastName: item.lms_enquiry_last_name,
    //                     mobileNumber: item.lms_enquiry_mobile,
    //                     enquiryEmail: item.lms_enquiry_email,
    //                     lms_enquiry_id: item.lms_enquiry_id,
    //                     password: "123456",
    //                 },
    //                 this.authorizationConfig
    //             )
    //             .then(({ data }) => {
    //                 console.log(data.responseData);
    //                 this.isDataProcessing = false;
    //                 //User Unauthorized
    //                 if (
    //                     data.error == "Unauthorized" ||
    //                     data.permissionError == "Unauthorized"
    //                 ) {
    //                     this.$store.dispatch("actionUnauthorizedLogout");
    //                 } else {
    //                     // Staff Status changed
    //                     if (data.responseData == 1) {
    //                         this.snackBarColor = "success";
    //                         this.changeSnackBarMessage(
    //                             this.$t("label_staff_status_changed")
    //                         );
    //                         this.getAllEnquiry(event);
    //                     } else if (data.responseData == 3) {
    //                         this.snackBarColor = "error";
    //                         this.changeSnackBarMessage(
    //                             this.$t("label_email_exists")
    //                         );
    //                         this.getAllEnquiry(event);
    //                     } else if (data.responseData == 4) {
    //                         this.snackBarColor = "error";
    //                         this.changeSnackBarMessage(
    //                             this.$t("label_mobile_exists")
    //                         );
    //                         this.getAllEnquiry(event);
    //                     } else if (data.responseData == 2) {
    //                         console.log("Error");
    //                         this.snackBarColor = "error";
    //                         this.changeSnackBarMessage(
    //                             this.$t("label_something_went_wrong")
    //                         );
    //                     }
    //                 }
    //             })
    //             .catch((error) => {
    //                 this.isDataProcessing = false;
    //                 this.snackBarColor = "error";
    //                 this.changeSnackBarMessage(
    //                     this.$t("label_something_went_wrong")
    //                 );
    //             });
    //     }
    // },

    // Enable  Disable Staff Status
    async enableDisableEnquiry(item, $event) {
      const result = await Global.showConfirmationAlert(
        `Are you sure you want to disable`,
        "You won't be able to revert this!",
        "warning"
      );
      if (result.isConfirmed) {
        this.isDataProcessing = true;
        this.$http
          .post(
            "web_enable_disable_enquiry",
            {
              centerId: ls.get("loggedUserCenterId"),
              loggedUserId: ls.get("loggedUserId"),
              lms_enquiry_id: item.lms_enquiry_id,
              lms_enquiry_status: item.lms_enquiry_status == "Active" ? 0 : 1,
            },
            this.authorizationConfig
          )
          .then(({ data }) => {
            this.isDataProcessing = false;
            //User Unauthorized
            if (
              data.error == "Unauthorized" ||
              data.permissionError == "Unauthorized"
            ) {
              this.$store.dispatch("actionUnauthorizedLogout");
            } else {
              // Staff Status changed
              if (data.responseData == 1) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_status_enquiry"));
                this.getAllEnquiry(event);
              }
              // Staff Status changed failed
              else if (data.responseData == 2) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
            }
          })
          .catch((error) => {
            this.isDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },

    // Get all Staff from DB
    getAllEnquiry(e) {
      this.tableDataLoading = true;
      let postData = "";

      if (this.isSearchBySource == true) {
        postData = {
          centerId: ls.get("loggedUserCenterId"),
          perPage: e.itemsPerPage == -1 ? this.totalItemsInDB : e.itemsPerPage,
          filterBy: this.selectedSource,
        };
      } else {
        postData = {
          centerId: ls.get("loggedUserCenterId"),
          perPage: e.itemsPerPage == -1 ? this.totalItemsInDB : e.itemsPerPage,
          filterBy: this.staffSearchCriteria,
        };
      }

      this.$http
        .get(`web_get_all_student_fee?page=${e.page}`, {
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
    getStatusColor(lms_student_is_active) {
      if (lms_student_is_active == "Active") return "success";
      if (lms_student_is_active == "Mobile-R") return "primary";
      else return "error";
    },
    // Export to PDF
    savePDF() {
      const pdfDoc = new jsPDF();
      pdfDoc.autoTable({
        columns: [
          { header: "Code", dataKey: "lms_enquiry_code" },
          { header: "Name", dataKey: "lms_enquiry_full_name" },
          { header: "Class", dataKey: "lms_enquiry_class" },
          { header: "Section", dataKey: "lms_enquiry_section" },
          { header: "RollNo", dataKey: "lms_roll_no" },
          { header: "Course", dataKey: "lms_child_course_name" },
          { header: "Source", dataKey: "source_name" },
          { header: "Mobile", dataKey: "lms_enquiry_mobile" },
          { header: "Status", dataKey: "lms_enquiry_status" },
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 },
      });
      pdfDoc.save(
        "EnquiryListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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
