<template>
    <div  id="app">
       <v-container  fluid
      style="background-color: #e4e8e4; max-width: 100% !important"
      >
      <v-sheet class="pa-4 mb-4" color="text-white">
           <v-row dense>
               <transition name="fade" mode="out-in">
                   <v-col class="d-flex flex-column ma-4">
                       <!-- Card Start -->
                       <v-card elevation="0">
                           <v-row class="mx-4 my-1">
                               <v-toolbar-title dark color="primary">
                                   <v-list-item two-line style="padding:0 !important;">
                                       <v-list-item-content style="padding:0 !important;">
                                           <v-list-item-title class="text-h4 pb-1">
                                              Video Details
                                           </v-list-item-title>
                                           <v-list-item-subtitle>
                                               Home <v-icon>mdi-chevron-right</v-icon> Video
                                               <v-icon>mdi-chevron-right</v-icon><strong class="primary--text text--lighten-1"> Video Details</strong>
                                           </v-list-item-subtitle>
                                       </v-list-item-content>
                                   </v-list-item>
                               </v-toolbar-title>
   
                           </v-row>
                           <v-container fluid style="max-width: 100% !important">
                               <v-tabs v-model="tabs" class="d-flex flex-row">
                                   <v-tab>
                                       Playlist
                                   </v-tab>
   
                                   <v-tab>
                                       Video
                                   </v-tab>
                               </v-tabs>
                               <v-divider></v-divider>
                               <v-tabs-items v-model="tabs" class="ma-0 pa-0">
                                   <v-tab-item> <playlist /> </v-tab-item>
                                   <v-tab-item> <video /> </v-tab-item>
                               </v-tabs-items>
                           </v-container>
                       </v-card>
                       <!-- Card End -->
                   </v-col>
               </transition>
           </v-row>
        </v-sheet>
       </v-container>
    </div>
   </template>
   
   
   <script>
      import playlist from "../../components/video_components/PlaylistView.vue"
      import video from "../../components/video_components/VideoView.vue"
   
       export default {
           components: {
            playlist,
            video,
             
           },
   
           data() {
               return {
                   tabs: null,
                   text:
                       "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
               };
           },
           mounted() { },
           computed: {},
   
           created() { },
           watch: {},
           methods: {},
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
   