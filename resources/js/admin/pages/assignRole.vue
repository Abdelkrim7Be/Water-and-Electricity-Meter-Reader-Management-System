<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <span class="_title0"
                        >Role assignment
                        <div
                            style="width: 200px; margin-top: -7px; float: right"
                        >
                            <Select
                                v-model="data.id"
                                style="
                                    width: 200px;
                                    /* margin-bottom: 5px !important; */
                                "
                                placeholder="Type d'utilisateur"
                                @on-change="changeUser"
                            >
                                <Option
                                    :value="r.id"
                                    v-for="(r, i) in roles"
                                    :key="i"
                                    v-if="roles.length"
                                    >{{ r.roleName }}</Option
                                >
                            </Select>
                        </div></span
                    >

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Ressource</th>
                                <th>Lire</th>
                                <th>Créer</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr v-for="(r, i) in ressources" :key="i">
                                <td class="_table_name">
                                    {{ r.ressourceName }}
                                </td>
                                <td><Checkbox v-model="r.read"></Checkbox></td>
                                <td><Checkbox v-model="r.write" v-if="!(r.ressourceName == 'Assign_Role') && !(r.ressourceName == 'Historique')"></Checkbox></td>
                                <td>
                                    <Checkbox v-model="r.update" v-if="!(r.ressourceName == 'Historique')"></Checkbox>
                                </td>
                                <td>
                                    <Checkbox v-model="r.delete" v-if="!(r.ressourceName == 'Assign_Role')"></Checkbox>
                                </td>
                            </tr>
                            <!-- ITEMS -->
                            <div class="center_button">
                                <Button class="btn_center_button" type="primary" :loading="isSending" :disabled="isSending" @click="assignRoles" v-if="isUpdatePermitted">Attribuer</Button>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                roleName: "",
                id: null,
            },
            isSending: false,

            roles: [],
            ressources: [
                {
                    ressourceName: "Relèves",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "releves",
                },
                {
                    ressourceName: "Releveurs",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "releveurs",
                },
                {
                    ressourceName: "Admin_Users",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "adminusers",
                },
                {
                    ressourceName: "Roles",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "roles",
                },
                {
                    ressourceName: "Assign_Role",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "assignRole",
                },
                {
                    ressourceName: "Historique",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "historique",
                },
            ],
            defaultRessourcesPermissions: [
                {
                    ressourceName: "Relèves",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "releves",
                },
                {
                    ressourceName: "Releveurs",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "releveurs",
                },
                {
                    ressourceName: "Admin_Users",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "adminusers",
                },
                {
                    ressourceName: "Roles",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "roles",
                },
                {
                    ressourceName: "Assign_Role",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "assignRole",
                },
                {
                    ressourceName: "Historique",
                    read: false,
                    write: false,
                    update: false,
                    delete: false,
                    name: "historique",
                },
            ],
        };
        // if ... equal flase, we will block a certain API
    },
    methods: {
        async assignRoles() {
            // console.log(this.ressources);
            let data = JSON.stringify(this.ressources); //.convert this JSON data into a string
            const res = await this.callApi('post', '/app/assign_role', { 'permission': data , 'id': this.data.id });
            if (res.status == 200) {
                this.s("Les permissions ont été attribuées au rôle souhaité avec succès.");
                let index = this.roles.findIndex(role => role.id == this.data.id);
                this.roles[index].permission = data;
            } else {
                this.swr();
            }
        },
        changeUser() {
            // give me the index of the role where the id matches this.data.id
            let index = this.roles.findIndex(role => role.id == this.data.id);
            // console.log(index);
            let permission = this.roles[index].permission;
            if (!permission) {
                this.ressources = this.defaultRessourcesPermissions;
            } else {
                this.ressources = JSON.parse(permission);
            }
            // console.log(permission);
        },
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        const res = await this.callApi("get", "app/get_roles");
        if (res.status == 200) {
            this.roles = res.data.data;
            if (res.data.data.length) {
                this.data.id = res.data.data[0].id;
                if (res.data.data[0].permission) {
                    this.ressources = JSON.parse(res.data.data[0].permission);//to keep the same permission even with the reload
                }
            }
        } else {
            this.swr();
        }
    },
};
</script>

<style scoped>
.router-link-exact-active {
    color: #10549d !important;
    border-right: none !important;
    background-color: #fff !important;
}
</style>
