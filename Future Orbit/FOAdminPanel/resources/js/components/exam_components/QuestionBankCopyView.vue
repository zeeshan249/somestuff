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
   
        <v-sheet class="pa-4 mb-4" >
        <v-breadcrumbs :items="breadCrumbItem">
            <template v-slot:divider>
                <v-icon>mdi-forward</v-icon>
            </template>
        </v-breadcrumbs>
        </v-sheet>
        <v-row dense>
            <transition name="fade" mode="out-in">
                <v-col class="d-flex flex-column ml-2">
                    <!-- Card Start -->
                    <v-card>
                        <v-app-bar dark color="primary">
                            <v-toolbar-title color="success">{{
                                $t("label_add_question_bank")
                            }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn
                                v-if="activeCopyCourseButton"
                                v-permission:all="'Question Bank'"
                                class="ma-2"
                                outlined
                                small
                                color="white"
                                @click="QuestionBankCopy"
                            >
                                <v-icon class="mr-2" color="white"
                                    >mdi-book-plus</v-icon
                                >
                                Copy Question
                            </v-btn>
                        </v-app-bar>

                        <v-container  fluid
                            style="background-color: #e4e8e4; max-width: 100% !important"
        >
                            <div>
                                <!-- Destination Row Set -->
                                <v-row dense>
                                    <v-col cols="12" md="2" class="p-2">
                                        <v-chip
                                            class="ma-2"
                                            color="cyan"
                                            label
                                            text-color="white"
                                        >
                                            <v-icon left>
                                                mdi-label
                                            </v-icon>
                                            Destination Course
                                        </v-chip>
                                    </v-col>

                                    <v-col cols="12" md="3" class="p-2">
                                        <v-select
                                            v-model="
                                                selectedCourseIdDestination
                                            "
                                            :disabled="iscourseItemsLoading"
                                            :items="courseItemsDestination"
                                            dense
                                            outlined
                                            :label="lblSelectCourse"
                                            item-text="lms_course_name"
                                            item-value="lms_course_id"
                                            @change="
                                                getAllActiveSubjectBasedonCourseDestination()
                                            "
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="3" class="p-2">
                                        <v-select
                                            outlined
                                            dense
                                            v-model="
                                                selectedSubjectIdDestination
                                            "
                                            :items="subjectItemsDestination"
                                            :disabled="subjectDataLoading"
                                            item-text="lms_subject_name"
                                            item-value="lms_subject_id"
                                            @change="
                                                getAllActiveTopicBasedonSubjectDestination()
                                            "
                                        >
                                            <template #label>
                                                {{ $t("label_subject") }}
                                                <span class="red--text">
                                                    <strong>{{
                                                        $t("label_star")
                                                    }}</strong>
                                                </span>
                                            </template>
                                        </v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                        class="pl-2 pr-4 pt-2"
                                    >
                                        <v-select
                                            outlined
                                            dense
                                            v-model="selectedTopicIdDestination"
                                            :items="topicItemsDestination"
                                            :disabled="topicDataLoading"
                                            item-text="lms_topic_name"
                                            item-value="lms_topic_id"
                                            @change="activeSource()"
                                        >
                                            <template #label
                                                >{{ $t("label_topic") }}
                                                <span class="red--text">
                                                    <strong>{{
                                                        $t("label_star")
                                                    }}</strong>
                                                </span></template
                                            >
                                        </v-select>
                                    </v-col>
                                </v-row>

                                <!-- Destination Row Set End -->

                                <!-- Source Row Set -->
                                <v-row dense v-if="activeSourceSet">
                                    <v-col cols="12" md="2" class="p-2">
                                        <v-chip
                                            class="ma-2"
                                            color="primary"
                                            label
                                            text-color="white"
                                        >
                                            <v-icon left>
                                                mdi-label
                                            </v-icon>
                                            Source Question Set
                                        </v-chip>
                                    </v-col>

                                    <v-col cols="12" md="3" class="p-2">
                                        <v-select
                                            v-model="selectedCourseId"
                                            :disabled="iscourseItemsLoading"
                                            :items="courseItems"
                                            dense
                                            outlined
                                            :label="lblSelectCourse"
                                            item-text="lms_course_name"
                                            item-value="lms_course_id"
                                            @change="
                                                getAllActiveSubjectBasedonCourse()
                                            "
                                        ></v-select>
                                    </v-col>
                                    <v-col cols="12" md="3" class="p-2">
                                        <v-select
                                            outlined
                                            dense
                                            v-model="selectedSubjectId"
                                            :items="subjectItems"
                                            :disabled="subjectDataLoading"
                                            item-text="lms_subject_name"
                                            item-value="lms_subject_id"
                                            @change="
                                                getAllActiveTopicBasedonSubject()
                                            "
                                        >
                                            <template #label>
                                                {{ $t("label_subject") }}
                                                <span class="red--text">
                                                    <strong>{{
                                                        $t("label_star")
                                                    }}</strong>
                                                </span>
                                            </template>
                                        </v-select>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        md="4"
                                        class="pl-2 pr-4 pt-2"
                                    >
                                        <v-select
                                            outlined
                                            dense
                                            v-model="selectedTopicId"
                                            :items="topicItems"
                                            :disabled="topicDataLoading"
                                            item-text="lms_topic_name"
                                            item-value="lms_topic_id"
                                            @change="
                                                isSearchByQuestionBank = true;
                                                getAllActiveQuestionBasedOnCondition(
                                                    $event
                                                );
                                            "
                                        >
                                            <template #label
                                                >{{ $t("label_topic") }}
                                                <span class="red--text">
                                                    <strong>{{
                                                        $t("label_star")
                                                    }}</strong>
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
                <v-col class="ml-2">
                    <!-- Card Start -->
                    <v-card>
                        <v-app-bar dark color="primary">
                            <v-toolbar-title color="success">{{
                                $t("label_question_bank_directory")
                            }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                        </v-app-bar>

                        <v-container  fluid
                          style="background-color: #e4e8e4; max-width: 100% !important"
        >
                            <v-card class="mx-auto" max-width="100%">
                                <!-- <v-card-title>
      <v-text-field
        v-model="search"
        append-icon="mdi-magnify"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title> -->
                                <v-data-table
                                    dense
                                    show-select
                                    v-model="selectedQuestionId"
                                    :headers="tableHeader"
                                    :items="dataTableRowNumbering"
                                    item-key="lms_question_bank_id"
                                    class="elevation-1"
                                    :loading="tableDataLoading"
                                    :loading-text="tableLoadingDataText"
                                    :server-items-length="totalItemsInDB"
                                    :items-per-page="25"
                                    @pagination="
                                        getAllActiveQuestionBasedOnCondition
                                    "
                                    @input="enterSelect()"
                                    style="width: 100%; align-content: center;"
                                    :footer-props="{
                                        itemsPerPageOptions: [
                                            100,
                                            50,
                                            200,
                                            500,
                                            100,
                                            -1
                                        ]
                                    }"
                                    :search="search"
                                >
                                    <template v-slot:no-data>
                                        <p
                                            class="font-weight-black bold title"
                                            style="color:red"
                                        >
                                            {{ $t("label_no_data_found") }}
                                        </p>
                                    </template>
                                    <!-- <template
                                        v-slot:item.lms_question_bank_id="{
                                            item
                                        }"
                                    >
                                        <td>
                                            Custom
                                            {{ item.lms_question_bank_id }}
                                        </td>
                                    </template>
                                    <template
                                        v-slot:item.data-table-select="{
                                            on,
                                            props
                                        }"
                                    >
                                        <v-simple-checkbox
                                            color="green"
                                            v-bind="props"
                                            v-on="on"
                                        ></v-simple-checkbox>
                                    </template>
                                    <template
                                        v-slot:item.lms_question_bank_id="{
                                            item
                                        }"
                                    >
                                        <td>
                                            Custom
                                            {{ item.lms_question_bank_id }}
                                        </td>
                                    </template> -->
                                    <template
                                        v-slot:item.lms_question_bank_is_active="{
                                            item
                                        }"
                                    >
                                        <v-checkbox
                                            color="primary"
                                            @change="
                                                setSelectedQuestion(
                                                    item,
                                                    $event
                                                )
                                            "
                                            v-model="
                                                item.lms_question_bank_is_active
                                            "
                                        ></v-checkbox>
                                    </template>
                                    <template
                                        v-slot:item.lms_question_difficulty_level_name="{
                                            item
                                        }"
                                        class="m-0 p-0"
                                    >
                                        <v-chip
                                            x-small
                                            :color="
                                                getDifficultyLevelColor(
                                                    item.lms_question_difficulty_level_name
                                                )
                                            "
                                            dark
                                            >{{
                                                item.lms_question_difficulty_level_name
                                            }}</v-chip
                                        >
                                    </template>
                                    <template
                                        v-slot:item.lms_question_bank_type_single_multiple="{
                                            item
                                        }"
                                        class="m-0 p-0"
                                    >
                                        <v-chip
                                            x-small
                                            :color="
                                                getStatusColor(
                                                    item.lms_question_bank_type_single_multiple
                                                )
                                            "
                                            dark
                                            >{{
                                                item.lms_question_bank_type_single_multiple
                                            }}</v-chip
                                        >
                                    </template>
                                    <template v-slot:top>
                                        <v-toolbar flat>
                                            
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                icon
                                                small
                                                color="teal"
                                                v-if="!tableDataLoading"
                                            >
                                                <download-excel
                                                    :data="excelData"
                                                    :fields="excelFields"
                                                    :name="excelFileName"
                                                >
                                                    <v-icon dark
                                                        >mdi-file-excel</v-icon
                                                    >
                                                </download-excel>
                                            </v-btn>

                                            <v-btn
                                                v-if="!tableDataLoading"
                                                icon
                                                small
                                                color="red"
                                                @click="savePDF"
                                            >
                                                <v-icon dark
                                                    >mdi-file-pdf</v-icon
                                                >
                                            </v-btn>
                                        </v-toolbar>
                                    </template>

                                    <template
                                        v-slot:item.lms_course_name="{ item }"
                                    >
                                        <div
                                            style="white-space: nowrap; width:100%;"
                                        >
                                            <span
                                                style="display: inline-block; overflow: hidden; text-overflow: ellipsis; width:100%;"
                                            >
                                                {{ item.lms_course_name }}</span
                                            >
                                        </div></template
                                    >

                                    <template
                                        v-slot:item.lms_question_bank_text="{
                                            item
                                        }"
                                    >
                                        <div
                                            v-html="item.lms_question_bank_text"
                                            style="align-content: center;"
                                        ></div>

                                        <!-- <vue-mathjax :formula="formula"></vue-mathjax> -->
                                    </template>
                                    <template v-slot:item.actions="{ item }">
                                        <v-icon
                                            v-permission="'Question Bank'"
                                            small
                                            class="mr-1"
                                            @click="editQuestionBank(item)"
                                            color="primary"
                                            >mdi-pencil</v-icon
                                        >
                                        <v-icon
                                            v-if="
                                                item.lms_question_bank_is_active ==
                                                    'Active'
                                            "
                                            v-permission="'Question Bank'"
                                            small
                                            color="error"
                                            @click="
                                                enableDisableExamSchedule(item)
                                            "
                                            >mdi-delete</v-icon
                                        >
                                        <v-icon
                                            v-if="
                                                item.lms_question_bank_is_active ==
                                                    'Inactive'
                                            "
                                            v-permission="'Question Bank'"
                                            small
                                            color="success"
                                            @click="
                                                enableDisableExamSchedule(item)
                                            "
                                            >mdi-check-circle</v-icon
                                        >
                                        <v-icon
                                            v-if="true"
                                            v-permission="'Question Bank'"
                                            small
                                            class="mr-1"
                                            @click="viewQuestionBank(item)"
                                            color="info"
                                            >mdi-eye</v-icon
                                        >
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
            >{{ snackBarMessage }}</v-snackbar
        >

        <!-- //Question Dialog -->

        <v-dialog
            v-model="questionDialog"
            fullscreen
            hide-overlay
            transition="dialog-bottom-transition"
            scrollable
        >
            <v-card>
                <v-toolbar dark color="primary" dense max-height="60">
                    <v-btn icon dark @click="questionDialog = false">
                        <v-icon>mdi-close</v-icon></v-btn
                    >
                    <v-toolbar-title>Question View</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn dark text @click="questionDialog = false"
                            >Close</v-btn
                        >
                    </v-toolbar-items>
                </v-toolbar>
                <div class="text-center">
                    <v-chip class="ma-2" color="green" text-color="white"
                        ><v-avatar left class="green darken-4">C</v-avatar
                        >{{ DialogCourse }}</v-chip
                    >
                    <v-chip class="ma-2" color="green" text-color="white"
                        ><v-avatar left class="green darken-4">S</v-avatar
                        >{{ DialogSubject }}</v-chip
                    >
                    <v-chip class="ma-2" color="green" text-color="white"
                        ><v-avatar left class="green darken-4">T</v-avatar
                        >{{ DialogTopic }}</v-chip
                    >
                    <v-chip class="ma-2" color="green" text-color="white"
                        ><v-avatar left class="green darken-4">H</v-avatar
                        >{{ DialogQuestionTag }}</v-chip
                    >
                </div>
                <v-divider></v-divider>

                <v-card-text>
                    <v-alert color="primary" outlined dense
                        >Question Section</v-alert
                    >
                    <!-- <div v-html="DialogQuestionText"></div>  -->
                    <ckeditor
                        :editor="editor"
                        v-model="DialogQuestionText"
                        :config="editorConfig"
                    ></ckeditor>

                    <div v-if="DialogQuestionHasImage == 1">
                        <v-img
                            :lazy-src="DialogQuestionImage"
                            :src="DialogQuestionImage"
                            alt=""
                            max-height="500"
                            max-width="500"
                            contain
                        ></v-img>
                    </div>

                    <v-divider></v-divider>
                    <v-alert color="primary" outlined dense
                        >Option Section</v-alert
                    >
                    <v-simple-table dense fixed-header>
                        <thead style="border: 1px solid #d9d9d9;">
                            <tr>
                                <th
                                    class="text-centre"
                                    style="text-align: center;background:#555555;color:white"
                                >
                                    <strong>Option 1 | A</strong>
                                </th>
                                <th
                                    class="text-centre"
                                    style="text-align: center;background:#555555;color:white"
                                >
                                    <strong>Option 2 | B</strong>
                                </th>
                                <th
                                    class="text-centre"
                                    style="text-align: center;background:#555555;color:white"
                                >
                                    <strong>Option 3 | C</strong>
                                </th>
                                <th
                                    class="text-centre"
                                    style="text-align: center;background:#555555;color:white"
                                >
                                    <strong>Option 4 | D</strong>
                                </th>
                                <th
                                    class="text-centre"
                                    style="text-align: center;background:#555555;color:white"
                                >
                                    <strong>Option 5 | E</strong>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border: 1px solid #d9d9d9;">
                                <td style="border: 1px solid #d9d9d9;">
                                    <div v-if="DialogOption1HasImage == 0">
                                        <ckeditor
                                            :editor="editor"
                                            v-model="DialogOption1"
                                            :config="editorConfig"
                                        ></ckeditor>
                                        <!-- <div v-html="DialogOption1" ></div> -->
                                    </div>
                                    <div v-else>
                                        <v-img
                                            max-height="150"
                                            max-width="250"
                                            :lazy-src="DialogOption1Image"
                                            contain
                                            :src="DialogOption1Image"
                                            alt=""
                                        ></v-img>
                                    </div>
                                </td>
                                <td style="border: 1px solid #d9d9d9;">
                                    <div v-if="DialogOption2HasImage == 0">
                                        <ckeditor
                                            :editor="editor"
                                            v-model="DialogOption2"
                                            :config="editorConfig"
                                        ></ckeditor>
                                        <!-- <div v-html="DialogOption2" ></div> -->
                                    </div>
                                    <div v-else>
                                        <v-img
                                            max-height="150"
                                            max-width="250"
                                            :lazy-src="DialogOption2Image"
                                            :src="DialogOption2Image"
                                            contain
                                        ></v-img>
                                    </div>
                                </td>
                                <td style="border: 1px solid #d9d9d9;">
                                    <div v-if="DialogOption3HasImage == 0">
                                        <ckeditor
                                            :editor="editor"
                                            v-model="DialogOption3"
                                            :config="editorConfig"
                                        ></ckeditor>
                                        <!-- <div v-html="DialogOption3" ></div> -->
                                    </div>
                                    <div v-else>
                                        <v-img
                                            max-height="150"
                                            max-width="250"
                                            :lazy-src="DialogOption3Image"
                                            :src="DialogOption3Image"
                                            contain
                                        ></v-img>
                                    </div>
                                </td>
                                <td style="border: 1px solid #d9d9d9;">
                                    <div v-if="DialogOption4HasImage == 0">
                                        <ckeditor
                                            :editor="editor"
                                            v-model="DialogOption4"
                                            :config="editorConfig"
                                        ></ckeditor>
                                        <!-- <div v-html="DialogOption4" ></div> -->
                                    </div>
                                    <div v-else>
                                        <v-img
                                            max-height="150"
                                            max-width="250"
                                            :lazy-src="DialogOption4Image"
                                            :src="DialogOption4Image"
                                            contain
                                        ></v-img>
                                    </div>
                                </td>
                                <td style="border: 1px solid #d9d9d9;">
                                    <div v-if="DialogOption5HasImage == 0">
                                        <ckeditor
                                            :editor="editor"
                                            v-model="DialogOption5"
                                            :config="editorConfig"
                                        ></ckeditor>
                                        <!-- <div v-html="DialogOption5" ></div> -->
                                    </div>
                                    <div v-else>
                                        <v-img
                                            max-height="150"
                                            max-width="250"
                                            :lazy-src="DialogOption5Image"
                                            :src="DialogOption5Image"
                                            contain
                                        ></v-img>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </v-simple-table>

                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-chip
                            class="ma-2"
                            color="deep-purple accent-4"
                            text-color="white"
                            ><span>Difficulty Level : &nbsp;</span
                            ><strong>{{
                                DialogDifficultyLevel
                            }}</strong></v-chip
                        >
                        <v-chip
                            class="ma-2"
                            color="deep-purple accent-4"
                            text-color="white"
                            ><span>Marks : &nbsp;</span
                            ><strong>{{ DialogQuestionMarks }}</strong></v-chip
                        >
                        <v-chip
                            class="ma-2"
                            color="deep-purple accent-4"
                            text-color="white"
                            ><span>Total Option : &nbsp;</span
                            ><strong>{{ DialogNoOfOption }}</strong></v-chip
                        >
                        <v-alert
                            border="left"
                            colored-border
                            color="deep-purple accent-4"
                            elevation="2"
                            max-width="1000px"
                        >
                            <!-- <div v-if="lms_question_bank_solution_has_image==0" v-html="DialogSolution"></div> -->
                            <div
                                v-if="lms_question_bank_solution_has_image == 0"
                            >
                                <strong>Solution</strong> <br /><ckeditor
                                    :editor="editor"
                                    v-model="DialogSolution"
                                    :config="editorConfig"
                                ></ckeditor>
                            </div>

                            <div
                                v-if="lms_question_bank_solution_has_image == 1"
                            >
                                <v-img
                                    max-height="150"
                                    max-width="250"
                                    :lazy-src="DialogQuestionSolutionImage"
                                    :src="DialogQuestionSolutionImage"
                                    alt=""
                                ></v-img>
                            </div>
                        </v-alert>
                    </v-card-actions>
                </v-card-text>
            </v-card>
        </v-dialog>

        <!-- //Set Dialog -->
        <v-dialog v-model="dialog" hide-overlay persistent width="500">
            <v-card color="error" dark>
                <v-card-title class="headline">
                    Updating Data!!! Please Wait...
                </v-card-title>

                <v-card-text>
                    Your request is processing!!! I will automatically close
                    when done.
                    <v-progress-linear
                        indeterminate
                        color="white"
                        class="mb-0"
                    ></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>

        <!-- <h5>Selected: {{ selected }}</h5> -->
    </v-container>
</div>
</template>


<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script
    id="MathJax-script"
    async
    src="https://cdn.jsdelivr.net/npm/mathjax@3.0.1/es5/tex-mml-chtml.js"
></script>

<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });

//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
    props: ["userPermissionDataProps"],

    data() {
        return {
            // For Breadcrumb
            breadCrumbItem: [
                {
                    text: this.$t("label_home"),
                    disabled: false
                },
                {
                    text: this.$t("label_exam_schedule"),
                    disabled: false
                },
                {
                    text: this.$t("label_question_bank_directory"),
                    disabled: false
                }
            ],
            selectedQuestionId: [],
            selectedSubjectId: "1",
            selectedSubjectIdDestination: "",
            subjectItems: [],
            subjectItemsDestination: [],
            selectedTopicId: "1",
            topicItems: [],
            selectedTopicIdDestination: "",
            topicItemsDestination: [],
            subjectDataLoading: false,
            topicDataLoading: false,
            editor: ClassicEditor,
            editorData: "",
            editorConfig: {},
            search: "",
            //Question Data
            // formula:"$$x = {-b \\pm \\sqrt{b^2-4ac} \\over 2a}.$$",
            DialogCourse: "",
            DialogSubject: "",
            DialogTopic: "",
            DialogQuestionTag: "",

            DialogDifficultyLevel: "",
            DialogSingleMultiple: "",

            DialogQuestionText: "",
            DialogQuestionImage: null,

            DialogOption1: "",
            DialogOption2: "",
            DialogOption3: "",
            DialogOption4: "",
            DialogOption5: "",

            DialogOption1HasImage: "",
            DialogOption2HasImage: "",
            DialogOption3HasImage: "",
            DialogOption4HasImage: "",
            DialogOption5HasImage: "",

            DialogQuestionHasImage: "",
            DialogOption1Image: "",
            DialogOption2Image: "",
            DialogOption3Image: "",
            DialogOption4Image: "",
            DialogOption5Image: "",

            DialogCorrectAnswer: "",
            DialogQuestionMarks: "",
            DialogNoOfOption: "",
            DialogSolution: "",
            lms_question_bank_solution_has_image: "",

            // Form Data
            lblSelectCourse: this.$t("label_course"),
            selectedCourseId: "1",
            selectedCourseIdDestination: "",
            isDataProcessing: false,
            questionBankSearchCriteria: "",
            lblSearchQuestionCriteria: this.$t("label_search_question_bank"),
            iscourseItemsLoading: false,
            courseItems: [],
            courseItemsDestination: [],
            isSearchByQuestionBank: false,
            authorizationConfig: "",
            dialog: false,
            questionDialog: false,

            // Snack Bar

            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",
            activeSourceSet: false,
            activeCopyCourseButton: false,

            //   Datatable Start

            tableDataLoading: false,
            totalItemsInDB: 0,
            tableLoadingDataText: this.$t("label_loading_data"),

            tableHeader: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: this.$t("label_course_name"),
                    value: "lms_question_bank_id",
                    groupable: false,
                    width: "10%",
                    sortable: false
                },
                {
                    text: this.$t("label_course_name"),
                    value: "lms_course_name",
                    groupable: false,
                    width: "10%",
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
                    width: "10%"
                },
                {
                    text: this.$t("label_question_tag"),
                    value: "lms_question_bank_tag",
                    width: "5%",
                    sortable: false
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "15%",
                    align: "right"
                },
                {
                    text: this.$t("label_question"),
                    value: "lms_question_bank_text",
                    width: "35%",
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
                }
            ],
            tableItems: [],

            isDataProcessing: false,

            //Datatable End

            // For Excel Download
            excelFields: {
                Course: "label_course_name",
                Subject: "label_subject_name",
                Topic: "label_topic_name",
                Header: "label_question_tag",
                Question: "lms_question_bank_text",
                Option1: "lms_question_bank_options_1",
                Option2: "lms_question_bank_options_5",
                Option3: "lms_question_bank_options_3",
                Option4: "lms_question_bank_options_4",
                Option5: "lms_question_bank_options_5",
                Level: "lms_question_difficulty_level_name",
                Single_Multiple: "lms_question_bank_type_single_multiple",
                Marks: "lms_question_bank_marks",

                Solution: "lms_question_bank_solution"
            },
            excelData: [],
            excelFileName:
                "QuestionBank" + "_" + moment().format("DD/MM/YYYY") + ".xls"
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
    },

    created() {
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") }
        };

        // Get all active sources

        this.getAllActiveCourse();
        this.getAllActiveCourseDestination();
    },

    methods: {
        enterSelect() {
            console.log(
                this.selectedQuestionId.map(e => e.lms_question_bank_id)
                //this.selectedQuestionId
            ); // logs all the selected items.

            if (this.selectedQuestionId.length == this.itemsPerPage) {
                alert("selected all");
            }
        },

        // Get all active subject based on course
        getAllActiveSubjectBasedonCourse(src) {
            this.subjectDataLoading = true;
            this.$http
                .get(
                    `web_get_all_active_subject_based_on_course_without_pagination`,
                    {
                        params: {
                            centerId: ls.get("loggedUserCenterId"),
                            courseId: this.selectedCourseId
                        },
                        headers: { Authorization: "Bearer " + ls.get("token") }
                    }
                )
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
                .catch(error => {
                    this.isSourceDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },

        // Get all active subject based on course
        getAllActiveTopicBasedonSubject() {
            this.topicDataLoading = true;
            this.$http
                .get(
                    `web_get_all_active_topic_based_on_subject_without_pagination`,
                    {
                        params: {
                            centerId: ls.get("loggedUserCenterId"),
                            selectedSubjectId: this.selectedSubjectId
                        },
                        headers: { Authorization: "Bearer " + ls.get("token") }
                    }
                )
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
                .catch(error => {
                    this.isSourceDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },

        // Get all active subject based on course Destination
        getAllActiveSubjectBasedonCourseDestination(src) {
            this.subjectDataLoading = true;
            this.$http
                .get(
                    `web_get_all_active_subject_based_on_course_without_pagination`,
                    {
                        params: {
                            centerId: ls.get("loggedUserCenterId"),
                            courseId: this.selectedCourseIdDestination
                        },
                        headers: { Authorization: "Bearer " + ls.get("token") }
                    }
                )
                .then(({ data }) => {
                    this.subjectDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.subjectItemsDestination = data;
                    }
                })
                .catch(error => {
                    this.isSourceDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        activeSource() {
            this.activeSourceSet = true;
        },

        // Get all active subject based on course
        getAllActiveTopicBasedonSubjectDestination() {
            this.topicDataLoading = true;
            this.$http
                .get(
                    `web_get_all_active_topic_based_on_subject_without_pagination`,
                    {
                        params: {
                            centerId: ls.get("loggedUserCenterId"),
                            selectedSubjectId: this.selectedSubjectIdDestination
                        },
                        headers: { Authorization: "Bearer " + ls.get("token") }
                    }
                )
                .then(({ data }) => {
                    this.topicDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.topicItemsDestination = data;
                    }
                })
                .catch(error => {
                    this.isSourceDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },

        // Get all active subject based on course
        getAllActiveQuestionBasedOnCondition(e) {
            this.tableDataLoading = true;
            let postData = "";

            postData = {
                centerId: ls.get("loggedUserCenterId"),
                perPage:
                    e.itemsPerPage == -1 ? this.totalItemsInDB : e.itemsPerPage,
                courseId: this.selectedCourseId,
                subjectId: this.selectedSubjectId,
                topicId: this.selectedTopicId
            };

            this.$http
                .get(
                    `web_get_all_question_bank_based_on_condition?page=${e.page}`,
                    {
                        params: postData,
                        headers: { Authorization: "Bearer " + ls.get("token") }
                        // params: {
                        //     centerId: ls.get("loggedUserCenterId"),
                        //     courseId: this.selectedCourseId,
                        //     perPage:
                        //         e.itemsPerPage == -1
                        //             ? this.totalItemsInDB
                        //             : e.itemsPerPage
                        // },
                        // headers: { Authorization: "Bearer " + ls.get("token") }
                    }
                )
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
                        this.activeCopyCourseButton = true;
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

        // View Staff
        viewQuestionBank(item) {
            this.DialogCourse = item.lms_course_name;
            this.DialogSubject = item.lms_subject_name;
            this.DialogTopic = item.lms_topic_name;

            this.DialogDifficultyLevel =
                item.lms_question_difficulty_level_name;
            this.DialogSingleMultiple =
                item.lms_question_bank_type_single_multiple;

            this.DialogQuestionText = item.lms_question_bank_text;
            this.DialogQuestionTag = item.lms_question_bank_tag;
            this.DialogQuestionHasImage = item.lms_question_bank_has_image;
            this.DialogQuestionImage =
                process.env.MIX_QUESTION_IMAGE_URL +
                item.lms_question_bank_image_path;

            this.DialogOption1 = item.lms_question_bank_options_1;
            this.DialogOption2 = item.lms_question_bank_options_2;
            this.DialogOption3 = item.lms_question_bank_options_3;
            this.DialogOption4 = item.lms_question_bank_options_4;
            this.DialogOption5 = item.lms_question_bank_options_5;

            this.DialogOption1HasImage =
                item.lms_question_bank_options_1_has_image;
            this.DialogOption2HasImage =
                item.lms_question_bank_options_2_has_image;
            this.DialogOption3HasImage =
                item.lms_question_bank_options_3_has_image;
            this.DialogOption4HasImage =
                item.lms_question_bank_options_4_has_image;
            this.DialogOption5HasImage =
                item.lms_question_bank_options_5_has_image;

            this.DialogOption1Image =
                process.env.MIX_ANSWER_IMAGE_URL +
                item.lms_question_bank_options_1;
            this.DialogOption2Image =
                process.env.MIX_ANSWER_IMAGE_URL +
                item.lms_question_bank_options_2;
            this.DialogOption3Image =
                process.env.MIX_ANSWER_IMAGE_URL +
                item.lms_question_bank_options_3;
            this.DialogOption4Image =
                process.env.MIX_ANSWER_IMAGE_URL +
                item.lms_question_bank_options_4;
            this.DialogOption5Image =
                process.env.MIX_ANSWER_IMAGE_URL +
                item.lms_question_bank_options_5;

            this.DialogCorrectAnswer = item.lms_question_bank_correct_answers;
            this.DialogQuestionMarks = item.lms_question_bank_marks;
            this.DialogNoOfOption = item.lms_question_bank_no_of_option;
            this.DialogSolution = item.lms_question_bank_solution;
            this.lms_question_bank_solution_has_image =
                item.lms_question_bank_solution_has_image;
            this.DialogQuestionSolutionImage =
                process.env.MIX_SOLUTION_IMAGE_URL +
                item.lms_question_bank_solution;

            this.questionDialog = true;

            console.log(this.DialogOption1Image);

            // this.$router.push({
            //   name: "HumanResourceStaffProfile",
            //   params: { questionBankId: item.lms_question_bank_id}
            // });
        },

        // Get all active course
        getAllActiveCourseDestination() {
            this.isCourseDataLoading = true;
            this.$http
                .get(`web_get_active_course_without_pagination`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId")
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
                })
                .then(({ data }) => {
                    this.isCourseDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.courseItemsDestination = data;
                    }
                })
                .catch(error => {
                    this.isCourseDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },

        // Get all active course
        getAllActiveCourse() {
            this.isCourseDataLoading = true;
            this.$http
                .get(`web_get_active_course_without_pagination`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId")
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
                })
                .then(({ data }) => {
                    this.isCourseDataLoading = false;
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
                    this.isCourseDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        // Question Bank
        editQuestionBank(item) {
            this.$router.push({
                name: "AddQuestionBank",
                params: { questionBankDataProps: item }
            });

            //let routeData = this.$router.resolve({name: 'AddQuestionBank', params: {questionBankDataProps: item}});
            //window.open(routeData.href, '_blank');
        },
        // Copy Question
        QuestionBankCopy() {
            if (
                this.selectedQuestionId.map(e => e.lms_question_bank_id)
                    .length < 1
            ) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(
                    "Copy need atleast 1 (One) question"
                );
            } else {
                let userDecision = confirm(
                    this.$t("label_question_copied_sure") +
                        this.selectedQuestionId.map(e => e.lms_question_bank_id)
                            .length +
                        " Question(s)"
                );
                if (userDecision) {
                    this.isDataProcessing = true;
                    // this.dialog = true;
                    //Set Dialog
                    this.$http
                        .post(
                            "web_save_copy_question_bank",
                            {
                                centerId: ls.get("loggedUserCenterId"),
                                loggedUserId: ls.get("loggedUserId"),
                                QuestionList: this.selectedQuestionId
                                    .map(e => e.lms_question_bank_id)
                                    .toString(),
                                CourseId: this.selectedCourseIdDestination,
                                SubjectId: this.selectedSubjectIdDestination,
                                TopicId: this.selectedTopicIdDestination
                            },
                            this.authorizationConfig
                        )
                        .then(({ data }) => {
                            console.log("Response" + data.responseData);
                            this.isDataProcessing = false;
                            //this.dialog = false;
                            //User Unauthorized
                            if (
                                data.error == "Unauthorized" ||
                                data.permissionError == "Unauthorized"
                            ) {
                                this.$store.dispatch(
                                    "actionUnauthorizedLogout"
                                );
                            } else {
                                // Staff Status changed
                                if (data.responseData == "2") {
                                    this.snackBarColor = "success";
                                    this.changeSnackBarMessage(
                                        this.$t("label_question_copied")
                                    );
                                    this.getAllActiveQuestionBasedOnCondition(
                                        event
                                    );
                                }
                                // Staff Status changed failed
                                else if (data.responseData == 1) {
                                    this.snackBarColor = "error";
                                    this.changeSnackBarMessage(
                                        this.$t("label_something_went_wrong")
                                    );
                                }
                            }
                        })
                        .catch(error => {
                            console.log(error);
                            this.isDataProcessing = false;
                            this.snackBarColor = "error";
                            this.changeSnackBarMessage(
                                this.$t("label_something_went_wrong")
                            );
                        });
                }
            }
        },
        // Enable  Disable Staff Status
        enableDisableExamSchedule(item, $event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_status_exam_schedule")
            );
            if (userDecision) {
                this.isDataProcessing = true;
                this.dialog = true;
                //Set Dialog
                this.$http
                    .post(
                        "web_delete_question_bank",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            loggedUserId: ls.get("loggedUserId"),
                            questionBankId: item.lms_question_bank_id,
                            isQuestionBankActive:
                                item.lms_question_bank_is_active == "Active"
                                    ? 0
                                    : 1
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
                            if (data.responseData == "1") {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_quesion_bank_status_changed")
                                );
                                this.getAllActiveQuestionBasedOnCondition(
                                    event
                                );
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
                    .catch(error => {
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
        // Export to PDF
        savePDF() {
            const pdfDoc = new jsPDF({ orientation: "landscape" });

            pdfDoc.autoTable({
                columns: [
                    { header: "Course", dataKey: "lms_course_name" },
                    { header: "Type", dataKey: "lms_exam_schedule_type" },
                    { header: "Name", dataKey: "lms_exam_schedule_name" },
                    {
                        header: "Live From",
                        dataKey: "lms_exam_schedule_live_from"
                    },
                    { header: "Live To", dataKey: "lms_exam_schedule_live_to" },

                    {
                        header: "Total Question",
                        dataKey: "lms_exam_schedule_no_of_question"
                    },
                    {
                        header: "Total Marks",
                        dataKey: "lms_exam_schedule_max_marks"
                    },
                    {
                        header: "Total Time",
                        dataKey: "lms_exam_schedule_total_time_alloted"
                    },
                    {
                        header: "Free/Paid",
                        dataKey: "lms_exam_schedule_is_free_paid"
                    },
                    {
                        header: "Pass Marks",
                        dataKey: "lms_exam_schedule_pass_marks"
                    },
                    {
                        header: "Status",
                        dataKey: "lms_exam_schedule_is_active_live"
                    }
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 }
            });
            pdfDoc.save(
                "EnquiryListAsPDF" +
                    "_" +
                    moment().format("DD/MM/YYYY") +
                    ".pdf"
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
