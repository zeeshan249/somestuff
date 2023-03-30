// This file contains all vuex state
const state = {

    // Contains Login State
    loginState: {
        isLoggedIn: !!localStorage.getItem('token'),
    },

    
}

export default state
