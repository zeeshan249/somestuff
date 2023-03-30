<template>
    <div id="app">
        <v-container
        fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
        >
            <v-overlay :value="isDialogLoaderActive" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
            <v-card>
                <v-toolbar-title dark color="primary">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                <strong> Fee Collection </strong>
                            </v-list-item-title>
                            <v-list-item-subtitle
                                >{{ $t("label_home")
                                }}<v-icon>mdi-forward</v-icon>
                                Accounts
                                <v-icon>mdi-forward</v-icon>
                                Fee Collection
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-toolbar-title>

                <v-spacer></v-spacer>

                <v-card class="mx-2" elevation="0">
                    <v-card class="mx-auto" color="grey lighten-4 ma-4">
                        <v-row class="ml-2">
                            <v-col cols="12" md="2">
                                <v-list-item-avatar
                                    color="grey darken-3"
                                    rounded
                                    size="100"
                                >
                                    <img
                                        :src="
                                            buildCoverImages(buildProfileImage)
                                        "
                                        :lazy-src="
                                            buildCoverImages(buildProfileImage)
                                        "
                                    />
                                </v-list-item-avatar>
                            </v-col>
                            <v-col cols="12" md="10">
                                <v-row dense>
                                    <v-col cols="12" md="12">
                                        <span
                                            class="text-h6 font-weight-black text-uppercase"
                                            >{{ lms_student_full_name }}</span
                                        ></v-col
                                    >
                                </v-row>
                                <v-row dense>
                                    <v-col cols="5">
                                        <strong> Student ID:</strong>
                                        <strong> {{ lms_student_code }}</strong>
                                    </v-col>
                                    <v-col cols="5">
                                        <strong> Stream:</strong>
                                        <strong> {{ lms_course_name }} </strong>
                                    </v-col>
                                </v-row>
                                <v-row dense>
                                    <v-col cols="5">
                                        <strong>Student Id:</strong>
                                        <strong>
                                            {{ lms_registration_code }}</strong
                                        >
                                    </v-col>

                                    <v-col cols="5">
                                        <strong> Course Enrolled:</strong>
                                        <strong>
                                            {{ lms_child_course_name }}
                                        </strong>
                                    </v-col>
                                </v-row>
                            </v-col>
                        </v-row>

                        <v-sheet color="transparent"> </v-sheet>
                    </v-card>
                    <v-form ref="holdingFormBasic" lazy-validation>
                        <v-list-item class="grow">
                            <v-list-item-avatar
                                color="grey darken-3"
                                v-if="false"
                            >
                                <v-img
                                    class="elevation-6"
                                    alt=""
                                    src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
                                ></v-img>
                            </v-list-item-avatar>
                            <v-row align="center" justify="end" class="mt-2">
                                <v-col cols="12" md="4" class="mt-2">
                                    <v-text-field
                                        regular
                                        dense
                                        v-model="lms_child_course_name"
                                        readonly
                                    >
                                        <template #label>
                                            Student Course
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="12" md="4" class="mt-2">
                                    <v-text-field
                                        regular
                                        dense
                                        v-model="lms_child_course_fees"
                                        readonly
                                    >
                                        <template #label>
                                            <span> Course Fees </span>
                                        </template>
                                    </v-text-field>
                                </v-col>

                                <v-col cols="12" md="4">
                                    <v-text-field
                                        regular
                                        dense
                                        v-model="lms_child_course_duration"
                                        @keypress="isDigit"
                                        readonly
                                    >
                                        <template #label
                                            >No of Installment
                                            <span class="red--text">
                                                <strong>{{
                                                    $t("label_star")
                                                }}</strong>
                                            </span>
                                        </template>
                                    </v-text-field>
                                </v-col>
                            </v-row>
                        </v-list-item>

                        <v-row dense class="mx-2">
                            <v-col cols="12" md="3">
                                <v-select
                                    regular
                                    dense
                                    v-model="discountType"
                                    :items="discountTypeItems"
                                    item-text="description"
                                    item-value="lms_discount_id"
                                    :rules="[
                                        (v) => !!v || $t('label_required'),
                                    ]"
                                    @change="changeDiscountType"
                                    readonly
                                >
                                    <template #label>
                                        Selected Discount Type
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-select>
                            </v-col>

                            <v-col cols="12" md="3">
                                <v-text-field
                                    regular
                                    dense
                                    v-model="discountAmount"
                                    readonly
                                >
                                    <template #label>
                                        Discount Amount
                                    </template>
                                </v-text-field>
                            </v-col>

                            <v-col cols="12" md="3">
                                <v-text-field
                                    regular
                                    dense
                                    v-model="actualFees"
                                    readonly
                                >
                                    <template #label>
                                        Actual Fees
                                        <span class="red--text">
                                            <strong>{{
                                                $t("label_star")
                                            }}</strong>
                                        </span>
                                    </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field
                                    regular
                                    dense
                                    v-model="startDate"
                                    readonly
                                >
                                    <template #label> Start Date </template>
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" md="3">
                                <v-text-field
                                    regular
                                    dense
                                    v-model="endDate"
                                    readonly
                                >
                                    <template #label> End Date </template>
                                </v-text-field>
                            </v-col>
                        </v-row>
                    </v-form>
                    <v-divider class="mx-4"></v-divider>
                    <!-- <v-card-actions>
                        <v-list-item class="grow">
                            <v-row align="center" justify="start">
                                <v-btn
                                    color="primary"
                                    :disabled="
                                      
                                        isStudentUpdateFormDataProcessing
                                    "
                                    @click="saveBasicInfo()"
                                    > {{
                            isBasicFormDataProcessing == true
                                ? $t("label_processing")
                                : 'Generate New Fee'
                        }}</v-btn
                                >
                               
                            </v-row>
                        </v-list-item>
                    </v-card-actions> -->
                    <v-toolbar color="primary" dark flat height="auto">
                        <template v-slot:extension>
                            <v-tabs v-model="tab" align-with-title>
                                <v-tabs-slider color="yellow"></v-tabs-slider>

                                <v-tab v-for="item in items" :key="item">
                                    {{ item }}
                                </v-tab>
                            </v-tabs>
                        </template>
                    </v-toolbar>

                    <v-tabs-items v-model="tab">
                        <v-tab-item Fees>
                            <transition name="fade" mode="out-in">
                                <v-data-table
                                    dense
                                    :headers="tableHeader"
                                    :items="dataTableRowNumbering"
                                    item-key="fee_id"
                                    class="elevation-0"
                                    :loading="tableDataLoading"
                                    :loading-text="tableLoadingDataText"
                                    :server-items-length="totalItemsInDB"
                                    :items-per-page="100"
                                    @pagination="
                                        getAllGeneratedMontlyFeeForStudent
                                    "
                                    :footer-props="{
                                        itemsPerPageOptions: [
                                            7, 25, 50, 100, 200, -1,
                                        ],
                                    }"
                                >
                                    <template v-slot:no-data>
                                        <p
                                            class="font-weight-black bold title"
                                            style="color: red"
                                        >
                                            {{ $t("label_no_data_found") }}
                                        </p>
                                    </template>

                                    <template v-slot:top>
                                        <v-toolbar flat class="mt-4">
                                            <v-text-field
                                                class="mx-2"
                                                outlined
                                                dense
                                                v-model="staffSearchCriteria"
                                                :label="lblSearchStaffCriteria"
                                            ></v-text-field>
                                            <v-btn
                                                class="mx-2 mb-6"
                                                dense
                                                rounded
                                                color="primary"
                                                @click="
                                                    isSearchBySource = false;
                                                    getAllGeneratedMontlyFeeForStudent(
                                                        $event
                                                    );
                                                "
                                                :disabled="tableDataLoading"
                                                >{{ $t("label_search") }}</v-btn
                                            >
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
                                                class="mr-2"
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

                                    <template v-slot:item.actions="{ item }">
                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    v-if="item.is_paid == 0"
                                                    color="primary"
                                                    :disabled="
                                                        isStudentUpdateFormDataProcessing
                                                    "
                                                    @click="payfees(item)"
                                                    x-small
                                                >
                                                    {{ "Pay Fee" }}</v-btn
                                                >

                                                <v-btn
                                                    v-if="item.is_paid == 1"
                                                    color="success"
                                                    :disabled="true"
                                                    x-small
                                                >
                                                    {{ "Fee Paid" }}</v-btn
                                                >
                                            </template>
                                        </v-tooltip>
                                    </template>

                                    <template v-slot:item.receipt="{ item }">
                                        <v-tooltip bottom>
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    color="success"
                                                    v-if="item.is_paid == 1"
                                                    x-small
                                                    @click="savePDFRecipt"
                                                >
                                                    {{ "Print" }}</v-btn
                                                >
                                            </template>
                                        </v-tooltip>
                                    </template>
                                </v-data-table>
                            </transition>
                        </v-tab-item>
                        <v-tab-item Voucher>
                            <v-card flat>
                                <transition name="fade" mode="out-in">
                                    <v-data-table
                                        dense
                                        :headers="tableVoucherHeader"
                                        :items="dataTableRowNumbering1"
                                        item-key="issue_voucher_id"
                                        class="elevation-0"
                                        :loading="tableDataLoading"
                                        :loading-text="tableLoadingDataText"
                                        :server-items-length="totalItemsInDB1"
                                        :items-per-page="100"
                                        @pagination="
                                            getAllGeneratedVoucherStudent
                                        "
                                        :footer-props="{
                                            itemsPerPageOptions: [100, 200, -1],
                                        }"
                                    >
                                        <template v-slot:no-data>
                                            <p
                                                class="font-weight-black bold title"
                                                style="color: red"
                                            >
                                                {{ $t("label_no_data_found") }}
                                            </p>
                                        </template>

                                        <template v-slot:top>
                                            <v-toolbar flat class="mt-4">
                                                <v-text-field
                                                    class="mx-2"
                                                    outlined
                                                    dense
                                                    v-model="
                                                        staffSearchCriteria1
                                                    "
                                                    :label="
                                                        lblSearchStaffCriteria
                                                    "
                                                ></v-text-field>
                                                <v-btn
                                                    class="mx-2 mb-6"
                                                    dense
                                                    rounded
                                                    color="primary"
                                                    @click="
                                                        isSearchBySource = false;
                                                        getAllGeneratedVoucherStudent(
                                                            $event
                                                        );
                                                    "
                                                    :disabled="tableDataLoading"
                                                    >{{
                                                        $t("label_search")
                                                    }}</v-btn
                                                >
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    icon
                                                    small
                                                    color="teal"
                                                    v-if="!tableDataLoading"
                                                >
                                                    <download-excel
                                                        :data="excelData1"
                                                        :fields="excelFields1"
                                                        :name="excelFileName1"
                                                    >
                                                        <v-icon dark
                                                            >mdi-file-excel</v-icon
                                                        >
                                                    </download-excel>
                                                </v-btn>

                                                <v-btn
                                                    v-if="!tableDataLoading"
                                                    class="mr-2"
                                                    icon
                                                    small
                                                    color="red"
                                                    @click="savePDF1"
                                                >
                                                    <v-icon dark
                                                        >mdi-file-pdf</v-icon
                                                    >
                                                </v-btn>
                                            </v-toolbar>
                                        </template>

                                        <template
                                            v-slot:item.voucher_issue_status="{
                                                item,
                                            }"
                                        >
                                            <v-chip
                                                x-small
                                                :color="
                                                    getStatusColor(
                                                        item.voucher_issue_status
                                                    )
                                                "
                                                dark
                                                >{{
                                                    item.voucher_issue_status
                                                }}</v-chip
                                            >
                                        </template>
                                    </v-data-table>
                                </transition>
                            </v-card>
                        </v-tab-item>
                    </v-tabs-items>
                </v-card>
            </v-card>

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
            <v-dialog
                transition="dialog-top-transition"
                v-model="addEditDialog"
                max-width="650"
                scrollable
                :fullscreen="$vuetify.breakpoint.smAndDown"
                persistent
            >
                <template v-slot:default="dialog">
                    <v-overlay :value="isDialogLoaderActive" color="primary">
                        <v-progress-circular
                            indeterminate
                            size="50"
                            color="primary"
                        ></v-progress-circular>
                    </v-overlay>
                    <v-card>
                        <v-toolbar
                            color="primary"
                            dark
                            :max-height="
                                $vuetify.breakpoint.smAndDown ? 56 : '20vh'
                            "
                        >
                            <v-toolbar-title class="popup-header">{{
                                addEditText
                            }}</v-toolbar-title>
                            <v-spacer></v-spacer><v-spacer></v-spacer>
                            <v-btn icon dark @click="addEditDialog = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text class="py-4 px-2">
                            <v-form
                                ref="holdingFormBasic"
                                v-model="isFormAddEditValid"
                                lazy-validation
                            >
                                <v-row class="mx-auto d-flex" dense>
                                    <v-col cols="12" md="12" class="pt-5">
                                        <strong>
                                            <span
                                                class="text-h6 font-weight-black text-uppercase"
                                            >
                                                Name:
                                            </span>
                                        </strong>

                                        <strong>
                                            <span
                                                class="text-h6 font-weight-black text-uppercase"
                                            >
                                                {{
                                                    lms_student_full_name
                                                }}</span
                                            >
                                        </strong>
                                    </v-col>

                                    <v-col cols="6" md="6" class="pt-5">
                                        <strong> Student Code: </strong>
                                        <strong>
                                            <span class="">
                                                {{ lms_student_code }}</span
                                            >
                                        </strong>
                                    </v-col>

                                    <v-col cols="6" md="6" class="pt-5">
                                        <strong> Registration No: </strong>
                                        <strong>
                                            {{ lms_registration_code }}</strong
                                        >
                                    </v-col>

                                    <v-col cols="6" md="6" class="pt-5">
                                        <strong> Fee Amount: </strong>
                                        <strong>
                                            ₹
                                            {{ item.lms_final_monthly_amount }}
                                        </strong>
                                    </v-col>

                                    <v-col cols="6" md="6" class="pt-5">
                                        <strong> Month Of: </strong>
                                        <strong>
                                            {{ item.lms_fees_date }}
                                        </strong>
                                    </v-col>

                                    <v-col cols="12" md="12" class="pt-5">
                                        <v-autocomplete
                                            v-model="item.voucher_id"
                                            :items="voucherItems1"
                                            label="Select Voucher"
                                            item-text="issue_voucher_number"
                                            item-value="issue_voucher_id"
                                            dense
                                     
                                            @change="changeVoucherType(item)"
                                        >
                                            <template #label>
                                                Select Voucher
                                            </template></v-autocomplete
                                        >
                                    </v-col>

                                    <v-row>
                                        <v-col cols="12" md="4" class="pt-5">
                                            <v-text-field
                                                v-model="lms_child_course_fees"
                                                dense
                                                :rules="[
                                                    (v) =>
                                                        !!v ||
                                                        $t('label_required'),
                                                ]"
                                                readonly
                                            >
                                                <template #label>
                                                    Course Fees
                                                </template>
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="1" class="pt-5">
                                            <span><strong>-</strong></span>
                                        </v-col>
                                        <v-col cols="12" md="3" class="pt-5">
                                            <v-text-field
                                                v-model="totalDiscount"
                                                dense
                                                :rules="[
                                                    (v) =>
                                                        !!v ||
                                                        $t('label_required'),
                                                ]"
                                                readonly
                                            >
                                                <template #label>
                                                  Discount
                                                </template>
                                            </v-text-field>
                                        </v-col>
                                        <v-col cols="12" md="1" class="pt-5">
                                            <span><strong>=</strong></span>
                                        </v-col>

                                        <v-col cols="12" md="3" class="pt-5">
                                            <v-text-field
                                                v-model="lms_actual_fee_before_calcution"
                                                dense
                                                :rules="[
                                                    (v) =>
                                                        !!v ||
                                                        $t('label_required'),
                                                ]"
                                                readonly
                                            >
                                                <template #label>
                                                  Actual Fees
                                                </template>
                                            </v-text-field>
                                        </v-col>

                                        <v-col cols="12" md="3" class="pt-5">
                                            <v-text-field
                                                v-model="totalAmount"
                                                dense
                                                :rules="[
                                                    (v) =>
                                                        !!v ||
                                                        $t('label_required'),
                                                ]"
                                                readonly
                                            >
                                                <template #label>
                                                  Final Monthly  Fees Payable
                                                </template>
                                            </v-text-field>
                                        </v-col>
                                    </v-row>

                                    <v-col cols="10" md="10" class="pt-5">
                                        <v-text-field
                                            v-model="ManualReceiptNo"
                                            dense
                                    
                                        >
                                            <template #label>
                                                Manual Receipt No
                                        
                                            </template>
                                        </v-text-field>
                                    </v-col>

                                    <v-col cols="10" md="10" class="pt-5">
                                        <v-select
                                            v-model="cashorupi"
                                            :items="cashorUpiItems"
                                            label="Select Payment Mode"
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                            ]"
                                            dense
                                        >
                                            <template #label>
                                                Payment Mode
                                                <span class="red--text">
                                                    <strong>*</strong>
                                                </span>
                                            </template></v-select
                                        >
                                    </v-col>

                                    <v-col
                                        cols="10"
                                        md="10"
                                        class="pt-5"
                                        v-if="cashorupi == 'UPI'"
                                    >
                                        <v-text-field
                                            v-model="referenceNo"
                                            dense
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                            ]"
                                        >
                                            <template #label>
                                                Reference Number
                                                <span class="red--text">
                                                    <strong>*</strong>
                                                </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions class="justify-end pt-4 pb-6">
                            <v-btn
                                class="mx-2 secondary-button"
                                @click="close()"
                                >Close</v-btn
                            >
                            <v-btn
                                class="mx-2 primary-button"
                                @click="saveBasicInfo(item)"
                                :disabled="!isFormAddEditValid"
                            >
                                Pay
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-dialog>
        </v-container>
    </div>
</template>
<style scoped>
/* header  {
height:90px !important;
}
.v-toolbar__content{
    height:10px !important;
} */
</style>
<script>
// Secure Local Storage
import SecureLS from "secure-ls";
import { Global } from "../../components/helpers/global";
import jsPDF from "jspdf";
import "jspdf-autotable";
const ls = new SecureLS({ encodingType: "aes" });
export default {
    props: ["userPermissionDataProps", "enquiryDataProps"],
    data() {
        console.log("Mobile",this.enquiryDataProps);
        return {
            items: ["Fees", "Voucher"],
            cashorUpiItems: ["Cash", "UPI"],
            lms_actual_fee_before_calcution:this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_actual_fee
                    : "",
            cashorupi: "",
            ManualReceiptNo: "",
            isSearchBySource: false,
            lblSearchStaffCriteria: "Search",
            staffSearchCriteria: "",
            staffSearchCriteria1: "",
            lms_student_whatsapp_number: this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_student_whatsapp_number
                    : "",
            lms_student_id:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_student_id
                    : "",
            lms_student_full_name:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_student_full_name
                    : "",
            lms_student_code:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_student_code
                    : "",
            lms_registration_code:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_registration_code
                    : "",
            lms_child_course_id:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_child_course_id
                    : "",
            lms_course_id:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_course_id
                    : "",
            lms_course_name:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_course_name
                    : "",
            lms_child_course_name:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_child_course_name
                    : "",
            lms_child_course_fees:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_child_course_fees
                    : "",
            lms_child_course_duration:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_child_course_duration
                    : "",
            discountAmount:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.amount
                    : "",
            actualFees:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_actual_fee
                    : "",
            startDate:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_actual_fee_start_date
                    : "",
            endDate:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_actual_fee_end_date
                    : "",
            discountType:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_discount_id
                    : "",

            discountTypeItems: [],
            voucherItems: [],
            buildProfileImage:
                this.enquiryDataProps.lms_student_profile_image != null
                    ? this.enquiryDataProps.lms_student_profile_image
                    : "",

            isStudentUpdateFormDataProcessing: false,
            profileImagesUrl: "",
            altprofileImagesUrl: "",
            modalStart: false,
            alertType: "",
            alertMessage: "",
            tab: null,
            // Snack Bar
            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",
            alertMessage: "",
            totalAmount: "",
            voucherAmount: "",
            // Form Data
            authorizationConfig: "",

            stepperInfo: 1,

            isSourceDataLoading: false,

            isSchoolDataLoading: false,
            isBasicHoldingFormValid: true,
            isBasicFormDataProcessing: false,
            isDialogLoaderActive: false,
            modalFromDate: false,
            modalToDate: false,
            //table data loading start
            tableDataLoading: false,
            totalItemsInDB: 0,
            totalItemsInDB1: 0,
            tableLoadingDataText: this.$t("label_loading_data"),
            addEditText: "Add",
            addEditDialog: false,
            addUpdateButtonText: "Pay",
            isFormAddEditValid: false,
            //table header for student fees paid section
            tableHeader: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: "Registration Code",
                    value: "lms_student_reg_id",
                    width: "20%",
                    sortable: false,
                },
                {
                    text: "Fees Due",
                    value: "lms_final_monthly_amount",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Month",
                    value: "lms_fees_date",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Due Date",
                    value: "due_date",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Fee Description",
                    value: "lms_fee_description",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: this.$t("label_actions"),
                    value: "actions",
                    sortable: false,
                    width: "15%",
                    align: "middle",
                },

                {
                    text: "Receipt",
                    value: "receipt",
                    sortable: false,
                    width: "15%",
                    align: "middle",
                },
            ],
            //table header for voucher for student section
            tableVoucherHeader: [
                { text: "#", value: "index", width: "5%", sortable: false },
                {
                    text: "Voucher Number",
                    value: "issue_voucher_number",
                    width: "20%",
                    sortable: false,
                },
                {
                    text: "Student Id",
                    value: "registration_id",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Voucher Description",
                    value: "voucher_description",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Voucher Amount",
                    value: "voucher_amount",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Valid From",
                    value: "valid_from",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Valid To",
                    value: "valid_to",
                    width: "15%",
                    sortable: false,
                },
                {
                    text: "Status",
                    value: "voucher_issue_status",
                    width: "10%",
                    sortable: false,
                },
            ],
            tableItems: [],
            voucherItems1: ["--Select Voucher--"],
            isDataProcessing: false,

            //tabledata end
            // For Excel Download
            excelFields: {
                RegistrationCode: "lms_student_reg_id",
                FeesDue: "lms_final_monthly_amount",
                Month: "lms_fees_date",
                FeeDescription: "lms_fee_description",
            },
            excelData: [],
            excelFileName:
                "Fees" + "_" + moment().format("DD/MM/YYYY") + ".xls",

            excelFields1: {
                VoucherNumber: "issue_voucher_number",
                StudentId: "registration_id",
                VoucherDescription: "voucher_description",
                VoucherAmount: "voucher_amount",
                ValidFrom: "valid_from",
                ValidTo: "valid_to",
                Status: "voucher_issue_status",
            },
            excelData1: [],
            excelFileName1:
                "Voucher" + "_" + moment().format("DD/MM/YYYY") + ".xls",
        };
    },

    created() {
        if (this.enquiryDataProps == null) {
          this.$router.push({
              name: "GeneratedFees",
          });
      }
        this.profileImagesUrl = process.env.MIX_PROFILE_URL;
        this.altprofileImagesUrl = this.profileImagesUrl + "NotAvailable.jpg";

        console.log(this.enquiryDataProps);
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") },
        };
        this.getPrefixModuleWise();
        this.getAllActiveDiscount();
        this.getAllGeneratedMontlyFeeForStudent();
        this.getAllGeneratedVoucherForStudent();
        this.getAllGeneratedVoucherStudent();
        this.getAllActiveVoucher();
    },
    watch: {
        addEditDialog(value) {
            return value ? true : this.close();
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

        dataTableRowNumbering1() {
            return this.voucherItems.map((items, index) => ({
                ...items,
                index: index + 1,
            }));
        },

        //End
    },
    methods: {
        //send Whatsapp Message

        // Send Whatsapp Message
    getSendWhatsappMessage(details) {
      var WAMessage = `
✨Payment Receipt - Month of: ${details.date}✨%0A%0A
Dear ${details.name},%0A%0A
Received Payment of ₹. ${details.amount}%0AFor the month of : ${details.date}
%0A%0A
Thank you%0A
Regards,%0A
Future Orbit - Admission Cell`;
      this.isSourceDataLoading = true;
      this.$http
        .get(`web_send_whatsapp/${details.mobile}/` + WAMessage, {
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
            this.sourceData = data;
          }
        })
        .catch((error) => {
          this.isSourceDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
        //tab 1
        getAllGeneratedMontlyFeeForStudent(e) {
            this.tableDataLoading = true;

            this.$http
                .get(
                    `web_discount_get_all_student_monthly_fees?page=${e.page}`,
                    {
                        params: {
                            studentId: this.lms_student_id,
                            filterBy: this.staffSearchCriteria,
                            perPage:
                                e.itemsPerPage == -1
                                    ? this.totalItemsInDB
                                    : e.itemsPerPage,
                        },
                        headers: { Authorization: "Bearer " + ls.get("token") },
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
                    }
                })
                .catch((error) => {
                    this.isSchoolDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        //tab 2
        getAllGeneratedVoucherStudent(e) {
            this.tableDataLoading = true;

            this.$http
                .get(`web_voucher_details_student_wise?page=${e.page}`, {
                    params: {
                        studentId: this.lms_student_id,
                        filterBy: this.staffSearchCriteria1,
                        perPage:
                            e.itemsPerPage == -1
                                ? this.totalItemsInDB
                                : e.itemsPerPage,
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
                        this.voucherItems = data.data;
                        this.totalItemsInDB1 = data.total;
                        this.excelData1 = data.data;
                    }
                })
                .catch((error) => {
                    this.isSchoolDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        getAllGeneratedVoucherForStudent() {
            this.tableDataLoading = true;

            this.$http
                .get(`web_voucher_details_get`, {
                    params: {
                        studentId: this.lms_student_id,
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
                        console.log("Voucher Details", data);
                    }
                })
                .catch((error) => {
                    this.isSchoolDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        getAllActiveDiscount() {
            this.isSchoolDataLoading = true;
            this.$http
                .get(`web_discount_fetch_without_pagination`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
                })
                .then(({ data }) => {
                    this.isSchoolDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.discountTypeItems = data;
                    }
                })
                .catch((error) => {
                    this.isSchoolDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        changeDiscountType() {
            this.isSchoolDataLoading = true;
            this.$http
                .get(`web_discount_fetch_without_pagination`, {
                    params: {
                        discountId: this.discountType,
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
                })
                .then(({ data }) => {
                    this.isSchoolDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.discountAmount = data[0].amount;
                        this.actualFees = Math.round(
                            (this.lms_child_course_fees - this.discountAmount) /
                                this.lms_child_course_duration
                        );
                    }
                })
                .catch((error) => {
                    this.isSchoolDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        buildCoverImages(images) {
            return images != ""
                ? this.profileImagesUrl + images
                : this.altprofileImagesUrl;
        },

        getStatusColor(voucher_issue_status) {
            if (voucher_issue_status == "Issued") return "success";
            if (voucher_issue_status == "Expired") return "danger";
            if (voucher_issue_status == "Redeemed") return "secondary";
            else return "error";
        },

        savePDF() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    {
                        header: "RegistrationCode",
                        dataKey: "lms_student_reg_id",
                    },
                    { header: "FeesDue", dataKey: "lms_final_monthly_amount" },
                    { header: "Month", dataKey: "lms_fees_date" },
                    {
                        header: "FeeDescription",
                        dataKey: "lms_fee_description",
                    },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save("Fees" + "_" + moment().format("DD/MM/YYYY") + ".pdf");
        },

        savePDFRecipt() {
            console.log(this.tableItems);
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    {
                        header: "RegistrationCode",
                        dataKey: "lms_student_reg_id",
                    },
                    { header: "FeesDue", dataKey: "lms_final_monthly_amount" },
                    { header: "Month", dataKey: "lms_fees_date" },
                ],
                body: this.tableItems,
                //styles: { fillColor: [255, 0, 0] },
                // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
                margin: { top: 10 },
            });
            pdfDoc.save("Fees" + "_" + moment().format("DD/MM/YYYY") + ".pdf");
        },

        savePDF1() {
            const pdfDoc = new jsPDF();
            pdfDoc.autoTable({
                columns: [
                    {
                        header: "VoucherNumber",
                        dataKey: "issue_voucher_number",
                    },
                    { header: "StudentId", dataKey: "registration_id" },
                    {
                        header: "VoucherDescription",
                        dataKey: "voucher_description",
                    },
                    { header: "VoucherAmount", dataKey: "voucher_amount" },
                    { header: "ValidFrom", dataKey: "valid_from" },
                    { header: "ValidTo", dataKey: "valid_to" },
                    { header: "Status", dataKey: "voucher_issue_status" },
                ],
                body: this.voucherItems,
                margin: { top: 10 },
            });
            pdfDoc.save(
                "Voucher" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
            );
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

        // To ensure name is character with space only
        isCharactersWithSpace(evt) {
            var regex = new RegExp("^[a-zA-Z ]+$");
            var key = String.fromCharCode(
                !evt.charCode ? evt.which : evt.charCode
            );
            if (!regex.test(key)) {
                evt.preventDefault();
                return false;
            }
        },
        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },
        // Get Prefix Setting
        getPrefixModuleWise() {
            this.isBasicFormDataProcessing = true;
            this.$http
                .get(`web_get_prefix_module_wiseq`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        prefixModuleName: "Enquiry Code",
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
                })
                .then(({ data }) => {
                    this.isBasicFormDataProcessing = false;
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        // If prefix set
                        if (data[0].lms_is_prefix_assigned == "1") {
                            this.alertType = "success";
                            this.alertMessage =
                                "Here you can enter Fee Information";
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
                .catch((error) => {
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        //all vouchers

        getAllActiveVoucher(item) {
            this.isSchoolDataLoading = true;
            this.$http
                .get(`web_voucher_details_get`, {
                    params: {
                        studentId: item.lms_student_id,
                        voucherStatus: 1,
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
                })
                .then(({ data }) => {
                    this.isSchoolDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.voucherItems1 = data.data;
                    }
                })
                .catch((error) => {
                    this.isSchoolDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        //change voucher type

        changeVoucherType(item) {
            this.isDialogLoaderActive = true;
            this.$http
                .get(`web_voucher_get_details_with_student`, {
                    params: {
                        studentId: item.lms_student_id,
                        voucherId: item.voucher_id,
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
                })
                .then(({ data }) => {
                    console.log("Voucher Data", data);
                    this.isDialogLoaderActive = false;
                    console.log("dsasdasdasd", data);
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.totalAmount =
                            item.lms_final_monthly_amount -
                            data[0].voucher_amount;
                        this.voucherAmount = data[0].voucher_amount;
                    }
                })
                .catch((error) => {
                    this.isSchoolDataLoading = false;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
        //Save basic info
        saveBasicInfo(item) {

            let details = {
        name: this.lms_student_full_name,
        sid: this.lms_student_code,
        rid: this.lms_registration_code,
        amount: item.lms_final_monthly_amount,
        date: item.lms_fees_date,
        mobile: "91" + this.lms_student_whatsapp_number,
      };

    //   this.getSendWhatsappMessage(details);
            console.log(item);
            if (this.$refs.holdingFormBasic.validate()) {
                // Save/Edit Basic Info
                this.authorizationConfig = {
                    headers: {
                        Authorization: "Bearer " + ls.get("token"),
                        "content-type": "multipart/form-data",
                    },
                };
                this.isBasicFormDataProcessing = true;
                let basicFormData = new FormData();
                basicFormData.append("studentId", this.lms_student_id);

                basicFormData.append(
                    "lms_student_full_name",
                    this.lms_student_full_name
                );

                basicFormData.append(
                    "courseRegistrationCode",
                    this.lms_registration_code
                );
                basicFormData.append("studentcode", this.lms_student_code);

                basicFormData.append("feesPaidForTheMonth", item.lms_fees_date);

                basicFormData.append("feesPayable", this.totalAmount);

                basicFormData.append("ManualReceiptNo", this.ManualReceiptNo);

                basicFormData.append("paymentMode", this.cashorupi);
                if (this.cashorupi == "UPI") {
                    basicFormData.append("referenceNo", this.referenceNo);
                }
                if (item.voucher_id != null) {
                    basicFormData.append("voucherId", item.voucher_id);
                }
                if (item.voucherNumber != null) {
                    basicFormData.append(
                        "voucherNumber",
                        item.issue_voucher_number
                    );
                }
                basicFormData.append("feeId", item.fee_id);
                basicFormData.append("voucherAmount", this.voucherAmount);
                this.isDialogLoaderActive = true;
                this.$http
                    .post(
                        "web_fee_paid",
                        basicFormData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isDialogLoaderActive = false;
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
                            // Profile Image uppload failed
                            else if (data.responseData == 1) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_image_upload_failed")
                                );
                            }
                            // Email exists
                            else if (data.responseData == 2) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    "Fee Already Generated for This Student Course"
                                );
                            }

                            // Enquiry Saved
                            else if (data.responseData == 4) {
                                // this.isEnquiryBasicEdit = 1;
                                // this.lms_discount_id = data.lms_discount_id;

                                // setTimeout(() => {
                                //     this.$router.push({
                                //         name: "Discounts",
                                //     });
                                // }, 2000);

                                Global.showSuccessAlert(
                                    true,
                                    "success",
                                    `Fee Details Saved Successfully For Registration Id:${this.lms_registration_code}`
                                );

                                this.close();

                               
                                // this.getAllGeneratedMontlyFeeForStudent();
                                // this.getAllGeneratedVoucherForStudent();

                                this.$router.push({
                                    name: "GeneratedFees",
                                });
                                this.getSendWhatsappMessage(details);
                            }
                            // Enquiry save failed
                            else if (data.responseData == 5) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                            // Edit Success
                            else if (data.responseData == 6) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    "Discount Details Updated"
                                );

                                setTimeout(() => {
                                    this.$router.push({
                                        name: "Discounts",
                                    });
                                }, 2000);
                                // this.stepperInfo = 2;
                            } else if (data.responseData == 7) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch((error) => {
                        this.isBasicFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },

        payfees(item) {
            this.item = Object.assign({}, item);
            this.addEditText = `Fee Receipt`;
            this.addEditDialog = true;
            this.addUpdateButtonText = "Update";
            console.log("Pay Fees Items", this.item);
            this.totalAmount = item.lms_final_monthly_amount;
            this.totalDiscount =  item.lms_total_fee_discount;
            this.getAllActiveVoucher(item);
        },

        close() {
            this.addEditDialog = false;
            setTimeout(() => {
                this.item = Object.assign({}, this.defaultItem);
            }, 300);
        },
    },
};
</script>
