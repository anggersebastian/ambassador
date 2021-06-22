<template>
    <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-white text-center">
            <div class="inner">
                <h3 style="font-size:17px;">
                    {{count}}
                </h3>

                <p>{{title}}</p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
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
        count:{
            type:[String, Number],
            default:'0'
        }
    }
}
</script>