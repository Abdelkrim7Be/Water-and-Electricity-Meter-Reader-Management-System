require("./bootstrap");
import { createApp } from "vue";
import app from "./components/app.vue";
import router from "./router.js";
import store from "./store.js";
// import ViewUI from "view-design";
import ViewUIPlus from "view-ui-plus";
// import "view-design/dist/styles/iview.css";
import "view-ui-plus/dist/styles/viewuiplus.css";
import common from "./common";

const vueApp = createApp(app);
vueApp.use(router).use(store).use(ViewUIPlus).mixin(common);
vueApp.component("app", app);
vueApp.mount("#app");
