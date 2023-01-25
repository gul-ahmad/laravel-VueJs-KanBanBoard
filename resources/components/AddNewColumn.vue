<template>
    <modal name="add-new-column-model">
        <form
            class="relative mb-3 flex flex-col justify-between bg-white rounded-md shadow overflow-hidden"
        >
            <div class="p-3 flex-1">
                <input
                    class="block w-full px-2 py-1 text-lg border-b border-blue-800 rounded"
                    type="text"
                    placeholder="Enter a title"
                />
                <textarea
                    class="mt-3 p-2 block w-full p-1 border text-sm rounded"
                    rows="2"
                    placeholder="Add a description (optional)"
                ></textarea>
                <!-- <div v-show="errorMessage">
          <span class="text-xs text-red-500">
            {{ errorMessage }}
          </span>
        </div> -->
            </div>
            <div class="p-3 flex justify-between items-end text-sm bg-gray-100">
                <button
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
    </modal>
</template>

<script>
export default {
    name: "AddNewColumn",

    mount() {
        this.show();
    },
};
</script>
