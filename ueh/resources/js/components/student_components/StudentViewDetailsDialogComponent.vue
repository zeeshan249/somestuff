<template>
  <div>
    <v-row>
      <v-dialog
        v-model="isViewStudentDetailsDialogVisible"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
      >
        <v-card>
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
                <strong>{{$t('label.label_student_details')}}</strong>
                {{$t('label.label_company_name')}}
              </small>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn icon dark @click="isViewStudentDetailsDialogVisible = false">
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
                  <strong>{{clickedStudentDetailsViewProp.student_name}}</strong>
                </div>
                <div class="ml-4 mb-1">
                  <v-icon color="blue darken-2">mdi-cellphone-android</v-icon>
                  {{clickedStudentDetailsViewProp.student_mobile}}
                </div>
                <div class="ml-4 mb-1">
                  <v-icon color="blue darken-2">mdi-email</v-icon>
                  {{ clickedStudentDetailsViewProp.user_email_id!=null?clickedStudentDetailsViewProp.user_email_id:$t('label.label_not_updated')}}
                </div>
                <div class="ml-4 mb-1">
                  <small>
                    <strong>{{$t('label.label_address')}}</strong>
                  </small>
                </div>
                <div class="ml-5">{{clickedStudentDetailsViewProp.student_address}}</div>
                <v-row class="ml-5">
                  <div>{{clickedStudentDetailsViewProp.state_name}}</div>
                  <div class="ml-1">{{clickedStudentDetailsViewProp.student_pin}}</div>
                </v-row>

                <v-divider class="mx-4"></v-divider>

                <v-list two-line>
                  <v-list-item>
                    <v-avatar color="blue darken-2" size="36">
                      <v-icon color="white">mdi-account</v-icon>
                    </v-avatar>
                    <v-list-item-content class="ml-3">
                      <v-list-item-title>{{$t('label.label_guardian_name')}}</v-list-item-title>
                      <v-list-item-subtitle>{{clickedStudentDetailsViewProp.student_guardian_name || $t('label.label_not_updated')}}</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                  <v-list-item>
                    <v-avatar color="blue darken-2" size="36">
                      <v-icon color="white">mdi-calendar-check</v-icon>
                    </v-avatar>
                    <v-list-item-content class="ml-3">
                      <v-list-item-title>{{$t('label.label_dob')}}</v-list-item-title>
                      <v-list-item-subtitle>{{clickedStudentDetailsViewProp.student_dob}}</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>

                  <v-list-item>
                    <v-avatar color="blue darken-2" size="36">
                      <v-icon color="white">label_dob</v-icon>
                    </v-avatar>
                    <v-list-item-content class="ml-3">
                      <v-list-item-title>{{$t('label.label_qualification')}}</v-list-item-title>
                      <v-list-item-subtitle>{{clickedStudentDetailsViewProp.student_educational_qualification}}</v-list-item-subtitle>
                    </v-list-item-content>
                  </v-list-item>
                </v-list>
              </v-card>
            </v-col>
            <v-col cols="12" md="8" sm="12">
              <v-card class="m-1">
                <v-system-bar color="primary darken-2" dark>
                  <v-spacer></v-spacer>
                  <div color="white">{{$t('label.label_student_details')}}</div>
                </v-system-bar>

                <v-card class="mx-auto" outlined>
                  <v-list-item three-line>
                    <v-list-item-content>
                      <v-row class="ml-2 mb-2">
                        <div>
                          <strong>{{$t('label.label_student_in_caps')}}</strong>
                        </div>
                        <div class="ml-3">
                          <strong>{{$t('label.label_details_in_caps')}}</strong>
                        </div>
                        <v-badge
                          v-if="clickedStudentDetailsViewProp.student_status==1"
                          bordered
                          color="primary"
                          icon="mdi-lock"
                          overlap
                          class="ml-5 mb-2"
                        >
                          <v-btn class="white--text" x-small color="primary" depressed>
                            {{$t('label.label_active')}}
                            <div class="ml-2"></div>
                          </v-btn>
                        </v-badge>

                        <v-badge
                          v-if="clickedStudentDetailsViewProp.student_status==2"
                          bordered
                          color="error"
                          icon="mdi-window-close"
                          overlap
                          class="ml-5 mb-2"
                        >
                          <v-btn class="white--text" x-small color="error" depressed>
                            {{$t('label.label_certificate_request_generated')}}
                            <div class="ml-2"></div>
                          </v-btn>
                        </v-badge>

                        <v-badge
                          v-if="clickedStudentDetailsViewProp.student_status==3"
                          bordered
                          color="success"
                          icon="mdi-lock-open"
                          overlap
                          class="ml-5 mb-2"
                        >
                          <v-btn class="white--text" x-small color="success" depressed>
                            {{$t('label.label_certified')}}
                            <div class="ml-2"></div>
                          </v-btn>
                        </v-badge>
                      </v-row>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-numeric-9-plus-box</v-icon>
                        {{$t('label.label_student_code')}} : {{clickedStudentDetailsViewProp.student_code}}
                      </div>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-bank</v-icon>
                        {{$t('label.label_registration_code')}}: {{clickedStudentDetailsViewProp.student_registration_code }}
                      </div>
                      <div class="ml-4 mb-1" >
                        <v-icon color="blue darken-2">mdi-calendar</v-icon>
                        {{$t('label.label_student_course')}}: {{clickedStudentDetailsViewProp.course_name}}
                      </div>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-calendar</v-icon>
                        {{$t('label.label_certificate_request_number')}}: {{clickedStudentDetailsViewProp.student_status==1?$t('label.label_request_not_generated'):(clickedStudentDetailsViewProp.student_status==2?clickedStudentDetailsViewProp.certificate_application_number:clickedStudentDetailsViewProp.certificate_application_number)}}
                      </div>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-calendar</v-icon>
                        {{$t('label.label_certificate_number')}}: {{clickedStudentDetailsViewProp.certificate_status==1?$t('label.label_not_approved'):(clickedStudentDetailsViewProp.certificate_status==2?clickedStudentDetailsViewProp.certificate_ueh_number:$t('label.label_rejected'))}}
                      </div>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-calendar</v-icon>
                        {{$t('label.label_certified_on')}}: {{clickedStudentDetailsViewProp.certificate_status==1?$t('label.label_not_approved'):(clickedStudentDetailsViewProp.certificate_status==2?clickedStudentDetailsViewProp.certificate_approved_rejected_on:$t('label.label_rejected'))}}
                      </div>
                      <div class="ml-4 mb-1">
                        <v-icon color="blue darken-2">mdi-calendar</v-icon>
                        {{$t('label.label_registered_on')}}: {{clickedStudentDetailsViewProp.student_created_at}}
                      </div>

                      <v-row class="ml-4">
                        <v-chip class="ma-2" color="teal" text-color="white">
                          <v-avatar left>
                            <v-icon>mdi-checkbox-marked-circle</v-icon>
                          </v-avatar>
                          {{clickedStudentDetailsViewProp.student_status==1?$t('label.label_active'):(clickedStudentDetailsViewProp.student_status==2?$t('label.label_certificate_request_generated'):$t('label.label_certified'))}}
                        </v-chip>
                        <v-chip class="ma-2" color="cyan" text-color="white">
                          <v-avatar left>
                            <v-icon>mdi-calendar-check</v-icon>
                          </v-avatar>
                          {{$t('label.label_registered_on')}}: {{clickedStudentDetailsViewProp.student_created_at}}
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
                    <v-expansion-panel v-if="clickedStudentDetailsViewProp.student_status==2">
                      <v-expansion-panel-header disable-icon-rotate>
                        <template v-slot:actions>
                          <v-icon color="primary">mdi-account-plus</v-icon>
                        </template>
                        <strong>{{$t('label.label_approve_reject_certificate')}}</strong>
                      </v-expansion-panel-header>
                      <v-progress-linear
                        :active="isCertificateApprovingRejecting"
                        :indeterminate="isCertificateApprovingRejecting"
                        color="indigo darken-2"
                        rounded
                        value="100"
                      ></v-progress-linear>
                      <v-expansion-panel-content>
                        <v-container>
                          <v-row cols="12">
                            <v-col cols="12" md="8" sm="6">
                              <v-card-text>
                                <strong>{{ $t('label.label_certificate_request_number') }}</strong>
                                {{ clickedStudentDetailsViewProp.certificate_application_number }}
                              </v-card-text>
                            </v-col>
                            <v-col cols="12" md="4" sm="6">
                              <v-btn
                                :disabled="isCertificateApprovingRejecting"
                                outlined
                                color="success"
                                @click="approverejectCertificate(2)"
                              >{{$t('label.label_approve')}}</v-btn>
                                <!-- <v-btn
                                :disabled="isCertificateApprovingRejecting"
                                outlined
                                color="error"
                                @click="approverejectCertificate(3)"
                              >{{$t('label.label_reject')}}</v-btn> -->
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
                        <strong>{{$t('label.label_student_documents')}}</strong>
                      </v-expansion-panel-header>
                      <v-expansion-panel-content>
                        <v-container>
                          <v-row cols="12">
                            <v-col cols="12" md="6" sm="12">
                              <v-card
                                v-if="clickedStudentDetailsViewProp.student_document_aadhar!=null"
                              >
                                <v-card-title>
                                  <v-icon color="success" class="mr-3">mdi-credit-card</v-icon>
                                  <strong>{{$t('label.label_aadhar_card')}}</strong>
                                </v-card-title>
                                <v-img
                                  height="150"
                                  :src="getStudentAadharImage()"
                                  :lazy-src="getStudentAadharImage()"
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
                                v-if="clickedStudentDetailsViewProp.student_document_pan!=null"
                              >
                                <v-card-title>
                                  <v-icon color="success" class="mr-3">mdi-credit-card</v-icon>
                                  <strong>{{$t('label.label_pan_card')}}</strong>
                                </v-card-title>
                                <v-img
                                  height="150"
                                  :src="getStudentPanImage()"
                                  :lazy-src="getStudentPanImage()"
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
                                v-if="clickedStudentDetailsViewProp.student_document_voter_card!=null"
                              >
                                <v-card-title>
                                  <v-icon color="success" class="mr-3">mdi-credit-card</v-icon>
                                  <strong>{{$('label.label_voter_card')}}</strong>
                                </v-card-title>
                                <v-img
                                  height="150"
                                  :src="getStudentVoterCardImage()"
                                  :lazy-src="getStudentVoterCardImage()"
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
    "isViewStudentDetailsDialogVisibleProp",
    "clickedStudentDetailsViewProp"
  ],
  data() {
    return {
      companyLogo: process.env.MIX_COMANY_IMAGE_URL + "company_logo.png",

      isViewStudentDetailsDialogVisible: false,

      isAadharImageDownloading: false,
      isPanImageDownloading: false,
      isVoterImageDownloading: false,
      downloadImageUrl: "",
      //Snackbar Message
      isSnackBarVisible: true,
      snackBarMessage: "",
      //End

      isCertificateApprovingRejecting: false,
      authorizationConfig:''
    };
  },

  watch: {
    isViewStudentDetailsDialogVisibleProp(newVal) {
      this.isViewStudentDetailsDialogVisible = newVal;

    },
    isViewStudentDetailsDialogVisible(val) {
      val || this.close();
    },

  },
  created()
  {
this.authorizationConfig = {
      headers: { Authorization: "Bearer " + localStorage.getItem("token") }
    };
  },
  methods: {
    getUserProfileImage() {


      return this.clickedStudentDetailsViewProp.user_profile_image==null? process.env.MIX_USER_PROFILE_IMAGE_URL +"default.png":
      process.env.MIX_USER_PROFILE_IMAGE_URL +
        this.clickedStudentDetailsViewProp.user_profile_image;
    },
    getStudentAadharImage() {
      return this.clickedStudentDetailsViewProp.student_document_aadhar != null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedStudentDetailsViewProp.student_document_aadhar
        : "";
    },
    getStudentPanImage() {
      return this.clickedStudentDetailsViewProp.student_document_pan != null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedStudentDetailsViewProp.student_document_pan
        : "";
    },

    getStudentVoterCardImage() {
      return this.clickedStudentDetailsViewProp.student_document_voter_card !=
        null
        ? process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
            this.clickedStudentDetailsViewProp.student_document_voter_card
        : "";
    },
    close() {
      this.isViewStudentDetailsDialogVisible = false;
      this.$emit("onCloseViewStudentDetailsDialogEvent", false);
    },

    downloadImage(typeOfImage) {
      if (typeOfImage == "a") {
        this.isAadharImageDownloading = true;
        this.downloadImageUrl =
          process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedStudentDetailsViewProp.student_document_aadhar;
      }
      if (typeOfImage == "p") {
        this.isPanImageDownloading = true;
        this.downloadImageUrl =
          process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedStudentDetailsViewProp.student_document_pan;
      }
      if (typeOfImage == "v") {
        this.isVoterImageDownloading = true;
        this.downloadImageUrl =
          process.env.MIX_FRANCHISE_DOCUMENT_IMAGE_URL +
          this.clickedStudentDetailsViewProp.student_document_voter_card;
      }

      axios({
        url: this.downloadImageUrl,

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

          var fileURL = window.URL.createObjectURL(new Blob([response.data]));
          var fileLink = document.createElement("a");
          fileLink.href = fileURL;
          if (typeOfImage == "a") {
            fileLink.setAttribute(
              "download",
              this.clickedStudentDetailsViewProp.student_document_aadhar
            );
          }
          if (typeOfImage == "p") {
            fileLink.setAttribute(
              "download",
              this.clickedStudentDetailsViewProp.student_document_pan
            );
          }
          if (typeOfImage == "v") {
            fileLink.setAttribute(
              "download",
              this.clickedStudentDetailsViewProp.student_document_voter_card
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

          this.$emit("onImageDownloadFailedEvent");
        });
    },

    approverejectCertificate(certificateStatus) {
      this.isCertificateApprovingRejecting = true;
      axios
        .post("web_approve_reject_certificate", {
            certificateId:this.clickedStudentDetailsViewProp.certificate_id,
            certificateStatus:certificateStatus,
          franchiseId: this.clickedStudentDetailsViewProp.franchise_id,
          studentId: this.clickedStudentDetailsViewProp.student_id
        },this.authorizationConfig)
        .then(({ data }) => {
          this.isCertificateApprovingRejecting = false;
          this.close();
          this.$emit("onCertificateApprovedRejectedEvent", {
            isServerError: false,
            data: data
          });
        })
        .catch(error => {
          this.isCertificateApprovingRejecting = false;

          this.$emit("onCertificateApprovedRejectedEvent", {
            isServerError: false,
            data: error
          });
        });
    }
  },

};
</script>
