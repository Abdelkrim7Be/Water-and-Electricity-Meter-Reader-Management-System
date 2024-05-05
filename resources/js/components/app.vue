<template>
    <div>
        <div v-if="$store.state.user">
            <!--========== ADMIN SIDE MENU one ========-->
            <div class="_1side_menu">
                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_img_name">
                    <div class="logo-container">
                        <img src="./imgs/logo.jpg" />
                    </div>
                    <div class="poplit">
                        <Poptip v-model="visible">
                            <a>{{ Admin.fullName }}</a>
                            <template #title>
                                <div>
                                    <i
                                        ><Icon type="md-person" />
                                        {{ Admin.userType }}</i
                                    >
                                </div>
                            </template>
                            <template #content>
                                <a @click="close">Fermer</a>
                            </template>
                        </Poptip>
                    </div>
                </div>
                <div class="_1side_menu_content">
                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
                            <!-- <li
                                v-for="(menuItem, i) in rawPermissions"
                                :key="i"
                                v-if="rawPermissions && menuItem && menuItem.read"
                                >
                                <router-link :to="'/' + menuItem.name">
                                    <Icon type="ios-speedometer" />
                                    {{ menuItem.ressourceName }}
                                </router-link>
                            </li> -->

                            <li
                                v-if="
                                    rawPermissions &&
                                    rawPermissions[0] &&
                                    rawPermissions[0].read
                                "
                            >
                                <router-link to="/releves"
                                    ><Icon type="ios-speedometer" /> Plan de
                                    relève</router-link
                                >
                            </li>

                            <li
                                v-if="
                                    rawPermissions &&
                                    rawPermissions[1] &&
                                    rawPermissions[1].read
                                "
                            >
                                <router-link to="/releveurs"
                                    ><Icon
                                        type="ios-speedometer"
                                    />Releveurs</router-link
                                >
                            </li>
                            <li
                                v-if="
                                    rawPermissions &&
                                    rawPermissions[2] &&
                                    rawPermissions[2].read
                                "
                            >
                                <router-link to="/adminusers"
                                    ><Icon
                                        type="ios-speedometer"
                                    />Admins/Users</router-link
                                >
                            </li>
                            <li
                                v-if="
                                    rawPermissions &&
                                    rawPermissions[3] &&
                                    rawPermissions[3].read
                                "
                            >
                                <router-link to="/roles"
                                    ><Icon type="ios-speedometer" />Management
                                    des roles</router-link
                                >
                            </li>
                            <li
                                v-if="
                                    rawPermissions &&
                                    rawPermissions[4] &&
                                    rawPermissions[4].read
                                "
                            >
                                <router-link to="/assignRole"
                                    ><Icon type="ios-speedometer" />Permissions
                                    des roles</router-link
                                >
                            </li>
                            <li
                                v-if="
                                    rawPermissions &&
                                    rawPermissions[5] &&
                                    rawPermissions[5].read
                                "
                            >
                                <router-link to="/historique"
                                    ><Icon
                                        type="ios-speedometer"
                                    />Historique</router-link
                                >
                            </li>
                            <li>
                                <a href="/logout"
                                    ><Icon
                                        type="ios-speedometer"
                                    />Déconnecter</a
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="right-button" style="float: right"></div>
                </div>
            </div>
            <!--========= HEADER ==========-->
        </div>
        <router-view />
    </div>
</template>

<script>
import { CellGroup } from "view-ui-plus";
import { isProxy, toRaw } from "vue";

export default {
    data() {
        return {
            authUser: window.authUser,
            isLoggedIn: false,
            Admin: "",
            visible: false,
            menuItem: null,
        };
    },

    methods: {
        close() {
            this.visible = false;
        },
    },

    computed: {
        rawPermissions() {
            if (!window.permissions) {
                return []; // or any other default value that makes sense for your application
            }
            return toRaw(JSON.parse(window.permissions));
        },
    },

    created() {
        let rawData;
        if (isProxy(this.authUser)) {
            rawData = toRaw(authUser);
            this.Admin = window.authUser;
        }
        this.$store.commit("setUpdateUser", rawData);
        this.$store.commit("setUserPermission", this.rawPermissions);
    },
};
</script>

<style scoped>
html,
body {
    height: 100%;
    margin: 0;
    padding: 0;
}
#app {
    height: 100% !important;
    margin: 0;
    overflow: hidden !important;
}
._1side_menu_name {
    font-family: "Raleway", sans-serif;
    font-size: 48px;
    font-weight: bold;
    text-transform: uppercase;
    text-align: center;
    color: #33475c;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
    letter-spacing: 2px;
    line-height: 1.2;
    margin: 0;
    padding: 20px 0;
}

._1side_menu_img_name {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.logo-container {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background-color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}

.logo-container img {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Ajoutez une ombre si souhaité */
}

.poplit {
    margin-top: 10px;
}
</style>
