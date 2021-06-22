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

        <cardOrder title="Total Order" :counter="totalOrder" icon="fa fa-shopping-cart" color="info-box-icon bg-green"/>
        <cardOrder title="Total Paid" :counter="orderPaid" icon="fa fa-check" color="info-box-icon bg-aqua"/>
        <cardOrder title="Total Unpaid" :counter="orderUnpaid" icon="fa fa-warning" color="info-box-icon bg-red"/>
        <cardOrder title="Paid Ratio" :counter="paidRatio" icon="fa fa-bar-chart" color="info-box-icon bg-yellow"/>

        <cardPrice title="Total Quantity Sold" :count="totalSold"/>
        <cardPrice title="COGS" :count="totalCogs"/>
        <cardPrice title="Unpaid Revenue" :count="unpaidRevenue"/>
        <cardPrice title="Gross Revenue" :count="grossRevenue"/>
        <cardPrice title="Net Revenue" :count="netRevenue"/>
        <cardPrice title="Gross Profit" :count="grossProfit"/>
        <cardPrice title="Expenses" count="0"/>
        <cardPrice title="Net Profit" :count="netProfit"/>
    </div>
</template>
<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

import cardOrder from './CardOrder.vue'
import cardPrice from './CardPrice.vue'
export default {
    components:{
        DatePicker,
        cardOrder,
        cardPrice
    },

    data(){
        return{
            dateRange:'',
            totalOrder:0,
            orderPaid:0,
            orderUnpaid:0,
            paidRatio:0,
            totalSold:0,
            totalCogs:0,
            unpaidRevenue:0,
            grossRevenue:0,
            grossProfit:0,
            netProfit:0,
            netRevenue:0,
            start:'',
            end:''
        }
    },
    created(){
        this.fetchReport()
    },

    methods:{
        async fetchReport(){
            try {
                let report = await axios.get(`/backend/index/json?start=${this.start}&end=${this.end}`)
                report = report.data
                if(report.status){
                    this.totalOrder =report.data.total_order
                    this.orderPaid =report.data.paid
                    this.orderUnpaid =report.data.unpaid
                    this.paidRatio = report.data.paid_ratio.toFixed(2)
                    this.totalSold = report.data.total_sold
                    this.totalCogs = 'Rp '+this.$formatCurrency(report.data.total_cogs)
                    this.unpaidRevenue = 'Rp '+this.$formatCurrency(report.data.unpaid_revenue),
                    this.grossRevenue = 'Rp '+this.$formatCurrency(report.data.gross_revenue)
                    this.grossProfit = 'Rp '+this.$formatCurrency(report.data.gross_profit)
                    this.netProfit = 'Rp '+this.$formatCurrency(report.data.net_profit)
                    this.netRevenue = 'Rp '+this.$formatCurrency(report.data.net_revenue)
                }
            } catch (error) {
                throw error
            }
        },

        onConfirm(){
            let start = this.$date(this.dateRange[0], "YYYY-MM-DD");
            let end = this.$date(this.dateRange[1], "YYYY-MM-DD");
            this.start = start
            this.end = end
            return this.fetchReport()
        },
    }
}
</script>