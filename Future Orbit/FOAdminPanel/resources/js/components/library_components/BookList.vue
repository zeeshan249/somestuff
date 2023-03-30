<template>
    <div id="app">
        <v-container
            fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
        >
            <!-- Card Start -->
            <v-overlay :value="isLoaderActive" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
            <v-sheet class="pa-4 mb-4" color="text-white">
                <v-row
                    justify="space-around"
                    style="
                        margin-right: 1px !important;
                        margin-left: -1px !important;
                    "
                    class="mb-4 mt-1"
                    dense
                >
                    <v-toolbar-title dark color="primary">
                        <v-list-item two-line>
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">
                                    <strong>Book List</strong>
                                </v-list-item-title>
                                <v-list-item-subtitle
                                    >Home <v-icon>mdi-forward</v-icon> Library
                                    <v-icon>mdi-forward</v-icon> Book
                                    List</v-list-item-subtitle
                                >
                            </v-list-item-content>
                        </v-list-item>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn
                        v-permission="'Add Book List'"
                        v-if="!isAddCardVisible"
                        :disabled="tableDataLoading"
                        color="primary"
                        class="white--text"
                        @click="isAddCardVisible = !isAddCardVisible"
                    >
                        Add Book
                        <v-icon right dark> mdi-plus </v-icon>
                    </v-btn>
                </v-row>
            </v-sheet>

            <transition name="fade" mode="out-in">
                <v-card class="mx-auto" elevation="0" v-if="isAddCardVisible">
                    <v-form
                        ref="saveLibraryForm"
                        v-model="issaveLibraryFormValid"
                        lazy-validation
                    >
                        <v-row dense class="mx-auto mt-4">
                            <v-col cols="12" md="4" sm="12" class="px-4">
                                <v-autocomplete
                                    outlined
                                    dense
                                    v-model="lms_course_id"
                                    :items="courseItems"
                                    multiple
                                    :disabled="isSourceDataLoading"
                                    item-text="lms_course_name"
                                    item-value="lms_course_id"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_course") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-autocomplete>
                            </v-col>

                            <v-col
                                cols="12"
                                xs="12"
                                sm="12"
                                md="8"
                                class="px-4"
                            >
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="lms_book_title"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_book_title") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>

                        <v-row dense class="mx-auto">
                            <v-col cols="12" md="4" sm="12" class="px-4">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="lms_book_number"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_book_number") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="4" sm="12" class="px-4">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="lms_book_publisher"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_book_publisher") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="4" sm="12" class="px-4">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="lms_book_author"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_book_author") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>

                        <v-row dense class="mx-auto">
                            <v-col cols="12" md="4" sm="12" class="px-4">
                                <v-text-field
                                    outlined
                                    dense
                                    title-case
                                    v-model="lms_book_subject"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_book_subject") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="4" sm="12" class="px-4">
                                <v-text-field
                                    outlined
                                    dense
                                    v-model="lms_book_isbn_number"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_book_isbn_number") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="4" sm="12" class="px-4">
                                <v-text-field
                                    outlined
                                    dense
                                    @keypress="isDigitWithDecimal"
                                    v-model="lms_book_price"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_book_price") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                        </v-row>

                        <v-row dense class="mx-auto">
                            <v-col cols="12" md="4" sm="12" class="px-4">
                                <v-text-field
                                    outlined
                                    dense
                                    @keypress="isDigit"
                                    v-model="lms_book_return_days"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_book_return_days") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="2" sm="12" class="pl-4 pr-1">
                                <v-text-field
                                    outlined
                                    dense
                                    @keypress="isDigit"
                                    v-model="lms_book_quantity"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_book_quantity") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="2" sm="12" class="pl-1 pr-4">
                                <v-text-field
                                    outlined
                                    dense
                                    @keypress="isDigit"
                                    v-model="lms_book_current_quantity"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                >
                                    <template #label>
                                        {{ $t("label_book_current_quantity") }}
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="4" sm="12" class="px-4">
                            </v-col>
                        </v-row>
                        <v-row dense class="mx-auto">
                            <v-col cols="12" md="1" sm="12" class="pl-4">
                                <v-avatar color="indigo">
                                    <img
                                        v-if="bookCoverImage == null"
                                        :src="altBookCoverImage"
                                    />
                                    <img
                                        v-if="bookCoverImage != null"
                                        :src="bookCoverImage"
                                    />
                                </v-avatar>
                            </v-col>
                            <v-col cols="12" md="7" sm="12" class="pr-4">
                                <v-file-input
                                    v-model="selectedBookCoverImage"
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
                                        >Select Cover Image</template
                                    >
                                </v-file-input>
                            </v-col>
                        </v-row>

                        <v-card-actions>
                            <v-spacer></v-spacer>

                            <v-btn
                                class="ma-2 rounded"
                                tile
                                color="primary"
                                :disabled="
                                    !issaveLibraryFormValid ||
                                    issaveLibraryFormDataProcessing
                                "
                                @click="saveLibrary"
                            >
                                {{
                                    isSaveEditClicked == 1
                                        ? issaveLibraryFormDataProcessing ==
                                          true
                                            ? $t("label_processing")
                                            : $t("label_save_library")
                                        : issaveLibraryFormDataProcessing ==
                                          true
                                        ? $t("label_processing")
                                        : $t("label_update_library")
                                }}
                            </v-btn>
                            <v-btn
                                class="ma-2 rounded"
                                tile
                                color="error"
                                :disabled="
                                    !issaveLibraryFormValid ||
                                    issaveLibraryFormDataProcessing
                                "
                                @click="
                                    isAddCardVisible = !isAddCardVisible;
                                    resetForm();
                                "
                                >{{
                                    issaveLibraryFormDataProcessing == true
                                        ? $t("label_processing")
                                        : $t("label_cancel")
                                }}</v-btn
                            >
                        </v-card-actions>
                    </v-form>
                </v-card>
            </transition>
            <!-- Card End -->

            <transition name="fade" mode="out-in">
                <v-card elevation="2">
                    <v-data-table
                        dense
                        :headers="tableHeader"
                        :items="dataTableRowNumbering"
                        item-key="lms_book_id"
                        class="elevation-1"
                        :loading="tableDataLoading"
                        :loading-text="tableLoadingDataText"
                        :server-items-length="totalItemsInDB"
                        :items-per-page="100"
                        @pagination="getAllBookList"
                        show-expand
                        :expanded.sync="expanded"
                        :single-expand="singleExpand"
                        :footer-props="{
                            itemsPerPageOptions: [100, 200, 300, 500, -1],
                        }"
                    >
                        <template
                            v-slot:item.data-table-expand="{
                                item,
                                isExpanded,
                                expand,
                            }"
                        >
                            <v-icon
                                small
                                @click="expand(false)"
                                v-if="isExpanded"
                                size="22"
                                class="mr-2"
                                color="primary"
                                >mdi-arrow-up-circle-outline</v-icon
                            >

                            <v-icon
                                small
                                @click="
                                    expand(true);
                                    includeReturned = false;
                                    getAllStudentListBookWise(item);
                                "
                                v-if="!isExpanded"
                                size="22"
                                class="mr-2"
                                color="success"
                                >mdi-arrow-down-circle-outline</v-icon
                            >
                        </template>
                        <template v-slot:expanded-item="{ headers, item }">
                            <td :colspan="headers.length" class="pa-4">
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
                                    <template
                                        v-slot:item.actions_issue="{ item }"
                                    >
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

                                    <template v-slot:top>
                                        <v-toolbar flat>
                                            <v-spacer></v-spacer>
                                            <v-spacer></v-spacer>
                                            <v-switch
                                                class="pt-2 mx-1"
                                                v-if="!tableDataLoading"
                                                inset
                                                v-model="includeReturned"
                                                @change="
                                                    getAllStudentListBookWise(
                                                        item
                                                    )
                                                "
                                            ></v-switch>
                                        </v-toolbar>
                                    </template>
                                </v-data-table>
                            </td>
                        </template>

                        <template v-slot:no-data>
                            <p
                                class="font-weight-black bold title"
                                style="color: red"
                            >
                                {{ $t("label_no_data_found") }}
                            </p>
                        </template>
                        <template v-slot:item.lms_book_status="{ item }">
                            <v-chip
                                x-small
                                :color="getStatusColor(item.lms_book_status)"
                                dark
                                >{{ item.lms_book_status }}</v-chip
                            >
                        </template>
                        <template
                            v-slot:item.lms_book_cover_image_path="{ item }"
                        >
                            <img
                                width="50"
                                height="auto"
                                :src="
                                    buildCoverImages(
                                        item.lms_book_cover_image_path
                                    )
                                "
                                :lazy-src="
                                    buildCoverImages(
                                        item.lms_book_cover_image_path
                                    )
                                "
                            />
                        </template>
                        <template v-slot:top>
                            <v-toolbar flat>
                                <v-text-field
                                    class="mt-4"
                                    label="Search"
                                    prepend-inner-icon="mdi-magnify"
                                    @input="searchBatch"
                                ></v-text-field>
                                <v-spacer></v-spacer>
                                <v-spacer></v-spacer>

                                <v-switch
                                    class="pt-4 mx-1"
                                    v-if="!tableDataLoading"
                                    inset
                                    v-model="includeDelete"
                                    @change="getAllBookList"
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
                            </v-toolbar>
                        </template>

                        <template v-slot:item.actions="{ item }">
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon
                                        small
                                        class="mr-2"
                                        v-bind="attrs"
                                        v-on="on"
                                        color="info"
                                        >mdi-information-outline</v-icon
                                    >
                                </template>

                                <div>
                                    <table class="GeneratedTable">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Number</th>
                                                <th>ISBN</th>
                                                <th>Publisher</th>
                                                <th>Author</th>
                                                <th>Subject</th>
                                                <th>Date</th>
                                                <th>Return Days</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    {{ item.lms_book_title }}
                                                </td>
                                                <td>
                                                    {{ item.lms_book_number }}
                                                </td>
                                                <td>
                                                    {{
                                                        item.lms_book_isbn_number
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        item.lms_book_publisher
                                                    }}
                                                </td>
                                                <td>
                                                    {{ item.lms_book_author }}
                                                </td>
                                                <td>
                                                    {{ item.lms_book_subject }}
                                                </td>
                                                <td>
                                                    {{
                                                        item.lms_book_created_date
                                                    }}
                                                </td>
                                                <td>
                                                    {{
                                                        item.lms_book_return_days
                                                    }}
                                                </td>
                                                <td>
                                                    {{ item.lms_book_status }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </v-tooltip>
                            <v-icon
                                small
                                class="mr-2"
                                v-permission="'Edit Book List'"
                                @click="editLibrary(item)"
                                color="primary"
                                >mdi-lead-pencil</v-icon
                            >
                            <v-icon
                                small
                                v-if="item.lms_book_status == 'Active'"
                                v-permission="'Delete Book List'"
                                color="error"
                                @click="disableBook(item)"
                                >mdi-delete</v-icon
                            >
                            <v-icon
                                small
                                v-if="item.lms_book_status == 'Inactive'"
                                v-permission="'Delete Book List'"
                                color="success"
                                @click="disableBook(item)"
                                >mdi-check-circle</v-icon
                            >

                            <v-menu transition="slide-y-transition" bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <v-icon
                                        small
                                        v-permission="'Book List'"
                                        color="success"
                                        v-bind="attrs"
                                        v-on="on"
                                        >mdi-dots-vertical</v-icon
                                    >
                                </template>
                                <v-list>
                                    <!-- <v-list-item @click="disableBook(item)">
                                        <v-list-item-title>
                                            <v-icon small class="mr-2"
                                                >mdi-format-list-bulleted</v-icon
                                            >
                                            Book Issue
                                            Details</v-list-item-title
                                        >
                                    </v-list-item> -->
                                    <v-list-item
                                        @click="IssueBook(item)"
                                        v-permission="'Issue Book'"
                                    >
                                        <v-list-item-title>
                                            <v-icon small class="mr-2"
                                                >mdi-account-plus</v-icon
                                            >
                                            Issue Book
                                        </v-list-item-title>
                                    </v-list-item>
                                    <v-list-item
                                        @click="disableBook(item)"
                                        v-if="item.lms_book_is_physical == '2'"
                                    >
                                        <v-list-item-title>
                                            <v-icon small class="mr-2"
                                                >mdi-cloud-download</v-icon
                                            >
                                            Download Digital Copy
                                        </v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </template>
                    </v-data-table>
                </v-card>
            </transition>
        </v-container>
    </div>
</template>
<script>
import { BookList } from "../../components/library_components/BookList";
export default BookList;
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
table.GeneratedTable {
    width: 100%;
    background-color: #ffffff;
    border-collapse: collapse;
    border-width: 2px;
    border-color: #ffffff;
    border-style: solid;
    color: #000000;
}

table.GeneratedTable td,
table.GeneratedTable th {
    border-width: 2px;
    border-color: #8a8a8a;
    border-style: solid;
    padding: 3px;
}

table.GeneratedTable thead {
    background-color: #ffffff;
}
</style>
