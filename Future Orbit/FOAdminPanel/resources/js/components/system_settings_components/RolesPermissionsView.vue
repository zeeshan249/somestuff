<template>
    <div id="app">
        <!-- Card Start -->
        <v-container
        fluid
        style="background-color: #e4e8e4; max-width: 100% !important" 
        >
            <v-progress-linear
                :active="isRoleDataProcessing"
                :indeterminate="isRoleDataProcessing"
                height="10"
                absolute
                top
                color="primary"
                background-color="primary lighten-3"
                striped
            ></v-progress-linear>
            <v-sheet class="pa-4 mb-4" >
            <v-row class="ml-4 mr-4 pt-4">
                <v-toolbar-title dark color="primary">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                <strong>{{
                                    this.$t("label_roles_and_permissions")
                                }}</strong>
                            </v-list-item-title>
                            <v-list-item-subtitle
                                >Home <v-icon>mdi-forward</v-icon>
                                {{ this.$t("label_system_settings") }}
                                <v-icon>mdi-forward</v-icon>
                                {{
                                    this.$t("label_roles_and_permissions")
                                }}</v-list-item-subtitle
                            >
                        </v-list-item-content>
                    </v-list-item>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                    v-permission="'Add Role'"
                    v-if="!isAddRoleCardVisible"
                    :disabled="tableDataLoading"
                    color="primary"
                    class="white--text mr-4 mt-4"
                    @click="isAddRoleCardVisible = !isAddRoleCardVisible"
                >
                    <v-icon class="mr-2" color="white">mdi-account-plus</v-icon>
                    Add New Role
                </v-btn>
            </v-row>
        </v-sheet>
            <v-card v-if="isAddRoleCardVisible" flat elevation="0">
                <v-app-bar dark color="grey" flat>
                    <v-toolbar-title color="success" class="title"
                        >Add New Role</v-toolbar-title
                    >
                    <v-spacer></v-spacer>
                    <v-btn icon class="ma-2" outlined small color="white">
                        <v-icon
                            color="white"
                            @click="
                                isAddRoleCardVisible = !isAddRoleCardVisible
                            "
                            >mdi-minus</v-icon
                        >
                    </v-btn>
                </v-app-bar>

                <v-container>
                    <v-form
                        ref="saveRoleForm"
                        v-model="isSaveRoleFormValid"
                        lazy-validation
                    >
                        <v-row dense>
                            <v-col cols="12" xs="12" sm="12" md="8">
                                <v-text-field
                                    :label="roleNameLabel"
                                    :hint="roleNameHint"
                                    class="ml-4"
                                    v-model="roleName"
                                    :rules="roleRules"
                                    type="text"
                                    clearable
                                    @keypress="isCharacters"
                                ></v-text-field>
                            </v-col>
                            <v-col cols="12" xs="12" sm="12" md="4">
                                <v-btn
                                    v-permission="'Add Role' | 'Edit Role'"
                                    class="ma-2 rounded"
                                    tile
                                    color="primary"
                                    :disabled="
                                        !isSaveRoleFormValid ||
                                            isSaveRoleFormDataProcessing
                                    "
                                    @click="saveRole"
                                    >{{
                                        isSaveRoleFormDataProcessing == true
                                            ? $t("label_processing")
                                            : $t("label_save")
                                    }}</v-btn
                                >
                            </v-col>
                        </v-row>
                    </v-form>
                </v-container>
            </v-card>

            <transition name="fade" mode="out-in">
                <v-data-table
                    dense
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    item-key="id"
                    class="elevation-1"
                    :options.sync="options"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="50"
                    @pagination="getAllRole"
                    :footer-props="{
                        itemsPerPageOptions: [50, 100, 150, -1]
                    }"
                >
                    <template v-slot:no-data>
                        <p
                            class="font-weight-black bold title"
                            style="color:red"
                        >
                            {{ $t("label_no_data_found") }}
                        </p>
                    </template>
                    <template
                        v-slot:item.is_role_active="{
                            item
                        }"
                    >
                        <v-chip
                            x-small
                            :color="getRoleStatusColor(item.is_role_active)"
                            dark
                            >{{ item.is_role_active }}</v-chip
                        >
                    </template>
                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-spacer></v-spacer>
                            <v-switch
                                class="pt-4 mx-1"
                                v-if="!tableDataLoading"
                                inset
                                v-model="includeDelete"
                                @change="getAllRole"
                            ></v-switch>
                            <v-btn
                                icon
                                small
                                color="teal"
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
                            v-permission="'Edit Role'"
                            small
                            class="mr-2"
                            @click="editRole(item)"
                            color="primary"
                            >mdi-pencil</v-icon
                        >
                        <v-icon
                            v-permission="'Assign Permission'"
                            small
                            class="mr-2"
                            @click="assignPermission(item)"
                            color="teal"
                            >mdi-bookmark-check</v-icon
                        >
                        <v-icon
                            v-if="item.is_role_active == 'Active'"
                            v-permission="'Edit Role'"
                            small
                            color="error"
                            @click="disableRole(item)"
                            >mdi-delete</v-icon
                        >
                        <v-icon
                            v-if="item.is_role_active == 'Inactive'"
                            v-permission="'Edit Role'"
                            small
                            color="success"
                            @click="disableRole(item)"
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

//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
    props: ["userPermissionDataProps"],

    data() {
        return {
            includeDelete: false,
            // Form Labels
            roleNameLabel: this.$t("label_role_name"),
            roleNameHint: this.$t("label_enter_role_name"),

            // Form Inputs and Validation Authorization
            isSaveRoleFormValid: true,
            isSaveRoleFormDataProcessing: false,
            roleName: "",
            roleRules: [v => !!v || this.$t("label_role_name_required")],
            authorizationConfig: "",

            // Snack Bar

            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",

            //   Datatable Start

            tableDataLoading: false,
            totalItemsInDB: 0,
            tableLoadingDataText: this.$t("label_loading_data"),
            options: {
                sortBy: ["name"],
                sortDesc: [true]
            },

            tableHeader: [
                { text: "#", value: "index", width: "10%", sortable: false },
                {
                    text: this.$t("label_role_name"),
                    value: "name",
                    width: "50%"
                },
                {
                    text: this.$t("label_role_status"),
                    value: "is_role_active",
                    align: "middle",
                    width: "20%"
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
            isRoleDataProcessing: false,
            isSaveEditClicked: 1,
            editRoleId: "",
            //Datatable End

            // For Add role card
            isAddRoleCardVisible: false,

            // For Excel Download
            excelFields: {
                "Role Name": "name",
                Status: "is_role_active"
            },
            excelData: [],
            excelFileName:
                "RoleListAsExcel" + "_" + moment().format("DD/MM/YYYY") + ".xls"
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

    watch: {
        // For Datatable
        options: {
            handler(e) {
                this.getAllRole(e);
            }
        }
    },

    methods: {
        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },
        // Assign permission
        assignPermission(item) {
            this.$router.push({
                name: "SystemSettingsAssignPermissions",
                params: { roleId: item.id }
            });
        },
        // Edit Role Name

        editRole(item) {
            this.isAddRoleCardVisible = true;
            this.editRoleId = item.id;
            this.isSaveEditClicked = 0;
            this.roleName = item.name;
        },
        // Disable role status
        disableRole(item, $event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_role")
            );
            if (userDecision) {
                this.isRoleDataProcessing = true;
                this.$http
                    .post(
                        "web_update_role",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            roleName: item.name,
                            roleId: item.id,
                            isRoleActive:
                                item.is_role_active == "Active" ? 0 : 1
                        },
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isRoleDataProcessing = false;
                        //User Unauthorized
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            // Role Disabled
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_role_status_changed")
                                );
                                this.getAllRole(event);
                            }
                            // Role Disabled failed
                            else if (data.responseData == 2) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isRoleDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },
        // To ensure role name is character and space only
        isCharacters(evt) {
            var regex = new RegExp("^[a-zA-Z ]+$");
            var key = String.fromCharCode(
                !evt.charCode ? evt.which : evt.charCode
            );
            if (!regex.test(key)) {
                evt.preventDefault();
                return false;
            }
        },
        // Save Role To DB after validation
        saveRole($event) {
            if (this.$refs.saveRoleForm.validate()) {
                this.isSaveRoleFormDataProcessing = true;
                let postData;
                if (this.isSaveEditClicked == 1) {
                    postData = {
                        roleName: this.roleName,
                        isSaveEditClicked: 1,
                        centerId: ls.get("loggedUserCenterId")
                    };
                } else {
                    postData = {
                        roleName: this.roleName,
                        roleId: this.editRoleId,
                        isSaveEditClicked: 0,
                        centerId: ls.get("loggedUserCenterId")
                    };
                }
                this.$http
                    .post("web_save_role", postData, this.authorizationConfig)
                    .then(({ data }) => {
                        this.isSaveRoleFormDataProcessing = false;
                        //User Unauthorized
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            // Server side validation fails
                            if (data.responseData == 0) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(data.error);
                            }
                            // Role Exists
                            else if (data.responseData == 1) {
                                this.snackBarColor = "info";
                                this.changeSnackBarMessage(
                                    this.$t("label_role_exists")
                                );
                            }
                            // Role Saved
                            else if (data.responseData == 2) {
                                this.roleName = "";
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_role_saved")
                                );
                                this.getAllRole(event);
                                this.isSaveEditClicked = 1;
                            }
                            // Failed to save role
                            else if (data.responseData == 3) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }

                            // Role Updated
                            else if (data.responseData == 4) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_role_name_updated")
                                );
                                this.getAllRole(event);
                                this.isSaveEditClicked = 1;
                                this.roleName = "";
                            }
                            // Role update failed
                            else if (data.responseData == 5) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isSaveRoleFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all role from DB
        getAllRole(e) {
            this.tableDataLoading = true;
            const sortBy =
                this.options.sortBy.length == 0
                    ? "name"
                    : this.options.sortBy[0];
            const orderBy =
                this.options.sortDesc.length > 0 && this.options.sortDesc[0]
                    ? "asc"
                    : "desc";
            this.$http
                .get(`web_get_all_roles?page=${e.page}`, {
                    params: {
                        includeDelete: this.includeDelete,
                        centerId: ls.get("loggedUserCenterId"),
                        perPage:
                            e.itemsPerPage == -1
                                ? this.totalItemsInDB
                                : e.itemsPerPage,
                        sortBy: sortBy,
                        orderBy: orderBy
                    },
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
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        // Role Status Color
        getRoleStatusColor(is_role_active) {
            if (is_role_active == "Active") return "success";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    { header: "Role", dataKey: "name" },
                    { header: "Status", dataKey: "is_role_active" }
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 }
            });
            pdfDoc.save(
                "RoleListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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
