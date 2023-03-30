// This file contains all vuex actions
import router from '../vuerouter/router'
import axios from '../axios/axios'
const actions = {


    // Logout
    actionLogout({ commit }) {

        axios
        .post("auth/web_logout")
            .then(({ data }) =>
            {
            commit('COMMIT_LOGOUT_USER_DATA')
        })
        .catch(error => {});
    },
    // Unauthorized logout
    actionUnauthorizedLogout({ commit }) {

        axios
        .post("auth/web_logout")
            .then(({ data }) =>
            {
            commit('COMMIT_UNAUTHORIZED_LOGOUT_USER_DATA')
        })
        .catch(error => {});
    },


}

export default actions
