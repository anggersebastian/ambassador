const actions = {

    playNotif({ commit }, params) {
      let sound = new Audio(process.env.MIX_HOST+'/audio/notif.webm')
      sound.type = 'audio/mpeg'
      commit('SET_NEW_ORDER', params)
      return sound.play()
    },

    resetOrder({commit}){
      console.log('wowo')
      commit('RESET_ORDER')
    }

}

export default actions