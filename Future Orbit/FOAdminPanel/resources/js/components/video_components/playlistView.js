// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });

//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

export const playlistView = {
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
          text: this.$t("label_academics"),
          disabled: false,
        },
        {
          text: this.$t("label_topic"),
          disabled: false,
        },
      ],
      isLoaderActive: false,
      isSaveEditClicked: 1,
      courseId: "",
      subjectId: "",
      topicId:"",
      playlist_name: "",
      playlist_img_url: "",
     

      issaveTopicFormValid: true,
      issaveTopicFormDataProcessing: false,

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
        {
          text: "#",
          value: "index",
          width: "5%",
          sortable: false
        },
        {
          text: "Subject Name",
          value: "lms_subject_name",
          width: "20%",
          sortable: false
        },
        {
          text: "Topic Name",
          value: "lms_topic_name",
          width: "20%",
          sortable: false
        },
        {
          text: "Playlist Name",
          value: "playlist_name",
          align: "middle",
          width: "20%",
          sortable: false
        },
        {
          text: "Status",
          value: "playlist_status",
          width: "20%",
          sortable: false
        },
        {
          text: "Image",
          value: "playlist_image_url",
          width: "20%",
          sortable: false
        },
        {
          text: this.$t("label_actions"),
          value: "actions",
          sortable: false,
          width: "20%",
          align: "middle",
        },
      ],
      tableItems: [],
      isSaveEditClicked: 1,
      editTopictId: "",
      courseImageNameForEdit: "",

      //Datatable End
      courseItems: [],
      subjectItems: [],
      topicItems: [],
      // For Add Department card
      isAddCardVisible: false,

      // For Excel Download
      excelFields: {
        "Topic Code": "lms_topic_code",
        "Topic Name": "lms_topic_name",
        "Subject Name": "lms_subject_name",
        "Course Name": "lms_course_name",
        Status: "lms_topic_is_active",
      },
      excelData: [],
      excelFileName:
        "TopicListAsExcel" + "_" + moment().format("DD/MM/YYYY") + ".xls",
    };
  },

  

  //#region
  playlistImage(val) {
    this.playlistImage = val;
    this.imageRule =
      this.playlistImage != null
        ? [(v) => !v || v.size <= 1048576 || "File size should be 1MB"]
        : [];
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
    // Get All Stream
    this.getAllStream();
    this.getAllSubject();
    this.getAllTopic();

   
  },

  methods: {
    // Get all Playlist from DB
    getAllPlaylist(e) {
      this.tableDataLoading = true;
      this.$http
        .get(`web_get_playlist?page=${e.page}`, {
          params: {
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

     // Change Snack bar message
     changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },

  // Topic Status Color
  getStatusColor(is_active) {
    if (is_active == "Active") return "success";
    else return "error";
  },

    // Export to PDF
    savePDF() {
      const pdfDoc = new jsPDF();
      pdfDoc.autoTable({
        columns: [
          { header: "Topic Code", dataKey: "lms_topic_code" },
          { header: "Topic Name", dataKey: "lms_topic_name" },
          { header: "Course Name", dataKey: "lms_course_name" },
          { header: "Subject Name", dataKey: "lms_subject_name" },
          { header: "Status", dataKey: "lms_topic_is_active" },
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 },
      });
      pdfDoc.save(
        "TopicListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
      );
    },

     // Disable Course status
     disableTopic(item, $event) {
      let userDecision = confirm(
        this.$t("label_are_you_sure_change_status_topic")
      );
      if (userDecision) {
        this.isLoaderActive = true;
        this.$http
          .post(
            "web_enable_disable_topic",
            {
              centerId: ls.get("loggedUserCenterId"),
              topicId: item.lms_topic_id,
              isTopicActive: item.lms_topic_is_active == "Active" ? 0 : 1,
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
                  this.$t("label_topic_status_changed")
                );
                this.getAllPlaylist(event);
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


    // Get all Stream
    getAllStream() {  
      console.log("stream");
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

    // Get all Subject
    getAllSubject(e) {
      this.isSourceDataLoading = true;
      this.$http
        .get(`web_get_all_active_subject_based_on_course_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            courseId: this.courseId,
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
            this.subjectItems = data;
          }
        })
        .catch((error) => {
          this.isSourceDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },

    // Get all Topic
    getAllTopic(e) {
      this.isSourceDataLoading = true;
      this.$http
        .get(`web_get_topic_list`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            subjectId: this.subjectId,

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
            this.topicItems = data;
          }
        })
        .catch((error) => {
          this.isSourceDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },

    // let postData = new FormData();
  // if (this.doctorProfileImage != null) {
  //   postData.append("doctor_profile_image", this.doctorProfileImage);
  // }


     // Save Subject To DB after validation
     saveTopic($event) {
      if (this.$refs.saveTopicForm.validate()) {
        this.issaveTopicFormDataProcessing = true;
        let postData = new FormData();
        if (this.isSaveEditClicked == 1 && this.playlistImage != null) {
          postData.append("playlist_img_url", this.playlistImage);
          postData.append("courseId", this.courseId);
          postData.append("subjectId", this.subjectId);
          postData.append("topicId", this.topicId);
          postData.append("playlist_name", this.playlist_name);
          postData.append("isSaveEditClicked", 1);
          postData.append("centerId", ls.get("loggedUserCenterId"));
          postData.append("loggedUserId", ls.get("loggedUserId"));
        } else {
          postData.append("playlist_img_url", this.playlistImage);
          postData.append("courseId", this.courseId);
          postData.append("subjectId", this.subjectId);
          postData.append("topicId", this.topicId);
          postData.append("playlist_name", this.playlist_name);
          postData.append("isSaveEditClicked", 1);
          postData.append("centerId", ls.get("loggedUserCenterId"));
          postData.append("loggedUserId", ls.get("loggedUserId"));

          postData.append("playlist_id", this.playlist_id);
        }
        this.$http
          .post("web_save_playlist", postData, this.authorizationConfig)
          .then(({ data }) => {
            this.issaveTopicFormDataProcessing = false;
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
                this.changeSnackBarMessage("Playlist already exist");
              }
              // Course Saved
              else if (data.responseData == 2) {
               
                this.courseId = "";
                this.subjectId = "";
                this.topicId = "";
                this.playlist_name = "";
                this.playlist_img_url = "";


                this.snackBarColor = "success";
                this.changeSnackBarMessage("Playlist Saved Successfully");
                this.getAllPlaylist(event);
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
                this.changeSnackBarMessage(this.$t("label_topic_updated"));
                this.getAllPlaylist(event);
                this.isSaveEditClicked = 1;
                this.courseId = "";
                this.subjectId = "";
                this.topicId = "";
                this.playlist_name = "";
                this.playlist_img_url = "";
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
            this.issaveTopicFormDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },

    // Edit Course
    editPlaylist(item) {
       console.warn("this item",item);
      this.isAddCardVisible = true;
      this.editPlaylisttId = item.playlist_id;
      this.isSaveEditClicked = 0;
      this.getAllSubject();
      this.getAllStream();
     
      this.getAllTopic();
      this.subjectId = item.subject_id;
      this.courseId = item.lms_course_id;

      this.topicId = item.topic_id;
      this.playlist_name = item.playlist_name;
      this.playlist_img_url = item.playlist_img_url;

    },
  },
};

