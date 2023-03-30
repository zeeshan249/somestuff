<template>
    <div style="background-color: #d7d8db; height:100%" id="app">
        <v-container
            style="background-color: #fff"
            class="ma-4 pa-0"
            width="100%"
        >
            <!-- Card Start -->
            <v-overlay :value="isLoaderActive" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
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
            </v-row>

            <transition name="fade" mode="out-in">
                <v-card>
                    <v-row>
                        <v-carousel>
                            <v-carousel-item
                                v-for="(item, i) in items"
                                :key="i"
                                :src="item.src"
                                reverse-transition="fade-transition"
                                transition="fade-transition"
                            ></v-carousel-item>
                        </v-carousel>
                    </v-row>
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
    props: ["userPermissionDataProps", "assignmentDataProps"],

    data() {
        return {
            isLoaderActive: false,

            authorizationConfig: "",
            tableItems: [],

            // Snack Bar

            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",

            items: []
        };
    },
    watch: {},
    computed: {
        // For numbering the Data Table Rows
        //End
    },

    created() {
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") }
        };
        this.getSubmittedAssignmentDetail();
    },

    methods: {
        // Get all Subject from DB
        getSubmittedAssignmentDetail() {
            this.isLoaderActive = true;

            this.$http

                .get(`web_get_submitted_assignment_details`, {
                    params: {
                        assignmentId: this.assignmentDataProps
                            .lms_assignment_id,
                        studentId: this.assignmentDataProps.lms_student_id
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
                })
                .then(({ data }) => {
                    this.isLoaderActive = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.items = data;
                    }
                })
                .catch(error => {
                    this.isLoaderActive = false;
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
        evaluateAssignment() {
            let userDecision = confirm("Are you sure to evaluate assignment");
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_evaluate_assignment",
                        {
                            assignmentId: this.assignmentDataProps
                                .lms_assignment_id,
                            studentId: this.assignmentDataProps.lms_student_id,
                            loggedUserId: ls.get("loggedUserId")
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
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    "Assignment Evaluated"
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
                    .catch(error => {
                        this.isLoaderActive = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
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
