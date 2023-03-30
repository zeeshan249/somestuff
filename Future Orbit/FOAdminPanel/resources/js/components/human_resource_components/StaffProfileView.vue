<template>
    <div id="app">
        <v-container
        fluid
        style="background-color: #e4e8e4; max-width: 100% !important"
        
        >
        <v-sheet class="pa-4 mb-4" >
            <v-breadcrumbs :items="breadCrumbItem">
                <template v-slot:divider>
                    <v-icon>mdi-forward</v-icon>
                </template>
            </v-breadcrumbs>
        </v-sheet>
            <v-card max-width="100%" class="mx-auto">
                <v-app-bar dark color="primary">
                    <v-app-bar-nav-icon></v-app-bar-nav-icon>
                    <v-toolbar-title>{{
                        staffDetails.lms_user_full_name
                    }}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn icon>
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </v-app-bar>
                <v-container
                fluid
                 style="background-color: #e4e8e4; max-width: 100% !important"
      
                >
                    <v-row justify="center" dense="">
                        <v-col cols="12" md="4">
                            <v-skeleton-loader
                                :loading="isDataLoading"
                                class="mb-6"
                                type="card-avatar, article"
                            >
                                <v-card
                                    class="mx-auto"
                                    max-width="374"
                                    outlined=""
                                >
                                    <v-img
                                        height="250"
                                        :src="backgroundImage"
                                        class="d-flex"
                                        :lazy-src="backgroundImage"
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
                                        <v-avatar
                                            size="100"
                                            style="                                               position: absolute;
                                                bottom: 0px;
                                                left: 50%;
                                                margin-left: -50px;
                                            "
                                        >
                                            <v-img
                                                height="100"
                                                width="100"
                                                :src="userProfileImage"
                                                :lazy-src="userProfileImage"
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
                                    </v-img>

                                    <v-card-title
                                        >{{ staffDetails.lms_staff_full_name }}
                                        <div class="text-caption text-grey">
                                            {{ $t("label_member_since") }}
                                            {{
                                                staffDetails.lms_staff_created_at
                                            }}
                                        </div></v-card-title
                                    >

                                    <v-card-text>
                                        <div class="mt-2">
                                            <v-icon>mdi-phone</v-icon>
                                            <strong>{{
                                                staffDetails.lms_staff_mobile_number
                                            }}</strong>
                                        </div>
                                        <div class="mt-2">
                                            <v-icon>mdi-email</v-icon>
                                            <strong>{{
                                                staffDetails.lms_staff_email
                                            }}</strong>
                                        </div>

                                        <div class="mt-2">
                                            <v-icon>mdi-account</v-icon>
                                            {{
                                                staffDetails.lms_staff_about !=
                                                    null &&
                                                staffDetails.lms_staff_about !=
                                                    ""
                                                    ? staffDetails.lms_staff_about
                                                    : $t(
                                                          "label_about_staff_not_updated"
                                                      )
                                            }}
                                        </div>
                                    </v-card-text>

                                    <v-divider class="mx-4 p-0 m-0"></v-divider>

                                    <v-chip-group
                                        active-class="success white--text"
                                        column
                                        class="mt-2 ml-2 p-0"
                                    >
                                        <v-chip
                                            class="ma-2"
                                            color="indigo"
                                            text-color="white"
                                        >
                                            <v-avatar left>
                                                <v-icon>mdi-facebook</v-icon>
                                            </v-avatar>
                                            {{
                                                staffDetails.lms_staff_facebook !=
                                                    null &&
                                                staffDetails.lms_staff_facebook !=
                                                    ""
                                                    ? staffDetails.lms_staff_facebook
                                                    : $t("label_not_updated")
                                            }}
                                        </v-chip>
                                        <v-chip
                                            class="ma-2"
                                            color="indigo"
                                            text-color="white"
                                        >
                                            <v-avatar left>
                                                <v-icon>mdi-twitter</v-icon>
                                            </v-avatar>
                                            {{
                                                staffDetails.lms_staff_twitter !=
                                                    null &&
                                                staffDetails.lms_staff_twitter !=
                                                    ""
                                                    ? staffDetails.lms_staff_twitter
                                                    : $t("label_not_updated")
                                            }}
                                        </v-chip>
                                        <v-chip
                                            class="ma-2"
                                            color="indigo"
                                            text-color="white"
                                        >
                                            <v-avatar left>
                                                <v-icon>mdi-whatsapp</v-icon>
                                            </v-avatar>
                                            {{
                                                staffDetails.lms_staff_whatsapp !=
                                                    null &&
                                                staffDetails.lms_staff_whatsapp !=
                                                    ""
                                                    ? staffDetails.lms_staff_whatsapp
                                                    : $t("label_not_updated")
                                            }}
                                        </v-chip>
                                        <v-chip
                                            class="ma-2"
                                            color="indigo"
                                            text-color="white"
                                        >
                                            <v-avatar left>
                                                <v-icon>mdi-linkedin</v-icon>
                                            </v-avatar>
                                            {{
                                                staffDetails.lms_staff_linkedin !=
                                                    null &&
                                                staffDetails.lms_staff_linkedin !=
                                                    ""
                                                    ? staffDetails.lms_staff_linkedin
                                                    : $t("label_not_updated")
                                            }}
                                        </v-chip>
                                        <v-chip
                                            class="ma-2"
                                            color="indigo"
                                            text-color="white"
                                        >
                                            <v-avatar left>
                                                <v-icon>mdi-instagram</v-icon>
                                            </v-avatar>
                                            {{
                                                staffDetails.lms_staff_instagram !=
                                                    null &&
                                                staffDetails.lms_staff_instagram !=
                                                    ""
                                                    ? staffDetails.lms_staff_instagram
                                                    : $t("label_not_updated")
                                            }}
                                        </v-chip>
                                    </v-chip-group>
                                </v-card>
                            </v-skeleton-loader>
                        </v-col>

                        <v-col cols="12" md="8">
                            <v-skeleton-loader
                                :loading="isDataLoading"
                                class="mb-6"
                                type="list-item, table-tbody, list-item, table-tbody,list-item, list-item-three-line"
                            >
                                <v-expansion-panels popout>
                                    <v-expansion-panel hide-actions>
                                        <v-expansion-panel-header>
                                            <v-row
                                                align="center"
                                                class="spacer"
                                                no-gutters
                                            >
                                                <v-col cols="4" sm="2" md="1">
                                                    <v-avatar
                                                        size="36px"
                                                        color="primary"
                                                    >
                                                        <v-icon dark
                                                            >mdi-phone</v-icon
                                                        >
                                                    </v-avatar>
                                                </v-col>
                                                <v-col
                                                    class="hidden-xs-only"
                                                    sm="5"
                                                    md="3"
                                                >
                                                    <strong>{{
                                                        $t("label_basic_info")
                                                    }}</strong>
                                                </v-col>

                                                <v-col
                                                    class="hidden-xs-only"
                                                    sm="5"
                                                    md="3"
                                                >
                                                    <strong
                                                        >{{ $t("label_role") }}
                                                        :
                                                    </strong>
                                                    {{ staffDetails.role_name }}
                                                </v-col>
                                                <v-col cols="4" sm="2" md="1">
                                                    <v-avatar
                                                        size="36px"
                                                        color="primary"
                                                    >
                                                        <v-icon dark
                                                            >mdi-lock-reset</v-icon
                                                        >
                                                    </v-avatar>
                                                </v-col>
                                                <v-col
                                                    class="hidden-xs-only"
                                                    sm="5"
                                                    md="3"
                                                >
                                                    <v-text-field
                                                        readonly
                                                        v-model="
                                                            staffDetails.password_normal
                                                        "
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
                                                    >
                                                    <strong>Password : </strong>
                                                    </v-text-field>

                                                    
                                                </v-col>
                                            </v-row>
                                            <v-row align="center" justify="start" class="mb-2">
                                        <v-switch
                                            class="mx-2"
                                            inset
                                            :label="
                                                staffDetails.lms_is_user_logged
                                                    ? 'User Logged In'
                                                    : 'User Logged Out'
                                            "
                                            v-model="
                                                 staffDetails.lms_is_user_logged
                                            "
                                            @change="loggedInStaffStatus(staffDetails.lms_is_user_logged, staffDetails.lms_user_id)"
                                        >
                                        </v-switch>
                                    </v-row>
                                        </v-expansion-panel-header>

                                        <v-expansion-panel-content>
                                            <v-divider></v-divider>
                                            <v-row dense="" class="ml-4">
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{ $t("label_code") }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_code
                                                    }}
                                                </v-col>
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_department"
                                                            )
                                                        }}
                                                        :</strong
                                                    >
                                                    {{
                                                        staffDetails.lms_department_name !=
                                                            null &&
                                                        staffDetails.lms_department_name !=
                                                            ""
                                                            ? staffDetails.lms_department_name
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>
                                            <v-row dense="" class="ml-4">
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_designation"
                                                            )
                                                        }}
                                                        :</strong
                                                    >
                                                    {{
                                                        staffDetails.lms_designation_name !=
                                                            null &&
                                                        staffDetails.lms_designation_name !=
                                                            ""
                                                            ? staffDetails.lms_designation_name
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>
                                            <v-row dense="" class="ml-4 mt-4">
                                                <v-col cols="12" md="3" sm="6">
                                                    <v-icon>mdi-account</v-icon>
                                                    <strong>{{
                                                        $t(
                                                            "label_personal_details"
                                                        )
                                                    }}</strong>
                                                </v-col>
                                                <v-col cols="12" md="9" sm="6">
                                                    <v-divider></v-divider>
                                                </v-col>
                                            </v-row>

                                            <v-row dense="" class="ml-4 mt-2">
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_father_name"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_father_name !=
                                                            null &&
                                                        staffDetails.lms_staff_father_name !=
                                                            ""
                                                            ? staffDetails.lms_staff_father_name
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_mother_name"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_mother_name !=
                                                            null &&
                                                        staffDetails.lms_staff_mother_name !=
                                                            ""
                                                            ? staffDetails.lms_staff_mother_name
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>

                                            <v-row dense="" class="ml-4 mt-2">
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        ><strong
                                                            >{{
                                                                $t("label_dob")
                                                            }}
                                                            :
                                                        </strong>
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_date_of_birth
                                                    }}
                                                </v-col>
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{ $t("label_doj") }} :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_date_of_joining !=
                                                            null &&
                                                        staffDetails.lms_staff_date_of_joining !=
                                                            ""
                                                            ? staffDetails.lms_staff_date_of_joining
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>

                                            <v-row dense="" class="ml-4 mt-2">
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        ><strong
                                                            >{{
                                                                $t(
                                                                    "label_gender"
                                                                )
                                                            }}
                                                            :
                                                        </strong>
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_gender
                                                    }}
                                                </v-col>
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_marital_status"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_marital_status !=
                                                            null &&
                                                        staffDetails.lms_staff_marital_status !=
                                                            ""
                                                            ? staffDetails.lms_staff_marital_status
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>

                                            <v-row dense="" class="ml-4 mt-4">
                                                <v-col cols="12" md="3" sm="6">
                                                    <v-icon
                                                        >mdi-contacts</v-icon
                                                    >
                                                    <strong>{{
                                                        $t(
                                                            "label_contact_details"
                                                        )
                                                    }}</strong>
                                                </v-col>
                                                <v-col cols="12" md="9" sm="6">
                                                    <v-divider></v-divider>
                                                </v-col>
                                            </v-row>

                                            <v-row dense="" class="ml-4 mt-2">
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_mobile_number"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_mobile_number !=
                                                            null &&
                                                        staffDetails.lms_staff_mobile_number !=
                                                            ""
                                                            ? staffDetails.lms_staff_mobile_number
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_emergency_contact_number"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_emergency_contact !=
                                                            null &&
                                                        staffDetails.lms_staff_emergency_contact !=
                                                            ""
                                                            ? staffDetails.lms_staff_emergency_contact
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>

                                            <v-row dense="" class="ml-4 mt-2">
                                                <v-col cols="12" md="12" sm="6">
                                                    <strong
                                                        >{{ $t("label_email") }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_email !=
                                                            null &&
                                                        staffDetails.lms_staff_email !=
                                                            ""
                                                            ? staffDetails.lms_staff_email
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>

                                            <v-row dense="" class="ml-4 mt-2">
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_current_address"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_local_address !=
                                                            null &&
                                                        staffDetails.lms_staff_local_address !=
                                                            ""
                                                            ? staffDetails.lms_staff_local_address
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_permanent_address"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_permanent_address !=
                                                            null &&
                                                        staffDetails.lms_staff_permanent_address !=
                                                            ""
                                                            ? staffDetails.lms_staff_permanent_address
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>

                                    <!-- Bank Account Details Started -->
                                    <v-expansion-panel hide-actions>
                                        <v-expansion-panel-header>
                                            <v-row
                                                align="center"
                                                class="spacer"
                                                no-gutters
                                            >
                                                <v-col cols="4" sm="2" md="1">
                                                    <v-avatar
                                                        size="36px"
                                                        color="primary"
                                                    >
                                                        <v-icon dark
                                                            >mdi-cards</v-icon
                                                        >
                                                    </v-avatar>
                                                </v-col>
                                                <v-col
                                                    class="hidden-xs-only"
                                                    sm="5"
                                                    md="3"
                                                >
                                                    <strong>{{
                                                        $t(
                                                            "label_bank_account_details"
                                                        )
                                                    }}</strong>
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-header>

                                        <v-expansion-panel-content>
                                            <v-divider></v-divider>
                                            <v-row dense="" class="ml-4">
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_account_title"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_account_title !=
                                                            null &&
                                                        staffDetails.lms_staff_account_title !=
                                                            ""
                                                            ? staffDetails.lms_staff_account_title
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_bank_account_number"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_bank_account_number !=
                                                            null &&
                                                        staffDetails.lms_staff_bank_account_number !=
                                                            ""
                                                            ? staffDetails.lms_staff_bank_account_number
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>

                                            <v-row dense="" class="ml-4 mt-2">
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_bank_name"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_bank_name !=
                                                            null &&
                                                        staffDetails.lms_staff_bank_name !=
                                                            ""
                                                            ? staffDetails.lms_staff_bank_name
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                                <v-col cols="12" md="6" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_ifsc_code"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_bank_ifsc_code !=
                                                            null &&
                                                        staffDetails.lms_staff_bank_ifsc_code !=
                                                            ""
                                                            ? staffDetails.lms_staff_bank_ifsc_code
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>

                                            <v-row dense="" class="ml-4 mt-2">
                                                <v-col cols="12" md="12" sm="6">
                                                    <strong
                                                        >{{
                                                            $t(
                                                                "label_bank_branch_name"
                                                            )
                                                        }}
                                                        :
                                                    </strong>
                                                    {{
                                                        staffDetails.lms_staff_bank_branch !=
                                                            null &&
                                                        staffDetails.lms_staff_bank_branch !=
                                                            ""
                                                            ? staffDetails.lms_staff_bank_branch
                                                            : $t(
                                                                  "label_not_updated"
                                                              )
                                                    }}
                                                </v-col>
                                            </v-row>
                                        </v-expansion-panel-content>
                                    </v-expansion-panel>
                                    <!-- Bank Account Details end -->

                                    <!-- Upload Documents Started -->
                                    <v-expansion-panel hide-actions>
                                        <v-card
                                            max-width="100%"
                                            class="mx-auto"
                                        >
                                            <v-toolbar color="light-blue" dark>
                                                <v-avatar
                                                    size="36px"
                                                    color="white"
                                                    class="ml-2"
                                                >
                                                    <v-icon color="primary"
                                                        >mdi-cards</v-icon
                                                    >
                                                </v-avatar>

                                                <v-toolbar-title class="ml-2">{{
                                                    $t("label_documents")
                                                }}</v-toolbar-title>

                                                <v-spacer></v-spacer>
                                            </v-toolbar>

                                            <v-list two-line subheader>
                                                <v-list-item
                                                    v-for="item in downloadItems"
                                                    :key="item.title"
                                                >
                                                    <v-list-item-avatar>
                                                        <v-icon
                                                            :class="[
                                                                item.iconClass,
                                                            ]"
                                                            v-text="item.icon"
                                                        ></v-icon>
                                                    </v-list-item-avatar>

                                                    <v-list-item-content>
                                                        <v-list-item-title
                                                            v-text="item.title"
                                                        ></v-list-item-title>
                                                        <v-list-item-subtitle
                                                            v-text="
                                                                item.subtitle
                                                            "
                                                        ></v-list-item-subtitle>
                                                    </v-list-item-content>

                                                    <v-list-item-action>
                                                        <v-btn icon>
                                                            <v-icon
                                                                color="success lighten-1"
                                                                v-show="
                                                                    item.downloadLink !=
                                                                    false
                                                                "
                                                                @click="
                                                                    downloadDocument(
                                                                        item.type
                                                                    )
                                                                "
                                                                >mdi-cloud-download</v-icon
                                                            >
                                                        </v-btn>
                                                    </v-list-item-action>
                                                </v-list-item>
                                            </v-list>
                                        </v-card>
                                    </v-expansion-panel>
                                    <!-- Upload Documents end -->
                                </v-expansion-panels>
                            </v-skeleton-loader>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card>

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
        </v-container>
    </div>
</template>

<script>
// Secure Local Storage
import SecureLS from "secure-ls";
const ls = new SecureLS({ encodingType: "aes" });

export default {
    data() {
        return {
            isPasswordVisible: false,
            // For Breadcrumb
            breadCrumbItem: [
                {
                    text: this.$t("label_home"),
                    disabled: false,
                },
                {
                    text: this.$t("label_human_resource"),
                    disabled: false,
                },
                {
                    text: this.$t("label_staff_details"),
                    disabled: false,
                },
            ],
            staffUserId: "",
            isDataLoading: false,
            authorizationConfig: "",
            staffDetails: "",
            // Snack Bar

            isSnackBarVisible: false,
            snackBarMessage: "",
            snackBarColor: "",
            backgroundImage: process.env.MIX_IMAGE_URL_FOR_VIEW_STAFF,
            userProfileImage: "",

            downloadItems: [],
            isJoiningLetterDownloading: false,
            isResignationLetterDownloading: false,
            isResumeDownloading: false,
            isAadharCardDownloading: false,
            isPanCardDownloading: false,
            isVoterCardDownloading: false,
            downloadImageUrl: "",
        };
    },
    created() {
        this.staffUserId = this.$route.params.staffUserId;
        // Token Config
        this.authorizationConfig = {
            headers: { Authorization: "Bearer " + ls.get("token") },
        };
        this.getStaffDetailsIdWise();
    },
    methods: {
        // Get Staff Details Id wise
        getStaffDetailsIdWise() {
            this.isDataLoading = true;

            this.$http
                .post(
                    "web_get_staff_details_id_wise",
                    { staffUserId: this.staffUserId },
                    this.authorizationConfig
                )
                .then(({ data }) => {
                    this.isDataLoading = false;
                    //User Unauthorized
                    if (
                        data.error == "Unauthorized" ||
                        data.permissionError == "Unauthorized"
                    ) {
                        this.$store.dispatch("actionUnauthorizedLogout");
                    } else {
                       
                        this.staffDetails = data[0];
                        this.userProfileImage =
                            this.staffDetails.lms_staff_profile_image != null &&
                            this.staffDetails.lms_staff_profile_image != ""
                                ? process.env.MIX_USER_PROFILE_IMAGE_URL +
                                  this.staffDetails.lms_staff_profile_image
                                : process.env.MIX_USER_PROFILE_IMAGE_URL +
                                  "default.png";
                        this.downloadItems = [
                            {
                                type: "j",
                                icon: "mdi-file",
                                iconClass: "blue white--text",
                                title: this.$t("label_joining_letter"),
                                subtitle:
                                    this.staffDetails
                                        .lms_staff_joining_letter_path !=
                                        null &&
                                    this.staffDetails
                                        .lms_staff_joining_letter_path != ""
                                        ? this.staffDetails
                                              .lms_staff_joining_letter_path
                                        : this.$t("label_not_updated"),
                                downloadLink:
                                    this.staffDetails
                                        .lms_staff_joining_letter_path !=
                                        null &&
                                    this.staffDetails
                                        .lms_staff_joining_letter_path != ""
                                        ? this.staffDetails
                                              .lms_staff_joining_letter_path
                                        : false,
                            },
                            {
                                type: "r",
                                icon: "mdi-file",
                                iconClass: "blue white--text",
                                title: this.$t("label_resume"),
                                subtitle:
                                    this.staffDetails.lms_staff_resume_path !=
                                        null &&
                                    this.staffDetails.lms_staff_resume_path !=
                                        ""
                                        ? this.staffDetails
                                              .lms_staff_resume_path
                                        : this.$t("label_not_updated"),
                                downloadLink:
                                    this.staffDetails.lms_staff_resume_path !=
                                        null &&
                                    this.staffDetails.lms_staff_resume_path !=
                                        ""
                                        ? this.staffDetails
                                              .lms_staff_resume_path
                                        : false,
                            },
                            {
                                type: "re",
                                icon: "mdi-file",
                                iconClass: "amber white--text",
                                title: this.$t("label_resignation_letter"),
                                subtitle:
                                    this.staffDetails
                                        .lms_staff_resignation_letter_path !=
                                        null &&
                                    this.staffDetails
                                        .lms_staff_resignation_letter_path != ""
                                        ? this.staffDetails
                                              .lms_staff_resignation_letter_path
                                        : this.$t("label_not_updated"),
                                downloadLink:
                                    this.staffDetails
                                        .lms_staff_resignation_letter_path !=
                                        null &&
                                    this.staffDetails
                                        .lms_staff_resignation_letter_path != ""
                                        ? this.staffDetails
                                              .lms_staff_resignation_letter_path
                                        : false,
                            },
                            {
                                type: "p",
                                icon: "mdi-file",
                                iconClass: "blue white--text",
                                title: this.$t("label_pan_card"),
                                subtitle:
                                    this.staffDetails.lms_staff_pan_path !=
                                        null &&
                                    this.staffDetails.lms_staff_pan_path != ""
                                        ? this.staffDetails.lms_staff_pan_path
                                        : this.$t("label_not_updated"),
                                downloadLink:
                                    this.staffDetails.lms_staff_pan_path !=
                                        null &&
                                    this.staffDetails.lms_staff_pan_path != ""
                                        ? this.staffDetails.lms_staff_pan_path
                                        : false,
                            },
                            {
                                type: "a",
                                icon: "mdi-file",
                                iconClass: "amber white--text",
                                title: this.$t("label_aadhar_card"),
                                subtitle:
                                    this.staffDetails.lms_staff_aadhar_path !=
                                        null &&
                                    this.staffDetails.lms_staff_aadhar_path !=
                                        ""
                                        ? this.staffDetails
                                              .lms_staff_aadhar_path
                                        : this.$t("label_not_updated"),
                                downloadLink:
                                    this.staffDetails.lms_staff_aadhar_path !=
                                        null &&
                                    this.staffDetails.lms_staff_aadhar_path !=
                                        ""
                                        ? this.staffDetails
                                              .lms_staff_aadhar_path
                                        : false,
                            },
                            {
                                type: "v",
                                icon: "mdi-file",
                                iconClass: "blue white--text",
                                title: this.$t("label_voter_card"),
                                subtitle:
                                    this.staffDetails
                                        .lms_staff_voter_card_path != null &&
                                    this.staffDetails
                                        .lms_staff_voter_card_path != ""
                                        ? this.staffDetails
                                              .lms_staff_voter_card_path
                                        : this.$t("label_not_updated"),
                                downloadLink:
                                    this.staffDetails
                                        .lms_staff_voter_card_path != null &&
                                    this.staffDetails
                                        .lms_staff_voter_card_path != ""
                                        ? this.staffDetails
                                              .lms_staff_voter_card_path
                                        : false,
                            },
                        ];
                    }
                })
                .catch((error) => {
                    this.isDataLoading = false;
                    this.isSnackBarVisible = true;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
                });
        },
              // Enable  Disable Logged In User Status
              loggedInStaffStatus(item,user, $event) {
                 // console.log("sadsd",user)
         
                this.isDataProcessing = true;
                this.$http
                    .post(
                        "web_get_logged_in_user_status",
                        {
                        
                            status:
                                item != '1' ? 0 : 1,
                            staffUserId: user
                        },
                        this.authorizationConfig
                    )
                    .then(({ data }) => {
                        this.isDataProcessing = false;
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
                                  "Successfully Changed Login Status"
                                );
                           
                            }
                            // Staff Status changed failed
                            else if (data.responseData == 2) {
                                this.snackBarColor = "error";
                                this.changeSnackBarMessage(
                                    this.$t("label_something_went_wrong")
                                );
                            }
                        }
                    })
                    .catch(error => {
                        this.isDataProcessing = false;
                        this.snackBarColor = "error";
                        this.changeSnackBarMessage(
                            this.$t("label_something_went_wrong")
                        );
                    });
            
        },

        // Change Snack bar message
        changeSnackBarMessage(data) {
            this.isSnackBarVisible = true;
            this.snackBarMessage = data;
        },
        downloadDocument(typeOfImage) {
            if (typeOfImage == "a") {
                this.isAadharCardDownloading = true;
                this.downloadImageUrl =
                    process.env.MIX_STAFF_DOCUMENT_URL +
                    this.staffDetails.lms_staff_aadhar_path;
            }
            if (typeOfImage == "p") {
                this.isPanCardDownloading = true;
                this.downloadImageUrl =
                    process.env.MIX_STAFF_DOCUMENT_URL +
                    this.staffDetails.lms_staff_pan_path;
            }
            if (typeOfImage == "v") {
                this.isVoterCardDownloading = true;
                this.downloadImageUrl =
                    process.env.MIX_STAFF_DOCUMENT_URL +
                    this.staffDetails.lms_staff_voter_card_path;
            }
            if (typeOfImage == "r") {
                this.isResumeDownloading = true;
                this.downloadImageUrl =
                    process.env.MIX_STAFF_DOCUMENT_URL +
                    this.staffDetails.lms_staff_resume_path;
            }
            if (typeOfImage == "re") {
                this.isResignationLetterDownloading = true;
                this.downloadImageUrl =
                    process.env.MIX_STAFF_DOCUMENT_URL +
                    this.staffDetails.lms_staff_resignation_letter_path;
            }
            if (typeOfImage == "j") {
                this.isJoiningLetterDownloading = true;
                this.downloadImageUrl =
                    process.env.MIX_STAFF_DOCUMENT_URL +
                    this.staffDetails.lms_staff_joining_letter_path;
            }

            this.$http({
                url: this.downloadImageUrl,

                method: "GET",
                responseType: "blob",
                headers: { Authorization: "Bearer " + ls.get("token") },
            })
                .then((response) => {
                    if (typeOfImage == "a") {
                        this.isAadharCardDownloading = false;
                    }
                    if (typeOfImage == "p") {
                        this.isPanCardDownloading = false;
                    }
                    if (typeOfImage == "v") {
                        this.isVoterCardDownloading = false;
                    }
                    if (typeOfImage == "j") {
                        this.isJoiningLetterDownloading = false;
                    }
                    if (typeOfImage == "r") {
                        this.isResumeDownloading = false;
                    }
                    if (typeOfImage == "re") {
                        this.isResignationLetterDownloading = false;
                    }
                    var fileURL = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    var fileLink = document.createElement("a");
                    fileLink.href = fileURL;
                    if (typeOfImage == "a") {
                        fileLink.setAttribute(
                            "download",
                            this.staffDetails.lms_staff_aadhar_path
                        );
                    }
                    if (typeOfImage == "p") {
                        fileLink.setAttribute(
                            "download",
                            this.staffDetails.lms_staff_pan_path
                        );
                    }
                    if (typeOfImage == "v") {
                        fileLink.setAttribute(
                            "download",
                            this.staffDetails.lms_staff_voter_card_path
                        );
                    }
                    if (typeOfImage == "r") {
                        fileLink.setAttribute(
                            "download",
                            this.staffDetails.lms_staff_resume_path
                        );
                    }
                    if (typeOfImage == "re") {
                        fileLink.setAttribute(
                            "download",
                            this.staffDetails.lms_staff_resignation_letter_path
                        );
                    }
                    if (typeOfImage == "j") {
                        fileLink.setAttribute(
                            "download",
                            this.staffDetails.lms_staff_joining_letter_path
                        );
                    }
                    document.body.appendChild(fileLink);
                    fileLink.click();
                })
                .catch((error) => {
                    if (typeOfImage == "a") {
                        this.isAadharCardDownloading = false;
                    }
                    if (typeOfImage == "p") {
                        this.isPanCardDownloading = false;
                    }
                    if (typeOfImage == "v") {
                        this.isVoterCardDownloading = false;
                    }
                    if (typeOfImage == "r") {
                        this.isResumeDownloading = false;
                    }
                    if (typeOfImage == "re") {
                        this.isResignationLetterDownloading = false;
                    }
                    if (typeOfImage == "j") {
                        this.isJoiningLetterDownloading = false;
                    }
                    this.isSnackBarVisible = true;
                    this.snackBarColor = "error";
                    this.changeSnackBarMessage(
                        this.$t("label_something_went_wrong")
                    );
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
