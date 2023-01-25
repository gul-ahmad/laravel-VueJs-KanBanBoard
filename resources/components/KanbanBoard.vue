<template>
    <div class="relative p-2 flex overflow-x-auto h-full">
        <modal name="add-new-column-model" height="340">
            <div class="relative w-full h-full md:h-auto">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                >
                    <button
                        type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="authentication-modal"
                        @click="closeColumnModal"
                    >
                        <svg
                            aria-hidden="true"
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3
                            class="mb-4 text-xl font-medium text-gray-900 dark:text-white"
                        >
                            Add New Column
                        </h3>
                        <form
                            class="space-y-6"
                            @submit.prevent="handleAddNewColumn"
                        >
                            <div>
                                <label
                                    for="title"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Title</label
                                >
                                <input
                                    type="text"
                                    v-model.trim="newColumn.title"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                />
                            </div>
                            <div>
                                <label
                                    for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Description</label
                                >
                                <textarea
                                    type="textarea"
                                    v-model="newColumn.description"
                                    rows="3"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                ></textarea>
                            </div>
                            <div v-show="errorMessage">
                                <span class="text-xs text-red-500">
                                    {{ errorMessage }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <button
                                            type="submit"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        >
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-end">
                                    <div class="flex items-center h-5">
                                        <button
                                            class="text-white bg-red-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            @click="closeColumnModal"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </modal>

        <!-- Columns () -->

        <div
            v-for="column in columns"
            :key="column.id"
            class="mr-6 w-4/5 max-w-xs flex-1 flex-shrink-0"
        >
            <div class="rounded-md shadow-md overflow-hidden">
                <div
                    class="p-3 flex justify-between items-baseline bg-blue-800"
                >
                    <h4 class="font-medium text-white">
                        {{ column.title }}
                    </h4>
                    <button
                        class="py-1 px-2 text-sm text-orange-500 hover:underline"
                        @click="openAddCardForm(column.id)"
                    >
                        Add Card
                    </button>
                    <button
                        class="py-1 px-2 text-sm text-orange-500 hover:underline"
                        @click="deleteCard(column.id)"
                    >
                        Delete Column
                    </button>
                </div>
                <div
                    class="p-2 flex-1 flex flex-col h-full overflow-x-hidden overflow-y-auto bg-blue-100"
                >
                    <AddCardForm
                        v-if="newCardForColumn === column.id"
                        :column-id="column.id"
                        v-on:Card-added="handleCardAdded"
                        v-on:Card-cancelled="closeAddCardForm"
                    />
                    <!-- cards -->
                    <draggable
                        class="flex-1 overflow-hidden"
                        v-model="column.cards"
                        v-bind="CardDragOptions"
                        @end="handleCardMoved"
                    >
                        <transition-group
                            name="fade"
                            class="flex-1 flex flex-col h-full overflow-x-hidden overflow-y-auto rounded shadow-xs"
                            tag="div"
                        >
                            <div
                                v-for="card in column.cards"
                                :key="card.id"
                                v-on:click="editCardDetails(card, column.id)"
                                class="mb-3 p-3 h-24 flex flex-col bg-white rounded-md shadow transform hover:shadow-md cursor-pointer"
                            >
                                <span class="block mb-2 text-xl text-gray-900">
                                    {{ card.title }}
                                </span>
                                <p class="text-gray-700 truncate">
                                    {{ card.description }}
                                </p>
                            </div>
                        </transition-group>
                    </draggable>
                    <!-- ./cards -->
                    <!-- No card -->
                    <div
                        v-show="
                            !column.cards.length &&
                            newCardForColumn !== column.id
                        "
                        class="flex-1 p-4 flex flex-col items-center justify-center"
                    >
                        <span class="text-gray-600">No cards yet</span>
                        <button
                            class="mt-1 text-sm text-orange-600 hover:underline"
                            @click="openAddCardForm(column.id)"
                        >
                            Add one
                        </button>
                    </div>
                    <!-- ./No card -->
                </div>
            </div>
        </div>
        <modal name="edit-card-model" height="340">
            <div class="relative w-full h-full md:h-auto">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                >
                    <button
                        type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-hide="authentication-modal"
                        @click="closeCardEditModel"
                    >
                        <svg
                            aria-hidden="true"
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3
                            class="mb-4 text-xl font-medium text-gray-900 dark:text-white"
                        >
                            Edit Card {{ card.id }}
                        </h3>
                        <form
                            class="space-y-6"
                            @submit.prevent="
                                updateColumnDetails(card, editColumnId)
                            "
                        >
                            <div>
                                <label
                                    for="title"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Title</label
                                >
                                <input
                                    type="text"
                                    v-model.trim="card.title"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                />
                            </div>
                            <div>
                                <label
                                    for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Description</label
                                >
                                <textarea
                                    type="textarea"
                                    v-model="card.description"
                                    rows="3"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                ></textarea>
                            </div>
                            <div v-show="errorMessage">
                                <span class="text-xs text-red-500">
                                    {{ errorMessage }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <button
                                            type="submit"
                                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                        >
                                            Save
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-end">
                                    <div class="flex items-center h-5">
                                        <button
                                            class="text-white bg-red-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            @click="closeCardEditModel"
                                            type="button"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </modal>

        <div class="mr-6 w-4/5 max-w-xs flex-1 flex-shrink-0">
            <!-- <AddNewColumn/> -->

            <button
                class="py-1 px-2 text-sm text-orange-500 hover:underline bg-blue-800 rounded-md"
                @click="showColumnModal"
            >
                Add Columns
            </button>
        </div>
        <!-- ./Columns -->
    </div>
</template>

<script>
import draggable from "vuedraggable";
import AddCardForm from "./AddCardForm";
// import AddNewColumn from './AddNewColumn';

export default {
    components: { draggable, AddCardForm },

    props: {
        //initialData: Array
    },
    data() {
        return {
            columns: [],
            newCardForColumn: 0,
            errorMessage: "",
            newColumn: {
                title: "",
                description: "",
            },
            //for updating card we are getting columnId using this
            editColumnId: "",
            //for updating card we are getting card Details using below
            card: {
                id: "",
                title: "",
                description: "",
            },
        };
    },
    methods: {
        getData() {
            axios.get("api/columns").then((response) => {
                this.columns = response.data.data;
                
            });
        },
        openAddCardForm(columnId) {
           
            this.newCardForColumn = columnId;
        },
        // reset the statusId and close form
        closeAddCardForm() {
            this.newCardForColumn = 0;
        },
        handleCardAdded(newCard) {
           

            // Find the index of the status where we should add the card
            const statusIndex = this.columns.findIndex(
                (column) => column.id === newCard.column_id
            );

          

            // Add newly created Card to our column
            this.columns[statusIndex].cards.push(newCard);
            this.getData();

            // Reset and close the AddCardForm
            this.closeAddCardForm();
        },
        deleteCard(column_id) {
            if (confirm("Are you sure?")) {
                axios
                    .post("api/columns/" + column_id, { _method: "delete" })
                    .then((res) => {
                        //console.log(res.data);

                        this.getData();

                       
                        // Tell the parent component we've added a new Card and include it
                        // this.$emit("Card-added",this.newCard);
                    })
                    .catch((err) => {
                        // Handle the error returned from our request
                        this.handleErrors(err);
                        // console.log(err);
                    });
            }
        },
        showColumnModal() {
            this.$modal.show("add-new-column-model");
        },
        closeColumnModal() {
            this.newColumn.title = "";
            this.newColumn.description = "";
            this.$modal.hide("add-new-column-model");
        },
        handleAddNewColumn() {
            // Basic validation so we don't send an empty Card to the server
            if (!this.newColumn.title) {
                this.errorMessage = "The title field is required";
                return;
            }
            if (!this.newColumn.description) {
                this.errorMessage = "The description field is required";
                return;
            }

            axios
                .post("api/columns", this.newColumn)
                .then((res) => {
                   
                    this.getData();
                    this.closeColumnModal();
                })
                .catch((err) => {
                    // Handle the error returned from our request
                    this.handleErrors(err);
                   
                });
        },
        handleErrors(err) {
            if (err.response && err.response.status === 422) {
                // We have a validation error
                const errorBag = err.response.data.errors;
                if (errorBag.title) {
                    this.errorMessage = errorBag.title[0];
                } else if (errorBag.description) {
                    this.errorMessage = errorBag.description[0];
                } else {
                    this.errorMessage = err.response.message;
                }
            } else {
               
                console.log(err.response);
            }
        },
        handleColumnAdded(newColumn) {
            // Add newly created Card to our column
            this.columns.push(newColumn);
            // Reset and close the AddCardForm

            this.closeColumnModal();
        },
        editCardDetails(card, columnId) {
          
            this.card.title = card.title;
            this.card.description = card.description;
            this.card.id = card.id;
            this.editColumnId = columnId;
            this.$modal.show("edit-card-model");
        },
        closeCardEditModel() {
            this.$modal.hide("edit-card-model");
        },
        updateColumnDetails(card, editColumnId) {
            
            if (!this.card.title) {
                this.errorMessage = "The title field cannot be empty!";
                return;
            }

            axios
                .put("api/cards/" + this.card.id, {
                    title: this.card.title,
                    id: editColumnId,
                })
                .then((res) => {
                  

                    this.getData();
                    this.closeCardEditModel();

                  
                    // this.$emit("Card-added",this.newCard);
                })
                .catch((err) => {
                    // Handle the error returned from our request
                    this.handleErrors(err);
                    // console.log(err);
                });
        },
        handleCardMoved() {
          
            // Send the entire list of statuses to the server
           
            axios
                .put("api/cards/sync", { columns: this.columns })
                .catch((err) => {
                    console.log(err.response);
                });
        },
    },
    computed: {
        CardDragOptions() {
            return {
                animation: 200,
                group: "Card-list",
                dragClass: "status-drag",
            };
        },
    },
    created() {
        this.getData();
    },
};
</script>
<style scoped>
.status-drag {
    transition: transform 0.5s;
    transition-property: all;
}
</style>
