<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { Task } from '@/types/index';
import { useAutoAnimate } from '@formkit/auto-animate/vue';
import Modal from '@/Components/Modal.vue';

const title = ref('Todo');
const tasks = ref<Task[]>([]);
const newTask = ref({ title: '', description: '' });
const showModal = ref(false);

const [parentlist] = useAutoAnimate();

const props = defineProps({
    tasks: Array as () => Task[],
});

onMounted(() => {
    tasks.value = props.tasks || [];
});

function newTodo() {
    if (!newTask.value.title || !newTask.value.description) {
        alert('Please fill in all fields.');
        return;
    }

    router.post('/todo', newTask.value, {
        onSuccess: () => {
            tasks.value.push({ ...newTask.value, id: Date.now() });
            newTask.value = { title: '', description: '' };
        }
    });
}

function deleteTask(taskId: number) {
    router.delete(`/todo/${taskId}`);
};
</script>

<template>
    <Head title="Todo" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                {{ title }}
            </h2>
            <button
                            @click="showModal = true"
                            class="bg-emerald-500 text-white py-2 px-4 rounded hover:bg-emerald-600 w-max z-20 cursor-pointer"
                        >
                            Add Task
                        </button>
            </div>
           
        </template>
        

        <div class="py-12">
            
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
               
                <div class=" shadow-xs sm:rounded-lg dark:bg-gray-800">
                    
                    <div class=" text-gray-900 dark:text-gray-100 w-full">
                        
                       


                        <!-- Task List -->
                        <div class="py-6 w-full flex flex-wrap" ref="parentlist">
                            <div
                                v-if="tasks && tasks.length"
                                v-for="task in tasks"
                                :key="task.id"
                                class="flex flex-row items-start w-max border border-gray-300 rounded-xl space-x-2 py-2 px-4 m-2"
                            >
                                <div class="flex flex-col flex-grow">
                                    <div class="py-2 font-bold">
                                        {{ task.title }}
                                    </div>
                                    <div>
                                        {{ task.description }}
                                    </div>
                                </div>
                                
                                <div class="flex flex-col gap-2">
                                    <Link
                                        :href="`/todo/${task.id}/edit`"
                                        class="bg-blue-500 text-white px-3 py-1 rounded-xl hover:bg-blue-600 text-xs text-center"
                                    >
                                        Edit
                                    </Link>
                                    <button
                                        @click="deleteTask(task.id)"
                                        class="bg-red-500 text-white px-3 py-1 rounded-xl hover:bg-red-600 text-xs text-center"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                            <div v-else class="text-gray-500 italic p-4">
                            No tasks available.
                        </div>
                        </div>
                      
                        <Modal :show="showModal" @close="showModal = false">
                        <form @submit.prevent="newTodo" class="w-full relative">
                            <input
                                v-model="newTask.title"
                                placeholder="Task Title"
                                class="w-full mb-2 px-4 py-2 border rounded"
                                required
                            />
                            <textarea
                                v-model="newTask.description"
                                placeholder="Task Description"
                                class="w-full mb-2 px-4 py-2 border rounded"
                                required
                            ></textarea>
                            <button
                                type="submit"
                                class="bg-emerald-500 text-white py-2 px-4 rounded hover:bg-emerald-600 float-right"
                            >
                                Add Task
                            </button>
                        </form>
                    </Modal>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
