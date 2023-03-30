<template>
  <div>
    <v-row>
      <v-dialog
        v-model="isViewFranchiseDetailsDialogVisible"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
      >
        <v-card>
          <v-progress-linear
            :active="isApproveRejectDataProcessing"
            :indeterminate="isApproveRejectDataProcessing"
            absolute
            top
            color="white"
          ></v-progress-linear>
          <v-toolbar dark color="primary">
            <v-list-item-avatar size="48">
              <v-img :src="getUserProfileImage()" :lazy-src="getUserProfileImage()">
                <template v-slot:placeholder>
                  <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                  </v-row>
                </template>
              </v-img>
            </v-list-item-avatar>
            <v-toolbar-title>
              <small>
                <strong>{{$t('label.label_franchise_details')}}</strong>
                {{$t('label.label_company_name')}}
              </small>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn icon dark @click="isViewFranchiseDetailsDialogVisible = false">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>

          <v-row>
            <v-col cols="12" md="4" sm="12">
              <v-card class="m-1">
                <v-img height="100" :src="companyLogo"></v-img>
                <v-card-title>
                  <strong>{{$t('label.label_company_name')}}</strong>
                </v-card-title>

                <div class="ml-4 mb-1">
                  <v-icon color="blue darken-2">mdi-account</v-icon>
                  <strong>{{clickedFranchiseDetailsViewProp.franchise_applicant_name}}</strong>
                </div>
                <div class="ml-4 mb-1">
                  <v-icon color="blue darken-2">mdi-cellphone-android</v-icon>
                  {{clickedFranchiseDetailsViewProp.franchise_mobile}}
                </div>
                <div class="ml-4 mb-1">
                  <v-icon color="blue darken-2">mdi-email</v-icon>
                  {{ clickedFranchiseDetailsViewProp.franchise_status==1?(clickedFranchiseDetailsViewProp.user_email_id!=null?clickedFranchiseDetailsViewProp.user_email_id:$t('label.label_not_updated')):$t('label.label_not_updated') }}
                </div>
                <div class="ml-4 mb-1">
                  <small>
                    <strong>{{$t('label.label_address')}}</strong>
                  </small>
                </div>
                <div class="ml-5">{{clickedFranchiseDetailsViewProp.franchise_address}}</div>
                <v-row class="ml-5">
                  <div
                    v-if="clickedFranchiseDetailsViewProp.franchise_status==1"
                  >{{clickedFranchiseDetailsViewProp.state_name}}</div>
                  <div class="ml-1">{{clickedFranchiseDetailsViewProp.franchise_pin}}</div>
                </v-row>

                <v-divider class="mx-4"></v-divider>

                <v-list two-line>
                  <v-list-item>
                    <v-avatar color="blue darken-2" size="36">
                      <v-icon color="white">mdi-bank</v-icon>
                    </v-avatar>
                    <v-list-item-content class="ml-3">
                      <v-list-item-title>{{$t('label.label_business_grade')}}</v-list-item-title>
                      <v-list-item-subtitle>{{clickedFranchiseDetailsViewProp.franchise_business_grade || $t('label.label_not_updated')}}</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-avatar color="blue darken-2" size="36">
                      <v-icon color="white">mdi-account-multiple</v-icon>
                    </v-avatar>
                    <v-list-item-content class="ml-3">
                      <v-list-item-title>{{$t('label.label_total_student')}}</v-list-item-title>
                      <v-list-item-subtitle>{{clickedFranchiseDetailsViewProp.franchise_current_student_strength || $t('label.label_not_updated')}}</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-avatar color="blue darken-2" size="36">
                      <v-icon color="white">mdi-account-multiple</v-icon>
                    </v-avatar>
                    <v-list-item-content class="ml-3">
                      <v-list-item-title>{{$t('label.label_nature_of_business')}}</v-list-item-title>
                      <v-list-item-subtitle>{{clickedFranchiseDetailsViewProp.franchise_nature_of_business || $t('label.label_not_updated')}}</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-card>
            </v-col>
            <v-col cols="12" md="8" sm="12">
              <v-card class="m-1">
                <v-system-bar color="primary darken-2" dark>
                  <v-spacer></v-spacer>
                  <div color="white">{{$t('label.label_franchise_details')}}</div>
                </v-system-bar>

                <v-card class="mx-auto" outlined>
                  <v-list-item three-line>
                    <v-list-item-content>
                      <v-row class="ml-2 mb-2">
                        <div>
                          <strong>{{$t('label.label_franchise_in_caps')}}</strong>
                        </div>
                        <div class="ml-3">
                          <strong>{{$t('label.label_details_in_caps')}}</strong>
                        </div>
                        <v-badge
                          v-if="clickedFranchiseDetailsViewProp.franchise_status==0"
                          bordered
                          color="primary"
                          icon="mdi-lock"
                          overlap
                          class="ml-5 mb-2"
                        >
                          <v-btn class="white--text" x-small color="primary" depressed>
                            {{$t('label.label_applied')}}
                            <div class="ml-2"></div>
                          </v-btn>
                        </v-badge>

                        <v-badge
                          v-if="clickedFranchiseDetailsViewProp.franchise_status==2"
                          bordered
                          color="error"
                          icon="mdi-window-close"
                          overlap
                          class="ml-5 mb-2"
                        >
                          <v-btn class="white--text" x-small color="error" depressed>
                            {{$t('label.label_rejected')}}
                            <div class="ml-2"></div>
                          </v-btn>
                        </v-badge>

                        <v-badge
                          v-if="clickedFranchiseDetailsViewProp.franchise_status==1"
                          bordered
                          color="success"
                          icon="mdi-lock-open"
                          overlap
                          class="ml-5 mb-2"
                        >
                          <v-btn class="white--text" x-small color="success" depressed>
                            {{$t('label.label_approved')}}
                            <div class="ml-2"></div>
                          </v-btn>
                        </v-badge>
                      </v-row>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-numeric-9-plus-box</v-icon>
                        {{$t('label.label_application_number')}} : {{clickedFranchiseDetailsViewProp.franchise_application_number}}
                      </div>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-bank</v-icon>
                        {{$t('label.label_franchise_code')}}: {{clickedFranchiseDetailsViewProp.franchise_status==0?$t('label.label_not_approved') : (clickedFranchiseDetailsViewProp.franchise_status==1?clickedFranchiseDetailsViewProp.franchise_code:$t('label.label_rejected') ) }}
                      </div>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-calendar</v-icon>
                        {{$t('label.label_applied_on')}}: {{clickedFranchiseDetailsViewProp.franchise_applied_date}}
                      </div>

                      <v-row class="ml-4">
                        <v-chip class="ma-2" color="teal" text-color="white">
                          <v-avatar left>
                            <v-icon>mdi-checkbox-marked-circle</v-icon>
                          </v-avatar>
                          {{clickedFranchiseDetailsViewProp.franchise_status==0?$t('label.label_not_approved'):(clickedFranchiseDetailsViewProp.franchise_status==1?$t('label.label_approved'):$t('label.label_rejected'))}}
                        </v-chip>
                        <v-chip class="ma-2" color="cyan" text-color="white">
                          <v-avatar left>
                            <v-icon>mdi-calendar-check</v-icon>
                          </v-avatar>
                          {{$t('label.label_member_since')}}: {{clickedFranchiseDetailsViewProp.franchise_status==0?$t('label.label_not_approved'):(clickedFranchiseDetailsViewProp.franchise_status==1?clickedFranchiseDetailsViewProp.franchise_approved_rejected_date:$t('label.label_rejected'))}}
                        </v-chip>
                      </v-row>
                    </v-list-item-content>

                    <v-list-item-avatar tile size="80" color="grey">
                      <v-img :src="getUserProfileImage()" :lazy-src="getUserProfileImage()">
                        <template v-slot:placeholder>
                          <v-row class="fill-height ma-0" align="center" justify="center">
                            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                          </v-row>
                        </template>
                      </v-img>
                    </v-list-item-avatar>
                  </v-list-item>

                  <v-expansion-panels focusable>
                    <v-expansion-panel v-if="clickedFranchiseDetailsViewProp.franchise_status!=1">
                      <v-expansion-panel-header disable-icon-rotate>
                        <template v-slot:actions>
                          <v-icon color="primary">mdi-checkbox-multiple-marked-circle</v-icon>
                        </template>
                        <strong>{{clickedFranchiseDetailsViewProp.franchise_status==0?$t('label.label_approve_pipe_reject_franchise'):(clickedFranchiseDetailsViewProp.franchise_status==1?$t('label.label_reject'):$t('label.label_approve'))}}</strong>
                      </v-expansion-panel-header>
                      <v-expansion-panel-content>
                        <v-container>
                          <v-form
                            ref="approveRejectFranchiseForm"
                            v-model="isApproveRejectFranchiseFormValid"
                            lazy-validation
                          >
                            <v-row cols="12">
                              <v-col cols="12" md="8" sm="6">
                                <v-textarea
                                  rows="1"
                                  :label="labelRemarks"
                                  :rules="approveRejectRemarksRules"
                                  required
                                  v-model="approveRejectRemarks"
                                  clearable
                                  no-resize
                                  auto-grow
                                  value
                                ></v-textarea>
                              </v-col>
                              <v-col cols="12" md="4" sm="6">
                                <v-scale-transition>
                                  <div v-if="!isApproveRejectDataProcessing" class="text-center">
                                    <v-btn
                                      v-if="clickedFranchiseDetailsViewProp.franchise_status==0 || clickedFranchiseDetailsViewProp.franchise_status==2"
                                      outlined
                                      color="success"
                                      @click="approveRejectAppliedFranchise('1')"
                                      :disabled="!isApproveRejectFranchiseFormValid"
                                    >{{$t('label.label_approve')}}</v-btn>
                                    <v-btn
                                      v-if="clickedFranchiseDetailsViewProp.franchise_status==0 || clickedFranchiseDetailsViewProp.franchise_status==1"
                                      outlined
                                      color="error"
                                      @click="approveRejectAppliedFranchise('2')"
                                      :disabled="!isApproveRejectFranchiseFormValid"
                                    >{{ $t('label.label_reject') }}</v-btn>
                                  </div>
                                </v-scale-transition>
                              </v-col>
                            </v-row>
                          </v-form>
                        </v-container>
                      </v-expansion-panel-content>
                    </v-expansion-panel>

                    <v-expansion-panel v-if="clickedFranchiseDetailsViewProp.franchise_status==1" >
                      <v-expansion-panel-header disable-icon-rotate >
                        <template v-slot:actions>
                          <v-icon color="primary">mdi-account-plus</v-icon>
                        </template>
                        <strong>{{clickedFranchiseDetailsViewProp.franchise_ec_member_code==null?$t('label.label_assign_ec_member'):$t('label.label_ec_member_details')}}</strong>
                      </v-expansion-panel-header>
                       <v-progress-linear v-if="clickedFranchiseDetailsViewProp.franchise_ec_member_code==null"
                       :active="isECMemberDetailsLoading"
        :indeterminate="isECMemberDetailsLoading"
      color="indigo darken-2"
      rounded
      value="100"
    ></v-progress-linear>
                      <v-expansion-panel-content >
                        <v-container>
                          <v-row cols="12">
                            <v-col cols="12" md="8" sm="6">
                              <v-card-text
                                v-if="clickedFranchiseDetailsViewProp.franchise_ec_member_code!=null"
                              > <strong>{{ $t('label.label_assigned_executive') }}</strong>   {{ clickedFranchiseDetailsViewProp.ec_member_applicant_name }}</v-card-text>
                              <v-select
                                v-if="clickedFranchiseDetailsViewProp.franchise_ec_member_code==null"
                                dense
                                outlined
                                :disabled="isECMemberDetailsLoading"

                                :label="labelExecutiveMemberName"
                                persistent-hint
                                :items="ecMemberData"
                                item-text="ec_member_applicant_name" item-value="ec_member_id"
                                v-model="selectedECMemberId"

                              ></v-select>
                            </v-col>
                            <v-col cols="12" md="4" sm="6">
                              <v-btn
                              v-if="clickedFranchiseDetailsViewProp.franchise_ec_member_code==null"
                                :disabled="clickedFranchiseDetailsViewProp.franchise_ec_member_code!=null || isECMemberDetailsLoading"
                                outlined
                                color="success"
                                @click="assignECMember"
                              >{{$t('label.label_assign')}}</v-btn>
                            </v-col>
                          </v-row>
                        </v-container>
                      </v-expansion-panel-content>
                    </v-expansion-panel>
                    <v-expansion-panel>
                      <v-expansion-panel-header disable-icon-rotate>
                        <template v-slot:actions>
                          <v-icon color="primary">mdi-file-document</v-icon>
                        </template>
                        <strong>{{$t('label.label_franchise_documents')}}</strong>
                      </v-expansion-panel-header>
                      <v-expansion-panel-content>
                        <v-container>
                          <v-row cols="12">
                            <v-col cols="12" md="6" sm="12">
                              <v-card
                                v-if="clickedFranchiseDetailsViewProp.franchise_document_aadhar!=null"
                              >
                                <v-card-title>
                                  <v-icon color="success" class="mr-3">mdi-credit-card</v-icon>
                                  <strong>{{$t('label.label_aadhar_card')}}</strong>
                                </v-card-title>
                                <v-img
                                  height="150"
                                  :src="getFranchiseAadharImage()"
                                  :lazy-src="getFranchiseAadharImage()"
                                >
                                  <template v-slot:placeholder>
                                    <v-row class="fill-height ma-0" align="center" justify="center">
                                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                    </v-row>
                                  </template>
                                </v-img>
                                <v-card-actions>
                                  <v-spacer></v-spacer>
                                  <v-btn
                                    icon
                                    v-if="!isAadharImageDownloading"
                                    @click="downloadImage('a')"
                                  >
                                    <v-icon>mdi-cloud-download</v-icon>
                                  </v-btn>
                                  <v-progress-circular
                                    v-if="isAadharImageDownloading"
                                    :size="50"
                                    color="primary"
                                    indeterminate
                                  ></v-progress-circular>

                                </v-card-actions>
                              </v-card>
                            </v-col>
                            <v-col cols="12" md="6" sm="12">
                              <v-card
                                v-if="clickedFranchiseDetailsViewProp.franchise_document_pan!=null"
                              >
                                <v-card-title>
                                  <v-icon color="success" class="mr-3">mdi-credit-card</v-icon>
                                  <strong>{{$t('label.label_pan_card')}}</strong>
                                </v-card-title>
                                <v-img
                                  height="150"
                                  :src="getFranchisePanImage()"
                                  :lazy-src="getFranchisePanImage()"
                                >
                                  <template v-slot:placeholder>
                                    <v-row class="fill-height ma-0" align="center" justify="center">
                                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                    </v-row>
                                  </template>
                                </v-img>
                                <v-card-actions>
                                  <v-spacer></v-spacer>
                                   <v-btn
                                    icon
                                    v-if="!isPanImageDownloading"
                                    @click="downloadImage('p')"
                                  >
                                    <v-icon>mdi-cloud-download</v-icon>
                                  </v-btn>
                                  <v-progress-circular
                                    v-if="isPanImageDownloading"
                                    :size="50"
                                    color="primary"
                                    indeterminate
                                  ></v-progress-circular>

                                </v-card-actions>
                              </v-card>
                            </v-col>
                            <v-col cols="12" md="6" sm="12">
                              <v-card
                                v-if="clickedFranchiseDetailsViewProp.franchise_document_trade_license!=null"
                              >
                                <v-card-title>
                                  <v-icon color="success" class="mr-3">mdi-credit-card</v-icon>
                                  <strong>{{$t('label.label_trade_license')}}</strong>
                                </v-card-title>
                                <v-img
                                  height="150"
                                  :src="getFranchiseTradeLicenseImage()"
                                  :lazy-src="getFranchiseTradeLicenseImage()"
                                >
                                  <template v-slot:placeholder>
                                    <v-row class="fill-height ma-0" align="center" justify="center">
                                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                    </v-row>
                                  </template>
                                </v-img>
                                <v-card-actions>
                                  <v-spacer></v-spacer>
                                  <v-btn
                                    icon
                                    v-if="!isTradeImageDownloading"
                                    @click="downloadImage('t')"
                                  >
                                    <v-icon>mdi-cloud-download</v-icon>
                                  </v-btn>
                                  <v-progress-circular
                                    v-if="isTradeImageDownloading"
                                    :size="50"
                                    color="primary"
                                    indeterminate
                                  ></v-progress-circular>
                                </v-card-actions>
                              </v-card>
                            </v-col>
                            <v-col cols="12" md="6" sm="12">
                              <v-card
                                v-if="clickedFranchiseDetailsViewProp.franchise_document_voter_card!=null"
                              >
                                <v-card-title>
                                  <v-icon color="success" class="mr-3">mdi-credit-card</v-icon>
                                  <strong>{{$t('label.label_voter_card')}}</strong>
                                </v-card-title>
                                <v-img
                                  height="150"
                                  :src="getFranchiseVoterCardImage()"
                                  :lazy-src="getFranchiseVoterCardImage()"
                                >
                                  <template v-slot:placeholder>
                                    <v-row class="fill-height ma-0" align="center" justify="center">
                                      <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                    </v-row>
                                  </template>
                                </v-img>
                                <v-card-actions>
                                  <v-spacer></v-spacer>
                                  <v-btn
                                    icon
                                    v-if="!isVoterImageDownloading"
                                    @click="downloadImage('v')"
                                  >
                                    <v-icon>mdi-cloud-download</v-icon>
                                  </v-btn>
                                  <v-progress-circular
                                    v-if="isVoterImageDownloading"
                                    :size="50"
                                    color="primary"
                                    indeterminate
                                  ></v-progress-circular>
                                </v-card-actions>
                              </v-card>
                            </v-col>
                          </v-row>
                        </v-container>
                      </v-expansion-panel-content>
                    </v-expansion-panel>
                  </v-expansion-panels>

                  <!-- tab start -->
                  <v-card v-if="clickedFranchiseDetailsViewProp.franchise_status==1">
                    <v-tabs v-model="tab" background-color="primary accent-4" centered dark icons-and-text >
                      <v-tabs-slider></v-tabs-slider>
                      <v-tab>
                        {{ $t('label.label_students') }}
                        <v-icon>mdi-human-male-female</v-icon>
                      </v-tab>

                      <v-tab>
                        {{$t('label.label_certificates') }}
                        <v-icon>mdi-certificate</v-icon>
                      </v-tab>

                    </v-tabs>
                    <v-tabs-items v-model="tab">
                      <v-tab-item>
                      <student-active-certified-master-component :franchiseIdProps=this.clickedFranchiseDetailsViewProp.franchise_id
                      ></student-active-certified-master-component>
                      </v-tab-item>
                       <v-tab-item>
                      <certificate-generated-processed-rejected-master-component :franchiseIdProps=this.clickedFranchiseDetailsViewProp.franchise_id
                      ></certificate-generated-processed-rejected-master-component>
                      </v-tab-item>
                    </v-tabs-items>


                  </v-card>
                  <!-- tab End -->
                </v-card>
              </v-card>
            </v-col>
          </v-row>
        </v-card>
      </v-dialog>
    </v-row>
    <!-- End -->
  </div>

</template>

<script>
export default {
  props: [
    "isViewFranchiseDetailsDialogVisibleProp",
    "clickedFranchiseDetailsViewProp"
  ],
  data() {
    return {
      labelRemarks: this.$t("label.label_remarks"),
      labelExecutiveMemberName: this.$t("label.label_executive_member_name"),
      isApproveRejectDataProcessing: false,
      companyLogo: process.env.MIX_COMANY_IMAGE_URL + "company_logo.png",

      isViewFranchiseDetailsDialogVisible: false,
      approveRejectRemarks: "",
      isApproveRejectFranchiseFormValid: true,
      approveRejectRemarksRules: [
        v => !!v || this.$t("label.label_remarks_is_required")
      ],
      franchiseAadharImage:
        process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
        this.clickedFranchiseDetailsViewProp.franchise_aadhar_image,

      tab: "",
      isAadharImageDownloading: false,
      isPanImageDownloading: false,
      isTradeImageDownloading: false,
      isVoterImageDownloading: false,
      downloadImageUrl:'',
      //Snackbar Message
      isSnackBarVisible: true,
      snackBarMessage: "",
      //End
      // Ec Member details
isECMemberDetailsLoading:false,
ecMemberData:[],
selectedECMemberId:null,
authorizationConfig: "",


    };
  },
    created()
    {
 this.authorizationConfig = {
      headers: { Authorization: "Bearer " + localStorage.getItem("token") }
    };
    },
  watch: {
    isViewFranchiseDetailsDialogVisibleProp(newVal) {
      this.isViewFranchiseDetailsDialogVisible = newVal;
      this.getECMemberData();
    },
    isViewFranchiseDetailsDialogVisible(val) {
      val || this.close();
    }
  },
  methods: {
    getUserProfileImage() {

      return this.clickedFranchiseDetailsViewProp.franchise_status == 0 || this.clickedFranchiseDetailsViewProp.franchise_status == 2
        ? process.env.MIX_USER_PROFILE_IMAGE_URL + "default.png"
        : process.env.MIX_USER_PROFILE_IMAGE_URL +
            this.clickedFranchiseDetailsViewProp.user_profile_image;
    },
    getFranchiseAadharImage() {
      return this.clickedFranchiseDetailsViewProp.franchise_document_aadhar !=
        null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedFranchiseDetailsViewProp.franchise_document_aadhar
        : "";
    },
    getFranchisePanImage() {
      return this.clickedFranchiseDetailsViewProp.franchise_document_pan != null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedFranchiseDetailsViewProp.franchise_document_pan
        : "";
    },
    getFranchiseTradeLicenseImage() {
      return this.clickedFranchiseDetailsViewProp
        .franchise_document_trade_license != null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedFranchiseDetailsViewProp
              .franchise_document_trade_license
        : "";
    },
    getFranchiseVoterCardImage() {
      return this.clickedFranchiseDetailsViewProp
        .franchise_document_voter_card != null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedFranchiseDetailsViewProp.franchise_document_voter_card
        : "";
    },
    close() {
      this.isViewFranchiseDetailsDialogVisible = false;
      this.approveRejectRemarks = "";
      this.$emit("onCloseViewFranchiseDetailsDialogEvent", false);
    },
    approveRejectAppliedFranchise(approveRejectStatus) {
      if (this.$refs.approveRejectFranchiseForm.validate()) {
        this.isApproveRejectDataProcessing = true;
        axios
          .post("web_approve_reject_applied_franchise", {
            clickedFranchiseId: this.clickedFranchiseDetailsViewProp
              .franchise_id,
            approveRejectStatus: approveRejectStatus,
            approveRejectBy: localStorage.getItem("loggedUserId"),
            clickedFranchiseMobileNumber: this.clickedFranchiseDetailsViewProp
              .franchise_mobile,
            clickedFranchiseDOB: this.clickedFranchiseDetailsViewProp
              .franchise_dob,
            clickedFranchiseName: this.clickedFranchiseDetailsViewProp
              .franchise_applicant_name,
            approveRejectRemarks: this.approveRejectRemarks
          },this.authorizationConfig)
          .then(({ data }) => {
            this.isApproveRejectDataProcessing = false;
            this.close();

            this.$emit("onApproveRejectFranchiseEvent", {
              isServerError: false,
              data: data
            });
          })
          .catch(error => {
            this.isApproveRejectDataProcessing = false;
            this.close();
            this.$emit("onApproveRejectFranchiseEvent", {
              isServerError: true,
              data: error
            });
          });
      }
    },

    downloadImage(typeOfImage) {
      if (typeOfImage == "a") {
        this.isAadharImageDownloading = true;
        this.downloadImageUrl= process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedFranchiseDetailsViewProp.franchise_document_aadhar;
      }
      if (typeOfImage == "p") {
        this.isPanImageDownloading = true;
        this.downloadImageUrl= process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedFranchiseDetailsViewProp.franchise_document_pan;
      }
      if (typeOfImage == "v") {
        this.isVoterImageDownloading = true;
        this.downloadImageUrl= process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedFranchiseDetailsViewProp.franchise_document_voter_card;
      }
      if (typeOfImage == "t") {
        this.isTradeImageDownloading = true;
        this.downloadImageUrl= process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedFranchiseDetailsViewProp.franchise_document_trade_license;
      }

      axios({
        url:this.downloadImageUrl,

        method: "GET",
        responseType: "blob",
         headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
      })
        .then(response => {
          if (typeOfImage == "a") {
            this.isAadharImageDownloading = false;
          }
          if (typeOfImage == "p") {
            this.isPanImageDownloading = false;
          }
          if (typeOfImage == "v") {
            this.isVoterImageDownloading = false;
          }
          if (typeOfImage == "t") {
            this.isTradeImageDownloading = false;
          }
          var fileURL = window.URL.createObjectURL(new Blob([response.data]));
          var fileLink = document.createElement("a");
          fileLink.href = fileURL;
          if(typeOfImage=="a")
          {
          fileLink.setAttribute(
            "download",
            this.clickedFranchiseDetailsViewProp.franchise_document_aadhar
          );
          }
          if(typeOfImage=="p")
          {
          fileLink.setAttribute(
            "download",
            this.clickedFranchiseDetailsViewProp.franchise_document_pan
          );
          }
          if(typeOfImage=="v")
          {
          fileLink.setAttribute(
            "download",
            this.clickedFranchiseDetailsViewProp.franchise_document_voter_card
          );
          }
          if(typeOfImage=="t")
          {
          fileLink.setAttribute(
            "download",
            this.clickedFranchiseDetailsViewProp.franchise_document_trade_license
          );
          }
          document.body.appendChild(fileLink);
          fileLink.click();
        })
        .catch(error => {
          if (typeOfImage == "a") {
            this.isAadharImageDownloading = false;
          }
          if (typeOfImage == "p") {
            this.isPanImageDownloading = false;
          }
          if (typeOfImage == "v") {
            this.isVoterImageDownloading = false;
          }
          if (typeOfImage == "t") {
            this.isTradeImageDownloading = false;
          }
         this.$emit('onImageDownloadFailedEvent')
        });
    },

      getECMemberData()
      {
          this.isECMemberDetailsLoading=true;
           axios
        .post('web_get_ec_member_list_not_assigned_to_franchise', {
            franchiseId:this.clickedFranchiseDetailsViewProp.franchise_id
        },this.authorizationConfig)
        .then(({ data }) => {
          this.isECMemberDetailsLoading=false;
            this.ecMemberData = data;


        })
        .catch(error => {

          this.isECMemberDetailsLoading=false;
          this.close();
            this.$emit('onECMemberDataLoadFailedEvent');

        });
      },

assignECMember()
{

    this.isECMemberDetailsLoading=true;
           axios
        .post('web_assign_ec_member_to_franchise', {
            franchiseId:this.clickedFranchiseDetailsViewProp.franchise_id,
            ecMemberId:this.selectedECMemberId,
        },this.authorizationConfig)
        .then(({ data }) => {
          this.isECMemberDetailsLoading=false;
            this.close();
 this.$emit('onECMemberAssignedEvent',{isServerError:false,data:data});

        })
        .catch(error => {

          this.isECMemberDetailsLoading=false;

            this.$emit('onECMemberAssignedEvent',{isServerError:false,data:error});

        });
},
  },


};
</script>
