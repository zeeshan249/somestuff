<template>
  <!-- Card Start -->
  <v-container>
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
              <v-toolbar-title color="success">{{ $t('label_add_staff') }}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn
                v-permission:all="'Add Staff|Edit Staff'"
                class="ma-2"
                outlined
                small
                color="white"
                @click="addStaff"
              >
                <v-icon class="mr-2" color="white">mdi-account-multiple-plus</v-icon>
                {{ $t('label_add_staff') }}
              </v-btn>
            </v-app-bar>

            <v-container>
              <div>
                <v-row dense>
                  <v-col cols="12" class="ml-2" md="5">
                    <v-select
                      v-model="selectedRole"
                      :disabled="isRoleDataLoading"
                      :items="roleData"
                      dense
                      outlined
                      :label="lblSelectRole"
                      item-text="name"
                      item-value="name"
                      @change="isSearchByRole=true;getAllStaff($event);"
                    ></v-select>
                  </v-col>
                  <v-col cols="12" class="ml-4" md="4">
                    <v-text-field
                      outlined
                      dense
                      v-model="staffSearchCriteria"
                      :label="lblSearchStaffCriteria"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="2">
                    <v-btn
                      class="ml-2"
                      dense
                      rounded
                      color="primary"
                      @click="isSearchByRole=false;getAllStaff($event);"
                      :disabled="tableDataLoading"
                    >{{$t('label_search')}}</v-btn>
                  </v-col>
                </v-row>
              </div>
            </v-container>
          </v-card>
          <!-- Card End -->
        </v-col>
      </transition>
    </v-row>
    <v-row dense>
      <transition name="fade" mode="out-in">
        <v-col class="d-flex flex-column ml-2">
          <!-- Card Start -->
          <v-card>
            <v-app-bar dark color="primary">
              <v-toolbar-title color="success">{{ $t('label_staff_directory') }}</v-toolbar-title>
              <v-spacer></v-spacer>
            </v-app-bar>

            <v-container>
              <v-card class="mx-auto" max-width="100%">
                <v-data-table
                  dense
                  :headers="tableHeader"
                  :items="dataTableRowNumbering"
                  item-key="lms_staff_id"
                  class="elevation-1"
                  :loading="tableDataLoading"
                  :loading-text="tableLoadingDataText"
                  :server-items-length="totalItemsInDB"
                  :items-per-page="15"
                  @pagination="getAllStaff"
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
                  <template v-slot:item.lms_staff_is_active="{ item }">
                    <v-chip
                      x-small
                      :color="getStatusColor(item.lms_staff_is_active)"
                      dark
                    >{{ item.lms_staff_is_active }}</v-chip>
                  </template>
                  <template v-slot:top>
                    <v-toolbar flat>
                      <v-toolbar-title>{{$t('label_staff_directory')}}</v-toolbar-title>
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
                      v-permission="'Edit Staff'"
                      small
                      class="mr-2"
                      @click="editStaff(item)"
                      color="primary"
                    >mdi-pencil</v-icon>
                    <v-icon
                      v-permission="'Staff'"
                      small
                      class="mr-2"
                      @click="viewStaff(item)"
                      color="info"
                    >mdi-eye</v-icon>
                    <v-icon
                      v-if="item.lms_staff_is_active=='Active'"
                      v-permission="'Edit Staff'"
                      small
                      color="error"
                      @click="enableDisableStaff(item)"
                    >mdi-delete</v-icon>
                    <v-icon
                      v-if="item.lms_staff_is_active=='Inactive'"
                      v-permission="'Edit Staff'"
                      small
                      color="success"
                      @click="enableDisableStaff(item)"
                    >mdi-check-circle</v-icon>
                  </template>
                </v-data-table>
              </v-card>
            </v-container>
          </v-card>
          <!-- Card End -->
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
          text: this.$t("label_staff_directory"),
          disabled: false
        }
      ],
      // Form Data
      lblSelectRole: this.$t("label_select_role"),
      selectedRole: "",
      isDataProcessing: false,
      staffSearchCriteria: "",
      lblSearchStaffCriteria: this.$t("label_search_staff_criteria"),
      isRoleDataLoading: false,
      roleData: [],
      isSearchByRole: false,
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
          text: this.$t("label_code"),
          value: "lms_staff_code",
          width: "10%",
          sortable: false
        },
        {
          text: this.$t("label_name"),
          value: "lms_user_full_name",
          width: "20%",
          sortable: false
        },
        {
          text: this.$t("label_role"),
          value: "role_name",
          width: "10%",
          sortable: false
        },
        {
          text: this.$t("label_department"),
          value: "lms_department_name",
          width: "10%",
          sortable: false
        },
        {
          text: this.$t("label_designation"),
          value: "lms_designation_name",
          width: "10%",
          sortable: false
        },
        {
          text: this.$t("label_mobile_number"),
          value: "lms_user_mobile",
          width: "10%",
          sortable: false
        },
        {
          text: this.$t("label_status"),
          value: "lms_staff_is_active",
          align: "middle",
          width: "5%",
          sortable: false
        },
        {
          text: this.$t("label_actions"),
          value: "actions",
          sortable: false,
          width: "15%",
          align: "middle"
        }
      ],
      tableItems: [],
      isDataProcessing: false,

      //Datatable End

      // For Excel Download
      excelFields: {
        Code: "lms_staff_code",
        Name: "lms_user_full_name",
        Role: "role_name",
        Department: "lms_department_name",
        Designation: "lms_designation_name",
        "Mobile Number": "lms_user_mobile",
        Status: "lms_staff_is_active"
      },
      excelData: [],
      excelFileName:
        "StaffListAsExcel" + "_" + moment().format("DD/MM/YYYY") + ".xls"
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

    // Get all active roles
    this.getAllActiveRoles();
  },

  methods: {
    // Get all active roles
    getAllActiveRoles() {
      this.isRoleDataLoading = true;
      this.$http
        .get(`web_get_all_active_roles_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId")
          },
          headers: { Authorization: "Bearer " + ls.get("token") }
        })
        .then(({ data }) => {
          this.isRoleDataLoading = false;
          //User Unauthorized
          if (
            data.error == "Unauthorized" ||
            data.permissionError == "Unauthorized"
          ) {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.roleData = data;
          }
        })
        .catch(error => {
          this.isRoleDataLoading = false;
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
    viewStaff(item) {
      this.$router.push({
        name: "SystemSettingsviewStaffs",
        params: { roleId: item.id }
      });
    },
    // Edit Staff

    editStaff(item) {

      this.$router.push({
        name: "HumanResourceAddStaff",
        params: { staffDataProps: item}
      });
    },
    // Add Staff
    addStaff() {
      this.$router.push({
        name: "HumanResourceAddStaff",

      });
    },
    // Enable  Disable Staff Status
    enableDisableStaff(item, $event) {
      let userDecision = confirm(
        this.$t("label_are_you_sure_change_status_staff")
      );
      if (userDecision) {
        this.isDataProcessing = true;
        this.$http
          .post(
            "web_enable_disable_staff",
            {
              centerId: ls.get("loggedUserCenterId"),
              loggedUserId: ls.get("loggedUserId"),
              staffId: item.lms_staff_id,
              isStaffActive: item.lms_staff_is_active == "Active" ? 0 : 1,
              staffUserId: item.lms_user_id
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
                this.changeSnackBarMessage(
                  this.$t("label_staff_status_changed")
                );
                this.getAllStaff(event);
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
          .catch(error => {
            this.isDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },

    // Get all Staff from DB
    getAllStaff(e) {
      this.tableDataLoading = true;
      let postData = "";

      if (this.isSearchByRole == true) {
        postData = {
          centerId: ls.get("loggedUserCenterId"),
          perPage: e.itemsPerPage,
          filterBy: this.selectedRole
        };
      } else {
        postData = {
          centerId: ls.get("loggedUserCenterId"),
          perPage: e.itemsPerPage,
          filterBy: this.staffSearchCriteria
        };
      }

      this.$http
        .get(`web_get_all_staff?page=${e.page}`, {
          params: postData,
          headers: { Authorization: "Bearer " + ls.get("token") }
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
        .catch(error => {
          this.tableDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Role Status Color
    getStatusColor(is_role_acive) {
      if (is_role_acive == "Active") return "success";
      else return "error";
    },
    // Export to PDF
    savePDF() {
      const pdfDoc = new jsPDF();
      pdfDoc.autoTable({
        columns: [
          { header: "Code", dataKey: "lms_staff_code" },
          { header: "Name", dataKey: "lms_user_full_name" },
          { header: "Role", dataKey: "role_name" },
          { header: "Department", dataKey: "lms_department_name" },
          { header: "Designation", dataKey: "lms_designation_name" },
          { header: "Mobile Number", dataKey: "lms_user_mobile" },
          { header: "Status", dataKey: "lms_staff_is_active" }
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 }
      });
      pdfDoc.save(
        "StaffListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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

