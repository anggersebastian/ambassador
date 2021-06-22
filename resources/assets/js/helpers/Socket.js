import Vue from 'vue'
import VueSocketIOExt from 'vue-socket.io-extended'
import io from 'socket.io-client';
const socket = io(process.env.MIX_DROPY_HOST+'/admin-page')
 
Vue.use(VueSocketIOExt, socket);