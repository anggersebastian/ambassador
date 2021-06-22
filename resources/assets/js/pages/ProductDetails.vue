<template>
   <div class="col-md-12">
        <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green">
                        <i class="fa fa-shopping-cart"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Order</span> 
                        <span class="info-box-number">{{totalOrder}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red">
                        <i class="fa fa-check"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Unpaid</span> 
                        <span class="info-box-number">{{totalUnpaid}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua">
                        <i class="fa fa-warning"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Paid</span> 
                        <span class="info-box-number">{{totalPaid}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-white text-center">
                    <div class="inner">
                        <h3 style="font-size: 17px;">
                            {{totalSold}}
                        </h3>
                        <p>Total Quantity Sold</p>
                    </div>
                    <div class="icon"><i class="ion ion-stats-bars"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-white text-center">
                    <div class="inner">
                        <h3 style="font-size: 17px;">
                            {{$formatCurrency(totalCogs)}}
                        </h3>
                        <p>Cogs</p>
                    </div>
                    <div class="icon"><i class="ion ion-stats-bars"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-white text-center">
                    <div class="inner">
                        <h3 style="font-size: 17px;">
                            Rp {{$formatCurrency(grossProfit)}}
                        </h3>
                        <p>Gross Profit</p>
                    </div>
                    <div class="icon"><i class="ion ion-stats-bars"></i></div>
                </div>
            </div>
             <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-white text-center">
                    <div class="inner">
                        <h3 style="font-size: 17px;">
                            Rp {{$formatCurrency(netProfit)}}
                        </h3>
                        <p>Net Profit</p>
                    </div>
                    <div class="icon"><i class="ion ion-stats-bars"></i></div>
                </div>
            </div>
        </div>
        <ul class="timeline mt2" v-if="fbreport.length">
            <li  v-for="(item, index) in fbreport" :key="index">
                <!-- timeline icon -->
                <i class="fa fa-tasks bg-blue"></i>
                <div class="timeline-item">
                    <div class="timeline-header bg-primary">
                        <div class="badge">
                            <h5>Date : {{item.day}}</h5>
                        </div>
                    </div>
                    <div class="timeline-body">
                        <table>
                            <tr>
                                <td width="100px" >Total Order </td>
                                <td width="15px"> : </td>
                                <td><b>{{item.total_order }}</b></td>
                            </tr>
                             <tr>
                                <td width="100px" >Order Paid </td>
                                <td width="15px"> : </td>
                                <td><b>{{item.paid }}</b></td>
                            </tr>
                             <tr>
                                <td width="100px" >Order Unpaid </td>
                                <td width="15px"> : </td>
                                <td><b>{{item.unpaid }}</b></td>
                            </tr>
                             <tr>
                                <td width="100px" >Ad spent </td>
                                <td width="15px"> : </td>
                                <td><b>Rp {{$formatCurrency(item.ad_spent)}}</b></td>
                            </tr>
                            <tr>
                                <td width="100px" >view Content </td>
                                <td width="15px" >:</td>
                                <td><b>{{item.view_content}}</b></td>
                            </tr>
                            <tr>
                                <td width="100px" >Add to Cart </td>
                                <td width="15px" >:</td>
                                <td><b>{{item.add_to_cart}}</b></td>
                            </tr>
                            <tr>
                                <td width="100px" >Initiate Checkout </td>
                                <td width="15px" >:</td>
                                <td><b>{{item.initiate_checkout}}</b></td>
                            </tr>
                            <tr>
                                <td width="100px" >Lead </td>
                                <td width="10px" >:</td>
                                <td><b>{{item.lead}}</b></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </li>
        </ul>
        <div v-else>
            <p class="text-center"><strong>Fb report is empty</strong></p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return{
            fbreport : [],
            totalOrder:0,
            totalPaid:0,
            totalUnpaid:0,
            totalSold:0,
            grossProfit:0,
            netProfit:0,
            totalCogs:0
        }
    },

    mounted() {
        this.facebookReport()
    },
    methods: {
        async facebookReport() {
            try {
                let url = window.location.pathname
                url = url.split('/')
                let id = url[3]
            
                let fbreport = await axios.get(`/backend/product/${id}/jsonfb`)
                fbreport = fbreport.data
                if(fbreport.status){
                    this.fbreport = fbreport.data.facebook_report,
                    this.totalOrder = fbreport.data.total_order,
                    this.totalPaid = fbreport.data.total_paid,
                    this.totalUnpaid = fbreport.data.total_unpaid,
                    this.totalSold = fbreport.data.total_sold,
                    this.grossProfit = fbreport.data.gross_profit,
                    this.netProfit = fbreport.data.net_profit.total
                    this.totalCogs - fbreport.data.total_cogs.total
                }
            } catch (error) {
                throw error
            }
        }
    }
}
</script>

<style>
h5{
    color: white;
    font-weight: bold;
}

.badge{
    background-color: #3282b8;
    border-radius: 6px;
    border: 2px solid #81c6f3;
}

.panel{
    border-radius: 10px;
}

.card{
    border-radius: 6px;
    border: 4px solid #81c6f3;
    background: #3282b8;
    color: white;
}

</style>
