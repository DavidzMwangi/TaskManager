<script setup lang="ts">

import AppLayout from "@/Layouts/AppLayout.vue";
import type {ListResponse, Task} from "@/Types/types";
import Pagination from "@/Components/Pagination.vue";
import Icon from "@/Components/Icon.vue";
import {Head, Link, useForm} from '@inertiajs/vue3'
import SearchFilter from "@/Components/SearchFilter.vue";
import {Switch} from '@headlessui/vue'
import {ref, watch} from 'vue'
import axios from "axios";

const enabled = ref(false)
let timeout = null; // For storing the timeout reference

const props = defineProps({
    tasks_prop: {
        type: Object as () => ListResponse<Task>,
        required: true
    }
})
const tasks = ref<ListResponse<Task>>(props.tasks_prop)
const statusVariant = (status: boolean) => {
    return status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
}
const form = useForm({
    status: false
});

const searchFilter = ref({
    search: null,
    filterStatus: null
})

const fetchData = () => {
     // Clear the previous timeout if the user is still typing
  if (timeout) {
    clearTimeout(timeout);
  }
  // Set a new timeout to trigger the API call or other logic
  timeout = setTimeout(() => {
      axios.get(route('tasks.search'), {
          params: {
              search: searchFilter.value.search,
              filterStatus: searchFilter.value.filterStatus
          }
      }).then(response => {
          console.log(response.data)
          tasks.value = response.data.tasks
      }).catch(error => {
          console.log(error)
      })
  }, 300); // 300ms delay before executing the logic

}
const updateStatus = (task: Task) => {
    form.status = !task.status
    form.put(route('tasks.update', task.id),{
        preserveScroll: true,
        onSuccess: (res) => {

        },
        onError: (err) => {
            console.log(err)
        }
    })
}
const reset = () => {
    searchFilter.value.search = null
    searchFilter.value.filterStatus = null
    fetchData()
}
</script>

<template>
    <AppLayout>


        <div>
            <Head title="Organizations"/>
            <h1 class="mb-8 text-3xl font-bold text-gray-500 dark:text-gray-100">Tasks</h1>
            <div class="flex items-center justify-between mb-6">
                      <SearchFilter v-model="searchFilter.search" class="mr-4 w-full max-w-md" @reset="reset" @keyup="fetchData">
                        <label class="block text-gray-500 dark:text-gray-100">Status:</label>
                        <select v-model="searchFilter.filterStatus" @change="fetchData" class="form-select mt-1 w-full">
                            <option value="null" :selected="searchFilter.filterStatus === null">All</option>
                          <option value="true"  :selected="searchFilter.filterStatus === true">Completed</option>
                          <option value="false"  :selected="searchFilter.filterStatus === false">In-Complete</option>
                        </select>
                      </SearchFilter>
                <Link class="btn-indigo" href="/organizations/create">
                    <span>Create</span>
                    <span class="hidden md:inline">&nbsp;Organization</span>
                </Link>
            </div>
            <div class="bg-gray-300 dark:bg-gray-700  rounded-md shadow overflow-x-auto text-black dark:text-gray-300">
                <table class="w-full whitespace-nowrap ">
                    <thead>
                    <tr class="text-left font-bold text-black dark:text-gray-100 ">
                        <th class="pb-4 pt-6 px-6">Title</th>
                        <th class="pb-4 pt-6 px-6">Description</th>
                        <th class="pb-4 pt-6 px-6">Status</th>
                        <th class="pb-4 pt-6 px-6" colspan="2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="task in tasks.data" :key="task.id"
                        class="hover:bg-gray-100 dark:hover:bg-gray-600 ">
                        <td class="border-t">
                            <p class="flex items-center px-6 py-4 focus:text-indigo-500">
                                {{ task.title }}
                            </p>
                        </td>
                        <td class="border-t">
                            <p class="flex items-center px-6 py-4" tabindex="-1">
                                {{ task.description }}
                            </p>
                        </td>
                        <td class="border-t">
                <span :class="statusVariant(task.status)" class="px-2 py-1 rounded-full text-xs font-medium">
                  {{ task.status? 'Complete' : 'In-Complete' }}
                </span>
                        </td>
                        <td class="border-t">
                            <Switch :model-value="!!task.status" @update:modelValue="updateStatus(task)"
                                    :class="[task.status ? 'bg-indigo-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2']">
                                <span class="sr-only">Toggle Status</span>
                                <span
                                    :class="[task.status ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none relative inline-block size-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']">
                                  <span
                                      :class="[task.status ? 'opacity-0 duration-100 ease-out' : 'opacity-100 duration-200 ease-in', 'absolute inset-0 flex size-full items-center justify-center transition-opacity']"
                                      aria-hidden="true">
                                    <svg class="size-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                                      <path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                  </span>
                                  <span
                                      :class="[task.status ? 'opacity-100 duration-200 ease-in' : 'opacity-0 duration-100 ease-out', 'absolute inset-0 flex size-full items-center justify-center transition-opacity']"
                                      aria-hidden="true">
                                    <svg class="size-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                                      <path
                                          d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"/>
                                    </svg>
                                  </span>
                                </span>
                            </Switch>
                        </td>
                    </tr>
                    <tr v-if="tasks.data.length === 0">
                        <td class="px-6 py-4 border-t" colspan="4">No organizations found.</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <Pagination class="mt-6" :links="tasks.links"/>
        </div>
    </AppLayout>
</template>

<style scoped>

</style>
