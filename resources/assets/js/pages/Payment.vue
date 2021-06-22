<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th>Admin</th>
                                    <th>Account</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Files</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in payment" :key="index">
                                    <td class="v-middle">
                                        {{item.order ? item.order.invoice_number : ''}}
                                    </td>
                                    <td class="v-middle">
                                        {{item.admin ? item.admin.email : ''}}
                                    </td>
                                    <td class="v-middle">
                                        {{item.customer_account}}
                                    </td>
                                    <td class="v-middle">
                                        {{item.transaction_at}}
                                    </td>
                                    <td class="v-middle">
                                        Rp {{$formatCurrency(item.amount)}}
                                    </td>
                                    <td class="v-middle">
                                        <a :href="item.files" target="_blank"><i class="fa fa-eye"></i> Open</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            payment:[]
        }
    },

    mounted(){
        this.fetchPayment()
    },
    
    methods:{
        async fetchPayment(){
            try {
                let payment = await axios.get('/backend/payment/json')
                payment = payment.data
                if(payment.status){
                    this.payment = payment.data
                }
            } catch (error) {
                throw error
            }
        }
    }
}
</script>