<template>
  <v-content>
    <v-container  cols="12" sm="12" md="12">

            <v-tabs align-with-title v-model="tab" background-color="cyan"
      dark
      flat>
              <v-tabs-slider color="yellow"></v-tabs-slider>
                <v-tab>{{$t('label.label_approved_franchise')}}</v-tab>
              <v-tab>{{$t('label.label_pending_for_approval')}}</v-tab>
              <v-tab>{{$t('label.label_rejected_franchise')}}</v-tab>
            </v-tabs>

        <v-tabs-items v-model="tab">

          <v-tab-item>
            <franchise-approved-component></franchise-approved-component>
          </v-tab-item>
        <v-tab-item>
            <franchise-applied-component></franchise-applied-component>
          </v-tab-item>
          <v-tab-item>
            <franchise-rejected-component></franchise-rejected-component>
          </v-tab-item>
        </v-tabs-items>
    </v-container>
  </v-content>
</template>





<script>
export default {
  data() {
    return {
      tab: ""
    };
  },
  created() {}
};
</script>
