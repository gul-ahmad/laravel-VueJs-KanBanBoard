require("./bootstrap");

window.Vue = require('vue').default;

import VModal from 'vue-js-modal';


Vue.use(VModal, {
  dynamicDefaults: {
    draggable: true,
    // resizable: true,
    // height: 'auto'
  }
});
 Vue.component('kanban-board', require('../components/KanbanBoard.vue').default);

 const app = new Vue({

   el: '#app',

 });
