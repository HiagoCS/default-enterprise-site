import HomeComponent from "../views/Admin/index.vue";
import LoginComponent from "../views/Admin/components/LoginComponent";
const AdminPanel = [
    {
        path: "/admin/",
        name: "admin-home",
        component : HomeComponent
    
    },
    {
        path: "/admin/login",
        name: "admin-login",
        component : LoginComponent
    
    }
];
export default AdminPanel;