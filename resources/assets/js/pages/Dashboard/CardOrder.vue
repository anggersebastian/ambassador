<template>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span :class="color"><i :class="icon"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">{{title}}</span>
                <span class="info-box-number">{{counter}}</span>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:{
        color:{
            type:String,
            default:'info-box-icon bg-green'
        },
        icon:{
            type:String,
            default:'fa fa-shopping-cart'
        },
        
        title:{
            type:String,
            default:'',
        },

        counter:{
            type:[String, Number],
            default:0
        }
    }
}
</script>