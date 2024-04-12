<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import SideBar from "../components/SideBar.vue";
import NavBar from "../components/NavBar.vue";

const { title } = defineProps({
  title: String,
});

const sidebarOpened = ref(true);

function toggleSidebar() {
  sidebarOpened.value = !sidebarOpened.value;
}

function updateSidebarState() {
  sidebarOpened.value = window.outerWidth > 768;
}

onMounted(() => {
  updateSidebarState();
  window.addEventListener("resize", updateSidebarState);
});

onUnmounted(() => {
  window.removeEventListener("resize", updateSidebarState);
});
</script>

<template>
  <div class="min-h-full bg-gray-200 flex">
    <Sidebar :class="{ '-ml-[200px]': !sidebarOpened }" />
    <div class="flex-1">
      <NavBar @toggle-sidebar="toggleSidebar"></NavBar>
      <main class="p-6">
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>
