<template>
    <div class="container-fluid">
        <div class="col-6 main">
            <div class="row-12 header">
                <img :src="logo">
                <span>
                    <h4 class="modal-title">Login</h4>
                </span>
            </div>
            <div class="row-12 content">
                <div class="col-10 row-12">
                    <Form :inputs="fields" :content="user"/>
                </div>
            </div>
            <div class="row-6 footer">
                <div class="row-12 btn-group">
                    <button class="btn btn-success" @click="login()">Entrar</button>
                    <button class="btn btn-primary">Registrar-se</button>
                </div>
                <a href="">Esqueceu a senha?</a>
            </div>
        </div>
    </div>
</template>

<style lang="scss" src="./style.scss" scoped></style>

<script>
import Form from"@/components/commons/Form";
import axios from "@/api/axios"
import VueCookies from 'vue-cookies'
import $ from 'jquery'
export default {
    name:'admin-login',
    components:{Form},
    async created(){
        const {data} = await axios.logo();
        this.logo = "/"+data.path;
        console.log(this.logo);

        axios.validate()
        if(VueCookies.get('user')){
            if(VueCookies.get('user')){
                console.log(VueCookies.get('user'))
                window.location.href = "/admin/"
            }
        }
    },
    data(){
        return{
            logo:null,
            user:{
                cpf:"",
                password:""
            },
            fields:[
                    {
                    name:'CPF',
                    id:'cpf',
                    type:'text',
                    mask:'###.###.###-##'
                    },
                    {
                    name:'Senha',
                    id:'password',
                    type:'text',
                    mask:''
                    }
            ],
            label_class:{
                cpf:"",
                password:""
            }
        }
    },
    methods:{
        async login(){
            const {status, data, msg} = await axios.login(this.user);
            if(data){
                if(status == 401){
                    this.$swal({
                        title:data,
                        text:msg.text,
                        icon:'error',
                    });
                    if(msg.errors){
                        msg.errors.forEach(error =>{
                            $(`#${error}`).css('borderColor', '#ff4242');
                        });
                    }
                }
                if(status == 200){
                    VueCookies.set('token', data.token);
                    VueCookies.set('user', data.data.user);
                    window.location.href = "/admin/";
                }
                else{
                    return console.log(data);
                }
            }
        }
    }
}
</script>