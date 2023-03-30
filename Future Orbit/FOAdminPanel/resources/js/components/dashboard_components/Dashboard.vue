<template>
  <div id="app">
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
      

      <v-row class="ml-4 mr-4 pt-4">
        <v-toolbar-title dark color="primary">
          <v-list-item two-line>
            <v-list-item-content>
              <v-list-item-title class="text-h5">
                <strong>Welcome {{ loggedInUserFirstName }},</strong>
              </v-list-item-title>
              <v-list-item-subtitle
                >Last logged in {{ usrLastLoginTime }}
              </v-list-item-subtitle>
            </v-list-item-content>
          </v-list-item>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn
          color="primary"
          class="white--text"
          @click="staffAttendance"
          v-if="attendanceStatus == 0"
        >
          <v-icon right dark class="mr-4"> mdi-login </v-icon>
          Clock-In
        </v-btn>
        <v-btn
          color="info"
          class="white--text"
          @click="staffAttendance"
          v-if="attendanceStatus == 1"
        >
          <v-icon right dark class="mr-4"> mdi-login </v-icon>
          Clock-Out
        </v-btn>
        <v-btn
          color="primary"
          class="white--text"
          v-if="attendanceStatus == 2"
          disabled
        >
          <v-icon right dark class="mr-4"> mdi-login </v-icon>
          Day-End
        </v-btn>
      </v-row>

      <v-row class="ml-2 mr-2">
        <v-col cols="12" md="6"
          ><v-card>
            <v-toolbar color="cyan" dark>
              <v-toolbar-title>Upcoming Batches</v-toolbar-title>
              <v-spacer></v-spacer>

              <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
              </v-btn>
            </v-toolbar>
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-send</v-icon>
              </v-list-item-icon>
              <v-list-item-subtitle
                >B22102500 - JEE - Math</v-list-item-subtitle
              >
            </v-list-item>
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-send</v-icon>
              </v-list-item-icon>
              <v-list-item-subtitle
                >B22102501 - JEE - Chem</v-list-item-subtitle
              >
            </v-list-item>
            <v-list-item>
              <v-list-item-icon>
                <v-icon>mdi-send</v-icon>
              </v-list-item-icon>
              <v-list-item-subtitle
                >B22102502 - NEET - Math</v-list-item-subtitle
              >
            </v-list-item>

            <v-slider
              v-model="time"
              :max="6"
              :tick-labels="labels"
              class="mx-4"
              ticks
            ></v-slider>

            <v-list class="transparent">
              <v-list-item v-for="item in forecast" :key="item.day">
                <v-list-item-title>{{ item.day }}</v-list-item-title>

                <v-list-item-icon>
                  <v-icon>{{ item.icon }}</v-icon>
                </v-list-item-icon>

                <v-list-item-subtitle class="text-right">
                  {{ item.temp }}
                </v-list-item-subtitle>
              </v-list-item>
            </v-list>

            <v-divider></v-divider>

            <v-card-actions>
              <v-btn text> Full Report </v-btn>
            </v-card-actions>
          </v-card></v-col
        >

        <v-col cols="12" md="6">
          <v-card>
            <v-toolbar color="cyan" dark>
              <v-toolbar-title>Notice</v-toolbar-title>

              <v-spacer></v-spacer>

              <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
              </v-btn>
            </v-toolbar>

            <v-list three-line>
              <template v-for="(item, index) in items">
                <v-subheader
                  v-if="item.header"
                  :key="item.header"
                  v-text="item.header"
                ></v-subheader>

                <v-divider
                  v-else-if="item.divider"
                  :key="index"
                  :inset="item.inset"
                ></v-divider>

                <v-list-item v-else :key="item.title">
                  <v-list-item-avatar>
                    <v-img :src="item.avatar"></v-img>
                  </v-list-item-avatar>

                  <v-list-item-content>
                    <v-list-item-title v-html="item.title"></v-list-item-title>
                    <v-list-item-subtitle
                      v-html="item.subtitle"
                    ></v-list-item-subtitle>
                  </v-list-item-content>
                </v-list-item>
              </template>
            </v-list>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import { Dashboard } from "../../components/dashboard_components/Dashboard";
export default Dashboard;
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
