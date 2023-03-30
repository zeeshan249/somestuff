<template>
  <v-content>
    <v-container cols="12" sm="12" md="12">
         <v-snackbar
      v-model="isSnackBarVisible"
      color="error"
      multi-line="multi-line"
      right="right"
      :timeout="3000"
      top="top"
      vertical="vertical"
    >{{ snackBarMessage }}</v-snackbar>
      <v-select
                                dense
                                outlined
                                :disabled="isDataLoading"
                                :label="labelFranchiseMemberName"
                                persistent-hint
                                :items="franchiseData.data"
                                item-text="franchise_applicant_name" item-value="franchise_id"
                                v-model="selectedFranchiseId"

                              ></v-select>
      <v-card v-if="selectedFranchiseId!=null">
        <v-tabs v-model="tab" background-color="primary accent-4" centered dark icons-and-text>
          <v-tabs-slider></v-tabs-slider>

          <v-tab>
            {{$t('label.label_certificates') }}
            <v-icon>mdi-certificate</v-icon>
          </v-tab>
        </v-tabs>
        <v-tabs-items v-model="tab">
          <v-tab-item>
            <certificate-generated-processed-rejected-master-component
            :key="selectedFranchiseId"
            :franchiseIdProps=selectedFranchiseId
            ></certificate-generated-processed-rejected-master-component>
          </v-tab-item>
        </v-tabs-items>
      </v-card>
    </v-container>
  </v-content>
</template>
<script>
export default {
  data() {
    return {

      labelFranchiseMemberName: this.$t("label.label_franchise_member_name"),
      tab: "",
      //Snackbar Message
      isSnackBarVisible: false,
      snackBarMessage: "",
      //End
      // Ec Member details
isDataLoading:false,
franchiseData:[],
selectedFranchiseId:null,
authorizationConfig: "",


    };
  },
    created()
    {
 this.authorizationConfig = {
      headers: { Authorization: "Bearer " + localStorage.getItem("token") }
    };
    this.getApprovedFranchiseData();
    },
  methods: {

 changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },

      getApprovedFranchiseData()
      {
          this.isDataLoading=true;
           axios
        .post('web_get_approved_franchise_id_name','',this.authorizationConfig)
        .then(({ data }) => {
          this.isDataLoading=false;
            this.franchiseData = data;


        })
        .catch(error => {

          this.isDataLoading=false;
          this.changeSnackBarMessage(this.$t('message.message_something_went_wrong'))


        });
      },


  },


};
</script>
