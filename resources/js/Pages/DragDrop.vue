<script setup lang="ts">
import { ref, computed } from 'vue';

const items = ref([
    {
        id: 0,
        title: 'Item A',
        list: 1,
    },
    {
        id: 1,
        title: 'Item B',
        list: 1,
    },
    {
        id: 2,
        title: 'Item C',
        list: 2,
    },
    {
        id: 3,
        title: 'Item D',
        list: 2,
    },
    {
        id: 4,
        title: 'Item E',
        list: 3,
    },
    {
        id: 5,
        title: 'Item F',
        list: 3,
    },
    {
        id: 6,
        title: 'Item G',
        list:4,
    },
    {
        id: 7,
        title: 'Item H',
        list: 4,
    },
]);

const listOne = computed(() => items.value.filter((item) => item.list === 1));
const listTwo = computed(() => items.value.filter((item) => item.list === 2));
const listThree = computed(() => items.value.filter((item) => item.list === 3));
const listFour = computed(() => items.value.filter((item) => item.list === 4));

function startDrag(evt: DragEvent, item: { id: number; title: string; list: number }) {
    if (!evt.dataTransfer) {
        console.error('DragEvent dataTransfer is not available');
        return;
    }
    evt.dataTransfer.dropEffect = 'move';
    evt.dataTransfer.effectAllowed = 'move';
    evt.dataTransfer.setData('itemID', item.id.toString());
    console.log('Drag started for item:', item); // Debugging
}

function onDrop(evt: DragEvent, list: number) {
    if (!evt.dataTransfer) return;
    const itemID = evt.dataTransfer.getData('itemID');
    const item = items.value.find((item) => item.id === parseInt(itemID, 10));
    if (item) {
        item.list = list;
        console.log(`Item ${itemID} moved to list ${list}`); // Debugging
    }
}


</script>

<template>
    <div class="flex felx-row gap-2 px-2">
        
        <!-- Drop Zone 1 -->
        <div
            class=" bg-gray-200 mb-[10px] p-[10px] w-[300px] text-center h-max rounded-xl"
            @drop="onDrop($event, 1)"
            @dragover.prevent
            @dragenter.prevent
        >
        <TransitionGroup name="fade" tag="div">
            <div
                class=" bg-white mb-[10px] p-[5px] cursor-pointer"
                v-for="item in listOne"
                :key="item.id"
                draggable="true"
                @dragstart="startDrag($event, item)"
                v-auto-animate
            >
                {{ item.title }}
            </div>
        </TransitionGroup>
        </div>

        <!-- Drop Zone 2 -->
        <div
            class=" bg-gray-200 mb-[10px] p-[10px] w-[300px] text-center h-max rounded-xl"
            @drop="onDrop($event, 2)"
            @dragover.prevent
            @dragenter.prevent
        >
        <TransitionGroup name="fade" tag="div">
            <div
                class=" bg-white mb-[10px] p-[5px] cursor-pointer"
                v-for="item in listTwo"
                :key="item.id"
                draggable="true"
                @dragstart="startDrag($event, item)"
                v-auto-animate
            >
                {{ item.title }}
            </div>
        </TransitionGroup>
        </div>

        <!-- Drop Zone 3 -->
        <div
            class=" bg-gray-200 mb-[10px] p-[10px] w-[300px] text-center h-max rounded-xl"
            @drop="onDrop($event, 3)"
            @dragover.prevent
            @dragenter.prevent
        >
        <TransitionGroup name="fade" tag="div">
            <div
                class=" bg-white mb-[10px] p-[5px] cursor-pointer"
                v-for="item in listThree"
                :key="item.id"
                draggable="true"
                @dragstart="startDrag($event, item)"
                v-auto-animate
            >
                {{ item.title }}
            </div>
        </TransitionGroup>
        </div>

        <!-- Drop Zone 4 -->
        <div
            class=" bg-gray-200 mb-[10px] p-[10px] w-[300px] text-center h-max rounded-xl"
            @drop="onDrop($event, 4)"
            @dragover.prevent
            @dragenter.prevent
        >
        <TransitionGroup name="fade" tag="div">
            <div
                class=" bg-white mb-[10px] p-[5px] cursor-pointer"
                v-for="item in listFour"
                :key="item.id"
                draggable="true"
                @dragstart="startDrag($event, item)"
                v-auto-animate
            >
                {{ item.title }}
            </div>
        </TransitionGroup>
        </div>

    </div>
</template>

<style>

/* 1. declare transition */
.fade-move,
.fade-enter-active,
.fade-leave-active {
  transition: all 0.5s cubic-bezier(0.55, 0, 0.1, 1);
}

/* 2. declare enter from and leave to state */
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: scaleY(0.01) translate(30px, 0);
}

/* 3. ensure leaving items are taken out of layout flow so that moving
      animations can be calculated correctly. */
.fade-leave-active {
  position: absolute;
}
</style>
