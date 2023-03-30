<template>
  <v-container>
    <v-breadcrumbs :items="breadCrumbItem">
      <template v-slot:divider>
        <v-icon>mdi-forward</v-icon>
      </template>
    </v-breadcrumbs>

    <!-- Card Start -->
    <v-row dense>
      <v-col cols="12" md="12" sm="12">
        <v-card max-width="100%" class="mx-auto ml-3 mr-3 mt-5">
          <v-app-bar dark color="primary">
            <v-toolbar-title color="primary">{{ $t('label_assign_permissions') }}</v-toolbar-title>
          </v-app-bar>
          <v-data-table
            :headers="tableHeaders"
            :items="tableItems"
            dense
            group-by="Module"
            item-key="permission_id"
            groupable
            class="elevation-1"
            hide-default-footer
              disable-pagination
            :loading="tableDataLoading"
            :loading-text="tableLoadingDataText"
          >
            <template v-slot:no-data>
              <p
                class="font-weight-black bold title"
                style="color:red"
              >{{ $t("label_no_data_found") }}</p>
            </template>
            <template v-slot:item.is_permission_assigned="{ item }">
              <v-checkbox
                color="primary"
                @change="setSelectedPermission(item,$event)"
                v-model="item.is_permission_assigned"
              ></v-checkbox>
            </template>
          </v-data-table>
          <v-divider class="ml-3 mr-3 mt-0"></v-divider>
          <v-row align="center" justify="end" class="mr-5">
            <v-btn
              class="ma-2 rounded"
              tile
              color="primary"
              :disabled="isPermissionDataProcessing || tableDataLoading"
              @click="assignPermission"
            >{{isPermissionDataProcessing==true?$t("label_processing") : $t("label_save") }}</v-btn>
            <v-btn
              class="ma-2 rounded"
              outlined
              tile
              color="warning"
              :disabled="tableDataLoading || isPermissionDataProcessing"
              dark
              @click="resetPermission"
            >{{$t("label_button_reset")}}</v-btn>
          </v-row>
        </v-card>
      </v-col>
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
export default {
  data() {
    return {
      // Breadcrumb
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
          text: this.$t("label_roles_and_permissions"),
          disabled: false
        },
        {
          text: this.$t("label_assign_permissions"),
          disabled: false
        }
      ],

      //   Datatable Start
      tableDataLoading: false,
      tableLoadingDataText: this.$t("label_loading_data"),
      tableHeaders: [
        { text: "#", value: "sno", width: "10%" },
        { text: this.$t('label_module'), value: "Module", width: "80%" },
        { text: this.$t('label_permission'), value: "permission_name", width: "70%" },

        { text: this.$t('label_actions'), value: "is_permission_assigned", width: "10%" }
      ],
      tableItems: [],
      //Datatable End
      // Snack Bar

      isSnackBarVisible: false,
      snackBarMessage: "",
      snackBarColor: "",

      // For setting selected permission
      selectedPermissionId: [],
      isPermissionDataProcessing: false
    };
  },

  watch: {},

  methods: {
    // Set selected permission
    setSelectedPermission(item, $event) {

      if ($event) {
        this.selectedPermissionId.push(item.permission_id);
      } else {
        this.selectedPermissionId.pop(item.permission_id);
      }
    },

    // Change Snack bar message
    changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },
    // Get All permission
    getAssignedUnAssignedPermissionRoleWise() {
      this.tableDataLoading = true;
      this.$http
        .post(
          "web_get_assigned_unassigned_permission_role_wise",
          {
            centerId: ls.get("loggedUserCenterId"),
            roleId: this.$route.params.roleId
          },
          this.authorizationConfig

        )
        .then(({ data }) => {

          this.tableDataLoading = false;
          //User Unauthorized
          if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {

            this.tableItems = data;
            data.map(val => {
              if (val.is_permission_assigned == 1) {
                this.selectedPermissionId.push(val.permission_id);
              }
            });
          }
        })
        .catch(error => {

          this.tableDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

        });
    },
    // Assign permission
    assignPermission() {

      if (navigator.onLine) {
        // Assign permission
        this.isPermissionDataProcessing = true;
        this.$http
          .post(
            "web_assign_permission_role_wise",
            {
              roleId: this.$route.params.roleId,
              permissionId: this.selectedPermissionId
            },
            this.authorizationConfig
          )
          .then(({ data }) => {
            this.isPermissionDataProcessing = false;

            //User Unauthorized
            if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
              this.$store.dispatch("actionUnauthorizedLogout");
            } else {
                if(data.responseData==1)
                {
                     this.snackBarColor = "success";
            this.changeSnackBarMessage(this.$t("label_permission_assigned"));
this.getAssignedUnAssignedPermissionRoleWise();
                }
                else if(data.responseData==2)
                {
 this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
                }

            }
          })
          .catch(error => {

            this.isPermissionDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

          });
      } else {
        // Internet not found
        this.snackBarColor = "error";
        this.changeSnackBarMessage(this.$t("label_internet_not_found"));
      }
    },
    // Reset permission
    resetPermission() {
      if (navigator.onLine) {
        // Reset permission
        this.getAssignedUnAssignedPermissionRoleWise();
      } else {
        // Internet not found
        this.snackBarColor = "error";
        this.changeSnackBarMessage(this.$t("label_internet_not_found"));
      }
    }
  },
  created() {
    // Authorisation Config
    this.authorizationConfig = {
      headers: { Authorization: "Bearer " + ls.get("token") }
    };
    // Call Assigned Unassigned permission
    this.getAssignedUnAssignedPermissionRoleWise();
  }
};
</script>
