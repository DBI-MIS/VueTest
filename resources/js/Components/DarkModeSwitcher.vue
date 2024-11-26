<script lang="ts">
  import { ref, onMounted } from 'vue';
  import { MoonIcon, SunIcon } from '@heroicons/vue/24/solid'; // Import Heroicons
  
  export default {
    name: 'DarkModeSwitcher',
    components: {
      MoonIcon,
      SunIcon,
    },
    setup() {
      // State to hold the dark mode status (true for dark mode, false for light mode)
      const isDarkMode = ref<boolean>(false);
  
      // Check the saved dark mode preference in localStorage on mounted
      onMounted(() => {
        const storedDarkMode = localStorage.getItem('darkMode');
        if (storedDarkMode !== null) {
          isDarkMode.value = storedDarkMode === 'true';
        } else {
          // If not found, fallback to system preference
          isDarkMode.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
  
        // Apply the dark class to body element
        document.body.classList.toggle('dark', isDarkMode.value);
      });
  
      // Function to toggle dark mode and store preference in localStorage
      const toggleDarkMode = (): void => {
        isDarkMode.value = !isDarkMode.value;
        document.body.classList.toggle('dark', isDarkMode.value);
        localStorage.setItem('darkMode', isDarkMode.value.toString());
      };
  
      return {
        isDarkMode,
        toggleDarkMode,
      };
    },
  };
  </script>

<template>
    <div>
      <button @click="toggleDarkMode" class="p-2  text-white rounded-md flex items-center">
        <template v-if="isDarkMode">
          <MoonIcon class="h-5 w-5 text-yellow-400" />
        </template>
        <template v-else>
          <SunIcon class="h-5 w-5 text-yellow-500" />
        </template>
      </button>
    </div>
  </template>
  
  
  