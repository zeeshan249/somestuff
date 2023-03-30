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
      :items="studentListWithIndex"
      class="elevation-1"
      item-key="student_id"
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
              <small> <strong>{{$t("label.label_active")}}</strong></small>
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
                :data="studentListDataForExcelDownload"
                :fields="studentFieldsForExcelDownload"
                :name="excelFileNameForDownload"
              > <v-icon>mdi-file-excel</v-icon></download-excel>
            </v-btn>
            <v-btn small  tile  color="red" @click="downloadStudentDetailsInPDF" icon>
              <v-icon>mdi-file-pdf</v-icon></v-btn>

          <student-view-details-dialog-component
            :isViewStudentDetailsDialogVisibleProp="isViewStudentDetailsDialogVisible"
            :clickedStudentDetailsViewProp="clickedStudentDetailsView"
            @onCloseViewStudentDetailsDialogEvent="isViewStudentDetailsDialogVisible=false"
            @onImageDownloadFailedEvent="onImageDownloadFailed"

          ></student-view-details-dialog-component>
        </v-toolbar>
      </template>
      <template v-slot:item.image="{ item }">
            <div class="p-2">
                <v-avatar>
              <v-img :src="getUserProfileImage(item.user_profile_image)" :lazy-src="getUserProfileImage(item.user_profile_image)" height="80px" width="80px">
                     <template v-slot:placeholder>
                  <v-row class="fill-height ma-0" align="center" justify="center">
                    <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                  </v-row>
                </template>
              </v-img>
                </v-avatar>
            </div>
          </template>
      <template v-slot:item.actions="{ item }">
        <v-icon medium class="mr-2" @click="viewStudentDetailsDialog(item)" color="indigo">mdi-information</v-icon>

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
    props:['franchiseIdProps'],
  data() {
    return {
      // For Sorting
      sortingOptions: {
        sortBy: ["student_name"],
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
          text: this.$t("label.label_student_code"),
          align: "center",
          sortable: false,
          value: "student_code"
        },
        {
          text: this.$t("label.label_registration_code"),
          align: "center",
          sortable: false,
          value: "student_registration_code"
        },
        {
          text: this.$t("label.label_name"),
          align: "center",
          sortable: true,
          value: "student_name"
        },
        {
          text: this.$t("label.label_mobile"),
          align: "center",
          sortable: false,
          value: "student_mobile"
        },
         {
          text: this.$t("label.label_image"),
          align: "center",
          sortable: false,
          value: "image"
        },

        { text: "Actions", value: "actions", sortable: false }
      ],
      totalItemsInDB: 0,
      studentList: [],
      // End

      // For Excel Download
      studentFieldsForExcelDownload: {
        "Student Code": "student_code",
        "Registration Code": "student_registration_code",
        "Name": "student_name",
        "Mobile": "student_mobile"
      },
      studentListDataForExcelDownload: [],
      excelFileNameForDownload:  "ActiveStudentList"+moment().format('DD/MM/YYYY')+".xls",

      // End

      // For PDF download
      studentFieldsForPDFDownload: [
        "student_code",
        "student_registration_code",
        "student_name",
        "student_mobile"
      ],

      //End


      componentUpdateKey:0,



      //Snackbar Message
      isSnackBarVisible: false,
      snackBarColor: "",
      snackBarMessage: "",
      //End


      isViewStudentDetailsDialogVisible: false,
      clickedStudentDetailsView: ""


    };
  },

  computed: {
    // For numbering the Data Table Rows
    studentListWithIndex() {
      return this.studentList.map((items, index) => ({
        ...items,
        index: index + 1
      }));
    }

    //End
  },

  methods: {

    // For Pagination
    paginate(e) {
      this.tableDataLoading = true;
      const sortBy =
        this.sortingOptions.sortBy.length == 0
          ? "student_name"
          : this.sortingOptions.sortBy[0];
      const orderBy =
        this.sortingOptions.sortDesc.length > 0 &&
        this.sortingOptions.sortDesc[0]
          ? "asc"
          : "desc";

      axios
        .get(`web_get_all_certified_student_franchise_wise_list?page=${e.page}`, {
          params: {
            per_page: e.itemsPerPage,
            sort_by: sortBy,
            order_by: orderBy,
            filter_by: this.searchText,
            franchiseId:this.franchiseIdProps
          },
           headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
        })
        .then(({ data }) => {
          this.tableDataLoading = false;
            this.studentList = data.data;
            this.studentListDataForExcelDownload = data.data;
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



    // Download PDF
    downloadStudentDetailsInPDF() {
      let headerConfig = this.studentFieldsForPDFDownload.map(key => ({
        name: key,
        prompt: key,
        width: 100,
        align: "center",
        padding: 0
      }));
      const pdf = new jsPDF();

      pdf.table(2, 3, this.studentList, headerConfig);
      pdf.save("ActiveStudentList"+moment().format('DD/MM/YYYY')+".pdf");
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


    viewStudentDetailsDialog(item) {
      this.isViewStudentDetailsDialogVisible = true;
      this.clickedStudentDetailsView = item;
    },


    getUserProfileImage(imageName) {
      return process.env.MIX_USER_PROFILE_IMAGE_URL +imageName;
    },
  }
};
</script>
