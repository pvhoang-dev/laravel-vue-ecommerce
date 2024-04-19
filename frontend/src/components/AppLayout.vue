<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import SideBar from "../components/SideBar.vue";
import NavBar from "../components/NavBar.vue";
import store from "../store";
import Spinner from "./core/Spinner.vue";
import Toast from "./core/Toast.vue";

const { title } = defineProps({
  title: String,
});

const sidebarOpened = ref(true);
const currentUser = computed(() => store.state.user.data);

function toggleSidebar() {
  sidebarOpened.value = !sidebarOpened.value;
}

function updateSidebarState() {
  sidebarOpened.value = window.outerWidth > 768;
}

onMounted(() => {
  store.dispatch("getUser");
  updateSidebarState();
  window.addEventListener("resize", updateSidebarState);
});

onUnmounted(() => {
  window.removeEventListener("resize", updateSidebarState);
});
</script>

<template>
  <div v-if="currentUser.name" class="min-h-full bg-gray-200 flex">
    <SideBar :class="{ '-ml-[200px]': !sidebarOpened }" />
    <div class="flex-1">
      <NavBar @toggle-sidebar="toggleSidebar"></NavBar>
      <main class="p-6">
        <router-view></router-view>
      </main>
    </div>
  </div>
  <div v-else class="min-h-full bg-gray-200 flex items-center justify-center">
    <Spinner />
  </div>
  <Toast />
</template>
