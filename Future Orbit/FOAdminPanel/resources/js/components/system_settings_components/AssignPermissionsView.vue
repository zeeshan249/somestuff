<template>
    <div id="app">
        <!-- Card Start -->
        <v-container
        fluid
        style="background-color: #e4e8e4; max-width: 100% !important"
        >
        <v-sheet class="pa-4 mb-4" >
            <v-row class="ml-4 mr-4 pt-4">
                <v-toolbar-title dark color="primary">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                <strong>{{
                                    this.$t("label_assign_permissions")
                                }}</strong>
                            </v-list-item-title>
                            <v-list-item-subtitle
                                >Home <v-icon>mdi-forward</v-icon>
                                {{ this.$t("label_system_settings") }}
                                <v-icon>mdi-forward</v-icon>
                                {{ this.$t("label_roles_and_permissions") }}
                                <v-icon>mdi-forward</v-icon>
                                {{ this.$t("label_assign_permissions") }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-toolbar-title>
                <v-spacer></v-spacer>
            </v-row>
        </v-sheet>
            <v-card>
                <v-system-bar color="primary darken-2" dark>
                    <v-spacer></v-spacer>
                </v-system-bar>
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
                        >
                            {{ $t("label_no_data_found") }}
                        </p>
                    </template>
                    <template v-slot:item.is_permission_assigned="{ item }">
                        <v-row class="p-0">
                            <v-col class="p-0">
                                <v-switch
                                    class="ma-0"
                                    color="info"
                                    inset
                                    v-model="item.is_permission_assigned"
                                    @change="assignPermission(item, $event)"
                                ></v-switch>
                            </v-col>

                            <v-col class="p-0">
                                <v-checkbox
                                    class="ma-0"
                                    color="primary"
                                    @change="
                                        setSelectedPermission(item, $event)
                                    "
                                    v-model="item.is_permission_assigned"
                                ></v-checkbox>
                            </v-col>
                        </v-row>
                    </template>
                </v-data-table>
                <v-divider class="ml-3 mr-3 mt-0"></v-divider>
                <v-row align="center" justify="end" class="mr-5">
                    <v-btn
                        class="ma-2 rounded"
                        tile
                        color="primary"
                        :disabled="
                            isPermissionDataProcessing || tableDataLoading
                        "
                        @click="assignPermission"
                        >{{
                            isPermissionDataProcessing == true
                                ? $t("label_processing")
                                : $t("label_save")
                        }}</v-btn
                    >
                    <v-btn
                        class="ma-2 rounded"
                        outlined
                        tile
                        color="warning"
                        :disabled="
                            tableDataLoading || isPermissionDataProcessing
                        "
                        dark
                        @click="resetPermission"
                        >{{ $t("label_button_reset") }}</v-btn
                    >
                </v-row>
            </v-card>
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
export default {
    data() {
        return {
            //   Datatable Start
            tableDataLoading: false,
            tableLoadingDataText: this.$t("label_loading_data"),
            tableHeaders: [
                { text: "#", value: "sno", width: "10%" },
                {
                    text: this.$t("label_module"),
                    value: "Module",
                    width: "90%"
                },
                {
                    text: this.$t("label_permission"),
                    value: "permission_name",
                    width: "60%"
                },
                {
                    text: this.$t("label_actions"),
                    value: "is_permission_assigned",
                    width: "20%",
                    align: "End"
                }
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
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.tableItems = data;
                        data.map(val => {
                            if (val.is_permission_assigned == 1) {
                                this.selectedPermissionId.push(
                                    val.permission_id
                                );
                            }
                        });
                    }
                })
                .catch(error => {
                    this.tableDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
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
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_permission_assigned")
                                );
                                this.getAssignedUnAssignedPermissionRoleWise();
                            } else if (data.responseData == 2) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isPermissionDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
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
        },

        // Disable School Source
        assignPermission(item, $event) {
            console.log(item, this.$route.params.roleId);
            this.isPermissionDataProcessing = true;
            this.$http
                .post(
                    "web_assign_individual_permission_role_wise",
                    {
                        roleId: this.$route.params.roleId,
                        permissionId: item.permission_id,
                        is_permission_assigned: item.is_permission_assigned
                    },
                    this.authorizationConfig
                )
                .then(({ data }) => {
                    this.isPermissionDataProcessing = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        // School Source Disabled
                        if (data.responseData == 1) {
                            this.snackBarColor = "success";
                            this.changeSnackBarMessage("Permission updated");
                        }
                        // School Source Disabled failed
                        else if (data.responseData == 2) {
                            this.snackBarColor = "error";
                            this.changeSnackBarMessage(
                                this.$t("label_something_went_wrong")
                            );
                        }
                    }
                })
                .catch(error => {
                    this.isPermissionDataProcessing = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
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
<style scoped>
.v-messages {
    flex: 1 1 auto;
    font-size: 12px;
    min-width: 1px;
    position: relative;
}
</style>
