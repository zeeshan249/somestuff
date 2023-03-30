// This file contains all commit for vuex
import router from '../vuerouter/router'
import SecureLS from 'secure-ls'
var ls=new SecureLS({encodingType: 'aes'})
const mutations = {



  // Updates user logged status
  COMMIT_USER_LOGGED_IN (state) {
    state.loginState.isLoggedIn = true;

    },

    // Update User Logout
    COMMIT_LOGOUT_USER_DATA(state) {
        state.loginState.isLoggedIn = false
        ls.removeAll()

        router.push({
            name: 'Login'
        })
    },

    // Unauthorized logout
    COMMIT_UNAUTHORIZED_LOGOUT_USER_DATA(state) {
        state.loginState.isLoggedIn = false
        ls.removeAll()
        router.push({
            name: 'Unauthorized'
        })
    },



}

export default mutations

