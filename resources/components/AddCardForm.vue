<template>
    <form
      class="relative mb-3 flex flex-col justify-between bg-white rounded-md shadow overflow-hidden"
      @submit.prevent="handleAddNewTask"
    >
      <div class="p-3 flex-1">
        <input
          class="block w-full px-2 py-1 text-lg border-b border-blue-800 rounded"
          type="text"
          placeholder="Enter a title"
          v-model.trim="newTask.title"
        />
        <textarea
          class="mt-3 p-2 block w-full p-1 border text-sm rounded"
          rows="2"
          placeholder="Add a description (optional)"
          v-model.trim="newTask.description"
        ></textarea>
        <div v-show="errorMessage">
          <span class="text-xs text-red-500">
            {{ errorMessage }}
          </span>
        </div>
      </div>
      <div class="p-3 flex justify-between items-end text-sm bg-gray-100">
        <button
          @click="$emit('task-cancelled')"
          type="reset"
          class="py-1 leading-5 text-gray-600 hover:text-gray-700"
        >
          cancel
        </button>
        <button
          type="submit"
          class="px-3 py-1 leading-5 text-white bg-orange-600 hover:bg-orange-500 rounded"
        >
          Add
        </button>
      </div>
    </form>
  </template>
  
  <script>
import { exit } from 'process';

  export default {
    props: {
      columnId: Number
    },
    data() {
      return {
        newTask: {
          title: "",
          description: "",
          column_id: null
        },
        errorMessage:"",
        
      };
    },
    mounted() {
      this.newTask.column_id = this.columnId;
    },
    methods: {
      handleAddNewTask() {
        // Basic validation so we don't send an empty task to the server
        if (!this.newTask.title) {
          this.errorMessage = "The title field is required";
          return;
        }
  
        // Send new task to server
      

      //  alert(this.newTask.column_id);
        axios
          .post("api/cards", this.newTask)
          .then(res => {
            //console.log(res.data);
            
            ///alert(this.newTask.column_id);
                     // Tell the parent component we've added a new task and include it
            this.$emit("task-added",this.newTask);
          })
          .catch(err => {
            // Handle the error returned from our request
            this.handleErrors(err);
           // console.log(err);
          });
      },

      handleAddNewColumn() {
        // Basic validation so we don't send an empty task to the server
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
          .then(res => {
            //console.log(res.data);
            
            ///alert(this.newTask.column_id);
                     // Tell the parent component we've added a new task and include it
            this.$emit("column-added",this.newColumn);
          })
          .catch(err => {
            // Handle the error returned from our request
            this.handleErrors(err);
           // console.log(err);
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
          // We have bigger problems
          console.log(err.response);
        }
      }
    }
  };
  </script>