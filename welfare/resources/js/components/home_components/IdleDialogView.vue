<template>
  <div class="text-center">
    <v-dialog v-model="isIdleDialogVisible" width="500">
      <v-card>
        <v-card-title class="headline primary  white--text" primary-title>{{$t('label_session_about_to_expire')}}</v-card-title>

        <v-card-text >
          <div><strong>{{$t('label_left_browser_inactive')}}</strong></div>
          <div>{{$t('label_time_left_before_logout')}}{{ time/1000 }} {{$t('label_seconds_left')}}</div>
        </v-card-text>


      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  props: ["isIdleDialogProp"],
  data() {
    return {
      isIdleDialogVisible: false,
      time: 10000
    };
  },

  watch: {
    isIdleDialogProp(newVal) {
      this.isIdleDialogVisible = newVal;
      this.startTimer();
    },
    isIdleDialogVisible(val) {
      val || this.close();
    }
  },

  methods: {
    close() {
      this.isIdleDialogVisible = false;
    },
    startTimer() {
        this.time=10000;
      let timerId = setInterval(() => {
        this.time -= 1000;
        if (!this.$store.state.idleVue.isIdle) clearInterval(timerId);

        if (this.time < 1) {
          clearInterval(timerId);
          this.close();
          this.$store.dispatch("actionLogout");
        }
      }, 1000);
    }
  }
};
</script>
