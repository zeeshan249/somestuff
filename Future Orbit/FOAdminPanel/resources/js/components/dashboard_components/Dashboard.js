// Secure Local Storage
import SecureLS from "secure-ls";
import { Global } from "../../components/helpers/global";
const ls = new SecureLS({ encodingType: "aes" });
import DatetimePicker from "vuetify-datetime-picker";
//PDF Export
import jsPDF from "jspdf";
import "jspdf-autotable";
import Vue from "vue";
Vue.use(DatetimePicker);
import VueMask from "v-mask";
Vue.use(VueMask);
export const Dashboard = {
    props: ["userPermissionDataProps"],

    data() {
        return {
            loggedInUserFirstName: null,
            usrLastLoginTime: null,
            roleId: null,
            attendanceStatus: null,
            isLoaderActive: false,
            authorizationConfig: "",
            latitude: null,
            longitude: null,
            labels: ["SU", "MO", "TU", "WED", "TH", "FR", "SA"],
            time: 0,
            forecast: [
                {
                    day: "Sunday",
                    icon: "mdi-nature-people",
                    temp: "MATH - 12:00"
                },
                {
                    day: "Sunday",
                    icon: "mdi-medical-bag",
                    temp: "CHEM - 15:00"
                },
                {
                    day: "Sunday",
                    icon: "mdi-medical-bag",
                    temp: "PHY - 12:00"
                }
            ],
            items: [
                { header: "Today" },
                {
                    avatar: "https://cdn.vuetifyjs.com/images/lists/1.jpg",
                    title: "Brunch this weekend?",
                    subtitle: `<span class="text--primary">Ali Connors</span> &mdash; I'll be in your neighborhood doing errands this weekend. Do you want to hang out?`
                },
                { divider: true, inset: true },
                {
                    avatar: "https://cdn.vuetifyjs.com/images/lists/2.jpg",
                    title:
                        'Summer BBQ <span class="grey--text text--lighten-1">4</span>',
                    subtitle: `<span class="text--primary">to Alex, Scott, Jennifer</span> &mdash; Wish I could come, but I'm out of town this weekend.`
                },
                { divider: true, inset: true },
                {
                    avatar: "https://cdn.vuetifyjs.com/images/lists/3.jpg",
                    title: "Oui oui",
                    subtitle:
                        '<span class="text--primary">Sandra Adams</span> &mdash; Do you have Paris recommendations? Have you ever been?'
                },
                { divider: true, inset: true },
                {
                    avatar: "https://cdn.vuetifyjs.com/images/lists/4.jpg",
                    title: "Birthday gift",
                    subtitle:
                        '<span class="text--primary">Trevor Hansen</span> &mdash; Have any ideas about what we should get Heidi for her birthday?'
                },
                { divider: true, inset: true },
                {
                    avatar: "https://cdn.vuetifyjs.com/images/lists/5.jpg",
                    title: "Recipe to try",
                    subtitle:
                        '<span class="text--primary">Britta Holt</span> &mdash; We should eat this: Grate, Squash, Corn, and tomatillo Tacos.'
                }
            ]
        };
    },
    watch: {},
    computed: {},
    created() {
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") }
        };
        this.loggedInUserFirstName = ls.get("lms_staff_first_name");
        this.usrLastLoginTime = ls.get("lms_user_last_login_date");
        this.roleId = ls.get("role_id");
        this.getStaffAttendanceStatus();
        this.getGeoLocation();
        //this.getStreetAddressFrom();
    },
    methods: {
        getGeoLocation() {
            navigator.geolocation.getCurrentPosition(
                position => {
                    this.longitude = position.coords.longitude;
                    this.latitude = position.coords.latitude;
                    console.log(position.coords.latitude);
                    console.log(position.coords.longitude);
                },
                error => {
                    console.log(error.message);
                }
            );
        },
        async getStreetAddressFrom(lat, long) {
            try {
                var { data } = await axios.get(
                    "https://maps.googleapis.com/maps/api/geocode/json?latlng=" +
                        lat +
                        "," +
                        long +
                        "&key={yourAPIKey}"
                );
                if (data.error_message) {
                    console.log(data.error_message);
                } else {
                    this.address = data.results[0].formatted_address;
                }
            } catch (error) {
                console.log(error.message);
            }
        },
        //Staff attendance Status
        getStaffAttendanceStatus() {
            this.$http
                .get(`web_staff_attendance_status`, {
                    params: {
                        centerId: ls.get("loggedUserCenterId"),
                        loggedUserId: ls.get("loggedUserId"),
                        roleId: this.roleId,
                        longitude: this.longitude,
                        latitude: this.latitude
                    },
                    headers: {
                        Authorization: "Bearer " + ls.get("token")
                    }
                })
                .then(({ data }) => {
                    this.tableDataLoading = false;
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        if (data.responseData == 0) {
                            this.attendanceStatus = 0;
                        } else if (data.responseData == 1) {
                            this.attendanceStatus = 1;
                        } else {
                            this.attendanceStatus = 2;
                        }
                    }
                })
                .catch(error => {
                    this.tableDataLoading = false;
                    Global.showErrorAlert(
                        true,
                        "error",
                        this.$t("label_something_went_wrong"),
                        null
                    );
                });
        },

        //Staff attendance
        staffAttendance() {
            //   this.isLoaderActive = true;
            this.$http
                .post(
                    "web_staff_attendance",
                    {
                        centerId: ls.get("loggedUserCenterId"),
                        loggedUserId: ls.get("loggedUserId"),
                        roleId: this.roleId,
                        longitude: this.longitude,
                        latitude: this.latitude
                    },
                    this.authorizationConfig
                )
                .then(({ data }) => {
                    //this.isLoaderActive = false;
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                        // Course Disabled
                        if (data.responseData == 1) {
                            Global.showSuccessAlert(
                                true,
                                "success",
                                "Welcome to Future Orbit!!! Have a great day",
                                null
                            );
                            this.getStaffAttendanceStatus();
                        } else if (data.responseData == 2) {
                            Global.showSuccessAlert(
                                true,
                                "success",
                                "Thanks Team!!!",
                                null
                            );
                            this.getStaffAttendanceStatus();
                        }
                        // Course Disabled failed
                        else if (data.responseData == 3) {
                            Global.showErrorAlert(
                                true,
                                "error",
                                this.$t("label_something_went_wrong"),
                                null
                            );
                        }
                    }
                })
                .catch(error => {
                    //this.isLoaderActive = false;
                    Global.showErrorAlert(
                        true,
                        "error",
                        this.$t("label_something_went_wrong"),
                        null
                    );
                });
        }
    }
};
