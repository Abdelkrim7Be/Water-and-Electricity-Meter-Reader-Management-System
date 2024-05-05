<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="row"  v-if="isWritePermitted">
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
                        Historisation de la relève
                        <Button @click="clearHistorique" v-if="isDeletePermitted">
                            <Icon type="ios-trash" /> Vider historique
                        </Button>
                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>ID</th>
                                <th>Relève</th>
                                <th>Acteur</th>
                                <th>Type d'acteur</th>
                                <th>action</th>
                                <th>colonnes affectées</th>
                                <th>Horodatage</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr
                                v-for="(historique, i) in historiques"
                                :key="i"
                                v-if="historiques.length"
                            >
                                <td>{{ historique.id }}</td>
                                    <td>{{ historique.releve_plan_id }}</td>
                                <td class="_table_name">
                                    {{ historique.acteur }}
                                </td>
                                <td>
                                    {{ historique.acteur_type }}
                                </td>
                                <td class="_table_name">{{ historique.action_type }}</td>
                                <td class="shrink_110_px _table_name">{{ historique.updated_fields }}</td>
                                <td class="shrink_110_px">
                                    {{
                                        historique.created_at
                                            .slice(0, 19)
                                            .replace("T", " ")
                                    }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <Page
                    :total="pageInfo.total"
                    :current="pageInfo.current_page"
                    :page-size="parseInt(pageInfo.per_page)"
                    @on-change="getHistoriqueData"
                    v-if="pageInfo"
                />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            historiques: [],
            token: "",
            releveursCount: 0,
            planningsCount: 0,
            countUsers: 0,
            countAdmins: 0,
            total: 5,
            pageInfo: null,
        };
        
    },
    methods: {
        async getHistoriqueData(page = 1) {
            const res = await this.callApi(
                "get",
                `/app/get_historique?page=${page}&total=${this.total}`
            );
            if (res.status == 200) {
                this.historiques = res.data.data;
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
        async clearHistorique() {
            const res = await this.callApi("delete", "/app/clear_historique");
            if (res.status == 200) {
                this.historiques = [];
                // Uncomment the following line if you want to reset the total count as well
                // this.totalCount = 0;
            } else {
                this.swr();
            }
        },
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        this.fetchData();
        this.getHistoriqueData();
    },

    async updated() {
        this.getHistoriqueData();
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