<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';

import Dropdown from '@/Components/Dropdown.vue';
import Logo from "@/Components/Logo.vue";
import MainMenu from "@/Components/MainMenu.vue";
import Icon from "@/Components/Icon.vue";
import FlashMessages from "@/Components/FlashMessages.vue";
import ApplicationMark from "@/Shared/ApplicationMark.vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
  <div>
    <div id="dropdown" />
    <div class="md:flex md:flex-col">
      <div class="md:flex md:flex-col md:h-screen">
        <div class="md:flex md:shrink-0">
          <div class="flex items-center justify-between px-6 py-4 bg-indigo-900 md:shrink-0 md:justify-center md:w-56">
            <Link class="mt-1" href="/">

                <ApplicationMark class="block h-9 w-auto" />

            </Link>
            <dropdown class="md:hidden" placement="bottom-end">
              <template #default>
                <svg class="w-6 h-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
              </template>
              <template #dropdown>
                <div class="mt-2 px-8 py-4 bg-indigo-800 rounded shadow-lg">
                  <MainMenu />
                </div>
              </template>
            </dropdown>
          </div>
          <div class="md:text-md flex items-center justify-between p-4 w-full text-sm bg-white dark:bg-gray-800 text-black dark:text-gray-100 border-b md:px-12 md:py-0">
            <div class="mr-4 mt-1">{{ $page.props.auth.user.name }}</div>
            <dropdown class="mt-1" placement="bottom-end">
              <template #default>
                <div class="group flex items-center cursor-pointer select-none">
                  <div class="mr-1 text-black dark:text-gray-100 group-hover:text-indigo-600 focus:text-indigo-600 whitespace-nowrap">
                    <span>{{ $page.props.auth.user.name }}</span>
                    <span class="hidden md:inline">&nbsp;{{ $page.props.auth.user.name }}</span>
                  </div>
                  <Icon class="w-5 h-5 fill-gray-700 dark:fill-indigo-200 group-hover:fill-indigo-600 focus:fill-indigo-600" name="cheveron-down" />
                </div>
              </template>
              <template #dropdown>
                <div class="mt-2 py-2 text-sm bg-white dark:bg-gray-800  text-black dark:text-gray-100 rounded shadow-xl">
                  <Link class="block px-6 py-2 hover:text-white hover:bg-indigo-500" :href="route('profile.show')">My Profile</Link>
                  <Link class="block px-6 py-2 hover:text-white hover:bg-indigo-500" v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">Api Tokens</Link>
                  <Link class="block px-6 py-2 w-full text-left hover:text-white hover:bg-indigo-500" @click="logout" >Logout</Link>
                </div>
              </template>
            </dropdown>
          </div>
        </div>
        <div class="md:flex md:grow md:overflow-hidden">
          <MainMenu class="hidden shrink-0 p-12 w-56 bg-indigo-800 overflow-y-auto md:block" />
          <div class="px-4 py-8 md:flex-1 md:p-12 md:overflow-y-auto bg-gray-300 dark:bg-gray-700 " scroll-region>
            <FlashMessages />
            <slot />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
