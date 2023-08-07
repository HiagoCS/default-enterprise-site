import axios from "axios";
import VueCookies from 'vue-cookies'
import {useRouter} from "vue-router";

const api = axios.create({
 baseURL: "http://localhost:8000/api",
});
const validate = () =>{
    api.get('/user', {headers:{
        'Authorization': `Bearer ${VueCookies.get('token')}`
    }}).then(({data, request})=>{
        if(request.status == 200 && VueCookies.get('token') == data.token){
            VueCookies.set('user', data)
            console.log("here")
        }

    }).catch(({response}) => {
        if(VueCookies.remove('user')){
            VueCookies.set('token', null);
        }
        
    });
}
const login =  async (user) =>{
    try{
        const response = api.post("/admin/login", user);
        return (await response);
    }catch(error){
        if((await error).response.data.status == 401){
            const errors = [];
            if((await error).response.data.credentials['cpf'] == '' || (await error).response.data.credentials['cpf'] == null)
                errors.push('cpf');
            if((await error).response.data.credentials['password'] == '' || (await error).response.data.credentials['password'] == null)
                errors.push('password');
            let response = (await error).response.data;
            response.msg = errors.length > 0 ? {text: response.msg.text, errors:errors}: 'Erro Desconhecido';
            return response;
        }
        else{
            let response = (await error).response.data;
            response.msg = 'Erro Desconhecido';
            return response;
        }
        
    }
}
const logo = async() =>{
    const response = api.get("admin/account/logo/");
    return (await response);
}

export default {api, login, validate, logo}