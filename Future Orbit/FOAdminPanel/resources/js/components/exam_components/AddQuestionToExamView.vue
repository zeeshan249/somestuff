<template>
  <!-- Card Start -->
  <v-container fluid>
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
    <v-breadcrumbs :items="breadCrumbItem">
      <template v-slot:divider>
        <v-icon>mdi-forward</v-icon>
      </template>
    </v-breadcrumbs>

    <v-row dense>
      <transition name="fade" mode="out-in">
        <v-col class="d-flex flex-column ml-2">
          <!-- Card Start -->
          <v-card>
            <v-app-bar dark color="primary">
              <v-toolbar-title color="success">{{ $t('label_assign_question_exam') }}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn v-if="false"
                v-permission:all="'Question Bank'"
                class="ma-2"
                outlined
                small
                color="white"
                @click="addExamSchedule"
              >
                <v-icon class="mr-2" color="white">mdi-book-plus</v-icon>
                View Assigned Question
              </v-btn>
            </v-app-bar>

            <v-container fluid>
               <v-row dense >
                 <v-col cols="12" md="6" ><p><strong>Stream: &nbsp; </strong> {{CourseName}}</p></v-col>
                   <v-col cols="12" md="6" ><p><strong>Exam Name: &nbsp; </strong> {{ExamName}}</p></v-col>
              </v-row>

              <v-row dense >
                 <v-col cols="12" md="6" ><p><strong>Total Marks &nbsp; </strong> {{ExamMarks}}</p></v-col>
                   <v-col cols="12" md="6" ><p><strong>Added Marks: &nbsp; </strong> {{ExamAddedMarks}}</p></v-col>
              </v-row>

              <v-row dense >
                 <v-col cols="12" md="6" ><p><strong>Total Question: &nbsp; </strong> {{ExamQuestion}}</p></v-col>
                   <v-col cols="12" md="6" ><p><strong>Added Question: &nbsp; </strong> {{ExamAddedQuestion}}</p></v-col>
              </v-row>
              <div >
                <v-row dense class="mx-2" >
                  <v-col cols="12" md="10" >
                    <v-text-field
                      outlined
                      dense
                      v-model="questionBankSearchCriteria"
                      :label="lblSearchQuestionCriteria"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="2" >
                    <v-btn
                      dense
                      rounded
                      color="primary"
                      @click="isSearchByQuestionBank=false;getAllQuestionBank($event);"
                      :disabled="tableDataLoading"
                    >{{$t('label_search')}}</v-btn>
                  </v-col>
                </v-row>

                <v-row dense  class="mx-2">
                  <v-col cols="12" md="6">
                    <v-select
                      outlined
                      dense
                      v-model="selectedSubjectId"
                      :items="subjectItems"
                      :disabled="subjectDataLoading"
                      item-text="lms_subject_name"
                      item-value="lms_subject_id"
                      @change="getAllActiveTopicBasedonSubject()"
                    >
                      <template #label>
                        {{ $t("label_subject") }}
                        <span class="red--text">
                          <strong>{{ $t("label_star") }}</strong>
                        </span>
                      </template>
                    </v-select>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-select
                      outlined
                      dense
                      v-model="selectedTopicId"
                      :items="topicItems"
                      :disabled="topicDataLoading"
                      item-text="lms_topic_name"
                      item-value="lms_topic_id"
                      @change="
                       isSearchByQuestionBank=true;
                        getAllQuestionBank($event);
                      "
                    >
                      <template #label
                        >{{ $t("label_topic") }}
                        <span class="red--text">
                          <strong>{{ $t("label_star") }}</strong>
                        </span></template
                      >
                    </v-select>
                  </v-col>
                </v-row>
              </div>
            </v-container>
          </v-card>
          <!-- Card End -->
        </v-col>
      </transition>
    </v-row>
    <v-row dense>
      <transition name="fade" mode="out-in">
        <v-col class="d-flex flex-column ml-2">
          <!-- Card Start -->
          <v-card>
            <v-app-bar dark color="primary">
              <v-toolbar-title color="success">{{ $t('label_question_bank_directory') }}</v-toolbar-title>
              <v-spacer></v-spacer>
            </v-app-bar>

            <v-container fluid>
              <v-card class="mx-auto" max-width="100%">
                <v-data-table
                  dense
                  :headers="tableHeader"
                  :items="dataTableRowNumbering"
                  item-key="lms_question_bank_id"
                  class="elevation-1 pa-0"
                  :loading="tableDataLoading"
                  :loading-text="tableLoadingDataText"
                  :server-items-length="totalItemsInDB"
                  :items-per-page="300"
                  @pagination="getAllQuestionBank"
                   style="width: 100%; align-content: center;"
                  :footer-props="{itemsPerPageOptions: [300, 100, 150,200,-1],}">
                  <template v-slot:no-data>
                    <p
                      class="font-weight-black bold title"
                      style="color:red"
                    >{{ $t("label_no_data_found") }}</p>
                  </template>
                  <template v-slot:item.lms_question_difficulty_level_name="{ item }">
                    <v-chip
                      x-small
                      :color="getDifficultyLevelColor(item.lms_question_difficulty_level_name)"
                      dark
                    >{{ item.lms_question_difficulty_level_name}}</v-chip>
                  </template>
                   <template v-slot:item.lms_question_added_not_added="{ item }">
                    <v-chip
                      x-small
                      :color="getQuestionStatusColor(item.lms_question_added_not_added)"
                      dark
                    >{{ item.lms_question_added_not_added }}</v-chip>
                  </template>

                  <template v-slot:item.lms_question_bank_type_single_multiple="{ item }">
                    <v-chip
                      x-small
                      :color="getStatusColor(item.lms_question_bank_type_single_multiple)"
                      dark
                    >{{ item.lms_question_bank_type_single_multiple }}</v-chip>
                  </template>
                  <template v-slot:top>
                    <v-toolbar flat>
                      <v-toolbar-title>{{$t('label_question_bank_directory')}}</v-toolbar-title>
                      <v-spacer></v-spacer>
                      <v-btn icon small color="teal" v-if="!tableDataLoading">
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
                        class="mr-2"
                        icon
                        small
                        color="red"
                        @click="savePDF"
                      >
                        <v-icon dark>mdi-file-pdf</v-icon>
                      </v-btn>
                    </v-toolbar>
                  </template>


                  <template v-slot:item.lms_course_name="{ item }" >
                  <div  style="white-space: nowrap; width:100%;" >
                  <span style="display: inline-block; overflow: hidden; text-overflow: ellipsis; width:100%;">
                  {{ item.lms_course_name }}</span></div></template>


                <template v-slot:item.lms_question_bank_text="{ item }" >
                  <div v-html="item.lms_question_bank_text" style="align-content: center;"></div>
                </template>

                <template v-slot:item.actions="{ item }" >

                    <v-icon v-if="item.lms_question_added_not_added=='N'"
                    color="blue"
                      v-permission="'Question Bank'"
                      dark
                     class="m-1"
                      @click="isAddOrRemoveQuestion='Add';addOrRemoveQuestion(item);"
                      small
                    >mdi-plus-circle-outline</v-icon>
                     <v-icon v-if="item.lms_question_added_not_added=='A'"
                    color="danger"
                      v-permission="'Question Bank'"
                      class="m-1"
                      dark
                      @click="isAddOrRemoveQuestion='Remove';addOrRemoveQuestion(item);"
                      small
                    >mdi-minus-circle-outline</v-icon>

                    <v-icon v-if="true"
                      v-permission="'Question Bank'"
                      small
                      @click="viewQuestionBank(item)"
                      dark
                      color="primary"
                    >mdi-eye</v-icon>
                   <div v-if="false">
                     <v-icon
                      v-if="item.lms_question_bank_is_active=='Active'"
                      v-permission="'Question Bank'"
                      small
                      color="error"
                      @click="enableDisableExamSchedule(item)"
                    >mdi-delete</v-icon>
                    <v-icon
                      v-if="item.lms_question_bank_is_active=='Inactive'"
                      v-permission="'Question Bank'"
                      small
                      color="success"
                      @click="enableDisableExamSchedule(item)"
                    >mdi-check-circle</v-icon>
                   </div>


                  </template>
                </v-data-table>
              </v-card>
            </v-container>
          </v-card>
          <!-- Card End -->
        </v-col>
      </transition>

      <!-- Card End -->
    </v-row>

    <v-snackbar
      v-model="isSnackBarVisible"
      :color="snackBarColor"
      multi-line="multi-line"
      right="right"
      :timeout="3000"
      top="top"
      vertical="vertical"
    >{{ snackBarMessage }}</v-snackbar>


    <!-- //Question Dialog -->

    <v-dialog
      v-model="questionDialog"
    fullscreen hide-overlay transition="dialog-bottom-transition" scrollable >




          <v-card>
        <v-toolbar dark color="primary" dense max-height="60">
          <v-btn icon dark @click="questionDialog = false"> <v-icon>mdi-close</v-icon></v-btn>
          <v-toolbar-title>Question View</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark text @click="questionDialog = false">Close</v-btn>
          </v-toolbar-items>
        </v-toolbar>
           <div class="text-center">

             <v-btn class="mx-2" fab dark color="indigo" small  v-if="DialogQuestionAddedorNot=='N'" @click="isAddOrRemoveQuestion='Add';addOrRemoveQuestion(DialogItem);" > <v-icon dark> mdi-plus </v-icon> </v-btn>
             <v-btn class="mx-2" fab dark color="danger" small  v-if="DialogQuestionAddedorNot=='A'" @click="isAddOrRemoveQuestion='Remove';addOrRemoveQuestion(DialogItem);"> <v-icon dark> mdi-minus </v-icon> </v-btn>
             <v-chip class="ma-2" color="green" text-color="white" ><v-avatar left class="green darken-4">C</v-avatar>{{DialogCourse}}</v-chip>
             <v-chip class="ma-2" color="green" text-color="white" ><v-avatar left class="green darken-4">S</v-avatar>{{DialogSubject}}</v-chip>
             <v-chip class="ma-2" color="green" text-color="white" ><v-avatar left class="green darken-4">T</v-avatar>{{DialogTopic}}</v-chip>
             <v-chip class="ma-2" color="green" text-color="white" ><v-avatar left class="green darken-4">H</v-avatar>{{DialogQuestionTag}}</v-chip>


          </div>
          <v-divider></v-divider>

        <v-card-text>
          <v-alert  color="primary"  outlined dense  >Question Section</v-alert>
            <div v-html="DialogQuestionText"></div>
            <div v-if="DialogQuestionHasImage==1"><v-img  max-height="150" max-width="250" :lazy-src="DialogQuestionImage" :src= "DialogQuestionImage" alt=""></v-img></div>


            <v-divider></v-divider>
             <v-alert  color="primary"  outlined dense>Option Section</v-alert>
            <v-simple-table dense fixed-header>
              <thead style="border: 1px solid #d9d9d9;">
                <tr>
                  <th class="text-centre" style="text-align: center;background:#555555;color:white"><strong>Option 1 | A</strong></th>
                  <th class="text-centre" style="text-align: center;background:#555555;color:white"><strong>Option 2 | B</strong></th>
                  <th class="text-centre" style="text-align: center;background:#555555;color:white"><strong>Option 3 | C</strong></th>
                  <th class="text-centre" style="text-align: center;background:#555555;color:white"><strong>Option 4 | D</strong></th>
                  <th class="text-centre" style="text-align: center;background:#555555;color:white"><strong>Option 5 | E</strong></th>
                </tr>
              </thead>
              <tbody>
                <tr style="border: 1px solid #d9d9d9;">
                  <td style="border: 1px solid #d9d9d9;">
                      <!-- <div v-if="DialogOption1HasImage==0"><div v-html="DialogOption1" ></div></div> -->
                       <div v-if="DialogOption1HasImage==0"> <ckeditor :editor="editor" v-model="DialogOption1" :config="editorConfig" ></ckeditor></div>
                      <div v-else><v-img  max-height="150" max-width="250" :lazy-src="DialogOption1Image" :src= "DialogOption1Image" alt=""></v-img></div>
                  </td>
                  <td style="border: 1px solid #d9d9d9;">
                      <!-- <div v-if="DialogOption2HasImage==0"><div v-html="DialogOption2" ></div></div> -->
                       <div v-if="DialogOption2HasImage==0"> <ckeditor :editor="editor" v-model="DialogOption2" :config="editorConfig" ></ckeditor></div>
                      <div v-else><v-img max-height="150" max-width="250" :lazy-src="DialogOption2Image" :src= "DialogOption2Image" ></v-img></div>
                  </td>
                  <td style="border: 1px solid #d9d9d9;">
                      <!-- <div v-if="DialogOption3HasImage==0"><div v-html="DialogOption3" ></div></div> -->
                       <div v-if="DialogOption3HasImage==0"> <ckeditor :editor="editor" v-model="DialogOption3" :config="editorConfig" ></ckeditor></div>
                      <div v-else><v-img max-height="150" max-width="250" :lazy-src="DialogOption3Image" :src= "DialogOption3Image" ></v-img></div>
                  </td>
                  <td style="border: 1px solid #d9d9d9;">
                      <!-- <div v-if="DialogOption4HasImage==0"><div v-html="DialogOption4" ></div></div> -->
                       <div v-if="DialogOption4HasImage==0"> <ckeditor :editor="editor" v-model="DialogOption4" :config="editorConfig" ></ckeditor></div>
                      <div v-else><v-img max-height="150" max-width="250" :lazy-src="DialogOption4Image" :src= "DialogOption4Image" ></v-img></div>
                  </td>
                  <td style="border: 1px solid #d9d9d9;">
                      <!-- <div v-if="DialogOption5HasImage==0"><div v-html="DialogOption5" ></div></div> -->
                       <div v-if="DialogOption5HasImage==0"> <ckeditor :editor="editor" v-model="DialogOption5" :config="editorConfig" ></ckeditor></div>
                      <div v-else><v-img max-height="150" max-width="250" :lazy-src="DialogOption5Image" :src= "DialogOption5Image" ></v-img></div>
                  </td>
                </tr>
              </tbody>
            </v-simple-table>




                <v-divider></v-divider>
        <v-card-actions>
           <v-chip class="ma-2" color="deep-purple accent-4" text-color="white" ><span>Difficulty Level : &nbsp;</span><strong>{{DialogDifficultyLevel}}</strong></v-chip>
          <v-chip class="ma-2" color="deep-purple accent-4" text-color="white" ><span>Marks : &nbsp;</span><strong>{{DialogQuestionMarks}}</strong></v-chip>
          <v-chip class="ma-2" color="deep-purple accent-4" text-color="white" ><span>Total Option : &nbsp;</span><strong>{{DialogNoOfOption}}</strong></v-chip>
          <v-alert border="left" colored-border color="deep-purple accent-4" elevation="2" max-width="1000px" > <strong>Solution:</strong>
          <!-- <div v-if="lms_question_bank_solution_has_image==0" v-html="DialogSolution"></div> -->
           <div v-if="lms_question_bank_solution_has_image==0"> <strong>Solution</strong> <br><ckeditor :editor="editor" v-model="DialogSolution" :config="editorConfig" ></ckeditor> </div>
          <div v-if="lms_question_bank_solution_has_image==1"><v-img  max-height="150" max-width="250" :lazy-src="DialogQuestionSolutionImage" :src= "DialogQuestionSolutionImage" alt=""></v-img></div>


   </v-alert>

        </v-card-actions>
               </v-card-text>
      </v-card>

    </v-dialog>




<!-- //Set Dialog -->
    <v-dialog
      v-model="dialog"
      hide-overlay
      persistent
      width="500"
    >
      <v-card
        color="error"
        dark
      >

      <v-card-title class="headline">
          Updating Data!!! Please Wait...
        </v-card-title>


        <v-card-text>
         Your request is processing!!! I will automatically close when done.
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>



  </v-container>
</template>
<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });

//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
  props: ["userPermissionDataProps","examScheduleDataProps"],

  data() {
    return {
      // For Breadcrumb
      breadCrumbItem: [
        {
          text: this.$t("label_home"),
          disabled: false
        },
        {
          text: this.$t("label_exam"),
          disabled: false
        },
        {
          text: this.$t("label_exam_schedule"),
          disabled: false
        },
        {
          text: this.$t("label_assign_question_exam"),
          disabled: false
        }
      ],


  editor: ClassicEditor,
      //Question Data

      DialogCourse:'',
      DialogSubject:'',
      DialogTopic:'',
      DialogQuestionTag:'',

      DialogDifficultyLevel:'',
      DialogSingleMultiple:'',

      DialogQuestionText:'',
      DialogQuestionImage:null,

      DialogOption1:'',
      DialogOption2:'',
      DialogOption3:'',
      DialogOption4:'',
      DialogOption5:'',

      DialogOption1HasImage:'',
      DialogOption2HasImage:'',
      DialogOption3HasImage:'',
      DialogOption4HasImage:'',
      DialogOption5HasImage:'',

      DialogQuestionHasImage:'',
      DialogOption1Image:'',
      DialogOption2Image:'',
      DialogOption3Image:'',
      DialogOption4Image:'',
      DialogOption5Image:'',

      DialogQuestionAddedorNot:'',
      DialogItem:'',


      DialogCorrectAnswer:'',
      DialogQuestionMarks:'',
      DialogNoOfOption:'',
      DialogSolution:'',
      lms_question_bank_solution_has_image:'',


      // Form Data
      lblSelectCourse: this.$t("label_course"),
      selectedSubjectId: "",
      isDataProcessing: false,
      questionBankSearchCriteria: "",
      lblSearchQuestionCriteria: this.$t("label_search_question_bank"),
      issubjectItemsLoading: false,
      subjectItems: [],
      isSearchByQuestionBank: false,
      authorizationConfig: "",
       dialog: false,
       questionDialog:false,

      // Snack Bar

      isSnackBarVisible: false,
      snackBarMessage: "",
      snackBarColor: "",
      selectedTopicId: "",
      topicDataLoading: false,
      topicItems: [],

      //   Datatable Start

      tableDataLoading: false,
      totalItemsInDB: 0,
      tableLoadingDataText: this.$t("label_loading_data"),

      tableHeader: [
        { text: "#", value: "index", width: "5%", sortable: false },
        {
          text: this.$t("label_question_tag"),
          value: "lms_question_bank_tag",
          width: "10%",
          sortable: false
        },
         {
          text: this.$t("label_question"),
          value: "lms_question_bank_text",
          width: "40%",
          sortable: false
        },
         {
          text: this.$t("label_subject_name"),
          value: "lms_subject_name",
          width: "10%",
          sortable: false
        },
        {
          text: this.$t("label_topic_name"),
          value: "lms_topic_name",
          width: "10%",
          sortable: false
        },
       {
          text: this.$t("label_exam_difficulty_level"),
          value: "lms_question_difficulty_level_name",
          align: "middle",
          width: "5%",
          sortable: false
        },
        {
          text: this.$t("label_exam_answer_type"),
          value: "lms_question_bank_type_single_multiple",
          align: "middle",
          width: "5%",
          sortable: false
        },
        {
          text: this.$t("label_status"),
          value: "lms_question_added_not_added",
          align: "middle",
          width: "5%",
          sortable: false
        },
        {
          text: this.$t("label_actions"),
          value: "actions",
          sortable: false,
          width: "10%",
          align: "middle"
        }
      ],
      tableItems: [],
      isDataProcessing: false,

      //Datatable End



          CourseName: this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_course_name
          : "",
          ExamName: this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_name
          : "",

          ExamMarks: this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_max_marks
          : "",

          ExamQuestion: this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_no_of_question
          : "",

          ExamAddedMarks: "",

          ExamAddedQuestion:  "",

           ExamCourseId: this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_course_id
          : "",

            ExamScheduleId: this.examScheduleDataProps != null
          ? this.examScheduleDataProps.lms_exam_schedule_id
          : "",

          QuestionId: "",

          isAddOrRemoveQuestion:'',




      // For Excel Download
      excelFields: {
        Code: "lms_enquiry_code",
        Date: "lms_enquiry_date",
        Source: "source_name",
        Name: "lms_enquiry_full_name",
        Mobile: "lms_enquiry_mobile",
        Email: "lms_enquiry_email",
        School: "lms_enquiry_school_name",
        Remarks: "lms_enquiry_remarks",
        Status: "lms_enquiry_status"
      },
      excelData: [],
      excelFileName:
        "EnquiryListAsExcel" + "_" + moment().format("DD/MM/YYYY") + ".xls"
    };
  },
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
 watch: {
        whatsAppNumber(val) {
            this.whatsAppNumber = val;
            this.mobileRules =
                this.whatsAppNumber != ""
                    ? [
                          v =>
                              (v && v.length >= 10) ||
                              this.$t("label_whatsapp_mobile_number_10_digits")
                      ]
                    : [];
        },
        selectedProfilePicture(val) {
            this.selectedProfilePicture = val;

            this.imageRule =
                this.selectedProfilePicture != null
                    ? [
                          v =>
                              !v ||
                              v.size <= 1048576 ||
                              this.$t("label_file_size_criteria_1_mb")
                      ]
                    : [];
        },
        whatsApp(val) {
            this.whatsApp = val;
            this.whatsAppMobileRules =
                this.whatsApp != " "
                    ? [
                          v =>
                              (v && v.length >= 10) ||
                              this.$t("label_whatsapp_mobile_number_10_digits")
                      ]
                    : [];
        }
    },
  created() {
    // Token Config
    this.authorizationConfig = {
      headers: { Authorization: "Bearer " + ls.get("token") }
    };

    if(this.examScheduleDataProps != null)
    {
    this.getAllActiveSubjectBasedonCourse(this.ExamCourseId)
    this.getAddedMarksQuestionNo();
    }
    else
    {
       this.$router.push({
        name: "ExamDirectory"});
    }
  },

  methods: {
    // Get all active subject based on course
    getAllActiveTopicBasedonSubject() {
      this.topicDataLoading = true;
      this.$http
        .get(`web_get_all_active_topic_based_on_subject_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            selectedSubjectId: this.selectedSubjectId,
          },
          headers: { Authorization: "Bearer " + ls.get("token") },
        })
        .then(({ data }) => {
          this.topicDataLoading = false;
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
   // Get all active subject based on course
    getAllActiveSubjectBasedonCourse(src) {
        console.log(src );
       // console.log(event.target.options[event.target.options.selectedIndex].text);

      this.subjectDataLoading = true;
      this.$http
        .get(`web_get_all_active_subject_based_on_course_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            courseId: src,
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

     // Change Snack bar message
    changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },
    // View Staff
    viewQuestionBank(item) {
      this.DialogItem = item;
      this.DialogCourse= item.lms_course_name;
      this.DialogSubject= item.lms_subject_name;
      this.DialogTopic= item.lms_topic_name;

      this.DialogDifficultyLevel= item.lms_question_difficulty_level_name;
      this.DialogSingleMultiple= item.lms_question_bank_type_single_multiple;

      this.DialogQuestionText= item.lms_question_bank_text;
      this.DialogQuestionTag= item.lms_question_bank_tag;
      this.DialogQuestionHasImage= item.lms_question_bank_has_image;
      this.DialogQuestionImage= process.env.MIX_QUESTION_IMAGE_URL + item.lms_question_bank_image_path;


      this.DialogOption1= item.lms_question_bank_options_1;
      this.DialogOption2= item.lms_question_bank_options_2;
      this.DialogOption3= item.lms_question_bank_options_3;
      this.DialogOption4= item.lms_question_bank_options_4;
      this.DialogOption5= item.lms_question_bank_options_5;

      this.DialogOption1HasImage= item.lms_question_bank_options_1_has_image;
      this.DialogOption2HasImage= item.lms_question_bank_options_2_has_image;
      this.DialogOption3HasImage= item.lms_question_bank_options_3_has_image;
      this.DialogOption4HasImage= item.lms_question_bank_options_4_has_image;
      this.DialogOption5HasImage= item.lms_question_bank_options_5_has_image;


	   	this.DialogOption1Image= process.env.MIX_ANSWER_IMAGE_URL + item.lms_question_bank_options_1;
      this.DialogOption2Image= process.env.MIX_ANSWER_IMAGE_URL + item.lms_question_bank_options_2;
      this.DialogOption3Image= process.env.MIX_ANSWER_IMAGE_URL + item.lms_question_bank_options_3;
      this.DialogOption4Image= process.env.MIX_ANSWER_IMAGE_URL + item.lms_question_bank_options_4;
      this.DialogOption5Image= process.env.MIX_ANSWER_IMAGE_URL + item.lms_question_bank_options_5;



      this.DialogCorrectAnswer= item.lms_question_bank_correct_answers;
      this.DialogQuestionMarks= item.lms_question_bank_marks;
      this.DialogNoOfOption= item.lms_question_bank_no_of_option;
      this.DialogSolution= item.lms_question_bank_solution;
      this.lms_question_bank_solution_has_image= item.lms_question_bank_solution_has_image;
      this.DialogQuestionSolutionImage= process.env.MIX_SOLUTION_IMAGE_URL + item.lms_question_bank_solution;
      this.DialogQuestionAddedorNot = item.lms_question_added_not_added;
      this.questionDialog=true;
    },


    // Question Bank
    editExamSchedule(item) {
      this.$router.push({
        name: "AddExamSchedule",
        params: { examScheduleDataProps: item}

      });
    },
    // Add Staff
    addExamSchedule() {
      this.$router.push({
        name: "AddQuestionBank",

      });
    },


  // Add Remove Question
    addOrRemoveQuestion(item) {

if(this.ExamAddedQuestion < this.ExamQuestion && this.isAddOrRemoveQuestion =='Add' || this.isAddOrRemoveQuestion =='Remove'  )
{

let userDecision = confirm(
        this.$t("label_are_you_sure_add_remove_question" )
      );
      if (userDecision) {
        this.isDataProcessing = true;
        this.dialog= true;
        //Set Dialog
        this.$http
          .post(
            "web_add_or_remove_question",
            {
              centerId: ls.get("loggedUserCenterId"),
              loggedUserId: ls.get("loggedUserId"),
              scheduleId: item.lms_exam_schedule_id,
              questionBankId: item.lms_question_bank_id,
              addOrRemove : this.isAddOrRemoveQuestion,
              lms_exam_wise_question_id: item.lms_exam_wise_question_id
            },
            this.authorizationConfig
          )
          .then(({ data }) => {
            this.isDataProcessing = false;
            this.dialog= false;
            //User Unauthorized
            if (
              data.error == "Unauthorized" ||
              data.permissionError == "Unauthorized"
            ) {
              this.$store.dispatch("actionUnauthorizedLogout");
            } else {
              // Status changed
              if (data.responseData == 2) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(
                  this.$t("label_assign_question_database_add")
                );
                  this.getAllQuestionBank(event);
                 this.getAddedMarksQuestionNo();
              }
              // Status changed failed
              else if (data.responseData == 1) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
              // Status changed failed
              else if (data.responseData == 3) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
            }


          })
          .catch(error => {
            this.isDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
}
else
{

            this.isDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage("Required number of questions already added!!!");

}
    },

// Get Question & Marks
    getAddedMarksQuestionNo() {
      this.isexamTypeDataLoading = true;
      this.$http
        .get(`web_get_question_marks_added_exam_wise`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
             scheduleId: this.ExamScheduleId
          },
          headers: { Authorization: "Bearer " + ls.get("token") }
        })
        .then(({ data }) => {
          this.isexamTypeDataLoading = false;
          //User Unauthorized
          if (
            data.error == "Unauthorized" ||
            data.permissionError == "Unauthorized"
          ) {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
                if( data.length > 0 )
                {
                  this.ExamAddedMarks = data[0].QuestionMarks;
                  this.ExamAddedQuestion = data[0].QuestionNumber;
                }
                else
                {
                    this.ExamAddedMarks =0;
                    this.ExamAddedQuestion =0;
                }
          }
        })
        .catch(error => {
          this.isexamTypeDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Change Snack bar message
    changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },





    // Get all Staff from DB
    getAllQuestionBank(e) {
      console.log("Event "  + e.page);
     this.tableDataLoading = true;
      let postData = "";

      if (this.isSearchByQuestionBank == true) {
        postData = {
          centerId: ls.get("loggedUserCenterId"),
         // perPage: e.itemsPerPage == -1?this.totalItemsInDB:e.itemsPerPage,
           perPage: e.itemsPerPage,
          selectedSubjectId: this.selectedSubjectId,
          selectedTopicId : this.selectedTopicId,
          scheduleId: this.ExamScheduleId,
          isSearchByQuestionBank:this.isSearchByQuestionBank
        };
      } else {
        postData = {
          centerId: ls.get("loggedUserCenterId"),
            perPage: e.itemsPerPage,
           filterBy: this.questionBankSearchCriteria,
           scheduleId: this.ExamScheduleId
        };
      }

      this.$http

        .get(`web_get_all_question_bank_exam_wise?page=${e.page}`, {
          params: postData,
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
            this.excelData = data.data;
          }
        })
        .catch(error => {
          this.tableDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Source Status Color
    getStatusColor(lms_question_bank_type_single_multiple) {
      if (lms_question_bank_type_single_multiple == "S") return "success";
      if (lms_question_bank_type_single_multiple == "M") return "primary";
      else return "error";
    },
 getDifficultyLevelColor(lms_question_difficulty_level_name) {
      if (lms_question_difficulty_level_name == "E") return "blue";
      if (lms_question_difficulty_level_name == "M") return "warning";
      else return "error";
    },
    // Source Status Color
    getQuestionStatusColor(lms_question_added_not_added) {
      if (lms_question_added_not_added == "A") return "green";
      if (lms_question_added_not_added == "N") return "danger";
      else return "error";
    },
    // Export to PDF
    savePDF() {
      const pdfDoc = new jsPDF(
        { orientation: "landscape",}
      );

      pdfDoc.autoTable({
        columns: [
           { header: "Course", dataKey: "lms_course_name" },
          { header: "Type", dataKey: "lms_exam_schedule_type" },
          { header: "Name", dataKey: "lms_exam_schedule_name" },
          { header: "Live From", dataKey: "lms_exam_schedule_live_from" },
          { header: "Live To", dataKey: "lms_exam_schedule_live_to" },

          { header: "Total Question", dataKey: "lms_exam_schedule_no_of_question" },
          { header: "Total Marks", dataKey: "lms_exam_schedule_max_marks" },
          { header: "Total Time", dataKey: "lms_exam_schedule_total_time_alloted" },
          { header: "Free/Paid", dataKey: "lms_exam_schedule_is_free_paid" },
          { header: "Pass Marks", dataKey: "lms_exam_schedule_pass_marks" },
          { header: "Status", dataKey: "lms_exam_schedule_is_active_live" },
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 }
      });
      pdfDoc.save(
        "EnquiryListAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
      );
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
</style>

