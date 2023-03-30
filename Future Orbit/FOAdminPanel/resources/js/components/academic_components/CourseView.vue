<template>
    <!-- Card Start -->
    <v-container fluid style="max-width: 100% !important">
        <v-overlay :value="isLoaderActive" color="primary">
            <v-progress-circular
                indeterminate
                size="64"
                color="primary"
            ></v-progress-circular>
        </v-overlay>

        <transition name="fade" mode="out-in">
            <v-col class="d-flex flex-column pa-0 ma-0" v-if="isAddCardVisible">
                <v-card elevation="0">
                    <v-app-bar dark color="grey" class="pa-0" flat rounded="0">
                        <v-toolbar-title color="success">{{
                            $t("label_stream_add")
                        }}</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn icon class="ma-2" outlined small color="white">
                            <v-icon
                                color="white"
                                @click="isAddCardVisible = !isAddCardVisible"
                                >mdi-minus</v-icon
                            >
                        </v-btn>
                    </v-app-bar>

                    <v-form
                        ref="saveCourseForm"
                        v-model="isSaveCourseFormValid"
                        lazy-validation
                    >
                        <v-row dense class="mx-2 mt-4">
                            <v-col cols="12" xs="12" sm="12" md="6">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="courseCode"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_course_code") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" xs="12" sm="12" md="6">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="courseName"
                                    @keypress="isCharacters"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_course_name") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>

                        <v-row dense class="mx-2">
                            <v-col cols="12" xs="12" sm="12" md="12">
                                <v-textarea
                                    outlined
                                    dense
                                    v-model="courseDescription"
                                >
                                    <template #label>
                                        {{ $t("label_course_description") }}
                                        <span class="red--text"></span>
                                    </template>
                                </v-textarea>
                            </v-col>
                        </v-row>
                        <v-row dense class="mx-2">
                            <v-col cols="12" xs="12" sm="12" md="3">
                                <v-text-field
                                    outlined
                                    dense
                                    @keypress="isDigitWithDecimal"
                                    v-model="courseFees"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_course_fees") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" xs="12" sm="12" md="3">
                                <v-text-field
                                    outlined
                                    dense
                                    @keypress="isDigit"
                                    v-model="courseDuration"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_course_duration") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" xs="12" sm="12" md="6">
                                <v-file-input
                                    v-model="selectedCourseImage"
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
                                    <template #label>{{
                                        $t("label_course_image")
                                    }}</template>
                                </v-file-input>
                            </v-col>
                        </v-row>
                        <v-divider class="mx-4"></v-divider>
                        <div dense class="mx-2 text-center mb-2">
                            <v-btn
                                v-permission="'Add Course' | 'Edit Course'"
                                class="ma-2 rounded"
                                tile
                                color="primary"
                                :disabled="
                                    !isSaveCourseFormValid ||
                                    isSaveCourseFormDataProcessing
                                "
                                @click="isAddCardVisible = !isAddCardVisible"
                            >
                                <v-icon class="mr-2">mdi-content-save</v-icon>
                                {{
                                    isSaveCourseFormDataProcessing == true
                                        ? $t("label_processing")
                                        : $t("label_stream_save")
                                }}</v-btn
                            >

                            <v-btn
                                v-permission="'Add Course' | 'Edit Course'"
                                class="ma-2 rounded"
                                tile
                                color="error"
                                :disabled="
                                    !isSaveCourseFormValid ||
                                    isSaveCourseFormDataProcessing
                                "
                                @click="isAddCardVisible = !isAddCardVisible"
                            >
                                <v-icon class="mx-2">mdi-cancel</v-icon
                                >{{
                                    isSaveCourseFormDataProcessing == true
                                        ? $t("label_processing")
                                        : $t("label_cancel")
                                }}</v-btn
                            >
                        </div>
                        <v-divider class="mx-4"></v-divider>
                    </v-form>
                </v-card>
            </v-col>
        </transition>
        <!-- Card End -->

        <transition name="fade" mode="out-in">
            <v-data-table
                dense
                :headers="tableHeader"
                :items="dataTableRowNumbering"
                item-key="lms_course_id"
                :loading="tableDataLoading"
                :loading-text="tableLoadingDataText"
                :server-items-length="totalItemsInDB"
                :items-per-page="100"
                @pagination="getAllCourse"
                :footer-props="{
                    itemsPerPageOptions: [100, 200, 300, -1],
                }"
            >
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-text-field
                            v-model="searchText"
                            class="mt-4"
                            label="Search"
                            prepend-inner-icon="mdi-magnify"
                            @input="getAllCourse($event)"
                        ></v-text-field>
                        <v-spacer></v-spacer>
                        <v-spacer></v-spacer>
                        <v-switch
                            class="pt-4 mx-1"
                            v-if="!tableDataLoading"
                            inset
                            v-model="includeDelete"
                            @change="getAllCourse"
                        ></v-switch>

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
                        <v-btn
                            v-if="!isAddCardVisible"
                            :disabled="tableDataLoading"
                            color="primary"
                            class="white--text mx-2"
                            @click="isAddCardVisible = !isAddCardVisible"
                        >
                            {{ $t("label_stream_add") }}

                            <v-icon right dark> mdi-plus </v-icon>
                        </v-btn>
                    </v-toolbar>
                </template>
                <template v-slot:no-data>
                    <p class="font-weight-black bold title" style="color: red">
                        {{ $t("label_no_data_found") }}
                    </p>
                </template>
                <template v-slot:item.lms_course_is_active="{ item }">
                    <v-chip
                        x-small
                        :color="getStatusColor(item.lms_course_is_active)"
                        dark
                        >{{ item.lms_course_is_active }}</v-chip
                    >
                </template>

                <template v-slot:item.actions="{ item }">
                    <v-icon
                        v-permission="'Edit Course'"
                        small
                        class="mr-2"
                        @click="editCourse(item)"
                        color="primary"
                        >mdi-pencil</v-icon
                    >

                    <v-icon
                        v-if="item.lms_course_is_active == 'Active'"
                        v-permission="'Edit Course'"
                        small
                        color="error"
                        @click="disableCourse(item)"
                        >mdi-delete</v-icon
                    >
                    <v-icon
                        v-if="item.lms_course_is_active == 'Inactive'"
                        v-permission="'Edit Course'"
                        small
                        color="success"
                        @click="disableCourse(item)"
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
            isLoaderActive: false,
            imageRule: [],
            courseCode: "",
            courseName: "",
            courseDescription: "",
            courseDuration: "",
            courseFees: "",
            selectedCourseImage: null,

            isSaveCourseFormValid: true,
            isSaveCourseFormDataProcessing: false,

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
                {
                    text: this.$t("label_course_code"),
                    value: "lms_course_code",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: "Stream",
                    value: "lms_course_name",
                    width: "25%",
                    sortable: false,
                },
                {
                    text: this.$t("label_course_fees"),
                    value: "lms_course_fees",
                    width: "10%",
                    sortable: false,
                },
                {
                    text: this.$t("label_course_duration"),
                    value: "lms_course_duration",
                    width: "20%",
                    sortable: false,
                },
                {
                    text: this.$t("label_status"),
                    value: "lms_course_is_active",
                    align: "middle",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "20%",
                    align: "end",
                },
            ],
            tableItems: [],
            isSaveEditClicked: 1,
            editCourseId: "",
            courseImageNameForEdit: "",
            //Datatable End

            // For Add Department card
            isAddCardVisible: false,

            // For Excel Download
            excelFields: {
                "Course Code": "lms_course_code",
                "Course Name": "lms_course_name",
                "Course Description": "lms_course_description",
                "Course Duration(Months)": "lms_course_duration",
                "Course Fees": "lms_course_fees",
                Status: "lms_course_is_active",
            },
            excelData: [],
            excelFileName:
                "StreamListAsExcel" +
                "_" +
                moment().format("DD/MM/YYYY") +
                ".xls",
        };
    },
    watch: {
        selectedCourseImage(val) {
            this.selectedCourseImage = val;

            this.imageRule =
                this.selectedCourseImage != null
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
    },

    methods: {
        // Ensure Digit Input Field
        isDigit(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        // Ensure Digit Input with Decimal
        isDigitWithDecimal(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (
                charCode != 46 &&
                charCode > 31 &&
                (charCode < 48 || charCode > 57)
            ) {
                evt.preventDefault();
            } else {
                return true;
            }
        },
        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },

        // Edit Course

        editCourse(item) {
            this.isAddCardVisible = true;
            this.editCourseId = item.lms_course_id;
            this.isSaveEditClicked = 0;
            this.courseCode = item.lms_course_code;
            this.courseName = item.lms_course_name;
            this.courseDescription = item.lms_course_description;
            this.courseFees = item.lms_course_fees;
            this.courseDuration = item.lms_course_duration;
            this.courseImageNameForEdit = item.lms_course_image;
        },
        // Disable Course status
        disableCourse(item, $event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_course")
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_course",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            courseId: item.lms_course_id,
                            isCourseActive:
                                item.lms_course_is_active == "Active" ? 0 : 1,
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
                                    this.$t("label_course_status_changed")
                                );
                                this.getAllCourse(event);
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
        // Save Course To DB after validation
        saveCourse($event) {
            if (this.$refs.saveCourseForm.validate()) {
                this.isSaveCourseFormDataProcessing = true;
                let postData = new FormData();
                if (this.isSaveEditClicked == 1) {
                    postData.append("courseCode", this.courseCode);
                    postData.append("courseName", this.courseName);
                    if (this.courseDescription != "") {
                        postData.append(
                            "courseDescription",
                            this.courseDescription
                        );
                    }

                    postData.append("courseFees", this.courseFees);
                    postData.append("courseDuration", this.courseDuration);
                    if (this.selectedCourseImage != null) {
                        postData.append(
                            "courseImage",
                            this.selectedCourseImage
                        );
                    }

                    postData.append("isSaveEditClicked", 1);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                } else {
                    postData.append("courseCode", this.courseCode);
                    postData.append("courseName", this.courseName);
                    if (this.courseDescription != "") {
                        postData.append(
                            "courseDescription",
                            this.courseDescription
                        );
                    }

                    postData.append("courseFees", this.courseFees);
                    postData.append("courseDuration", this.courseDuration);
                    if (this.selectedCourseImage != null) {
                        postData.append(
                            "courseImage",
                            this.selectedCourseImage
                        );
                    }

                    postData.append("isSaveEditClicked", 0);
                    postData.append("centerId", ls.get("loggedUserCenterId"));
                    postData.append("loggedUserId", ls.get("loggedUserId"));
                    postData.append(
                        "courseImageNameForEdit",
                        this.courseImageNameForEdit
                    );
                    postData.append("courseId", this.editCourseId);
                }
                this.$http
                    .post(
                        "web_save_update_course",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isSaveCourseFormDataProcessing = false;
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
                            // Course Code Exists
                            else if (data.responseData == 1) {
                                this.snackBarColor = "info";
                                this.changeSnackBarMessage(
                                    this.$t("label_department_exists")
                                );
                            }
                            // Course Saved
                            else if (data.responseData == 2) {
                                this.courseCode = "";
                                this.courseName = "";
                                this.courseDescription = "";
                                this.courseFees = "";
                                this.courseDuration = "";
                                this.selectedCourseImage = null;
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_course_saved")
                                );
                                this.getAllCourse(event);
                                this.isSaveEditClicked = 1;
                            }
                            // Failed to save Course
                            else if (data.responseData == 3) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }

                            // Course Updated
                            else if (data.responseData == 4) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_course_updated")
                                );
                                this.getAllCourse(event);
                                this.isSaveEditClicked = 1;
                                this.courseCode = "";
                                this.courseName = "";
                                this.courseDescription = "";
                                this.courseFees = "";
                                this.courseDuration = "";
                                this.selectedCourseImage = null;
                            }
                            // Course update failed
                            else if (data.responseData == 5) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                            // Image upload failed
                            else if (data.responseData == 6) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_image_upload_failed")
                                );
                            }
                        }
                    })
                    .catch((error) => {
                        this.isSaveCourseFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        // Get all Course from DB
        getAllCourse(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_course?page=${e.page}`, {
                    params: {
                        searchText: this.searchText,
                        includeDelete: this.includeDelete,
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
        // Course Status Color
        getStatusColor(is_course_active) {
            if (is_course_active == "Active") return "success";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    { header: "Course Code", dataKey: "lms_course_code" },
                    { header: "Course Name", dataKey: "lms_course_name" },
                    {
                        header: "Course Description",
                        dataKey: "lms_course_description",
                    },
                    {
                        header: "Course Duration(Months)",
                        dataKey: "lms_course_duration",
                    },
                    { header: "Course Fees", dataKey: "lms_course_fees" },
                    { header: "Status", dataKey: "lms_course_is_active" },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save(
                "StreamListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
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
