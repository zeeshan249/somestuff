<template>
    <div style="margin: auto; padding: auto; width: 1200px" id="app">
        <v-container
            style="background-color: #fff"
            class="ma-4 pa-0"
            width="100%"
        >
            <v-row class="ml-4 mr-4 pt-4">
                <v-toolbar-title dark color="primary">
                    <v-list-item two-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h5">
                                <strong>{{label_add_discount}}</strong>
                            </v-list-item-title>
                            <v-list-item-subtitle
                                >{{ $t("label_home")
                                }}<v-icon>mdi-forward</v-icon>
                                {{ $t("label_enquiry") }}
                                <v-icon>mdi-forward</v-icon>
                                {{label_add_discount}}</v-list-item-subtitle
                            >
                        </v-list-item-content>
                    </v-list-item>
                </v-toolbar-title>
                <v-spacer></v-spacer>
            </v-row>
            <v-overlay :value="alertMessage == ''" color="primary">
                <v-progress-circular
                    indeterminate
                    size="64"
                    color="primary"
                ></v-progress-circular>
            </v-overlay>
            <v-alert
                class="mx-4"
                dense
                v-if="alertMessage != ''"
                text
                :type="alertType"
                elevation="2"
                dismissible
                transition="fade-transition"
                >{{ alertMessage }}</v-alert
            >

            <v-stepper v-model="stepperInfo" vertical>
                <v-stepper-step :complete="stepperInfo > 1" step="1">{{
                    $t("label_basic_info")
                }}</v-stepper-step>

                <v-stepper-content step="1">
                    <v-card color="grey lighten-1" class="mb-12">
                        <v-form
                            ref="holdingFormBasic"
                            v-model="isBasicHoldingFormValid"
                            lazy-validation
                        >
                            <v-card
                                class="mx-auto mt-2"
                                max-width="100%"
                                outlined
                            >
                                <v-app-bar dark color="primary">
                                    <v-toolbar-title color="success">{{
                                        $t("label_basic_info")
                                    }}</v-toolbar-title>
                                </v-app-bar>

                           
                            
                             

                                <v-row dense class="ml-2 mr-2 pt-4">
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            outlined
                                            dense
                                            v-model="description"
                                          
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                            ]"
                                        >
                                            <template #label>
                                               Discount Description
                                                <span class="red--text">
                                                    <strong>{{
                                                        $t("label_star")
                                                    }}</strong>
                                                </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            outlined
                                            dense
                                            v-model="amount"
                                         
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                            ]"
                                        >
                                            <template #label>
                                               Discount Amount
                                                <span class="red--text">
                                                    <strong>{{
                                                        $t("label_star")
                                                    }}</strong>
                                                </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-dialog
                                            ref="DialogFromDate"
                                            v-model="modalFromDate"
                                            :return-value.sync="valid_from"
                                            persistent
                                            width="290px"
                                        >
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-text-field
                                                    outlined
                                                    dense
                                                    v-model="valid_from"
                                                    prepend-inner-icon="mdi-calendar"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    :rules="[
                                                        (v) =>
                                                            !!v ||
                                                            $t(
                                                                'label_required'
                                                            ),
                                                    ]"
                                                >
                                                    <template #label>
                                                       Valid From Date
                                                        <span class="red--text">
                                                            <strong>{{
                                                                $t("label_star")
                                                            }}</strong>
                                                        </span>
                                                    </template>
                                                </v-text-field>
                                            </template>
                                            <v-date-picker
                                                v-model="valid_from"
                                                scrollable
                                            >
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    text
                                                    color="primary"
                                                    @click="modalFromDate = false"
                                                    >{{
                                                        $t("label_cancel")
                                                    }}</v-btn
                                                >
                                                <v-btn
                                                    text
                                                    color="primary"
                                                    @click="
                                                        $refs.DialogFromDate.save(
                                                            valid_from
                                                        )
                                                    "
                                                    >{{ $t("label_ok") }}</v-btn
                                                >
                                            </v-date-picker>
                                        </v-dialog>
                                    </v-col>
                                  
                                </v-row>

                                <v-row dense class="ml-2 mr-2">
                                    <v-col cols="12" md="4">
                                        <v-dialog
                                            ref="dialogToDate"
                                            v-model="modalToDate"
                                            :return-value.sync="valid_to"
                                            persistent
                                            width="290px"
                                        >
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-text-field
                                                    outlined
                                                    dense
                                                    v-model="valid_to"
                                                    prepend-inner-icon="mdi-calendar"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                >
                                                    <template #label>
                                                      Discount Applicable Upto
                                                        <span class="red--text">
                                                            <strong>{{
                                                                $t("label_star")
                                                            }}</strong>
                                                        </span>
                                                    </template>
                                                </v-text-field>
                                            </template>
                                            <v-date-picker
                                                v-model="valid_to"
                                                scrollable
                                            >
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    text
                                                    color="primary"
                                                    @click="modalToDate = false"
                                                    >{{
                                                        $t("label_cancel")
                                                    }}</v-btn
                                                >
                                                <v-btn
                                                    text
                                                    color="primary"
                                                    @click="
                                                        $refs.dialogToDate.save(
                                                            valid_to
                                                        )
                                                    "
                                                    >{{ $t("label_ok") }}</v-btn
                                                >
                                            </v-date-picker>
                                        </v-dialog>
                                    </v-col>
                                    <v-col cols="12" md="8">
                                        <v-text-field
                                            outlined
                                            dense
                                            v-model="discount_details"
                                          
                                            :rules="[
                                                (v) =>
                                                    !!v || $t('label_required'),
                                            ]"
                                        >
                                            <template #label>
                                               Discount Details
                                                <span class="red--text">
                                                    <strong>{{
                                                        $t("label_star")
                                                    }}</strong>
                                                </span>
                                            </template>
                                        </v-text-field>
                                    </v-col>

                                 
                                </v-row>

                                <v-row dense class="ml-2 mr-2">
                                    <v-col cols="12" md="6">
                                        <v-select
                                            outlined
                                            dense
                                            v-model="discount_type"
                                            :items="sourceData"
                                            :disabled="isSchoolDataLoading"
                                            item-text="discount_type"
                                            item-value="discount_type"
                                        >
                                            <template #label
                                                >Select Discount Type
                                                <span class="red--text">
                                                    <strong>{{
                                                        $t("label_star")
                                                    }}</strong>
                                                </span></template
                                            >
                                        </v-select>
                                    </v-col>
                                   
                                </v-row>

                       
                            </v-card>
                        </v-form>
                    </v-card>

                    <v-btn
                        color="primary"
                        :disabled="
                            !isBasicHoldingFormValid ||
                            isBasicFormDataProcessing ||
                            alertMessage == ''
                        "
                        @click="saveBasicInfo()"
                        >{{
                            isBasicFormDataProcessing == true
                                ? $t("label_processing")
                                : $t("label_save")
                        }}</v-btn
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
        </v-container>
    </div>
</template>
<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });
export default {
    props: ["userPermissionDataProps", "enquiryDataProps"],
    data() {
        return {
            label_add_discount:
                this.enquiryDataProps != null
                    ? "Edit Discount"
                    : "Add Discount",
            sourceData: ["Percentage", "Amount"],
            description: this.enquiryDataProps != null
                    ? this.enquiryDataProps.description
                    : "",
            amount: this.enquiryDataProps != null
                    ? this.enquiryDataProps.amount
                    : "",
            valid_from: this.enquiryDataProps != null
                    ? this.enquiryDataProps.valid_from
                    : new Date().toISOString().substr(0, 10),
            valid_to: this.enquiryDataProps != null
                    ? this.enquiryDataProps.valid_to
                    : new Date().toISOString().substr(0, 10),
            discount_details: this.enquiryDataProps != null
                    ? this.enquiryDataProps.discount_details
                    : "",
            discount_type: this.enquiryDataProps != null
                    ? this.enquiryDataProps.discount_type
                    : "",
            isDiscountEdit: this.enquiryDataProps != null ? 1 : 0,
      


            alertType: "",
            alertMessage: "",
            // Snack Bar
            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",

            // Form Data
            authorizationConfig: "",

            stepperInfo: 1,

            isSourceDataLoading: false,

            isSchoolDataLoading: false,
            isBasicHoldingFormValid: true,
            isBasicFormDataProcessing: false,


            modalFromDate: false,
            modalToDate: false,



           lms_discount_id:
                this.enquiryDataProps != null
                    ? this.enquiryDataProps.lms_discount_id
                    : "",
        
        };
    },
    watch: {
        whatsAppNumber(val) {
            this.whatsAppNumber = val;
            this.mobileRules =
                this.whatsAppNumber != ""
                    ? [
                          (v) =>
                              (v && v.length >= 10) ||
                              this.$t("label_whatsapp_mobile_number_10_digits"),
                      ]
                    : [];
        },
        selectedProfilePicture(val) {
            this.selectedProfilePicture = val;

            this.imageRule =
                this.selectedProfilePicture != null
                    ? [
                          (v) =>
                              !v ||
                              v.size <= 1048576 ||
                              this.$t("label_file_size_criteria_1_mb"),
                      ]
                    : [];
        },
        whatsApp(val) {
            this.whatsApp = val;
            this.whatsAppMobileRules =
                this.whatsApp != " "
                    ? [
                          (v) =>
                              (v && v.length >= 10) ||
                              this.$t("label_whatsapp_mobile_number_10_digits"),
                      ]
                    : [];
        },
    },
    created() {
        console.log(this.enquiryDataProps);
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") },
        };
        this. getPrefixModuleWise();
      
    },
    methods: {
  
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
        // To ensure name is character without space only
        isCharacters(evt) {
            var regex = new RegExp("^[a-zA-Z]+$");
            var key = String.fromCharCode(
                !evt.charCode ? evt.which : evt.charCode
            );
            if (!regex.test(key)) {
                evt.preventDefault();
                return false;
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
            this.$http
                .get(`web_get_prefix_module_wise`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        prefixModuleName: "Enquiry Code",
                    },
                    headers: { Authorization: "Bearer " + ls.get("token") },
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
                            this.alertMessage ="Here you can enter Discount Information"
                              
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
 
   


        //Save basic info
        saveBasicInfo() {
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
                basicFormData.append(
                    "isDiscountEdit",
                    this.isDiscountEdit
                );

                basicFormData.append(
                    "description",
                    this.description
                );
                basicFormData.append(
                    "amount",
                    this.amount
                );
                basicFormData.append("valid_from", this.valid_from);
              
                if (this.lms_discount_id != "") {
                    basicFormData.append("lms_discount_id", this.lms_discount_id);
                }
                basicFormData.append("valid_to", this.valid_to);
                basicFormData.append("discount_details", this.discount_details);

                basicFormData.append(
                    "discount_type",
                    this.discount_type
                );


                this.$http
                    .post(
                        "web_save_edit_discounts",
                        basicFormData,
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isBasicFormDataProcessing = false;
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
                                  "Discount Description Already Exists"
                                );
                            }

                            // Enquiry Saved
                            else if (data.responseData == 4) {
                             
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                 "New Discount Added"
                                );
                                this.isEnquiryBasicEdit = 1;
                                this.lms_discount_id= data.lms_discount_id;
                           


                                setTimeout(()=>{
                                    this.$router.push({
                                      name: "Discounts",
                                      });
                                  },2000)
                                // this.stepperInfo = 2;
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
                               
                                setTimeout(()=>{
                                    this.$router.push({
                                      name: "Discounts",
                                      });
                                  },2000)
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
    },
};
</script>
