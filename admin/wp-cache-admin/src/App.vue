<script setup>
import { ref, onMounted } from "vue";

const cacheStatus = ref("Checking...");
const cacheFiles = ref([]);

const fetchCacheStatus = async () => {
  const response = await fetch('/wp-json/wp-cache/v1/status');
  const data = await response.json();
  cacheStatus.value = data.status;
};

onMounted(fetchCacheStatus);

const clearCache = async () => {
  const response = await fetch('/wp-json/wp-cache/v1/clear', {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-WP-Nonce": window.wpApiSettings?.nonce || "" // Handle missing nonce gracefully
    },
    credentials: "same-origin"
  });

  const data = await response.json();
  cacheStatus.value = data.message;
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