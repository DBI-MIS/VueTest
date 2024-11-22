<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Task } from '@/types/index';

const title = ref('Todo')

const showModal = ref(false)

const props = defineProps({
    tasks: Array as () => Task[]
});

const deleteTask = (taskId: number) => {
    router.delete(`/todo/${taskId}`);
};



</script>

<template>

    <Head title="Todo" />
    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ title }}
            </h2>
        </template>

        <div class="py-12">

            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-xs sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100 w-full">
                        <Link class="bg-emerald-300 py-2 px-4 rounded-xl text-gray-700 float-right"
                            :href="route('tasks.create')">
                        <span>Create</span>
                        </Link>
                        <!-- <button id="show-modal" @click="showModal = true">Show Modal</button> -->



                <div class="">
                    <TransitionGroup name="fade" tag="div" enter-from-class="opacity-0" leave-to-class="opacity-0"
                        enter-active-class="transition duration-300 ease-in-out"
                        leave-active-class="transition duration-300 ease-in-out">
                        <div v-for="task in tasks" :key="task.id"
                            class="flex flex-row items-start w-max border-white border rounded-xl space-x-2 py-2 px-4 m-2">
                            <div class="flex flex-col min-w-64 max-w-64">
                                <div class="py-2">
                                    {{ task.title }}
                                </div>
                                <div>
                                    {{ task.description }}
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <Link :href="`/todo/${task.id}/edit`"
                                    class="bg-blue-500 text-white px-3 py-1 rounded-xl hover:bg-blue-600 text-xs text-center">
                                Edit
                                </Link>
                                <button @click="deleteTask(task.id)"
                                    class="bg-red-500 text-white px-3 py-1 rounded-xl hover:bg-red-600 text-xs text-center">
                                    Delete
                                </button>
                            </div>


                        </div>
                    </TransitionGroup>

                </div>
            </div>
        </div>
    </div>
</div>
</AuthenticatedLayout>
</template>
