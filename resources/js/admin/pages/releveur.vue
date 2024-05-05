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
                        Releveurs
                        <Button @click="addModal = true" v-if="isWritePermitted"
                            ><Icon type="ios-add" /> Ajouter releveur</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>S_num</th>
                                <th>Profil</th>
                                <th class="fullName">Nom complet</th>
                                <th>D_naissance</th>
                                <th>Email</th>
                                <th>Crée le</th>
                                <!-- <th>Updated_at</th> -->
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr
                                v-for="(releveur, i) in releveurs"
                                :key="i"
                                v-if="releveurs.length"
                            >
                                <td>{{ releveur.id }}</td>
                                <td class="_table_name">
                                    {{ releveur.serialNumber }}
                                </td>
                                <td class="table_image">
                                    <img
                                        :src="`/uploads/${releveur.iconImage}`"
                                    />
                                </td>
                                <!-- <td>{{ releveur.iconImage }}</td> -->
                                <td
                                    class="_table_name"
                                    style="width: 130px !important"
                                >
                                    {{ releveur.fullName }}
                                </td>
                                <td>{{ releveur.birthday }}</td>
                                <td class="_table_name">
                                    {{ releveur.email }}
                                </td>
                                <td class="shrink_110_px">
                                    {{
                                        releveur.created_at
                                            .slice(0, 19)
                                            .replace("T", " ")
                                    }}
                                </td>
                                <!-- <td class="shrink_110_px">
                                    {{
                                        releveur.updated_at
                                            .slice(0, 19)
                                            .replace("T", " ")
                                    }}
                                </td> -->
                                <td>
                                    <!-- <Button type="info" size="small"
                                        >Info</Button
                                    > -->
                                    <!-- <Button type="error" size="small"
                                        >Error</Button
                                    > -->
                                    <button
                                        class="_btn _action_btn edit_btn1"
                                        type="button"
                                        @click="showEditingModal(releveur, i)"
                                        v-if="isUpdatePermitted"
                                    >
                                        Modifier
                                    </button>
                                    <button
                                        class="_btn _action_btn make_btn1"
                                        type="button"
                                        @click="showDeletingModal(releveur, i)"
                                        :loading="releveur.isDeleting"
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

                <!--~~~~~~~ RELEVEUR ADDING MODEL~~~~~~~~~-->

                <Modal
                    :closable="false"
                    v-model="addModal"
                    title="Ajouter Releveur"
                    :mask-closable="false"
                >
                    <Input
                        v-model="data.serialNumber"
                        placeholder="Numéro de série (RXXY)...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="data.fullName"
                        placeholder="Nom complet...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        type="date"
                        v-model="data.birthday"
                        placeholder="Date de naissance...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="data.email"
                        placeholder="Email...."
                        style="margin-bottom: 5px !important"
                    />
                    <Upload
                        ref="uploads"
                        style="margin-top: 10px"
                        type="drag"
                        :headers="{
                            'x-csrf-token': token,
                            'X-Requested-With': 'XMLHttpRequest',
                        }"
                        :format="['jpg', 'jpeg', 'png']"
                        :default-file-list="defaultList"
                        :on-success="handleSuccess"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        action="/app/upload"
                    >
                        <div style="padding: 20px 0">
                            <Icon
                                type="ios-cloud-upload"
                                size="52"
                                style="color: #3399ff"
                            ></Icon>
                            <p>Cliquez ici ou glisser l'image dans le cadrons</p>
                        </div>
                    </Upload>
                    <div class="demo-upload-list" v-if="data.iconImage">
                        <img :src="`/uploads/${data.iconImage}`" />
                        <div class="demo-upload-list-cover">
                            <Icon
                                type="ios-trash-outline"
                                @click="deleteImage"
                            ></Icon>
                        </div>
                    </div>

                    <template #footer>
                        <Button type="default" @click="closeModals"
                            >Fermer</Button
                        >
                        <Button
                            type="primary"
                            @click="addReleveur"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{
                                isAdding ? "Ajout..." : "Ajouter releveur"
                            }}</Button
                        >
                    </template>
                </Modal>
                <!--~~~~~~~ RELEVEUR EDITING MODEL~~~~~~~~~-->

                <Modal
                    :closable="false"
                    v-model="editModal"
                    title="Modifier Releveur"
                    :mask-closable="false"
                >
                    <Input
                        v-model="editData.serialNumber"
                        placeholder="Numéro de série (RXXY)...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="editData.fullName"
                        placeholder="Nom complet...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        type="date"
                        v-model="editData.birthday"
                        placeholder="Date de naissance...."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="editData.email"
                        placeholder="Email...."
                        style="margin-bottom: 5px !important"
                    />
                    <Upload
                        v-show="isIconImageNew"
                        ref="editDataUploads"
                        style="margin-top: 10px"
                        type="drag"
                        :headers="{
                            'x-csrf-token': token,
                            'X-Requested-With': 'XMLHttpRequest',
                        }"
                        :format="['jpg', 'jpeg', 'png']"
                        :default-file-list="defaultList"
                        :on-success="handleSuccess"
                        :max-size="2048"
                        :on-format-error="handleFormatError"
                        :on-exceeded-size="handleMaxSize"
                        action="/app/upload"
                    >
                        <div style="padding: 20px 0">
                            <Icon
                                type="ios-cloud-upload"
                                size="52"
                                style="color: #3399ff"
                            ></Icon>
                            <p>Cliquez ici ou glisser l'image dans le cadrons</p>
                        </div>
                    </Upload>
                    <div class="demo-upload-list" v-if="editData.iconImage">
                        <img :src="`/uploads/${editData.iconImage}`" />
                        <div class="demo-upload-list-cover">
                            <Icon
                                type="ios-trash-outline"
                                @click="deleteImage(false)"
                            ></Icon>
                        </div>
                    </div>

                    <template #footer>
                        <Button type="default" @click="closeEditModal"
                            >Fermer</Button
                        >
                        <Button
                            type="primary"
                            @click="editReleveur"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{
                                isAdding ? "Edit..." : "Modifier releveur"
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
                    @on-change="getReleveurData"
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
                serialNumber: "",
                iconImage: "",
                fullName: "",
                birthday: "",
                email: "",
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            releveurs: [],
            editData: {
                serialNumber: "",
                iconImage: "",
                fullName: "",
                birthday: "",
                email: "",
            },
            index: -1,
            token: "",
            isIconImageNew: false,
            isEditingItem: false,
            releveursCount: 0,
            planningsCount: 0,
            countUsers: 0,
            countAdmins: 0,
            total: 3,
            pageInfo: null,
        };
    },
    methods: {
        closeModals() {
            this.addModal = false;
            this.editModal = false;
            this.data.serialNumber = "";
            this.data.iconImage = "";
            this.data.fullName = "";
            this.data.birthday = "";
            this.data.email = "";
        },
        async getReleveurData(page = 1) {
            const res = await this.callApi(
                "get",
                `/app/get_releveur?page=${page}&total=${this.total}`
            );
            if (res.status == 200) {
                this.releveurs = res.data.data;
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
        async addReleveur() {
            if (
                this.data.serialNumber.trim() == "" &&
                this.data.fullName.trim() == "" &&
                this.data.birthday.trim() == "" &&
                this.data.email.trim() == "" &&
                this.data.iconImage.trim() == ""
            ) {
                this.e("Tous les champs doivent etre remplis");
                return;
            }
            const res = await this.callApi(
                "post",
                "app/create_releveur",
                this.data
            );
            if (res.status == 201) {
                this.fetchData();
                this.releveurs.unshift(res.data);
                this.s("La création a été effectuée avec succès");
                this.getReleveurData();
                this.addModal = false;
                this.data.serialNumber = "";
                this.data.iconImage = "";
                this.data.fullName = "";
                this.data.birthday = "";
                this.data.email = "";
            } else {
                if (res.status == 422) {
                    let missingFields = [];

                    if (res.data.errors.serialNumber) {
                        missingFields.push(res.data.errors.serialNumber[0]);
                    }

                    if (res.data.errors.fullName) {
                        missingFields.push(res.data.errors.fullName[0]);
                    }

                    if (res.data.errors.birthday) {
                        missingFields.push(res.data.errors.birthday[0]);
                    }

                    if (res.data.errors.email) {
                        missingFields.push(res.data.errors.email[0]);
                    }
                    if (res.data.errors.iconImage) {
                        missingFields.push(res.data.errors.iconImage[0]);
                    }

                    if (missingFields.length > 0) {
                        let message = missingFields.join(" & ");
                        this.e(message);
                    }
                } else {
                    this.swr();
                }
            }
        },
        async editReleveur() {
            if (
                this.editData.serialNumber.trim() == "" &&
                this.editData.fullName.trim() == "" &&
                this.editData.birthday.trim() == "" &&
                this.editData.email.trim() == "" &&
                this.editData.iconImage.trim() == ""
            ) {
                this.e("Tous les champs sont requis");
                return;
            }
            const res = await this.callApi(
                "post",
                "app/edit_releveur",
                this.editData
            );
            if (res.status == 200) {
                this.fetchData();
                this.releveurs[this.index].serialNumber =
                    this.editData.serialNumber;
                this.releveurs[this.index].iconImage = this.editData.iconImage;
                this.releveurs[this.index].fullName = this.editData.fullName;
                this.releveurs[this.index].birthday = this.editData.birthday;
                this.releveurs[this.index].email = this.editData.email;
                this.s("La modification a été effectuée avec succcès");
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    let missingFields = [];

                    if (res.data.errors.serialNumber) {
                        missingFields.push(res.data.errors.serialNumber[0]);
                    }

                    if (res.data.errors.fullName) {
                        missingFields.push(res.data.errors.fullName[0]);
                    }

                    if (res.data.errors.birthday) {
                        missingFields.push(res.data.errors.birthday[0]);
                    }

                    if (res.data.errors.email) {
                        missingFields.push(res.data.errors.email[0]);
                    }
                    if (res.data.errors.iconImage) {
                        missingFields.push(res.data.errors.iconImage[0]);
                    }

                    if (missingFields.length > 0) {
                        let message = missingFields.join(" & ");
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
        showEditingModal(releveur, index) {
            let obj = {
                id: releveur.id,
                serialNumber: releveur.serialNumber,
                iconImage: releveur.iconImage,
                fullName: releveur.fullName,
                birthday: releveur.birthday,
                email: releveur.email,
            };
            this.editData = obj;
            this.editModal = true;
            this.index = index;
            this.isEditingItem = true;
        },
        showDeletingModal(releveur, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "/app/delete_releveur",
                data: releveur,
                deletingIndex: i,
                isDeleted: false,
            };
            this.$store.commit("setDeletingModalObj", deleteModalObj);
            console.log("delete method called");
            this.fetchData();
        },

        handleSuccess(res, file) {
            if (this.isEditingItem) {
                return (this.editData.iconImage = res);
            }
            this.data.iconImage = res;
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: "Le format du fichier est incorrect.",
                desc:
                    "Le format du fichier " + file.name + " est incorrect. Veuillez sélectionner un fichier au format JPEG, JPG ou PNG.",
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: "Limite de taille du fichier dépassée",
                desc: "Fichier " + file.name + " est trop volumineux, veuillez choisir un fichier de taille inférieure à 2 Mo.",
            });
        },
        async deleteImage(isAdd = true) {
            let image;
            if (!isAdd) {
                //for editing
                this.isIconImageNew = true;
                image = this.editData.iconImage;
                this.editData.iconImage = "";
                this.$refs.editDataUploads.clearFiles();
            } else {
                image = this.data.iconImage;
                this.data.iconImage = "";
                // console.log(this.$refs.uploads);
                this.$refs.uploads.clearFiles();
            }
            const res = await this.callApi("post", "/app/delete_image", {
                imageName: image,
            });
            if (res.status != 200) {
                this.data.iconImage = image;
                this.swr();
            }
            // this.swr();
        },
        closeEditModal() {
            this.isEditingItem = false;
            this.editModal = false;
        },
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        this.fetchData();
        this.getReleveurData();
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
                this.releveurs.splice(obj.deletingIndex, 1);
                this.fetchData();
                this.getReleveurData();
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
