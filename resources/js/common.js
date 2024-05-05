// here we are going to do the mixing for our axios

import axios from "axios";
import { mapGetters } from "vuex";
import { isProxy, toRaw } from "vue";
export default {
    data() {
        return {};
    },
    methods: {
        async callApi(method, url, dataObj) {
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj,
                });
            } catch (e) {
                return e.response;
            }
        },

        i(desc, title = "Important!") {
            this.$Notice.info({
                title: title,
                desc: desc,
            });
        },
        s(desc, title = "Superbe!") {
            this.$Notice.success({
                title: title,
                desc: desc,
            });
        },
        w(desc, title = "Oops!") {
            this.$Notice.warning({
                title: title,
                desc: desc,
            });
        },
        e(desc, title = "Oops!") {
            this.$Notice.error({
                title: title,
                desc: desc,
            });
        },
        swr(
            desc = "Une erreur s'est produite ! Veuillez réessayer.",
            title = "Oops"
        ) {
            this.$Notice.error({
                title: title,
                desc: desc,
            });
        },
        checkUserPermission(key) {
            let rawData;
            let isPermitted = false;
            if (!this.userPermission) return true;
            if (isProxy(this.userPermission)) {
                rawData = toRaw(this.userPermission);
            }
            for (let d of rawData) {
                // console.log(d.name);
                // console.log(d[key]);
                if (this.$route.fullPath.substring(1) == d.name) {
                    if (d[key]) {
                        isPermitted = true;
                        break;
                    } else {
                        break;
                    }
                }
            }
            return isPermitted;
        },
    },
    computed: {
        ...mapGetters({
            userPermission: "getUserPermission",
        }),
        isReadPermitted() {
            return this.checkUserPermission("read");
        },
        isWritePermitted() {
            return this.checkUserPermission("write");
        },
        isUpdatePermitted() {
            return this.checkUserPermission("update");
        },
        isDeletePermitted() {
            return this.checkUserPermission("delete");
        },
    },
};
