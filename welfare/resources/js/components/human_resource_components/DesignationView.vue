<template>
  <!-- Card Start -->
  <v-container>
    <v-progress-linear
      :active="isDesignationDataProcessing"
      :indeterminate="isDesignationDataProcessing"
      height="10"
      absolute
      top
      color="primary"
      background-color="primary lighten-3"
       striped
    ></v-progress-linear>
    <v-breadcrumbs :items="breadCrumbItem">
      <template v-slot:divider>
        <v-icon>mdi-forward</v-icon>
      </template>
    </v-breadcrumbs>
    <v-row dense>
      <transition name="fade" mode="out-in">
        <v-col class="d-flex flex-column ml-2">
          <!-- Card Start -->
          <v-card>
            <v-app-bar dark color="primary">
              <v-toolbar-title color="success">{{ $t('label_designation') }}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn
                v-permission="'Add Designation'"
                icon
                class="ma-2"
                outlined
                small
                color="white"
                v-if="!isAddDesignationCardVisible"
              >
                <v-icon color="white" @click="isAddDesignationCardVisible=!isAddDesignationCardVisible">mdi-plus</v-icon>
              </v-btn>
            </v-app-bar>

            <v-container>
              <v-card class="mx-auto" max-width="100%">
                <v-data-table
                  dense
                  :headers="tableHeader"
                  :items="dataTableRowNumbering"
                  item-key="lms_designation_id"
                  class="elevation-1"
                  :loading="tableDataLoading"
                  :loading-text="tableLoadingDataText"
                  :server-items-length="totalItemsInDB"
                  :items-per-page="15"
                  @pagination="getAllDesignation"
                  :footer-props="{
                            itemsPerPageOptions: [5, 10, 15],

                        }"
                >
                  <template v-slot:no-data>
                    <p
                      class="font-weight-black bold title"
                      style="color:red"
                    >{{ $t("label_no_data_found") }}</p>
                  </template>
                  <template v-slot:item.lms_designation_is_active="{ item }">
                    <v-chip
                      x-small
                      :color="getDesignationStatusColor(item.lms_designation_is_active)"
                      dark
                    >{{ item.lms_designation_is_active }}</v-chip>
                  </template>
                  <template v-slot:top>
                    <v-toolbar flat>
                      <v-toolbar-title>{{$t('label_designation')}}</v-toolbar-title>
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
                    <v-icon
                      v-permission="'Edit Designation'"
                      small
                      class="mr-2"
                      @click="editDesignation(item)"
                      color="primary"
                    >mdi-pencil</v-icon>

                    <v-icon v-if="item.lms_designation_is_active=='Active'"
                      v-permission="'Edit Designation'"
                      small
                      color="error"
                      @click="disableDesignation(item)"
                    >mdi-delete</v-icon>
                    <v-icon v-if="item.lms_designation_is_active=='Inactive'"
                      v-permission="'Edit Designation'"
                      small
                      color="success"
                      @click="disableDesignation(item)"
                    >mdi-check-circle</v-icon>
                  </template>
                </v-data-table>
              </v-card>
            </v-container>
          </v-card>
          <!-- Card End -->
        </v-col>
      </transition>
      <transition name="fade" mode="out-in">
        <v-col class="d-flex flex-column mr-2" v-if="isAddDesignationCardVisible">
          <v-card>
            <v-app-bar dark color="primary">
              <v-toolbar-title color="success">{{$t('label_designation')}}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon class="ma-2" outlined small color="white">
                <v-icon color="white" @click="isAddDesignationCardVisible=!isAddDesignationCardVisible">mdi-minus</v-icon>
              </v-btn>
            </v-app-bar>

            <v-container>
              <v-form ref="saveDesignationForm" v-model="isSaveDesignationFormValid" lazy-validation>
                <v-row dense>
                  <v-col cols="12" xs="12" sm="12" md="8">
                    <v-text-field
                      :label="designationNameLabel"
                      :hint="designationNameHint"
                      class="ml-4"
                      v-model="designationName"
                      :rules="designationRules"
                      type="text"
                      clearable
                      @keypress="isCharacters"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="12" md="4">
                    <v-btn
                      v-permission="'Add Designation' | 'Edit Designation'"
                      class="ma-2 rounded"
                      tile
                      color="primary"
                      :disabled="!isSaveDesignationFormValid || isSaveDesignationFormDataProcessing"
                      @click="saveDesignation"
                    >{{isSaveDesignationFormDataProcessing==true?$t("label_processing") : $t("label_save") }}</v-btn>
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
    >{{ snackBarMessage }}</v-snackbar>
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
          disabled: false
        },
        {
          text: this.$t("label_human_resource"),
          disabled: false
        },
        {
          text: this.$t("label_designation"),
          disabled: false
        }
      ],

      // Form Labels
      designationNameLabel: this.$t("label_designation_name"),
      designationNameHint: this.$t("label_enter_designation_name"),

      // Form Inputs and Validation Authorization
      isSaveDesignationFormValid: true,
      isSaveDesignationFormDataProcessing: false,
      designationName: "",
      designationRules: [v => !!v || this.$t("label_designation_name_required")],
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
        { text: "#", value: "index", width: "10%", sortable: false },
        { text: this.$t("label_designation_name"), value: "lms_designation_name", width: "50%" , sortable: false},
        {
          text: this.$t("label_status"),
          value: "lms_designation_is_active",
          align: "middle",
          width: "20%",
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
      isDesignationDataProcessing: false,
      isSaveEditClicked: 1,
      editDesignationId: "",
      //Datatable End

      // For Add Department card
      isAddDesignationCardVisible: false,

      // For Excel Download
      excelFields: {
        "Designation Name": "lms_designation_name",
        "Status": "lms_designation_is_active"
      },
      excelData: [],
      excelFileName:
        "DesignationListAsExcel" + "_" + moment().format("DD/MM/YYYY") + ".xls"
    };
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

    // Edit Designation Name

    editDesignation(item) {
        this.isAddDesignationCardVisible=true
      this.editDesignationId = item.lms_designation_id;
      this.isSaveEditClicked = 0;
      this.designationName = item.lms_designation_name;
    },
    // Disable Designation status
    disableDesignation(item, $event) {
      let userDecision = confirm(this.$t("label_are_you_sure_change_status_designation"));
      if (userDecision) {

        this.isDesignationDataProcessing = true;
        this.$http
          .post(
            "web_update_designation",
            {
              centerId: ls.get("loggedUserCenterId"),
              designationName: item.lms_designation_name,
              designationId: item.lms_designation_id,
              isDesignationActive: item.lms_designation_is_active=='Active'?0:1,
              loggedUserId:ls.get("loggedUserId")
            },
            this.authorizationConfig
          )
          .then(({ data }) => {
            this.isDesignationDataProcessing = false;
            //User Unauthorized
             if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
              this.$store.dispatch("actionUnauthorizedLogout");
            } else {
              // Designation Disabled
              if (data.responseData == 1) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_designation_status_changed"));
                this.getAllDesignation(event);
              }
              // Designation Disabled failed
              else if (data.responseData == 2) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
            }
          })
          .catch(error => {
            this.isDesignationDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },
    // To ensure Designation name is character and space only
    isCharacters(evt) {
      var regex = new RegExp("^[a-zA-Z ]+$");
      var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
      if (!regex.test(key)) {
        evt.preventDefault();
        return false;
      }
    },
    // Save Designation To DB after validation
    saveDesignation($event) {
      if (this.$refs.saveDesignationForm.validate()) {
        this.isSaveDesignationFormDataProcessing = true;
        let postData;
        if (this.isSaveEditClicked == 1) {
          postData = {
            designationName: this.designationName,
            isSaveEditClicked: 1,
            centerId: ls.get("loggedUserCenterId"),
            loggedUserId:ls.get("loggedUserId")
          };
        } else {
          postData = {
            designationName: this.designationName,
            designationId: this.editDesignationId,
            isSaveEditClicked: 0,
            centerId: ls.get("loggedUserCenterId"),
             loggedUserId:ls.get("loggedUserId")
          };
        }
        this.$http
          .post("web_save_designation", postData, this.authorizationConfig)
          .then(({ data }) => {
            this.isSaveDesignationFormDataProcessing = false;
            //User Unauthorized
             if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
              this.$store.dispatch("actionUnauthorizedLogout");
            } else {
              // Server side validation fails
              if (data.responseData == 0) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(data.error);
              }
              // Designation Exists
              else if (data.responseData == 1) {
                this.snackBarColor = "info";
                this.changeSnackBarMessage(this.$t("label_designation_exists"));
              }
              // Designation Saved
              else if (data.responseData == 2) {
                this.designationName = "";
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_designation_saved"));
                this.getAllDesignation(event);
                this.isSaveEditClicked = 1;
              }
              // Failed to save Designation
              else if (data.responseData == 3) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }

              // Designation Updated
              else if (data.responseData == 4) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_designation_name_updated"));
                this.getAllDesignation(event);
                this.isSaveEditClicked = 1;
                this.designationName = "";
              }
              // Designation update failed
              else if (data.responseData == 5) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
            }
          })
          .catch(error => {
            this.isSaveDesignationFormDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

          });
      }
    },

    // Get all Designation from DB
    getAllDesignation(e) {
      this.tableDataLoading = true;

      this.$http
        .get(`web_get_all_designations?page=${e.page}`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            perPage: e.itemsPerPage
          },
          headers: { Authorization: "Bearer " + ls.get("token") }
        })
        .then(({ data }) => {
          this.tableDataLoading = false;
          //User Unauthorized
          if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
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
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

        });
    },
    // Designation Status Color
    getDesignationStatusColor(is_designation_acive) {
      if (is_designation_acive == "Active") return "success";
      else return "error";
    },
    // Export to PDF
    savePDF() {
      const pdfDoc = new jsPDF();
      pdfDoc.autoTable({
        columns: [
          { header: "Designation", dataKey: "lms_designation_name" },
          { header: "Status", dataKey: "lms_designation_is_active" }
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 }
      });
      pdfDoc.save(
        "DesignationListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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

