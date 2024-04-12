<script setup>
import { ref } from "vue";
import SideBar from "../components/SideBar.vue";
import TopHeader from "../components/TopHeader.vue";

const { title } = defineProps({
  title: String,
});

const sidebarOpened = ref(true);

function toggleSidebar() {
  sidebarOpened.value = !sidebarOpened.value;
}
</script>

<template>
  <div class="min-h-full bg-gray-200 flex">
    <Sidebar :class="{ '-ml-[200px]': !sidebarOpened }" />
    <div class="flex-1">
      <TopHeader @toggle-sidebar="toggleSidebar"></TopHeader>
      <main class="p-6">
        <router-view></router-view>
      </main>
    </div>
  </div>
</template>
