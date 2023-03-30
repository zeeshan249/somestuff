<template >
  <div   :key="componentUpdateKey">
    <v-snackbar
      v-model="isSnackBarVisible"
      :color="snackBarColor"
      multi-line="multi-line"
      right="right"
      :timeout="3000"
      top="top"
      vertical="vertical"
    >{{ snackBarMessage }}</v-snackbar>
    <v-data-table

      :headers="tableColumnHeading"
      :items="appliedFranchiseListWithIndex"
      class="elevation-1"
      item-key="franchise_id"
      :options.sync="sortingOptions"
      :loading="tableDataLoading"
      :loading-text="tableLoadingDataText"
      @pagination="paginate"
      :server-items-length="totalItemsInDB"
      :items-per-page="5"
      :footer-props="{
                            itemsPerPageOptions: [5, 10, 15],
                            showCurrentPage: true,
                            showFirstLastPage: true,
                            firstIcon: 'mdi-arrow-collapse-left',
                            lastIcon: 'mdi-arrow-collapse-right',
                            prevIcon: 'mdi-minus',
                            nextIcon: 'mdi-plus'
                        }"
      sm
    >
      <template v-slot:top>
        <v-toolbar flat color="white">
          <v-toolbar-title  class="d-none d-lg-block">
              <small> <strong>{{$t("label.label_applied_franchise")}}</strong></small>
          </v-toolbar-title>
          <v-divider class="mx-4 d-none d-lg-block" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-text-field
            @keyup.enter="paginate"
            append-icon="mdi-magnify"
            :label="searchPlaceholder"
            single-line
            hide-details
            v-model="searchText"
          ></v-text-field>
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>


  <v-btn small  tile  color="green" icon>
              <download-excel
                :data="franchiseListDataForExcelDownload"
                :fields="franchiseFieldsForExcelDownload"
                :name="excelFileNameForDownload"
              > <v-icon>mdi-file-excel</v-icon></download-excel>
            </v-btn>
            <v-btn small  tile  color="red" @click="downloadAppliedFranchiceInPDF" icon>
              <v-icon>mdi-file-pdf</v-icon></v-btn>



          <franchise-approve-reject-dialog-component

            :isApproveRejectDialogVisibleProp="isApproveRejectDialogVisible"
            :clickedFranchiseDetailsProp="clickedFranchiseDetails"
            :labelApproveRejectFranchiseClickedProp="labelApproveRejectFranchiseClicked"
            @onCloseApproveRejectDialogEvent="isApproveRejectDialogVisible=false"
            @onApproveRejectFranchiseEvent="onApproveRejectFranchise($event)"
          ></franchise-approve-reject-dialog-component>

          <franchise-view-details-dialog-component
            :isViewFranchiseDetailsDialogVisibleProp="isViewFranchiseDetailsDialogVisible"
            :clickedFranchiseDetailsViewProp="clickedFranchiseDetailsView"
            @onCloseViewFranchiseDetailsDialogEvent="isViewFranchiseDetailsDialogVisible=false"
            @onApproveRejectFranchiseEvent="onApproveRejectFranchise($event)"
            @onImageDownloadFailedEvent="onImageDownloadFailed"
          ></franchise-view-details-dialog-component>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon medium class="mr-2" @click="viewFranchiseDetailsDialog(item)" color="indigo">mdi-information</v-icon>
        <v-icon
          class="mr-2"
          medium
          @click="approveRejectFranchiseDialog(item,'approve')"
          color="green"
        >mdi-check-circle</v-icon>
        <v-icon
          class="mr-2"
          medium
          @click="approveRejectFranchiseDialog(item,'reject')"
          color="red"
        >mdi-minus-circle</v-icon>
      </template>
      <template v-slot:no-data>
        <p
          class="font-weight-black bold title"
          style="color:indigo"
        >{{ $t("message.message_no_data_found") }}</p>
      </template>
    </v-data-table>
  </div>
</template>

<script>
import jsPDF from "jspdf";
export default {
  data() {
    return {
      // For Sorting
      sortingOptions: {
        sortBy: ["franchise_applicant_name"],
        sortDesc: [true]
      },

      //End

      //For Search
      searchText: "",
      searchPlaceholder: this.$t("placeholder.placeholder_search_name"),

      //End

      // For Data table
      tableDataLoading: false,
      tableLoadingDataText: this.$t("label.label_loading_data"),
      tableColumnHeading: [
        {
          text: this.$t("label.label_hash"),
          value: "index",
          align: "center",
          sortable: false
        },

        {
          text: this.$t("label.label_application_number"),
          align: "center",
          sortable: false,
          value: "franchise_application_number"
        },
        {
          text: this.$t("label.label_applicant_name"),
          align: "center",
          sortable: true,
          value: "franchise_applicant_name"
        },
        {
          text: this.$t("label.label_mobile"),
          align: "center",
          sortable: false,
          value: "franchise_mobile"
        },
        {
          text: this.$t("label.label_application_date"),
          align: "center",
          sortable: false,
          value: "franchise_applied_date"
        },

        { text: "Actions", value: "actions", sortable: false }
      ],
      totalItemsInDB: 0,
      appliedFranchiseList: [],
      // End

      // For Excel Download
      franchiseFieldsForExcelDownload: {
        "Application Number": "franchise_application_number",
        "Applicant Name": "franchise_applicant_name",
        "Mobile Number": "franchise_mobile",
        "Applied Date": "franchise_applied_date"
      },
      franchiseListDataForExcelDownload: [],
      excelFileNameForDownload:  "AppliedFranchiseList"+moment().format('DD/MM/YYYY')+".xls",

      // End

      // For PDF download
      franchiseFieldsForPDFDownload: [
        "franchise_application_number",
        "franchise_applicant_name",
        "franchise_mobile",
        "franchise_applied_date"
      ],

      //End

      // For Approve Reject Franchise
      labelApproveRejectFranchiseClicked: "",
      clickedFranchiseDetails: "",
      isApproveRejectDialogVisible: false,
      componentUpdateKey:0,

      // End

      //Snackbar Message
      isSnackBarVisible: false,
      snackBarColor: "",
      snackBarMessage: "",
      //End

      // For View Franchise Details
      isViewFranchiseDetailsDialogVisible: false,
      clickedFranchiseDetailsView: ""

      //End
    };
  },

  computed: {
    // For numbering the Data Table Rows
    appliedFranchiseListWithIndex() {
      return this.appliedFranchiseList.map((items, index) => ({
        ...items,
        index: index + 1
      }));
    }

    //End
  },

  methods: {

    // For Pagination
    paginate(e) {
        console.dir(this.sortingOptions);
      this.tableDataLoading = true;
      const sortBy =
        this.sortingOptions.sortBy.length == 0
          ? "franchise_applicant_name"
          : this.sortingOptions.sortBy[0];
      const orderBy =
        this.sortingOptions.sortDesc.length > 0 &&
        this.sortingOptions.sortDesc[0]
          ? "asc"
          : "desc";

      axios

        .get(`web_get_all_applied_franchise_list?page=${e.page}`, {
          params: {
            per_page: e.itemsPerPage,
            sort_by: sortBy,
            order_by: orderBy,
            filter_by: this.searchText,
          },
         headers: { Authorization: "Bearer " + localStorage.getItem("token") }
        })
        .then(({ data }) => {
          this.tableDataLoading = false;
            this.appliedFranchiseList = data.data;
            this.franchiseListDataForExcelDownload = data.data;
            this.totalItemsInDB = data.total;

        })
        .catch(error => {
          this.snackBarColor = "error";
          this.tableDataLoading = false;
          this.changeSnackBarMessage(
            this.$t("message.message_something_went_wrong")
          );
        });
    },
    // End

    // To Generate Approve Reject Francise Dialog
    approveRejectFranchiseDialog(item, labelApproveRejectFranchiseClicked) {
      this.isApproveRejectDialogVisible = true;
      this.clickedFranchiseDetails = item;
      this.labelApproveRejectFranchiseClicked = labelApproveRejectFranchiseClicked;
    },
    //End

    // Download PDF
    downloadAppliedFranchiceInPDF() {
      let headerConfig = this.franchiseFieldsForPDFDownload.map(key => ({
        name: key,
        prompt: key,
        width: 100,
        align: "center",
        padding: 0
      }));
      const pdf = new jsPDF();

      pdf.table(2, 3, this.appliedFranchiseList, headerConfig);
      pdf.save("AppliedFranchiseList"+moment().format('DD/MM/YYYY')+".pdf");
    },
    //End

    // Update the Franchise Approve/Reject in DB
    onApproveRejectFranchise(approveRejectFranchiseProcessingResponseData) {
      if (approveRejectFranchiseProcessingResponseData.isServerError == true) {
        this.snackBarColor = "error";
        this.changeSnackBarMessage(this.$t('message.message_something_went_wrong'));
      } else {
        if (approveRejectFranchiseProcessingResponseData.data.Result == "1") {
          this.snackBarColor = "success";
          this.changeSnackBarMessage( this.$t('message.message_franchise_approved'));
          this.componentUpdateKey+=1;

        } else if (
          approveRejectFranchiseProcessingResponseData.data.Result == "2"
        ) {
          this.snackBarColor = "success";
          this.changeSnackBarMessage(this.$t('message.message_franchise_rejected'));
          this.componentUpdateKey+=1;

        } else if (
          approveRejectFranchiseProcessingResponseData.data.Result == "3"
        ) {
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t('message.message_failed to_approve_franchise'));
        } else if (
          approveRejectFranchiseProcessingResponseData.data.Result == "4"
        ) {
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t('message.message_failed to_reject_franchise'));
        } else if (
          approveRejectFranchiseProcessingResponseData.data.Result == "5"
        ) {
          this.snackBarColor = "info";
          this.changeSnackBarMessage(
            this.$t('message.message_franchise_already_approved')


          );
        }
      }
    },
    //End

    // Snack Bar
    changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },
onImageDownloadFailed()
{
    this.changeSnackBarMessage(this.$t('message.message_something_went_wrong'))
},
    //End

    // To Generate the View Franchise Details Dialog
    viewFranchiseDetailsDialog(item) {
      this.isViewFranchiseDetailsDialogVisible = true;
      this.clickedFranchiseDetailsView = item;
    }
    //End
  }
};
</script>
