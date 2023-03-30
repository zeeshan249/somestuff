// Secure Local Storage
import SecureLS from "secure-ls";
import { Global } from "../../components/helpers/global";
const ls = new SecureLS({ encodingType: "aes" });
import DatetimePicker from "vuetify-datetime-picker";
//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";
import Vue from "vue";
Vue.use(DatetimePicker);
import VueMask from "v-mask";
Vue.use(VueMask);
export const IssueBook = {
    props: ["userPermissionDataProps", "bookListDataProps"],

    data() {
        return {
            isLoaderActive: false,
            isSourceDataLoading: false,
            studentSearchCriteria: "",
            lblSearchStudentCriteria: this.$t("label_search_student_criteria"),
            isSearchBySource: true,
            tableLoadingDataText: this.$t("label_loading_data"),
            tableDataLoading: false,
            totalItemsInDB: 0,
            authorizationConfig: "",
            tableItems: [],

            tableItemsBatchWiseStudent: [],
            show: false,
            lms_book_title:
                this.bookListDataProps != null
                    ? this.bookListDataProps.lms_book_title
                    : null,
            lms_book_publisher:
                this.bookListDataProps != null
                    ? this.bookListDataProps.lms_book_publisher
                    : null,
            lms_book_author:
                this.bookListDataProps != null
                    ? this.bookListDataProps.lms_book_author
                    : null,
            lms_book_subject:
                this.bookListDataProps != null
                    ? this.bookListDataProps.lms_book_subject
                    : null,
            lms_book_cover_image_path:
                this.bookListDataProps != null
                    ? this.bookListDataProps.lms_book_cover_image_path
                    : null,
            lms_book_id:
                this.bookListDataProps != null
                    ? this.bookListDataProps.lms_book_id
                    : null,
            //Table Start
            tableHeader: [
                {
                    text: "#",
                    value: "index",
                    width: "5%",
                    sortable: false
                },
                {
                    text: this.$t("label_code"),
                    value: "lms_registration_code",
                    width: "10%",
                    sortable: false
                },
                {
                    text: this.$t("label_date"),
                    value: "lms_student_course_mapping_created_at",
                    width: "10%",
                    sortable: false
                },
                {
                    text: this.$t("label_name"),
                    value: "lms_student_full_name",
                    width: "25%",
                    sortable: false
                },
                {
                    text: this.$t("label_course"),
                    value: "lms_child_course_name",
                    width: "30%",
                    sortable: false
                },
                {
                    text: this.$t("label_status"),
                    value: "lms_student_registration_type",
                    align: "end",
                    width: "5%",
                    sortable: false
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "15%",
                    align: "middle",
                    visible: "false"
                }
            ],
            tableHeaderStudent: [
                {
                    text: "#",
                    value: "index",
                    width: "5%",
                    sortable: false
                },
                {
                    text: "Student Name",
                    value: "lms_student_full_name",
                    width: "20%",
                    sortable: false,
                    align: "start"
                },
                {
                    text: "Student Code",
                    value: "lms_student_code",
                    width: "10%",
                    sortable: false,
                    align: "center"
                },
                {
                    text: "Registration Code",
                    value: "lms_registration_code",
                    width: "10%",
                    sortable: false,
                    align: "center"
                },
                {
                    text: "Issue Date",
                    value: "lms_student_book_issue_date",
                    width: "15%",
                    sortable: false,
                    align: "end"
                },
                {
                    text: "Scheduled Return",
                    value: "lms_student_book_scheduled_return_date",
                    width: "15%",
                    sortable: false,
                    align: "end"
                },
                {
                    text: "Return Date",
                    value: "lms_student_book_return_date",
                    width: "15%",
                    sortable: false,
                    align: "end"
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions_issue",
                    sortable: false,
                    width: "10%",
                    align: "Centre"
                }
            ]
            //Table End
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
        },
        dataTableRowNumberingStudent() {
            return this.tableItemsBatchWiseStudent.map((items, index) => ({
                ...items,
                index: index + 1
            }));
        }
    },
    created() {
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") }
        };
        this.lms_book_cover_image_path =
            process.env.MIX_BOOK_COVER_IMAGE_URL +
            this.lms_book_cover_image_path;
        if (this.bookListDataProps != null) {
            this.getAllStudentListBookWise(this.lms_book_id);
        } else {
            this.$router.push({
                name: "BookList"
            });
        }
    },
    methods: {
        backToPrevPage() {
            this.$router.push({
                name: "BookList"
            });
        },
        // Get all issued book student wise from DB
        getAllStudentListBookWise(lms_book_id) {
            this.tableDataLoading = true;
            console.log(ls.get("token"));
            this.$http
                .get(`web_get_all_student_book_wise`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        lms_book_id: this.lms_book_id,
                        lms_student_book_is_rteurned: [0]
                    },
                    headers: {
                        Authorization: "Bearer " + ls.get("token")
                    }
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
                        this.tableItemsBatchWiseStudent = data;
                    }
                })
                .catch(error => {
                    this.tableDataLoading = false;
                    Global.showErrorAlert(
                        true,
                        "error",
                        this.$t("label_something_went_wrong"),
                        null
                    );
                });
        },
        // Source Status Color
        getStatusColor(is_source_acive) {
            if (is_source_acive == "Active") return "success";
            if (is_source_acive == "Online") return "primary";
            if (is_source_acive == "Internal") return "success";
            if (is_source_acive == "Closed") return "warning";
            else return "error";
        },
        getAllStudents(e) {
            this.tableDataLoading = true;
            let postData = "";

            if (this.isSearchBySource == true) {
                postData = {
                    centerId: ls.get("loggedUserCenterId"),
                    lms_book_id: this.lms_book_id,
                    perPage:
                        e.itemsPerPage == -1
                            ? this.totalItemsInDB
                            : e.itemsPerPage,
                    filterBy: this.studentSearchCriteria
                };
            } else {
                postData = {
                    centerId: ls.get("loggedUserCenterId"),
                    lms_book_id: this.lms_book_id,
                    perPage: this.totalItemsInDB,
                    filterBy: this.studentSearchCriteria
                };
            }

            this.$http
                .get(`web_get_all_students_book_issue?page=${e.page}`, {
                    params: postData,
                    headers: {
                        Authorization: "Bearer " + ls.get("token")
                    }
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
                        console.log(data.data);
                        this.isSearchBySource = true;
                    }
                })
                .catch(error => {
                    this.tableDataLoading = false;
                    // Global.showErrorAlert(
                    //     true,
                    //     "error",
                    //     this.$t("label_something_went_wrong"),
                    //     null
                    // );
                });
        },
        //#region [IssueBook]
        IssueStudentBook(item) {
            console.log(item);
            let userDecision = confirm(
                this.$t("label_are_you_sure_issue_book")
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_issue_book",
                        {
                            loggedUserId: ls.get("loggedUserId"),
                            lms_book_id: this.lms_book_id,
                            lms_student_id: item.lms_student_id,
                            lms_registration_id: item.lms_registration_id,
                            lms_course_id: item.lms_course_id,
                            lms_user_id: item.lms_user_id
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
                            if (data.responseData == 1) {
                                Global.showSuccessAlert(
                                    true,
                                    "success",
                                    this.$t("label_book_return_changed"),
                                    null
                                );
                                this.getAllStudentListBookWise(item);
                            } else if (data.responseData == 2) {
                                Global.showErrorAlert(
                                    true,
                                    "error",
                                    this.$t("label_something_went_wrong"),
                                    null
                                );
                            } else if (data.responseData == 3) {
                                Global.showErrorAlert(
                                    true,
                                    "error",
                                    this.$t("label_book_out_of_stock"),
                                    null
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isLoaderActive = false;
                        Global.showErrorAlert(
                            true,
                            "error",
                            this.$t("label_something_went_wrong"),
                            null
                        );
                    });
            }
        },
        //#endregion
        //#region [returnBook]
        returnBook(item) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_return_book")
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_return_book",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            lms_student_book_issue_id:
                                item.lms_student_book_issue_id,
                            lms_book_id: item.lms_book_id,
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
                                Global.showSuccessAlert(
                                    true,
                                    "success",
                                    this.$t("label_book_return_changed"),
                                    null
                                );
                                this.getAllStudentListBookWise(item);
                            }
                            // Course Disabled failed
                            else if (data.responseData == 2) {
                                Global.showErrorAlert(
                                    true,
                                    "error",
                                    this.$t("label_something_went_wrong"),
                                    null
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isLoaderActive = false;
                        Global.showErrorAlert(
                            true,
                            "error",
                            this.$t("label_something_went_wrong"),
                            null
                        );
                    });
            }
        }
        //#endregion
    }
};
