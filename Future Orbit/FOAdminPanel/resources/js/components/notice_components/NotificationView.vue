<template>
    <div id="app">
        <v-container
            fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
        >
            <v-overlay :value="isLoaderActive" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
            <v-sheet class="pa-4 mb-4" color="text-white">
                <v-row
                    justify="space-around"
                    style="
                        margin-right: 1px !important;
                        margin-left: -1px !important;
                    "
                    class="mb-4 mt-1"
                    dense
                >
                    <v-toolbar-title dark color="primary">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">
                                    <strong>
                                        {{
                                            this.$t("label_notification")
                                        }}</strong
                                    >
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    >Home
                                    <v-icon>mdi-forward</v-icon> Communication
                                    <v-icon>mdi-forward</v-icon>
                                    {{ this.$t("label_notification") }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-permission="'Add Notification'"
                        v-if="!isAddCardVisible"
                        :disabled="tableDataLoading"
                        color="primary"
                        class="white--text"
                        @click="isAddCardVisible = !isAddCardVisible"
                    >
                        Add Notification
                        <v-icon right dark> mdi-plus </v-icon>
                    </v-btn>
                </v-row>
            </v-sheet>
            <transition name="fade" mode="out-in">
                <v-card v-if="isAddCardVisible">
                    <v-app-bar dark color="grey" flat>
                        <v-toolbar-title color="success"
                            >Add New Notification</v-toolbar-title
                        >
                    </v-app-bar>
                    <v-form
                        ref="saveNotificationForm"
                        v-model="isSaveNotificationFormValid"
                        lazy-validation
                    >
                        <v-row dense class="ma-4">
                            <v-col cols="12" md="12" sm="12">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="title"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        Title
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>
                        <v-row class="ma-2">
                            <v-col cols="12" md="6" sm="12">
                                <v-select
                                    outlined
                                    dense
                                    v-model="receiverType"
                                    :items="[
                                        'Batch',
                                        'Staff',
                                        'External Student',
                                    ]"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                    @change="getStaffExternalStudent()"
                                >
                                    <template #label>
                                        Receiver Type
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-select>
                            </v-col>
                            <v-col cols="12" md="6" sm="12">
                                <v-select
                                    v-if="
                                        receiverType == 'Staff' ||
                                        receiverType == 'External Student'
                                    "
                                    outlined
                                    dense
                                    v-model="userId"
                                    :items="userItems"
                                    multiple
                                    :disabled="isSourceDataLoading"
                                    item-text="lms_full_name"
                                    item-value="lms_user_id"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        Receiver
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-select>

                                <v-select
                                    v-if="receiverType == 'Batch'"
                                    outlined
                                    dense
                                    v-model="batchId"
                                    :items="batchItems"
                                    :disabled="isSourceDataLoading"
                                    item-text="lms_batch_name"
                                    item-value="lms_batch_id"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                    @change="getBatchStudent()"
                                >
                                    <template #label>
                                        Batch
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-select>
                            </v-col>
                        </v-row>
                        <v-row dense class="ma-4">
                            <v-col cols="12" md="4" sm="12">
                                <v-select
                                    outlined
                                    dense
                                    v-model="notificationHasImage"
                                    :items="['Yes', 'No']"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        Image Required
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-select>
                            </v-col>

                            <v-col
                                v-if="notificationHasImage == 'Yes'"
                                cols="12"
                                md="4"
                                sm="12"
                                class="pl-2 pr-4"
                            >
                                <v-file-input
                                    v-model="selectedNotificationImage"
                                    color="primary"
                                    outlined
                                    dense
                                    show-size
                                    accept="image/*"
                                    :rules="imageRule"
                                >
                                    <template
                                        v-slot:selection="{ index, text }"
                                    >
                                        <v-chip
                                            v-if="index < 2"
                                            color="primary"
                                            dark
                                            label
                                            small
                                            >{{ text }}</v-chip
                                        >
                                    </template>
                                    <template #label
                                        >Notification Image
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-file-input>
                            </v-col>
                            <v-col cols="12" sm="12" md="4" class="pl-2 pr-4">
                                <v-menu
                                    v-model="menu2"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="auto"
                                >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field
                                            v-model="notificatioDate"
                                            label="Notification Date"
                                            prepend-icon="mdi-calendar"
                                            readonly
                                            outlined
                                            dense
                                            v-bind="attrs"
                                            v-on="on"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                        v-model="notificatioDate"
                                        @input="menu2 = false"
                                    ></v-date-picker>
                                </v-menu>
                            </v-col>
                        </v-row>

                        <v-row dense class="ma-4">
                            <v-col cols="12" xs="12" sm="12" md="12">
                                <div id="app">
                                    <vue-editor
                                        v-model="body"
                                        :editor-toolbar="customToolbar"
                                        :rules="[
                                            (v) => !!v || $t('label_required'),
                                        ]"
                                    >
                                        ></vue-editor
                                    >
                                </div>
                            </v-col>
                        </v-row>

                        <v-card-actions>
                            <v-btn
                                class="ma-2 rounded"
                                tile
                                color="primary"
                                :disabled="
                                    !isSaveNotificationFormValid ||
                                    isSaveFormDataProcessing
                                "
                                @click="saveNotification"
                                >{{
                                    isSaveFormDataProcessing == true
                                        ? $t("label_processing")
                                        : $t("label_save")
                                }}</v-btn
                            >

                            <v-btn
                                class="ma-2 rounded"
                                tile
                                color="error"
                                :disabled="
                                    !isSaveNotificationFormValid ||
                                    isSaveFormDataProcessing
                                "
                                @click="
                                    isAddCardVisible = !isAddCardVisible;
                                    resetForm();
                                "
                                >{{
                                    isSaveFormDataProcessing == true
                                        ? $t("label_processing")
                                        : $t("label_cancel")
                                }}</v-btn
                            >
                        </v-card-actions>
                    </v-form>
                </v-card>
            </transition>
            <transition name="fade" mode="out-in">
                <v-data-table
                    dense
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    item-key="notification_id"
                    class="elevation-0"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="50"
                    :single-expand="singleExpand"
                    :expanded.sync="expanded"
                    show-expand
                    @pagination="getAllNotification"
                    :footer-props="{
                        itemsPerPageOptions: [50, 100, 150, 200, -1],
                    }"
                >
                    <template v-slot:expanded-item="{ headers, item }">
                        <td :colspan="headers.length">
                            <v-col cols="12" md="2">
                                <v-avatar
                                    v-if="item.notification_has_image == 1"
                                    rounded
                                    height="100"
                                    width="auto"
                                >
                                    <img
                                        :src="
                                            buildNotificationImages(
                                                item.notification_image
                                            )
                                        "
                                        :lazy-src="
                                            buildNotificationImages(
                                                item.notification_image
                                            )
                                        "
                                    /> </v-avatar
                            ></v-col>
                            <v-col cols="12" md="9">
                                <div
                                    v-html="item.notification_body"
                                    style="align-content: center"
                                ></div
                            ></v-col>
                        </td>
                    </template>
                    <template v-slot:no-data>
                        <p
                            class="font-weight-black bold title"
                            style="color: red"
                        >
                            {{ $t("label_no_data_found") }}
                        </p>
                    </template>

                    <template v-slot:item.notification_image="{ item }">
                        <v-avatar
                            v-if="item.notification_has_image == 1"
                            rounded
                            height="50"
                            width="50"
                            class="ma-2"
                        >
                            <img
                                :src="
                                    buildNotificationImages(
                                        item.notification_image
                                    )
                                "
                                :lazy-src="
                                    buildNotificationImages(
                                        item.notification_image
                                    )
                                "
                            />
                        </v-avatar>
                        <v-avatar
                            v-if="item.notification_has_image == 0"
                            rounded
                            color="grey"
                            height="50"
                            width="50"
                            class="ma-2"
                        >
                            <v-icon dark>mdi-image</v-icon>
                        </v-avatar>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-icon
                            color="error"
                            @click="deleteNotification(item)"
                            v-permission="'Delete Notification'"
                            >mdi-delete</v-icon
                        >
                    </template>
                </v-data-table>
            </transition>

            <!-- Card End -->

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

import { VueEditor } from "vue2-editor";
import katex from "katex";
import "katex/dist/katex.min.css";

export default {
    components: {
        VueEditor,
    },
    props: ["userPermissionDataProps"],

    data() {
        return {
            customToolbar: [
                [{ header: [1, 2, 3, 4, 5, 6, false] }],
                ["bold", "italic", "underline", "strike", { align: [] }],

                ["blockquote", "code-block"],

                [{ list: "ordered" }, { list: "bullet" }],
                [{ script: "sub" }, { script: "super" }],
                [{ indent: "-1" }, { indent: "+1" }],
                [{ direction: "rtl" }],

                [{ color: [] }, { background: [] }],
            ],

            // Save Notification
            isAddCardVisible: false,
            menu2: "",
            title: "",
            receiverType: "Batch",
            userId: [],
            userItems: [],
            batchId: "",
            batchItems: [],
            imageRule: [],
            notificationHasImage: "",
            selectedNotificationImage: null,
            body: "",
            isSaveNotificationFormValid: true,
            isSaveFormDataProcessing: false,
            notificatioDate: new Date(
                Date.now() - new Date().getTimezoneOffset() * 60000
            )
                .toISOString()
                .substr(0, 10),
            menu: false,

            // common
            authorizationConfig: "",
            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",

            //   Datatable Start
            notificationImageUrl: process.env.MIX_NOTIFICATION_IMAGE_URL,
            expanded: [],
            singleExpand: true,
            isLoaderActive: false,
            tableDataLoading: false,
            totalItemsInDB: 0,
            tableLoadingDataText: this.$t("label_loading_data"),
            notificationImagesUrl: "",
            tableHeader: [
                {
                    text: "#",
                    value: "index",
                    width: "5%",
                    sortable: false,
                    groupable: true,
                },
                {
                    text: "Image",
                    value: "notification_image",
                    width: "20%",
                    sortable: false,
                },
                {
                    text: "Title",
                    value: "notification_title",
                    width: "50%",
                    sortable: false,
                },

                {
                    text: "Notification Date",
                    value: "notification_to_be_send_date",
                    width: "15%",
                    sortable: false,
                },

                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "10%",
                    align: "middle",
                },
                {
                    text: "Description",
                    width: "10%",
                    value: "data-table-expand",
                    align: "end",
                },
            ],
            tableItems: [],
        };
    },
    watch: {
        selectedNotificationImage(val) {
            this.selectedNotificationImage = val;

            this.imageRule =
                this.selectedNotificationImage != null
                    ? [
                          (v) =>
                              !v ||
                              v.size <= 1048576 ||
                              this.$t("label_file_size_criteria_1_mb"),
                      ]
                    : [];
        },
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
        // get batch
        this.getBatch();
        this.notificationImagesUrl = process.env.MIX_NOTIFICATION_IMAGE_URL;
    },

    methods: {
        resetForm() {
            this.$refs.saveNotificationForm.reset();
            this.body = null;
        },
        buildNotificationImages(images) {
            return this.notificationImagesUrl + images;
        },
        // get batch
        getBatch() {
            this.isSourceDataLoading = true;
            this.$http
                .get(
                    `web_get_all_batch_without_pagination`,
                    this.authorizationConfig
                )
                .then(({ data }) => {
                    this.isSourceDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.batchItems = data;
                    }
                })
                .catch((error) => {
                    this.isSourceDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        //get batch student
        getBatchStudent() {
            this.isSourceDataLoading = true;
            this.$http
                .get(`web_get_get_all_student_batch_wise`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        lms_batch_id: this.batchId,
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
                        this.userId = [];
                        for (let x in data) {
                            this.userId.push(data[x].lms_user_id);
                        }
                    }
                })
                .catch((error) => {
                    this.isSourceDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },

        getStaffExternalStudent() {
            if (this.receiverType == "Staff") {
                this.isSourceDataLoading = true;
                this.$http
                    .get(`web_get_all_staff_without_pagination`, {
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
                            this.userItems = data;

                            this.userId = [];
                            for (let x in data) {
                                this.userId.push(data[x].lms_user_id);
                            }
                        }
                    })
                    .catch((error) => {
                        this.isSourceDataLoading = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            } else if (this.receiverType == "External Student") {
                this.isSourceDataLoading = true;
                this.$http
                    .get(
                        `web_get_all_students_not_in_batch_without_pagination`,
                        {
                            headers: {
                                Authorization: "Bearer " + ls.get("token"),
                            },
                        }
                    )
                    .then(({ data }) => {
                        this.isSourceDataLoading = false;
                        //User Unauthorized
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            this.userItems = data;

                            this.userId = [];
                            for (let x in data) {
                                this.userId.push(data[x].lms_user_id);
                            }
                        }
                    })
                    .catch((error) => {
                        this.isSourceDataLoading = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },

        // Disable Course status
        deleteNotification(item, $event) {
            let userDecision = confirm(
                "Are you sure to delete the notification"
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_delete_notification",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            notification_id: item.notification_id,
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
                            // Course Disabled
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    "Notice deleted successfully"
                                );
                                this.getAllNotification(event);
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
                    .catch((error) => {
                        this.isLoaderActive = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },
        // To ensure course name is character and space only
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
        // Save Subject To DB after validation
        saveNotification($event) {
            if (this.$refs.saveNotificationForm.validate()) {
                this.isSaveFormDataProcessing = true;
                let postData = new FormData();
                postData.append("title", this.title);
                postData.append("body", this.body);
                if (this.selectedNotificationImage != null) {
                    postData.append(
                        "notificationImage",
                        this.selectedNotificationImage
                    );
                }
                postData.append(
                    "notificationHasImage",
                    this.notificationHasImage == "Yes" ? "1" : "0"
                );
                postData.append("userId", this.userId);

                postData.append("loggedUserId", ls.get("loggedUserId"));
                postData.append("notificationDate", this.notificatioDate);

                this.$http
                    .post(
                        "web_save_notification",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isSaveFormDataProcessing = false;
                        //User Unauthorized
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            if (data.Result == "Success") {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    "Notification Saved"
                                );
                                this.getAllNotification(event);
                            } else if (data.responseData == "fail") {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    "Something went wrong"
                                );
                            }

                            // // Image upload failed
                            else if (data.Result == "ImageUploadFailed") {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_image_upload_failed")
                                );
                            }
                        }
                    })
                    .catch((error) => {
                        this.isSaveFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Topic from DB
        getAllNotification(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_notification?page=${e.page}`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        perPage:
                            e.itemsPerPage == -1
                                ? this.totalItemsInDB
                                : e.itemsPerPage,
                    },
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
                    }
                })
                .catch((error) => {
                    this.tableDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
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
