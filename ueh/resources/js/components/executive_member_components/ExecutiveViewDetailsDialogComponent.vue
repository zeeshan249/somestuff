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
                <strong>{{$t('label.label_executive_details')}}</strong>
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
                  <strong>{{clickedFranchiseDetailsViewProp.ec_member_applicant_name}}</strong>
                </div>
                <div class="ml-4 mb-1">
                  <v-icon color="blue darken-2">mdi-cellphone-android</v-icon>
                  {{clickedFranchiseDetailsViewProp.ec_member_mobile}}
                </div>
                <div class="ml-4 mb-1">
                  <v-icon color="blue darken-2">mdi-email</v-icon>
                  {{ clickedFranchiseDetailsViewProp.ec_member_status==1?(clickedFranchiseDetailsViewProp.user_email_id!=null?clickedFranchiseDetailsViewProp.user_email_id:$t('label.label_not_updated')):$t('label.label_not_updated') }}
                </div>
                <div class="ml-4 mb-1">
                  <small>
                    <strong>{{$t('label.label_address')}}</strong>
                  </small>
                </div>
                <div class="ml-5">{{clickedFranchiseDetailsViewProp.ec_member_address}}</div>
                <v-row class="ml-5">
                  <div
                    v-if="clickedFranchiseDetailsViewProp.ec_member_status==1"
                  >{{clickedFranchiseDetailsViewProp.state_name}}</div>
                  <div class="ml-1">{{clickedFranchiseDetailsViewProp.ec_member_pin}}</div>
                </v-row>

                <v-divider class="mx-4"></v-divider>

              </v-card>
            </v-col>
            <v-col cols="12" md="8" sm="12">
              <v-card class="m-1">
                <v-system-bar color="primary darken-2" dark>
                  <v-spacer></v-spacer>
                  <div color="white">{{$t('label.label_executive_details')}}</div>
                </v-system-bar>

                <v-card class="mx-auto" outlined>
                  <v-list-item three-line>
                    <v-list-item-content>
                      <v-row class="ml-2 mb-2">
                        <div>
                          <strong>{{$t('label.label_executive_in_caps')}}</strong>
                        </div>
                        <div class="ml-3">
                          <strong>{{$t('label.label_details_in_caps')}}</strong>
                        </div>
                        <v-badge
                          v-if="clickedFranchiseDetailsViewProp.ec_member_status==0"
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
                          v-if="clickedFranchiseDetailsViewProp.ec_member_status==2"
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
                          v-if="clickedFranchiseDetailsViewProp.ec_member_status==1"
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
                        {{$t('label.label_application_number')}} : {{clickedFranchiseDetailsViewProp.ec_member_application_number}}
                      </div>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-bank</v-icon>
                        {{$t('label.label_executive_code')}}: {{clickedFranchiseDetailsViewProp.ec_member_status==0?$t('label.label_not_approved') : (clickedFranchiseDetailsViewProp.ec_member_status==1?clickedFranchiseDetailsViewProp.ec_member_code:$t('label.label_rejected') ) }}
                      </div>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-calendar</v-icon>
                        {{$t('label.label_applied_on')}}: {{clickedFranchiseDetailsViewProp.ec_member_applied_date}}
                      </div>

                      <v-row class="ml-4">
                        <v-chip class="ma-2" color="teal" text-color="white">
                          <v-avatar left>
                            <v-icon>mdi-checkbox-marked-circle</v-icon>
                          </v-avatar>
                          {{clickedFranchiseDetailsViewProp.ec_member_status==0?$t('label.label_not_approved'):(clickedFranchiseDetailsViewProp.ec_member_status==1?$t('label.label_approved'):$t('label.label_rejected'))}}
                        </v-chip>
                        <v-chip class="ma-2" color="cyan" text-color="white">
                          <v-avatar left>
                            <v-icon>mdi-calendar-check</v-icon>
                          </v-avatar>
                          {{$t('label.label_member_since')}}: {{clickedFranchiseDetailsViewProp.ec_member_status==0?$t('label.label_not_approved'):(clickedFranchiseDetailsViewProp.ec_member_status==1?clickedFranchiseDetailsViewProp.ec_member_approved_rejected_date:$t('label.label_rejected'))}}
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
                    <v-expansion-panel v-if="clickedFranchiseDetailsViewProp.ec_member_status!=1">
                      <v-expansion-panel-header disable-icon-rotate>
                        <template v-slot:actions>
                          <v-icon color="primary">mdi-checkbox-multiple-marked-circle</v-icon>
                        </template>
                        <strong>{{clickedFranchiseDetailsViewProp.ec_member_status==0?$t('label.label_approve_pipe_reject_executive'):(clickedFranchiseDetailsViewProp.ec_member_status==1?$t('label.label_reject'):$t('label.label_approve'))}}</strong>
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
                                      v-if="clickedFranchiseDetailsViewProp.ec_member_status==0 || clickedFranchiseDetailsViewProp.ec_member_status==2"
                                      outlined
                                      color="success"
                                      @click="approveRejectAppliedFranchise('1')"
                                      :disabled="!isApproveRejectFranchiseFormValid"
                                    >{{$t('label.label_approve')}}</v-btn>
                                    <v-btn
                                      v-if="clickedFranchiseDetailsViewProp.ec_member_status==0 || clickedFranchiseDetailsViewProp.ec_member_status==1"
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


                    <v-expansion-panel>
                      <v-expansion-panel-header disable-icon-rotate>
                        <template v-slot:actions>
                          <v-icon color="primary">mdi-file-document</v-icon>
                        </template>
                        <strong>{{$t('label.label_executive_documents')}}</strong>
                      </v-expansion-panel-header>
                      <v-expansion-panel-content>
                        <v-container>
                          <v-row cols="12">
                            <v-col cols="12" md="6" sm="12">
                              <v-card
                                v-if="clickedFranchiseDetailsViewProp.ec_member_document_aadhar!=null"
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
                                v-if="clickedFranchiseDetailsViewProp.ec_member_document_pan!=null"
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
                                v-if="clickedFranchiseDetailsViewProp.ec_member_document_trade_license!=null"
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
                                v-if="clickedFranchiseDetailsViewProp.ec_member_document_voter_card!=null"
                              >
                                <v-card-title>
                                  <v-icon color="success" class="mr-3">mdi-credit-card</v-icon>
                                  <strong>{{$('label.label_voter_card')}}</strong>
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
                  <v-card v-if="isTabVisible">
                    <v-tabs
                      v-model="tab"
                      background-color="primary accent-4"
                      centered
                      dark
                      icons-and-text
                    >
                      <v-tabs-slider></v-tabs-slider>

                      <v-tab>
                        {{ $t('label.label_students') }}
                        <v-icon>mdi-human-male-female</v-icon>
                      </v-tab>

                      <v-tab>
                        {{$t('label.label_certificates') }}
                        <v-icon>mdi-certificate</v-icon>
                      </v-tab>

                      <v-tab>
                        {{$t('label.label_others') }}
                        <v-icon>mdi-account-box</v-icon>
                      </v-tab>
                    </v-tabs>
                    <v-tabs-items v-model="tab">
                      <v-tab-item>
                        <v-list three-line>
                          <template v-for="(item, index) in items_list">
                            <v-subheader v-if="item.header" :key="item.header" v-text="item.header"></v-subheader>

                            <v-divider v-else-if="item.divider" :key="index" :inset="item.inset"></v-divider>

                            <v-list-item v-else :key="item.title">
                              <v-list-item-avatar>
                                <v-img :src="item.avatar"></v-img>
                              </v-list-item-avatar>

                              <v-list-item-content>
                                <v-list-item-title v-html="item.title"></v-list-item-title>
                                <v-list-item-subtitle v-html="item.subtitle"></v-list-item-subtitle>
                              </v-list-item-content>
                            </v-list-item>
                          </template>
                        </v-list>
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
        this.clickedFranchiseDetailsViewProp.ec_member_aadhar_image,
      items_list: [
        { header: "Today" },
        {
          avatar: "https://cdn.vuetifyjs.com/images/lists/1.jpg",
          title: "Student Name",
          subtitle:
            "<span class='text--primary'>Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?"
        },
        { divider: true, inset: true },
        {
          avatar: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
          title: 'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
          subtitle:
            "<span class='text--primary'>to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend."
        },
        { divider: true, inset: true },
        {
          avatar: "https://cdn.vuetifyjs.com/images/lists/3.jpg",
          title: "Oui oui",
          subtitle:
            "<span class='text--primary'>Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?"
        },
        { divider: true, inset: true },
        {
          avatar: "https://cdn.vuetifyjs.com/images/lists/4.jpg",
          title: "Birthday gift",
          subtitle:
            "<span class='text--primary'>Trevor Hansen</span> &mdash; Have any ideas about what we should get Heidi for her birthday?"
        },
        { divider: true, inset: true },
        {
          avatar: "https://cdn.vuetifyjs.com/images/lists/5.jpg",
          title: "Recipe to try",
          subtitle:
            "<span class='text--primary'>Britta Holt</span> &mdash; We should eat this: Grate, Squash, Corn, and tomatillo Tacos."
        }
      ],
      tab: "",
      isTabVisible:false,
      isAadharImageDownloading: false,
      isPanImageDownloading: false,
      isTradeImageDownloading: false,
      isVoterImageDownloading: false,
      downloadImageUrl:'',
      //Snackbar Message
      isSnackBarVisible: true,
      snackBarMessage: "",
      //End
      authorizationConfig: "",
    };
  },

  watch: {
    isViewFranchiseDetailsDialogVisibleProp(newVal) {
      this.isViewFranchiseDetailsDialogVisible = newVal;
    },
    isViewFranchiseDetailsDialogVisible(val) {
      val || this.close();
    }
  },
    created()
    {
this.authorizationConfig = {
      headers: { Authorization: "Bearer " + localStorage.getItem("token") }
    };
    },
  methods: {
    getUserProfileImage() {
      return this.clickedFranchiseDetailsViewProp.ec_member_status == 0 || this.clickedFranchiseDetailsViewProp.ec_member_status == 2
        ? process.env.MIX_USER_PROFILE_IMAGE_URL + "default.png"
        : process.env.MIX_USER_PROFILE_IMAGE_URL +
            this.clickedFranchiseDetailsViewProp.user_profile_image;
    },
    getFranchiseAadharImage() {
      return this.clickedFranchiseDetailsViewProp.ec_member_document_aadhar !=
        null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedFranchiseDetailsViewProp.ec_member_document_aadhar
        : "";
    },
    getFranchisePanImage() {
      return this.clickedFranchiseDetailsViewProp.ec_member_document_pan != null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedFranchiseDetailsViewProp.ec_member_document_pan
        : "";
    },
    getFranchiseTradeLicenseImage() {
      return this.clickedFranchiseDetailsViewProp
        .ec_member_document_trade_license != null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedFranchiseDetailsViewProp
              .ec_member_document_trade_license
        : "";
    },
    getFranchiseVoterCardImage() {
      return this.clickedFranchiseDetailsViewProp
        .ec_member_document_voter_card != null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedFranchiseDetailsViewProp.ec_member_document_voter_card
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
          .post("web_approve_reject_applied_executive", {
            clickedFranchiseId: this.clickedFranchiseDetailsViewProp
              .ec_member_id,
            approveRejectStatus: approveRejectStatus,
            approveRejectBy: localStorage.getItem("loggedUserId"),
            clickedFranchiseMobileNumber: this.clickedFranchiseDetailsViewProp
              .ec_member_mobile,
            clickedFranchiseDOB: this.clickedFranchiseDetailsViewProp
              .ec_member_dob,
            clickedFranchiseName: this.clickedFranchiseDetailsViewProp
              .ec_member_applicant_name,
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
        this.downloadImageUrl=process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedFranchiseDetailsViewProp.ec_member_document_aadhar;
      }
      if (typeOfImage == "p") {
        this.isPanImageDownloading = true;
        this.downloadImageUrl=process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedFranchiseDetailsViewProp.ec_member_document_pan;
      }
      if (typeOfImage == "v") {
        this.isVoterImageDownloading = true;
        this.downloadImageUrl=process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedFranchiseDetailsViewProp.ec_member_document_voter_card;
      }
      if (typeOfImage == "t") {
        this.isTradeImageDownloading = true;
        this.downloadImageUrl=process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedFranchiseDetailsViewProp.ec_member_document_trade_license;
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
            this.clickedFranchiseDetailsViewProp.ec_member_document_aadhar
          );
          }
          if(typeOfImage=="p")
          {
          fileLink.setAttribute(
            "download",
            this.clickedFranchiseDetailsViewProp.ec_member_document_pan
          );
          }
          if(typeOfImage=="v")
          {
          fileLink.setAttribute(
            "download",
            this.clickedFranchiseDetailsViewProp.ec_member_document_voter_card
          );
          }
          if(typeOfImage=="t")
          {
          fileLink.setAttribute(
            "download",
            this.clickedFranchiseDetailsViewProp.ec_member_document_trade_license
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
    }
  }
};
</script>
