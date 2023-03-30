<template>
    <v-container fluid>
        <!-- Card Start -->
        <v-overlay :value="isLoaderActive" color="primary">
            <v-progress-circular
                indeterminate
                size="64"
                color="primary"
            ></v-progress-circular>
        </v-overlay>
        <v-data-table
            dense
            :headers="tableHeader"
            :items="dataTableRowNumbering"
            item-key="lms_exam_schedule_id"
            class="elevation-1 width-100"
            :loading="tableDataLoading"
            :loading-text="tableLoadingDataText"
            :server-items-length="totalItemsInDB"
            :items-per-page="200"
            @pagination="getAllExamSchedule"
            :footer-props="{
                itemsPerPageOptions: [50, 200, 500, 1000, -1]
            }"
        >
            <template v-slot:no-data>
                <p class="font-weight-black bold title" style="color: red">
                    {{ $t("label_no_data_found") }}
                </p>
            </template>
            <template v-slot:item.lms_exam_result_details_is_active="{ item }">
                <v-chip
                    x-small
                    :color="
                        getStatusColor(item.lms_exam_result_details_is_active)
                    "
                    dark
                    >{{ item.lms_exam_result_details_is_active }}</v-chip
                >
            </template>

            <template v-slot:item.lms_total_marks_scored="{ item }">
                <v-chip x-small :color="getPassFailStatusColor(item)" dark>{{
                    item.lms_total_marks_scored
                }}</v-chip>
            </template>

            <template v-slot:item.actions="{ item }" v-if="false">
                <v-icon @click="ViewStudentDetails(item)" color="primary">
                    mdi-eye-outline
                </v-icon>
            </template>
        </v-data-table>
    </v-container>
</template>
<script>
import { StudentExamDetails } from "../../components/report_components/StudentExamDetails";
export default StudentExamDetails;
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
