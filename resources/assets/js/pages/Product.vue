<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="range-date-order">
                        <date-picker 
                        v-model="dateRange" 
                        :confirm="true"
                        @confirm="onConfirm()"
                        placeholder="Last 30 days"
                        range></date-picker>
                    </div>
                    <div class="pull-right">
                        <button :class="created ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success'" @click="onCancel()">
                            <i :class="created ? 'fa fa-warning' :'fa fa-plus'"></i> {{created ? 'Cancel' : 'New'}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12" v-if="!created">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> 
                                    <span class="pointer" @click="onSort('id')">
                                        <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                                        id
                                    </span>
                                </th>
                                <th> 
                                    <span>
                                    Cover
                                    </span>
                                </th>
                                <th> 
                                    <span>
                                    Name
                                    </span>
                                </th>
                                <th> 
                                    <span class="pointer"  @click="onSort('code')">
                                        <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                                        Code
                                    </span>
                                </th>
                                <th> 
                                    <span class="">
                                    Cogs
                                    </span>
                                </th>
                                <th> 
                                    <span class="">
                                        Price
                                    </span>
                                </th>
                                <th> 
                                    <span class="">
                                        Price Type
                                    </span>
                                </th>
                                <th> 
                                    <span class="">
                                        Weight
                                    </span>
                                </th>
                                <th> 
                                    <span class="pointer"@click="onSort('total_order')">
                                        <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                                        Total Order
                                    </span>
                                </th>
                                <th> 
                                    <span class="pointer"@click="onSort('total_paid')">
                                        <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                                    Total Paid
                                    </span>
                                </th>
                                <th> 
                                    <span class="">
                                    Gross Revenue
                                    </span>
                                </th>
                                <th> 
                                    <span class="">
                                    Facebook Spent
                                    </span>
                                </th>
                                <th> 
                                    <span class="">
                                        Net Revenue
                                    </span>
                                </th>
                                <th> 
                                    <span class="">
                                    #
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in product" :key="index">
                                <td>
                                    #{{item.id}}
                                </td>
                                <td>
                                    <img :src="item.main_image" alt="" v-if="item.main_image" style="width:70px;">
                                </td>
                                <td class="v-middle">
                                    <a :href="`https://127.0.0.1:4000/form-order?product=${item.slug}`" style="text-transform:uppercase; text-decoration:none;" target="_blank">{{$readMore(item.name).first}}</a>
                                </td>
                                <td class="v-middle">
                                    {{item.code}}
                                </td>
                                <td class="v-middle">
                                    {{$formatCurrency(item.cogs)}}
                                </td>
                                <td class="v-middle">
                                    {{$formatCurrency(item.price)}}
                                </td>
                                <td class="v-middle">
                                    {{item.price_type}}
                                </td>
                                <td class="v-middle">
                                    {{item.weight}}
                                </td>
                                 <td class="v-middle text-center">
                                    {{item.total_order}}
                                </td>
                                <td class="v-middle">
                                    {{item.total_paid}}
                                </td>
                                <td class="v-middle">
                                    Rp {{$formatCurrency(item.gross_revenue)}}
                                </td>
                                <td class="v-middle">
                                    Rp {{$formatCurrency(item.fb_spent)}}
                                </td>
                                 <td class="v-middle">
                                    Rp {{$formatCurrency(item.net_revenue - item.fb_spent)}}
                                </td>

                                <td class="v-middle">
                                    <a :href="`/backend/product/${item.id}/view`" class="btn btn-success btn-xs">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a :href="`/backend/product/${item.id}/edit`" class="btn btn-primary btn-xs">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="javascript:;" class="btn btn-danger btn-xs" @click="removeProduct(item, index)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                     <div class="loading open">
                            <div>
                                <i class="fa fa-refresh fa-spin fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <transition name="fade">
            <Form @on-created="onCreated" :edit="edit" v-if="created"/>
        </transition>
    </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import Form from '../components/product/Form.vue';
export default {
    
    data(){
        return{
            created:false,
            product:[],
            edit:null,
            dateRange:'',
            start:'',
            end:'',
            sortir:'asc'
        }
    },

    components:{
        Form,
        DatePicker,
    },

    mounted(){
        this.fetchProduct()
    },

    methods:{

        async fetchProduct(){
            try {
                $('.loading').addClass('open')
                let product = await axios.get(`/backend/product/json?start=${this.start}&end=${this.end}`)
                product = product.data
                if(product.status){
                    this.product = product.data
                }
                $('.loading').removeClass('open')
            } catch (error) {
                $('.loading').removeClass('open')

                throw error
            }
        },

        onCreated(params){
            this.product.splice(0, 0, params)
            this.created = false
        },

        async removeProduct(params, index){
            try {
                if(confirm('Delete the product ?')){
                    let deleted = await axios.delete(`/backend/product/${params.id}`)
                    deleted = deleted.data
                    if(deleted.status){
                        this.product.splice(index, 1)
                    }
                }
            } catch (error) {
                throw error
            }
        },

        editProduct(params, index){
            this.edit = params
            this.created = true
        },

        onCancel(){
            if(!this.created) return this.created = true
            return this.$swal({
                title: "Are you sure?",
                text: "The form will be reset if you accept",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then(async (willDelete) => {
                    if (willDelete) {
                        this.created = false
                    } 
                })
        },

        onConfirm(){
            let start = this.$date(this.dateRange[0], "YYYY-MM-DD");
            let end = this.$date(this.dateRange[1], "YYYY-MM-DD");
            this.start = start
            this.end = end
            return this.fetchProduct()
        },

        onSort(type){
            if(this.sortir == ''){
                this.sortir = 'asc'
            }else if(this.sortir == 'asc'){
                this.sortir = 'desc'
            }else{
                this.sortir = 'asc'
            }

            this.product.sort((a, b) => {
                switch (type) {
                    case 'code':
                            if(this.sortir == 'asc'){
                                return this.sortAscending(a.total_order, b.total_order)
                            }else{
                                return this.sortDescending(a.total_order, b.total_order)
                            }
                        break;
                    case 'id':
                        if(this.sortir == 'asc'){
                            return this.sortAscending(a.id, b.id)
                        }else{
                            return this.sortDescending(a.id, b.id)
                        }
                        break
                    case 'total_paid':
                        if(this.sortir == 'asc'){
                            return this.sortAscending(a.total_paid, b.total_paid)
                        }else{
                            return this.sortDescending(a.total_paid, b.total_paid)
                        }
                    break;
                    case 'total_order':
                        if(this.sortir == 'asc'){
                            return this.sortAscending(a.total_order, b.total_order)
                        }else{
                            return this.sortDescending(a.total_order, b.total_order)
                        }
                    break;
                    default:
                        break;
                }
            })
        },

        sortAscending(a, b){
            return a - b
        },

        sortDescending(a, b){
            return b - a
        }
    }
}
</script>
<style lang="scss">
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>