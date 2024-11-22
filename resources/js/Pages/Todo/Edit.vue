<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    task: Object,
});

const form = useForm({
    title: props.task.title,
    description: props.task.description, // Initialize the form with the current task title
});

function submit() {
    form.put(`/todo/${props.task.id}`, {
        onSuccess: () => {
        },
    });
}
</script>

<template>

    <Head title="Edit Task" />
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Task</h2>

                    <form @submit.prevent="submit">
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input id="title" type="text" v-model="form.title"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            <div v-if="form.errors.title" class="text-red-600 text-sm mt-1">{{ form.errors.title }}
                            </div>

                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" v-model="form.description"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                rows="4"></textarea>
                            <div v-if="form.errors.description" class="text-red-600 text-sm mt-1">{{
                                form.errors.description }}</div>
                        </div>

                        <div class="mt-4">
                            <button type="submit"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                Update
                            </button>
                            <Link href="/todo" class="ml-4 text-gray-600 hover:text-gray-800">
                            Cancel
                            </Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
