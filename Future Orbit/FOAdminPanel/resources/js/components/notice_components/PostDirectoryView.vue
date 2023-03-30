<template>
    <div id="app">
        <!-- Card Start -->
        <v-container
            fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
        >
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
            <v-sheet class="pa-4 mb-4" color="text-white">
                    <v-toolbar-title dark color="primary">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">
                                    <strong>Post Directory</strong>
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    >Home
                                    <v-icon>mdi-forward</v-icon> Communication
                                    <v-icon>mdi-forward</v-icon>
                                    Post</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-toolbar-title>
            </v-sheet>
            <transition name="fade" mode="out-in">
                <v-data-table
                    dense
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    item-key="lms_enquiry_id"
                    class="elevation-1"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="100"
                    @pagination="getAllPost"
                    :footer-props="{
                        itemsPerPageOptions: [100, 200, 300, -1],
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
                    <template v-slot:item.lms_post_is_active="{ item }">
                        <v-chip
                            x-small
                            :color="getStatusColor(item.lms_post_is_active)"
                            dark
                            >{{ item.lms_post_is_active }}</v-chip
                        >
                    </template>

                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-select
                                v-if="false"
                                class="mt-4"
                                v-model="selectedSource"
                                :disabled="isSourceDataLoading"
                                :items="sourceData"
                                prepend-inner-icon="mdi-filter-outline"
                                dense
                                :label="lblSelectSource"
                                item-text="lms_information_source_name"
                                item-value="lms_information_source_name"
                                @change="
                                    isSearchByPost = true;
                                    getAllPost($event);
                                "
                            ></v-select>
                            <v-text-field
                                prepend-inner-icon="mdi-magnify"
                                class="mt-4 mx-4"
                                :disabled="isSourceDataLoading"
                                v-model="postSearchCriteria"
                                :label="lblSearchStudentCriteria"
                                @input="
                                    isSearchByPost = false;
                                    getAllPost($event);
                                "
                            ></v-text-field>
                            <v-spacer></v-spacer>
                            <v-spacer></v-spacer>
                            <v-btn
                                icon
                                small
                                color="teal"
                                class="mx-1"
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
                                class="mx-1"
                                icon
                                small
                                color="red"
                                @click="savePDF"
                            >
                                <v-icon dark>mdi-file-pdf</v-icon>
                            </v-btn>
                        </v-toolbar>
                    </template>
                    <template v-slot:item.lms_post_image="{ item }">
                        <v-avatar
                            v-if="item.lms_post_has_image == 1"
                            @click="viewPostContent(item)"
                        >
                            <img
                                :src="buildPostImages(item.lms_post_image)"
                                :lazy-src="buildPostImages(item.lms_post_image)"
                            />
                        </v-avatar>
                    </template>
                    <template v-slot:item.lms_is_post_approved="{ item }">
                        <v-chip
                            @click="approvePost(item)"
                            v-if="item.lms_is_post_approved == 'Protected'"
                            x-small
                            :color="getApprovalColor(item.lms_is_post_approved)"
                            dark
                            >{{ item.lms_is_post_approved }}</v-chip
                        >

                        <v-chip
                            @click="approvePost(item)"
                            v-if="item.lms_is_post_approved == 'Approved'"
                            x-small
                            :color="getApprovalColor(item.lms_is_post_approved)"
                            dark
                            >{{ item.lms_is_post_approved }}</v-chip
                        >
                    </template></v-data-table
                >
            </transition>
        </v-container>
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

        <v-dialog v-model="DialogPostContent" width="500">
            <v-card>
                <v-card-title class="text-h5 grey lighten-2">
                    Post Uploaded By: {{ postUploadedBy }}
                </v-card-title>

                <v-card-text>
                    {{ postContent }}
                </v-card-text>

                <v-divider></v-divider>

                <div
                    class="d-flex flex-column justify-space-between align-center"
                >
                    <v-img
                        height="auto"
                        :width="width"
                        :src="postImage"
                        :lazy-src="postImage"
                    ></v-img>

                    <v-slider
                        v-model="width"
                        class="align-self-stretch"
                        min="200"
                        max="500"
                        step="1"
                    ></v-slider>
                </div>

                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="primary"
                        text
                        @click="DialogPostContent = false"
                    >
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
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
            // Form Data
            lblSelectSource: this.$t("label_select_source"),
            selectedSource: "",
            isDataProcessing: false,
            postSearchCriteria: "",
            lblSearchStudentCriteria: "Search Post",
            isSourceDataLoading: false,
            sourceData: [],
            isSearchByPost: false,
            authorizationConfig: "",
            postImagesUrl: "",
            DialogPostContent: false,
            postImage: "",
            postUploadedBy: "",
            postContent: "",
            width: 200,
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
                    text: "Content",
                    value: "lms_post_content",
                    width: "40%",
                    sortable: false,
                },
                {
                    text: "Date",
                    value: "lms_post_created_at",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Uploaded By",
                    value: "full_name",
                    width: "20%",
                    sortable: false,
                },
                {
                    text: "Image",
                    value: "lms_post_image",
                    width: "20%",
                    sortable: false,
                },

                {
                    text: "IsApproved",
                    value: "lms_is_post_approved",
                    width: "10%",
                    sortable: false,
                },
            ],
            tableItems: [],
            isDataProcessing: false,

            //Datatable End

            // For Excel Download
            excelFields: {
                Code: "lms_registration_code",
                Date: "lms_student_course_mapping_created_at",
                Name: "lms_student_full_name",
                Mobile: "lms_student_mobile_number",
                StudetId: "lms_student_code",
            },
            excelData: [],
            excelFileName:
                "PostList" + "_" + moment().format("DD/MM/YYYY") + ".xls",
        };
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
        this.postImagesUrl = process.env.MIX_POST_IMAGE_URL;
    },

    methods: {
        viewPostContent(item) {
            this.postContent = item.lms_post_content;
            this.postUploadedBy = item.full_name;
            this.postImage = this.postImagesUrl + item.lms_post_image;
            this.DialogPostContent = true;
            return item;
        },
        buildPostImages(images) {
            return this.postImagesUrl + images;
        },
        // Enable  Disable Staff Status
        approvePost(item, $event) {
            let userDecision = confirm("Are you sure you want to approve post");
            if (userDecision) {
                this.isDataProcessing = true;
                this.dialog = true;
                //Set Dialog
                this.$http
                    .post(
                        "web_is_approve_post",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            loggedUserId: ls.get("loggedUserId"),
                            postId: item.lms_post_id,
                            isApproved:
                                item.lms_is_post_approved == "1" ? 0 : 1,
                        },
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isDataProcessing = false;
                        this.dialog = false;
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
                                this.changeSnackBarMessage("Post Approved");
                                this.getAllPost(event);
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
                    .catch((error) => {
                        this.isDataProcessing = false;
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

        // Get all Students from DB
        getAllPost(e) {
            this.tableDataLoading = true;
            let postData = "";

            if (this.isSearchByPost == true) {
                postData = {
                    centerId: ls.get("loggedUserCenterId"),
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDB
                            : e.itemsPerPage,
                    filterBy: this.selectedSource,
                };
            } else {
                postData = {
                    centerId: ls.get("loggedUserCenterId"),
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDB
                            : e.itemsPerPage,
                    filterBy: this.postSearchCriteria,
                };
            }

            this.$http
                .get(`web_get_all_post?page=${e.page}`, {
                    params: postData,
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
                        this.excelData = data.data;
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

        // Approved | Not Approved
        getApprovalColor(is_source_approved) {
            if (is_source_approved == "Protected") return "error";
            if (is_source_approved == "Approved") return "success";
            else return "error";
        },
        // Source Status Color
        getStatusColor(is_source_acive) {
            if (is_source_acive == "Active") return "success";
            if (is_source_acive == "Online") return "primary";
            if (is_source_acive == "Internal") return "success";
            if (is_source_acive == "Closed") return "warning";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    {
                        header: "Registration",
                        dataKey: "lms_registration_code",
                    },
                    { header: "Name", dataKey: "lms_student_full_name" },
                    {
                        header: "Date",
                        dataKey: "lms_student_course_mapping_created_at",
                    },
                    {
                        header: "Mobile Number",
                        dataKey: "lms_student_mobile_number",
                    },
                    { header: "Status", dataKey: "lms_post_is_active" },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "StudentListAsPDF" +
                    "_" +
                    moment().format("DD/MM/YYYY") +
                    ".pdf"
            );
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
