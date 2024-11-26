<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { defineProps, onMounted, ref, watchEffect, watch, computed } from 'vue';
import { Task } from '@/types/index';
import Modal from '@/Components/Modal.vue';
import AddButton from '@/Components/AddButton.vue';
import EditButton from '@/Components/EditButton.vue';
import DeleteButton from '@/Components/DeleteButton.vue';
import ShuffleButton from '@/Components/ShuffleButton.vue';

const title = ref('Todo');
// const tasks = ref<Task[]>([]);
const tasks = computed(() => props.tasks);
const newTask = ref({ title: '', description: '' });
const selectedTask = ref<Task | null>(null);
const showAddModal = ref(false);
const showEditModal = ref(false);

const props = defineProps({
    tasks: {
        type: Array as () => Task[],
        required: true
    }
});


// onMounted(() => {
//     tasks.value = props.tasks || [];
// });


// watchEffect(() => {
//     if (newTask.value && (newTask.value.title || newTask.value.description)) {
//         watch(
//             () => tasks.value,
//             (newTasks) => {
//                 tasks.value = newTasks || [];
//             },
//             { immediate: true }
//         );
//     }
// });


function newTodo() {
    if (!newTask.value.title || !newTask.value.description) {
        alert('Please fill in all fields.');
        return;
    }

    router.post('/todo', newTask.value, {
        onSuccess: () => {
            props.tasks.push({
                ...newTask.value, id: Date.now(),
                is_completed: false
            });
            newTask.value = { title: '', description: '' };
            showAddModal.value = false;

        },
        // onFinish: () => {
        //     // router.visit('/todo');
        //     router.reload();
        // }

    });
}

function openEditModal(task: Task) {
    selectedTask.value = { ...task };
    showEditModal.value = true;
}

function editTodo() {
    if (!selectedTask.value) return;

    router.put(`/todo/${selectedTask.value.id}`, {
        ...selectedTask.value,
    }, {
        onSuccess: () => {
            showEditModal.value = false;
        },
    });
}

function shuffle() {
    props.tasks.sort(() => 0.5 - Math.random());
}

function deleteTask(taskId: number) {
    if (!confirm('Are you sure you want to delete this task?')) {
        return;
    }

    router.delete(`/todo/${taskId}`, {
        onSuccess: () => {
            // tasks.value = tasks.value.filter(task => task.id !== taskId);
            const taskIndex = props.tasks.findIndex((task: Task) => task.id === taskId);
            if (taskIndex !== -1) {
                props.tasks.splice(taskIndex, 1);
            }
        },
        onError: () => {
            alert('Failed to delete the task.');
        },
        // onFinish: () => {
        //     // router.visit('/todo');
        //     router.reload();
        // }
    });
}

</script>

<template>

    <Head title="Todo" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {{ title }}
                </h2>
                <button @click="showAddModal = true"
                    class="bg-emerald-500 text-white py-2 px-4 rounded hover:bg-emerald-600 w-max z-20 cursor-pointer">
                    <AddButton />
                </button>
            </div>

        </template>



        <div class="py-12">

            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class=" shadow-xs sm:rounded-lg dark:bg-gray-800">
                    <button @click="shuffle"
                        class="text-gray-600 dark:text-gray-200 py-2 px-4 rounded z-20 cursor-pointer">
                        <ShuffleButton />
                    </button>
                    <div class=" text-gray-900 dark:text-gray-100 w-full">

                        <div class="py-6 w-full flex flex-wrap" v-auto-animate>
                            <div v-if="tasks && tasks.length" v-for="task in tasks" :key="task.id"
                                class="flex flex-row items-start w-max max-w-64 h-max border border-gray-300 rounded-xl space-x-2 py-1 px-2 m-2 ">
                                <div class="flex flex-col">
                                    <div class=" font-bold">
                                        {{ task.title }}
                                    </div>
                                    <div>
                                        {{ task.description }}
                                    </div>
                                </div>

                                <div class="flex flex-col gap-2">

                                    <button @click="openEditModal(task)"
                                        class="cursor-pointer bg-blue-500 text-white px-1 py-1 rounded-xl hover:bg-blue-600 text-xs text-center">
                                        <EditButton />
                                    </button>
                                    <button @click="deleteTask(task.id)"
                                        class="cursor-pointer bg-red-500 text-white px-1 py-1 rounded-xl hover:bg-red-600 text-xs text-center">
                                        <DeleteButton />
                                    </button>
                                </div>
                            </div>
                            <div v-else class="text-gray-500 italic p-4">
                                No tasks available.
                            </div>
                        </div>


                        <Modal :show="showAddModal" @close="showAddModal = false">
                            <form @submit.prevent="newTodo" class="w-full relative">
                                <input v-model="newTask.title" placeholder="Task Title"
                                    class="w-full mb-2 px-4 py-2 border rounded" required />
                                <textarea v-model="newTask.description" placeholder="Task Description"
                                    class="w-full mb-2 px-4 py-2 border rounded" required></textarea>
                                <button type="submit"
                                    class="bg-emerald-500 text-white py-2 px-4 rounded hover:bg-emerald-600 float-right">
                                    Add Task
                                </button>
                            </form>
                        </Modal>

                        <Modal :show="showEditModal" @close="showEditModal = false">
                            <form @submit.prevent="editTodo" class="w-full relative">
                                <div v-if="selectedTask">
                                    <input v-model="selectedTask.title" placeholder="Task Title"
                                        class="w-full mb-2 px-4 py-2 border rounded" required />
                                    <textarea v-model="selectedTask.description" placeholder="Task Description"
                                        class="w-full mb-2 px-4 py-2 border rounded" required></textarea>
                                    <button type="submit"
                                        class="bg-emerald-500 text-white py-2 px-4 rounded hover:bg-emerald-600 float-right">
                                        Update
                                    </button>
                                </div>
                                <div v-else class="text-gray-500 italic">
                                    No task selected.
                                </div>
                            </form>
                        </Modal>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
