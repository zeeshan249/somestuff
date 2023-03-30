
<template>

 <v-container>
      <v-progress-linear
      :active="isRoleDataProcessing"
      :indeterminate="isRoleDataProcessing"
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


 <v-form ref="saveCollectionForm" v-model="isSaveCollectionFormValid" lazy-validation>

    <v-row align="center" justify="space-around" dense >
         <v-btn depressed color="primary"  @click="CollectionEntry()">Collection Entry</v-btn>
        <v-btn depressed color="primary"   @click="RefundEntry()">Advocate Refund Entry</v-btn>
        <v-btn depressed color="primary"   @click="RefundScan()">Advocate Refund Scan</v-btn>
        <v-btn depressed color="primary"   @click="NotaryRefundScan()">Notary Refund Scan</v-btn>
    </v-row>



    <v-row>
        <v-col cols="12">
             <v-card max-width="100%" class="mx-auto" outlined="">
    <v-app-bar dark color="primary" >
      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <v-toolbar-title>Advocate Refund Entry</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon><v-icon>mdi-magnify</v-icon></v-btn>
    </v-app-bar>

    <v-container>




        <v-row>
            <v-col cols="12" md="5">
                <v-row dense="">
         <v-col cols="12" class="pl-5 pr-5">
           <v-autocomplete  v-if=false
                    dense
                    v-model="selectedDepartmentId"
                    :items="departmentItems"
                    :disabled="isDepartmentDataLoading"
                    item-text= "Head"
                    item-value="lms_department_id"
                    chips
                    :rules="[(v) => !!v|| $t('label_required')]"
                    @change="dispayShareInfo()"

                  >
                    <template #label>{{ $t('label_select_head') }}</template>
                  </v-autocomplete>
      </v-col>

       <v-col cols="12" class="pl-5 pr-5">
           <v-autocomplete
                    dense v-model="selectedAdvocateId" :items="advocateNameItems" :disabled="isDepartmentDataLoading"
                     @change="getAllPendingRefundForAdvocate($event);"
                    item-text="AdvocateName" item-value="lms_user_id" chips  :rules="[(v) => !!v|| $t('label_required')]">
                    <template #label>{{ $t('label_select_advocate') }}</template>
                  </v-autocomplete>
      </v-col>
    </v-row>
            </v-col>
            <v-col cols="12" md="7">
                    <v-data-table dense :headers="tableHeader" :items="dataTableRowNumbering" item-key="lms_department_id" class="elevation-1"
                  :loading="tableDataLoading" :loading-text="tableLoadingDataText" :server-items-length="totalItemsInDB" :items-per-page="50"
                  @pagination="getAllPendingRefundForAdvocate" :footer-props="{ itemsPerPageOptions: [15, 30, 50,100,150], }" hide-default-footer
                  >
                  <template v-slot:no-data> <p class="font-weight-black bold title" style="color:red" >{{ $t("label_no_data_found") }}</p> </template>
                  <template v-slot:item.actions="{ item }">
                    <v-icon v-permission="'Edit Department'"  class="mr-2"  @click="updateRefund(item)" color="primary">mdi-arrow-left-bold-circle</v-icon>
                 </template>

                  <template slot="body.append">
                    <tr class="success--text">
                        <th class="title">Total</th>
                        <th class="title"></th>
                        <th class="title"></th>
                        <th class="title"></th>
                        <th class="title">{{ sumField('collection_amount') }}</th>

                    </tr>
                </template>
                </v-data-table>
            </v-col>

        </v-row>


    </v-container>
    </v-card>
        </v-col>
        <!-- Collection Entry Details Start -->
        <v-col cols="12" md="12">
                <v-card class="mx-auto" max-width="100%">
                <div  >
                <v-data-table
                  dense
                  :headers="tableHeaderRefundCompleted"
                :items="dataTableRowNumbering_Refund_completed"
                  item-key="lms_department_id"
                  class="elevation-1"

                  :items-per-page="150"
                    @pagination="getAllCompletedRefundForAdvocate"
                  :footer-props="{
                            itemsPerPageOptions: [150, 300, 500,1000,1500],

                        }"
                >
                  <template v-slot:no-data>
                    <p
                      class="font-weight-black bold title"
                      style="color:red"
                    >{{ $t("label_no_data_found") }}</p>
                  </template>
                  <template v-slot:item.collection_is_active="{ item }">
                    <v-chip
                      x-small
                      :color="getDepartmentStatusColor(item.collection_is_active)"
                      dark
                    >{{ item.collection_is_active }}</v-chip>
                  </template>
                  <template v-slot:top>
                    <v-toolbar flat>
                      <v-toolbar-title>Refund Details - LA Wise</v-toolbar-title>
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

                  <template v-slot:item.actions="{ item }">
                    <v-icon
                      v-permission="'Edit Department'"
                      small
                      class="mr-2"
                      @click="editDepartment(item)"
                      color="primary"
                    >mdi-pencil</v-icon>

                    <v-icon v-if="item.collection_is_active=='Active'"
                      v-permission="'Edit Department'"
                      small
                      color="error"
                      @click="disableDepartment(item)"
                    >mdi-delete</v-icon>
                    <v-icon v-if="item.collection_is_active=='Inactive'"
                      v-permission="'Edit Department'"
                      small
                      color="success"
                      @click="disableDepartment(item)"
                    >mdi-check-circle</v-icon>
                  </template>


                  <template slot="body.append">
                    <tr class="success--text">
                        <th class="title"></th>
                          <th class="title">Refunded</th>
                        <th class="title"></th>
                        <th class="title"></th>
                        <th class="title"></th>
                        <th class="title">{{ sumField_refund_completed('collection_amount') }}</th>
                    </tr>
                </template>
                </v-data-table>
                </div>
              </v-card>
              <!-- Collection Entry Details End -->
        </v-col>
    </v-row>
 </v-form>

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
import VueBarcode from 'vue-barcode';
//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";

  export default {
      components: {
    'barcode': VueBarcode
  },
      props: ["userPermissionDataProps", "staffDataProps"],
    data () {
      return {
           breadCrumbItem: [
        {
          text: this.$t("label_home"),
          disabled: false
        },
        {
          text: this.$t("label_entry"),
          disabled: false
        },
        {
          text: this.$t("label_refund_entry"),
          disabled: false
        }
      ],
      authorizationConfig:"",
      selectedDepartmentId:"",
      departmentItems: [],
       selectedAdvocateId:"",
      advocateNameItems: [],
      isDepartmentDataLoading: false,
      isSaveCollectionFormDataProcessing: false,
      isSaveCollectionFormValid: true,
      welfareTableShare :"",
      advocateTableShare :"",
      notaryPublicTableShare:"",
      short_code:"",
      editCollectionId: "",
      isSaveEditClicked: 1,
      refund_id:"",
      isRoleDataProcessing: false,
      collection_amount:"",

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
        { text: this.$t("label_collection_date"), value: "collection_created_at", width: "25%" , sortable: false},
        { text: this.$t("label_receipt_number"), value: "receipt_no", width: "20%" , sortable: false},

        { text: this.$t("label_department_name"), value: "lms_department_name", width: "40%" , sortable: false},
        { text: this.$t("label_LA_name"), value: "collection_amount", width: "5%" , sortable: false},

        {text: this.$t("label_actions"),value: "actions",sortable: false,width: "5%",align: "middle"}
      ],
       tableHeaderRefundCompleted: [
        { text: "#", value: "index", width: "5%", sortable: false },
        { text: "Refund Date", value: "refund_date", width: "25%" , sortable: false},
         { text: "Refund To", value: "lms_user_full_name", width: "25%" , sortable: false},
        { text: this.$t("label_receipt_number"), value: "receipt_no", width: "20%" , sortable: false},

        { text: this.$t("label_department_name"), value: "lms_department_name", width: "40%" , sortable: false},
        { text: this.$t("label_LA_name"), value: "collection_amount", width: "5%" , sortable: false},

        {text: this.$t("label_actions"),value: "actions",sortable: false,width: "5%",align: "middle"}
      ],

      tableItems: [], tableItems_completed_refund: [],
      isDepartmentDataProcessing: false,
      //Datatable End

      // For Excel Download
      excelFields: {
        "Head": "lms_department_name",
        "Advocate Name": "lms_user_full_name",
        "Receipt": "receipt_no",
        "Refund": "collection_amount",
        "Date": "refund_date",

      },
      excelData: [],
      excelFileName:
        "DailyRefundExcel" + "_" + moment().format("DD/MM/YYYY") + ".xls"


      }
    },
     computed: {
    // For numbering the Data Table Rows
    dataTableRowNumbering() {
      return this.tableItems.map((items, index) => ({
        ...items,
        index: index + 1
      }));
    },

    // For numbering the Data Table Rows for completed refund
    dataTableRowNumbering_Refund_completed() {
      return this.tableItems_completed_refund.map((items, index) => ({
        ...items,
        index: index + 1
      }));
    }

    //End
  },
    created() {

    // Get Active department
    this.getAllActiveDepartment();
    // Get Advocate Details
    this.getAllActiveAdvocate();


    // Token Config
    this.authorizationConfig = {
      headers: { Authorization: "Bearer " + ls.get("token") },
    };

  },
    methods:{

    CollectionEntry() {this.$router.push({name: "DailyCollectionEntry"});},
    RefundEntry() {this.$router.push({name: "DailyRefundEntry"});},
    RefundScan() {this.$router.push({name: "DailyRefundEntryByNumber"});},
        NotaryRefundScan() {this.$router.push({name: "RefundEntryNotary"});},



sumField(key) {
        // sum data in give key (property)
        return this.tableItems.reduce((a, b) =>  parseInt(a) + (parseInt(b[key]) || 0), 0)
    },
    sumField_refund_completed(key) {
        // sum data in give key (property)
        return this.tableItems_completed_refund.reduce((a, b) =>  parseInt(a) + (parseInt(b[key]) || 0), 0)
    },
 print () {
      // Pass the element id here
      this.$htmlToPaper('printMe');
      window.print();
    },

        // Department Status Color
    getDepartmentStatusColor(is_department_acive) {
      if (is_department_acive == "Active") return "success";
      else return "error";
    },
    // Edit Department Name

    updateRefund(item) {
      this.refund_id = item.refund_id;
      this.collection_amount= item.collection_amount;

      this.isRoleDataProcessing = true;
        this.$http
          .post(
            "update_refund_by_advocate",
            {
              refund_id: this.refund_id,
              collection_amount : this.collection_amount,

            },
            this.authorizationConfig
          )
          .then(({ data }) => {
              console.log("data val" + data.responseData);
            this.isRoleDataProcessing = false;
            //User Unauthorized
             if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
              this.$store.dispatch("actionUnauthorizedLogout");
            } else {
              // Role Disabled
              if (data.responseData == 1) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_role_status_changed"));
                this.getAllPendingRefundForAdvocate(event);
                this.getAllCompletedRefundForAdvocate(event);
              }
              // Role Disabled failed
              else if (data.responseData == 2) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
            }
          })
          .catch(error => {
            this.isRoleDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
          });
   },


    // Export to PDF
    savePDF() {
      const pdfDoc = new jsPDF();
      pdfDoc.autoTable({
        columns: [
          { header: "Department", dataKey: "lms_department_name" },
          { header: "Status", dataKey: "collection_is_active" }
        ],
        body: this.tableItems,
        //styles: { fillColor: [255, 0, 0] },
        // columnStyles: { 0: { halign: 'center', fillColor: [0, 255, 0] } },
        margin: { top: 10 }
      });
      pdfDoc.save(
        "DailyCollectionAsPDF" + "_" + moment().format("DD/MM/YYYY") + ".pdf"
      );
    },
         // Change Snack bar message
    changeSnackBarMessage(data) {
      this.isSnackBarVisible = true;
      this.snackBarMessage = data;
    },
        // Get all pending refund by advocate from DB
    getAllPendingRefundForAdvocate(e) {
      this.tableDataLoading = true;

      this.$http
        .get(`web_get_all_pending_refund_advocate?page=${e.page}`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            perPage: e.itemsPerPage,
            selectedAdvocateId: this.selectedAdvocateId,
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

          }
        })
        .catch(error => {
          this.tableDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

        });
    },

// Get all completed refund by advocate from DB
    getAllCompletedRefundForAdvocate(e) {
      this.tableDataLoading = true;

      this.$http
        .get(`web_get_all_completed_refund_advocate?page=${e.page}`, {
          params: {
            centerId: ls.get("loggedUserCenterId"),
            perPage: e.itemsPerPage,
            selectedAdvocateId: this.selectedAdvocateId,
          },
          headers: { Authorization: "Bearer " + ls.get("token") }
        })
        .then(({ data }) => {
          this.tableDataLoading = false;
          //User Unauthorized
          if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
            this.$store.dispatch("actionUnauthorizedLogout");
          } else {
            this.tableItems_completed_refund = data.data;
            this.totalItemsInDB = data.total;
            this.excelData = data.data;
          }
        })
        .catch(error => {
          this.tableDataLoading = false;
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
            centerId: ls.get("loggedUserCenterId")
          },
          headers: { Authorization: "Bearer " + ls.get("token") }
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
        .catch(error => {
          this.isDepartmentDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },


    // Get all active Advocate
    getAllActiveAdvocate() {
      this.isDepartmentDataLoading = true;
      this.$http
        .get(`web_get_active_advocate_refund_eligble_without_pagination`, {
          params: {
            centerId: ls.get("loggedUserCenterId")
          },
          headers: { Authorization: "Bearer " + ls.get("token") }
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
            this.advocateNameItems = data;
          }
        })
        .catch(error => {
          this.isDepartmentDataLoading = false;
          this.snackBarColor = "error";
          this.changeSnackBarMessage(this.$t("label_something_went_wrong"));
        });
    },
// Save Department To DB after validation
    saveCollection($event) {
      if (this.$refs.saveCollectionForm.validate()) {
        this.isSaveCollectionFormDataProcessing = true;
    let postData;
        if (this.isSaveEditClicked == 1) {
          postData = {
            selectedDepartmentId: this.selectedDepartmentId,
            departmentName: this.departmentName,
            advocateShare: this.advocateTableShare,
            NotaryPublicShare: this.notaryPublicTableShare,
            AWCShare: this.welfareTableShare,
            selectedAdvocateId: this.selectedAdvocateId,
            short_code: this.short_code,
            centerId: ls.get("loggedUserCenterId"),
            loggedUserId:ls.get("loggedUserId"),
            isSaveEditClicked: 1,

          };
        }
           else {
          postData = {
              selectedAdvocateId: this.selectedAdvocateId,
              selectedDepartmentId: this.selectedDepartmentId,
            departmentName: this.departmentName,
            advocateShare: this.advocateTableShare,
            NotaryPublicShare: this.notaryPublicTableShare,
            AWCShare  : this.welfareTableShare ,
            editCollectionId: this.editCollectionId,
            isSaveEditClicked: 0,
            centerId: ls.get("loggedUserCenterId"),
             loggedUserId:ls.get("loggedUserId")
          };
        }

        this.$http
          .post("save_daily_collection_details", postData, this.authorizationConfig)
          .then(({ data }) => {
              console.log(data)
            this.isSaveCollectionFormDataProcessing = false;
            //User Unauthorized
             if (data.error == "Unauthorized" || data.permissionError=="Unauthorized") {
              this.$store.dispatch("actionUnauthorizedLogout");
            } else {
              // Server side validation fails
              if (data.responseData == 0) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(data.error);
              }
              // Department Exists
              else if (data.responseData == 1) {
                this.snackBarColor = "info";
                this.changeSnackBarMessage(this.$t("label_department_exists"));
              }
              // Department Saved
              else if (data.responseData == 2) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_collection_saved"));
                this.getAllCollection(event);
                this.isSaveEditClicked = 1;
                this.selectedDepartmentId="";
                this.selectedAdvocateId="";
                this.selectedDepartmentId.focus;
              }
              // Failed to save Department
              else if (data.responseData == 3) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }

              // Department Updated
              else if (data.responseData == 4) {
                this.snackBarColor = "success";
                this.changeSnackBarMessage(this.$t("label_department_name_updated"));
                this.getAllCollection(event);
                this.isSaveEditClicked = 1;
                this.departmentName = "";
                 this.advocateShare="";
                 this.NotaryPublicShare="";
                 this.AWCShare ="";
              }
              // Department update failed
              else if (data.responseData == 5) {
                this.snackBarColor = "error";
                this.changeSnackBarMessage(
                  this.$t("label_something_went_wrong")
                );
              }
            }
          })
          .catch(error => {
            this.isSaveCollectionFormDataProcessing = false;
            this.snackBarColor = "error";
            this.changeSnackBarMessage(this.$t("label_something_went_wrong"));

          });

      }


    },
    //End of Save Function
     dispayShareInfo()
      {
          for(var i=0; i<this.departmentItems.length;i++)
          {
              if(this.departmentItems[i].lms_department_id == this.selectedDepartmentId)
              {
                    this.welfareTableShare=this.departmentItems[i].AWCShare;
                    this.notaryPublicTableShare=this.departmentItems[i].NotaryPublicShare;

                    this.AdvocateShare= this.departmentItems[i].AdvocateShare;
                    this.advocateTableShare=  this.AdvocateShare;
                    this.short_code= this.departmentItems[i].short_code;

              }

          }


      }





    }
  }
</script>
