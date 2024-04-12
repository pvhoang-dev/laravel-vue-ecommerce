<script setup>
import { ref, computed } from "vue";
import store from "../store";
const test = computed(() => store.state.test);

defineProps({
  msg: String,
});
</script>

<template>
  {{ test }}
</template>

<style scoped>
.read-the-docs {
  color: #888;
}
</style>
