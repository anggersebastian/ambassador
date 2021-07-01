<template>
    <div class="modal" role="dialog" ref="filemanagerModal">
        <div class="modal-dialog modal-lg" style="width:1">
            <div class="modal-content" style="max-width:unset; width:100%;">
            <div class="modal-header">
                <button type="button" class="close" @click="closeModal()">&times;</button>
                <h4 class="modal-title">File Manager</h4>
            </div>
            <div class="modal-body">
                <vue-dropzone 
                    ref="myVueDropzone" 
                    id="dropzone" 
                    :options="dropzoneOptions"
                    @vdropzone-success="successEvent"
                />
                
                <div class="filemanager-grid">
                    <ul>
                        <li v-for="(item, index) in files" :key="index" @click="onSelect($event, item.Key)" class="gal-img">
                            <img :src="'https://d2jnbxtr5v4vqu.cloudfront.net/'+item.Key" alt="" class="img-responsive">
                        </li>
                        
                    </ul>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" @click="closeModal()">Close</button>
                <button type="button" class="btn btn-success" @click="onPressSelect">Select</button>
            </div>
            </div>

        </div>
    </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
const token = document.head.querySelector('meta[name="csrf-token"]');
export default {
    data(){
        return{
            dropzoneOptions:{
                url: '/backend/filemanager',
                thumbnailWidth: 150,
                maxFilesize: 0.5,
                headers: { "X-CSRF-TOKEN": token.content},
                addRemoveLinks:true 
            },
            files:[],
            selected:[],
        }
    },

    props:{
        show:{
            type:Boolean,
            default:false
        }
    },

    computed:{
        
    },

    components:{
        vueDropzone: vue2Dropzone,
    },

    mounted(){
        this.showModal(this.show)
        this.fetchFile()
    },

    watch:{
        show(newValue){
            this.showModal(newValue)
        }
    },

    methods:{
        showModal(){
            let modal = this.$refs.filemanagerModal
            if(this.show){
                $(modal).modal('show')
            } else{
                $(modal).modal('hide')
            }
        },

        successEvent(file, response){
            if(response.status){
                this.files.splice(0, 0, {Key:response.data})
            }
        },

        async fetchFile(){
            try {
                let files = await axios.get('/backend/filemanager')
                files = files.data
                this.files = files.data.reverse()
            } catch (error) {
                throw error
            }
        },

        onSelect(e, params){
            // e.target.classList = 'active'
            
            if($(e.target).hasClass('img-responsive')){
                if($(e.target).parent('li').hasClass('active')){
                        $(e.target).parent('li').removeClass('active')
                        var index = this.selected.indexOf(params)
                        this.selected.splice(index, 1)
                }else{
                    $(e.target).parent('li').addClass('active')
                    this.selected.push(process.env.MIX_CDN_URL + params)
                }
            }

            if($(e.target).hasClass('gal-img')){
                if($(e.target).hasClass('active')){
                        $(e.target).removeClass('active')
                        var index = this.selected.indexOf(params)
                        this.selected.splice(index, 1)
                }else{
                    $(e.target).addClass('active')
                    this.selected.push(process.env.MIX_CDN_URL + params)
                }
            }
        },

        onPressSelect(){
            this.$emit('selected', this.selected)
            this.selected = []
            $('.gal-img').removeClass('active')
        },

        closeModal(){
            this.selected = []
            $('.gal-img').removeClass('active')
            return this.$emit('close')
        }
    },
}
</script>

<style lang="scss">
    .filemanager-grid{
        margin-top:2rem;
        ul{
            margin: 0px;
            padding: 0px;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            li{
                width: 70px;
                display: block;
                margin-right: 5px;
                border: 1px solid #ddd;
                border-radius: 2px;
                padding: 3px;
                cursor: pointer;
                margin-bottom: 1rem;
                &:first-child{
                    margin-left: 0px;
                }

                &.active{
                    border-color: green;
                }
            }
            img{
                margin: auto;
            }
        }
    }
</style>
