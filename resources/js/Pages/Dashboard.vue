<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const items = [
    {
        title: 'First',
        description: 'The first item.',
    },
    {
        title: 'Second',
        description: 'The second item.',
    },
    {
        title: 'Third',
        description: 'sasdasd',
    },
    {
        title: 'Fourth',
        description: 'The first item.',
    },
    {
        title: 'Fifth',
        description: 'The second item.',
    },
    {
        title: 'Sixth',
        description: 'sasdasd',
    },
]

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-xs sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        You're logged in!
                    </div>

                    <masonry-wall :items="items" :ssr-columns="1" :column-width="[300, 200, 150]" :gap="10">
                        <template #default="{ item }">
                            <div class="border p-4 rounded-xl bg-blue-600 h-max">
                                <h1>{{ item.title }}</h1>
                                <span>{{ item.description }}</span>
                            </div>
                        </template>
                    </masonry-wall>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
