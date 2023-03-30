//  This file contains all route contain
import Vue from "vue";
import Router from "vue-router";
import store from "../vuex/store";

Vue.use(Router);

const router = new Router({
    scrollBehavior() {
        return {
            x: 0,
            y: 0
        };
    },
    routes: [
        {
            path: "/",
            redirect: {
                name: "Login"
            }
        },
        {
            path: "/login",
            name: "Login",
            component: require("../../components/login_components/LoginView.vue")
                .default
        },

        {
            path: "/unauthorized",
            name: "Unauthorized",
            component: require("../../components/error_components/UnauthorizedView.vue")
                .default
        },
        // Student Wise Exam Details
        {
            path: "/student-exam-details",
            component: require("../../components/report_components/StudentExamDetails.vue")
                .default,
            name: "StudentExamDetails",
            meta: {
                requiresAuth: true
            },
            props: true
        },

        {
            path: "/home",
            component: require("../../components/home_components/HomeView.vue")
                .default,
            name: "Home",
            meta: {
                requiresAuth: true
            },
            children: [
                // System Setting Roles Permission
                {
                    path: "system-settings/roles-permissions",
                    component: require("../../components/system_settings_components/RolesPermissionsView.vue")
                        .default,
                    name: "SystemSettingsRolesPermissions",
                    meta: {
                        requiresAuth: true
                    }
                },
                // System Setting Assign  Permission
                {
                    path: "system-settings/assign-permissions/:roleId",
                    component: require("../../components/system_settings_components/AssignPermissionsView.vue")
                        .default,
                    name: "SystemSettingsAssignPermissions",
                    meta: {
                        requiresAuth: true
                    }
                },
                // System Setting Prefix Setting
                {
                    path: "system-settings/prefix/",
                    component: require("../../components/system_settings_components/PrefixView.vue")
                        .default,
                    name: "SystemSettingsPrefix",
                    meta: {
                        requiresAuth: true
                    }
                },
                // System Setting Information Source
                {
                    path: "system-settings/information-source/",
                    component: require("../../components/system_settings_components/InformationSourceView.vue")
                        .default,
                    name: "SystemSettingsInformationSource",
                    meta: {
                        requiresAuth: true
                    }
                },

                // Human Resources Department
                {
                    path: "human-resource/department",
                    component: require("../../components/human_resource_components/DepartmentView.vue")
                        .default,
                    name: "HumanResourceDepartment",
                    meta: {
                        requiresAuth: true
                    }
                },

                // Human Resources Designation
                {
                    path: "human-resource/designation",
                    component: require("../../components/human_resource_components/DesignationView.vue")
                        .default,
                    name: "HumanResourceDesignation",
                    meta: {
                        requiresAuth: true
                    }
                },
                // Human Resources Staff Directory
                {
                    path: "human-resource/staff-directory",
                    component: require("../../components/human_resource_components/StaffDirectoryView.vue")
                        .default,
                    name: "HumanResourceStaffDirectory",
                    meta: {
                        requiresAuth: true
                    }
                },

                // Human Resources Add Satff
                {
                    path: "human-resource/add-staff",
                    component: require("../../components/human_resource_components/AddStaffView.vue")
                        .default,
                    name: "HumanResourceAddStaff",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Human Resources Staff Profile
                {
                    path: "human-resource/staff-profile/:staffUserId",
                    component: require("../../components/human_resource_components/StaffProfileView.vue")
                        .default,
                    name: "HumanResourceStaffProfile",
                    meta: {
                        requiresAuth: true
                    }
                },

                // Academics - Course
                {
                    path: "academics/course",
                    component: require("../../components/academic_components/CourseView.vue")
                        .default,
                    name: "AcademicsCourse",
                    meta: {
                        requiresAuth: true
                    }
                },

                // Academics - Course Child
                {
                    path: "academics/child-course",
                    component: require("../../components/academic_components/ChildCourseView.vue")
                        .default,
                    name: "AcademicsChildCourse",
                    meta: {
                        requiresAuth: true
                    }
                },

                // Academics - Subject
                {
                    path: "academics/subject",
                    component: require("../../components/academic_components/SubjectView.vue")
                        .default,
                    name: "AcademicsSubject",
                    meta: {
                        requiresAuth: true
                    }
                },

                // Academics - Topic
                {
                    path: "academics/topic",
                    component: require("../../components/academic_components/TopicView.vue")
                        .default,
                    name: "AcademicsTopic",
                    meta: {
                        requiresAuth: true
                    }
                },
                // View Assignment
                {
                    path: "academics/assignment",
                    component: require("../../components/academic_components/AssignmentView.vue")
                        .default,
                    name: "AssignmentView",
                    meta: {
                        requiresAuth: true
                    }
                },
                // View Submitted Assignment
                {
                    path: "academics/submitted-assignment",
                    component: require("../../components/academic_components/ViewSubmittedAssignment.vue")
                        .default,
                    name: "ViewSubmittedAssignment",
                    meta: {
                        requiresAuth: true
                    },
                    props: true 
                },

                // View Submitted Assignment Details
                {
                    path: "academics/submitted-assignment-details",
                    component: require("../../components/academic_components/SubmittedAssignmentDetails.vue")
                        .default,
                    name: "SubmittedAssignmentDetails",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Videos - video-directory
                {
                    path: "video/video-directory",
                    component: require("../../components/video_components/VideoDesignView.vue")
                        .default,
                    name: "VideoDesignView",
                    meta: {
                        requiresAuth: true
                    }
                },

                // Videos - Playlist
                {
                    path: "video/playlist",
                    component: require("../../components/video_components/PlaylistView.vue")
                        .default,
                    name: "Playlist",
                    meta: {
                        requiresAuth: true
                    }
                },

                // Videos - Video
                {
                    path: "video/video",
                    component: require("../../components/video_components/VideoView.vue")
                        .default,
                    name: "Video",
                    meta: {
                        requiresAuth: true
                    }
                },


                // Enquiry - Directory
                {
                    path: "enquiry/enquiry-directory",
                    component: require("../../components/enquiry_components/EnquiryDirectoryView.vue")
                        .default,
                    name: "EnquiryDirectory",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Enquiry - Add Enquiry
                {
                    path: "enquiry/add-enquiry",
                    component: require("../../components/enquiry_components/AddEnquiryView.vue")
                        .default,
                    name: "AddEnquiry",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Enquiry - Add Register
                {
                    path: "enquiry/add-register",
                    component: require("../../components/enquiry_components/AddRegisterView.vue")
                        .default,
                    name: "AddRegister",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // School - Add School
                {
                    path: "school/add-school",
                    component: require("../../components/enquiry_components/SchoolView.vue")
                        .default,
                    name: "AddSchool",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },


                // Exam Schedule - Directory
                {
                    path: "exam/exam-schedule-directory",
                    component: require("../../components/exam_components/ExamScheduleTabView.vue")
                        .default,
                    name: "ExamDirectory",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Exam Report Student Details
                {
                    path: "exam/exam-schedule-student-report-directory",
                    component: require("../../components/report_components/ExamStudentWiseReportView.vue")
                        .default,
                    name: "ViewStudentDetailsExamReport",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Book Issue Report
                {
                    path: "exam/book-issue-report",
                    component: require("../../components/report_components/BookIssueReportView.vue")
                        .default,
                    name: "BookIssueReport",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                {
                    path: "report/Enquiry-report-View",
                    component: require("../../components/report_components/EnquiryReportView.vue")
                        .default,
                    name: "EnquiryReportView",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                {
                    path: "report/student-registered-report",
                    component: require("../../components/report_components/StudentRegisteredReport.vue")
                        .default,
                    name: "StudentRegisteredReport",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                {
                    path: "report/Fee-report-View",
                    component: require("../../components/report_components/FeeReportView.vue")
                        .default,
                    name: "FeeReportView",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Exam  - Add Instruction
                {
                    path: "exam/instruction-view",
                    component: require("../../components/exam_components/InstructionView.vue")
                        .default,
                    name: "Instruction",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Exam Schedule - Add Exam Schedule
                {
                    path: "exam/add-schedule-directory",
                    component: require("../../components/exam_components/AddExamScheduleView.vue")
                        .default,
                    name: "AddExamSchedule",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Exam Question Bank
                {
                    path: "exam/question-bank-Directory",
                    component: require("../../components/exam_components/QuestionBankDirectoryView.vue")
                        .default,
                    name: "QuestionBank",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Exam Question Bank - Copy
                {
                    path: "exam/question-bank-copy",
                    component: require("../../components/exam_components/QuestionBankCopyView.vue")
                        .default,
                    name: "QuestionBankCopy",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Exam Question Bank
                {
                    path: "exam/add-question-bank",
                    component: require("../../components/exam_components/AddQuestionBankView.vue")
                        .default,
                    name: "AddQuestionBank",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Exam Question Bank
                {
                    path: "exam/add-question-to-exam",
                    component: require("../../components/exam_components/AddQuestionToExamView.vue")
                        .default,
                    name: "AddQuestionToExam",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Notice - Add Notice
                {
                    path: "notice/add-notice",
                    component: require("../../components/notice_components/NoticeView.vue")
                        .default,
                    name: "Notice",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Notification - Add Notification
                {
                    path: "notification/add-notification",
                    component: require("../../components/notice_components/NotificationView.vue")
                        .default,
                    name: "Notification",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Post - Add POst
                {
                    path: "post/add-post",
                    component: require("../../components/notice_components/PostDirectoryView.vue")
                        .default,
                    name: "Post",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Subscription - Add Subscription Master
                {
                    path: "subscription/add-subscription-master",
                    component: require("../../components/accounts_components/SubscriptionView.vue")
                        .default,
                    name: "Subscription",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Subscription - Assign Subscription
                {
                    path: "subscription/assign-subscription",
                    component: require("../../components/accounts_components/SubscriptionAssignView.vue")
                        .default,
                    name: "AssignSubscription",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Discount - Discount Directory
                {
                    path: "/home/discounts/view-discounts",
                    component: require("../../components/accounts_components/DiscountDirectoryView.vue")
                        .default,
                    name: "Discounts",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                {
                    path: "/home/discounts/add-discount",
                    component: require("../../components/accounts_components/AddDiscount.vue")
                        .default,
                    name: "AddDiscount",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                {
                    path: "/home/fee-generate/view-fee",
                    component: require("../../components/accounts_components/FeeGenerator.vue")
                        .default,
                    name: "FeeGenerator",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                {
                    path: "/home/fee-generate/add-fee-generate",
                    component: require("../../components/accounts_components/AddFeeGenerator.vue")
                        .default,
                    name: "AddFeeGenerator",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                {
                    path: "/home/generated-fees/view-generated-fees",
                    component: require("../../components/accounts_components/GeneratedFees.vue")
                        .default,
                    name: "GeneratedFees",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                {
                    path: "/home/generated-fees/pay-generated-fees",
                    component: require("../../components/accounts_components/PayGeneratedFees.vue")
                        .default,
                    name: "PayGeneratedFees",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Batch Directory
                {
                    path: "batch/batch-directory",
                    component: require("../../components/batch_components/BatchDirectoryView.vue")
                        .default,
                    name: "AddBactch",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Batch Directory
                {
                    path: "report/exam-report",
                    component: require("../../components/report_components/ExamReportView.vue")
                        .default,
                    name: "ExamReport",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Attendance Directory
                {
                    path: "attendance/attendance-directory",
                    component: require("../../components/batch_components/AttendanceDirectoryView.vue")
                        .default,
                    name: "AttendanceDirectory",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Attendance View
                {
                    path: "attendance/attendance-view",
                    component: require("../../components/batch_components/AttendanceView.vue")
                        .default,
                    name: "AttendanceView",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Student Batch Transfer
                {
                    path: "batch/batch-transfer",
                    component: require("../../components/batch_components/StudentBatchTransferView.vue")
                        .default,
                    name: "BatchTransfer",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },

                // Student Details View
                {
                    path: "student/student-details",
                    component: require("../../components/student_components/StudentDetails.vue")
                        .default,
                    name: "StudentDetails",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // All Students
                {
                    path: "student/student-directory",
                    component: require("../../components/student_components/ViewStudentTabView.vue")
                        .default,
                    name: "StudentDirectory",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Edit Students
                {
                    path: "student/edit-directory",
                    component: require("../../components/student_components/EditStudentInfoView.vue")
                        .default,
                    name: "EditStudentInfoView",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // All Course
                {
                    path: "course/courseTab",
                    component: require("../../components/academic_components/CourseDesignView.vue")
                        .default,
                    name: "courseTab",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Library
                {
                    path: "library/BookList",
                    component: require("../../components/library_components/BookList.vue")
                        .default,
                    name: "BookList",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Library - Issue Book
                {
                    path: "library/IssueItems",
                    component: require("../../components/library_components/IssueItems.vue")
                        .default,
                    name: "IssueItems",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Library - Issue Book
                {
                    path: "library/IssueBook",
                    component: require("../../components/library_components/IssueBook.vue")
                        .default,
                    name: "IssueBook",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                },
                // Dashboard
                {
                    path: "dashboard",
                    component: require("../../components/dashboard_components/Dashboard.vue")
                        .default,
                    name: "Dashboard",
                    meta: {
                        requiresAuth: true
                    },
                    props: true
                }
            ]
        }
    ]
});

router.beforeEach((to, from, next) => {
    // check if the route requires authentication and user is not logged in
    if (
        to.matched.some(route => route.meta.requiresAuth) &&
        !store.state.loginState.isLoggedIn
    ) {
        // redirect to login page
        next({ name: "Login" });
        return;
    }

    // if logged in redirect to dashboard
    if (to.path === "/login" && store.state.loginState.isLoggedIn) {
        next({ name: "Home" });
        return;
    }

    next();
});
export default router;
