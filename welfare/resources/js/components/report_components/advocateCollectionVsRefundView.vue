<template>
  <!-- Card Start -->
  <v-container>
    <v-progress-linear
      :active="isDataProcessing"
      :indeterminate="isDataProcessing"
      height="10"
      absolute
      top
      color="primary"
      background-color="primary lighten-3"
      striped
    ></v-progress-linear>
    <v-breadcrumbs :items="breadCrumbItem">
      <template v-slot:divider>
        <v-icon>mdi-forward</v-icon>
      </template>
    </v-breadcrumbs>

    <v-row dense>
      <transition name="fade" mode="out-in">
        <v-col class="d-flex flex-column ml-2">
          <!-- Card Start -->
          <v-card outlined="">
            <v-app-bar dark color="primary">
              <v-toolbar-title color="success">Collection And Refund Report - Advocate</v-toolbar-title>
              <v-spacer></v-spacer>

            </v-app-bar>

            <v-container>

                <v-row dense>
                 <v-col cols="12" md="6">
                  <v-dialog ref="dialogStartDate" v-model="modalStartDate" :return-value.sync="selectedStartDate" persistent width="290px" >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field class="ml-5" outlined dense v-model="selectedStartDate" prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :rules="[(v) => !!v|| $t('label_required')]" >
                        <template #label>
                          {{ $t('label_start_date') }}
                          <span class="red--text">
                            <strong>{{ $t('label_star') }}</strong>
                          </span>
                        </template>
                      </v-text-field>
                    </template>
                    <v-date-picker v-model="selectedStartDate" scrollable>
                      <v-spacer></v-spacer>
                      <v-btn text color="primary" @click="modalStartDate = false">{{$t('label_cancel')}}</v-btn>
                      <v-btn text color="primary" @click="$refs.dialogStartDate.save(selectedStartDate)">{{$t('label_ok')}}</v-btn>
                    </v-date-picker>
                  </v-dialog>
                </v-col>

                <v-col cols="12" md="6">
                  <v-dialog ref="dialogEndDate" v-model="modalEndDate" :return-value.sync="selectedEndDate" width="290px" >
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field  class="ml-5" outlined dense v-model="selectedEndDate" prepend-inner-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" >
                        <template #label>{{ $t('label_end_date') }}</template>
                      </v-text-field>
                    </template>
                    <v-date-picker v-model="selectedEndDate" scrollable>
                      <v-spacer></v-spacer>
                      <v-btn text color="primary" @click="modalEndDate = false">{{$t('label_cancel')}}</v-btn>
                      <v-btn text color="primary" @click="$refs.dialogEndDate.save(selectedEndDate)" >{{$t('label_ok')}}</v-btn>
                    </v-date-picker>
                  </v-dialog>
                </v-col>
                </v-row>

                <v-row dense>
                    <v-col cols="12" md="4">
                        <v-btn  class="ml-2" dense rounded color="primary" @click="param=1; getAdvocateCollectionAndRefund($event,param);" :disabled="tableDataLoading" >Details Report</v-btn>
                    </v-col>


                     <v-col cols="12" md="4">
                        <v-btn  class="ml-2" dense rounded color="primary" @click="param=2; getAdvocateCollectionAndRefund($event,param);" :disabled="tableDataLoading" >Head Wise</v-btn>
                    </v-col>


                     <v-col cols="12" md="4">
                        <v-btn  class="ml-2" dense rounded color="primary" @click="param=3; getAdvocateCollectionAndRefund($event,param);" :disabled="tableDataLoading" >Advocate Wise</v-btn>
                    </v-col>
                </v-row>









                 <v-row dense v-if="false">
                  <v-col cols="12" class="ml-2" md="5">
                    <v-select
                      v-model="selectedRole"
                      :disabled="isRoleDataLoading"
                      :items="roleData"
                      dense
                      outlined
                      :label="lblSelectRole"
                      item-text="name"
                      item-value="name"
                      @change="isSearchByRole=true;getAllStaff($event);"
                    ></v-select>
                  </v-col>
                  <v-col cols="12" class="ml-4" md="4">
                    <v-text-field
                      outlined
                      dense
                      v-model="staffSearchCriteria"
                      :label="lblSearchStaffCriteria"
                    ></v-text-field>
                  </v-col>

                </v-row>

            </v-container>
          </v-card>
          <!-- Card End -->
        </v-col>
      </transition>
    </v-row>
    <v-row dense>
      <transition name="fade" mode="out-in">
        <v-col class="d-flex flex-column ml-2">
            <v-container class="m-0 p-0">
            <!-- Collection Entry Details Start -->
                <v-card class="m-0 p-0" max-width="100%" outlined="">
                <v-data-table
                  dense
                  :headers="tableHeader"
                  :items="dataTableRowNumbering"
                  item-key="lms_department_id"
                  class="elevation-1"
                  :loading="tableDataLoading"
                  :loading-text="tableLoadingDataText"
                  :server-items-length="totalItemsInDB"
                  :items-per-page="50"
                  @pagination="getAdvocateCollectionAndRefund(param)"
                  :footer-props="{
                            itemsPerPageOptions: [15, 30, 50,100,150],

                        }"
                >
                  <template v-slot:no-data>
                    <p
                      class="font-weight-black bold title"
                      style="color:red"
                    >{{ $t("label_no_data_found") }}</p>
                  </template>
                   <template v-slot:top>
                    <v-toolbar flat>
                      <v-toolbar-title>Collection And Refund Report - Advocate</v-toolbar-title>
                      <v-spacer></v-spacer>
                      <v-btn icon small color="teal" v-if="!tableDataLoading">
                        <download-excel
                          :data="excelData"
                          :fields="excelFields"
                          :name="excelFileName"
                        >
                          <v-icon dark>mdi-file-excel</v-icon>
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
                        <v-icon dark>mdi-file-pdf</v-icon>
                      </v-btn>
                    </v-toolbar>
                  </template>

 
                  <template slot="body.append">
                    <tr class="success--text">
                        <th class="title">Total</th>
                        <th class="title">-</th>
                        <th class="title">-</th>
                        <th class="title">{{ sumField('Total') }}</th>
                        <th class="title">-</th>
                        <th class="title">{{ sumField('refund_amount') }}</th>
                        <th class="title">-</th>
                         <th class="title">-</th>
                    </tr>
                </template>
                </v-data-table>
              </v-card>
              <!-- Collection Entry Details End -->
            </v-container>
        </v-col>
      </transition>

      <!-- Card End -->
    </v-row>

    <v-snackbar
      v-model="isSnackBarVisible"
      :color="snackBarColor"
      multi-line="multi-line"
      right="right"
      :timeout="3000"
      top="top"
      vertical="vertical"
    >{{ snackBarMessage }}</v-snackbar>
  </v-container>
</template>
<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });

//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

export default {
  props: ["userPermissionDataProps"],

  data() {
    return {
      // For Breadcrumb
      breadCrumbItem: [
        {
          text: this.$t("label_home"),
          disabled: false
        },
        {
          text: this.$t("label_report"),
          disabled: false
        },
        {
          text: this.$t("label_collection_report"),
          disabled: false
        }
      ],


      // Form Data
      selectedStartDate: new Date().toISOString().substr(0, 10),
      selectedEndDate:new Date().toISOString().substr(0, 10),
      modalStartDate:false,
      modalEndDate:false,


      lblSelectRole: this.$t("label_select_role"),
      selectedRole: "",
      isDataProcessing: false,
      staffSearchCriteria: "",
      lblSearchStaffCriteria: this.$t("label_search_staff_criteria"),
      isRoleDataLoading: false,
      roleData: [],
      isSearchByRole: false,
      authorizationConfig: "",
      param:"1",

      // Snack Bar

      isSnackBarVisible: false,
      snackBarMessage: "",
      snackBarColor: "",


    // Datatable Start
      tableDataLoading: false,
      totalItemsInDB: 0,
      tableLoadingDataText: this.$t("label_loading_data"),


      tableHeader: [
        { text: "#", value: "index", width: "5%", sortable: false },
         { text: this.$t("label_receipt_number"), value: "receipt_no", width: "25%" , sortable: false},
        { text: "Collection Date", value: "collection_created_at", width: "10%" , sortable: false},
        { text: "Collection Amount", value: "Total", width: "5%" , sortable: false},
        { text: "Refund Date", value: "refund_date", width: "10%" , sortable: false},
         { text: "Refund Amount", value: "refund_amount", width: "5%" , sortable: false},
        { text: this.$t("label_department_name"), value: "lms_department_name", width: "20%" , sortable: false},
                { text: 'Count', value: "HeadCount", width: "5%" , sortable: false},

        { text: this.$t("label_advocate"), value: "lms_user_full_name", width: "15%" , sortable: false},



      ],
      tableItems: [],
      isDepartmentDataProcessing: false,
      //Datatable End

      // For Excel Download
      excelFields: {

        "Receipt No":"receipt_no",
        "Head": "lms_department_name",
        "Advocate Name": "lms_user_full_name",
        "Collection Date": "collection_created_at",
        "Collection Amount": "Total",
        "Refund Date": "refund_date",
        "Refund Amount": "refund_amount",

      },
      excelData: [],
      excelFileName:
        "AdvocateCollectionVsRefund" + "_" + moment().format("DD/MM/YYYY") + ".xls"
    };
  },
  computed: {
    // For numbering the Data Table Rows
    dataTableRowNumbering() {
      return this.tableItems.map((items, index) => ({
        ...items,
        index: index + 1
      }));
    }

    //End
  },

  created() {
    // Token Config
    this.authorizationConfig = {
      headers: { Authorization: "Bearer " + ls.get("token") }
    };
  },

  methods: {

      //added by priyo start
      sumField(key) {
        // sum data in give key (property)
        return this.tableItems.reduce((a, b) =>  parseInt(a) + (parseInt(b[key]) || 0), 0)
    },
    // Get all Collection from DB
    getAdvocateCollectionAndRefund(e,param) {

if(param == '1')
{
     this.tableDataLoading = true;
      this.$http
        .get(`web_get_advocate_collection_and_refund_receiptwise?page=${e.page}`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            perPage: e.itemsPerPage,
             selectedStartDate : this.selectedStartDate,
             selectedEndDate: this.selectedEndDate
          },
          headers: { Authorization: "Bearer " + ls.get("token") }
        })
        .then(({ data }) => {
          this.tableDataLoading = false;
          //User Unauthorized
          if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.tableItems = data.data;
            this.totalItemsInDB = data.total;
            this.excelData = data.data;
          }
        })
        .catch(error => {
          this.tableDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

        });
        }


        else if(param == '2')
        {
     this.tableDataLoading = true;
      this.$http
        .get(`web_get_advocate_head_wise_collection_and_refund?page=${e.page}`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            perPage: e.itemsPerPage,
             selectedStartDate : this.selectedStartDate,
             selectedEndDate: this.selectedEndDate
          },
          headers: { Authorization: "Bearer " + ls.get("token") }
        })
        .then(({ data }) => {
          this.tableDataLoading = false;
          //User Unauthorized
          if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.tableItems = data.data;
            this.totalItemsInDB = data.total;
            this.excelData = data.data;
          }
        })
        .catch(error => {
          this.tableDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

        });
        }

        else if(param == '3')
        {
     this.tableDataLoading = true;
      this.$http
        .get(`web_get_advocate_wise_collection_and_refund_for_advocate?page=${e.page}`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            perPage: e.itemsPerPage,
             selectedStartDate : this.selectedStartDate,
             selectedEndDate: this.selectedEndDate
          },
          headers: { Authorization: "Bearer " + ls.get("token") }
        })
        .then(({ data }) => {
          this.tableDataLoading = false;
          //User Unauthorized
          if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.tableItems = data.data;
            this.totalItemsInDB = data.total;
            this.excelData = data.data;
          }
        })
        .catch(error => {
          this.tableDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

        });
        }
    },


  

    // Export to PDF
    savePDF() {
      const pdfDoc = new jsPDF();
      pdfDoc.autoTable({
        columns: [
          { header: "Date", dataKey: "collection_created_at" },
          { header: "Receipt No", dataKey: "receipt_no" },
          { header: "Head", dataKey: "lms_department_name" },
          { header: "LA", dataKey: "advocate_share" },
          { header: "NT", dataKey: "notary_public_share" },
          { header: "WF", dataKey: "AWC_share" }
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 }
      });
      pdfDoc.save(
        "DailyCollectionAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
      );
    }
  }
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition-duration: 0.9s;
  transition-property: opacity;
  transition-timing-function: ease;
}

.fade-enter,
.fade-leave-active {
  opacity: 0;
}
</style>

