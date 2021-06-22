<template>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                    <h4 class="modal-title">Set Action</h4>
                </div>
                <div class="modal-body" v-if="order">
                    <div class="text-center" v-if="type == 'process' || type == 'shipping' || type == 'pending'">
                        <div class="modal-message" v-if="type == 'process'">
                            <p>Mark this order as Processing</p>

                            <p><strong>Payment Status</strong></p>
                        </div>
                        <div class="modal-message" v-if="type == 'pending'">
                            <p>Mark this order as Pending</p>

                            <p><strong>Payment Status</strong></p>
                        </div>
                        <div class="modal-message" v-else>
                            <p>Mark this order as Shipping</p>

                            <div class="form-group">
                                <input type="text" v-model="tracking" class="form-control" placeholder="No Resi">
                            </div>
                            <div class="form-group" v-if="type == 'shipping'">
                                <select class="form-control" v-model="setBatch">
                                    <option value="">Select batch</option>
                                    <option 
                                        v-for="(item, index) in batch"
                                        :key="index"
                                        :value="item.id"
                                    >
                                        {{item.title}} ({{item.request_date}})
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="btn-group btn-modal-status">
                            <button type="button" :class="order.paid_at ? 'btn btn-primary' : 'btn btn-default'">Paid</button>
                            <button type="button" :class="order.paid_at ? 'btn btn-default' : 'btn btn-primary'">Unpaid</button>
                        </div>
                    </div>
                     <div class="text-center" v-if="type == 'done' ">
                        <div class="modal-message">
                            <p>Mark this order to be completed</p>
                        </div>
                    </div>
                    <div class="text-center" v-if="type == 'cancel' ">
                        <div class="modal-message">
                            <p>Mark this order to be refunded</p>
                        </div>
                    </div>
                    <div class="text-center" v-if="type == 'paid' ">
                        <div class="modal-message">
                            <p>Mark this order to be paid</p>
                            <div class="form-group">
                                <input type="text" v-model="formatAmount" class="form-control" placeholder="Amount">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="customer" placeholder="From Ex: Dedy dantry">
                            </div>
                            <div class="form-group">
                                <input ref="struck" type="file" class="form-control" @change="onSelect">
                            </div>
                        </div>
                    </div>
                    <div class="text-center" v-if="type == 'unpaid' ">
                        <div class="modal-message">
                            <p>Mark this order Unpaid</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-success btn-block"
                        @click="onSave"
                    >
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        order:{
            type:Object,
            default(){
                return null
            }
        },
        type:{
            type:String,
            default:'process'
        }
    },

    data(){
        return{
            paid:false,
            tracking:'',
            amount:0,
            files:null,
            customer:'',

            batch:[],
            setBatch:''
        }
    },

    mounted(){
        this.fetchBatch()
    },

    computed:{
        formatAmount:{
            get(){
                return this.amount
            },
            set(newValue){
                newValue = newValue.replace(/^[, ]+|[, ]+$|[, ]+/g, "").trim();
                if (newValue.length > 2) {
                    return this.amount = newValue.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
                } else {
                    this.amount = newValue;
                }
            }
        },
    },

    methods:{
        onSave(){
            let formData = new FormData()
            let amount = this.amount != '' ? this.amount.replace(',', '') : this.amount
            formData.append('status', this.type)
            formData.append('order', this.order.id)
            formData.append('tracking', this.tracking)
            formData.append('amount', amount)
            formData.append('customer', this.customer)
            formData.append('batch', this.setBatch)
            if(this.files){
                formData.append('file', this.files)
            }

            this.$emit('save', formData)
        },

        onSelect(){
            const file = this.$refs.struck.files[0]
            this.struk = 'oke'
            this.files = file
        },

        // batch
        async fetchBatch(){
            try {
                let batch = await axios.get('/backend/logistic/batch/json')
                batch = batch.data
                if(batch.status){
                    this.batch = batch.data
                }
            } catch (error) {
                throw error
            }
        }
    }
}
</script>
<style lang="scss">
    .btn-modal-status{
        .btn{
            padding:6px 35px;
        }
    }
</style>