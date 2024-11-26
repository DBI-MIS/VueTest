<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Timer from './Timer.vue';
import DarkModeSwitcher from '@/Components/DarkModeSwitcher.vue';

</script>

<template>

    <Head title="Welcome" />
    <div class=" bg-gray-200 dark:bg-gray-800 h-screen justify-center items-center flex flex-col gap-4">
        <DarkModeSwitcher />
        <Timer />
        
            
        
        
    </div>

</template>
