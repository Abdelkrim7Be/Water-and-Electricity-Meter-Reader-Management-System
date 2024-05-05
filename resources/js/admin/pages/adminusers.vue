<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="row" v-if="isWritePermitted">
                    <div class="col-12 col-md-3">
                        <div
                            class="_1adminOverveiw_card _box_shadow _border_radious _mar_b30 _1adminOverveiw_bg_one"
                        >
                            <div class="_1adminOverveiw_card_left">
                                <p class="_1adminOverveiw_card_left_num">
                                    {{ planningsCount }}
                                </p>

                                <p class="_1adminOverveiw_card_left_title">
                                    <router-link to="/releves">
                                        Relèves
                                    </router-link>
                                </p>
                            </div>
                            <div class="_1adminOverveiw_card_right">
                                <Icon type="md-calendar" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div
                            class="_1adminOverveiw_card _box_shadow _border_radious _mar_b30 _1adminOverveiw_bg_two"
                        >
                            <div class="_1adminOverveiw_card_left">
                                <p class="_1adminOverveiw_card_left_num">
                                    {{ releveursCount }}
                                </p>

                                <p class="_1adminOverveiw_card_left_title">
                                    <router-link to="/releveurs">
                                        Releveurs
                                    </router-link>
                                </p>
                            </div>
                            <div class="_1adminOverveiw_card_right">
                                <Icon type="md-people" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div
                            class="_1adminOverveiw_card _box_shadow _border_radious _mar_b30 _1adminOverveiw_bg_two"
                        >
                            <div class="_1adminOverveiw_card_left">
                                <p class="_1adminOverveiw_card_left_num">
                                    {{ countAdmins }}
                                </p>

                                <p class="_1adminOverveiw_card_left_title">
                                    <router-link to="/adminusers"
                                        >Admins</router-link
                                    >
                                </p>
                            </div>
                            <div class="_1adminOverveiw_card_right">
                                <Icon type="md-lock" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div
                            class="_1adminOverveiw_card _box_shadow _border_radious _mar_b30 _1adminOverveiw_bg_two"
                        >
                            <div class="_1adminOverveiw_card_left">
                                <p class="_1adminOverveiw_card_left_num">
                                    {{ countUsers }}
                                </p>

                                <p class="_1adminOverveiw_card_left_title">
                                    <router-link to="/adminusers"
                                        >Utilisateurs</router-link
                                    >
                                </p>
                            </div>
                            <div class="_1adminOverveiw_card_right">
                                <Icon type="md-person" />
                            </div>
                        </div>
                    </div>
                </div>
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div
                    class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
                >
                    <p class="_title0">
                        Admins/Users
                        <Button @click="addModal = true" v-if="isWritePermitted"
                            ><Icon type="ios-add" /> Ajouter admin</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Nom complet</th>
                                <th>Email</th>
                                <!-- <th>Role ID</th> -->
                                <th>Type d'utilisateur</th>
                                <th>Crée le</th>
                                <!-- <th>Updated_at</th> -->
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr
                                v-for="(user, i) in users"
                                :key="i"
                                v-if="users.length"
                            >
                                <td>{{ user.id }}</td>
                                <td class="_table_name">
                                    {{ user.fullName }}
                                </td>
                                <td class="_table_name">{{ user.email }}</td>
                                <!-- <td >{{ user.role_id }}</td> -->
                                <td>{{ user.userType }}</td>
                                <td class="shrink_110_px">
                                    {{
                                        user.created_at
                                            .slice(0, 19)
                                            .replace("T", " ")
                                    }}
                                </td>
                                <!-- <td class="shrink_110_px">
                                    {{
                                        user.updated_at
                                            .slice(0, 19)
                                            .replace("T", " ")
                                    }}
                                </td> -->
                                <td>
                                    <button
                                        class="_btn _action_btn edit_btn1"
                                        type="button"
                                        @click="showEditingModal(user, i)"
                                        v-if="isUpdatePermitted"
                                    >
                                        Modifier
                                    </button>
                                    <button
                                        class="_btn _action_btn make_btn1"
                                        type="button"
                                        @click="showDeletingModal(user, i)"
                                        :loading="user.isDeleting"
                                        v-if="isDeletePermitted"
                                    >
                                        Supprimer
                                    </button>
                                </td>
                            </tr>
                            <!-- ITEMS -->
                        </table>
                    </div>
                </div>

                <!--~~~~~~~ ADMIN ADDING MODEL~~~~~~~~~-->

                <Modal
                    :closable="false"
                    v-model="addModal"
                    title="Ajouter admin"
                    :mask-closable="false"
                >
                    <Input
                        v-model="data.fullName"
                        type="text"
                        placeholder="Nom complet...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="data.email"
                        type="email"
                        placeholder="Email...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="data.password"
                        type="password"
                        placeholder="Mot de passe...."
                        style="margin-bottom: 5px !important"
                    />
                    <Select
                        v-model="data.role_id"
                        style="width: 200px; margin-bottom: 5px !important"
                        placeholder="Type d'utilisateur"
                    >
                        <Option
                            :value="r.id"
                            v-for="(r, i) in roles"
                            :key="i"
                            v-if="roles.length"
                            >{{ r.roleName }}</Option
                        >
                    </Select>

                    <template #footer>
                        <Button type="default" @click="closeModals"
                            >Fermer</Button
                        >
                        <Button
                            type="primary"
                            @click="addAdmin"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{
                                isAdding ? "Ajout..." : "Ajouter admin"
                            }}</Button
                        >
                    </template>
                </Modal>
                <!--~~~~~~~ RELEVEUR EDITING MODEL~~~~~~~~~-->

                <Modal
                    :closable="false"
                    v-model="editModal"
                    title="Modifier Admin"
                    :mask-closable="false"
                >
                    <Input
                        v-model="editData.fullName"
                        type="text"
                        placeholder="Nom complet...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="editData.email"
                        type="email"
                        placeholder="Email...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="editData.password"
                        type="password"
                        placeholder="Mot de passe...."
                        style="margin-bottom: 5px !important"
                    />
                    <Select
                        v-model="editData.role_id"
                        style="width: 200px; margin-bottom: 5px !important"
                        placeholder="Type d'utilisateur"
                    >
                        <Option
                            :value="r.id"
                            v-for="(r, i) in roles"
                            :key="i"
                            v-if="roles.length"
                            >{{ r.roleName }}</Option
                        >
                    </Select>

                    <template #footer>
                        <Button type="default" @click="editModal = false"
                            >Fermer</Button
                        >
                        <Button
                            type="primary"
                            @click="editAdmin"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{
                                isAdding ? "Edit..." : "Modifier admin"
                            }}</Button
                        >
                    </template>
                </Modal>

                <!--~~~~~~~ RELEVEUR DELETING MODEL~~~~~~~~~-->

                <deleteModal></deleteModal>

                <Page
                    :total="pageInfo.total"
                    :current="pageInfo.current_page"
                    :page-size="parseInt(pageInfo.per_page)"
                    @on-change="getUserData"
                    v-if="pageInfo"
                />
            </div>
        </div>
    </div>
</template>

<script>
import deleteModal from "../components/deleteModal.vue";
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            data: {
                fullName: "",
                email: "",
                password: "",
                role_id: null,
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            users: [],
            editData: {
                fullName: "",
                email: "",
                password: "",
                role_id: null,
            },
            index: -1,
            token: "",
            isIconImageNew: false,
            isEditingItem: false,
            releveursCount: 0,
            planningsCount: 0,
            countUsers: 0,
            countAdmins: 0,
            total: 5,
            pageInfo: null,
            roles: [],
        };
    },
    methods: {
        closeModals() {
            this.addModal = false;
            this.editModal = false;
            this.data.fullName = "";
            this.data.email = "";
            this.data.password = "";
            this.data.role_id = " ";
        },
        async getUserData(page = 1) {
            const [res, resRole] = await Promise.all([
                this.callApi(
                    "get",
                    `/app/get_users?page=${page}&total=${this.total}`
                ),
                this.callApi("get", "/app/get_roles"),
            ]);
            // const res = await this.callApi(
            //     "get",
            //     `/app/get_users?page=${page}&total=${this.total}`
            // );
            // const resRole = await this.callApi("get", "/app/get_roles");
            if (res.status == 200) {
                this.users = res.data.data;
                this.pageInfo = res.data;
            } else {
                this.swr();
            }
            if (resRole.status == 200) {
                this.roles = resRole.data.data;
            } else {
                this.swr();
            }

            // the problem is the delay, which is annoying
        },
        async fetchData() {
            try {
                const releveurs = await this.callApi(
                    "get",
                    "/app/get_releveur"
                );
                const plannings = await this.callApi("get", "/app/get_plan");
                const users = await this.callApi("get", "/app/get_users");

                this.releveursCount = releveurs.data.data.length;
                this.planningsCount = plannings.data.data.length;

                let countAdmins = 0;
                let countUsers = 0;

                users.data.data.forEach((user) => {
                    if (user.userType === "User") {
                        countUsers++;
                    } else {
                        countAdmins++;
                    }
                });

                this.countAdmins = countAdmins;
                this.countUsers = countUsers;
            } catch (error) {
                console.error(error);
            }
        },
        async addAdmin() {
            if (
                this.data.fullName.trim() == "" &&
                this.data.email.trim() == "" &&
                this.data.password.trim() == "" &&
                !this.data.role_id
            ) {
                this.e("Tous les champs doivent etre remplis");
                return;
            }
            const res = await this.callApi(
                "post",
                "/app/create_user",
                this.data
            );
            if (res.status == 201) {
                this.fetchData();
                this.users.unshift(res.data);
                this.s("La création a été effectuée avec succès");
                this.getUserData();
                this.addModal = false;
                this.data.fullName = "";
                this.data.email = "";
                this.data.password = "";
                this.data.role_id = "";
            } else {
                if (res.status == 422 || res.status == 419) {
                    let missingFields = [];

                    if (res.data.errors.fullName) {
                        missingFields.push(res.data.errors.fullName);
                    }

                    if (res.data.errors.email) {
                        missingFields.push(res.data.errors.email);
                    }

                    if (res.data.errors.password) {
                        missingFields.push(res.data.errors.password);
                    }
                    if (res.data.errors.role_id) {
                        missingFields.push(res.data.errors.role_id);
                    }

                    if (missingFields.length > 0) {
                        let message = missingFields.join(" || ");
                        this.e(message);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async editAdmin() {
            if (
                this.editData.fullName.trim() == "" &&
                this.editData.email.trim() == "" &&
                !this.editData.role_id
            ) {
                this.e("Tous les champs doivent etre remplis");
                return;
            }
            const res = await this.callApi(
                "post",
                "app/edit_user",
                this.editData
            );
            if (res.status == 200) {
                this.fetchData();
                this.users[this.index].fullName = this.editData.fullName;
                this.users[this.index].email = this.editData.email;
                this.users[this.index].role_id = this.editData.role_id;
                if (this.editData.password) {
                    this.users[this.index].password = this.editData.password;
                }
                this.s("La modification a été effectuée avec succès");
                this.editModal = false;
                this.fetchData();
                this.getUserData();
            } else {
                if (res.status == 422 || res.status == 419) {
                    let missingFields = [];

                    if (res.data.errors.fullName) {
                        missingFields.push(res.data.errors.fullName);
                    }

                    if (res.data.errors.email) {
                        missingFields.push(res.data.errors.email);
                    }

                    if (res.data.errors.password) {
                        missingFields.push(res.data.errors.password);
                    }
                    if (res.data.errors.role_id) {
                        missingFields.push(res.data.errors.role_id);
                    }

                    if (missingFields.length > 0) {
                        let message = missingFields.join(" || ");
                        this.e(message);
                    }
                } else if (res.status == 203) {
                    this.i("pas de changement fait!");
                    this.editModal = false;
                } else {
                    this.swr();
                }
            }
        },
        showEditingModal(user, index) {
            let obj = {
                id: user.id,
                fullName: user.fullName,
                email: user.email,
                role_id: user.role_id,
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
            this.isEditingItem = true;
        },
        showDeletingModal(user, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "/app/delete_user",
                data: user,
                deletingIndex: i,
                isDeleted: false,
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
            console.log("delete method called");
        },

        closeEditModal() {
            this.isEditingItem = false;
            this.editModal = false;
        },
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        this.fetchData();
        this.getUserData();
    },
    components: {
        deleteModal,
    },
    computed: {
        ...mapGetters(["getDeleteModalObj"]),
    },
    watch: {
        getDeleteModalObj(obj) {
            if (obj.isDeleted) {
                this.users.splice(obj.deletingIndex, 1);
                this.fetchData();
                this.getUserData();
            }
        },
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
