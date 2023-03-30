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


export const BatchTransfer = {
  props: ["userPermissionDataProps"],

  data() {
    return {
      // For Breadcrumb
      breadCrumbItem: [
        {
          text: this.$t("label_home"),
          disabled: false,
        },
        {
          text: this.$t("label_accounts"),
          disabled: false,
        },
        {
          text: this.$t("label_subscription"),
          disabled: false,
        },
      ],
      dayItems: [
        {
          day: "Sunday",
          lms_batch_slot_day: 1,
        },
        {
          day: "Monday",
          lms_batch_slot_day: 2,
        },
        {
          day: "Tuesday",
          lms_batch_slot_day: 3,
        },
        {
          day: "Wednesday",
          lms_batch_slot_day: 4,
        },
        {
          day: "Thursday",
          lms_batch_slot_day: 5,
        },
        {
          day: "Friday",
          lms_batch_slot_day: 6,
        },
        {
          day: "Saturday",
          lms_batch_slot_day: 7,
        },
      ],
      lms_child_course_id: null,
      childCourseItems: [],
      expanded: [],
      singleExpand: true,
      includeDelete: false,
      dialogBatchDetails: false,
      batchDetails: "",
      startTimeMenu: false,
      endTimeMenu: false,
      startDate: "",
      endDate: "",
      subjectDataLoading: false,

      timeProps: { useSeconds: true },
      textFieldProps: {
        outlined: true,
        dense: true,
        prependInnerIcon: "mdi-calendar",
      },

      searchBatch: "",
      isLoaderActive: false,
      lms_batch_name: "",
      lms_exam_card_payment_month_duration: "",
      lms_batch_code: "",

      lms_course_id: "",
      subjectName: "",
      lms_batch_start_date: "",
      lms_batch_end_date: "",

      issaveBatchFormValid: true,
      issaveBatchFormDataProcessing: false,

      authorizationConfig: "",
      tableItems: [],
      isSaveEditClicked: 1,
      lms_batch_id: "",
      courseImageNameForEdit: "",

      courseItems: [],
      facultiesItems: [],
      lms_user_id: "",
      // For Add Department card
      isAddCardVisible: false,
      subjectItems: [],
      lms_subject_id: "",

      // Snack Bar

      isSnackBarVisible: false,
      snackBarMessage: "",
      snackBarColor: "",

      //   Datatable Start

      tableDataLoading: false,
      totalItemsInDB: 0,
      tableLoadingDataText: this.$t("label_loading_data"),

      tableHeaderBatchSlotDetails: [
        { text: "#", value: "index", width: "5%", sortable: false },
        {
          text: "Subject Name",
          value: "lms_subject_name",
          width: "20%",
          sortable: false,
          align: "start",
        },
       

        {
          text: "Start Time",
          value: "lms_batch_slot_start_time",
          width: "10%",
          sortable: false,
          align: "end",
        },
        {
          text: "End Time",
          value: "lms_batch_slot_end_time",
          width: "10%",
          sortable: false,
          align: "end",
        },
           {
          text: "Day",
          value: "lms_batch_slot_day_text",
          width: "10%",
          sortable: false,
          align: "end",
        },
         {
          text: "Faculty",
          value: "lms_staff_full_name",
          width: "15%",
          sortable: false,
          align: "center",
        },
        {
          text: "Mobile",
          value: "lms_staff_mobile_number",
          width: "10%",
          sortable: false,
          align: "center",
        },
           {
          text: "Status",
          value: "lms_batch_slot_is_active",
          width: "10%",
          sortable: false,
          align: "end",
        },
        
      ],


      tableHeaderStudent: [
        { text: "#", value: "index", width: "5%", sortable: false },
        {
          text: "Student Name",
          value: "lms_student_full_name",
          width: "35%",
          sortable: false,
          align: "start",
        },
        {
          text: "Student Code",
          value: "lms_student_code",
          width: "20%",
          sortable: false,
          align: "center",
        },
        {
          text: "Registration Code",
          value: "lms_registration_code",
          width: "20%",
          sortable: false,
          align: "center",
        },

        {
          text: "Start Date",
          value: "lms_batch_mapping_date",
          width: "20%",
          sortable: false,
          align: "end",
        },
      ],
      tableHeader: [
        { text: "#", value: "index", width: "5%", sortable: false },
        {
          text: "Batch Code",
          value: "lms_batch_code",
          width: "10%",
          sortable: false,
        },
        {
          text: "Name",
          value: "lms_batch_name",
          width: "25%",
          sortable: false,
        },
        {
          text: "Stream",
          value: "lms_course_name",
          width: "15%",
          sortable: false,
        },
        {
          text: "Start Date",
          value: "lms_batch_start_date_edit",
          width: "10%",
          sortable: false,
        },
        {
          text: "End Date",
          value: "lms_batch_end_date_edit",
          width: "10%",
          sortable: false,
        },

        {
          text: this.$t("label_status"),
          value: "lms_batch_is_active",
          align: "middle",
          width: "10%",
          sortable: false,
        },
        {
          text: this.$t("label_actions"),
          value: "actions",
          sortable: false,
          width: "20%",
          align: "Centre",
        },
        {
          text: "Students",
          value: "data-table-expand",
          width: "10%",
          sortable: false,
          align: "center",
        },
      ],

      // For Excel Download
      excelFields: {
        Subscription: "lms_batch_name",
        Duration: "lms_exam_card_payment_month_duration",
        "Course Name": "lms_course_name",
        Status: "lms_batch_is_active",
      },
      excelData: [],
      excelFileName:
        "Subscription" + "_" + moment().format("DD/MM/YYYY") + ".xls",

      slotDetails: [
        {
          lms_batch_slot_id: null,
          lms_batch_slot_start_time: "11:00",
          lms_batch_slot_end_time: "13:00",
          lms_batch_slot_day: 1,
          lms_user_id: 2,
          lms_subject_id: 1,
        },
      ],
      tableItemsBatchWiseStudent: [],
      tableItemsBatchSlotDetails: [],
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
    // For numbering the Data Table Rows
    dataTableRowNumberingStudent() {
      return this.tableItemsBatchWiseStudent.map((items, index) => ({
        ...items,
        index: index + 1,
      }));
    },

     // For numbering the Data Table Rows
    dataTableRowNumberingBatchSlotDetails() {
      return this.tableItemsBatchSlotDetails.map((items, index) => ({
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
    // Get Active Sources
    this.getAllActiveCourses();
    this.getAllActiveFaculties();
  },

  methods: {
    resetForm() {
      this.$refs.saveBatchForm.reset();
      this.isSaveEditClicked = 1;
      this.slotDetails = [
        {
          lms_batch_slot_id: null,
          lms_batch_slot_start_time: "11:00",
          lms_batch_slot_end_time: "13:00",
          lms_batch_slot_day: 1,
          lms_user_id: 2,
          lms_subject_id: 1,
        },
      ];
    },

    remove(index, lms_batch_slot_id) {
      if (this.isSaveEditClicked == 0) {
        console.log(lms_batch_slot_id);
        this.disableSlot(lms_batch_slot_id);
        this.slotDetails.splice(index, 1);
      } else {
        this.slotDetails.splice(index, 1);
      }
    },
    addSlot() {
      this.slotDetails.push({
        lms_batch_slot_id: null,
        lms_batch_slot_start_time: "",
        lms_batch_slot_end_time: "",
        lms_batch_slot_day: "",
        lms_user_id: "",
      });
    },
    //get all data including deleted data

    // Get all active faculties
    getAllActiveFaculties() {
      this.isSourceDataLoading = true;
      this.$http
        .get(`web_get_all_active_faculties_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
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
            this.facultiesItems = data;
          }
        })
        .catch((error) => {
          this.isSourceDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },

    // Get all active sources
    getAllActiveCourses() {
      this.isSourceDataLoading = true;
      this.$http
        .get(`web_get_all_active_courses_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
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
            this.courseItems = data;
          }
        })
        .catch((error) => {
          this.isSourceDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
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
      if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
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

    editBatch(item) {
      this.isSaveEditClicked = 0;
      this.isAddCardVisible = true;
      this.lms_batch_id = item.lms_batch_id;
      this.lms_course_id = item.lms_course_id;
      this.getAllActiveSubjectBasedonCourse(item.lms_course_id);
      this.getAllActiveChildCourse();
      this.lms_batch_name = item.lms_batch_name;
      this.lms_batch_start_date = item.lms_batch_start_date;
      this.lms_batch_end_date = item.lms_batch_end_date;
      this.lms_batch_code = item.lms_batch_code;
      this.getSlotDetailsByBatchId(item.lms_batch_id);
      this.lms_child_course_id = item.lms_child_course_id;
    },
    //Assign Student to batch
    assignStudentToBatch(item) {
      this.$router.push({
        name: "BatchTransfer",
        params: { batchTransferDataProps: item },
      });
    },
    //BatchSlotDetails
    batchSlotDetails(item) {
      this.dialogBatchDetails = true;
      this.getAllBatchWiseSlotDetails(item.lms_batch_id);
      this.batchDetails = item.lms_course_name + ' of Batch: '  + item.lms_batch_code + ' - '+ item.lms_batch_name ;
      this.lms_batch_id= item.lms_batch_id;
    },
    // Get all active sources
    getSlotDetailsByBatchId(lms_batch_id) {
      this.isSourceDataLoading = true;
      this.$http
        .get(`web_get_slot_details_by_Batch_without_pagination`, {
          params: {
            lms_batch_id: lms_batch_id,
            centerId: ls.get("loggedUserCenterId"),
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
            this.slotDetails = data;
          }
        })
        .catch((error) => {
          this.isSourceDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Disable Slot
    disableSlot(lms_batch_slot_id) {
      let userDecision = confirm(
        this.$t("label_are_you_sure_change_status_slot")
      );
      if (userDecision) {
        this.isLoaderActive = true;
        this.$http
          .post(
            "web_disable_slot",
            {
              centerId: ls.get("loggedUserCenterId"),
              lms_batch_slot_id: lms_batch_slot_id,
              lms_batch_slot_is_active: 0,
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
                  this.$t("label_batch_status_changed")
                );
                this.getAllBatch(event);
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
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },

    // Disable batch status
    disableBatch(item, $event) {
      let userDecision = confirm(
        this.$t("label_are_you_sure_change_status_batch")
      );
      if (userDecision) {
        this.isLoaderActive = true;
        this.$http
          .post(
            "web_enable_disable_batch",
            {
              centerId: ls.get("loggedUserCenterId"),
              lms_batch_id: item.lms_batch_id,
              lms_batch_is_active: item.lms_batch_is_active == "Active" ? 0 : 1,
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
                  this.$t("label_batch_status_changed")
                );
                this.getAllBatch(event);
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
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },
    // To ensure course name is character and space only
    isCharacters(evt) {
      var regex = new RegExp("^[a-zA-Z ]+$");
      var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
      if (!regex.test(key)) {
        evt.preventDefault();

        return false;
      }
    },
    // Get all active subject based on course
    getAllActiveSubjectBasedonCourse(src) {
      console.log("Username: " + this.lms_course_id.text);
      this.subjectDataLoading = true;
      this.$http
        .get(`web_get_all_active_subject_based_on_course_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            courseId: this.lms_course_id,
          },
          headers: { Authorization: "Bearer " + ls.get("token") },
        })
        .then(({ data }) => {
          this.subjectDataLoading = false;
          //User Unauthorized
          if (
            data.error == "Unauthorized" ||
            data.permissionError == "Unauthorized"
          ) {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.subjectItems = data;
          }
        })
        .catch((error) => {
          this.isSourceDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },

    // Get all active child course based on course
    getAllActiveChildCourse() {
      this.subjectDataLoading = true;
      this.$http
        .get(`web_get_all_active_child_course_wp`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            courseId: this.lms_course_id,
          },
          headers: { Authorization: "Bearer " + ls.get("token") },
        })
        .then(({ data }) => {
          this.subjectDataLoading = false;
          //User Unauthorized
          if (
            data.error == "Unauthorized" ||
            data.permissionError == "Unauthorized"
          ) {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.childCourseItems = data;
          }
        })
        .catch((error) => {
          this.isSourceDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Save Subject To DB after validation
    saveBatch($event) {
      if (this.$refs.saveBatchForm.validate()) {
        this.issaveBatchFormDataProcessing = true;
        let postData = new FormData();
        if (this.isSaveEditClicked == 1) {
          postData.append("lms_batch_code", this.lms_batch_code);
          postData.append("lms_batch_name", this.lms_batch_name);
          postData.append("lms_course_id", this.lms_course_id);
          postData.append("lms_child_course_id", this.lms_child_course_id);

          postData.append(
            "lms_batch_start_date",
            moment(new Date(this.lms_batch_start_date)).format(
              "YYYY-MM-DD HH:mm:ss"
            )
          );
          postData.append(
            "lms_batch_end_date",
            moment(new Date(this.lms_batch_end_date)).format(
              "YYYY-MM-DD HH:mm:ss"
            )
          );

          postData.append(
            "slotDetails",
            JSON.stringify(this.slotDetails, null, 2)
          );
          postData.append("isSaveEditClicked", 1);
          postData.append("centerId", ls.get("loggedUserCenterId"));
          postData.append("loggedUserId", ls.get("loggedUserId"));
        } else {
          //Edit
          postData.append("lms_batch_id", this.lms_batch_id);
          postData.append("lms_batch_code", this.lms_batch_code);
          postData.append("lms_batch_name", this.lms_batch_name);
          postData.append("lms_course_id", this.lms_course_id);
          postData.append("lms_child_course_id", this.lms_child_course_id);
          postData.append(
            "lms_batch_start_date",
            moment(new Date(this.lms_batch_start_date)).format(
              "YYYY-MM-DD HH:mm:ss"
            )
          );
          postData.append(
            "lms_batch_end_date",
            moment(new Date(this.lms_batch_end_date)).format(
              "YYYY-MM-DD HH:mm:ss"
            )
          );
          postData.append(
            "slotDetails",
            JSON.stringify(this.slotDetails, null, 2)
          );
          postData.append("isSaveEditClicked", 0);
          postData.append("centerId", ls.get("loggedUserCenterId"));
          postData.append("loggedUserId", ls.get("loggedUserId"));
        }
        this.$http
          .post("web_save_update_batch", postData, this.authorizationConfig)
          .then(({ data }) => {
            this.issaveBatchFormDataProcessing = false;
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
                this.changeSnackBarMessage(this.$t("label_batch_exists"));
              }
              // Course Saved
              else if (data.responseData == 2) {
                this.$refs.saveBatchForm.reset();
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_batch_saved"));
                this.getAllBatch(event);
                this.isSaveEditClicked = 1;
              }
              // Failed to save Course
              else if (data.responseData == 3) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }

              // Subject Updated
              else if (data.responseData == 4) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_batch_updated"));
                this.getAllBatch(event);
                this.isSaveEditClicked = 1;
                this.$refs.saveBatchForm.reset();
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
            this.issaveBatchFormDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },

    // Get all Subject from DB
    getAllBatch(e) {
      this.tableDataLoading = true;

      this.$http
        .get(`web_get_all_batch?page=${e.page}`, {
          params: {
            includeDelete: this.includeDelete,
            centerId: ls.get("loggedUserCenterId"),
            perPage:
              e.itemsPerPage == -1 ? this.totalItemsInDB : e.itemsPerPage,
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
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
// Get all Subject from DB
    getAllBatchWiseSlotDetails(batchId) {
      this.tableDataLoading = true;

      this.$http
        .get(`web_get_all_batch_wise_slot_details`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            batchId: batchId,
          
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
            this.tableItemsBatchSlotDetails = data.data;
            console.log(data.data);
            this.totalItemsInDB = data.total;
            this.excelData = data.data;
          }
        })
        .catch((error) => {
          this.tableDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Get all Subject from DB
    getAllStudentBatchWise(item) {
      this.tableDataLoading = true;

      this.$http
        .get(`web_get_get_all_student_batch_wise`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            lms_batch_id: item.lms_batch_id,
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
            console.log(data);
            this.tableItemsBatchWiseStudent = data;
          }
        })
        .catch((error) => {
          this.tableDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
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
          { header: "Subscription", dataKey: "lms_batch_name" },
          {
            header: "Duration",
            dataKey: "lms_exam_card_payment_month_duration",
          },
          { header: "Course Name", dataKey: "lms_course_name" },
          {
            header: "Status",
            dataKey: "lms_batch_is_active",
          },
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 },
      });
      pdfDoc.save("Batch" + "_" + moment().format("DD/MM/YYYY") + ".pdf");
    },
  },
};
