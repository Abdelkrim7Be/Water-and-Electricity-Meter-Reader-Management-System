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
                        Plan de relève de {{ currentMonth }}
                        <Button @click="addModal = true" v-if="isWritePermitted"
                            ><Icon type="ios-add" /> Ajouter Plan</Button
                        >
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>releveur</th>
                                <!-- <th>prd</th> -->
                                <th>acteur</th>
                                <th>version</th>
                                <th>date_releve</th>
                                <th>tournee_debut</th>
                                <th>tournee_fin</th>
                                <th style="min-width: 130px">Ordre lecture</th>
                                <th>Compteurs</th>
                                <th>Durée</th>
                                <th>Crée le</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr
                                v-for="(plan, i) in plans"
                                :key="i"
                                v-if="plans.length"
                                :class="{ 'passed-row': isPlanPassed(plan) }"
                            >
                                <td>{{ plan.id }}</td>
                                <td>{{ plan.releveur }}</td>
                                <!-- <td>{{ plan.periode }}</td> -->
                                <td>{{ plan.acteur }}</td>
                                <td>{{ plan.version }}</td>
                                <td>{{ plan.date_releve }}</td>
                                <td>{{ plan.num_tournee_debut }}</td>
                                <td style="min-width: 130px !important">
                                    {{ plan.num_tournee_fin }}
                                </td>
                                <td>{{ plan.ordre_lecture }}</td>
                                <td>{{ plan.nombre_total }}</td>
                                <td>{{ plan.temps_execution_jours }}</td>
                                <td class="shrink_110_px">
                                    {{
                                        plan.created_at
                                            .slice(0, 19)
                                            .replace("T", " ")
                                    }}
                                </td>
                                <td>
                                    <button
                                        class="_btn _action_btn edit_btn1"
                                        :class="{
                                            'passed-btn': isPlanPassed(plan),
                                        }"
                                        type="button"
                                        @click="showEditingModal(plan, i)"
                                        :disabled="isPlanPassed(plan)"
                                        v-if="isUpdatePermitted"
                                    >
                                        Modifier
                                    </button>
                                    <button
                                        class="_btn _action_btn make_btn1"
                                        type="button"
                                        @click="showDeletingModal(plan, i)"
                                        :loading="plan.isDeleting"
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
                    title="Ajouter Plan"
                    :mask-closable="false"
                >
                    <Select
                        v-model="data.releveur"
                        style="width: 200px; margin-bottom: 5px !important"
                        placeholder="Releveur..."
                    >
                        <Option
                            v-for="option in options"
                            :key="option.id"
                            :value="option.serialNumber"
                        >
                            {{ option.fullName }}
                        </Option>
                    </Select>
                    <Input
                        type="date"
                        v-model="data.date_releve"
                        placeholder="date_releve..."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="data.num_tournee_debut"
                        placeholder="numéro tournée début (XXX YYY ZZZ)..."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="data.num_tournee_fin"
                        placeholder="numéro tournée fin (XXX YYY ZZZ)..."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="data.ordre_lecture"
                        placeholder="ordre lecture (X Y Z ...)..."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="data.temps_execution_jours"
                        placeholder="temps d'execution en jours..."
                        style="margin-bottom: 5px !important"
                    />

                    <template #footer>
                        <Button type="default" @click="closeModals"
                            >Fermer</Button
                        >
                        <Button
                            type="primary"
                            @click="addPlan"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{
                                isAdding ? "Ajout..." : "Ajouter Plan"
                            }}</Button
                        >
                    </template>
                </Modal>
                <!--~~~~~~~ RELEVEUR EDITING MODEL~~~~~~~~~-->

                <Modal
                    :closable="false"
                    v-model="editModal"
                    title="Modifier Plan"
                    :mask-closable="false"
                >
                    <Select
                        v-model="editData.releveur"
                        style="width: 200px; margin-bottom: 5px !important"
                        placeholder="Releveur..."
                    >
                        <Option
                            v-for="option in options"
                            :key="option.id"
                            :value="option.serialNumber"
                        >
                            {{ option.fullName }}
                        </Option>
                    </Select>
                    <Input
                        type="date"
                        v-model="editData.date_releve"
                        placeholder="date_releve..."
                        style="margin-bottom: 5px !important"
                        :disabled="isEnCoursDisabled"
                    />
                    <Input
                        v-model="editData.num_tournee_debut"
                        placeholder="numéro tournée début (XXX YYY ZZZ)..."
                        style="margin-bottom: 5px !important"
                        :disabled="isEnCoursDisabled"
                    />
                    <Input
                        v-model="editData.num_tournee_fin"
                        placeholder="numéro tournée fin (XXX YYY ZZZ)..."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="editData.ordre_lecture"
                        placeholder="ordre lecture (X Y Z ...)..."
                        style="margin-bottom: 5px !important"
                    />
                    <Input
                        v-model="editData.temps_execution_jours"
                        placeholder="temps d'execution en jours..."
                        style="margin-bottom: 5px !important"
                    />

                    <template #footer>
                        <Button type="default" @click="closeEditModal"
                            >Fermer</Button
                        >
                        <Button
                            type="primary"
                            @click="editPlan"
                            :disabled="isAdding"
                            :loading="isAdding"
                            >{{
                                isAdding ? "Edit..." : "Modifier Plan"
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
                    @on-change="getPlanData"
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
                releveur: "",
                date_releve: "",
                num_tournee_debut: "",
                num_tournee_fin: "",
                ordre_lecture: "",
                temps_execution_jours: "",
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            plans: [],
            options: [],
            editData: {
                releveur: "",
                date_releve: "",
                num_tournee_debut: "",
                num_tournee_fin: "",
                ordre_lecture: "",
                temps_execution_jours: "",
            },
            index: -1,
            token: "",
            isEditingItem: false,
            releveursCount: 0,
            planningsCount: 0,
            countUsers: 0,
            countAdmins: 0,
            total: 3,
            pageInfo: null,
            currentMonth: "",
            isEnCoursDisabled: false,
        };
    },
    methods: {
        closeModals() {
            this.addModal = false;
            this.editModal = false;
            this.data.releveur = "";
            this.data.date_releve = "";
            this.data.num_tournee_debut = "";
            this.data.num_tournee_fin = "";
            this.data.ordre_lecture = "";
            this.data.temps_execution_jours = "";
        },
        async getPlanData(page = 1) {
            const res = await this.callApi(
                "get",
                `/app/get_plan?page=${page}&total=${this.total}`
            );
            const res2 = await this.callApi("get", "/app/get_releveur");
            if (res.status == 200 && res2.status == 200) {
                this.plans = res.data.data;
                this.options = res2.data.data;
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

        async addPlan() {
            if (
                this.data.releveur.trim() == "" &&
                this.data.date_releve.trim() == "" &&
                this.data.num_tournee_debut.trim() == "" &&
                this.data.num_tournee_fin.trim() == "" &&
                this.data.ordre_lecture.trim() == "" &&
                this.data.temps_execution_jours.trim() == ""
            ) {
                this.e("Tous les champs doivent etre remplis");
                return;
            }
            const res = await this.callApi(
                "post",
                "app/create_plan",
                this.data
            );
            if (res.status == 201) {
                this.fetchData();
                this.plans.unshift(res.data);
                this.s("La création a été effectuée avec succès");
                this.getPlanData();
                this.addModal = false;
                this.data.releveur = "";
                this.data.date_releve = "";
                this.data.num_tournee_debut = "";
                this.data.num_tournee_fin = "";
                this.data.ordre_lecture = "";
                this.data.temps_execution_jours = "";
            } else {
                if (res.status == 422) {
                    let missingFields = [];

                    if (res.data.errors.releveur) {
                        missingFields.push(res.data.errors.releveur[0]);
                    }

                    if (res.data.errors.periode) {
                        missingFields.push(res.data.errors.periode[0]);
                    }

                    if (res.data.errors.acteur) {
                        missingFields.push(res.data.errors.acteur[0]);
                    }

                    if (res.data.errors.version) {
                        missingFields.push(res.data.errors.version[0]);
                    }
                    if (res.data.errors.date_releve) {
                        missingFields.push(res.data.errors.date_releve[0]);
                    }
                    if (res.data.errors.num_tournee_debut) {
                        missingFields.push(
                            res.data.errors.num_tournee_debut[0]
                        );
                    }
                    if (res.data.errors.num_tournee_fin) {
                        missingFields.push(res.data.errors.num_tournee_fin[0]);
                    }
                    if (res.data.errors.ordre_lecture) {
                        missingFields.push(res.data.errors.ordre_lecture[0]);
                    }
                    if (res.data.errors.nombre_total) {
                        missingFields.push(res.data.errors.nombre_total[0]);
                    }
                    if (res.data.errors.compteurs) {
                        missingFields.push(res.data.errors.compteurs[0]);
                    }
                    if (res.data.errors.temps_execution_jours) {
                        missingFields.push(
                            res.data.errors.temps_execution_jours[0]
                        );
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
        async editPlan() {
            if (
                this.editData.releveur.trim() == "" &&
                this.editData.date_releve.trim() == "" &&
                this.editData.num_tournee_debut.trim() == "" &&
                this.editData.num_tournee_fin.trim() == "" &&
                this.editData.ordre_lecture.trim() == "" &&
                this.editData.temps_execution_jours.trim() == ""
            ) {
                this.e("Tous les champs doivent etre remplis");
                return;
            }
            const res = await this.callApi(
                "post",
                "app/edit_plan",
                this.editData
            );
            if (res.status == 200) {
                this.fetchData();
                this.editData.version = this.editData.version + 1;
                this.plans[this.index].releveur = this.editData.releveur;
                this.plans[this.index].version = this.editData.version;
                this.plans[this.index].date_releve = this.editData.date_releve;
                this.plans[this.index].date_releve = this.editData.date_releve;
                this.plans[this.index].num_tournee_debut =
                    this.editData.num_tournee_debut;
                this.plans[this.index].num_tournee_fin =
                    this.editData.num_tournee_fin;
                this.plans[this.index].ordre_lecture =
                    this.editData.ordre_lecture;
                this.plans[this.index].nombre_total =
                    this.editData.ordre_lecture.split(" ").length * 112;
                this.plans[this.index].temps_execution_jours =
                    this.editData.temps_execution_jours;
                this.s("La modification a été effectuée avec succès");
                this.editModal = false;
            } else {
                if (res.status == 422) {
                    let missingFields = [];

                    if (res.data.errors.releveur) {
                        missingFields.push(res.data.errors.releveur[0]);
                    }

                    if (res.data.errors.periode) {
                        missingFields.push(res.data.errors.periode[0]);
                    }

                    if (res.data.errors.acteur) {
                        missingFields.push(res.data.errors.acteur[0]);
                    }

                    if (res.data.errors.version) {
                        missingFields.push(res.data.errors.version[0]);
                    }
                    if (res.data.errors.date_releve) {
                        missingFields.push(res.data.errors.date_releve[0]);
                    }
                    if (res.data.errors.num_tournee_debut) {
                        missingFields.push(
                            res.data.errors.num_tournee_debut[0]
                        );
                    }
                    if (res.data.errors.num_tournee_fin) {
                        missingFields.push(res.data.errors.num_tournee_fin[0]);
                    }
                    if (res.data.errors.ordre_lecture) {
                        missingFields.push(res.data.errors.ordre_lecture[0]);
                    }
                    if (res.data.errors.nombre_total) {
                        missingFields.push(res.data.errors.nombre_total[0]);
                    }
                    if (res.data.errors.compteurs) {
                        missingFields.push(res.data.errors.compteurs[0]);
                    }
                    if (res.data.errors.temps_execution_jours) {
                        missingFields.push(
                            res.data.errors.temps_execution_jours[0]
                        );
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
        showEditingModal(plan, index) {
            let obj = {
                id: plan.id,
                releveur: plan.releveur,
                version: plan.version,
                date_releve: plan.date_releve,
                num_tournee_debut: plan.num_tournee_debut,
                num_tournee_fin: plan.num_tournee_fin,
                ordre_lecture: plan.ordre_lecture,
                temps_execution_jours: plan.temps_execution_jours,
            };
            const currentDate = new Date();
            const startDate = new Date(obj.date_releve);
            const endDate = new Date(
                startDate.getTime() +
                    obj.temps_execution_jours * 24 * 60 * 60 * 1000
            );
            this.isEnCoursDisabled =
                startDate <= currentDate && endDate >= currentDate;

            this.editData = obj;
            this.editModal = true;
            this.index = index;
            this.isEditingItem = true;
        },
        showDeletingModal(plan, i) {
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: "/app/delete_plan",
                data: plan,
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

        isPlanPassed(plan) {
            const dateReleve = new Date(plan.date_releve);
            const datePlanPassed = new Date(
                dateReleve.getTime() +
                    plan.temps_execution_jours * 24 * 60 * 60 * 1000
            );
            return datePlanPassed < new Date();
        },
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        this.fetchData();
        this.getPlanData();
        const currentDate = new Date();
        const monthNames = [
            "Janvier",
            "Février",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Août",
            "Septembre",
            "Octobre",
            "Novembre",
            "Décembre",
        ];
        this.currentMonth = monthNames[currentDate.getMonth()];
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
                this.plans.splice(obj.deletingIndex, 1);
                this.fetchData();
                this.getPlanData();
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
.passed-row {
    background-color: rgb(235, 235, 228) !important; /* Red background color */
}
.passed-btn {
    background-color: rgba(134, 130, 130, 0.5) !important;
}
</style>
