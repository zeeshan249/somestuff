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
export const StudentExamDetails = {
    props: ["userPermissionDataProps", "studentDetailsDataProps", "studentId"],

    data() {
        return {
            isLoaderActive: false,
            tableDataLoading: false,
            tableLoadingDataText: this.$t("label_loading_data"),
            totalItemsInDB: 0,
            tableItems: [],
            tableHeader: [
                {
                    text: "#",
                    value: "index",
                    width: "5%",
                    sortable: false
                },

                {
                    text: "Student",
                    value: "lms_student_full_name",
                    width: "20%",
                    sortable: false
                },
                {
                    text: "Total",
                    value: "lms_exam_schedule_no_of_question",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Attempted",
                    value: "lms_total_answer_attempted",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Pass Marks",
                    value: "lms_exam_schedule_pass_marks",
                    align: "middle",
                    width: "5%",
                    sortable: false
                },
                {
                    text: "Score",
                    value: "lms_total_marks_scored",
                    width: "10%",
                    sortable: false
                },
                {
                    text: "Start Time",
                    value: "lms_exam_result_created_at",
                    width: "15%",
                    sortable: false
                },
                {
                    text: "End Time",
                    value: "lms_exam_result_details_submitted_at",
                    width: "15%",
                    sortable: false
                },

                {
                    text: this.$t("label_status"),
                    value: "lms_exam_result_details_is_active",
                    align: "middle",
                    width: "5%",
                    sortable: false
                }
                // {
                //     text: this.$t("label_actions"),
                //     value: "actions",
                //     sortable: false,
                //     width: "10%",
                //     align: "middle"
                // }
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
    },
    created() {
        console.log("TestProp: ", this.studentId);
    },
    methods: {
        // Get all Staff from DB
        getAllExamSchedule(e) {
            this.tableDataLoading = true;
            let postData = "";

            postData = {
                centerId: ls.get("loggedUserCenterId"),
                perPage:
                    e.itemsPerPage == -1 ? this.totalItemsInDB : e.itemsPerPage,
                filterBy: this.examSearchCriteria,
                lms_student_id: this.studentId
            };

            this.$http
                .get(`web_get_all_exam_student_report?page=${e.page}`, {
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
        // Source Status Color
        getStatusColor(is_source_acive) {
            if (is_source_acive == "Active") return "success";
            if (is_source_acive == "Submitted") return "primary";
            else return "error";
        },
        // Source Status Color
        getPassFailStatusColor(item) {
            if (
                parseInt(item.lms_total_marks_scored) >=
                parseInt(item.lms_exam_schedule_pass_marks)
            )
                return "success";
            else return "error";
        }
    }
};
