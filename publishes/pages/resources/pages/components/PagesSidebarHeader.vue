<template>
    <div class="flex justify-between w-full">
        <span class="inline-block text-xl"> Seiten </span>
        <Button
            square
            secondary
            @click="isOpen = true"
            @keyup.esc="isOpen = false"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="-4.5 -4.5 24 24"
                class="w-4 h-4 fill-white"
            >
                <path
                    d="M8.9 6.9v-5a1 1 0 1 0-2 0v5h-5a1 1 0 1 0 0 2h5v5a1 1 0 1 0 2 0v-5h5a1 1 0 1 0 0-2h-5z"
                ></path>
            </svg>
        </Button>
    </div>
    <AddPageModel :open="isOpen" @close="isOpen = false" />
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Button } from '@macramejs/admin-vue3';
import AddPageModel from './AddPageModal.vue';

const isOpen = ref(false);
</script>
