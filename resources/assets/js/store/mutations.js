const mutations = {

    // ////////////////////////////////////////////
    // SIDEBAR & UI UX
    // ////////////////////////////////////////////
    RESET_ORDER(state){
        state.newOrder = 0
        state.order = []
    },


    SET_NEW_ORDER(state, arg) {
        state.newOrder = state.newOrder + 1
        state.order.splice(0, 0, arg)
    }
}

export default mutations