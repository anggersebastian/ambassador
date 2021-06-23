<template>
    <div class="row">
        <div class="col-md-12 mb2 range-date">
            <div class="range-date-order">
                <date-picker 
                v-model="dateRange" 
                :confirm="true"
                @confirm="onConfirm()"
                placeholder="Last 30 days"
                range></date-picker>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-shopping-cart"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Total Order</span>
                <span class="info-box-number">{{totalOrder}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-check"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Total Paid</span>
                <span class="info-box-number">{{orderPaid}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-warning"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Unpaid Order</span>
                <span class="info-box-number">{{orderUnpaid}}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-bar-chart"></i></span>

                <div class="info-box-content">
                <span class="info-box-text">Paid Ratio</span>
                <span class="info-box-number">{{paidRatio.toFixed(2)}}<small>%</small></span>
            </div>
        </div>
        </div>
        <div class="col-lg-12 mt3">
            <div class="row">
                <div class="col-md-6 col-xs-12 mb1">
                    <div class="filter-order flex">
                        <div class="dropdown">
                            <button 
                                class="btn btn-default dropdown-toggle" 
                                type="button" data-toggle="dropdown"
                                @click="onPressAction($event)"
                            >
                                <span class="glyphicon glyphicon-check"></span>
                                Mark As
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li 
                                    @click="bulkUpdateStatus('pending')"
                                >
                                    <a href="javascript:;">Mark as Pending</a>
                                </li>
                                <li 
                                    @click="bulkUpdateStatus('process')"
                                >
                                    <a href="javascript:;">Mark as Process</a>
                                </li>
                                <li 
                                    @click="bulkUpdateStatus('shipping')"
                                >
                                    <a href="javascript:;">Mark as Shipping</a>
                                </li>
                                <li 
                                    @click="bulkUpdateStatus('cancel')"
                                >
                                    <a href="javascript:;">Mark as Refund</a>
                                </li>
                                <li 
                                    @click="bulkUpdateStatus('done')"
                                >
                                    <a href="javascript:;">Mark as Completed</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a 
                                        
                                        href="javascript:;"
                                        @click="bulkUpdateStatus('paid')"
                                    >
                                        Mark as Paid
                                    </a>
                                </li>
                                <li>
                                    <a 
                                        
                                        href="javascript:;"
                                        @click="bulkUpdateStatus('unpaid')"
                                    >
                                        Mark as UnPaid
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 mb1">
                    <div class="filter-order flex">
                        <button class="btn btn-default btn-sm mr1"
                            @click="onExport()"
                        >
                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                        Export
                        </button>
                        <button class="btn btn-default btn-sm mr1"
                            @click="onFilterOrder()"
                        >
                        <span class="glyphicon glyphicon-filter"></span>
                        Filter
                        </button>
                        <input 
                            type="text" 
                            class="form-control" 
                            v-model="search" 
                            placeholder="Search"
                            @keyup.enter="onSearchKey()"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12" v-if="newOrder > 0">
            <transition name="fade">
                <div class="alert alert-info text-center">
                    You have {{newOrder}} new orders, 
                    <a href="javascript:;" @click="refreshOrder()">
                        <strong>Click here to refresh</strong>
                    </a>
                </div>
            </transition>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-bordered" id="panel-order">
                <div class="panel-body" id="order-list">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" v-model="allSelected">
                                    </th>
                                    <th class="hide-sm">ID</th>
                                    <th class="hide-sm">Name</th>
                                    <th class="hide-sm">Product Name</th>
                                    <th class="hide-sm text-center">Quantity</th>
                                    <th class="hide-sm">Handle By</th>
                                    <th class="hide-sm">Status</th>
                                    <th class="hide-sm">Payment Type</th>
                                    <th class="hide-sm">Payment</th>
                                    <th class="hide-sm">Tracking</th>
                                    <th class="hide-sm">Order Date</th>
                                    <th class="hide-sm">Order From</th>
                                    <th>Follow-Up</th>
                                    <th class="hide-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in order" :key="index">
                                    <td class="v-middle">
                                        <input type="checkbox" :value="item" v-model="selected">
                                    </td>
                                    <td class="v-middle td-invoice hide-sm" style="min-width:110px;">
                                        <a href="#">
                                            <strong>#{{item.invoice_number}}</strong>
                                        </a>
                                        <div class="td-footer">
                                            <a href="javascript:;" @click="onEditOrder(item)"><i class="fa fa-pencil"></i> Edit</a>
                                            <a href="javascript:;" @click="onRemoveOrder(item, index)"><i class="fa fa-trash"></i> Hapus</a>
                                        </div>
                                    </td>
                                    <td class="v-middle hide-sm" style="min-width:110px;">
                                        {{item.costumer.name}}
                                    </td>
                                    <td class="v-middle hide-sm" style="min-width:130px;">
                                        {{ checkProduct(item) ? $readMore(checkProduct(item).name).first : ''}}
                                    </td>
                                    <td class="v-middle text-center hide-sm" style="min-width:120px;">
                                        <div v-if="item.detail.length" style="font-size:12px;">
                                            <span v-for="(value, i) in item.detail" :key="i">
                                                <i class="fa fa-tag" v-if="value.variations" />
                                                {{ value.variations ? value.variations.value : ''}} ({{value.quantity}})
                                            </span>
                                        </div>
                                    </td>
                                    <td class="v-middle hide-sm">
                                       {{item.handle ? item.handle.first_name : '-'}}
                                    </td>
                                    <td class="v-middle hide-sm">
                                        <div :class="generateColor(item.current_status)">
                                           {{ item.current_status ? item.current_status : 'Pending' }}
                                        </div>
                                    </td>
                                    <td class="v-middle hide-sm">
                                        <span class="text-uppercase">
                                            {{item.paid_with}}
                                        </span>
                                    </td>
                                    <td class="v-middle hide-sm">
                                        <div :class="item.paid_at ? 'flat flat-success' : 'flat flat-warning'">
                                            {{ item.paid_at ? 'Paid' : 'Unpaid' }}
                                        </div>
                                    </td>
                                    <td class="v-middle text-center hide-sm" style="min-width:130px;">
                                        <p style="font-size:13px;"><strong>{{ item.tracking_number ? item.tracking_number : '-'}}</strong></p>
                                    </td>
                                    <td class="v-middle hide-sm" style="min-width:140px;">
                                        <p style="font-size:12px;"><strong>{{ item.created_at }}</strong></p>
                                    </td>
                                     <td class="v-middle hide-sm" style="min-width:140px;">
                                        <p style="font-size:12px;"><strong>{{ item.order_from }}</strong></p>
                                    </td>
                                    <td class="v-middle">
                                        <div class="follow-up">
                                            <div class="flex follow-up-info show-sm mb1 justify-between align-center">
                                                <div>
                                                    <p> {{item.costumer.name}} <br/><span class="phone-number"> {{item.costumer.phone}}</span></p>
                                                </div>
                                                <div><p class="order-date">20-02-2020 - 13:25</p></div>
                                            </div>
                                            <div class="follow-up-row justify-around mb1">
                                                 <div class="follow-up-col mr-3" v-for="(mes, k) in arrFollowUp" :key="k">
                                                    <button
                                                        :class="setClassBtnFollowUp(item.followup, mes.type) ? 'follow-up-btn btn-primary' : 'follow-up-btn'"
                                                    @click="openModalFolloweUp(mes.type, item)"
                                                    >
                                                        {{ k == 0 ? 'W' : k + 1 }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="flex follow-up-action show-sm mt1 justify-between align-center">
                                                <div>
                                                    <a href="javascript:;" @click="onEditOrder(item)"><i class="fa fa-pencil"></i>Edit</a>
                                                </div>
                                                <div>
                                                    <div class="dropdown">
                                                        <button 
                                                            class="btn btn-default dropdown-toggle" 
                                                            type="button" data-toggle="dropdown"
                                                            @click="onPressAction($event)"
                                                        >Actions
                                                        <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li 
                                                                :class="item.checkout_at ? 'action-inactive' : ''"
                                                                @click="openModalStatus(item, {status:'pending'})"
                                                            >
                                                                <a href="javascript:;">Mark as Pending</a>
                                                            </li>
                                                            <li 
                                                                :class="item.process_at ? 'action-inactive' : ''"
                                                                @click="openModalStatus(item, {status:'process'})"
                                                            >
                                                                <a href="javascript:;">Mark as Process</a>
                                                            </li>
                                                            <li 
                                                                :class="item.shipping_at ? 'action-inactive' : ''"
                                                                @click="openModalStatus(item, {status:'shipping'})"
                                                            >
                                                                <a href="javascript:;">Mark as Shipping</a>
                                                            </li>
                                                            <li 
                                                                :class="item.cancel_at ? 'action-inactive' : ''"
                                                                @click="openModalStatus(item, {status:'cancel'})"
                                                            >
                                                                <a href="javascript:;">Mark as Refund</a>
                                                            </li>
                                                            <li 
                                                                :class="item.done_at ? 'action-inactive' : ''"
                                                                @click="openModalStatus(item, {status:'done'})"
                                                            >
                                                                <a href="javascript:;">Mark as Completed</a>
                                                            </li>
                                                            <li class="divider"></li>
                                                            <li :class="item.paid_at ? 'action-inactive' : ''">
                                                                <a 
                                                                    
                                                                    href="javascript:;"
                                                                    @click="openModalStatus(item, {status:'paid'})"
                                                                >
                                                                    Mark as Paid
                                                                </a>
                                                            </li>
                                                            <li :class="item.paid_at ? '' : 'action-inactive'">
                                                                <a 
                                                                    
                                                                    href="javascript:;"
                                                                    @click="openModalStatus(item, {status:'unpaid'})"
                                                                >
                                                                    Mark as UnPaid
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hide-sm">
                                        <div class="dropdown">
                                            <button 
                                                class="btn btn-default dropdown-toggle" 
                                                type="button" data-toggle="dropdown"
                                                 @click="onPressAction($event)"
                                            >Actions
                                            <span class="caret"></span></button>
                                            <ul class="dropdown-menu">
                                                <li 
                                                    :class="item.checkout_at ? 'action-inactive' : ''"
                                                    @click="openModalStatus(item, {status:'pending'})"
                                                >
                                                    <a href="javascript:;">Mark as Pending</a>
                                                </li>
                                                <li 
                                                    :class="item.process_at ? 'action-inactive' : ''"
                                                    @click="openModalStatus(item, {status:'process'})"
                                                >
                                                    <a href="javascript:;">Mark as Process</a>
                                                </li>
                                                <li 
                                                    :class="item.shipping_at ? 'action-inactive' : ''"
                                                    @click="openModalStatus(item, {status:'shipping'})"
                                                >
                                                    <a href="javascript:;">Mark as Shipping</a>
                                                </li>
                                                <li 
                                                    :class="item.cancel_at ? 'action-inactive' : ''"
                                                    @click="openModalStatus(item, {status:'cancel'})"
                                                >
                                                    <a href="javascript:;">Mark as Refund</a>
                                                </li>
                                                <li 
                                                    :class="item.done_at ? 'action-inactive' : ''"
                                                    @click="openModalStatus(item, {status:'done'})"
                                                >
                                                    <a href="javascript:;">Mark as Completed</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li :class="item.paid_at ? 'action-inactive' : ''">
                                                    <a 
                                                        
                                                        href="javascript:;"
                                                        @click="openModalStatus(item, {status:'paid'})"
                                                    >
                                                        Mark as Paid
                                                    </a>
                                                </li>
                                                <li :class="item.paid_at ? '' : 'action-inactive'">
                                                    <a 
                                                        
                                                        href="javascript:;"
                                                        @click="openModalStatus(item, {status:'unpaid'})"
                                                    >
                                                        Mark as UnPaid
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> 
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="loading open">
                        <div>
                            <i class="fa fa-refresh fa-spin fa-3x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <ModelStatus 
            ref="modalStatus" 
            :type="modalType"
            :order="modalOrder"
            @save="onSetActions"
        />
        <ModelFollowUp 
            ref="modelFollowUp"
            :type="followType"
            :order="followUpOrder"
            :datas="followupData"
            @close="closeFollowUpModal"
        />
        <ModalOrder 
            ref="modalEdit"
            :order="editOrder"
            :title="editTitle"
            @save="updateOrder"
            @cancel="cancelEdit"
        />
        <OrderFilter 
            ref="modelFilter"
            :filter="filters"
            :cs="arrCs"
            @apply="onApplyFilter()"
        />
    </div>
</template>
<script>
import ModelStatus from '../components/modal/Status.vue'
import ModelFollowUp from '../components/modal/FollowUp.vue'
import ModalOrder from '../components/modal/OrderEdit.vue'
import OrderFilter from '../components/modal/OrderFilter.vue'
import followMessage from '../utils/FollowUpMessage.js'

import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
export default {
    data(){
        return{
            order:[],
            orderPaid:0,
            orderUnpaid:0,
            paidRatio:0,
            totalOrder:0,
            modalType:'process',
            modalOrder:null,
            allSelected:false,

            arrFollowUp:[
                { type:1},
                { type:2},
                { type:3},
                { type:4},
                { type:5}
            ],
            followType:1,
            followupData:{
                followTitle:'',
                followMessage:'',
                followPhone:'',
                followName:'',
            },
            followUpOrder:null,

            // filter
            search:'',
            filters:{
                status:'',
                payment:'',
                paymentMethod:'',
                tracking:'',
                handle:'',
                startDate:'',
                endDate:''
            },

            //selected
            selected:[],
            //edit
            editOrder:null,
            editTitle:'',
            dateRange:null,
            confirm:true,
            page:0,
            isScroll: false,

            arrCs:[],
            export:''
        }
    },

    components:{
        ModelStatus,
        ModelFollowUp,
        ModalOrder,
        OrderFilter,
        DatePicker
    },

    created(){
        this.fetchOrder()
        this.fetchCs()
    },

    mounted(){
        window.onscroll= () => {
            return this.handleScroll()
        }
    },

    computed:{
        newOrder(){
            return this.$store.getters.newOrder
        }
    },

    watch:{
        allSelected(newValue){
            if(newValue) return this.selected = this.order
            return this.selected = []
        }
    },

    methods:{
        async fetchOrder(){
            try {
                $('.loading').addClass('open')
                let filter = this.filters
                let url = `/backend/order/json?search=${this.search}&status=${filter.status}&payment=${filter.payment}&payment-method=${filter.paymentMethod}&tracking=${filter.tracking}&handle=${filter.handle}&start=${filter.startDate}&end=${filter.endDate}&page=${this.page}&export=${this.export}`
                let orderApi = await axios.get(url)
                orderApi = orderApi.data
                if(orderApi.status){
                    this.orderPaid = orderApi.data.paid
                    this.orderUnpaid = orderApi.data.unpaid
                    this.totalOrder = orderApi.data.total_order
                    this.paidRatio = orderApi.data.paid_ratio
                    if(this.isScroll){

                        if(!orderApi.data.order.length){
                            this.isScroll = true
                        }else{
                            this.isScroll = false
                        }
                        this.order = this.order.concat(orderApi.data.order)
                        return $('.loading').removeClass('open')
                    }else{
                        this.order = orderApi.data.order
                        return $('.loading').removeClass('open')
                    }
                }
            } catch (error) {
                 $('.loading').removeClass('open')
                throw error
            }
        },

        async fetchCs(){
            try {
                let cs = await axios.get('/backend/admin/get-cs')
                cs = cs.data
                if(cs.status) {
                    this.arrCs =cs.data
                }
            } catch (error) {
                throw error
            }
        },

        refreshOrder(){
            this.$store.state.newOrder = 0
            return this.fetchOrder()
        },

        onPressAction(e){
            $(this).parent('.dropdown').addClass('open')
        },

        openModalStatus(arg, params){
            this.modalType = params.status
            this.modalOrder = arg
            let element = this.$refs.modalStatus.$el
            $(element).modal('show')
        },

        async onSetActions(params){
            let parsing = JSON.stringify(Object.fromEntries(params))
            parsing = JSON.parse(parsing)
            try {
                let action = await axios.post(`/backend/order/${parsing.order}/status`, params)
                action = action.data
                if(action.status){
                    let element = this.$refs.modalStatus.$el
                    $(element).modal('hide')
                    return this.reRenderStatus(parsing)
                }
            } catch (error) {
                throw error
            }
        },

        reRenderStatus(arg){
            let findIndex = this.order.findIndex(x => x.id == arg.order)
            if(!findIndex) return
            if(arg.status == 'paid'){
                this.order[findIndex].paid_at = this.$date('YYYY-MM-DD')
            }else if(arg.status == 'unpaid'){
                this.order[findIndex].paid_at = null
            }else{
                this.order[findIndex].current_status = arg.status == 'done' ? 'Completed' : arg.status
                this.order[findIndex].tracking_number = arg.tracking ? arg.tracking : ''
            }
        },

        openModalFolloweUp(type, item){
            let product = this.checkProduct(item)
            if(!product) {
                return  this.$swal({
                        title: "WARNING",
                        text: "Product not found or product has been removed from database",
                        icon:'warning'
                })
            }
            let phone = item.costumer.phone.replace('0', '62')
            this.followUpOrder = item
            switch (type) {
                case 1:
                    let body = {
                        invoice:item.invoice_number,
                        name:item.costumer.name,
                        product:product.name,
                        penerima:item.costumer.name,
                        phone:phone,
                        address:item.costumer.address,
                        district:item.costumer.district ? item.costumer.district.name : null,
                        city:item.costumer.city ? item.costumer.city : null,
                        province:item.costumer.province ? item.costumer.province : null,
                        shipping_fee: this.$formatCurrency(item.shipping_fee),
                        cod_fee:this.$formatCurrency(item.cod_fee),
                        total:item.paid_with == 'cod' ? this.$formatCurrency(item.total_price) : this.$formatCurrency(parseFloat(item.total_price) + 4400),
                        product_price:item.paid_with == 'cod'?  this.$formatCurrency(item.product_price) :  this.$formatCurrency(item.product_price + item.unique_fee),
                        admin:'Bastian',
                        order_id:item.invoice_number,
                        unique:this.$formatCurrency(item.unique_fee),
                        crypt_invoice:item.crypt_invoice
                    }
                    this.followType = 1
                    this.followupData.followTitle = 'Welcome'
                    if(item.paid_with == 'cod'){
                        this.followupData.followMessage = followMessage.codMessage(body)
                    } else{
                        this.followupData.followMessage = followMessage.firstMessage(body)
                    }
                    break;
                case 2:
                    this.followType = type
                    this.followupData.followTitle = 'Follow Up 1'
                    if(item.paid_with == 'cod'){
                        this.followupData.followMessage = followMessage.thirdMessage({
                            name:item.costumer.name
                        })
                    } else{
                        this.followupData.followMessage = followMessage.secondMessage({
                            name:item.costumer.name,
                            invoice:item.invoice_number
                        })
                    }
                    break;
                case 4:
                    this.followType = type
                    this.followupData.followTitle = 'Send Tracking Number'
                    if(!item.tracking_number){
                        return this.$swal("Warning! Please insert the tracking number before use the follow up 4", {
                            icon: "warning",
                        })
                    }
                    this.followupData.followMessage = followMessage.fourtchMessage({
                            name:item.costumer.name,
                            tracking_number:item.tracking_number
                        })
                    break
                case 5:
                    this.followType = type
                    this.followupData.followTitle = 'Send Invoice'
                    this.followupData.followMessage = followMessage.invoiceMessage({
                            crypt_invoice:item.crypt_invoice,
                            name:item.costumer.name,
                        })
                    break
            
                default:
                    this.followType = type
                    this.followupData.followTitle = 'Follow Up 2'
                    this.followupData.followMessage = followMessage.thirdMessage({
                        name:item.costumer.name
                    })
                    break;
            }
            this.followupData.followPhone = phone
            this.followupData.followName = item.costumer.name
            let element = this.$refs.modelFollowUp.$el
            $(element).modal('show')
        },

        closeFollowUpModal(){
            let element = this.$refs.modelFollowUp.$el
            $(element).modal('hide')
        },

        onEditOrder(arg){
            this.editOrder = Object.assign({}, arg)
            this.editTitle = 'Edit order #'+arg.invoice_number
            let element = this.$refs.modalEdit.$el
            $(element).modal('show')
        },

        async updateOrder(params){
            let body = {
                name:params.costumer.name,
                phone:params.costumer.phone,
                email:params.costumer.email,
                address:params.costumer.address,
                district:params.costumer.district.id,
                tracking_number:params.tracking_number,
                note:params.note,
                payment:params.paid_with,
                detail:params.detail.map(x => {
                    return{
                        id:x.id,
                        quantity:x.quantity
                    }
                }),
            }

            try {
                let update = await axios.put('/backend/order/'+params.id, body)
                update = update.data
                if(update.status){
                    let element = this.$refs.modalEdit.$el
                    $(element).modal('hide')
                }
            } catch (error) {
                throw error
            }
           
        },

        cancelEdit(){
            let element = this.$refs.modalEdit.$el
            $(element).modal('hide')
            return this.fetchOrder()
        },

        onRemoveOrder(order, index){
           this.$swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this order data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then(async (willDelete) => {
                if (willDelete) {
                    try {
                        let post = await axios.delete('/backend/order/'+order.id)
                        post = post.data
                        if(post.status){
                            this.order.splice(index, 1)
                            return this.$swal("Poof! Order has been deleted", {
                                icon: "success",
                            })
                        }
                    } catch (error) {
                        throw error
                    }
                } 
            })
        },

        async bulkUpdateStatus(type){
            if(!this.selected.length) return
            let now = this.$date(new Date(), 'YYYY-mm-DD HH:mm:ss')
            let body = {}
            switch (type) {
                case 'pending':
                    body.key = {
                        process_at: null
                    }
                    break;
                case 'process':
                    body.key = {
                        process_at: now
                    }
                    break;
                case 'shipping':
                    body.key = {
                        shipping_at: now
                    }
                    break;
                case 'cancel':
                    body.key = {
                        cancel_at: now
                    }
                    break;
                case 'done':
                    body.key = {
                        done_at: now
                    }
                    break;
                case 'paid':
                    body.key = {
                        paid_at: now
                    }
                    break;
                case 'unpaid':
                    body.key = {
                        paid_at: null
                    }
                    break;
            }
            if(!body) return
            body.order = this.selected.map(x => x.id)
            try {
                let updated = await axios.post(`/backend/order/bulk`, body)
                updated = updated.data
                if(updated.status){
                    this.allSelected = false
                    this.selected = []
                    return this.fetchOrder()
                }
            } catch (error) {
                throw error
            }
        },

        setClassBtnFollowUp(order, type){
            if(order.length > 0){
                if(order.some(x => x.name == type)) return true
                return false
            }

            return false
        },

        onFilterOrder(){
            let element = this.$refs.modelFilter.$el
            $(element).modal('show')
        },

        onApplyFilter(){
            let element = this.$refs.modelFilter.$el
            $(element).modal('hide')
            this.page = 0
            this.isScroll = false
            return this.fetchOrder()
        },

        onConfirm(){
            let start = this.$date(this.dateRange[0], "YYYY-MM-DD");
            let end = this.$date(this.dateRange[1], "YYYY-MM-DD");
            this.filters.startDate = start
            this.filters.endDate = end
            return this.fetchOrder()
        },

        checkProduct(params){
            if(params.detail.length){
                let detail = params.detail[0]
                if(detail.product){
                    return detail.product
                }
            }
            return false
        },

        handleScroll(){
            if(this.isScroll) return
            let a = document.documentElement.scrollTop + window.innerHeight
            let b = document.documentElement.offsetHeight -1
            if (a - b >= 0) {
                $('.loading').addClass('open')
                this.isScroll = true
                this.page = this.page + 1
                this.fetchOrder()
            }
        },

        onSearchKey(){
            this.page = 0
            this.isScroll = false
            this.fetchOrder()
        },

        async onExport(){
            this.export='execute'
            let filter = this.filters
            let url = `/backend/order/json?search=${this.search}&status=${filter.status}&payment=${filter.payment}&payment-method=${filter.paymentMethod}&tracking=${filter.tracking}&handle=${filter.handle}&start=${filter.startDate}&end=${filter.endDate}&page=${this.page}&export=${this.export}`
            this.export = ''
            return window.open(url,'_blank');
        },

        generateColor(params){
            if( params == 'Pending') return 'flat flat-danger'
            if(params == 'Refund')return 'flat flat-warning'
            if(params == 'Complete')return 'flat flat-success'
            return 'flat flat-primary'
        }
    }

}
</script>
<style lang="scss">
    #order-list{
        
        padding: 15px 5px;
        td{
            padding: 15px 8px;
            line-height: 1;
        }

        .dropdown-menu{
            left:-72%;
            margin-top: 0px;
            padding-top: 0px;
            border-radius: 0px;
            li{
                a{
                    padding:0.7rem 7px;
                }
                &.divider{
                    margin: 0px;
                }
            }
            .action-inactive{
                background: #a6a3a357;
                border-bottom: 1px solid #ddd;
                a{
                    cursor: unset;
                    color: #c1c1c1;
                }
            }
        }

        .td{
            &-invoice{
                &:hover, &:focus{
                    .td-footer{
                        opacity: 1;
                        text-align: left;
                    }
                }
            }

            &-footer{
                position: absolute;
                opacity: 0;
                display: block;
                margin-top:5px;
                text-align: right;
                transition: opacity 0.2s;
                a{
                    font-size: 11px;
                }
            }
        }

    }
    .range-date {
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
    }
</style>