<template>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                    <h4 class="modal-title">{{title}}</h4>
                </div>
                <div class="modal-body edit-order">
                    <div class="row" v-if="order">
                        <!-- <div class="flex"> -->
                            <div class="col-md-8 col-xs-12">
                                <ul class="nav nav-pills">
                                    <li class="active"><a data-toggle="pill" href="#home">Customer Data</a></li>
                                    <li><a data-toggle="pill" href="#menu1">Order Data</a></li>
                                </ul>
                                
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label">Name</label>
                                                    <input type="text" v-model="order.costumer.name" class="form-control">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label">Phone</label>
                                                    <input type="text" v-model="order.costumer.phone" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label">Email</label>
                                                    <input type="text" v-model="order.costumer.email" class="form-control">
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label">Address</label>
                                                    <input type="text" v-model="order.costumer.address" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <p><strong>Address Detail</strong></p>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label">Province</label>
                                                    <select class="form-control" v-model="setProvince" @change="onChangeAddress('province')">
                                                        <option 
                                                            v-for="(item, index) in province" :key="index"
                                                            :value="item.id"
                                                        >
                                                            {{item.name}}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label">City</label>
                                                    <select class="form-control" v-model="setCity" @change="onChangeAddress('city')">
                                                        <option value="" selected>Select City</option>
                                                        <option 
                                                            v-for="(item, index) in city"
                                                            :key="index"
                                                            :value="item.id"
                                                        >
                                                            {{item.name}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="control-label">Subdistrict</label>
                                            <select class="form-control" v-model="setDistrict">
                                                <option value="" selected>Select District</option>
                                                <option 
                                                    v-for="(item, index) in district"
                                                    :key="index"
                                                    :value="item.id"
                                                >
                                                    {{item.name}}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label">Courier</label>
                                                    <select class="form-control">
                                                        <option value="ninja">Ninja Xpress</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="control-label">Package</label>
                                                    <select class="form-control">
                                                        <option>Standart (Rp115.000)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="menu1" class="tab-pane fade">
                                        <div v-if="order.detail.length">
                                            <div 
                                                class="form-group" 
                                                v-for="(item, index) in order.detail" 
                                                :key="index"
                                            >
                                                <div v-if="item.variations">
                                                    <label for="" class="control-label">Quantity {{ item.variations.value }}</label>
                                                    <input type="number" v-model="item.quantity" class="form-control">
                                                </div>
                                                <div v-else>
                                                    <label for="" class="control-label">Quantity</label>
                                                    <input type="number" v-model="item.quantity" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="control-label">Note</label>
                                            <textarea 
                                                cols="30" 
                                                rows="3" 
                                                class="form-control" 
                                                v-model="order.note"
                                            />
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="control-label">Payment</label>
                                            <select class="form-control" v-model="order.paid_with">
                                                <option value="cod">COD</option>
                                                <option value="transfer">Transfer</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="control-label">Receipt Number</label>
                                            <input type="text" v-model="order.tracking_number" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-12">
                                <div class="order-info">
                                    <p class="order-summary">
                                        <strong>Order Summary</strong>
                                    </p>
                                    <div class="order-date">
                                        <p><strong>{{order.created_at}}</strong></p>
                                    </div>

                                    <div class="order-product">
                                        <p>{{order.detail[0].product.name}}</p>
                                        <ul>
                                            <li 
                                                v-for="(item, index) in order.detail" 
                                                :key="index"
                                            >
                                                <div class="li-left">
                                                    Variations {{ item.variations ? item.variations.value : '' }} (X{{item.quantity}})
                                                </div>
                                                <div class="li-right">
                                                    Rp{{($formatCurrency(item.product.price * item.quantity))}}
                                                </div>
                                            </li>
                                            <li>
                                                <div class="li-left">
                                                    Shipping {{weight}}gr
                                                </div>
                                                <div class="li-right">
                                                    Rp{{$formatCurrency(order.shipping_fee)}}
                                                </div>
                                            </li>
                                            <li v-if="order.paid_with == 'cod'">
                                                <div class="li-left">
                                                    COD Fee
                                                </div>
                                                <div class="li-right">
                                                    Rp{{$formatCurrency(order.cod_fee)}}
                                                </div>
                                            </li>
                                            <li v-else>
                                                <div class="li-left">
                                                    Unique Code
                                                </div>
                                                <div class="li-right">
                                                    Rp{{$formatCurrency(order.unique_fee)}}
                                                </div>
                                            </li>
                                             <li v-if="order.paid_with == 'transfer'">
                                                <div class="li-left">
                                                    Transferr Fee
                                                </div>
                                                <div class="li-right">
                                                    Rp 4.400
                                                </div>
                                            </li>
                                            <li>
                                                <div class="li-left">
                                                    <strong>TOTAL</strong>
                                                </div>
                                                <div class="li-right">
                                                    <strong>Rp {{$formatCurrency(totalPrice)}}</strong>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-warning"
                        @click="onCancel()"
                    >
                        Cancel
                    </button>
                    <button 
                        type="button" 
                        class="btn btn-success"
                        @click="onSave()"
                    >
                        Update Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        title:{
            type:String,
            default:''
        },
        order:{
            type:Object,
            default(){
                null
            }
        }
    },

    data(){
        return{
            province:[],
            city:[],
            district:[],

            setProvince:'',
            setCity:'',
            setDistrict:'',
            postal:''
        }
    },

    watch:{
        order(newValue){
            if(newValue){
                this.fetchProvince()
                let district = newValue.costumer.district
                this.setProvince = district ? district.province_id : null
                this.setCity = district ? district.city_id : null
                this.setDistrict = district ? district.id : null
            }
        }
    },

    computed:{
        weight(){
            if(this.order) {
                return this.order.detail.map(x => parseFloat(x.weight) * parseFloat(x.quantity)).reduce((a,b) => parseFloat(a) + parseFloat(b))
            }
            return 0
        },

        totalPrice(){
            if(this.order == null) return 0
            let productPrice = 0
            this.order.detail.map(x => {
                productPrice = productPrice + (parseFloat(x.quantity) * parseFloat(x.product.price))
            })
            let codFee = this.order.paid_with == 'cod' ? parseFloat(this.order.cod_fee) : parseFloat(this.order.unique_fee)
            let total = parseFloat(this.order.shipping_fee) + codFee + productPrice
            return total
        }
    },

    methods:{
        async fetchProvince(){
            try {
                let province = await axios.get('/api/address/province')
                province = province.data
                if(province.status){
                    this.province = province.data
                    this.fetchCity()
                }
            } catch (error) {
                throw error
            }
        },

        async fetchCity(){
            try {
                if(!this.setProvince) return
                let city = await axios.get(`/api/address/city/${this.setProvince}/province`)
                city = city.data
                if(city.status){
                    this.city = city.data
                    this.fetchDistrict()
                }
            } catch (error) {
                throw error
            }
        },

        async fetchDistrict(){
             try {
                if(!this.setCity) return
                let district = await axios.get(`/api/address/district/${this.setCity}/city`)
                district = district.data
                if(district.status){
                    this.district = district.data
                }
            } catch (error) {
                throw error
            }
        },

        onChangeAddress(arg){
            if(arg == 'province') {
                this.setCity = ''
                this.setDistrict = ''
               return this.fetchCity()
            }
            
            if(arg == 'city') {
                return this.fetchDistrict()
            }
        },

        onSave(){
            return this.$emit('save', this.order)
        },

        onCancel(){
            return this.$emit('cancel', this.order)
        }
    }

    
}
</script>
<style lang="scss" scoped>
    .btn-modal-status{
        .btn{
            padding:6px 35px;
        }
    }

    .modal-content{
        max-width: unset;
        width: 95%;
    }
</style>