<template>
    <div class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Filter Order</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                       <div class="row">
                           <div class="col-md-6">
                               <label for="" class="control-label">Status</label>
                                <select class="form-control" v-model="filter.status">
                                    <option value="">All</option>
                                    <option
                                            v-for="(item, index) in status" 
                                            :key="index" 
                                            :value="item.value"
                                        >
                                            {{item.name}}
                                        </option>
                                </select>
                           </div>
                           <div class="col-md-6">
                               <label for="" class="control-label">Payment Status</label>
                                <select class="form-control" v-model="filter.payment">
                                    <option value="">All</option>
                                    <option value="paid">Paid</option>
                                    <option value="unpaid">Unpaid</option>
                                </select>
                           </div>
                       </div>
                    </div>
                    <div class="form-group">
                       <div class="row">
                           <div class="col-md-6">
                               <label for="" class="control-label">Peyment Method</label>
                                <select class="form-control" v-model="filter.paymentMethod">
                                    <option value="">All</option>
                                    <option value="cod">COD</option>
                                    <option value="transfer">Bank Transfer</option>
                                </select>
                           </div>
                           <div class="col-md-6">
                               <label for="" class="control-label">Tracking Number</label>
                                <input type="text" class="form-control" placeholder="Tracking Number" v-model="filter.tracking">
                           </div>
                       </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="" class="control-label">Handle By</label>
                                <select name="" id="" class="form-control" v-model="filter.handle">
                                    <option value="">All</option>
                                    <option 
                                        v-for="(item, index) in cs"
                                        :key="index"
                                        :value="item.id"
                                        >{{item.first_name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal" aria-label="Close">
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        class="btn btn-primary"
                        @click="onApply()"
                    >
                        Apply
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        filter:{
            type:Object,
            default(){
                return null
            }
        },
        cs:{
            type:Array,
            default(){
                return []
            }
        }
    },

    data(){
       return{
           status:[
               {value:'pending', name:'Pending'},
               {value:'process', name:'Process'},
               {value:'shipping', name:'Shipping'},
               {value:'cancel', name:'Refund'},
               {value:'done', name:'Completed'},
           ]
       }
    },

   methods:{
       onApply(){
           return this.$emit('apply')
       }
   }
}
</script>