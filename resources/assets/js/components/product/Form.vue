<template>
    <div>
        <div class="col-lg-12">
            <div class="alert alert-danger" v-if="errorForm">
                <div v-for="(item, index) in errorForm" :key="index">
                    <p v-for="(value, i) in item" :key="i">
                        * {{value}}
                    </p>
                </div>
            </div>
        </div>
        <ValidationObserver v-slot="{ handleSubmit }">
            <form action="" class="mt1" @submit.prevent="handleSubmit(onSubmit)">
                <div class="dropy-tabs" v-show="tabs == 0">
                    <div class="col-lg-8">
                        <div class="panel panel-bordered">
                            <div class="panel-heading">Product Info</div>
                            <div class="panel-body">
                                <ValidationProvider
                                    v-slot="{ errors }"
                                    name="name"
                                    rules="required"
                                    tag="div"
                                    class="form-group"
                                >
                                    <label for="name" class="control-label">Name</label>
                                    <input type="text" class="form-control" v-model="name">
                                    <span class="help-block" style="color:#a94442;">
                                        {{ errors[0] }}
                                    </span>
                                </ValidationProvider>    
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ValidationProvider
                                                v-slot="{ errors }"
                                                name="formatCogs"
                                                rules="required"
                                                tag="div"
                                            >
                                                <label for="cogs" class="control-label">Cogs</label>
                                                <input type="text" class="form-control" v-model="formatCogs" v-on:keypress="checkNumber($event)">
                                                <span class="help-block" style="color:#a94442;">
                                                    {{ errors[0] }}
                                                </span>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-md-6">
                                            <ValidationProvider
                                                v-slot="{ errors }"
                                                name="formatWeight"
                                                rules="required"
                                                tag="div"
                                            >
                                                <label for="weight" class="control-label">Weight <i class="text-info" style="font-size:12px;">(Gram)</i></label>
                                                <input type="text" class="form-control" v-model="formatWeight" v-on:keypress="checkNumber($event)">
                                                <span class="help-block" style="color:#a94442;">
                                                    {{ errors[0] }}
                                                </span>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-bordered">
                            <div class="panel-heading">Product Pricing</div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="row">
                                        <div :class="price_type == 'fix' ? 'col-md-6' : 'col-md-12'">
                                            <ValidationProvider
                                                v-slot="{ errors }"
                                                name="price_type"
                                                rules="required"
                                                tag="div"
                                            >
                                                <label for="price_type" class="control-label">Price Type</label>
                                                <select name="price_type" class="form-control" v-model="price_type">
                                                    <option value="fix">FIX</option>
                                                    <option value="range">RANGE</option>
                                                </select>
                                                <span class="help-block" style="color:#a94442;">
                                                    {{ errors[0] }}
                                                </span>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-md-6" v-show="price_type == 'fix'">
                                            <ValidationProvider
                                                v-slot="{ errors }"
                                                name="formatPrice"
                                                rules="required"
                                                tag="div"
                                            >
                                                <label for="price  Price TYpe" class="control-label">Price</label>
                                                <input type="text" class="form-control" v-model="formatPrice" v-on:keypress="checkNumber($event)">
                                                <span class="help-block" style="color:#a94442;">
                                                    {{ errors[0] }}
                                                </span>
                                            </ValidationProvider>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" v-show="price_type == 'range'">
                                    <div class="row" v-for="(item, index) in rangeArr" :key="index">
                                        <div class="col-md-3">
                                            <ValidationProvider
                                                v-slot="{ errors }"
                                                :name="item.index+'p'"
                                                rules="required"
                                                tag="div"
                                            >
                                                <label for="" class="control-label">Range Start</label>
                                                <input type="text" class="form-control" v-model="item.start">
                                                <span class="help-block">
                                                    {{ errors[0] }}
                                                </span>
                                            </ValidationProvider>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="" class="control-label">Range End</label>
                                            <input type="text" class="form-control" v-model="item.end">
                                        </div>
                                        <div class="col-md-5">
                                            <label for="" class="control-label">Price</label>
                                            <input type="text" class="form-control" v-model="item.price" v-on:keypress="checkNumber($event)">
                                        </div>
                                        <div class="col-md-1" v-if="rangeArr.length > 1">
                                            <button class="btn btn-danger btn-xs" style="margin-top:3.4rem;" type="button" @click="removeRangeArr(index)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mb1 mt1 text-center">
                                        <button class="btn btn-info btn-xs" @click="addPriceRange()" type="button">
                                            <i class="fa fa-plus"></i> Add Price Range
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="panel panel-bordered">
                        <div class="panel-heading">Product Category</div>
                            <div class="panel-body">
                                <ValidationProvider
                                    v-slot="{ errors }"
                                    name="setCategory"
                                    rules="required"
                                    tag="div"
                                    class="form-group"
                                >
                                    <multiselect 
                                        v-model="setCategory" 
                                        :options="arrCategory" 
                                        :multiple="true" 
                                        :close-on-select="false" 
                                        :clear-on-select="false" 
                                        :preserve-search="true" 
                                        placeholder="Pick some" 
                                        label="name" 
                                        track-by="name" 
                                        :preselect-first="true">
                                            <template 
                                                slot="selection" 
                                                slot-scope="{ values, search, isOpen }">
                                                    <span 
                                                        class="multiselect__single" 
                                                        v-if="setCategory.length && !isOpen">
                                                            {{ setCategory.length }} Category selected
                                                    </span>
                                            </template>
                                    </multiselect>
                                    <span class="help-block" style="color:#a94442;">
                                        {{ errors[0] }}
                                    </span>
                                </ValidationProvider>
                            </div>
                        </div>

                        <div class="panel panel-bordered">
                            <div class="panel-heading">Product Tag</div>
                            <div class="panel-body">
                                <ValidationProvider
                                    v-slot="{ errors }"
                                    name="setTag"
                                    rules="required"
                                    tag="div"
                                    class="form-group"
                                >
                                    <multiselect 
                                        v-model="setTag" 
                                        tag-placeholder="Add this as new tag" 
                                        placeholder="Search or add a tag" 
                                        label="name" 
                                        track-by="slug" 
                                        :options="arrTag" 
                                        :multiple="true" 
                                        :taggable="true" 
                                        @tag="addTag">
                                    </multiselect>
                                    <span class="help-block" style="color:#a94442;">
                                        {{ errors[0] }}
                                    </span>
                                </ValidationProvider>
                            </div>
                        </div>

                        <div class="panel panel-bordered">
                            <div class="panel-heading">Product Attribute</div>
                            <div class="panel-body">
                                <div class="mb1 flex flex-row flex-wrap">
                                    <span 
                                        class="label label-default"
                                        v-for="(item, index) in resAttribute"
                                        :key="index"
                                        style="margin-left:2px; margin-top:2px;"
                                    >
                                        {{ item.key }}:{{item.value}}
                                    </span>
                                </div>
                                <button class="btn btn-primary btn-sm" type="button" @click="addAttribute()">
                                    <i class="fa fa-plus"></i> Add Attribute
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropy-tabs" v-show="tabs == 1">
                    <div class="col-lg-12">
                        <div class="panel panel-bordered">
                            <div class="panel-heading">
                                Product Content
                            </div>
                            <div class="panel-body">
                                <ValidationProvider
                                    v-slot="{ errors }"
                                    name="description"
                                    rules="required"
                                    tag="div"
                                    class="form-group"
                                >
                                    <label for="" class="control-label">Description</label>
                                    <textarea cols="30" rows="10" class="form-control" v-model="description"></textarea>
                                    <span class="help-block" style="color:#a94442;">
                                        {{ errors[0] }}
                                    </span>
                                </ValidationProvider>

                                <div class="form-group">
                                    <label for="" class="control-label">Product Cover</label>
                                    <div class="product-cover">
                                        <a href="javascript:;" class="btn btn-primary btn-sm" @click="setCover">
                                            <i class="fa fa-plus"></i> Add Cover
                                        </a>
                                    </div>
                                    <ul v-if="cover" class="filemanager-ul">
                                        <li>
                                            <img :src="cover" alt="">
                                        </li>
                                    </ul>
                                </div>

                                <div class="form-group">
                                    <label for="" class="control-label">Produt Gallery</label>
                                    <div class="product-cover">
                                        <a href="javascript:;" class="btn btn-primary btn-sm" @click="fileManagerPopup=true">
                                            <i class="fa fa-plus"></i> Add Image
                                        </a>
                                    </div>
                                    <ul v-if="product_image.length" class="filemanager-ul">
                                        <li v-for="(item, index) in product_image" :key="index">
                                            <img :src="item" alt="">
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dropy-tabs" v-show="tabs == 2">
                    <div class="col-lg-12">
                        <div class="panel panel-bordered">
                            <div class="panel-heading">
                                Product Meta
                            </div>
                            <div class="panel-body">
                                <ValidationProvider
                                    v-slot="{ errors }"
                                    name="meta_slug"
                                    rules="required"
                                    tag="div"
                                    class="form-group"
                                >
                                    <label for="" class="control-label">Modified Slug</label>
                                    <input type="text" class="form-control" v-model="meta_slug">
                                    <span class="help-block" style="color:#a94442;">
                                        {{ errors[0] }}
                                    </span>
                                 </ValidationProvider>
                                <ValidationProvider
                                    v-slot="{ errors }"
                                    name="meta_title"
                                    rules="required"
                                    tag="div"
                                    class="form-group"
                                >
                                    <label for="" class="control-label">Meta Title</label>
                                    <input type="text" class="form-control" v-model="meta_title">
                                    <span class="help-block" style="color:#a94442;">
                                        {{ errors[0] }}
                                    </span>
                                </ValidationProvider>
                                 <ValidationProvider
                                    v-slot="{ errors }"
                                    name="meta_description"
                                    rules="required"
                                    tag="div"
                                    class="form-group"
                                >
                                    <label for="" class="control-label">Meta Description</label>
                                    <textarea cols="10" rows="4" class="form-control" v-model="meta_description"></textarea>
                                    <span class="help-block" style="color:#a94442;">
                                        {{ errors[0] }}
                                    </span>
                                </ValidationProvider>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropy-tabs" v-show="tabs == 3">
                    <div class="col-lg-12">
                        <div class="panel panel-bordered">
                            <div class="panel-heading">
                                Setting
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" class="minimal" v-model="setting.image">
                                        Show Product Image ?
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" class="minimal" v-model="setting.quantity">
                                        Show Quantity Order ?
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <input type="checkbox" class="minimal" v-model="setting.cod">
                                        Show Payment COD?
                                    </label>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-xs-12">
                                            <label>
                                                <input type="checkbox" class="minimal" v-model="spesifictCs">
                                                Handle by spesifict CS ?
                                            </label>

                                            
                                             <multiselect 
                                                v-if="spesifictCs"
                                                v-model="cs" 
                                                :options="arrCs" 
                                                :multiple="true" 
                                                :close-on-select="false" 
                                                :clear-on-select="false" 
                                                :preserve-search="true" 
                                                placeholder="Pick some" 
                                                label="email" 
                                                track-by="email" 
                                                :preselect-first="true">
                                                    <template 
                                                        slot="selection" 
                                                        slot-scope="{ values, search, isOpen }">
                                                            <span 
                                                                class="multiselect__single" 
                                                                v-if="cs.length && !isOpen">
                                                                    {{ cs.length }} CS selected
                                                            </span>
                                                    </template>
                                            </multiselect>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="control-label">Header Text</label>
                                    <textarea v-model="setting.headerText" cols="3" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                        

                        <div class="panel panel-borde">
                            <div class="panel-heading">
                                Field Active
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="setting.name">Name
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="setting.phone">Phone
                                        </label>
                                    </div>

                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="setting.email">Email
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="setting.city">City
                                        </label>
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" v-model="setting.address">Address
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="pull-left">
                                <a href="javascript:;" class="btn btn-default" type="button" @click="onTabs(false)" v-if="tabs > 0">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-success" href="javascript:;" @click="onTabs(true)" v-if="tabs < 3">
                                Next  <i class="fa fa-arrow-right"></i>
                                </a>
                                <button class="btn btn-success" type="submit" v-else>
                                 Save product <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </ValidationObserver>
        <div class="modal" id="modal-default" ref="attributeModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Product Atrribute</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="row">
                                <div v-for="(item, index) in attribute" :key="index">
                                    <div class="col-md-3 mb1">
                                        <label for="" class="control-label">key</label>
                                        <select class="form-control" v-model="item.key">
                                            <option value="color">Color</option>
                                            <option value="size">Size</option>
                                            <option value="type">Type</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb1">
                                        <label for="" class="control-label">Value</label>
                                        <input type="text" class="form-control" v-model="item.value">
                                    </div>
                                    <div class="col-md-4 mb1">
                                            <label for="" class="control-label">Price</label>
                                        <input type="text" class="form-control" v-model="item.price" v-on:keypress="checkNumber($event)">
                                    </div>
                                    <div class="col-md-1 text-center">
                                        <button class="btn btn-danger btn-xs" style="margin-top:3rem;" type="button" @click="removeAttribute(index)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-xs btn-info" type="button" @click="onNewAttribute()">
                                <i class="fa fa-plus"></i> Add Attribute
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button> -->
                        <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <Filemanager :show="fileManagerPopup" @selected="selectImage" @close="closeModalFileManager"/>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import Filemanager from '../FileManager.vue'
import { ValidationProvider,ValidationObserver } from "vee-validate"
export default {
    props:{
        edit:{
            type:Object,
            default(){
                return null
            }
        }
    },

    data(){
        return {
            price_type:'fix',
            rangeArr:[
                {
                    start:1,
                    end:2,
                    price:0
                }
            ],
            tabs:0,

            name:'',
            cogs:0,
            weight:0,
            price:0,
            setTag:[],
            setCategory:[],
            attribute:[
                {
                    key:'color',
                    value:'default',
                    price:0
                }
            ],
            description:'',
            cover:'',
            product_image:[],
            meta_slug:'',
            meta_title:'',
            meta_description:'',


            arrCategory:[],

            arrTag:[],
            fileManagerPopup:false,
            setStatusCover:false,
            errorForm:null,

            arrCs:[],
            cs:[],
            setting:{
                cod:false,
                image:true,
                quantity:true,
                layout:'single',
                email:false,
                name:true,
                phone:true,
                city:true,
                address:true,
                headerText:' Silahkan isi Form di bawah Dengan Lengkap dan tekan tombol BELI untuk Lakukan Pemesanan'
            },
            spesifictCs:false
        }
    },

    components:{
        multiselect:Multiselect,
        Filemanager,
        ValidationProvider,
        ValidationObserver
    },

    computed:{
        resAttribute(){
            return this.attribute.filter(x => x.value != 'default')
        },

        formatWeight:{
            get(){
                return this.weight
            },
            set(newValue){
                newValue = newValue.replace(/^[, ]+|[, ]+$|[, ]+/g, "").trim();
                if (newValue.length > 2) {
                    return this.weight = newValue.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
                } else {
                    this.weight = newValue;
                }
            }
        },
        
        formatPrice:{
            get(){
                return this.price
            },
            set(newValue){
                newValue = newValue.replace(/^[, ]+|[, ]+$|[, ]+/g, "").trim();
                if (newValue.length > 2) {
                    return this.price = newValue.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
                } else {
                    this.price = newValue;
                }
            }
        },

        formatCogs:{
            get(){
                return this.cogs
            },
            set(newValue){
                newValue = newValue.replace(/^[, ]+|[, ]+$|[, ]+/g, "").trim();
                if (newValue.length > 2) {
                    return this.cogs = newValue.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
                } else {
                    this.cogs = newValue;
                }
            }
        }
    },

    watch:{
        price_type(newValue){
            if(newValue == 'range'){
            }
        },

        name(newValue){
            if(newValue !=''){
                this.meta_slug = newValue.replace(/\s/g, "-").toLowerCase()
                this.meta_title = newValue
            }
        },

        edit(newValue){
            if(newValue !== null){
                this.initEdit()
            }
        }
    },

    mounted(){
        this.fetchCategory()
        this.fetchTag()
        this.fetchCs()
    },

    methods:{

        async fetchCategory(){
            try {
                let category = await axios.get('/api/category')
                category = category.data
                if(category.status){
                    return this.arrCategory = category.data
                }
            } catch (error) {
                throw error
            }
        },

        async fetchTag(){
             try {
                let tag = await axios.get('/api/tag')
                tag = tag.data
                if(tag.status){
                    return this.arrTag = tag.data
                }
            } catch (error) {
                throw error
            }
        },

        async fetchCs(){
            try {
                let cs = await axios.get('/backend/admin/get-cs')
                cs = cs.data
                if(cs.status) {
                    this.arrCs =cs.data
                }
            } catch (error) {
                throw error
            }
        },

        addPriceRange(){
            let checkEnd = this.rangeArr[this.rangeArr.length - 1]

            this.rangeArr.push({
                start:checkEnd.end + 1,
                end:checkEnd.end + 2,
                price:0
            })
        },

        removeRangeArr(index){
            this.rangeArr.splice(index, 1)
        },

        onTabs(type){
            if(type){
                if(this.tabs == 3){
                    return this.onSubmit()
                }
                this.tabs++
            } else{
                if(this.tabs > 0){
                    this.tabs--
                }
            }
        },

        async onSubmit(){
            try {
                let validateNumber = (arg)=>{
                    if(arg != '' || arg.length > 0) return arg.replace(/[\s,]+/g,'').trim();
                    return 0
                }
                let body = {
                    name:this.name,
                    weight:validateNumber(this.weight),
                    price_type:this.price_type,
                    price:validateNumber(this.price),
                    cogs:validateNumber(this.cogs),
                    price_range:this.rangeArr.filter(x => x.price > 0),
                    attribute:this.attribute.filter(x =>x.value !='default'),
                    description:this.description,
                    cover:this.cover,
                    product_image:this.product_image,
                    meta_slug:this.meta_slug,
                    meta_title:this.meta_title,
                    meta_description:this.meta_description,
                    category:this.setCategory.length ? this.setCategory.map(x => x.id) : '',
                    tag:this.setTag.length ? this.setTag.map(x => x.id) : '',
                    cs:this.spesifictCs ? this.cs.map(x=> {
                        return {user_id:x.id, email:x.email}
                    }) : null,
                    setting:this.setting
                }
                let post
                if(this.edit !== null){
                    post = await axios.put('/backend/product/' + this.edit.id, body)
                }else{
                    post = await axios.post('/backend/product', body)

                }
                post = post.data
                if(post.status){
                    window.location.href='/backend/product'
                    this.reset(post.data)
                }else{
                    this.errorForm = post.data
                }
                
            } catch (error) {
                throw error
            }
            
        },

        reset(params) {
            Object.assign(this.$data, this.$options.data.call(this))
            return this.$emit('on-created', params)
        },

        addTag (newTag) {
            // const tag = {
            //     name: newTag,
            // }
            // this.arrTag.push(tag)
            // this.setTag.push(tag)
        },

        addAttribute(){
            let modal = this.$refs.attributeModal
            $(modal).modal('show')
        },

        onNewAttribute(){
            this.attribute.push({
                key:'color',
                value:'Merah',
                price:this.price
            })
        },

        removeAttribute(index){
            this.attribute.splice(index, 1)
        },

        sendingEvent (file, xhr, formData) {
            // formData.append('paramName', 'some value or other');
        },

        successEvent(file, response){
            if(response.status){
                this.product_image.push(response.data)
                let m = this.$refs.myVueDropzone.getUploadingFiles()
            }
        },

        removedEvent(file, xhr, error){
            console.log(file)
        },

        selectImage(params){
            if(this.setStatusCover){
                this.cover = params[0];
                this.setStatusCover = false
            }else{
                this.product_image = params
            }
                this.fileManagerPopup = false
        },

        setCover(){
            this.fileManagerPopup = true
            this.setStatusCover = true
        },

        // generate edit
        initEdit(){
            this.name = this.edit.name
            this.cogs = this.edit.cogs
            this.weight = this.edit.weight
            this.price_type = this.edit.price_type.toLowerCase()
            this.price = this.edit.price
            this.rangeArr = this.edit.range
            this.attribute = this.edit.models
            this.description = this.edit.description
            this.cover = this.edit.main_image
            this.product_image = this.edit.gallery.map(x => x.url)
            this.meta_slug = this.edit.slug
            this.meta_title = this.edit.meta_title
            this.meta_description = this.edit.meta_description
            this.setCategory = this.edit.category
            this.setTag = this.edit.tag
            this.cs = this.edit.cs ? this.edit.cs.map(x=>{
                return{
                    id:x.user_id,
                    email:x.email
                }
            }) : []
            this.spesifictCs = this.edit.cs.length ? true : false
            let setting = this.edit.setting ? this.edit.setting.config : this.setting
            this.setting = {
                cod:setting.cod,
                image:setting.image,
                quantity:setting.quantity,
                layout:setting.layout,
                email:setting.email,
                name:typeof setting.name == 'undefined' ? true : setting.name,
                phone:typeof setting.phone == 'undefined' ? true : setting.phone,
                city:typeof setting.city == 'undefined' ? true : setting.city,
                address:typeof setting.address == 'undefined' ? true : setting.address,
                headerText:typeof setting.headerText == 'undefined' ? ' Silahkan isi Form di bawah Dengan Lengkap dan tekan tombol BELI untuk Lakukan Pemesanan' : setting.headerText
            }
            
        },

        closeModalFileManager(){
            this.fileManagerPopup = false
            this.setStatusCover = false
        },

        checkNumber(event){
            return this.$cekNumber(event)
        }
    }
}
</script>
<style lang="scss">
    .form-img{
        display: flex;
        flex-direction: row;
        img{
            width:60px;
            margin-left: 3px;
        }
    }

    .form-group{
        .filemanager-ul{
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row;
            margin-top: 1rem;
            li{
                margin-right: 5px;
                border:1px solid #ddd;
                width: 100px;
                height: 100px;
                overflow: hidden;
                img{
                    width:100%;
                }
            }
        }
    }
</style>