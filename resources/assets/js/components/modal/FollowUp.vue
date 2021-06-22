<template>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                    <h4 class="modal-title">{{datas.followTitle}}</h4>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> {{datas.followName}}</p>
                    <div class="form-group">
                        <label for="" class="control-label">Phone Number</label>
                        <input 
                            type="text" 
                            class="form-control"
                            v-model="datas.followPhone"
                        >
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Message</label>
                        <textarea 
                            cols="30" 
                            rows="5" 
                            class="form-control" 
                            v-model="datas.followMessage"
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-success btn-block"
                        @click="onSave"
                    >
                        Follow Up
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
            type:Number,
            default:1
        },
       datas:{
           type:Object,
           default(){
               return null
           }
       }
    },

    data(){
        return{
            paid:false,
            tracking:''
        }
    },

    methods:{
        async onSave(){
            await this.postFollowUp()
            this.$emit('close')
            return window.open(`https://api.whatsapp.com/send?phone=${this.datas.followPhone}&text=${this.datas.followMessage}`, '_blank')
        },

        async postFollowUp(){
            try {
                let followUp = await axios.post('/backend/order/follow-up/'+this.order.id, {
                    name:this.type
                })
                followUp = followUp.data
                if(followUp.status){
                    this.order.followup.push({name:this.type})
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