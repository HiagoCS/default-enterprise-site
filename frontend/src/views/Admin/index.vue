<template>
        <div class="container-fluid">
        <div class="col-10 main">
            <div class="row-12 content">
                <div class="row-2 left-menu">
                    <div class="row-12 title">

                        <!-- @/assets/storage/img/uploads -->
                        <img :src='logo'>
                        <h4>{{user['name']}}</h4>
                    </div>
                    <span v-for="item in templates" @click="template=item">{{ item }}</span>
                </div>
                <div class="row-2 right-content">
                    <component :is="actualTemplate" v-bind.sync="props"></component>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" src="./style.scss" scoped></style>
<script>
import axios from "@/api/axios"
import VueCookies from 'vue-cookies'
import {
    CabecalhoTemplate,
    ImagensTemplate
} from './components/templates/templates.js';
    export default{
        name:"Admin-Home",
        computed:{
            actualTemplate(){
                if(this.template == 'Cabecalho')
                    return CabecalhoTemplate;
                if(this.template == 'Imagens')
                    return ImagensTemplate;
            },
            props(){
                if(this.template == 'Cabecalho')
                    return {};
                if(this.template == 'Imagens')
                    return {currentLogo:this.logo};
            }
        },
        data(){
            return{
                user:"",
                logo:null,
                template:'Imagens',
                templates:[
                    'Imagens',
                    'Cabecalho',
                    'Contatos',
                    'Corpo',
                    'Portifólio',
                    'Localização',
                    'Sobre',
                    'Formulários',
                    'Rodapé',

                ]
            }
        },
        methods:{
            updateLogo(previewLogo){
                this.logo = previewLogo;
            }
        },
        async created(){
            axios.validate()
            if(VueCookies.get('user')){
                this.user = VueCookies.get('user');
                const {data} = await axios.logo();
                this.logo = "/"+data.path;
                console.log(this.logo);
                
            }
            else{
                this.templates = [];
                this.template = '';
                this.$swal({
                    title:"Você não está logado",
                    icon:'error',
                    confirmButtonText: 'Login',
                }).then(({isConfirmed})=>{
                    if(isConfirmed){
                        window.location.href = '/admin/login'
                    }
                }).catch(err=>{
                    console.log(err);
                });
                console.log(this.user);
            }
        }
    }
</script>