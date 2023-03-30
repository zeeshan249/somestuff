<template>
  <div id="app">
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
            <v-card class="mx-auto mt-2" max-width="100%" outlined>
              <v-app-bar dark color="primary">
                <v-toolbar-title color="success">{{
                  $t("label_basic_info")
                }}</v-toolbar-title>
              </v-app-bar>

              <v-row dense class="ml-2 mr-2 mt-2">
                <v-col cols="12" md="3" sm="6">
                  <v-text-field v-model="staffCode" outlined dense disabled>
                    <template #label>{{ $t("label_code") }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3" sm="6">
                  <v-select
                    outlined
                    dense
                    v-model="selectedRoleId"
                    :items="roleItems"
                    :disabled="isRoleDataLoading"
                    item-text="name"
                    item-value="id"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_role") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-select>
                </v-col>
                <v-col cols="12" md="3" sm="6">
                  <v-select
                    outlined
                    dense
                    v-model="selectedDesignationId"
                    :items="designationItems"
                    :disabled="isDesignationDataLoading"
                    item-text="lms_designation_name"
                    item-value="lms_designation_id"
                  >
                    <template #label>{{ $t("label_designation") }}</template>
                  </v-select>
                </v-col>
                <v-col cols="12" md="3" sm="6">
                  <v-select
                    outlined
                    dense
                    v-model="selectedDepartmentId"
                    :items="departmentItems"
                    :disabled="isDepartmentDataLoading"
                    item-text="lms_department_name"
                    item-value="lms_department_id"
                  >
                    <template #label>{{ $t("label_department") }}</template>
                  </v-select>
                </v-col>
              </v-row>

              <v-row dense class="ml-2 mr-2">
                <v-col cols="12" md="3">
                  <v-text-field
                    outlined
                    dense
                    v-model="firstName"
                    @keypress="isCharacters"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_first_name") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    outlined
                    dense
                    v-model="lastName"
                    @keypress="isCharacters"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_last_name") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    outlined
                    dense
                    v-model="fatherName"
                    @keypress="isCharactersWithSpace"
                  >
                    <template #label>{{ $t("label_father_name") }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    outlined
                    dense
                    v-model="motherName"
                    @keypress="isCharactersWithSpace"
                  >
                    <template #label>{{ $t("label_mother_name") }}</template>
                  </v-text-field>
                </v-col>
              </v-row>

              <v-row dense class="ml-2 mr-2">
                <v-col cols="12" md="3">
                  <v-select
                    outlined
                    dense
                    v-model="selectedGender"
                    :items="genderItems"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_gender") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-select>
                </v-col>
                <v-col cols="12" md="3">
                  <v-select
                    outlined
                    dense
                    v-model="selectedMaritalStatus"
                    :items="maritalStatusItems"
                  >
                    <template #label>{{ $t("label_marital_status") }}</template>
                  </v-select>
                </v-col>

                <v-col cols="12" md="3">
                  <v-dialog
                    ref="dialogDOB"
                    v-model="modalDOB"
                    :return-value.sync="selectedDOB"
                    persistent
                    width="290px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        outlined
                        dense
                        v-model="selectedDOB"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        :rules="[(v) => !!v || $t('label_required')]"
                      >
                        <template #label>
                          {{ $t("label_dob") }}
                          <span class="red--text">
                            <strong>{{ $t("label_star") }}</strong>
                          </span>
                        </template>
                      </v-text-field>
                    </template>
                    <v-date-picker v-model="selectedDOB" scrollable>
                      <v-spacer></v-spacer>
                      <v-btn text color="primary" @click="modalDOB = false">{{
                        $t("label_cancel")
                      }}</v-btn>
                      <v-btn
                        text
                        color="primary"
                        @click="$refs.dialogDOB.save(selectedDOB)"
                        >{{ $t("label_ok") }}</v-btn
                      >
                    </v-date-picker>
                  </v-dialog>
                </v-col>

                <v-col cols="12" md="3">
                  <v-dialog
                    ref="dialogDOJ"
                    v-model="modalDOJ"
                    :return-value.sync="selectedDOJ"
                    persistent
                    width="290px"
                  >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field
                        outlined
                        dense
                        v-model="selectedDOJ"
                        prepend-inner-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                      >
                        <template #label>{{ $t("label_doj") }}</template>
                      </v-text-field>
                    </template>
                    <v-date-picker v-model="selectedDOJ" scrollable>
                      <v-spacer></v-spacer>
                      <v-btn text color="primary" @click="modalDOJ = false">{{
                        $t("label_cancel")
                      }}</v-btn>
                      <v-btn
                        text
                        color="primary"
                        @click="$refs.dialogDOJ.save(selectedDOJ)"
                        >{{ $t("label_ok") }}</v-btn
                      >
                    </v-date-picker>
                  </v-dialog>
                </v-col>
              </v-row>

              <v-row dense class="ml-2 mr-2">
                <v-col cols="12" md="3">
                  <v-text-field
                    outlined
                    dense
                    v-model="contactNumber"
                    maxlength="10"
                    :counter="10"
                    @keypress="isDigit"
                    :rules="[
                      (v) => !!v || $t('label_provide_valid_mobile_number'),
                      (v) =>
                        (v && v.length >= 10) ||
                        $t('label_mobile_number_10_digits'),
                    ]"
                  >
                    <template #label>
                      {{ $t("label_contact_number") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    outlined
                    dense
                    v-model="emergencyContactNumber"
                    :counter="10"
                    maxlength="10"
                    @keypress="isDigit"
                    :rules="mobileRules"
                  >
                    <template #label>{{
                      $t("label_emergency_contact_number")
                    }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    outlined
                    dense
                    v-model="email"
                    type="email"
                    :rules="[
                      (v) => !!v || $t('label_required'),
                      (v) =>
                        !v ||
                        /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                        $t('label_provide_valid_email'),
                    ]"
                  >
                    <template #label>
                      {{ $t("label_email") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-file-input
                    v-model="selectedProfilePicture"
                    color="primary"
                    outlined
                    dense
                    show-size
                    accept="image/*"
                    :rules="imageRule"
                  >
                    <template v-slot:selection="{ index, text }">
                      <v-chip
                        v-if="index < 2"
                        color="primary"
                        dark
                        label
                        small
                        >{{ text }}</v-chip
                      >
                    </template>
                    <template #label>{{ $t("label_profile_image") }}</template>
                  </v-file-input>
                </v-col>
              </v-row>

              <!-- New Row Start -->
              <v-row dense class="ml-2 mr-2">
                <v-col cols="12" md="6">
                  <v-text-field outlined dense v-model="currentAddress">
                    <template #label>{{
                      $t("label_current_address")
                    }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field outlined dense v-model="permanentAddress">
                    <template #label>{{
                      $t("label_permanent_address")
                    }}</template>
                  </v-text-field>
                </v-col>
              </v-row>

              <!-- New Row Start -->
              <v-row dense class="ml-2 mr-2">
                <v-col cols="12" md="3">
                  <v-text-field outlined dense v-model="qualification">
                    <template #label>{{ $t("label_qualification") }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field outlined dense v-model="workExperience">
                    <template #label>{{
                      $t("label_work_experience")
                    }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field outlined dense v-model="aboutStaff">
                    <template #label>{{ $t("label_about_staff") }}</template>
                  </v-text-field>
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
        <v-btn color="primary" @click="stepperInfo = 2">{{
          $t("label_skip")
        }}</v-btn>
      </v-stepper-content>
      <v-stepper-step :complete="stepperInfo > 2" step="2">{{
        $t("label_payroll")
      }}</v-stepper-step>
      <v-stepper-content step="2">
        <v-card color="grey lighten-1" class="mb-12">
          <v-form
            ref="holdingFormPayroll"
            v-model="isPayRollFormValid"
            lazy-validation
          >
            <v-card class="mx-auto" max-width="100%" outlined>
              <v-system-bar color="primary" dark height="10px"></v-system-bar>
              <!-- New Row Start -->
              <v-row dense class="ml-2 mr-2 mt-2">
                <v-col cols="12" md="3">
                  <v-text-field outlined dense v-model="epfNo">
                    <template #label>
                      {{ $t("label_epf_no") }}
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="3">
                  <v-text-field
                    outlined
                    dense
                    v-model="basicSalary"
                    @keypress="isDigitWithDecimal"
                  >
                    <template #label>
                      {{ $t("label_basic_salary") }}
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-select
                    outlined
                    dense
                    v-model="selectedContractType"
                    :items="contractItems"
                  >
                    <template #label>{{ $t("label_contract_type") }}</template>
                  </v-select>
                </v-col>
                <v-col cols="12" md="6">
                  <v-select
                    outlined
                    dense
                    v-model="selectedWorkShift"
                    :items="workShiftItems"
                  >
                    <template #label>{{ $t("label_work_shift") }}</template>
                  </v-select>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field outlined dense v-model="location">
                    <template #label>{{ $t("label_location") }}</template>
                  </v-text-field>
                </v-col>
              </v-row>
            </v-card>
          </v-form>
        </v-card>
        <v-btn
          color="primary"
          :disabled="!isPayRollFormValid || isPayRollFormDataProcessing"
          @click="editPayrollInfo()"
          >{{
            isPayRollFormDataProcessing == true
              ? $t("label_processing")
              : $t("label_save")
          }}</v-btn
        >
        <v-btn color="primary" @click="stepperInfo = 3">{{
          $t("label_skip")
        }}</v-btn>
      </v-stepper-content>

      <v-stepper-step :complete="stepperInfo > 3" step="3">{{
        $t("label_bank_account_details")
      }}</v-stepper-step>

      <v-stepper-content step="3">
        <v-card color="grey lighten-1" class="mb-12">
          <v-card class="mx-auto mt-2" max-width="100%" outlined>
            <v-system-bar color="primary" dark height="10px"></v-system-bar>
            <!-- New Row Start -->
            <v-row dense class="ml-2 mr-2 mt-2">
              <v-col cols="12" md="3">
                <v-text-field outlined dense v-model="accountTitle">
                  <template #label>{{
                    $t("label_account_title")
                  }}</template></v-text-field
                >
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field outlined dense v-model="bankAccountNumber">
                  <template #label>{{
                    $t("label_bank_account_number")
                  }}</template></v-text-field
                >
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field outlined dense v-model="bankName">
                  <template #label>{{
                    $t("label_bank_name")
                  }}</template></v-text-field
                >
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field outlined dense v-model="ifscCode">
                  <template #label>{{ $t("label_ifsc_code") }}</template>
                </v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field outlined dense v-model="bankBranchName">
                  <template #label>{{ $t("label_bank_branch_name") }}</template>
                </v-text-field>
              </v-col>
            </v-row>
          </v-card>
        </v-card>
        <v-btn
          color="primary"
          :disabled="isBankDetailsFormDataProcessing"
          @click="editBankDetailsInfo()"
          >{{
            isBankDetailsFormDataProcessing == true
              ? $t("label_processing")
              : $t("label_save")
          }}</v-btn
        >

        <v-btn color="primary" @click="stepperInfo = 4">{{
          $t("label_skip")
        }}</v-btn>
      </v-stepper-content>

      <v-stepper-step :complete="stepperInfo > 4" step="4">{{
        $t("label_social_media_links")
      }}</v-stepper-step>
      <v-stepper-content step="4">
        <v-card color="grey lighten-1" class="mb-12">
          <v-form
            ref="holdingFormSocialLink"
            v-model="isSocialLinkFormValid"
            lazy-validation
          >
            <v-card class="mx-auto mt-2" max-width="100%" outlined>
              <v-system-bar color="primary" dark height="10px"></v-system-bar>
              <!-- New Row Start -->
              <v-row dense class="ml-2 mr-2 mt-2">
                <v-col cols="12" md="4">
                  <v-text-field
                    outlined
                    dense
                    v-model="whatsApp"
                    @keypress="isDigit"
                    maxlength="10"
                    :counter="10"
                    :rules="whatsAppMobileRules"
                  >
                    <template #label>{{ $t("label_whatsapp") }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field outlined dense v-model="facebook">
                    <template #label>{{ $t("label_facebook_url") }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="4">
                  <v-text-field outlined dense v-model="twitter">
                    <template #label>{{ $t("label_twitter_url") }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field outlined dense v-model="linkedin">
                    <template #label>{{ $t("label_linkedin_url") }}</template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    outlined
                    dense
                    v-model="instagam"
                    label="Instagram URL"
                  >
                    <template #label>{{ $t("label_instagram_url") }}</template>
                  </v-text-field>
                </v-col>
              </v-row>
            </v-card>
          </v-form>
        </v-card>
        <v-btn
          color="primary"
          :disabled="!isSocialLinkFormValid || isSocialLinkFormDataProcessing"
          @click="editSocialDetailsInfo()"
          >{{
            isSocialLinkFormDataProcessing == true
              ? $t("label_processing")
              : $t("label_save")
          }}</v-btn
        >

        <v-btn color="primary" @click="stepperInfo = 5">{{
          $t("label_skip")
        }}</v-btn>
      </v-stepper-content>

      <v-stepper-step :complete="stepperInfo > 5" step="5">{{
        $t("label_upload_documents")
      }}</v-stepper-step>
      <v-stepper-content step="5">
        <v-card color="grey lighten-1" class="mb-12">
          <v-form
            ref="holdingFormUploadDocument"
            v-model="isUploadDocumentFormValid"
            lazy-validation
          >
            <v-card class="mx-auto" max-width="100%" outlined>
              <v-system-bar color="primary" dark height="10px"></v-system-bar>
              <!-- New Row Start -->
              <v-row dense class="ml-2 mr-2 mt-2">
                <v-col cols="12" md="6">
                  <v-file-input
                    v-model="selectedJoiningLetter"
                    color="primary"
                    outlined
                    dense
                    show-size
                    accept=".doc,.docx,.jpg,.jpeg,.png,.pdf"
                    :rules="fileRule"
                  >
                    <template v-slot:selection="{ index, text }">
                      <v-chip
                        v-if="index < 2"
                        color="primary"
                        dark
                        label
                        small
                        >{{ text }}</v-chip
                      >
                    </template>
                    <template #label>{{ $t("label_joining_letter") }}</template>
                  </v-file-input>
                </v-col>
                <v-col cols="12" md="6">
                  <v-file-input
                    v-model="selectedResume"
                    color="primary"
                    outlined
                    dense
                    show-size
                    accept=".doc,.docx,.jpg,.jpeg,.png,.pdf"
                    :rules="fileRule"
                  >
                    <template v-slot:selection="{ index, text }">
                      <v-chip
                        v-if="index < 2"
                        color="primary"
                        dark
                        label
                        small
                        >{{ text }}</v-chip
                      >
                    </template>
                    <template #label>{{ $t("label_resume") }}</template>
                  </v-file-input>
                </v-col>
                <v-col cols="12" md="6">
                  <v-file-input
                    v-model="selectedResignationLetter"
                    color="primary"
                    outlined
                    dense
                    show-size
                    accept=".doc,.docx,.jpg,.jpeg,.png,.pdf"
                    :rules="fileRule"
                  >
                    <template v-slot:selection="{ index, text }">
                      <v-chip
                        v-if="index < 2"
                        color="primary"
                        dark
                        label
                        small
                        >{{ text }}</v-chip
                      >
                    </template>
                    <template #label>{{
                      $t("label_resignation_letter")
                    }}</template>
                  </v-file-input>
                </v-col>
                <v-col cols="12" md="6">
                  <v-file-input
                    v-model="selectedAadharCard"
                    color="primary"
                    outlined
                    dense
                    show-size
                    accept=".doc,.docx,.jpg,.jpeg,.png,.pdf"
                    :rules="fileRule"
                  >
                    <template v-slot:selection="{ index, text }">
                      <v-chip
                        v-if="index < 2"
                        color="primary"
                        dark
                        label
                        small
                        >{{ text }}</v-chip
                      >
                    </template>
                    <template #label>{{ $t("label_aadhar_card") }}</template>
                  </v-file-input>
                </v-col>
                <v-col cols="12" md="6">
                  <v-file-input
                    v-model="selectedPanCard"
                    color="primary"
                    outlined
                    dense
                    show-size
                    accept=".doc,.docx,.jpg,.jpeg,.png,.pdf"
                    :rules="fileRule"
                  >
                    <template v-slot:selection="{ index, text }">
                      <v-chip
                        v-if="index < 2"
                        color="primary"
                        dark
                        label
                        small
                        >{{ text }}</v-chip
                      >
                    </template>
                    <template #label>{{ $t("label_pan_card") }}</template>
                  </v-file-input>
                </v-col>
                <v-col cols="12" md="6">
                  <v-file-input
                    v-model="selectedVoterCard"
                    color="primary"
                    outlined
                    dense
                    show-size
                    accept=".doc,.docx,.jpg,.jpeg,.png,.pdf"
                    :rules="fileRule"
                  >
                    <template v-slot:selection="{ index, text }">
                      <v-chip
                        v-if="index < 2"
                        color="primary"
                        dark
                        label
                        small
                        >{{ text }}</v-chip
                      >
                    </template>
                    <template #label>{{ $t("label_voter_card") }}</template>
                  </v-file-input>
                </v-col>
              </v-row>
            </v-card>
          </v-form>
        </v-card>
        <v-btn
          color="primary"
          :disabled="
            !isUploadDocumentFormValid || isUploadDocumentFormDataProcessing
          "
          @click="editUploadDocumentInfo()"
          >{{
            isUploadDocumentFormDataProcessing == true
              ? $t("label_processing")
              : $t("label_save")
          }}</v-btn
        >

        <v-btn color="primary" @click="stepperInfo = 1">{{
          $t("label_skip")
        }}</v-btn>
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
  props: ["userPermissionDataProps", "staffDataProps"],
  data() {
    return {
      // For Breadcrumb
      breadCrumbItem: [
        {
          text: this.$t("label_home"),
          disabled: false,
        },
        {
          text: this.$t("label_human_resource"),
          disabled: false,
        },
        {
          text: this.$t("label_add_staff"),
          disabled: false,
        },
      ],
      alertType: "",
      alertMessage: "",
      // Snack Bar
      isSnackBarVisible: false,
      snackBarMessage: "",
      snackBarColor: "",

      // Form Data
      authorizationConfig: "",

      stepperInfo: 1,
      staffCode:
        this.staffDataProps != null ? this.staffDataProps.lms_staff_code : "",

      selectedRoleId:
        this.staffDataProps != null ? this.staffDataProps.role_id : "",
      roleItems: [],
      isRoleDataLoading: false,

      selectedDesignationId:
        this.staffDataProps != null
          ? this.staffDataProps.lms_designation_id
          : "",
      designationItems: [],
      isDesignationDataLoading: false,

      selectedDepartmentId:
        this.staffDataProps != null
          ? this.staffDataProps.lms_department_id
          : "",
      departmentItems: [],
      isDepartmentDataLoading: false,
      isBasicHoldingFormValid: true,
      isBasicFormDataProcessing: false,
      firstName:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_first_name
          : "",
      lastName:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_last_name
          : "",
      fatherName:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_father_name
          : "",
      motherName:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_mother_name
          : "",
      genderItems: ["Male", "Female", "Transgender"],
      maritalStatusItems: [
        "Single",
        "Married",
        "Widowed",
        "Seprated",
        "Not specified",
      ],
      selectedGender:
        this.staffDataProps != null ? this.staffDataProps.lms_staff_gender : "",
      selectedMaritalStatus:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_marital_status
          : "",
      modalDOB: false,
      modalDOJ: false,
      selectedDOB:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_date_of_birth
          : new Date().toISOString().substr(0, 10),
      selectedDOJ:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_date_of_joining
          : new Date().toISOString().substr(0, 10),
      contactNumber:
        this.staffDataProps != null
          ? this.staffDataProps.lms_user_mobile
          : null,
      emergencyContactNumber:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_emergency_contact
          : null,
      email:
        this.staffDataProps != null ? this.staffDataProps.lms_staff_email : "",
      mobileRules: [],
      imageRule: [],

      selectedProfilePicture: null,
      currentAddress:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_local_address
          : "",
      permanentAddress:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_permanent_address
          : "",
      qualification:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_qualification
          : "",
      workExperience:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_work_experience
          : "",
      aboutStaff:
        this.staffDataProps != null ? this.staffDataProps.lms_staff_about : "",
      staffId:
        this.staffDataProps != null ? this.staffDataProps.lms_staff_id : "",
      staffUserId:
        this.staffDataProps != null ? this.staffDataProps.lms_user_id : "",
      isStaffBasicEdit: this.staffDataProps != null ? 1 : 0,
      staffProfileImageNameForEdit:
        this.staffDataProps != null
          ? this.staffDataProps.lms_user_profile_image
          : "",

      epfNo:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_epf_number
          : "",
      basicSalary:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_basic_salary
          : "",
      selectedContractType:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_contract_type
          : "",
      contractItems: ["Temporary", "Permanent"],

      selectedWorkShift:
        this.staffDataProps != null ? this.staffDataProps.lms_staff_shift : "",
      workShiftItems: ["Morning", "Day", "Night"],
      location:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_location
          : "",
      isPayRollFormValid: true,
      isPayRollFormDataProcessing: false,

      isBankDetailsFormDataProcessing: false,

      accountTitle:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_account_title
          : "",

      bankAccountNumber:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_bank_account_number
          : "",

      bankName:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_bank_name
          : "",

      ifscCode:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_bank_ifsc_code
          : "",

      bankBranchName:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_bank_branch
          : "",

      isSocialLinkFormValid: true,
      isSocialLinkFormDataProcessing: false,

      whatsApp:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_whatsapp
          : null,

      facebook:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_facebook
          : "",
      twitter:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_twitter
          : "",

      linkedin:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_linkedin
          : "",
      instagam:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_instagram
          : "",
      whatsAppMobileRules: [],

      selectedJoiningLetter: null,
      selectedResume: null,
      selectedResignationLetter: null,
      selectedAadharCard: null,
      selectedPanCard: null,
      selectedVoterCard: null,
      staffJoiningLetterNameForEdit:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_joining_letter_path
          : "",

      staffResumeNameForEdit:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_resume_path
          : "",

      staffResignationLetterNameForEdit:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_resignation_letter_path
          : "",

      staffAadharCardNameForEdit:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_aadhar_path
          : "",

      staffPanCardNameForEdit:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_pan_path
          : "",

      staffVoterCardNameForEdit:
        this.staffDataProps != null
          ? this.staffDataProps.lms_staff_voter_card_path
          : "",
      isUploadDocumentFormValid: true,
      isUploadDocumentFormDataProcessing: false,

      fileRule: [],
    };
  },
  watch: {
    emergencyContactNumber(val) {
      this.emergencyContactNumber = val;
      this.mobileRules =
        this.emergencyContactNumber != ""
          ? [
              (v) =>
                (v && v.length >= 10) ||
                this.$t("label_mobile_number_10_digits"),
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
    selectedJoiningLetter(val) {
      this.selectedJoiningLetter = val;

      this.fileRule =
        this.selectedJoiningLetter != null
          ? [
              (v) =>
                !v ||
                v.size <= 1048576 ||
                this.$t("label_file_size_criteria_1_mb"),
            ]
          : [];
    },
    selectedResume(val) {
      this.selectedResume = val;

      this.fileRule =
        this.selectedResume != null
          ? [
              (v) =>
                !v ||
                v.size <= 1048576 ||
                this.$t("label_file_size_criteria_1_mb"),
            ]
          : [];
    },
    selectedResignationLetter(val) {
      this.selectedResignationLetter = val;

      this.fileRule =
        this.selectedResignationLetter != null
          ? [
              (v) =>
                !v ||
                v.size <= 1048576 ||
                this.$t("label_file_size_criteria_1_mb"),
            ]
          : [];
    },

    selectedAadharCard(val) {
      this.selectedAadharCard = val;

      this.fileRule =
        this.selectedAadharCard != null
          ? [
              (v) =>
                !v ||
                v.size <= 1048576 ||
                this.$t("label_file_size_criteria_1_mb"),
            ]
          : [];
    },
    selectedPanCard(val) {
      this.selectedPanCard = val;

      this.fileRule =
        this.selectedPanCard != null
          ? [
              (v) =>
                !v ||
                v.size <= 1048576 ||
                this.$t("label_file_size_criteria_1_mb"),
            ]
          : [];
    },
    selectedVoterCard(val) {
      this.selectedVoterCard = val;

      this.fileRule =
        this.selectedVoterCard != null
          ? [
              (v) =>
                !v ||
                v.size <= 1048576 ||
                this.$t("label_file_size_criteria_1_mb"),
            ]
          : [];
    },
  },
  created() {
    // Token Config
    this.authorizationConfig = {
      headers: { Authorization: "Bearer " + ls.get("token") },
    };
    // Get Prefix Setting
    this.getPrefixModuleWise();

    // Get Active Roles
    this.getAllActiveRoles();

    // Get Active Designation
    this.getAllActiveRoles();

    // Get Active Designation
    this.getAllActiveDesignation();

    // Get Active department
    this.getAllActiveDepartment();

    console.log(this.staffDataProps);
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
      if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        evt.preventDefault();
      } else {
        return true;
      }
    },
    // To ensure name is character without space only
    isCharacters(evt) {
      var regex = new RegExp("^[a-zA-Z]+$");
      var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
      if (!regex.test(key)) {
        evt.preventDefault();
        return false;
      }
    },
    // To ensure name is character with space only
    isCharactersWithSpace(evt) {
      var regex = new RegExp("^[a-zA-Z ]+$");
      var key = String.fromCharCode(!evt.charCode ? evt.which : evt.charCode);
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
            prefixModuleName: "Staff Code",
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
              this.alertMessage =
                this.$t("label_staff_code_will_be_generated") +
                data[0].lms_prefix_pattern +
                this.$t("label_if_want_to_change_staff_code");
            }
            // If prefix not set
            else {
              this.alertType = "error";
              this.alertMessage = this.$t(
                "label_prefix_pattern_not_set_for_staff"
              );
            }
          }
        })
        .catch((error) => {
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Get all active roles
    getAllActiveRoles() {
      this.isRoleDataLoading = true;
      this.$http
        .get(`web_get_all_active_roles_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
          },
          headers: { Authorization: "Bearer " + ls.get("token") },
        })
        .then(({ data }) => {
          this.isRoleDataLoading = false;
          //User Unauthorized
          if (
            data.error == "Unauthorized" ||
            data.permissionError == "Unauthorized"
          ) {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.roleItems = data;
          }
        })
        .catch((error) => {
          this.isRoleDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },

    // Get all active designation
    getAllActiveDesignation() {
      this.isDesignationDataLoading = true;
      this.$http
        .get(`web_get_active_designation_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
          },
          headers: { Authorization: "Bearer " + ls.get("token") },
        })
        .then(({ data }) => {
          this.isDesignationDataLoading = false;
          //User Unauthorized
          if (
            data.error == "Unauthorized" ||
            data.permissionError == "Unauthorized"
          ) {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.designationItems = data;
          }
        })
        .catch((error) => {
          this.isDesignationDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },

    // Get all active department
    getAllActiveDepartment() {
      this.isDepartmentDataLoading = true;
      this.$http
        .get(`web_get_active_department_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
          },
          headers: { Authorization: "Bearer " + ls.get("token") },
        })
        .then(({ data }) => {
          this.isDepartmentDataLoading = false;
          //User Unauthorized
          if (
            data.error == "Unauthorized" ||
            data.permissionError == "Unauthorized"
          ) {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.departmentItems = data;
          }
        })
        .catch((error) => {
          this.isDepartmentDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
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
        basicFormData.append("isStaffBasicEdit", this.isStaffBasicEdit);
        if (this.staffProfileImageNameForEdit != null) {
        basicFormData.append(
          "staffProfileImageNameForEdit",
          this.staffProfileImageNameForEdit
        );
        }
        basicFormData.append("centerId", ls.get("loggedUserCenterId"));
        if (this.staffId != "") {
          basicFormData.append("staffId", this.staffId);
        }
        basicFormData.append("loggedUserId", ls.get("loggedUserId"));
        if (this.staffUserId != "") {
          basicFormData.append("staffUserId", this.staffUserId);
        }
        basicFormData.append("staffRoleId", this.selectedRoleId);
        if (this.selectedDesignationId != "") {
          basicFormData.append(
            "staffDesignationId",
            this.selectedDesignationId
          );
        }
        if (this.selectedDepartmentId != "") {
          basicFormData.append("staffDepartmentId", this.selectedDepartmentId);
        }
        basicFormData.append("staffFirstName", this.firstName);
        basicFormData.append("staffLastName", this.lastName);
        if (this.fatherName != "") {
          basicFormData.append("staffFathersName", this.fatherName);
        }
        if (this.motherName != "") {
          basicFormData.append("staffMothersName", this.motherName);
        }

        basicFormData.append("staffGender", this.selectedGender);
        if (this.selectedMaritalStatus != "") {
          basicFormData.append(
            "staffMaritalStatus",
            this.selectedMaritalStatus
          );
        }
        basicFormData.append("staffDOB", this.selectedDOB);
        if (this.selectedDOJ != "") {
          basicFormData.append("staffDOJ", this.selectedDOJ);
        }
        basicFormData.append("staffContactNumber", this.contactNumber);
        if (this.emergencyContactNumber != null) {
          basicFormData.append(
            "staffEmergencyContactNumber",
            this.emergencyContactNumber
          );
        }
        basicFormData.append("staffEmail", this.email);
        
        if (this.selectedProfilePicture != null) {
          basicFormData.append(
            "staffProfileImage",
            this.selectedProfilePicture
          );
        }

        basicFormData.append("staffCurrentAddress", this.currentAddress);
        basicFormData.append("staffPermanentAddress", this.permanentAddress);
        basicFormData.append("staffQualification", this.qualification);
        basicFormData.append("staffWorkExp", this.workExperience);
        basicFormData.append("staffAbout", this.aboutStaff);

        this.$http
          .post(
            "web_save_edit_staff_basic_info",
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
                this.changeSnackBarMessage(this.$t("label_email_exists"));
              }
              // Mobile exists
              else if (data.responseData == 3) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(this.$t("label_mobile_exists"));
              }

              // Staff Saved
              else if (data.responseData == 4) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(
                  this.$t("label_staff_details_saved")
                );
                this.isStaffBasicEdit = 1;
                this.staffId = data.staffId;
                this.staffUserId = data.staffUserId;
                this.staffCode = data.staffCode;
                this.staffProfileImageNameForEdit = data.staffEditImageName;
                this.stepperInfo = 2;
              }
              // Staff save failed
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
                  this.$t("label_staff_details_updated")
                );
                this.staffProfileImageNameForEdit = data.staffEditImageName;
                this.stepperInfo = 2;
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
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },
    //Edit payroll
    editPayrollInfo() {
      if (this.$refs.holdingFormPayroll.validate()) {
        // Edit Payoll Info
        this.authorizationConfig = {
          headers: {
            Authorization: "Bearer " + ls.get("token"),
            "content-type": "multipart/form-data",
          },
        };
        this.isPayRollFormDataProcessing = true;
        let payRollFormData = new FormData();
        payRollFormData.append("staffId", this.staffId);
        payRollFormData.append("loggedUserId", ls.get("loggedUserId"));
        payRollFormData.append("centerId", ls.get("loggedUserCenterId"));

        if (this.epfNo != "") {
          payRollFormData.append("staffEpfNo", this.epfNo);
        }
        if (this.basicSalary != "") {
          payRollFormData.append("staffBasicSalary", this.basicSalary);
        }
        if (this.selectedContractType != "") {
          payRollFormData.append(
            "staffContractType",
            this.selectedContractType
          );
        }
        if (this.selectedWorkShift != "") {
          payRollFormData.append("staffWorkShift", this.selectedWorkShift);
        }
        if (this.location != "") {
          payRollFormData.append("staffLocation", this.location);
        }

        this.$http
          .post(
            "web_edit_staff_payroll_info",
            payRollFormData,
            this.authorizationConfig
          )
          .then(({ data }) => {
            this.isPayRollFormDataProcessing = false;
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

              // Payroll edited
              else if (data.responseData == 1) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(
                  this.$t("label_staff_details_updated")
                );
                this.stepperInfo = 3;
              }
              // Payroll edited failed
              else if (data.responseData == 2) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
            }
          })
          .catch((error) => {
            this.isPayRollFormDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },
    // Edit Bank details
    editBankDetailsInfo() {
      // Edit Bank details Info
      this.authorizationConfig = {
        headers: {
          Authorization: "Bearer " + ls.get("token"),
          "content-type": "multipart/form-data",
        },
      };
      this.isBankDetailsFormDataProcessing = true;
      let bankDetailsFormData = new FormData();
      bankDetailsFormData.append("staffId", this.staffId);
      bankDetailsFormData.append("loggedUserId", ls.get("loggedUserId"));
      bankDetailsFormData.append("centerId", ls.get("loggedUserCenterId"));

      if (this.accountTitle != "") {
        bankDetailsFormData.append("staffAccountTitle", this.accountTitle);
      }
      if (this.bankAccountNumber != "") {
        bankDetailsFormData.append(
          "staffBankAccountNumber",
          this.bankAccountNumber
        );
      }
      if (this.bankName != "") {
        bankDetailsFormData.append("staffBank", this.bankName);
      }
      if (this.ifscCode != "") {
        bankDetailsFormData.append("staffIfscCode", this.ifscCode);
      }
      if (this.bankBranchName != "") {
        bankDetailsFormData.append("staffBankBranch", this.bankBranchName);
      }

      this.$http
        .post(
          "web_edit_staff_bank_details_info",
          bankDetailsFormData,
          this.authorizationConfig
        )
        .then(({ data }) => {
          this.isBankDetailsFormDataProcessing = false;
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

            // Bank details edited
            else if (data.responseData == 1) {
              this.snackBarColor = "success";
              this.changeSnackBarMessage(
                this.$t("label_staff_details_updated")
              );
              this.stepperInfo = 4;
            }
            // Bank details edited failed
            else if (data.responseData == 2) {
              this.snackBarColor = "error";
              this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
            }
          }
        })
        .catch((error) => {
          this.isBankDetailsFormDataProcessing = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
    // Edit Social Info
    editSocialDetailsInfo() {
      if (this.$refs.holdingFormSocialLink.validate()) {
        // Edit Social Info
        this.authorizationConfig = {
          headers: {
            Authorization: "Bearer " + ls.get("token"),
            "content-type": "multipart/form-data",
          },
        };
        this.isSocialLinkFormDataProcessing = true;
        let socialLinkFormData = new FormData();
        socialLinkFormData.append("staffId", this.staffId);
        socialLinkFormData.append("loggedUserId", ls.get("loggedUserId"));
        socialLinkFormData.append("centerId", ls.get("loggedUserCenterId"));

        if (this.whatsApp != null) {
          socialLinkFormData.append("staffWhatsApp", this.whatsApp);
        }
        if (this.facebook != "") {
          socialLinkFormData.append("staffFacebook", this.facebook);
        }
        if (this.twitter != "") {
          socialLinkFormData.append("staffTwitter", this.twitter);
        }
        if (this.linkedin != "") {
          socialLinkFormData.append("staffLinkedin", this.linkedin);
        }
        if (this.instagam != "") {
          socialLinkFormData.append("staffInstagram", this.instagam);
        }

        this.$http
          .post(
            "web_edit_staff_social_link_info",
            socialLinkFormData,
            this.authorizationConfig
          )
          .then(({ data }) => {
            this.isSocialLinkFormDataProcessing = false;
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

              // social  edited
              else if (data.responseData == 1) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(
                  this.$t("label_staff_details_updated")
                );
                this.stepperInfo = 5;
              }
              // social edited failed
              else if (data.responseData == 2) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
            }
          })
          .catch((error) => {
            this.isSocialLinkFormDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },
    // Edit Document upload
    editUploadDocumentInfo() {
      if (this.$refs.holdingFormUploadDocument.validate()) {
        // Edit Upload doc Info
        this.authorizationConfig = {
          headers: {
            Authorization: "Bearer " + ls.get("token"),
            "content-type": "multipart/form-data",
          },
        };
        this.isUploadDocumentFormDataProcessing = true;
        let uploadDocumentFormData = new FormData();
        uploadDocumentFormData.append("staffId", this.staffId);
        uploadDocumentFormData.append("loggedUserId", ls.get("loggedUserId"));
        uploadDocumentFormData.append("centerId", ls.get("loggedUserCenterId"));

        if (this.selectedJoiningLetter != null) {
          uploadDocumentFormData.append(
            "staffJoiningLetter",
            this.selectedJoiningLetter
          );
        }

        if (this.selectedResume != null) {
          uploadDocumentFormData.append("staffResume", this.selectedResume);
        }

        if (this.selectedResignationLetter != null) {
          uploadDocumentFormData.append(
            "staffResignationLetter",
            this.selectedResignationLetter
          );
        }
        if (this.selectedAadharCard != null) {
          uploadDocumentFormData.append(
            "staffAadharCard",
            this.selectedAadharCard
          );
        }
        if (this.selectedPanCard != null) {
          uploadDocumentFormData.append("staffPanCard", this.selectedPanCard);
        }
        if (this.selectedVoterCard != null) {
          uploadDocumentFormData.append(
            "staffVoterCard",
            this.selectedVoterCard
          );
        }
        uploadDocumentFormData.append(
          "staffJoiningLetterNameForEdit",
          this.staffJoiningLetterNameForEdit
        );

        uploadDocumentFormData.append(
          "staffResumeNameForEdit",
          this.staffResumeNameForEdit
        );

        uploadDocumentFormData.append(
          "staffResignationLetterNameForEdit",
          this.staffResignationLetterNameForEdit
        );

        uploadDocumentFormData.append(
          "staffAadharCardNameForEdit",
          this.staffAadharCardNameForEdit
        );
        uploadDocumentFormData.append(
          "staffPanCardNameForEdit",
          this.staffPanCardNameForEdit
        );
        uploadDocumentFormData.append(
          "staffVoterCardNameForEdit",
          this.staffVoterCardNameForEdit
        );

        this.$http
          .post(
            "web_edit_staff_upload_document_info",
            uploadDocumentFormData,
            this.authorizationConfig
          )
          .then(({ data }) => {
            this.isUploadDocumentFormDataProcessing = false;
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

              // Joining letter upload failed
              else if (data.responseData == 1) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_joining_letter_upload_failed")
                );
              }
              // resume upload failed
              else if (data.responseData == 2) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_resume_letter_upload_failed")
                );
              }
              // resignation upload failed
              else if (data.responseData == 3) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_resignation_letter_upload_failed")
                );
              }
              // aadhar upload failed
              else if (data.responseData == 4) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_aadhar_letter_upload_failed")
                );
              }
              // pan upload failed
              else if (data.responseData == 5) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_pan_letter_upload_failed")
                );
              }
              // voter upload failed
              else if (data.responseData == 6) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_voter_letter_upload_failed")
                );
              }
              // upload doc save success
              else if (data.responseData == 7) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(
                  this.$t("label_staff_details_updated")
                );
                this.staffJoiningLetterNameForEdit =
                  data.staffJoiningLetterName;
                this.staffResumeNameForEdit = data.staffResumeName;
                this.staffResignationLetterNameForEdit =
                  data.staffResignationLetterName;
                this.staffAadharCardNameForEdit = data.staffAadharCardName;
                this.staffPanCardNameForEdit = data.staffPanCardName;
                this.staffVoterCardNameForEdit = data.staffVoterCardName;
                this.stepperInfo = 1;
              }
              // upload doc save failed
              else if (data.responseData == 8) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
            }
          })
          .catch((error) => {
            this.isUploadDocumentFormDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
      }
    },
  },
};
</Script>

