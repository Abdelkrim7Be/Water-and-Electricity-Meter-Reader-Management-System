import "./bootstrap";
import "../css/grid.min.css";
import "../css/main.css";
import { createApp } from "vue";
import app from "./components/app.vue";
import router from "./router.js";
import store from "./store.js";
// import ViewUI from "view-design";
import {
    Button, Checkbox, Icon, Input, Modal, Notice, Option, Page,
    Poptip, Select, Upload,
} from "view-ui-plus";
import "view-ui-plus/dist/styles/viewuiplus.css";
import common from "./common";

const vueApp = createApp(app);
const components = { Button, Checkbox, Icon, Input, Modal, Option, Page, Poptip, Select, Upload };
Object.entries(components).forEach(([name, component]) => vueApp.component(name, component));
vueApp.config.globalProperties.$Notice = Notice;
vueApp.use(router).use(store).mixin(common);
vueApp.component("app", app);
vueApp.mount("#app");
