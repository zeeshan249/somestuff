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
    
    <v-row 
    
     dense>
      <transition name="fade" mode="out-in">
        <v-col class="d-flex flex-column ml-2">
          <!-- Card Start -->
          <v-card >
            <v-app-bar dark color="primary">
              <v-toolbar-title color="success">{{ $t('label_department') }}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn
                v-permission="'Add Department'"
                icon
                class="ma-2"
                outlined
                small
                color="white"
                v-if="!isAddDepartmentCardVisible"
              >
                <v-icon color="white" @click="isAddDepartmentCardVisible=!isAddDepartmentCardVisible">mdi-plus</v-icon>
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
                  item-key="lms_department_id"
                  class="elevation-1"
                  :loading="tableDataLoading"
                  :loading-text="tableLoadingDataText"
                  :server-items-length="totalItemsInDB"
                  :items-per-page="15"
                  @pagination="getAllDepartment"
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
                  <template v-slot:item.lms_department_is_active="{ item }">
                    <v-chip
                      x-small
                      :color="getDepartmentStatusColor(item.lms_department_is_active)"
                      dark
                    >{{ item.lms_department_is_active }}</v-chip>
                  </template>
                  <template v-slot:top>
                    <v-toolbar flat>
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
                      v-permission="'Edit Department'"
                      small
                      class="mr-2"
                      @click="editDepartment(item)"
                      color="primary"
                    >mdi-pencil</v-icon>

                    <v-icon v-if="item.lms_department_is_active=='Active'"
                      v-permission="'Edit Department'"
                      small
                      color="error"
                      @click="disableDepartment(item)"
                    >mdi-delete</v-icon>
                    <v-icon v-if="item.lms_department_is_active=='Inactive'"
                      v-permission="'Edit Department'"
                      small
                      color="success"
                      @click="disableDepartment(item)"
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
        <v-col class="d-flex flex-column mr-2" v-if="isAddDepartmentCardVisible">
          <v-card>
            <v-app-bar dark color="primary">
              <v-toolbar-title color="success">{{$t('label_department')}}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon class="ma-2" outlined small color="white">
                <v-icon color="white" @click="isAddDepartmentCardVisible=!isAddDepartmentCardVisible">mdi-minus</v-icon>
              </v-btn>
            </v-app-bar>

            <v-container>
              <v-form ref="saveDepartmentForm" v-model="isSaveDepartmentFormValid" lazy-validation>
                <v-row dense>
                  <v-col cols="12" xs="12" sm="12" md="8">
                    <v-text-field
                      :label="departmentNameLabel"
                      :hint="departmentNameHint"
                      class="ml-4"
                      v-model="departmentName"
                      :rules="departmentRules"
                      type="text"
                      clearable
                      @keypress="isCharacters"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="12" md="4">
                    <v-btn
                      v-permission="'Add Department' | 'Edit Department'"
                      class="ma-2 rounded"
                      tile
                      color="primary"
                      :disabled="!isSaveDepartmentFormValid || isSaveDepartmentFormDataProcessing"
                      @click="saveDepartment"
                    >{{isSaveDepartmentFormDataProcessing==true?$t("label_processing") : $t("label_save") }}</v-btn>
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
          text: this.$t("label_department"),
          disabled: false
        }
      ],

      // Form Labels
      departmentNameLabel: this.$t("label_department_name"),
      departmentNameHint: this.$t("label_enter_department_name"),

      // Form Inputs and Validation Authorization
      isSaveDepartmentFormValid: true,
      isSaveDepartmentFormDataProcessing: false,
      departmentName: "",
      departmentRules: [v => !!v || this.$t("label_department_name_required")],
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
        { text: this.$t("label_department_name"), value: "lms_department_name", width: "50%" , sortable: false},
        {
          text: this.$t("label_status"),
          value: "lms_department_is_active",
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
      isDepartmentDataProcessing: false,
      isSaveEditClicked: 1,
      editDepartmentId: "",
      //Datatable End

      // For Add Department card
      isAddDepartmentCardVisible: false,

      // For Excel Download
      excelFields: {
        "Department Name": "lms_department_name",
        "Status": "lms_department_is_active"
      },
      excelData: [],
      excelFileName:
        "DepartmentListAsExcel" + "_" + moment().format("DD/MM/YYYY") + ".xls"
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

    // Edit Department Name

    editDepartment(item) {
        this.isAddDepartmentCardVisible=true
      this.editDepartmentId = item.lms_department_id;
      this.isSaveEditClicked = 0;
      this.departmentName = item.lms_department_name;
    },
    // Disable Department status
    disableDepartment(item, $event) {
      let userDecision = confirm(this.$t("label_are_you_sure_change_status_department"));
      if (userDecision) {

        this.isDepartmentDataProcessing = true;
        this.$http
          .post(
            "web_update_department",
            {
              centerId: ls.get("loggedUserCenterId"),
              departmentName: item.lms_department_name,
              departmentId: item.lms_department_id,
              isDepartmentActive: item.lms_department_is_active=='Active'?0:1,
              loggedUserId:ls.get("loggedUserId")
            },
            this.authorizationConfig
          )
          .then(({ data }) => {
            this.isDepartmentDataProcessing = false;
            //User Unauthorized
             if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
              this.$store.dispatch("actionUnauthorizedLogout");
            } else {
              // Department Disabled
              if (data.responseData == 1) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_department_status_changed"));
                this.getAllDepartment(event);
              }
              // Department Disabled failed
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
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },
    // To ensure department name is character and space only
    isCharacters(evt) {
      var regex = new RegExp("^[a-zA-Z ]+$");
      var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
      if (!regex.test(key)) {
        evt.preventDefault();
        return false;
      }
    },
    // Save Department To DB after validation
    saveDepartment($event) {
      if (this.$refs.saveDepartmentForm.validate()) {
        this.isSaveDepartmentFormDataProcessing = true;
        let postData;
        if (this.isSaveEditClicked == 1) {
          postData = {
            departmentName: this.departmentName,
            isSaveEditClicked: 1,
            centerId: ls.get("loggedUserCenterId"),
            loggedUserId:ls.get("loggedUserId")
          };
        } else {
          postData = {
            departmentName: this.departmentName,
            departmentId: this.editDepartmentId,
            isSaveEditClicked: 0,
            centerId: ls.get("loggedUserCenterId"),
             loggedUserId:ls.get("loggedUserId")
          };
        }
        this.$http
          .post("web_save_department", postData, this.authorizationConfig)
          .then(({ data }) => {
            this.isSaveDepartmentFormDataProcessing = false;
            //User Unauthorized
             if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
              this.$store.dispatch("actionUnauthorizedLogout");
            } else {
              // Server side validation fails
              if (data.responseData == 0) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(data.error);
              }
              // Department Exists
              else if (data.responseData == 1) {
                this.snackBarColor = "info";
                this.changeSnackBarMessage(this.$t("label_department_exists"));
              }
              // Department Saved
              else if (data.responseData == 2) {
                this.departmentName = "";
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_department_saved"));
                this.getAllDepartment(event);
                this.isSaveEditClicked = 1;
              }
              // Failed to save Department
              else if (data.responseData == 3) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }

              // Department Updated
              else if (data.responseData == 4) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_department_name_updated"));
                this.getAllDepartment(event);
                this.isSaveEditClicked = 1;
                this.departmentName = "";
              }
              // Department update failed
              else if (data.responseData == 5) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
            }
          })
          .catch(error => {
            this.isSaveDepartmentFormDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

          });
      }
    },

    // Get all Department from DB
    getAllDepartment(e) {
      this.tableDataLoading = true;

      this.$http
        .get(`web_get_all_departments?page=${e.page}`, {
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
    // Department Status Color
    getDepartmentStatusColor(is_department_acive) {
      if (is_department_acive == "Active") return "success";
      else return "error";
    },
    // Export to PDF
    savePDF() {
      const pdfDoc = new jsPDF();
      pdfDoc.autoTable({
        columns: [
          { header: "Department", dataKey: "lms_department_name" },
          { header: "Status", dataKey: "lms_department_is_active" }
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 }
      });
      pdfDoc.save(
        "DepartmentListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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

