<template>
  <!-- Card Start -->
  <v-container>

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
              <v-toolbar-title color="success">{{ $t('label_prefix') }}</v-toolbar-title>
              <v-spacer></v-spacer>

            </v-app-bar>

            <v-container>
              <v-card class="mx-auto" max-width="100%">
                <v-data-table
                  dense
                  :headers="tableHeader"
                  :items="dataTableRowNumbering"
                  item-key="lms_prefix_setting_id"
                  class="elevation-1"
                  :loading="tableDataLoading"
                  :loading-text="tableLoadingDataText"
                  :server-items-length="totalItemsInDB"
                  :items-per-page="15"
                  @pagination="getAllPrefix"
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
                  <template v-slot:item.lms_prefix_is_active="{ item }">
                    <v-chip
                      x-small
                      :color="getPrefixStatusColor(item.lms_prefix_is_active)"
                      dark
                    >{{ item.lms_prefix_is_active }}</v-chip>
                  </template>
                  <template v-slot:top>
                    <v-toolbar flat>
                      <v-toolbar-title>{{$t('label_prefix')}}</v-toolbar-title>
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
                      v-permission="'Edit Prefix'"
                      small
                      class="mr-2"
                      @click="editPrefix(item)"
                      color="primary"
                    >mdi-pencil</v-icon>
                  </template>
                </v-data-table>
              </v-card>
            </v-container>
          </v-card>
          <!-- Card End -->
        </v-col>
      </transition>
      <transition name="fade" mode="out-in">
        <v-col class="d-flex flex-column mr-2" v-if="isAddCardVisible">
          <v-card>
            <v-app-bar dark color="primary">
              <v-toolbar-title color="success">{{$t('label_prefix')}}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon class="ma-2" outlined small color="white">
                <v-icon color="white" @click="isAddCardVisible=!isAddCardVisible">mdi-minus</v-icon>
              </v-btn>
            </v-app-bar>

            <v-container>
              <v-form ref="savePrefixForm" v-model="isSavePrefixFormValid" lazy-validation>
                <v-row dense>
                  <v-col cols="12" xs="12" sm="12" md="8">
                    <v-text-field
                      :label="prefixNameLabel"
                      :hint="prefixNameHint"
                      class="ml-4"
                      v-model="prefixName"
                      :rules="prefixRules"
                      type="text"
                      clearable
                       maxlength="2"
                      @keypress="isCharacters"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" xs="12" sm="12" md="4">
                    <v-btn
                      v-permission="'Edit Prefix'"
                      class="ma-2 rounded"
                      tile
                      color="primary"
                      :disabled="!isSavePrefixFormValid || isSavePrefixFormDataProcessing"
                      @click="savePrefix"
                    >{{isSavePrefixFormDataProcessing==true?$t("label_processing") : $t("label_save") }}</v-btn>
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
          text: this.$t("label_system_settings"),
          disabled: false
        },
        {
          text: this.$t("label_prefix"),
          disabled: false
        }
      ],

      // Form Labels
      prefixNameLabel: this.$t("label_prefix_name"),
      prefixNameHint: this.$t("label_enter_prefix_name"),

      // Form Inputs and Validation Authorization
      isSavePrefixFormValid: true,
      isSavePrefixFormDataProcessing: false,
      prefixName: "",
      prefixRules: [v => !!v || this.$t("label_prefix_name_required"),
      ],
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
         { text: this.$t("label_module"), value: "lms_prefix_module_name", width: "25%", sortable: false },
        { text: this.$t("label_prefix"), value: "lms_prefix", width: "10%" , sortable: false},
        {
          text: this.$t("label_pattern"),
          value: "lms_prefix_pattern",
          align: "middle",
          width: "30%",
          sortable: false
        },
         {
          text: this.$t("label_status"),
          value: "lms_prefix_is_active",
          align: "middle",
          width: "20%",
          sortable: false
        },
        {
          text: this.$t("label_actions"),
          value: "actions",
          sortable: false,
          width: "5%",
          align: "middle"
        }
      ],
      tableItems: [],

      editPrefixId: "",
      //Datatable End

      // For Add Department card
      isAddCardVisible: false,

      // For Excel Download
      excelFields: {
          "Module": "lms_prefix_module_name",
        "Prefix": "lms_prefix",
         "Pattern": "lms_prefix_pattern",
        "Status": "lms_prefix_is_active"
      },
      excelData: [],
      excelFileName:
        "PrefixListAsExcel" + "_" + moment().format("DD/MM/YYYY") + ".xls"
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

    // Edit Prefix Name

    editPrefix(item) {
        this.isAddCardVisible=true
      this.editPrefixId = item.lms_prefix_setting_id;
      this.prefixName = item.lms_prefix;
    },

    // To ensure Prefix name is character and space only
    isCharacters(evt) {
      var regex = new RegExp("^[a-zA-Z ]+$");
      var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
      if (!regex.test(key)) {
        evt.preventDefault();
        return false;
      }
    },
    // Save Prefix To DB after validation
    savePrefix($event) {
      if (this.$refs.savePrefixForm.validate()) {
        this.isSavePrefixFormDataProcessing = true;
        let postData = {
            prefixName: this.prefixName,
            prefixSettingId: this.editPrefixId,
            centerId: ls.get("loggedUserCenterId"),
             loggedUserId:ls.get("loggedUserId")
          };

        this.$http
          .post("web_save_prefix", postData, this.authorizationConfig)
          .then(({ data }) => {
            this.isSavePrefixFormDataProcessing = false;
            //User Unauthorized
             if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
              this.$store.dispatch("actionUnauthorizedLogout");
            } else {
              // Server side validation fails
              if (data.responseData == 0) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(data.error);
              }
              // Prefix Updated
              else if (data.responseData == 1) {
                this.snackBarColor = "success";
                 this.prefixName = "";
                this.changeSnackBarMessage(this.$t("label_prefix_name_updated"));
                 this.getAllPrefix(event);
              }
              // Prefix Update failed
              else if (data.responseData == 2) {

                this.snackBarColor = "error";
                this.changeSnackBarMessage(this.$t("label_something_went_wrong"));


              }

            }
          })
          .catch(error => {
            this.isSavePrefixFormDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

          });
      }
    },

    // Get all Prefix from DB
    getAllPrefix(e) {
      this.tableDataLoading = true;

      this.$http
        .get(`web_get_all_prefix?page=${e.page}`, {
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
    // Prefix Status Color
    getPrefixStatusColor(is_prefix_active) {
      if (is_prefix_active == "Active") return "success";
      else return "error";
    },
    // Export to PDF
    savePDF() {
      const pdfDoc = new jsPDF();
      pdfDoc.autoTable({
        columns: [
              { header: "Module", dataKey: "lms_prefix_module_name" },
          { header: "Prefix", dataKey: "lms_prefix" },
            { header: "Pattern", dataKey: "lms_prefix_pattern" },
          { header: "Status", dataKey: "lms_prefix_is_active" }
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 }
      });
      pdfDoc.save(
        "PrefixListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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

