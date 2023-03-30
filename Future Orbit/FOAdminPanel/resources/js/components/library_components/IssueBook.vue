<template>
    <div style=" margin:auto; padding:auto; width:1200px;" id="app">
        <v-container
            style="background-color: #fff"
            class="ma-4 pa-0"
            width="100%"
        >
            <!-- Card Start -->
            <v-overlay :value="isLoaderActive" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
            <v-row class="ml-4 mr-4 pt-4">
                <v-toolbar-title dark color="primary">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                <strong>Issue Book</strong>
                            </v-list-item-title>
                            <v-list-item-subtitle
                                >Home <v-icon>mdi-forward</v-icon> Library
                                <v-icon>mdi-forward</v-icon> Book List
                                <v-icon>mdi-forward</v-icon> Issue
                                Book</v-list-item-subtitle
                            >
                        </v-list-item-content>
                    </v-list-item>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn
                    :disabled="tableDataLoading"
                    color="primary"
                    class="white--text"
                    @click="backToPrevPage"
                >
                    <v-icon left dark> mdi-arrow-left-bold </v-icon>
                    Back to Book List
                </v-btn>
            </v-row>

            <v-card class="mx-auto" max-width="auto" outlined>
                <v-list-item three-line>
                    <v-list-item-content>
                        <div class="text-h6 text-uppercase mb-4">
                            Title : {{ lms_book_title }}
                        </div>
                        <v-list-item-title class="text--primary mb-1">
                            Publisher: {{ lms_book_publisher }}
                        </v-list-item-title>
                        <v-list-item-subtitle class="text--primary mb-1"
                            >Author: {{ lms_book_author }} | Subject:
                            {{ lms_book_subject }}
                        </v-list-item-subtitle>
                    </v-list-item-content>

                    <v-list-item-avatar tile size="100" color="grey">
                        <img :src="lms_book_cover_image_path" />
                    </v-list-item-avatar>
                </v-list-item>

                <v-card-actions>
                    <v-btn color="orange lighten-2" text @click="show = !show">
                        View Issued Details
                    </v-btn>

                    <v-spacer></v-spacer>

                    <v-btn icon @click="show = !show">
                        <v-icon>{{
                            show ? "mdi-chevron-up" : "mdi-chevron-down"
                        }}</v-icon>
                    </v-btn>
                </v-card-actions>

                <v-expand-transition>
                    <div v-show="show">
                        <v-divider></v-divider>

                        <v-data-table
                            dense
                            :headers="tableHeaderStudent"
                            :items="dataTableRowNumberingStudent"
                            class="elevation-0"
                            :loading-text="tableLoadingDataText"
                            hide-default-footer
                        >
                            <template v-slot:no-data>
                                <p
                                    class="font-weight-black bold title"
                                    style="color: red"
                                >
                                    No Student Found
                                </p>
                            </template>
                            <template v-slot:item.actions_issue="{ item }">
                                <v-icon
                                    small
                                    class="mr-2"
                                    v-if="
                                        item.lms_student_book_is_rteurned ==
                                            'Active'
                                    "
                                    v-permission="'Issue Book'"
                                    @click="returnBook(item)"
                                    color="primary"
                                    >mdi-reply-all</v-icon
                                >
                            </template>
                        </v-data-table>
                    </div>
                </v-expand-transition>
            </v-card>

            <transition name="fade" mode="out-in">
                <v-data-table
                    dense
                    :headers="tableHeader"
                    :items="dataTableRowNumbering"
                    class="elevation-1"
                    :loading="tableDataLoading"
                    :loading-text="tableLoadingDataText"
                    :server-items-length="totalItemsInDB"
                    :items-per-page="100"
                    @pagination="getAllStudents"
                    :footer-props="{
                        itemsPerPageOptions: [100, 200, 300, -1]
                    }"
                >
                    <template v-slot:no-data>
                        <p
                            class="font-weight-black bold title"
                            style="color:red"
                        >
                            {{ $t("label_no_data_found") }}
                        </p>
                    </template>
                    <template
                        v-slot:item.lms_student_registration_type="{
                            item
                        }"
                    >
                        <v-chip
                            x-small
                            :color="
                                getStatusColor(
                                    item.lms_student_registration_type
                                )
                            "
                            dark
                            >{{ item.lms_student_registration_type }}</v-chip
                        >
                    </template>

                    <template v-slot:top>
                        <v-toolbar flat>
                            <v-text-field
                                prepend-inner-icon="mdi-magnify"
                                class="mt-4 mx-4"
                                :disabled="isSourceDataLoading"
                                v-model="studentSearchCriteria"
                                :label="lblSearchStudentCriteria"
                                @input="
                                    isSearchBySource = false;
                                    getAllStudents($event);
                                "
                            ></v-text-field>
                            <v-spacer></v-spacer>
                            <v-spacer></v-spacer>
                        </v-toolbar>
                    </template>

                    <template v-slot:item.actions="{ item }">
                        <v-chip
                            v-if="item.lms_student_book_is_rteurned == null"
                            @click="IssueStudentBook(item)"
                            color="primary"
                            small
                        >
                            <v-icon
                                small
                                class="mr-2"
                                v-permission="'Issue Book'"
                                color="white"
                                >mdi-plus-circle-outline</v-icon
                            >
                            Issue Book
                        </v-chip>
                    </template>
                </v-data-table>
            </transition>
        </v-container>
    </div>
</template>
<script>
import { IssueBook } from "../../components/library_components/IssueBook";
export default IssueBook;
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

.fluid-background {
    background-color: blue;
}

.work-experiences > div {
    margin: 2px 0;
    padding-bottom: 2px;
}
.work-experiences > div:not(:last-child) {
    border-bottom: 0px solid rgb(206, 212, 218);
}
</style>
