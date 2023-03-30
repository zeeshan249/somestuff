<template>
    <div id="app">
        <v-container
        fluid
            style=" max-width: 100% !important"
       
        >
        <v-sheet class="pa-4 mb-4" color="text-white">
            <v-row  dense>
                <transition name="fade" mode="out-in">
                    <v-col class="d-flex flex-column ma-4">
                        <!-- Card Start -->
                        <v-card width="100%" class="max-aoto" elevation="0">
                            <v-row class="mx-4 my-1">
                                <v-toolbar-title dark color="primary">
                                    <v-list-item
                                        two-line
                                        style="padding: 0 !important"
                                    >
                                        <v-list-item-content
                                            style="padding: 0 !important"
                                        >
                                            <v-list-item-title
                                                class="text-h4 pb-1"
                                            >
                                                Exam Schedule
                                            </v-list-item-title>
                                            <v-list-item-subtitle>
                                                Home
                                                <v-icon
                                                    >mdi-chevron-right</v-icon
                                                >
                                                Exam
                                                <v-icon
                                                    >mdi-chevron-right</v-icon
                                                ><strong
                                                    class="primary--text text--lighten-1"
                                                    >Schedule Exam</strong
                                                >
                                            </v-list-item-subtitle>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-btn
                                    class="ma-2"
                                    color="primary"
                                    @click="addExamSchedule"
                                >
                                    <v-icon class="mr-2" color="white"
                                        >mdi-book-plus</v-icon
                                    >
                                    {{ $t("label_add_exam_schedule") }}
                                </v-btn>
                            </v-row>
                            <v-container 
                                    fluid
                                    style="max-width: 100% !important">
                                <v-tabs v-model="tabs" class="d-flex flex-row">
                                    <v-tab> Live </v-tab>

                                    <v-tab> Upcoming </v-tab>

                                    <v-tab> Over </v-tab>
                                </v-tabs>
                                <v-divider></v-divider>
                                <v-tabs-items v-model="tabs" class="ma-0 pa-0">
                                    <v-tab-item>
                                        <ExamDirectoryLive />
                                    </v-tab-item>
                                    <v-tab-item>
                                        <ExamDirectoryUpcoming />
                                    </v-tab-item>

                                    <v-tab-item
                                        ><ExamDirectoryOver
                                    /></v-tab-item>
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
import ExamDirectoryLive from "../../components/exam_components/AddExamScheduleDirectoryView.vue";
import ExamDirectoryUpcoming from "../../components/exam_components/AddExamScheduleUpcomingDirectoryView.vue";
import ExamDirectoryOver from "../../components/exam_components/AddExamScheduleOverDirectoryView.vue";

export default {
    components: {
        ExamDirectoryOver,
        ExamDirectoryUpcoming,
        ExamDirectoryLive
    },

    data() {
        return {
            tabs: null,
            text:
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."
        };
    },
    mounted() {},
    computed: {},

    created() {},
    watch: {},
    methods: {
        // Add Exam Schedule
        addExamSchedule(item) {
            this.$router.push({
                name: "AddExamSchedule"
            });
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
