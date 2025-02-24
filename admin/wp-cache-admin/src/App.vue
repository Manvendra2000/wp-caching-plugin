<script setup>
import { ref, onMounted } from "vue";

const cacheStatus = ref("Loading...");

const fetchCacheStatus = async () => {
  const response = await fetch('/wp-json/wp-cache/v1/status');
  const data = await response.json();
  cacheStatus.value = data.status;
};

onMounted(fetchCacheStatus);

const clearCache = async () => {
  await fetch('/wp-json/wp-cache/v1/clear', { method: "POST" });
  cacheStatus.value = "Cache Cleared!";
};
</script>

<template>
  <div>
    <h1>WordPress Cache</h1>
    <p>Cache Status: {{ cacheStatus }}</p>
    <button @click="clearCache">Clear Cache</button>
  </div>
</template>

<style>
button {
  padding: 10px;
  background: blue;
  color: white;
  border: none;
  cursor: pointer;
}
</style>