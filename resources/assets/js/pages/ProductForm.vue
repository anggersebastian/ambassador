<template>
    <div class="row">
        <Form @on-created="onCreated" :edit="product" v-if="created"/>
    </div>
</template>

<script>
import Form from '../components/product/Form.vue';
export default {
    
    data(){
        return{
            created:true,
            product:null,
        }
    },

    components:{
        Form
    },

    mounted(){
        this.fetchProduct()
    },

    methods:{

        onCreated(){
            
        },

        async fetchProduct(){
            try {
                let url = window.location.pathname
                url = url.split('/')
                let id = url[3]
                let product = await axios.get('/backend/product/'+id)
                product = product.data
                if(product.status){
                    this.product = product.data
                }
            } catch (error) {
                throw error
            }
        }
       
    }
}
</script>
<style lang="scss">
    .v-middle{
        vertical-align: middle!important;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>