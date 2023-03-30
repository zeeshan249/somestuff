<template>
  <v-content class="p-0">
    <v-container  cols="12" sm="12" md="12">

            <v-tabs align-with-title v-model="certificateTab" background-color="cyan"
      dark
      flat>
              <v-tabs-slider color="yellow"></v-tabs-slider>
                <v-tab>{{$t('label.label_generated')}}</v-tab>
              <v-tab>{{$t('label.label_approved')}}</v-tab>
              <!-- <v-tab>{{$t('label.label_rejected')}}</v-tab> -->
            </v-tabs>

        <v-tabs-items v-model="certificateTab">

          <v-tab-item>
            <certificate-generated-component :franchiseIdProps="franchiseIdProps"></certificate-generated-component>
          </v-tab-item>
        <v-tab-item>
            <certificate-processed-component :franchiseIdProps="franchiseIdProps"></certificate-processed-component>
          </v-tab-item>
          <!-- <v-tab-item>
            <certificate-rejected-component :franchiseIdProps="franchiseIdProps"></certificate-rejected-component>
          </v-tab-item> -->
        </v-tabs-items>
    </v-container>
  </v-content>
</template>





<script>
export default {
    props:[
        'franchiseIdProps'
    ],
  data() {
    return {
      certificateTab: ""
    };
  },
  created() {}
};
</script>
