import { createRouter, createWebHistory } from "vue-router";

export default createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/releves', name: 'releves', component: () => import('./admin/pages/planreleve.vue') },
        { path: '/releveurs', name: 'releveurs', component: () => import('./admin/pages/releveur.vue') },
        { path: '/adminusers', name: 'adminusers', component: () => import('./admin/pages/adminusers.vue') },
        { path: '/login', name: 'login', component: () => import('./admin/pages/login.vue') },
        { path: '/roles', name: 'roles', component: () => import('./admin/pages/role.vue') },
        { path: '/assignRole', name: 'assignRole', component: () => import('./admin/pages/assignRole.vue') },
        { path: '/historique', name: 'historique', component: () => import('./admin/pages/historique.vue') },
    ],
});
