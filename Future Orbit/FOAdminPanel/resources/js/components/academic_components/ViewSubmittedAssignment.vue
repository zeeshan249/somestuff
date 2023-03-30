<template>
    <div  id="app">
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
                                <strong> Evaluate Assignment</strong>
                            </v-list-item-title>
                            <v-list-item-subtitle
                                >Home <v-icon>mdi-forward</v-icon> Academics
                                <v-icon>mdi-forward</v-icon>
                                Evaluate Assignment</v-list-item-subtitle
                            >
                        </v-list-item-content>
                    </v-list-item>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                        color="primary"
                        class="white--text"
                       @click="showUserPage(null); "
                    >
                     Back
                    <v-icon right dark> mdi-arrow-left </v-icon>
              </v-btn>
            </v-row>
            </v-sheet>
            <transition name="fade" mode="out-in">
                <v-card>
                    <v-data-table
                        dense
                        :headers="tableHeader"
                        :items="dataTableRowNumbering"
                        item-key="lms_submitted_assignment_document_id"
                        class="elevation-1"
                        :loading="tableDataLoading"
                        :loading-text="tableLoadingDataText"
                        :server-items-length="totalItemsInDB"
                        :items-per-page="50"
                        @pagination="getAllAssignmentSubmittedByStudent"
                        :footer-props="{
                            itemsPerPageOptions: [25, 50, 100, 200, -1]
                        }"
                    >
                        <template v-slot:no-data>
                            <p
                                class="font-weight-black bold title"
                                style="color: red"
                            >
                                {{ $t("label_no_data_found") }}
                            </p>
                        </template>
                        <template
                            v-slot:item.lms_submitted_assignment_upload_status="{
                                item
                            }"
                        >
                            <v-chip
                                x-small
                                :color="
                                    getStatusColor(
                                        item.lms_submitted_assignment_evaluation_status
                                    )
                                "
                                dark
                                >{{
                                    item.lms_submitted_assignment_evaluation_status
                                }}</v-chip
                            >
                        </template>
                        <template
                                 v-slot:item.lms_submitted_assignment_document_path="{
                                item
                            }"
                        >
                            <v-btn
                                                            icon
                                                            @click="
                                                                downloadAssignment(
                                                                    item.lms_submitted_assignment_document_path
                                                                )
                                                            "
                                                        >
                                                            <v-icon
                                                                color="success lighten-1"
                                                                >mdi-download-circle</v-icon
                                                            >
                                                        </v-btn>
                        </template>

                        <template v-slot:item.actions="{ item }">
                            <v-icon
                            v-if="item.lms_submitted_assignment_evaluation_status == 'Not Evaluated'"
                            small
                            color="error"
                            @click="changeStatus(item)"
                            >mdi-check-circle</v-icon
                        >
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
import { Global } from "../../components/helpers/global"
//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";
import Vue from "vue";
import { createLogger } from "vuex";
Vue.use(DatetimePicker);

import VueMask from "v-mask";
Vue.use(VueMask);

export default {
    props: ["userPermissionDataProps","assignmentDataProps"],

    data() {
        return {
           
            isLoaderActive: false,

            authorizationConfig: "",
            tableItems: [],

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
                    text: "Title",
                    value: "lms_assignment_title",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Subject",
                    value: "lms_subject_name",
                    width: "15%",
                    sortable: false
                },
                {
                    text: "Topic",
                    value: "lms_topic_name",
                    width: "15%",
                    sortable: false
                },
                {
                    text: "Name",
                    value: "lms_student_full_name",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Code",
                    value: "lms_student_code",
                    width: "10%",
                    sortable: false
                },
             

                {
                    text: this.$t("label_status"),
                    value: "lms_submitted_assignment_upload_status",
                    align: "middle",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Document",
                    value: "lms_submitted_assignment_document_path",
                    width: "10%",
                    sortable: false
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "20%",
                    align: "end"
                    //yaha pe switch  hoga enable disable ka
                }
            ]
        };
    },
    watch: {},
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
             // Disable School Source
             async changeStatus(item, $event) {
            const result = await Global.showConfirmationAlert(
                "Are you sure, to Confirm Evaluation of Assignment?",
                
            
            );
            if (result.isConfirmed) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_evaluate_assignment",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            assignmentId: item.lms_assignment_id,
                            studentId: item.lms_student_id,
                            loggedUserId: ls.get("loggedUserId"),
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
                            console.log(data.responseData);
                            // School Source Disabled
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    "Assignment Evaluated"
                                );
                              //  this.dialogAddSchool = false;
                               
                            }
                            this.getAllAssignmentSubmittedByStudent(event);
                           
                        }
                    })
                    .catch((error) => {
                        this.isLoaderActive = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },
        showUserPage() {
      this.$router.push({
        name: "AssignmentView", 
      });
    },
        downloadAssignment(imageUrl) {
            console.log(imageUrl);
            this.isLoaderActive = true;
            this.downloadImageUrl = process.env.MIX_ASSIGNMENT_URL + imageUrl;
            axios({
                url: this.downloadImageUrl,
                method: "GET",
                responseType: "blob",
                headers: {
                    Authorization: "Bearer " + ls.get("token"),
                },
            })
                .then((response) => {
                    var fileURL = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    var fileLink = document.createElement("a");
                    fileLink.href = fileURL;
                    fileLink.setAttribute("download", imageUrl);

                    document.body.appendChild(fileLink);
                    fileLink.click();
                    this.isLoaderActive = false;
                })
                .catch((error) => {
                    this.isLoaderActive = true;
                });
        },
        // Get all Subject from DB
        getAllAssignmentSubmittedByStudent(e) {
        //  console.log("Assigenment id is",this.assignmentDataProps.lms_assignment_id);
            this.tableDataLoading = true;
            this.$http

                .get(`web_get_get_all_submitted_assignment?page=${e.page}`, {
                    params: {
                        perPage:
                            e.itemsPerPage == -1
                                ? this.totalItemsInDB
                                : e.itemsPerPage,
                        assignmentId:this.assignmentDataProps.lms_assignment_id
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
        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },

        // Course Status Color
        getStatusColor(is_assignment_upload_status_active) {
            if (is_assignment_upload_status_active == "Evaluated")
                return "success";
            else return "error";
        },

    //    viewAssignment(item) {
    //         this.$router.push({
    //             name: "SubmittedAssignmentDetails",
    //             params: { assignmentDataProps: item }
    //         });
    //      }
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
