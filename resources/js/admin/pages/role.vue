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
                                    <router-link to="/releves"> Relèves </router-link>
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
                        Management des roles
                        <Button @click="addModal = true" v-if="isWritePermitted"
                            ><Icon type="ios-add" /> Ajouter role</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Role</th>
                                <th>Description</th>
                                <th>Crée le</th>
                                <!-- <th>Updated_at</th> -->
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr
                                v-for="(role, i) in roles"
                                :key="i"
                                v-if="roles.length"
                            >
                                <td>{{ role.id }}</td>
                                <td class="_table_name">
                                    {{ role.roleName }}
                                </td>
                                <td class="shrink_110_px">
                                    {{ role.description }}
                                </td>
                                <td class="shrink_110_px">
                                    {{
                                        role.created_at
                                            .slice(0, 19)
                                            .replace("T", " ")
                                    }}
                                </td>
                                <!-- <td class="shrink_110_px">
                                    {{
                                        role.updated_at
                                            .slice(0, 19)
                                            .replace("T", " ")
                                    }}
                                </td> -->
                                <td>
                                    <button
                                        class="_btn _action_btn edit_btn1"
                                        type="button"
                                        @click="showEditingModal(role, i)"
                                        v-if="isUpdatePermitted"
                                    >
                                        Modifier
                                    </button>
                                    <button
                                        class="_btn _action_btn make_btn1"
                                        type="button"
                                        @click="showDeletingModal(role, i)"
                                        :loading="role.isDeleting"
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
                    title="Ajouter un role"
                    :mask-closable="false"
                >
                    <Input
                        v-model="data.roleName"
                        type="text"
                        placeholder="Libellé...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="data.description"
                        type="text"
                        placeholder="Description...."
                        style="margin-bottom: 5px !important"
                    />
                    <template #footer>
                        <Button type="default" @click="closeModals"
                            >Fermer</Button
                        >
                        <Button
                            type="primary"
                            @click="addRole"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{
                                isAdding ? "Ajout..." : "Ajouter role"
                            }}</Button
                        >
                    </template>
                </Modal>
                <!--~~~~~~~ RELEVEUR EDITING MODEL~~~~~~~~~-->

                <Modal
                    :closable="false"
                    v-model="editModal"
                    title="Changer Role"
                    :mask-closable="false"
                >
                    <Input
                        v-model="editData.roleName"
                        type="text"
                        placeholder="Libellé...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="editData.description"
                        type="email"
                        placeholder="Description...."
                        style="margin-bottom: 5px !important"
                    />

                    <template #footer>
                        <Button type="default" @click="editModal = false"
                            >Fermer</Button
                        >
                        <Button
                            type="primary"
                            @click="editRole"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{ isAdding ? "Edit..." : "Changer role" }}</Button
                        >
                    </template>
                </Modal>

                <!--~~~~~~~ RELEVEUR DELETING MODEL~~~~~~~~~-->

                <deleteModal></deleteModal>

                <Page
                    :total="pageInfo.total"
                    :current="pageInfo.current_page"
                    :page-size="parseInt(pageInfo.per_page)"
                    @on-change="getRoleData"
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
                roleName: "",
                description: "",
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            roles: [],
            editData: {
                roleName: "",
                description: "",
            },
            index: -1,
            token: "",
            isEditingItem: false,
            releveursCount: 0,
            planningsCount: 0,
            countUsers: 0,
            countAdmins: 0,
            total: 5,
            pageInfo: null,
        };
    },
    methods: {
        closeModals() {
            this.addModal = false;
            this.editModal = false;
            this.data.roleName = "";
            this.data.description = "";
        },
        async getRoleData(page = 1) {
            const res = await this.callApi(
                "get",
                `/app/get_roles?page=${page}&total=${this.total}`
            );
            if (res.status == 200) {
                this.roles = res.data.data;
                this.pageInfo = res.data;
            } else {
                this.swr();
            }
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
        async addRole() {
            if (
                this.data.roleName.trim() == "" &&
                this.data.description.trim() == ""
            ) {
                this.e("Tous les champs doivent etre remplis");
                return;
            }

            const res = await this.callApi(
                "post",
                "/app/create_role",
                this.data
            );
            if (res.status == 201) {
                this.fetchData();
                this.roles.unshift(res.data);
                this.s("La création a été effectué avec succès");
                this.getRoleData();
                this.addModal = false;
                this.data.roleName = "";
                this.data.description = "";
            } else {
                if (res.status == 422 || res.status == 419) {
                    if (res.status == 422) {
                        let missingFields = [];

                        if (res.data.errors.roleName) {
                            missingFields.push(res.data.errors.roleName[0]);
                        }

                        if (res.data.errors.description) {
                            missingFields.push(res.data.errors.description[0]);
                        }

                        if (missingFields.length > 0) {
                            let message = missingFields.join(" & ");
                            this.e(message);
                        }
                    }
                } else {
                    this.swr();
                }
            }
        },
        async editRole() {
            if (
                this.editData.roleName.trim() == "" &&
                this.editData.description.trim() == "" 
            ) {
                this.e("Tous les champs doivent etre remplis");
                return;
            }
            const res = await this.callApi(
                "post",
                "app/edit_role",
                this.editData
            );
            if (res.status == 200) {
                this.fetchData();
                this.roles[this.index].roleName = this.editData.roleName;
                this.roles[this.index].description = this.editData.description;
                this.s("La modification a été effectuée avec succès");
                this.editModal = false;
            } else {
                if (res.status == 422 || res.status == 419) {
                    let missingFields = [];

                    if (res.data.errors.roleName) {
                        missingFields.push(res.data.errors.roleName);
                    }

                    if (res.data.errors.description) {
                        missingFields.push(res.data.errors.description);
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
        showEditingModal(role, index) {
            let obj = {
                id: role.id,
                roleName: role.roleName,
                description: role.description,
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
            this.isEditingItem = true;
        },
        showDeletingModal(role, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "/app/delete_role",
                data: role,
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
        this.getRoleData();
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
                this.roles.splice(obj.deletingIndex, 1);
                this.fetchData();
                this.getRoleData();
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
