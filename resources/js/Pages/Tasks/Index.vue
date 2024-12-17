<script setup lang="ts">

import AppLayout from "@/Layouts/AppLayout.vue";
import type {ListResponse, Task} from "@/Types/types";
import Pagination from "@/Components/Pagination.vue";
import Icon from "@/Components/Icon.vue";
import { Head, Link } from '@inertiajs/vue3'
import SearchFilter from "@/Components/SearchFilter.vue";

defineProps({
    tasks: {
        type: Object as () => ListResponse<Task>,
        required: true
    }
})
</script>

<template>
<AppLayout>


  <div>
    <Head title="Organizations" />
    <h1 class="mb-8 text-3xl font-bold">Organizations</h1>
    <div class="flex items-center justify-between mb-6">
<!--      <SearchFilter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">-->
<!--        <label class="block text-gray-700">Trashed:</label>-->
<!--        <select v-model="form.trashed" class="form-select mt-1 w-full">-->
<!--          <option :value="null" />-->
<!--          <option value="with">With Trashed</option>-->
<!--          <option value="only">Only Trashed</option>-->
<!--        </select>-->
<!--      </SearchFilter>-->
      <Link class="btn-indigo" href="/organizations/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Organization</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6">Title</th>
            <th class="pb-4 pt-6 px-6">Description</th>
            <th class="pb-4 pt-6 px-6" colspan="2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in tasks.data" :key="task.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link class="flex items-center px-6 py-4 focus:text-indigo-500" href="">
                {{ task.title }}
              </Link>
            </td>
            <td class="border-t">
              <Link class="flex items-center px-6 py-4" href="" tabindex="-1">
                {{ task.description }}
              </Link>
            </td>
            <td class="border-t">


            </td>
          </tr>
          <tr v-if="tasks.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="4">No organizations found.</td>
          </tr>
        </tbody>
      </table>
    </div>
    <Pagination class="mt-6" :links="tasks.links" />
  </div>
</AppLayout>
</template>

<style scoped>

</style>
