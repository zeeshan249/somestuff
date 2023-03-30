<template>
  <v-content class="p-0">
    <v-container  cols="12" sm="12" md="12">

            <v-tabs align-with-title v-model="studentTab" background-color="cyan"
      dark
      flat>
              <v-tabs-slider color="yellow"></v-tabs-slider>
                <v-tab>{{$t('label.label_active')}}</v-tab>
              <v-tab>{{$t('label.label_certified')}}</v-tab>
              <v-tab>{{$t('label.label_certificate_request_generated')}}</v-tab>
            </v-tabs>

        <v-tabs-items v-model="studentTab">

          <v-tab-item>
            <student-active-component :franchiseIdProps="franchiseIdProps"></student-active-component>
          </v-tab-item>
        <v-tab-item>
            <student-certified-component :franchiseIdProps="franchiseIdProps"></student-certified-component>
          </v-tab-item>
          <v-tab-item>
            <student-certificate-request-generated-component :franchiseIdProps="franchiseIdProps"></student-certificate-request-generated-component>
          </v-tab-item>
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
      studentTab: ""
    };
  },
  created() {}
};
</script>
