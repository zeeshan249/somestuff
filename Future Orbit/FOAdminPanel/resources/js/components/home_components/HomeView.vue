<template>
    <v-app>
        <v-overlay :value="isLoaderActive" color="primary">
            <v-progress-circular
                indeterminate
                size="64"
                color="primary"
            ></v-progress-circular>
        </v-overlay>

        <idle-dialog-component
            :isIdleDialogProp="isIdle"
        ></idle-dialog-component>

        <v-navigation-drawer
            v-model="drawer"
            :clipped="$vuetify.breakpoint.lgAndUp"
            app
        >
            <v-list dense>
                <v-list-item class="px-2">
                    <v-list-item-avatar size="48">
                        <v-img
                            :src="loggedUserProfileImage"
                            :lazy-src="loggedUserProfileImage"
                        >
                            <template v-slot:placeholder>
                                <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                >
                                    <v-progress-circular
                                        indeterminate
                                        color="grey lighten-5"
                                    ></v-progress-circular>
                                </v-row>
                            </template>
                        </v-img>
                    </v-list-item-avatar>

                    <v-list-item link class="pl-0">
                        <v-list-item-content>
                            <v-list-item-title class="m-0 p-o">
                                <h5>{{ loggedUserName }}</h5>
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                <v-icon small color="gray darken-2"
                                    >mdi-phone</v-icon
                                >
                                {{ loggedUserMobileNumber }}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item>
            </v-list>

            <v-divider class="mt-0 mb-0"></v-divider>
            <perfect-scrollbar>
                <v-list shaped dense>
                    <!-- Dashboard Start -->
                    <template>
                        <v-list-group
                            v-permission="'Admin Dashboard'"
                            prepend-icon="mdi-view-dashboard"
                            icon-alt="mdi-view-dashboard"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Dashboard</v-list-item-title
                                    >
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                v-permission="'Admin Dashboard'"
                                to="/home/dashboard"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Admin Dashboard</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group></template
                    >
                    <!-- Dashboard End -->
                    <!-- Enquiry Start -->
                    <template>
                        <v-list-group
                            prepend-icon="mdi-walk"
                            icon-alt="mdi-walk"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Enquiry</v-list-item-title
                                    >
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                v-permission="'Add Enquiry'"
                                to="/home/enquiry/enquiry-directory"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Enquiry</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item
                                v-permission="'Add Enquiry'"
                                to="/home/school/add-school"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >School</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="
                                    'Add Information Source' |
                                        'Edit Information Source' |
                                        'Delete Information Source'
                                "
                                to="/home/system-settings/information-source"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                            >
                                <v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelInformationSource"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item> </v-list-group
                    ></template>
                    <!-- Enquiry End -->
                    <!-- Student Start -->
                    <template>
                        <v-list-group
                            prepend-icon="mdi-account"
                            icon-alt="mdi-account"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Student</v-list-item-title
                                    >
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                v-permission="'New Admission'"
                                to="/home/student/student-directory"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Student Details</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group></template
                    >
                    <!-- Student End -->
                    <!-- For Academics -->
                    <template>
                        <v-list-group
                            prepend-icon="mdi-school"
                            icon-alt="mdi-school"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelAcademics"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </template>
                            <v-list-item
                                v-permission="'Course'"
                                to="/home/batch/batch-directory"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>Batch</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-if="false"
                                v-permission="'Course'"
                                to="/home/academics/submitted-assignment"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Submitted Assignment</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item
                                v-permission="'Add Assignment'"
                                to="/home/academics/assignment"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Assignment</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-if="false"
                                v-permission="'Course'"
                                to="/home/academics/course"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelStream"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item
                                v-permission="'Course'"
                                to="/home/course/courseTab"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Course Management</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item
                                v-if="false"
                                v-permission="'Course'"
                                to="/home/academics/child-course"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelChildCourse"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item
                                v-if="false"
                                v-permission="'Subject'"
                                to="/home/academics/subject"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelSubject"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-if="false"
                                v-permission="'Topic'"
                                to="/home/academics/topic"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelTopic"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item> </v-list-group
                    ></template>
                    <!-- Academics End -->

                    <!-- Video Start -->
                    <template>
                        <v-list-group
                            prepend-icon="mdi-video-wireless-outline"
                            icon-alt="mdi-video-wireless-outline"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title>Video</v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                to="/home/video/video-directory"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Video Details</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group></template
                    >
                    <!-- Video End -->

                    <!-- Exam Start -->
                    <template>
                        <v-list-group
                            prepend-icon="mdi-bookmark-check"
                            icon-alt="mdi-bookmark-check"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title>Exam</v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                v-permission="'Exam Schedule'"
                                to="/home/exam/instruction-view"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Instruction</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'Question Bank'"
                                to="/home/exam/question-bank-Directory"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Question Bank</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'Question Bank'"
                                to="/home/exam/question-bank-copy"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Question Bank-Copy</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'Exam Schedule'"
                                to="/home/exam/exam-schedule-directory"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Exam Schedule</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group></template
                    >
                    <!-- Exam End -->

                    <!-- Accounts Start -->
                    <template v-permission="'Subscription'">
                        <v-list-group
                            prepend-icon="mdi-file-chart"
                            icon-alt="mdi-file-chart"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Accounts</v-list-item-title
                                    >
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                v-permission="'Subscription'"
                                to="/home/subscription/add-subscription-master"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Subscription</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                to="/home/discounts/view-discounts"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Discounts</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                to="/home/fee-generate/view-fee"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Generate Fees</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                to="/home/generated-fees/view-generated-fees"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Fee Collection</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group></template
                    >
                    <!-- Acciounts End -->
                    <!-- Communication Start -->
                    <template>
                        <v-list-group
                            prepend-icon="mdi-bell-ring"
                            icon-alt="mdi-bell-ring"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Communication</v-list-item-title
                                    >
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                to="/home/notice/add-notice"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Notice</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                to="/home/notification/add-notification"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Notification</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                to="/home/post/add-post"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>Post</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group></template
                    >
                    <!-- Communication End -->

                    <!-- Report Start -->
                    <template v-permission="'Reports'">
                        <v-list-group
                            prepend-icon="mdi-chart-areaspline"
                            icon-alt="mdi-chart-areaspline"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Report</v-list-item-title
                                    >
                                </v-list-item-content>
                            </template>
                            <v-list-item
                                to="/home/report/enquiry-report-View"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Enquiry Report</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                to="/home/report/student-registered-report"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Student Registered
                                        Report</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                to="/home/report/Fee-report-View"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Fee Report</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'Exam Report'"
                                to="/home/report/exam-report"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Exam Report</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item
                                v-permission="'Attendance Report'"
                                to="/home/attendance/attendance-directory"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Attendance Report</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item
                                v-permission="'Book Issue Report'"
                                to="/home/exam/book-issue-report"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Book Issue Report</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group></template
                    >
                    <!-- Report End -->

                    <!-- Library Start -->
                    <template>
                        <v-list-group
                            prepend-icon="mdi-book-open-page-variant"
                            icon-alt="mdi-book-open-page-variant"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Library</v-list-item-title
                                    >
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                v-permission="'Book List'"
                                to="/home/library/BookList"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Book List</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                to="/home/library/IssueItems"
                                class="text-decoration-none mb-1"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Issue Items</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group></template
                    >
                    <!-- Library End -->
                    <!-- For Human Resource -->
                    <template>
                        <v-list-group
                            prepend-icon="mdi-file-tree"
                            icon-alt="mdi-file-tree"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelHumanResource"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                v-permission="'Department'"
                                to="/home/human-resource/department"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelDepartment"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'Designation'"
                                to="/home/human-resource/designation"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                            >
                                <v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelDesignation"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'Staff'"
                                to="/home/human-resource/staff-directory"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                                ><v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelStaffDirectory"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item> </v-list-group
                    ></template>
                    <!-- Human Resource End -->
                    <!-- System Setting -->
                    <template>
                        <v-list-group
                            prepend-icon="mdi-flower"
                            icon-alt="mdi-flower"
                            append-icon
                        >
                            <template v-slot:activator>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelSystemSettings"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </template>

                            <v-list-item
                                v-permission="'Roles Permissions'"
                                to="/home/system-settings/roles-permissions"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                            >
                                <v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelRolesAndPermissions"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'Prefix'"
                                to="/home/system-settings/prefix"
                                class="text-decoration-none mb-1"
                                exact-active-class="primary"
                                color="white"
                            >
                                <v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        v-text="labelPrefix"
                                    ></v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'Session Setting'"
                                to="/home/system-settings/roles-permissions"
                                class="text-decoration-none mb-1"
                            >
                                <v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Session Setting</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'SMS Setting'"
                                to="/home/system-settings/roles-permissions"
                                class="text-decoration-none mb-1"
                            >
                                <v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >SMS Setting</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'Email Setting'"
                                to="/home/system-settings/roles-permissions"
                                class="text-decoration-none mb-1"
                            >
                                <v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >Email Setting</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item
                                v-permission="'User Status'"
                                to="/home/system-settings/roles-permissions"
                                class="text-decoration-none mb-1"
                            >
                                <v-list-item-action> </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title
                                        >User Status</v-list-item-title
                                    >
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-group>
                    </template>
                </v-list>
            </perfect-scrollbar>
        </v-navigation-drawer>

        <v-app-bar
            :clipped-left="$vuetify.breakpoint.lgAndUp"
            app
            color="primary darken-1"
            dark
        >
            <v-app-bar-nav-icon
                @click.stop="drawer = !drawer"
            ></v-app-bar-nav-icon>

            <v-toolbar-title style="width: 300px" class="ml-0 pl-4">
                <span class="hidden-sm-and-down">
                    <strong>{{ $t("label_company_name") }}</strong>
                </span>
            </v-toolbar-title>

            <v-spacer></v-spacer>
            <v-btn icon>
                <v-icon>mdi-apps</v-icon>
            </v-btn>
            <v-btn icon>
                <v-badge color="green" content="6" left>
                    <v-icon>mdi-bell</v-icon>
                </v-badge>
            </v-btn>

            <v-menu transition="slide-y-transition" bottom max-width="250px">
                <template v-slot:activator="{ on }">
                    <v-btn icon large v-on="on">
                        <v-avatar size="32px" item>
                            <v-img
                                :src="loggedUserProfileImage"
                                :lazy-src="loggedUserProfileImage"
                            >
                                <template v-slot:placeholder>
                                    <v-row
                                        class="fill-height ma-0"
                                        align="center"
                                        justify="center"
                                    >
                                        <v-progress-circular
                                            indeterminate
                                            color="grey lighten-5"
                                        ></v-progress-circular>
                                    </v-row>
                                </template>
                            </v-img>
                        </v-avatar>
                    </v-btn>
                </template>

                <v-card>
                    <v-list>
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-img
                                    :src="loggedUserProfileImage"
                                    :lazy-src="loggedUserProfileImage"
                                >
                                    <template v-slot:placeholder>
                                        <v-row
                                            class="fill-height ma-0"
                                            align="center"
                                            justify="center"
                                        >
                                            <v-progress-circular
                                                indeterminate
                                                color="grey lighten-5"
                                            ></v-progress-circular>
                                        </v-row>
                                    </template>
                                </v-img>
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title class="m-0 p-o">
                                    <h5>{{ loggedUserName }}</h5>
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    <v-icon small color="gray darken-2"
                                        >mdi-phone</v-icon
                                    >
                                    {{ loggedUserMobileNumber }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>

                    <v-divider class="p-0 m-0"></v-divider>

                    <v-list dense>
                        <v-list-item-group>
                            <v-list-item @click="logout">
                                <v-list-item-icon>
                                    <v-icon>mdi-exit-to-app</v-icon>
                                </v-list-item-icon>

                                <v-list-item-content>
                                    <v-list-item-title>{{
                                        $t("label_logout")
                                    }}</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>

                            <v-list-item @click="changePasswordDialog = true">
                                <v-list-item-icon>
                                    <v-icon>mdi-reload</v-icon>
                                </v-list-item-icon>

                                <v-list-item-content>
                                    <v-list-item-title>{{
                                        $t("label_change_password")
                                    }}</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-divider class="p-0 m-0"></v-divider>
                            <v-list-item>
                                <v-list-item-icon>
                                    <v-icon>mdi-lumx</v-icon>
                                </v-list-item-icon>

                                <v-list-item-content>
                                    <v-list-item-title>{{
                                        $t("label_settings")
                                    }}</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                </v-card>
            </v-menu>
        </v-app-bar>

        <transition name="fade" mode="out-in">
            <router-view
                :userPermissionDataProps="userPermissionData"
                v-if="userPermissionData != null"
            ></router-view>
        </transition>

        <v-row justify="center">
            <v-dialog
                v-model="changePasswordDialog"
                scrollable
                max-width="450px"
            >
                <v-card>
                    <v-card-title>{{
                        $t("label_change_password")
                    }}</v-card-title>

                    <v-progress-linear
                        :active="isforgotPasswordFormDataProcessing"
                        :indeterminate="isforgotPasswordFormDataProcessing"
                        absolute
                        top
                        color="white"
                    ></v-progress-linear>
                    <v-divider></v-divider>
                    <v-card-text style="height: 250px">
                        <v-form
                            ref="holdingForm"
                            v-model="isholdingFormValid"
                            lazy-validation
                        >
                            <v-row>
                                <v-col cols="12" md="12" class="mt-4 mb-0 p-2">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="oldPassword"
                                        label="Old Password"
                                        :append-icon="
                                            isPasswordVisible
                                                ? 'mdi-eye'
                                                : 'mdi-eye-off'
                                        "
                                        :type="
                                            isPasswordVisible
                                                ? 'text'
                                                : 'password'
                                        "
                                        @click:append="
                                            isPasswordVisible =
                                                !isPasswordVisible
                                        "
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col cols="12" md="12" class="mt-0 mb-0 p-2">
                                    <v-text-field
                                        outlined
                                        dense
                                        v-model="newPassword"
                                        label="New Password"
                                        :append-icon="
                                            isPasswordVisible
                                                ? 'mdi-eye'
                                                : 'mdi-eye-off'
                                        "
                                        :type="
                                            isPasswordVisible
                                                ? 'text'
                                                : 'password'
                                        "
                                        @click:append="
                                            isPasswordVisible =
                                                !isPasswordVisible
                                        "
                                        :rules="passwordRules"
                                        @keyup.enter="changePassword"
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12" md="12" class="m-0 p-0">
                                    <v-text-field
                                        v-if="false"
                                        outlined
                                        dense
                                        v-model="confirmPassword"
                                        label="Confirm Password"
                                        :append-icon="
                                            isPasswordVisible
                                                ? 'mdi-eye'
                                                : 'mdi-eye-off'
                                        "
                                        :type="
                                            isPasswordVisible
                                                ? 'text'
                                                : 'password'
                                        "
                                        @click:append="
                                            isPasswordVisible =
                                                !isPasswordVisible
                                        "
                                        @keyup.enter="changePassword"
                                        :rules="passwordRules"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-card-text>
                    <v-divider></v-divider>
                    <v-card-actions>
                        <v-btn
                            color="blue darken-1"
                            text
                            @click="changePasswordDialog = false"
                        >
                            Close
                        </v-btn>
                        <v-btn
                            color="blue darken-1"
                            text
                            :disabled="
                                !isholdingFormValid ||
                                isforgotPasswordFormDataProcessing
                            "
                            @click="changePassword()"
                        >
                            {{
                                isforgotPasswordFormDataProcessing == true
                                    ? $t("label_validating")
                                    : $t("label_change_password")
                            }}
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-row>

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

        <v-footer padless default class="text-center mt-6">
            <v-col class="text-center text-primary" cols="12">
                Powered by <strong>Future Orbit</strong>
            </v-col>
        </v-footer>
    </v-app>
</template>

<script>
// To secure local storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });

export default {
    data() {
        return {
            changePasswordDialog: false,
            oldPassword: "",
            newPassword: "",
            confirmPassword: "",
            dialogm1: "",
            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",
            isPasswordVisible: false,
            isholdingFormValid: true,
            isforgotPasswordFormDataProcessing: false,

            //Rules
            passwordRules: [
                (v) => !!v || this.$t("label_provide_valid_password"),
                (v) =>
                    (v && v.length > 5) || this.$t("label_password_min_char"),
            ],

            // Authorization token
            authorizationConfig: "",
            // For loader

            isLoaderActive: false,

            // Navigation Drawer & App Bar

            drawer: null,
            loggedUserName: "",
            loggedUserProfileImage: "",
            loggedUserMobileNumber: "",

            // System Settings
            labelSystemSettings: this.$t("label_system_settings"),
            labelRolesAndPermissions: this.$t("label_roles_and_permissions"),
            labelInformationSource: this.$t("label_information_source"),

            // Human Resource
            labelHumanResource: this.$t("label_human_resource"),
            labelDepartment: this.$t("label_department"),
            labelDesignation: this.$t("label_designation"),
            labelPrefix: this.$t("label_prefix"),
            labelStaffDirectory: this.$t("label_staff_directory"),

            // Academics
            labelAcademics: this.$t("label_academics"),
            labelCourse: this.$t("label_course"),
            labelStream: this.$t("label_stream"),
            labelChildCourse: this.$t("label_child_course"),
            labelSubject: this.$t("label_subject"),
            labelTopic: this.$t("label_topic"),

            // Form Data processing
            userPermissionData: null,
            isFormDataProcessing: true,
        };
    },
    computed: {
        // For Idle Componenet
        isIdle() {
            return this.$store.state.idleVue.isIdle;
        },
    },
    created() {
        // Enable loader
        this.isLoaderActive = true;
        // Set authorization token
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") },
        };
        // Get Logged User Permission & role

        this.$http
            .post(
                "auth/web_get_logged_user_details_with_role_permission",
                "",
                this.authorizationConfig
            )
            .then(({ data }) => {
                this.isLoaderActive = false;
                if (
                    data.error == "Unauthorized" ||
                    data.permissionError == "Unauthorized"
                ) {
                    // Unauthorized logout
                    this.$store.dispatch("actionUnauthorizedLogout");
                } else {
                    // Set logged user details with permissions
                    this.loggedUserName = data.userData[0].lms_staff_full_name;
                    this.loggedUserMobileNumber =
                        data.userData[0].lms_staff_mobile_number;
                    this.loggedUserProfileImage =
                        data.userData[0].lms_staff_profile_image != null
                            ? process.env.MIX_USER_PROFILE_IMAGE_URL +
                              data.userData[0].lms_staff_profile_image
                            : process.env.MIX_USER_PROFILE_IMAGE_URL +
                              "default.png";

                    this.$laravel.setPermissions(data.userPermission);
                    this.userPermissionData = data.userPermission;
                }
            })
            .catch((error) => {
                this.isLoaderActive = false;
                this.$store.dispatch("actionLogout");
            });
    },
    methods: {
        //#region - Toggle Mini Bar
        // toggleMiniBar() {
        //   console.log("-------------->");
        //   if (!this.$vuetify.breakpoint.lgAndUp) {
        //     this.sideMenu = !this.sideMenu;
        //   } else if (this.$vuetify.breakpoint.mdAndUp) {
        //     this.toggleMini = !this.toggleMini;
        //   }
        // },
        //#endregion

        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },
        // Change Password
        changePassword($event) {
            let userDecision = confirm(
                this.$t("label_are_you_sure_change_pasword")
            );
            if (userDecision) {
                this.isforgotPasswordFormDataProcessing = true;
                this.dialog = true;
                //Set Dialog
                this.$http
                    .post(
                        "web_get_logged_change_password",
                        {
                            centerId: ls.get("loggedUserCenterId"),
                            loggedUserId: ls.get("loggedUserId"),
                            oldPassword: this.oldPassword,
                            newPassword: this.newPassword,
                        },
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isforgotPasswordFormDataProcessing = false;
                        this.dialog = false;
                        //User Unauthorized
                        if (
                            data.error == "Unauthorized" ||
                            data.permissionError == "Unauthorized"
                        ) {
                            this.$store.dispatch("actionUnauthorizedLogout");
                        } else {
                            // Staff Status changed
                            if (data.responseData == 1) {
                                this.snackBarColor = "success";
                                this.changeSnackBarMessage(
                                    this.$t("label_change_password_success")
                                );
                                this.changePasswordDialog = false;
                            }
                            // Staff Status changed failed
                            else if (data.responseData == 2) {
                                this.isforgotPasswordFormDataProcessing = false;
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch((error) => {
                        this.isforgotPasswordFormDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            }
        },
        // Logout user
        logout() {
            this.isLoaderActive = true;
            this.$http
                .post("auth/web_logout", "", this.authorizationConfig)
                .then(({ data }) => {
                    this.isLoaderActive = false;
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        this.$store.dispatch("actionLogout");
                    }
                })
                .catch((error) => {
                    this.isLoaderActive = false;
                    this.$store.dispatch("actionLogout");
                });
        },
    },
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
.ps {
    height: 500px;
}
</style>
