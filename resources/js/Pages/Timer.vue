<script setup lang="ts">
import { ref, onMounted, onUnmounted } from 'vue';

const currentDate = ref('');
const currentTime = ref('');

const formatDate = (date: Date): string => {
  return new Intl.DateTimeFormat('en-US', {
    weekday: 'long',
    month: 'long',
    day: '2-digit',
    year: 'numeric',
  }).format(date);
};

const formatTime = (date: Date): string => {
  return new Intl.DateTimeFormat('en-US', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: true,
  }).format(date);
};

let interval: number | undefined;

const updateTime = () => {
  const now = new Date();
  currentDate.value = formatDate(now);
  currentTime.value = formatTime(now);
};

onMounted(() => {
  updateTime();
  interval = setInterval(updateTime, 1000);
});

onUnmounted(() => {
  if (interval) {
    clearInterval(interval);
  }
});
</script>

<template>
  <div class="flex flex-col items-center justify-center h-max space-y-4">
    <span class="text-xl font-bold dark:text-gray-200 text-gray-800">📅 {{ currentDate }}</span>
    <span class="text-5xl font-mono dark:text-gray-200 text-gray-800">{{ currentTime }}</span>
  </div>
</template>
