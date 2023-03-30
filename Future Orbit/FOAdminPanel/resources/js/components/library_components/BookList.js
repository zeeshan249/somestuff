import SecureLS from "secure-ls";
import { Global } from "../../components/helpers/global";
const ls = new SecureLS({ encodingType: "aes" });
import DatetimePicker from "vuetify-datetime-picker";
import jsPDF from "jspdf";
import "jspdf-autotable";
import Vue from "vue";
Vue.use(DatetimePicker);
import VueMask from "v-mask";
import { createLogger } from "vuex";
Vue.use(VueMask);
export const BookList = {
    props: ["userPermissionDataProps"],

    data() {
        return {
            //#region [tableHeader]
            tableHeader: [
                {
                    text: "#",
                    value: "index",
                    width: "5%",
                    sortable: false
                },
                {
                    text: "Cover",
                    value: "lms_book_cover_image_path",
                    width: "5%",
                    sortable: false
                },
                {
                    text: "Title",
                    value: "lms_book_title",
                    width: "35%",
                    sortable: false
                },
                {
                    text: "Stream",
                    value: "lms_course_name",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Author",
                    value: "lms_book_author",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Subject",
                    value: "lms_book_subject",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Qty",
                    value: "qtyVsAvlQty",
                    width: "5%",
                    sortable: false
                },

                {
                    text: this.$t("label_status"),
                    value: "lms_book_status",
                    align: "middle",
                    width: "5%",
                    sortable: false
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "20%",
                    align: "Centre"
                },
                {
                    text: "Issued",
                    value: "data-table-expand",
                    width: "5%",
                    sortable: false,
                    align: "center"
                }
            ],
            //#endregion

            //#region [Props]
            toolTipshow: false,
            selectedBookCoverImage: null,
            oldBookCoverImage: null,
            imageRule: [],
            coverImagesUrl: "",
            courseItems: [],
            lms_course_id: [],
            lms_book_id: "",
            lms_book_title: "",
            lms_book_number: "",
            lms_book_publisher: "",
            lms_book_author: "",
            lms_book_subject: "",
            lms_book_current_quantity: "",
            lms_book_quantity: "",
            lms_book_price: "",
            lms_book_return_days: "",
            lms_book_isbn_number: "",
            lms_book_cover_image_path: "",
            bookCoverImage: null,
            altBookCoverImage: "",
            issaveLibraryFormValid: true,
            issaveLibraryFormDataProcessing: false,
            tableItemsBatchWiseStudent: [],
            expanded: [],
            singleExpand: true,
            includeDelete: false,
            includeReturned: false,
            isReturned: [0],
            isLoaderActive: false,
            authorizationConfig: "",
            isSaveEditClicked: 1,
            tableItems: [],
            isAddCardVisible: false,
            tableDataLoading: false,
            totalItemsInDB: 0,
            tableLoadingDataText: this.$t("label_loading_data"),
            myArray: [],
            searchBatch: "",
            //#endregion

            //#region [tableHeaderStudent]
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
            ],
            //#endregion

            //#region [Excel Download]
            // For Excel Download
            excelFields: {
                "Book ID": "lms_book_id",
                Title: "lms_book_title",
                "Book Number": "lms_book_number",
                Publisher: "lms_book_publisher",
                Author: "lms_book_author",
                Subject: "lms_book_subject",
                "Stock Quantity": "lms_book_quantity",
                "Avl Quantity": "lms_book_current_quantity",
                Price: "lms_book_price",
                Status: "lms_book_status"
            },
            excelData: [],
            excelFileName:
                "BookList" + "_" + moment().format("DD/MM/YYYY") + ".xls"
            //#endregion
        };
    },
    watch: {
        selectedBookCoverImage(val) {
            this.selectedBookCoverImage = val;
            this.imageRule =
                this.selectedBookCoverImage != null
                    ? [
                          v =>
                              !v ||
                              v.size <= 1048576 ||
                              this.$t("label_file_size_criteria_1_mb")
                      ]
                    : [];
        }
    },
    computed: {
        // For numbering the Data Table Rows
        dataTableRowNumbering() {
            return this.tableItems.map((items, index) => ({
                ...items,
                index: index + 1
            }));
        },
        // For numbering the Data Table Rows
        dataTableRowNumberingStudent() {
            return this.tableItemsBatchWiseStudent.map((items, index) => ({
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
        console.log(ls.get("token"));
        // Get Active Sources
        this.getAllActiveCourses();
        this.coverImagesUrl = process.env.MIX_BOOK_COVER_IMAGE_URL;
        this.altBookCoverImage = this.coverImagesUrl + "NotAvailable.jpg";
    },

    methods: {
        //#region [IssueBook]
        IssueBook(item) {
            this.$router.push({
                name: "IssueBook",
                params: { bookListDataProps: item }
            });
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
        },
        //#endregion

        //#region [getAllStudentListBookWise]
        getAllStudentListBookWise(item) {
            this.includeReturned
                ? (this.isReturned = [0, 1])
                : (this.isReturned = [0]);
            this.tableDataLoading = true;
            this.$http
                .get(`web_get_all_student_book_wise`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        lms_book_id: item.lms_book_id,
                        lms_student_book_is_rteurned: this.isReturned
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
                        console.log(data);
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
        //#endregion

        //#region [buildCoverImages]
        buildCoverImages(images) {
            
            return images != null
                ? this.coverImagesUrl + images
                : this.altBookCoverImage;
        },
        //#endregion

        //#region [IssueBook]
        // Get all books from DB
        getAllBookList(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_get_all_book_list?page=${e.page}`, {
                    params: {
                        includeDelete: this.includeDelete,
                        centerId: ls.get("loggedUserCenterId"),
                        perPage:
                            e.itemsPerPage == -1
                                ? this.totalItemsInDB
                                : e.itemsPerPage
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
                        this.tableItems = data.data;
                        this.totalItemsInDB = data.total;
                        this.excelData = data.data;
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
        //#endregion

        editLibrary(item) {
            this.isSaveEditClicked = 0;
            this.isAddCardVisible = true;
            this.lms_book_id = item.lms_book_id;
            let courseIds = [];
            item.lms_course_id.split(",").forEach(function(obj) {
                courseIds.push(parseInt(obj));
            });
            this.lms_course_id = courseIds;
            this.lms_book_title = item.lms_book_title;
            this.lms_book_number = item.lms_book_number;
            this.lms_book_publisher = item.lms_book_publisher;
            this.lms_book_author = item.lms_book_author;
            this.lms_book_subject = item.lms_book_subject;
            this.lms_book_quantity = item.lms_book_quantity;
            this.lms_book_current_quantity = item.lms_book_current_quantity;
            this.lms_book_price = item.lms_book_price;
            this.lms_book_return_days = item.lms_book_return_days;
            this.lms_book_isbn_number = item.lms_book_isbn_number;
            this.oldBookCoverImage = item.lms_book_cover_image_path;
            this.bookCoverImage =
                item.lms_book_cover_image_path != null
                    ? this.coverImagesUrl + item.lms_book_cover_image_path
                    : this.altBookCoverImage;
        },
        // Save library To DB after validation
        saveLibrary($event) {
            if (this.$refs.saveLibraryForm.validate()) {
                this.issaveLibraryFormDataProcessing = true;
                let postData = new FormData();
                postData.append("centerId", ls.get("loggedUserCenterId"));
                postData.append("loggedUserId", ls.get("loggedUserId"));
                postData.append("lms_course_id", this.lms_course_id);
                postData.append("lms_book_title", this.lms_book_title);
                postData.append("lms_book_number", this.lms_book_number);
                postData.append(
                    "lms_book_isbn_number",
                    this.lms_book_isbn_number
                );
                postData.append("lms_book_publisher", this.lms_book_publisher);
                postData.append("lms_book_author", this.lms_book_author);
                postData.append("lms_book_subject", this.lms_book_subject);
                postData.append("lms_book_quantity", this.lms_book_quantity);
                postData.append(
                    "lms_book_current_quantity",
                    this.lms_book_current_quantity
                );
                postData.append("lms_book_price", this.lms_book_price);
                postData.append(
                    "lms_book_return_days",
                    this.lms_book_return_days
                );
                if (this.selectedBookCoverImage != null) {
                    postData.append(
                        "lms_book_cover_image_path",
                        this.selectedBookCoverImage
                    );
                }

                if (this.isSaveEditClicked == 1) {
                    postData.append("isSaveEditClicked", 1);
                } else {
                    postData.append("isSaveEditClicked", 0);
                    postData.append("lms_book_id", this.lms_book_id);
                    postData.append(
                        "oldBookCoverImage",
                        this.oldBookCoverImage
                    );
                }
                this.$http
                    .post(
                        "web_save_update_book_list",
                        postData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.issaveLibraryFormDataProcessing = false;
                        //User Unauthorized
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            // Server side validation fails
                            if (data.responseData == 0) {
                                Global.showErrorAlert(
                                    true,
                                    "error",
                                    data.error,
                                    null
                                );
                            }
                            // Course Code Exists
                            else if (data.responseData == 1) {
                                Global.showErrorAlert(
                                    true,
                                    "info",
                                    this.$t("label_exist"),
                                    null
                                );
                            }
                            // Course Saved
                            else if (data.responseData == 2) {
                                this.$refs.saveLibraryForm.reset();
                                Global.showSuccessAlert(
                                    true,
                                    "success",
                                    this.$t("label_book_list_saved"),
                                    null
                                );
                                this.getAllBookList(event);
                                this.isSaveEditClicked = 1;
                            }
                            // Failed to save Course
                            else if (data.responseData == 3) {
                                Global.showErrorAlert(
                                    true,
                                    "error",
                                    this.$t("label_something_went_wrong"),
                                    null
                                );
                            }

                            // Subject Updated
                            else if (data.responseData == 4) {
                                Global.showSuccessAlert(
                                    true,
                                    "success",
                                    this.$t("label_book_list_updated"),
                                    null
                                );
                                this.getAllBookList(event);
                                this.isSaveEditClicked = 1;
                                this.$refs.saveLibraryForm.reset();
                            }
                            // Course update failed
                            else if (data.responseData == 5) {
                                Global.showErrorAlert(
                                    true,
                                    "error",
                                    this.$t("label_something_went_wrong"),
                                    null
                                );
                            }
                            // Image upload failed
                            else if (data.responseData == 6) {
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
                        this.issaveLibraryFormDataProcessing = false;
                        Global.showErrorAlert(
                            true,
                            "error",
                            this.$t("label_something_went_wrong"),
                            null
                        );
                    });
            }
        },
        resetForm() {
            this.$refs.saveLibraryForm.reset();
            this.isSaveEditClicked = 1;
        },

        // Disable book status
        disableBook(item, $event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_book")
            );
            if (userDecision) {
                this.isLoaderActive = true;
                this.$http
                    .post(
                        "web_enable_disable_book",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            lms_book_id: item.lms_book_id,
                            lms_book_status:
                                item.lms_book_status == "Active" ? 0 : 1,
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
                                    this.$t("label_book_status_changed"),
                                    null
                                );
                                this.getAllBookList(event);
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
        },

        // Get all active sources
        getAllActiveCourses() {
            this.isSourceDataLoading = true;
            this.$http
                .get(`web_get_all_active_courses_without_pagination`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId")
                    },
                    headers: {
                        Authorization: "Bearer " + ls.get("token")
                    }
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
                        this.courseItems = data;
                    }
                })
                .catch(error => {
                    this.isSourceDataLoading = false;
                    Global.showErrorAlert(
                        true,
                        "error",
                        this.$t("label_something_went_wrong"),
                        null
                    );
                });
        },
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
        // Status Color
        getStatusColor(is_course_active) {
            if (is_course_active == "Active") return "success";
            else return "error";
        },
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    { header: "Book ID", dataKey: "lms_book_id" },
                    { header: "Title", dataKey: "lms_book_title" },
                    { header: "Book Number", dataKey: "lms_book_number" },
                    { header: "Publisher", dataKey: "lms_book_publisher" },
                    { header: "Author", dataKey: "lms_book_author" },
                    { header: "Subject", dataKey: "lms_book_subject" },
                    { header: "Stock Quantity", dataKey: "lms_book_quantity" },
                    {
                        header: "Avl Quantity",
                        dataKey: "lms_book_current_quantity"
                    },
                    { header: "Price", dataKey: "lms_book_price" },
                    { header: "Status", dataKey: "lms_book_status" }
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 }
            });
            pdfDoc.save(
                "BookList" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
            );
        }
    }
};
