<template>
    <div class="row-12 content">
        <div class="col-10 offset-1 input-with-preview">
        <div>
            <h4>Logo do Site</h4>
            <img :src="!previewLogo ? currentLogo : previewLogo" class="logo-preview" >
        </div>
        <div class="col-8 row-2 input-group">
            <div class="col-12">
                <input type="file" class="custom-file-input" id="logo" accept="image/*" @change="preview($event)">
                <label class="custom-file-label" for="logo">Escolha a imagem (JPG || PNG)</label>
            </div>
            <!-- <div class="col-12 row alias">
                <input type="text" 
                    class="form-control"
                    @click="alias_class='active'"
                    @focusout="alias_class=''"
                    v-model="logo_alias" 
                    id="logo_alias"
                    style="width:40vw;">
                <label for="logo_alias" :class="logo_alias == '' || !logo_alias ? alias_class:'active'">Apelido da Imagem</label>
            </div> -->
        </div>
    </div>
    <div class="col-10 offset-1 actions">
        <button :class="`btn btn-${(logo_alias != '' || image)? 'primary':'secondary'}`" @click="upload()">Salvar</button>
        <button class="btn btn-danger">Cancelar</button>
    </div>
    </div>
</template>

<style lang="scss" src="./style.scss" scoped></style>

<script>
import axios from "@/api/axios"
import VueCookies from 'vue-cookies'
export default{
    name:'ImagensTemplate',
    props:['currentLogo'],
    data(){
        return{
            previewLogo:null,
            logo_alias:null,
            alias_class: '',
            image:null
        }
    },
    methods:{
        upload(){
            //console.log(this.image);
            let data = new FormData();
            data.append('file', this.image);
            data.append('media_type', 'Logo');
            data.append('media_alias', this.logo_alias);
            axios
            .api
            .post('/admin/account/logo/upload', data, {headers:{
                'content-type': 'multipart/form-data'
            }})
            .then((request)=>{
                console.log(request)
            })
            .catch((err) => {
                console.log(err)
            });
        },  
        preview(e){
            this.image = e.target.files[0];
            const reader = new FileReader();
            reader.readAsDataURL(this.image);
            reader.onload = e =>{
                //this.$emit('updateLogo', e.target.result)
                this.previewLogo = e.target.result;
            };
            console.log(this.previewLogo);
            console.log(this.image);
        }
    }
}
</script>