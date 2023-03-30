<template>
  <div>
    <v-form
      ref="approveRejectFranchiseForm"
      v-model="isApproveRejectFranchiseFormValid"
      lazy-validation
    >
      <v-dialog v-model="isApproveRejectDialogVisible" max-width="500px">
        <v-card>
          <v-progress-linear
            :active="isApproveRejectDataProcessing"
            :indeterminate="isApproveRejectDataProcessing"
            absolute
            top
            color="primary"
          ></v-progress-linear>

          <v-card-title>
            <span
              v-if="labelApproveRejectFranchiseClickedProp=='approve'"
              class="headline"
            >{{$t('label.label_approve_franchise')}}</span>
            <span
              v-if="labelApproveRejectFranchiseClickedProp=='reject'"
              class="headline"
            >{{$t('label.label_reject_franchise')}}</span>
          </v-card-title>

          <v-card-text>
            <v-container>
              <v-textarea
                outlined
                name="input-7-4"
                :label="labelRemarks"
                v-model="approveRejectRemarks"
                required
                :rules="approveRejectRemarksRules"
                clearable
                no-resize
              ></v-textarea>
            </v-container>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-scale-transition>
              <div v-if="!isApproveRejectDataProcessing" class="text-center">
                <v-btn color="blue darken-1" text @click="close">{{$t('label.label_cancel')}}</v-btn>
                <v-btn
                  v-if="labelApproveRejectFranchiseClickedProp=='approve'"
                  color="blue darken-1"
                  text
                  @click="approveRejectAppliedFranchise('1')"
                  :disabled="!isApproveRejectFranchiseFormValid"
                >{{$t('label.label_approve')}}</v-btn>
                <v-btn
                  v-if="labelApproveRejectFranchiseClickedProp=='reject'"
                  color="blue darken-1"
                  text
                  @click="approveRejectAppliedFranchise('2')"
                  :disabled="!isApproveRejectFranchiseFormValid"
                >{{$t('label.label_reject')}}</v-btn>
              </div>
            </v-scale-transition>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-form>
  </div>
</template>

<script>
export default {
  props: [
    "isApproveRejectDialogVisibleProp",
    "labelApproveRejectFranchiseClickedProp",
    "clickedFranchiseDetailsProp"
  ],
  data() {
    return {
        //Form Data
      isApproveRejectDataProcessing: false,
      isApproveRejectDialogVisible: false,
      approveRejectRemarks: "",
      labelRemarks:this.$t('label.label_remarks'),

      //End
      // Form validation & rules
      isApproveRejectFranchiseFormValid: true,
      approveRejectRemarksRules: [v => !!v || this.$t('label.label_remarks_is_required')],

      //End
      authorizationConfig: "",
    };
  },

  watch: {
    isApproveRejectDialogVisibleProp(newVal) {
      this.isApproveRejectDialogVisible = newVal;
    },
    isApproveRejectDialogVisible(val) {
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
      // Close the Dialog
    close() {
      this.isApproveRejectDialogVisible = false;
      this.approveRejectRemarks = "";
      this.$emit("onCloseApproveRejectDialogEvent", false);
    },
    //End

    // Approve Reject Franchise
    approveRejectAppliedFranchise(approveRejectStatus) {

      if (this.$refs.approveRejectFranchiseForm.validate()) {
        this.isApproveRejectDataProcessing = true;
        axios
          .post("web_approve_reject_applied_franchise", {
            clickedFranchiseId: this.clickedFranchiseDetailsProp.franchise_id,
            approveRejectStatus: approveRejectStatus,
            approveRejectBy: localStorage.getItem("loggedUserId"),
            clickedFranchiseMobileNumber: this.clickedFranchiseDetailsProp
              .franchise_mobile,
            clickedFranchiseDOB: this.clickedFranchiseDetailsProp.franchise_dob,
            clickedFranchiseName: this.clickedFranchiseDetailsProp
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
    }
  }
};
</script>
