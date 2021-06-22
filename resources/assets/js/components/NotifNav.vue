<template>
    <li class="dropdown messages-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning">{{newOrder}}</span>
        </a>
        <ul class="dropdown-menu">
            <li class="header">You have new {{newOrder}} orders</li>
            <li>
            <!-- inner menu: contains the actual data -->
            <ul class="menu">
                <li v-for="(item, index) in resNotif" :key="index">
                    <a href="#">
                        <div class="pull-left">
                        <div class="notification-icon notification-icon-order"><svg aria-hidden="true" width="15.8" height="14.377777777777778" viewBox="0 0 576 512" focusable="false" class="fa-icon" style="font-size: 0.8em;"><path d="M504.7 320h-293.1l6.5 32h268.4c15.4 0 26.8 14.3 23.4 29.3l-5.5 24.3c18.7 9.1 31.6 28.2 31.6 50.4 0 31.2-25.5 56.4-56.8 56-29.8-0.4-54.3-24.6-55.2-54.4-0.4-16.3 6.1-31 16.8-41.5h-209.6c10.4 10.2 16.8 24.3 16.8 40 0 31.8-26.5 57.4-58.7 55.9-28.5-1.3-51.8-24.4-53.3-52.9-1.2-22 10.4-41.5 28.1-51.6l-70.2-343.4h-69.9c-13.3 0-24-10.7-24-24v-16c0-13.3 10.7-24 24-24h102.5c11.4 0 21.2 8 23.5 19.2l9.2 44.8h392.8c15.4 0 26.8 14.3 23.4 29.3l-47.3 208c-2.5 10.9-12.2 18.7-23.4 18.7zM408 168h-48v-40c0-8.8-7.2-16-16-16h-16c-8.8 0-16 7.2-16 16v40h-48c-8.8 0-16 7.2-16 16v16c0 8.8 7.2 16 16 16h48v40c0 8.8 7.2 16 16 16h16c8.8 0 16-7.2 16-16v-40h48c8.8 0 16-7.2 16-16v-16c0-8.8-7.2-16-16-16z"></path></svg><!----><!----><!----><!----><!----><!----><!----></div>
                        </div>
                        <h4>
                        New Order
                        <!-- <small><i class="fa fa-clock-o"></i> 2 hours</small> -->
                        </h4>
                        <p>{{item.costumer}} membeli {{item.product}}</p>
                    </a>
                </li>
               
            </ul>
            </li>
            <li class="footer"><a href="javascript:;" @click="onMarkAllRead()">Mark as read</a></li>
        </ul>
    </li>
</template>
<script>
export default {
    data(){
        return{
            notif:[]
        }
    },

    created(){
        this.fetNotif()
    },

    computed:{
        newOrder(){
            let a = this.$store.getters.order.length
            let b = this.notif.length
            return a + b
        },

        resNotif(){
            let fromStore = this.$store.getters.order
            return [...fromStore, ...this.notif]
        }
    },

    methods:{
        async fetNotif(){
            try {
                let notif = await axios.get('/backend/notif')
                notif = notif.data
                if(notif.status){
                    this.notif = notif.data
                }
            } catch (error) {
                throw error
            }
        },

        async onMarkAllRead(){
            try {
                let notif = await axios.post('/backend/notif')
                 notif = notif.data
                if(notif.status){
                    this.notif = []
                    return this.$store.dispatch('resetOrder')
                }
            } catch (error) {
                throw error
            }
        }
    }
}
</script>