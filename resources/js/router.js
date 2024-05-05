// the vue-router is a plugin , so to use it , we use the method : use()
// vue-router has a backward compatibility mode that allows it to work on older browsers
// but it puts a hash or pound in front of our adress that why i think we don't need it anymore
// that swhy we use the (mode:'history') that uses the push states that is not supported but older browsers

import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import app from "./components/app.vue";
import ExampleComponent from "./components/pages/basic/ExampleComponent.vue";
import newRoutePage from "./components/pages/basic/newRoutePage.vue";
import hooks from "./components/pages/basic/hooks.vue";
import methods from "./components/pages/basic/methods.vue";

// project pages
import home from "./admin/pages/home.vue";
import releveur from "./admin/pages/releveur.vue";
import adminusers from "./admin/pages/adminusers.vue";
import planreleve from "./admin/pages/planreleve.vue";
import historique from "./admin/pages/historique.vue";
import login from "./admin/pages/login.vue";
import role from "./admin/pages/role.vue";
import assignRole from "./admin/pages/assignRole.vue";

import usecom from './vuex/usecom.vue'
const routes = [
    // project routes...

    // { path: "/", component: home },
    // { path: "/", component: planreleve, name: "releves"},
    { path: "/releves", component: planreleve, name: "releves"},
    { path: "/releveurs", component: releveur, name:"releveurs" },
    { path: "/adminusers", component: adminusers, name:"adminusers" },
    { path: "/login", component: login, name:"login" },
    { path: "/roles", component: role, name:"roles" },
    { path: "/assignRole", component: assignRole, name:"assignRole" },
    { path: "/historique", component: historique, name:"historique" },
    // { path: "/testvuex", component: usecom },

    // { path: "/new-vue-route", component: ExampleComponent },

    // basic test tuto routes
    // { path: "/new-route", component: newRoutePage },
    // vue hooks
    // { path : '/hooks', component: hooks},
    // { path : '/methods', component: methods},
];

const router = createRouter({
    history: createWebHistory(),
    // In Vue Router 4, createWebHistory() is used to create a history object to handle the browser's history API. This object enables Vue Router to change the URL and update the browser's history without triggering a page refresh.
    routes,
});

export default router;
