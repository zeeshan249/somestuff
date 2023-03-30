<template>
  <div  id="app">
    <v-container 
           fluid
            style="background-color: #e4e8e4; max-width: 100% !important"
    >
      <!-- Card Start -->
      <v-overlay :value="isLoaderActive" color="primary">
        <v-progress-circular
          indeterminate
          size="64"
          color="primary"
        ></v-progress-circular>
      </v-overlay>
      <v-sheet class="pa-4 mb-4" color="text-white">
      <v-row class="ml-4 mr-4 pt-4">
        <v-toolbar-title dark color="primary">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h5">
                <strong>Batch Creation</strong>
              </v-list-item-title>
              <v-list-item-subtitle
                >Home <v-icon>mdi-forward</v-icon> Academic
                <v-icon>mdi-forward</v-icon> Batch
                Creation</v-list-item-subtitle
              >
            </v-list-item-content>
          </v-list-item>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn
          v-if="!isAddCardVisible"
          :disabled="tableDataLoading"
          color="primary"
          class="white--text"
          @click="isAddCardVisible = !isAddCardVisible"
        >
          Launch New Batch
          <v-icon right dark> mdi-plus </v-icon>
        </v-btn>
      </v-row>
</v-sheet>
      <transition name="fade" mode="out-in">
        <v-col v-if="isAddCardVisible">
          <v-card class="mx-auto">
            <v-app-bar dark color="primary">
              <v-toolbar-title color="success">{{
                $t("label_batch")
              }}</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon class="ma-2" outlined small color="white">
                <v-icon
                  color="white"
                  @click="isAddCardVisible = !isAddCardVisible"
                  >mdi-minus</v-icon
                >
              </v-btn>
            </v-app-bar>

            <v-form
              ref="saveBatchForm"
              v-model="issaveBatchFormValid"
              lazy-validation
            >
              <v-row dense class="mx-auto mt-4">
                <v-col cols="12" md="4" sm="12" class="px-2">
                  <v-select
                    outlined
                    dense
                    v-model="lms_course_id"
                    :items="courseItems"
                    :disabled="isSourceDataLoading"
                    item-text="lms_course_name"
                    item-value="lms_course_id"
                    :rules="[(v) => !!v || $t('label_required')]"
                    @change="
                      getAllActiveSubjectBasedonCourse(this);
                      getAllActiveChildCourse(this);
                    "
                  >
                    <template #label>
                          Stream
                      <span class="red--text">
                        <strong>Stream</strong>
                      </span>
                    </template>
                  </v-select>
                </v-col>
                <v-col cols="12" md="4" sm="12" class="px-2">
                  <v-select
                    outlined
                    dense
                    v-model="lms_child_course_id"
                    :items="childCourseItems"
                    :disabled="isSourceDataLoading"
                    item-text="lms_child_course_name"
                    item-value="lms_child_course_id"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_child_course") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-select>
                </v-col>
                <v-col cols="12" xs="12" sm="12" md="4" class="px-2">
                  <v-text-field
                    outlined
                    dense
                    v-model="lms_batch_name"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_batch_title") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>

                <v-col cols="12" xs="12" sm="12" md="6" class="px-2">
                  <template>
                    <v-datetime-picker
                      label="Start Date"
                      v-model="lms_batch_start_date"
                      outlined
                      :time-picker-props="timeProps"
                      time-format="HH:mm:ss"
                      date-format="yyyy-MM-dd"
                      :text-field-props="textFieldProps"
                    >
                    </v-datetime-picker>
                  </template>
                </v-col>
                <v-col cols="12" xs="12" sm="12" md="6" class="px-2">
                  <template>
                    <v-datetime-picker
                      label="End Date"
                      v-model="lms_batch_end_date"
                      outlined
                      :time-picker-props="timeProps"
                      time-format="HH:mm:ss"
                      date-format="yyyy-MM-dd"
                      :text-field-props="textFieldProps"
                    >
                    </v-datetime-picker>
                  </template>
                </v-col>
                <v-col
                  cols="12"
                  xs="12"
                  sm="12"
                  md="6"
                  class="px-2"
                  v-if="false"
                >
                  <v-text-field
                    outlined
                    dense
                    v-model="lms_batch_code"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_batch_code") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
              </v-row>
              <v-app-bar color="grey" elevation="0" dark height="60">
                <v-toolbar-title color="success">
                  Add Class Timing</v-toolbar-title
                >
                <v-spacer></v-spacer>
                <v-btn
                  @click="addSlot"
                  :disabled="tableDataLoading"
                  color="success"
                  class="white--text"
                >
                  Add Class
                  <v-icon right dark> mdi-plus </v-icon>
                </v-btn>
              </v-app-bar>

              <v-row
                v-for="(slot, index) in slotDetails"
                :key="index"
                class="work-experiences mx-auto mt-4"
                cols="12"
              >
                <v-col cols="12" md="2">
                  <v-text-field
                    v-mask="`##:##`"
                    dense
                    v-model="slot.lms_batch_slot_start_time"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_batch_start_time") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                  <v-text-field
                    v-mask="`##:##`"
                    dense
                    v-model="slot.lms_batch_slot_end_time"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                    <template #label>
                      {{ $t("label_batch_end_time") }}
                      <span class="red--text">
                        <strong>{{ $t("label_star") }}</strong>
                      </span>
                    </template>
                  </v-text-field>
                </v-col>
                <v-col cols="12" md="2">
                  <v-select
                    dense
                    label="Day"
                    v-model="slot.lms_batch_slot_day"
                    :items="dayItems"
                    :disabled="isSourceDataLoading"
                    item-text="day"
                    item-value="lms_batch_slot_day"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                  </v-select>
                </v-col>
                <v-col cols="12" md="3">
                  <v-select
                    dense
                    label="Subject"
                    v-model="slot.lms_subject_id"
                    :items="subjectItems"
                    :disabled="subjectDataLoading"
                    item-text="lms_subject_name"
                    item-value="lms_subject_id"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                  </v-select>
                </v-col>
                <v-col cols="12" md="2">
                  <v-select
                    dense
                    label="Faculty"
                    v-model="slot.lms_user_id"
                    :items="facultiesItems"
                    :disabled="isSourceDataLoading"
                    item-text="lms_staff_full_name"
                    item-value="lms_user_id"
                    :rules="[(v) => !!v || $t('label_required')]"
                  >
                  </v-select>
                </v-col>
                <v-col cols="12" md="1">
                  <v-btn
                    icon
                    color="error"
                    @click="remove(index, slot.lms_batch_slot_id)"
                    v-show="index || (!index && slotDetails.length > 1)"
                    ><v-icon dark> mdi-minus-circle </v-icon></v-btn
                  >
                </v-col>
              </v-row>
              <v-row dense>
                <v-col
                  cols="12"
                  xs="12"
                  sm="12"
                  md="12"
                  class="px-2 text-center"
                >
                  <v-btn
                    class="ma-2 rounded"
                    tile
                    color="primary"
                    :disabled="
                      !issaveBatchFormValid || issaveBatchFormDataProcessing
                    "
                    @click="saveBatch"
                    >{{
                      issaveBatchFormDataProcessing == true
                        ? $t("label_processing")
                        : $t("label_save")
                    }}</v-btn
                  >

                  <v-btn
                    class="ma-2 rounded"
                    tile
                    color="error"
                    :disabled="
                      !issaveBatchFormValid || issaveBatchFormDataProcessing
                    "
                    @click="resetForm"
                    >Reset</v-btn
                  >
                </v-col>
              </v-row>
            </v-form>
          </v-card>
        </v-col>
      </transition>
      <!-- Card End -->

      <transition name="fade" mode="out-in">
        <v-card>
          <v-data-table
            dense
            :headers="tableHeader"
            :items="dataTableRowNumbering"
            item-key="lms_batch_id"
            class="elevation-1"
            :loading="tableDataLoading"
            :loading-text="tableLoadingDataText"
            :server-items-length="totalItemsInDB"
            :items-per-page="50"
            @pagination="getAllBatch"
            show-expand
            :expanded.sync="expanded"
            :single-expand="singleExpand"
            :footer-props="{
              itemsPerPageOptions: [25, 50, 100, 200, -1],
            }"
          >
            <template
              v-slot:item.data-table-expand="{ item, isExpanded, expand }"
            >
              <v-icon
                small
                @click="expand(false)"
                v-if="isExpanded"
                size="22"
                class="mr-2"
                color="primary"
                >mdi-arrow-up-circle-outline</v-icon
              >

              <v-icon
                small
                @click="
                  expand(true);
                  getAllStudentBatchWise(item);
                "
                v-if="!isExpanded"
                size="22"
                class="mr-2"
                color="success"
                >mdi-arrow-down-circle-outline</v-icon
              >
            </template>
            <template v-slot:expanded-item="{ headers, item }">
              <td :colspan="headers.length" class="pa-4">
                <v-data-table
                  dense
                  :headers="tableHeaderStudent"
                  :items="dataTableRowNumberingStudent"
                  item-key="lms_registration_id"
                  class="elevation-0"
                  :loading-text="tableLoadingDataText"
                  hide-default-footer
                >
                  <template v-slot:no-data>
                    <p class="font-weight-black bold title" style="color: red">
                      No Student Found
                    </p>
                  </template>
                </v-data-table>
              </td>
            </template>
            <template v-slot:no-data>
              <p class="font-weight-black bold title" style="color: red">
                {{ $t("label_no_data_found") }}
              </p>
            </template>
            <template v-slot:item.lms_batch_is_active="{ item }">
              <v-chip
                x-small
                :color="getStatusColor(item.lms_batch_is_active)"
                dark
                >{{ item.lms_batch_is_active }}</v-chip
              >
            </template>
            <template v-slot:top>
              <v-toolbar flat>
                <v-text-field
                  class="mt-4"
                  label="Search"
                  prepend-inner-icon="mdi-magnify"
                  @input="searchBatch"
                ></v-text-field>
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>

                <v-switch
                  class="pt-4 mx-1"
                  v-if="!tableDataLoading"
                  inset
                  v-model="includeDelete"
                  @change="getAllBatch"
                ></v-switch>
                <v-btn
                  icon
                  small
                  color="teal"
                  class="mx-1"
                  v-if="!tableDataLoading"
                >
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
                  class="mx-1"
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
                small
                class="mr-2"
                @click="assignStudentToBatch(item)"
                color="primary"
                >mdi-account-plus</v-icon
              >
              <v-icon
                small
                class="mr-2"
                @click="batchSlotDetails(item)"
                color="primary"
                >mdi-format-align-bottom</v-icon
              >
              <v-icon
                small
                class="mr-2"
                @click="editBatch(item)"
                color="primary"
                >mdi-lead-pencil</v-icon
              >

              <v-icon
                small
                v-if="item.lms_batch_is_active == 'Active'"
                v-permission="'Edit Subject'"
                color="error"
                @click="disableBatch(item)"
                >mdi-delete</v-icon
              >
              <v-icon
                small
                v-if="item.lms_batch_is_active == 'Inactive'"
                v-permission="'Edit Subject'"
                color="success"
                @click="disableBatch(item)"
                >mdi-check-circle</v-icon
              >
            </template>
          </v-data-table>
        </v-card>
      </transition>
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

      <!-- Dialog Start -->
      <v-dialog
        v-model="dialogBatchDetails"
        fullscreen
        hide-overlay
        transition="dialog-bottom-transition"
      >
        <v-card>
          <v-card-title class="text-h5 grey lighten-2">
            Details of {{ batchDetails }}
          </v-card-title>

          <v-card-text>
            <v-data-table
              dense
              :headers="tableHeaderBatchSlotDetails"
              :items="dataTableRowNumberingBatchSlotDetails"
              item-key="lms_batch_slot_id"
              :loading="tableDataLoading"
              :loading-text="tableLoadingDataText"
              :server-items-length="totalItemsInDB"
              :items-per-page="15"
            
              :footer-props="{
                itemsPerPageOptions: [15, 25, 50, -1],
              }"
            >
             
              <template v-slot:no-data>
                <p class="font-weight-black bold title" style="color: red">
                  {{ $t("label_no_data_found") }}
                </p>
              </template>
              <template v-slot:item.lms_batch_slot_is_active="{ item }">
                <v-chip
                  x-small
                  :color="getStatusColor(item.lms_batch_slot_is_active)"
                  dark
                  >{{ item.lms_batch_slot_is_active }}</v-chip
                >
              </template>

            
            </v-data-table>
          </v-card-text>

          <v-divider></v-divider>

          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text @click="dialogBatchDetails = false">
              Close
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <!-- Dialog End -->
    </v-container>
  </div>
</template>
<script>
import { BookIssue } from "../../components/batch_components/BookIssue";
export default BookIssue;
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

.fluid-background {
  background-color: blue;
}

.work-experiences > div {
  margin: 2px 0;
  padding-bottom: 2px;
}
.work-experiences > div:not(:last-child) {
  border-bottom: 0px solid rgb(206, 212, 218);
}
</style>
