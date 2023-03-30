<template>
  <div id="app">
    <!-- Card Start -->
    <v-container  fluid
            style="max-width: 100% !important"
       >
      <v-overlay :value="isLoaderActive" color="primary">
        <v-progress-circular
          indeterminate
          size="64"
          color="primary"
        ></v-progress-circular>
      </v-overlay>

      <v-snackbar
        v-model="isSnackBarVisible"
        :color="snackBarColor"
        multi-line="multi-line"
        right="right"
        :timeout="3000"
        top="top"
        vertical="vertical"
        >{{ snackBarMessage }}
      </v-snackbar>
  
      <transition name="fade" mode="out-in">
        <v-col class="d-flex flex-column mr-2" v-if="isAddCardVisible">
          <v-card elevation="0">
            <v-app-bar dark color="primary" flat>
              <v-toolbar-title color="success">
                Playlist
              </v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon class="ma-2" outlined small color="white">
                <v-icon
                  color="white"
                  @click="isAddCardVisible = !isAddCardVisible"
                  >mdi-minus</v-icon
                >
              </v-btn>
            </v-app-bar>
  
            <v-container>
              <v-form
                ref="saveTopicForm"
                v-model="issaveTopicFormValid"
                lazy-validation
              >
                <v-row dense>
                  <v-col cols="12" md="12" sm="12">
                    <v-select
                      outlined
                      dense
                      v-model="courseId"
                      :items="courseItems"
                      :disabled="isSourceDataLoading"
                      item-text="lms_course_name"
                      item-value="lms_course_id"
                      @change="getAllSubject($event)"
                      :rules="[(v) => !!v || $t('label_required')]"
                    >
                      <template #label>
                        Select Stream
                        <span class="red--text">
                          <strong>{{ $t("label_star") }}</strong>
                        </span>
                      </template>
                    </v-select>
                  </v-col>
  
                  <v-col cols="12" md="12" sm="12">
                    <v-select
                      outlined
                      dense
                      v-model="subjectId"
                      :items="subjectItems"
                      :disabled="isSourceDataLoading"
                      item-text="lms_subject_name"
                      item-value="lms_subject_id"
                      @change="getAllTopic($event)"
                      :rules="[(v) => !!v || $t('label_required')]"
                    >
                      <template #label>
                        Select Subject
                        <span class="red--text">
                          <strong>{{ $t("label_star") }}</strong>
                        </span>
                      </template>
                    </v-select>
                  </v-col>

                  <v-col cols="12" md="12" sm="12">
                    <v-select
                      outlined
                      dense
                      v-model="topicId"
                      :items="topicItems"
                      :disabled="isSourceDataLoading"
                      item-text="lms_topic_name"
                      item-value="lms_topic_id"
                      :rules="[(v) => !!v || $t('label_required')]"
                    >
                      <template #label>
                        Select Topic
                        <span class="red--text">
                          <strong>{{ $t("label_star") }}</strong>
                        </span>
                      </template>
                    </v-select>
                  </v-col>
  
                  <v-col cols="12" xs="12" sm="12" md="12">
                    <v-text-field
                      outlined
                      dense
                      v-model="playlist_name"
                      :rules="[(v) => !!v || $t('label_required')]"
                    >
                      <template #label>
                        Playlist Name
                        <span class="red--text">
                          <strong>{{ $t("label_star") }}</strong>
                        </span>
                      </template>
                    </v-text-field>
                  </v-col>

                  <v-col cols="12" xs="12" sm="12" md="12">
                    <v-file-input
                      v-model="playlistImage"
                      prepend-icon="mdi-camera"
                      color="primary"
                      dense
                      outlined
                      show-size
                      accept=".jpg , .png, .jpeg"
                      :rules="imageRule"
                    >
                      <template #label>
                      Playlist Image
                      <span class="red--text">
                          <strong>{{ $t("label_star") }}</strong>
                        </span>
                      </template>

                      <template v-slot:selection="{ index, text }">
                        <v-chip
                          v-if="index < 2"
                          color="primary"
                          dark
                          label
                          small
                          >{{ text }}</v-chip
                        >
                      </template>
                    </v-file-input>
                  </v-col>
                </v-row>

                <v-divider class="mx-4"></v-divider>
                <div dense class="mx-2 text-center mb-2">
                  <v-btn
                    v-permission="'Add Topic' | 'Edit Topic'"
                    class="ma-2 rounded"
                    tile
                    color="primary"
                    :disabled="
                      !issaveTopicFormValid || issaveTopicFormDataProcessing
                    "
                    @click="saveTopic"
                    ><v-icon class="mr-2">mdi-content-save</v-icon>
                    {{
                      issaveTopicFormDataProcessing == true
                        ? $t("label_processing")
                        : $t("label_save")
                    }}</v-btn
                  >
  
                  <v-btn
                    v-permission="'Add Course' | 'Edit Course'"
                    class="ma-2 rounded"
                    tile
                    color="error"
                    @click="isAddCardVisible = !isAddCardVisible"
                  >
                    <v-icon class="mx-2">mdi-cancel</v-icon>
                    {{
                      isSaveTopicFormDataProcessing == true
                        ? $t("label_processing")
                        : $t("label_cancel")
                    }}</v-btn
                  >
                </div>
              </v-form>
            </v-container>
          </v-card>
        </v-col>
      </transition>

      <transition name="fade" mode="out-in">
        <v-data-table
          dense
          :headers="tableHeader"
          :items="dataTableRowNumbering"
          item-key="lms_topic_id"
          class="elevation-0"
          :loading="tableDataLoading"
          :loading-text="tableLoadingDataText"
          :server-items-length="totalItemsInDB"
          :items-per-page="50"
          @pagination="getAllPlaylist"
          :footer-props="{
            itemsPerPageOptions: [50, 100, 150, 200, -1],
          }"
        >

          <template v-slot:top>
            <v-toolbar flat>
              <v-text-field
                class="mt-4"
                label="Search"
                prepend-inner-icon="mdi-magnify"
              ></v-text-field>
              <v-spacer></v-spacer>
              <v-spacer></v-spacer>
              <v-switch
                class="pt-4 mx-1"
                v-if="!tableDataLoading"
                inset
                v-model="includeDelete"
                @change="getAllCourse"
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
  
              <v-btn
                v-permission="'Add Course'"
                v-if="!isAddCardVisible"
                color="primary"
                class="white--text mx-2"
                @click="isAddCardVisible = !isAddCardVisible"
              >
                Add Playlist
                <v-icon right dark> mdi-plus </v-icon>
              </v-btn>
            </v-toolbar>
          </template>

          <template v-slot:no-data>
            <p class="font-weight-black bold title" style="color: red">
              {{ $t("label_no_data_found") }}
            </p>
          </template>

          <template v-slot:item.playlist_status="{ item }">
            <v-chip
              x-small
              :color="getStatusColor(item.playlist_status)"
              dark
              >{{ item.playlist_status }}</v-chip
            >
          </template>

          <template v-slot:item.playlist_image_url="{ item }">
            <v-avatar>
            <img
              
              inset
              dense
              max-height="50"
              max-width="50"
              :src="'http://app2.futureorbit.in/public/storage/playlist_image/'+item.playlist_image_url"
            >
            </v-avatar>
          </template>

         
  
          <template v-slot:item.actions="{ item }">
            <v-icon
            
              small
              class="mr-2"
              @click="editPlaylist(item)"
              color="primary"
              >mdi-pencil</v-icon
            >
  
            <v-icon
              v-if="item.lms_topic_is_active == 'Active'"
             
              small
              color="error"
              @click="disableTopic(item)"
              >mdi-delete</v-icon
            >
            <v-icon
              v-if="item.lms_topic_is_active == 'Inactive'"
              v-permission="'Edit Topic'"
              small
              color="success"
              @click="disableTopic(item)"
              >mdi-check-circle</v-icon
            >
          </template>
          
        </v-data-table>
      </transition>
 
    </v-container>
  </div>
  </template>
  
  
<script>

 import { playlistView } from "../video_components/playlistView";
 export default playlistView;

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
  