<template>
    <!-- Card Start -->
    <v-container
    fluid
        style="background-color: #e4e8e4; max-width: 100% !important"
        >
        <v-sheet class="pa-4 mb-4" >
        <v-breadcrumbs :items="breadCrumbItem">
            <template v-slot:divider>
                <v-icon>mdi-forward</v-icon>
            </template>
        </v-breadcrumbs>
    </v-sheet>
        <v-overlay :value="alertMessage == ''" color="primary">
            <v-progress-circular
                indeterminate
                size="64"
                color="primary"
            ></v-progress-circular>
        </v-overlay>
        <v-alert
            dense
            v-if="alertMessage != ''"
            text
            :type="alertType"
            elevation="2"
            dismissible
            transition="fade-transition"
            >{{ alertMessage }}</v-alert
        >

        <v-form
            ref="holdingFormBasic"
            v-model="isBasicHoldingFormValid"
            lazy-validation
        >
            <v-expansion-panels v-model="panel" single accordion focusable>
                <v-app-bar dark color="primary">
                    <v-toolbar-title color="success">{{
                        $t("label_add_question_bank")
                    }}</v-toolbar-title>
                </v-app-bar>
                <v-expansion-panel>
                    <v-expansion-panel-header v-slot="{ open }">
                        <v-row no-gutters>
                            <v-col cols="4">
                                <strong>Stream Settings</strong>
                            </v-col>
                            <v-col cols="8" class="text--secondary">
                                <v-fade-transition leave-absolute>
                                    <span v-if="open" key="0"
                                        >Select Stream | Subject | Topic</span
                                    ><span v-else key="1">
                                        <v-row no-gutters style="width: 100%">
                                            <v-col cols="6">
                                                Stream:
                                                {{
                                                    courseItems.selectedCourseId ||
                                                        "Not Selected"
                                                }}</v-col
                                            >
                                        </v-row>
                                    </span>
                                </v-fade-transition>
                            </v-col>
                            <template v-slot:actions>
                                <v-icon color="primary">
                                    mdi-arrow-down-drop-circle
                                </v-icon>
                            </template>
                        </v-row>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-row dense class="ml-2 mr-2 mt-2">
                            <v-col cols="12" md="3" sm="6" v-if="false">
                                <v-text-field
                                    v-model="lms_question_bank_id"
                                    outlined
                                    dense
                                    disabled
                                >
                                    <template #label>{{
                                        $t("label_code")
                                    }}</template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" md="4" sm="12">
                                <v-select
                                    outlined
                                    dense
                                    v-model="selectedCourseId"
                                    :items="courseItems"
                                    :disabled="isCourseDataLoading"
                                    item-text="lms_course_name"
                                    item-value="lms_course_id"
                                    @change="
                                        getAllActiveSubjectBasedonCourse(this)
                                    "
                                >
                                    <template #label
                                        >{{ $t("label_stream") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span></template
                                    >
                                </v-select>
                            </v-col>

                            <v-col cols="12" md="4" sm="12">
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
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-select>
                            </v-col>

                            <v-col cols="12" md="4" sm="12">
                                <v-select
                                    outlined
                                    dense
                                    v-model="selectedTopicId"
                                    :items="topicItems"
                                    :disabled="topicDataLoading"
                                    item-text="lms_topic_name"
                                    item-value="lms_topic_id"
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
                    </v-expansion-panel-content>
                </v-expansion-panel>

                <v-expansion-panel>
                    <v-expansion-panel-header
                        ><strong>Marks Settings</strong>
                        <template v-slot:actions>
                            <v-icon color="teal">
                                mdi-arrow-down-drop-circle
                            </v-icon>
                        </template>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <v-row dense class="ml-2 mr-2 mt-2">
                            <v-col cols="12" md="6">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="QuestionMarks"
                                    @keypress="isDigit"
                                    :rules="[v => !!v || $t('label_required')]"
                                >
                                    <template #label>
                                        {{ $t("label_exam_question_marks") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" md="6">
                                <v-select
                                    outlined
                                    dense
                                    v-model="difficultyLevel"
                                    :items="difficultyLevelItems"
                                    item-text="lms_question_difficulty_level_name"
                                    item-value="lms_question_difficulty_level_id"
                                    :rules="[v => !!v || $t('label_required')]"
                                >
                                    <template #label>
                                        {{ $t("label_exam_difficulty_level") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-select>
                            </v-col>

                            <v-col cols="12" md="6">
                                <v-select
                                    outlined
                                    dense
                                    v-model="selectedAnswerType"
                                    :items="selectedAnswerItems"
                                    item-text="lms_question_bank_type_single_multiple"
                                    item-value="lms_question_bank_type_single_multiple_value"
                                    :rules="[v => !!v || $t('label_required')]"
                                    @change="setAnswerType()"
                                >
                                    <template #label
                                        >{{ $t("label_exam_answer_type") }}
                                        <span class="red--text"
                                            ><strong>{{
                                                $t("label_star")
                                            }}</strong></span
                                        ></template
                                    >
                                </v-select>
                            </v-col>

                            <v-col cols="12" md="6">
                                <v-select
                                    outlined
                                    dense
                                    v-model="selectedNoOfOptions"
                                    :items="NoOfOptionsItems"
                                    item-text="lms_question_bank_no_of_option"
                                    item-value="lms_question_bank_no_of_option_value"
                                    :rules="[v => !!v || $t('label_required')]"
                                    @change="OptionShowHide()"
                                >
                                    <template #label
                                        >{{ $t("label_exam_no_of_options") }}
                                        <span class="red--text"
                                            ><strong>{{
                                                $t("label_star")
                                            }}</strong></span
                                        ></template
                                    >
                                </v-select>
                            </v-col>
                        </v-row>
                    </v-expansion-panel-content>
                </v-expansion-panel>

                <!-- //Question & Answer Section -->
                <v-expansion-panel>
                    <v-expansion-panel-header>
                        <strong>Question</strong>

                        <template v-slot:actions>
                            <v-icon color="error">
                                mdi-arrow-down-drop-circle
                            </v-icon>
                        </template>
                    </v-expansion-panel-header>

                    <v-expansion-panel-content>
                        <v-row>
                            <v-col cols="12" md="8">
                                <v-file-input
                                    v-model="selectedQuestionImage"
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
                                        >Question Image
                                        <span class="red--text"
                                            ><strong>{{
                                                $t("label_star")
                                            }}</strong></span
                                        ></template
                                    >
                                </v-file-input>
                            </v-col>

                            <v-col cols="12" md="4">
                                <v-select
                                    outlined
                                    dense
                                    :multiple="SelectMultiple"
                                    v-model="selectedCorrectOptions"
                                    :items="CorrectOptionsItems"
                                    item-text="lms_question_bank_correct_answers"
                                    item-value="lms_question_bank_correct_answers_value"
                                    :rules="[v => !!v || $t('label_required')]"
                                >
                                    <template #label
                                        >{{ $t("label_exam_correct_options") }}
                                        <span class="red--text"
                                            ><strong>{{
                                                $t("label_star")
                                            }}</strong></span
                                        ></template
                                    >
                                </v-select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="12" class="m-0 p-0">
                                <v-text-field
                                    v-model="questionTag"
                                    outlined
                                    dense
                                    label="Question Tag"
                                    clearable
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12" md="12" class="m-0 p-0">
                                <!-- <vue-editor v-model="selectedQuestionText" :editor-toolbar="customToolbar" :rules="[(v) => !!v || $t('label_required')]"></vue-editor> -->
                                <ckeditor
                                    :editor="editor"
                                    v-model="selectedQuestionText"
                                    :config="editorConfig"
                                ></ckeditor>
                            </v-col>
                        </v-row>
                    </v-expansion-panel-content>
                </v-expansion-panel>

                <v-expansion-panel>
                    <v-expansion-panel-header>
                        <strong>Options</strong>

                        <template v-slot:actions>
                            <v-icon color="error">
                                mdi-arrow-down-drop-circle
                            </v-icon>
                        </template>
                    </v-expansion-panel-header>

                    <v-expansion-panel-content dense class="p-0 m-0">
                        <v-tabs vertical>
                            <v-tab
                                v-if="Option1ShowHide"
                                @click="
                                    selectedOption1Color = 'primary';
                                    selectedOption2Color = '';
                                    selectedOption3Color = '';
                                    selectedOption4Color = '';
                                    selectedOption5Color = '';
                                    selectedOptionSolColor = '';
                                "
                            >
                                <v-chip
                                    :color="selectedOption1Color"
                                    text-color="white"
                                    class="mt-2"
                                >
                                    <v-icon left>mdi-arrow-right-bold</v-icon>
                                    Option A
                                </v-chip></v-tab
                            >

                            <v-tab
                                v-if="Option2ShowHide"
                                @click="
                                    selectedOption1Color = '';
                                    selectedOption2Color = 'primary';
                                    selectedOption3Color = '';
                                    selectedOption4Color = '';
                                    selectedOption5Color = '';
                                    selectedOptionSolColor = '';
                                "
                            >
                                <v-chip
                                    :color="selectedOption2Color"
                                    text-color="white"
                                    class="mt-2"
                                >
                                    <v-icon left>mdi-arrow-right-bold</v-icon>
                                    Option B
                                </v-chip></v-tab
                            >

                            <v-tab
                                v-if="Option3ShowHide"
                                @click="
                                    selectedOption1Color = '';
                                    selectedOption2Color = '';
                                    selectedOption3Color = 'primary';
                                    selectedOption4Color = '';
                                    selectedOption5Color = '';
                                    selectedOptionSolColor = '';
                                "
                            >
                                <v-chip
                                    :color="selectedOption3Color"
                                    text-color="white"
                                    class="mt-2"
                                >
                                    <v-icon left>mdi-arrow-right-bold</v-icon>
                                    Option C
                                </v-chip>
                            </v-tab>

                            <v-tab
                                v-if="Option4ShowHide"
                                @click="
                                    selectedOption1Color = '';
                                    selectedOption2Color = '';
                                    selectedOption3Color = '';
                                    selectedOption4Color = 'primary';
                                    selectedOption5Color = '';
                                    selectedOptionSolColor = '';
                                "
                            >
                                <v-chip
                                    :color="selectedOption4Color"
                                    text-color="white"
                                    class="mt-2"
                                >
                                    <v-icon left>mdi-arrow-right-bold</v-icon>
                                    Option D</v-chip
                                >
                            </v-tab>

                            <v-tab
                                v-if="Option5ShowHide"
                                @click="
                                    selectedOption1Color = '';
                                    selectedOption2Color = '';
                                    selectedOption3Color = '';
                                    selectedOption4Color = '';
                                    selectedOption5Color = 'primary';
                                    selectedOptionSolColor = '';
                                "
                            >
                                <v-chip
                                    :color="selectedOption5Color"
                                    text-color="white"
                                    class="mt-2"
                                >
                                    <v-icon left>mdi-arrow-right-bold</v-icon>
                                    Option E</v-chip
                                >
                            </v-tab>
                            <v-tab
                                @click="
                                    selectedOption1Color = '';
                                    selectedOption2Color = '';
                                    selectedOption3Color = '';
                                    selectedOption4Color = '';
                                    selectedOption5Color = '';
                                    selectedOptionSolColor = 'cyan';
                                "
                            >
                                <v-chip
                                    :color="selectedOptionSolColor"
                                    text-color="white"
                                    class="mt-2"
                                >
                                    Solution
                                    <v-icon right class="ml-2"
                                        >mdi-lightbulb-on
                                    </v-icon></v-chip
                                >
                            </v-tab>
                            <!-- Option 1 Start -->
                            <v-tab-item v-if="Option1ShowHide">
                                <v-card flat>
                                    <v-card-text>
                                        <v-row dense>
                                            <v-col cols="12" md="4">
                                                <v-btn-toggle
                                                    v-model="toggle_option1"
                                                    mandatory
                                                    color="primary"
                                                    @change="toggle1Change()"
                                                >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Text</span
                                                        ><v-icon right
                                                            >mdi-clipboard-text</v-icon
                                                        ></v-btn
                                                    >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Image</span
                                                        ><v-icon right
                                                            >mdi-image-album</v-icon
                                                        ></v-btn
                                                    >
                                                </v-btn-toggle>
                                            </v-col>
                                            <v-col cols="12" md="8">
                                                <v-alert dense type="info"
                                                    >Select
                                                    <strong
                                                        >Image or Text</strong
                                                    >
                                                    for Option</v-alert
                                                >
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="Op1RowImageShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <v-file-input
                                                    v-model="
                                                        selectedOptionImage1
                                                    "
                                                    color="primary"
                                                    outlined
                                                    dense
                                                    show-size
                                                    accept="image/*"
                                                    :rules="imageRule"
                                                    @change="Image1Selected"
                                                >
                                                    <template
                                                        v-slot:selection="{
                                                            index,
                                                            text
                                                        }"
                                                    >
                                                        <v-chip
                                                            v-if="index < 1"
                                                            color="primary"
                                                            dark
                                                            label
                                                            small
                                                            >{{ text }}</v-chip
                                                        >
                                                    </template>
                                                    <template #label
                                                        >Option 1 Image
                                                        <span class="red--text"
                                                            ><strong>{{
                                                                $t("label_star")
                                                            }}</strong></span
                                                        ></template
                                                    >
                                                </v-file-input>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <div
                                                    class="
                            d-flex
                            flex-column
                            justify-space-between
                            align-center
                          "
                                                    cols="11"
                                                    md="11"
                                                >
                                                    <v-card>
                                                        <v-img
                                                            :src="
                                                                Option1ImagePreview
                                                            "
                                                            :width="Imagewidth"
                                                            contain
                                                            lass="grey darken-4"
                                                            :aspect-ratio="
                                                                16 / 9
                                                            "
                                                        ></v-img>
                                                        <v-card-actions>
                                                            <v-slider
                                                                v-model="
                                                                    Imagewidth
                                                                "
                                                                class="align-self-stretch"
                                                                min="400"
                                                                max="700"
                                                                step="10"
                                                                thumb-label
                                                                ticks
                                                                append-icon="mdi-magnify-plus-outline"
                                                                prepend-icon="mdi-magnify-minus-outline"
                                                            ></v-slider>
                                                        </v-card-actions>
                                                    </v-card>
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="Op1RowTextShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <!-- <vue-editor v-model="selectedOptionText1" :editor-toolbar="customToolbar"></vue-editor> -->
                                                <ckeditor
                                                    :editor="editor"
                                                    v-model="
                                                        selectedOptionText1
                                                    "
                                                    :config="editorConfig"
                                                ></ckeditor>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                            <!-- Option 2 Start -->
                            <v-tab-item v-if="Option2ShowHide">
                                <v-card flat>
                                    <v-card-text>
                                        <v-row dense>
                                            <v-col cols="12" md="4">
                                                <v-btn-toggle
                                                    v-model="toggle_option2"
                                                    mandatory
                                                    color="primary"
                                                    @change="toggle2Change()"
                                                >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Text</span
                                                        ><v-icon right
                                                            >mdi-clipboard-text</v-icon
                                                        ></v-btn
                                                    >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Image</span
                                                        ><v-icon right
                                                            >mdi-image-album</v-icon
                                                        ></v-btn
                                                    >
                                                </v-btn-toggle>
                                            </v-col>
                                            <v-col cols="12" md="8">
                                                <v-alert dense type="info"
                                                    >Select
                                                    <strong
                                                        >Image or Text</strong
                                                    >
                                                    for Option</v-alert
                                                >
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="Op2RowImageShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <v-file-input
                                                    v-model="
                                                        selectedOptionImage2
                                                    "
                                                    color="primary"
                                                    outlined
                                                    dense
                                                    show-size
                                                    accept="image/*"
                                                    :rules="imageRule"
                                                    @change="Image2Selected"
                                                >
                                                    <template
                                                        v-slot:selection="{
                                                            index,
                                                            text
                                                        }"
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
                                                        >Option 2 Image
                                                        <span class="red--text"
                                                            ><strong>{{
                                                                $t("label_star")
                                                            }}</strong></span
                                                        ></template
                                                    >
                                                </v-file-input>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <div
                                                    class="
                            d-flex
                            flex-column
                            justify-space-between
                            align-center
                          "
                                                    cols="12"
                                                    md="12"
                                                >
                                                    <v-card>
                                                        <v-img
                                                            :src="
                                                                Option2ImagePreview
                                                            "
                                                            :width="Imagewidth"
                                                            contain
                                                            class="grey darken-4"
                                                            :aspect-ratio="
                                                                16 / 9
                                                            "
                                                        ></v-img>
                                                        <v-card-actions>
                                                            <v-slider
                                                                v-model="
                                                                    Imagewidth
                                                                "
                                                                class="align-self-stretch"
                                                                min="400"
                                                                max="700"
                                                                step="10"
                                                                thumb-label
                                                                ticks
                                                                append-icon="mdi-magnify-plus-outline"
                                                                prepend-icon="mdi-magnify-minus-outline"
                                                            ></v-slider>
                                                        </v-card-actions>
                                                    </v-card>
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="Op2RowTextShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <!-- <vue-editor v-model="selectedOptionText2" :editor-toolbar="customToolbar"></vue-editor> -->
                                                <ckeditor
                                                    :editor="editor"
                                                    v-model="
                                                        selectedOptionText2
                                                    "
                                                    :config="editorConfig"
                                                ></ckeditor>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                            <!-- Option 3 Start -->
                            <v-tab-item v-if="Option3ShowHide">
                                <v-card flat>
                                    <v-card-text>
                                        <v-row dense>
                                            <v-col cols="12" md="4">
                                                <v-btn-toggle
                                                    v-model="toggle_option3"
                                                    mandatory
                                                    color="primary"
                                                    @change="toggle3Change()"
                                                >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Text</span
                                                        ><v-icon right
                                                            >mdi-clipboard-text</v-icon
                                                        ></v-btn
                                                    >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Image</span
                                                        ><v-icon right
                                                            >mdi-image-album</v-icon
                                                        ></v-btn
                                                    >
                                                </v-btn-toggle>
                                            </v-col>
                                            <v-col cols="12" md="8">
                                                <v-alert dense type="info"
                                                    >Select
                                                    <strong
                                                        >Image or Text</strong
                                                    >
                                                    for Option</v-alert
                                                >
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="Op3RowImageShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <v-file-input
                                                    v-model="
                                                        selectedOptionImage3
                                                    "
                                                    color="primary"
                                                    outlined
                                                    dense
                                                    show-size
                                                    accept="image/*"
                                                    :rules="imageRule"
                                                    @change="Image3Selected"
                                                >
                                                    <template
                                                        v-slot:selection="{
                                                            index,
                                                            text
                                                        }"
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
                                                        >Option 3 Image
                                                        <span class="red--text"
                                                            ><strong>{{
                                                                $t("label_star")
                                                            }}</strong></span
                                                        ></template
                                                    >
                                                </v-file-input>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <div
                                                    class="
                            d-flex
                            flex-column
                            justify-space-between
                            align-center
                          "
                                                    cols="12"
                                                    md="12"
                                                >
                                                    <v-card>
                                                        <v-img
                                                            :src="
                                                                Option3ImagePreview
                                                            "
                                                            :width="Imagewidth"
                                                            contain
                                                            class="grey darken-4"
                                                            :aspect-ratio="
                                                                16 / 9
                                                            "
                                                        ></v-img>
                                                        <v-card-actions>
                                                            <v-slider
                                                                v-model="
                                                                    Imagewidth
                                                                "
                                                                class="align-self-stretch"
                                                                min="400"
                                                                max="700"
                                                                step="10"
                                                                thumb-label
                                                                ticks
                                                                append-icon="mdi-magnify-plus-outline"
                                                                prepend-icon="mdi-magnify-minus-outline"
                                                            ></v-slider>
                                                        </v-card-actions>
                                                    </v-card>
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="Op3RowTextShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <!-- <vue-editor v-model="selectedOptionText3" :editor-toolbar="customToolbar"></vue-editor> -->
                                                <ckeditor
                                                    :editor="editor"
                                                    v-model="
                                                        selectedOptionText3
                                                    "
                                                    :config="editorConfig"
                                                ></ckeditor>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                            <!-- Option 4 Start -->
                            <v-tab-item v-if="Option4ShowHide">
                                <v-card flat>
                                    <v-card-text>
                                        <v-row dense>
                                            <v-col cols="12" md="4">
                                                <v-btn-toggle
                                                    v-model="toggle_option4"
                                                    mandatory
                                                    color="primary"
                                                    @change="toggle4Change()"
                                                >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Text</span
                                                        ><v-icon right
                                                            >mdi-clipboard-text</v-icon
                                                        ></v-btn
                                                    >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Image</span
                                                        ><v-icon right
                                                            >mdi-image-album</v-icon
                                                        ></v-btn
                                                    >
                                                </v-btn-toggle>
                                            </v-col>
                                            <v-col cols="12" md="8">
                                                <v-alert dense type="info"
                                                    >Select
                                                    <strong
                                                        >Image or Text</strong
                                                    >
                                                    for Option</v-alert
                                                >
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="Op4RowImageShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <v-file-input
                                                    v-model="
                                                        selectedOptionImage4
                                                    "
                                                    color="primary"
                                                    outlined
                                                    dense
                                                    show-size
                                                    accept="image/*"
                                                    :rules="imageRule"
                                                    @change="Image4Selected"
                                                >
                                                    <template
                                                        v-slot:selection="{
                                                            index,
                                                            text
                                                        }"
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
                                                        >Option 4 Image
                                                        <span class="red--text"
                                                            ><strong>{{
                                                                $t("label_star")
                                                            }}</strong></span
                                                        ></template
                                                    >
                                                </v-file-input>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <div
                                                    class="
                            d-flex
                            flex-column
                            justify-space-between
                            align-center
                          "
                                                    cols="12"
                                                    md="12"
                                                >
                                                    <v-card>
                                                        <v-img
                                                            :src="
                                                                Option4ImagePreview
                                                            "
                                                            :width="Imagewidth"
                                                            contain
                                                            class="grey darken-4"
                                                            :aspect-ratio="
                                                                16 / 9
                                                            "
                                                        ></v-img>
                                                        <v-card-actions>
                                                            <v-slider
                                                                v-model="
                                                                    Imagewidth
                                                                "
                                                                class="align-self-stretch"
                                                                min="400"
                                                                max="700"
                                                                step="10"
                                                                thumb-label
                                                                ticks
                                                                append-icon="mdi-magnify-plus-outline"
                                                                prepend-icon="mdi-magnify-minus-outline"
                                                            ></v-slider>
                                                        </v-card-actions>
                                                    </v-card>
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="Op4RowTextShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <!-- <vue-editor v-model="selectedOptionText4" :editor-toolbar="customToolbar"></vue-editor> -->
                                                <ckeditor
                                                    :editor="editor"
                                                    v-model="
                                                        selectedOptionText4
                                                    "
                                                    :config="editorConfig"
                                                ></ckeditor>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                            <!-- Option 5 Start -->
                            <v-tab-item v-if="Option5ShowHide">
                                <v-card flat>
                                    <v-card-text>
                                        <v-row dense>
                                            <v-col cols="12" md="4">
                                                <v-btn-toggle
                                                    v-model="toggle_option5"
                                                    mandatory
                                                    color="primary"
                                                    @change="toggle5Change()"
                                                >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Text</span
                                                        ><v-icon right
                                                            >mdi-clipboard-text</v-icon
                                                        ></v-btn
                                                    >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Image</span
                                                        ><v-icon right
                                                            >mdi-image-album</v-icon
                                                        ></v-btn
                                                    >
                                                </v-btn-toggle>
                                            </v-col>
                                            <v-col cols="12" md="8">
                                                <v-alert dense type="info"
                                                    >Select
                                                    <strong
                                                        >Image or Text</strong
                                                    >
                                                    for Option</v-alert
                                                >
                                            </v-col>
                                        </v-row>
                                        <v-row dense v-if="Op5RowImageShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <v-file-input
                                                    v-model="
                                                        selectedOptionImage5
                                                    "
                                                    color="primary"
                                                    outlined
                                                    dense
                                                    show-size
                                                    accept="image/*"
                                                    :rules="imageRule"
                                                    @change="Image5Selected"
                                                >
                                                    <template
                                                        v-slot:selection="{
                                                            index,
                                                            text
                                                        }"
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
                                                        >Option 5 Image
                                                        <span class="red--text"
                                                            ><strong>{{
                                                                $t("label_star")
                                                            }}</strong></span
                                                        ></template
                                                    >
                                                </v-file-input>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <div
                                                    class="
                            d-flex
                            flex-column
                            justify-space-between
                            align-center
                          "
                                                >
                                                    <v-card>
                                                        <v-img
                                                            :src="
                                                                Option5ImagePreview
                                                            "
                                                            :width="Imagewidth"
                                                            contain
                                                            class="grey darken-4"
                                                            :aspect-ratio="1.7"
                                                        ></v-img>
                                                        <v-card-actions>
                                                            <v-slider
                                                                v-model="
                                                                    Imagewidth
                                                                "
                                                                class="align-self-stretch"
                                                                min="400"
                                                                max="700"
                                                                step="10"
                                                                thumb-label
                                                                ticks
                                                                append-icon="mdi-magnify-plus-outline"
                                                                prepend-icon="mdi-magnify-minus-outline"
                                                            ></v-slider>
                                                        </v-card-actions>
                                                    </v-card>
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="Op5RowTextShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <!-- <vue-editor v-model="selectedOptionText5" :editor-toolbar="customToolbar"></vue-editor> -->
                                                <ckeditor
                                                    :editor="editor"
                                                    v-model="
                                                        selectedOptionText5
                                                    "
                                                    :config="editorConfig"
                                                ></ckeditor>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>

                            <!-- Solution -->
                            <v-tab-item>
                                <v-card flat>
                                    <v-card-text>
                                        <v-row dense>
                                            <v-col cols="12" md="4">
                                                <v-btn-toggle
                                                    v-model="toggle_option6"
                                                    mandatory
                                                    color="primary"
                                                    @change="toggle6Change()"
                                                >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Text</span
                                                        ><v-icon right
                                                            >mdi-clipboard-text</v-icon
                                                        ></v-btn
                                                    >
                                                    <v-btn
                                                        ><span
                                                            class="hidden-sm-and-down"
                                                            >Image</span
                                                        ><v-icon right
                                                            >mdi-image-album</v-icon
                                                        ></v-btn
                                                    >
                                                </v-btn-toggle>
                                            </v-col>
                                            <v-col cols="12" md="8">
                                                <v-alert dense type="info"
                                                    >Select
                                                    <strong
                                                        >Image or Text</strong
                                                    >
                                                    for Solution</v-alert
                                                >
                                            </v-col>
                                        </v-row>
                                        <v-row dense v-if="Op6RowImageShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <v-file-input
                                                    v-model="
                                                        selectedOptionImage6
                                                    "
                                                    color="primary"
                                                    outlined
                                                    dense
                                                    show-size
                                                    accept="image/*"
                                                    :rules="imageRule"
                                                    @change="Image6Selected"
                                                >
                                                    <template
                                                        v-slot:selection="{
                                                            index,
                                                            text
                                                        }"
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
                                                        >Solution Image
                                                        <span class="red--text"
                                                            ><strong>{{
                                                                $t("label_star")
                                                            }}</strong></span
                                                        ></template
                                                    >
                                                </v-file-input>
                                            </v-col>
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <div
                                                    class="
                            d-flex
                            flex-column
                            justify-space-between
                            align-center
                          "
                                                >
                                                    <v-card>
                                                        <v-img
                                                            :src="
                                                                Option6ImagePreview
                                                            "
                                                            :width="Imagewidth"
                                                            contain
                                                            class="grey darken-4"
                                                            :aspect-ratio="1.7"
                                                        ></v-img>
                                                        <v-card-actions>
                                                            <v-slider
                                                                v-model="
                                                                    Imagewidth
                                                                "
                                                                class="align-self-stretch"
                                                                min="400"
                                                                max="700"
                                                                step="10"
                                                                thumb-label
                                                                ticks
                                                                append-icon="mdi-magnify-plus-outline"
                                                                prepend-icon="mdi-magnify-minus-outline"
                                                            ></v-slider>
                                                        </v-card-actions>
                                                    </v-card>
                                                </div>
                                            </v-col>
                                        </v-row>
                                        <v-row v-if="Op6RowTextShowHide">
                                            <v-col
                                                cols="12"
                                                md="12"
                                                class="m-0 p-0"
                                            >
                                                <ckeditor
                                                    :editor="editor"
                                                    v-model="solution"
                                                    :config="editorConfig"
                                                    placeholder=""
                                                ></ckeditor>
                                            </v-col>
                                        </v-row>
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                        </v-tabs>
                    </v-expansion-panel-content>
                </v-expansion-panel>
                <!-- ===========End================= -->
            </v-expansion-panels>
        </v-form>

        <v-stepper v-model="stepperInfo" vertical>
            <v-stepper-content step="1">
                <v-btn
                    color="primary"
                    :disabled="
                        !isBasicHoldingFormValid ||
                            isBasicFormDataProcessing ||
                            alertMessage == ''
                    "
                    @click="saveQuestionBank()"
                    >{{
                        isBasicFormDataProcessing == true
                            ? $t("label_processing")
                            : $t("label_save")
                    }}</v-btn
                >
                <v-btn color="green" dark @click="backToQuestionDirectory"
                    >Back to Question Directory</v-btn
                >
            </v-stepper-content>
        </v-stepper>

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

        <!-- //Set Dialog -->
        <v-dialog v-model="dialog" hide-overlay persistent width="300">
            <v-card color="error" dark>
                <v-card-title class="headline"> Please Wait... </v-card-title>

                <v-card-text>
                    Loading Data...
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

import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
    props: ["userPermissionDataProps", "questionBankDataProps"],

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
                    text: this.$t("label_add_question_bank"),
                    disabled: false
                }
            ],
            editor: ClassicEditor,
            editorData: "",
            editorConfig: {
                // The configuration of the editor.
                toolbar: [
                    "heading",
                    "|",
                    "bold",
                    "italic",
                    "Underline",
                    "Subscript",
                    "Superscript",
                    "strikethrough",
                    "code",
                    "bulletedList",
                    "numberedList",
                    "|",
                    "alignment",
                    "outdent",
                    "indent",
                    "|",
                    "fontColor",
                    "blockQuote",
                    "insertTable",
                    "|",
                    "undo",
                    "redo",
                    "|",
                    "MathType",
                    "ChemType",
                    "SpecialCharacters"
                ]
            },

            selectedOption1Color: "primary",
            selectedOption2Color: "",
            selectedOption3Color: "",
            selectedOption4Color: "",
            selectedOption5Color: "",
            selectedOptionSolColor: "cyan",
            toggle_option1: "text",
            Op1RowImageShowHide: "",
            Op1RowTextShowHide: true,
            Option1ImagePreview: "",

            toggle_option2: "text",
            Op2RowImageShowHide: "",
            Op2RowTextShowHide: true,
            Option2ImagePreview: "",

            toggle_option3: "text",
            Op3RowImageShowHide: "",
            Op3RowTextShowHide: true,
            Option3ImagePreview: "",

            toggle_option4: "text",
            Op4RowImageShowHide: "",
            Op4RowTextShowHide: true,
            Option4ImagePreview: "",

            toggle_option5: "text",
            Op5RowImageShowHide: "",
            Op5RowTextShowHide: true,
            Option5ImagePreview: "",

            toggle_option6: "text",
            Op6RowImageShowHide: "",
            Op6RowTextShowHide: true,
            Option6ImagePreview: "",

            SelectMultiple: false,
            Imagewidth: "300",

            selectedQuestionImage: null,
            selectedQuestionText: "",

            selectedOptionImage1: null,
            selectedOptionText1: "",

            selectedOptionImage2: null,
            selectedOptionText2: "",

            selectedOptionImage3: null,
            selectedOptionText3: "",

            selectedOptionImage4: null,
            selectedOptionText4: "",

            selectedOptionImage5: null,
            selectedOptionText5: "",

            selectedOptionImage6: null,
            selectedOptionText6: "",

            Option1ShowHide: false,
            Option2ShowHide: false,
            Option3ShowHide: false,
            Option4ShowHide: false,
            Option5ShowHide: false,

            solution: "",
            questionTag: "",

            panel: "",
            alertType: "",
            alertMessage: "",
            // Snack Bar
            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",
            dialog: false,
            isBasicHoldingFormValid: true,
            isBasicFormDataProcessing: false,

            // Form Data
            authorizationConfig: "",

            stepperInfo: 1,

            lms_question_bank_id:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_id
                    : "",

            selectedCourseId:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_course_id
                    : "",
            courseItems: [],
            isCourseDataLoading: false,

            selectedSubjectId:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_subject_id
                    : "",

            subjectItems: [],
            subjectDataLoading: false,

            selectedTopicId:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_topic_id
                    : "",
            topicItems: [],
            topicDataLoading: false,

            QuestionMarks:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_marks
                    : "",

            noOfQuestion:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps
                          .lms_exam_schedule_no_of_question
                    : "",

            difficultyLevelItems: [],
            difficultyLevel:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps
                          .lms_question_difficulty_level_id
                    : "",

            selectedAnswerItems: [],
            selectedAnswerType:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps
                          .lms_question_bank_type_single_multiple_value
                    : "",

            questionTag:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_tag
                    : "",

            selectedQuestionText:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_text
                    : "",

            selectedOptionText1:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_options_1
                    : "",
            selectedOptionText2:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_options_2
                    : "",

            selectedOptionText3:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_options_3
                    : "",

            selectedOptionText4:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_options_4
                    : "",

            selectedOptionText5:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_options_5
                    : "",

            solution:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_solution
                    : "",

            selectedAnswerItems: [
                {
                    lms_question_bank_type_single_multiple:
                        "Single Choice Answer",
                    lms_question_bank_type_single_multiple_value: "0"
                },
                {
                    lms_question_bank_type_single_multiple:
                        "Multiple Choice Answer",
                    lms_question_bank_type_single_multiple_value: "1"
                }
            ],

            // selectedAnswerType:
            //   this.questionBankDataProps != null
            //     ? this.questionBankDataProps.lms_question_bank_type_single_multiple_value
            //     : "",

            NoOfOptionsItems: [
                // {
                //   lms_question_bank_no_of_option: "2 Options",
                //   lms_question_bank_no_of_option_value: "2",
                // },
                {
                    lms_question_bank_no_of_option: "4 Options",
                    lms_question_bank_no_of_option_value: "4"
                },
                {
                    lms_question_bank_no_of_option: "5 Options",
                    lms_question_bank_no_of_option_value: "5"
                }
            ],
            selectedNoOfOptions:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps.lms_question_bank_no_of_option
                    : "",

            selectedCorrectOptions:
                this.questionBankDataProps != null
                    ? this.questionBankDataProps
                          .lms_question_bank_correct_answers
                    : "",
            CorrectOptionsItems: [
                {
                    lms_question_bank_correct_answers: "Option A | 1",
                    lms_question_bank_correct_answers_value: "A"
                },
                {
                    lms_question_bank_correct_answers: "Option B | 2",
                    lms_question_bank_correct_answers_value: "B"
                },
                {
                    lms_question_bank_correct_answers: "Option C | 3",
                    lms_question_bank_correct_answers_value: "C"
                },
                {
                    lms_question_bank_correct_answers: "Option D | 4",
                    lms_question_bank_correct_answers_value: "D"
                },
                {
                    lms_question_bank_correct_answers: "Option E | 5",
                    lms_question_bank_correct_answers_value: "E"
                }
            ],

            imageRule: [],

            // ExamScheduleProfileImage:
            //   this.questionBankDataProps != null
            //     ? process.env.MIX_EXAM_PROFILE_IMAGE_URL +
            //       this.questionBankDataProps.lms_exam_schedule_image
            //     : "",

            isQuestionBankEdit: this.questionBankDataProps != null ? 1 : 0,

            whatsAppMobileRules: [],

            isUploadDocumentFormValid: true,
            isUploadDocumentFormDataProcessing: false,

            fileRule: []
        };
    },
    watch: {
        selectedQuestionImage(val) {
            this.selectedQuestionImage = val;

            this.imageRule =
                this.selectedQuestionImage != null
                    ? [
                          v =>
                              !v ||
                              v.size <= 1048576 ||
                              this.$t("label_file_size_criteria_1_mb")
                      ]
                    : [];
        }
    },
    created() {
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") }
        };
        // Get Prefix Setting
        this.getPrefixModuleWise();

        // Get Active Course
        this.getAllActiveCourse();

        // Get Active school
        this.getAllDifficultyLevel();
        this.selectedOptionSolColor = "cyan";

        if (this.questionBankDataProps != null) {
            this.getAllActiveSubjectBasedonCourse();
            this.getAllActiveTopicBasedonSubject();
            this.OptionShowHide();
        }
    },

    methods: {
        Image1Selected(payload) {
            const file = payload; // in case vuetify file input
            if (file) {
                this.Option1ImagePreview = URL.createObjectURL(file);
                URL.revokeObjectURL(file); // free memory
            } else {
                this.Option1ImagePreview = null;
            }
        },
        Image2Selected(payload) {
            const file = payload; // in case vuetify file input
            if (file) {
                this.Option2ImagePreview = URL.createObjectURL(file);
                URL.revokeObjectURL(file); // free memory
            } else {
                this.Option2ImagePreview = null;
            }
        },
        Image3Selected(payload) {
            const file = payload; // in case vuetify file input
            if (file) {
                this.Option3ImagePreview = URL.createObjectURL(file);
                URL.revokeObjectURL(file); // free memory
            } else {
                this.Option3ImagePreview = null;
            }
        },
        Image4Selected(payload) {
            const file = payload; // in case vuetify file input
            if (file) {
                this.Option4ImagePreview = URL.createObjectURL(file);
                URL.revokeObjectURL(file); // free memory
            } else {
                this.Option4ImagePreview = null;
            }
        },
        Image5Selected(payload) {
            const file = payload; // in case vuetify file input
            if (file) {
                this.Option5ImagePreview = URL.createObjectURL(file);
                URL.revokeObjectURL(file); // free memory
            } else {
                this.Option5ImagePreview = null;
            }
        },

        Image6Selected(payload) {
            const file = payload; // in case vuetify file input
            if (file) {
                this.Option6ImagePreview = URL.createObjectURL(file);
                URL.revokeObjectURL(file); // free memory
            } else {
                this.Option6ImagePreview = null;
            }
        },

        toggle6Change(files) {
            if (this.toggle_option6 == "0") {
                (this.selectedOptionImage6 = null),
                    (this.Op6RowImageShowHide = false);
                this.Op6RowTextShowHide = true;
                this.Option6ImagePreview = null;
            } else {
                (this.selectedOptionText6 = ""),
                    (this.Op6RowImageShowHide = true);
                this.Op6RowTextShowHide = false;
            }
        },
        toggle5Change(files) {
            if (this.toggle_option5 == "0") {
                (this.selectedOptionImage5 = null),
                    (this.Op5RowImageShowHide = false);
                this.Op5RowTextShowHide = true;
                this.Option5ImagePreview = null;
            } else {
                (this.selectedOptionText5 = ""),
                    (this.Op5RowImageShowHide = true);
                this.Op5RowTextShowHide = false;
            }
        },
        toggle4Change(files) {
            if (this.toggle_option4 == "0") {
                (this.selectedOptionImage4 = null),
                    (this.Op4RowImageShowHide = false);
                this.Op4RowTextShowHide = true;
                this.Option4ImagePreview = null;
            } else {
                (this.selectedOptionText4 = ""),
                    (this.Op4RowImageShowHide = true);
                this.Op4RowTextShowHide = false;
            }
        },
        toggle3Change(files) {
            if (this.toggle_option3 == "0") {
                (this.selectedOptionImage3 = null),
                    (this.Op3RowImageShowHide = false);
                this.Op3RowTextShowHide = true;
                this.Option3ImagePreview = null;
            } else {
                (this.selectedOptionText3 = ""),
                    (this.Op3RowImageShowHide = true);
                this.Op3RowTextShowHide = false;
            }
        },
        toggle2Change(files) {
            if (this.toggle_option2 == "0") {
                (this.selectedOptionImage2 = null),
                    (this.Op2RowImageShowHide = false);
                this.Op2RowTextShowHide = true;
                this.Option2ImagePreview = null;
            } else {
                (this.selectedOptionText2 = ""),
                    (this.Op2RowImageShowHide = true);
                this.Op2RowTextShowHide = false;
            }
        },
        toggle1Change(files) {
            if (this.toggle_option1 == "0") {
                (this.selectedOptionImage1 = null),
                    (this.Op1RowImageShowHide = false);
                this.Op1RowTextShowHide = true;
                this.Option1ImagePreview = null;
            } else {
                (this.selectedOptionText1 = ""),
                    (this.Op1RowImageShowHide = true);
                this.Op1RowTextShowHide = false;
            }
        },

        setAnswerType() {
            if (this.selectedAnswerType == 1) {
                this.SelectMultiple = true;
                this.selectedCorrectOptions = 0;
            } else {
                this.SelectMultiple = false;
                this.selectedCorrectOptions = 0;
            }
        },
        OptionShowHide() {
            if (this.selectedNoOfOptions == "2") {
                this.Option1ShowHide = true;
                this.Option2ShowHide = true;

                this.Option3ShowHide = false;
                this.Option4ShowHide = false;
                this.Option5ShowHide = false;

                this.CorrectOptionsItems = [
                    {
                        lms_question_bank_correct_answers: "Option A | 1",
                        lms_question_bank_correct_answers_value: "A"
                    },
                    {
                        lms_question_bank_correct_answers: "Option B | 2",
                        lms_question_bank_correct_answers_value: "B"
                    }
                ];
            } else if (this.selectedNoOfOptions == "4") {
                this.selectedOption1Color = "primary";
                this.selectedOptionSolColor = "";
                this.Option1ShowHide = true;
                this.Option2ShowHide = true;
                this.Option4ShowHide = true;
                this.Option3ShowHide = true;

                this.Option5ShowHide = false;

                this.CorrectOptionsItems = [
                    {
                        lms_question_bank_correct_answers: "Option A | 1",
                        lms_question_bank_correct_answers_value: "A"
                    },
                    {
                        lms_question_bank_correct_answers: "Option B | 2",
                        lms_question_bank_correct_answers_value: "B"
                    },
                    {
                        lms_question_bank_correct_answers: "Option C | 3",
                        lms_question_bank_correct_answers_value: "C"
                    },
                    {
                        lms_question_bank_correct_answers: "Option D | 4",
                        lms_question_bank_correct_answers_value: "D"
                    }
                ];
            } else if (this.selectedNoOfOptions == "5") {
                this.selectedOption1Color = "primary";
                this.selectedOptionSolColor = "";
                this.Option1ShowHide = true;
                this.Option2ShowHide = true;
                this.Option4ShowHide = true;
                this.Option3ShowHide = true;
                this.Option5ShowHide = true;

                this.CorrectOptionsItems = [
                    {
                        lms_question_bank_correct_answers: "Option A | 1",
                        lms_question_bank_correct_answers_value: "A"
                    },
                    {
                        lms_question_bank_correct_answers: "Option B | 2",
                        lms_question_bank_correct_answers_value: "B"
                    },
                    {
                        lms_question_bank_correct_answers: "Option C | 3",
                        lms_question_bank_correct_answers_value: "C"
                    },
                    {
                        lms_question_bank_correct_answers: "Option D | 4",
                        lms_question_bank_correct_answers_value: "D"
                    },
                    {
                        lms_question_bank_correct_answers: "Option E | 5",
                        lms_question_bank_correct_answers_value: "E"
                    }
                ];
            }
        },

        // backToQuestionDirectory
        backToQuestionDirectory() {
            this.$router.push({ name: "QuestionBank" });
        },

        // Ensure Digit Input in Mobile Number Field
        isDigit(evt) {
            evt = evt ? evt : window.event;
            var charCode = evt.which ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
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
        // Get Prefix Setting
        getPrefixModuleWise() {
            this.$http
                .get(`web_get_prefix_module_wise`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        prefixModuleName: "Enquiry Code"
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
                })
                .then(({ data }) => {
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        // If prefix set
                        if (data[0].lms_is_prefix_assigned == "1") {
                            this.alertType = "success";
                            this.alertMessage = "Enter course wise question";
                        }
                        // If prefix not set
                        else {
                            this.alertType = "error";
                            this.alertMessage = this.$t(
                                "label_prefix_pattern_not_set_for_enquiry"
                            );
                        }
                    }
                })
                .catch(error => {
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
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

        // Get all active Difficulty Level
        getAllDifficultyLevel() {
            this.isScheduleTypeDataLoading = true;
            this.dialog = true;
            this.$http
                .get(`web_get_active_difficulty_level_wp`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId")
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") }
                })
                .then(({ data }) => {
                    this.isScheduleTypeDataLoading = false;
                    this.dialog = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.difficultyLevelItems = data;
                    }
                })
                .catch(error => {
                    this.isScheduleTypeDataLoading = false;
                    this.dialog = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },

        //Save Question
        saveQuestionBank() {
            if (this.$refs.holdingFormBasic.validate()) {
                // Save/Edit Basic Info
                this.authorizationConfig = {
                    headers: {
                        Authorization: "Bearer " + ls.get("token"),
                        "content-type": "multipart/form-data"
                    }
                };
                this.isBasicFormDataProcessing = true;
                this.dialog = true;
                let basicFormData = new FormData();

                //Set default value

                if (this.isQuestionBankEdit == 1) {
                    basicFormData.append(
                        "lms_question_bank_options_1_text",
                        "TextOption1"
                    );
                    basicFormData.append(
                        "lms_question_bank_options_1_has_image",
                        "0"
                    );

                    basicFormData.append(
                        "lms_question_bank_options_2_text",
                        "TextOption2"
                    );
                    basicFormData.append(
                        "lms_question_bank_options_2_has_image",
                        "0"
                    );

                    basicFormData.append(
                        "lms_question_bank_options_3_text",
                        "TextOption3"
                    );
                    basicFormData.append(
                        "lms_question_bank_options_3_has_image",
                        "0"
                    );

                    basicFormData.append(
                        "lms_question_bank_options_4_text",
                        "TextOption4"
                    );
                    basicFormData.append(
                        "lms_question_bank_options_4_has_image",
                        "0"
                    );

                    basicFormData.append(
                        "lms_question_bank_options_5_text",
                        "TextOption5"
                    );
                    basicFormData.append(
                        "lms_question_bank_options_5_has_image",
                        "0"
                    );
                    this.toggle_option1 = "0";
                    this.toggle_option2 = "0";
                    this.toggle_option3 = "0";
                    this.toggle_option4 = "0";
                    this.toggle_option5 = "0";
                    this.toggle_option6 = "0";
                }

                this.selectedNoOfOptions = "4";

                basicFormData.append(
                    "isQuestionBankEdit",
                    this.isQuestionBankEdit
                );

                basicFormData.append("centerId", ls.get("loggedUserCenterId"));

                if (this.lms_question_bank_id != "") {
                    basicFormData.append(
                        "lms_question_bank_id",
                        this.lms_question_bank_id
                    );
                }

                basicFormData.append("loggedUserId", ls.get("loggedUserId"));

                basicFormData.append("lms_subject_id", this.selectedSubjectId);
                if (this.selectedCourseId != "") {
                    basicFormData.append(
                        "lms_course_id",
                        this.selectedCourseId
                    );
                }
                if (this.selectedTopicId != "") {
                    basicFormData.append("lms_topic_id", this.selectedTopicId);
                }
                if (this.difficultyLevel != "") {
                    basicFormData.append(
                        "lms_question_difficulty_level_id",
                        this.difficultyLevel
                    );
                }
                if (this.selectedAnswerType != "") {
                    basicFormData.append(
                        "lms_question_bank_type_single_multiple",
                        this.selectedAnswerType
                    );
                }
                if (this.noOfQuestion != "") {
                    basicFormData.append(
                        "lms_exam_schedule_no_of_question",
                        this.noOfQuestion
                    );
                }

                if (this.selectedCorrectOptions != "") {
                    basicFormData.append(
                        "lms_question_bank_correct_answers",
                        this.selectedCorrectOptions
                    );
                }
                if (this.QuestionMarks != "") {
                    basicFormData.append(
                        "lms_question_bank_marks",
                        this.QuestionMarks
                    );
                }
                if (this.selectedNoOfOptions != "") {
                    basicFormData.append(
                        "lms_question_bank_no_of_option",
                        this.selectedNoOfOptions
                    );
                }
                if (this.selectedQuestionText != "") {
                    basicFormData.append(
                        "lms_question_bank_text",
                        this.selectedQuestionText
                    );
                }

                if (this.selectedQuestionImage != null) {
                    basicFormData.append("lms_question_bank_has_image", "1");
                    basicFormData.append(
                        "lms_question_bank_image_path",
                        this.selectedQuestionImage
                    );
                } else {
                    basicFormData.append("lms_question_bank_has_image", "0");
                }

                if (
                    this.toggle_option1 == "0" &&
                    (this.selectedNoOfOptions == "4" ||
                        this.selectedNoOfOptions == "5")
                ) {
                    basicFormData.append(
                        "lms_question_bank_options_1",
                        this.selectedOptionText1
                    );
                    basicFormData.append(
                        "lms_question_bank_options_1_text",
                        "TextOption1"
                    );
                    basicFormData.append(
                        "lms_question_bank_options_1_has_image",
                        "0"
                    );
                } else {
                    basicFormData.append(
                        "lms_question_bank_options_1",
                        this.selectedOptionImage1
                    );
                    basicFormData.append(
                        "lms_question_bank_options_1_has_image",
                        "1"
                    );
                }

                if (
                    (this.toggle_option2 == "0" &&
                        this.selectedNoOfOptions == "4") ||
                    this.selectedNoOfOptions == "5"
                ) {
                    basicFormData.append(
                        "lms_question_bank_options_2",
                        this.selectedOptionText2
                    );
                    basicFormData.append(
                        "lms_question_bank_options_2_text",
                        "TextOption2"
                    );
                    basicFormData.append(
                        "lms_question_bank_options_2_has_image",
                        "0"
                    );
                } else {
                    basicFormData.append(
                        "lms_question_bank_options_2",
                        this.selectedOptionImage2
                    );
                    basicFormData.append(
                        "lms_question_bank_options_2_has_image",
                        "1"
                    );
                }

                if (
                    (this.toggle_option3 == "0" &&
                        this.selectedNoOfOptions == "4") ||
                    this.selectedNoOfOptions == "5"
                ) {
                    basicFormData.append(
                        "lms_question_bank_options_3",
                        this.selectedOptionText3
                    );
                    basicFormData.append(
                        "lms_question_bank_options_3_text",
                        "TextOption3"
                    );
                    basicFormData.append(
                        "lms_question_bank_options_3_has_image",
                        "0"
                    );
                } else {
                    basicFormData.append(
                        "lms_question_bank_options_3",
                        this.selectedOptionImage3
                    );
                    basicFormData.append(
                        "lms_question_bank_options_3_has_image",
                        "1"
                    );
                }

                if (
                    (this.toggle_option4 == "0" &&
                        this.selectedNoOfOptions == "4") ||
                    this.selectedNoOfOptions == "5"
                ) {
                    basicFormData.append(
                        "lms_question_bank_options_4",
                        this.selectedOptionText4
                    );
                    basicFormData.append(
                        "lms_question_bank_options_4_text",
                        "TextOption4"
                    );
                    basicFormData.append(
                        "lms_question_bank_options_4_has_image",
                        "0"
                    );
                } else {
                    basicFormData.append(
                        "lms_question_bank_options_4",
                        this.selectedOptionImage4
                    );
                    basicFormData.append(
                        "lms_question_bank_options_4_has_image",
                        "1"
                    );
                }

                if (
                    this.toggle_option5 == "0" &&
                    this.selectedNoOfOptions == "5"
                ) {
                    basicFormData.append(
                        "lms_question_bank_options_5",
                        this.selectedOptionText5
                    );
                    basicFormData.append(
                        "lms_question_bank_options_5_text",
                        "TextOption5"
                    );
                    basicFormData.append(
                        "lms_question_bank_options_5_has_image",
                        "0"
                    );
                } else {
                    basicFormData.append(
                        "lms_question_bank_options_5",
                        this.selectedOptionImage5
                    );
                    basicFormData.append(
                        "lms_question_bank_options_5_has_image",
                        "1"
                    );
                }

                if (this.toggle_option6 == "0") {
                    basicFormData.append(
                        "lms_question_bank_solution",
                        this.solution
                    );
                    basicFormData.append(
                        "lms_question_bank_solution_text",
                        "Solution"
                    );
                    basicFormData.append(
                        "lms_question_bank_solution_has_image",
                        "0"
                    );
                } else {
                    basicFormData.append(
                        "lms_question_bank_solution",
                        this.selectedOptionImage6
                    );
                    basicFormData.append(
                        "lms_question_bank_solution_has_image",
                        "1"
                    );
                }

                // if (this.solution != "") {
                //   basicFormData.append("lms_question_bank_solution", this.solution);
                // }

                if (this.questionTag != "") {
                    basicFormData.append(
                        "lms_question_bank_tag",
                        this.questionTag
                    );
                }

                this.$http
                    .post(
                        "web_save_edit_qestion_bank",
                        basicFormData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isBasicFormDataProcessing = false;
                        this.dialog = false;

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
                            // Image uppload failed
                            else if (data.responseData == 1) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_image_upload_failed")
                                );
                            }

                            // Exam Saved
                            else if (data.responseData == 4) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_exam_details_details_saved")
                                );

                                // this.isQuestionBankEdit = 1;
                                // this.lms_question_bank_id = data.lms_exam_schedule_id;
                                // this.$router.push({ name: "QuestionBank" });

                                //Clear Data after question save

                                this.selectedQuestionImage = null;
                                //this.selectedCorrectOptions
                                this.selectedQuestionText = "";

                                this.toggle_option1 = "text";
                                this.selectedOptionImage1 = null;
                                this.selectedOptionText1 = "";

                                this.toggle_option2 = "text";
                                this.selectedOptionImage2 = null;
                                this.selectedOptionText2 = "";

                                this.toggle_option3 = "text";
                                this.selectedOptionImage3 = null;
                                this.selectedOptionText3 = "";

                                this.toggle_option4 = "text";
                                this.selectedOptionImage4 = null;
                                this.selectedOptionText4 = "";

                                this.toggle_option5 = "text";
                                this.selectedOptionImage5 = null;
                                this.selectedOptionText5 = "";

                                this.toggle_option6 = "text";
                                this.selectedOptionImage6 = null;
                                this.solution = "";

                                this.questionTag = "";

                                this.selectedCorrectOptions = null;
                            }
                            // Exam Data save failed
                            else if (data.responseData == 5) {
                                this.snackBarColor = "error";
                                this.dialog = false;
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                            // Edit Success
                            else if (data.responseData == 6) {
                                this.snackBarColor = "success";
                                this.dialog = false;
                                this.changeSnackBarMessage(
                                    this.$t(
                                        "label_exam_details_details_updates"
                                    )
                                );

                                this.$router.push({ name: "QuestionBank" });

                                // this.stepperInfo = 2;
                            } else if (data.responseData == 7) {
                                this.snackBarColor = "error";
                                this.dialog = false;
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isBasicFormDataProcessing = false;
                        this.dialog = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        }
    }
};
</script>
