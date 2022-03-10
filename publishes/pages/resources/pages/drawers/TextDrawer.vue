<template>
    <Drawer title="Text" hint="just a simple text input" color="purple">
        <svg
            width="24"
            height="24"
            stroke-width="1.5"
            viewBox="0 0 24 24"
            fill="none"
            class="w-4 h-4"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M3 10L17 10"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                d="M3 6H21"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                d="M3 18L17 18"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
            <path
                d="M3 14H21"
                stroke="currentColor"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    </Drawer>
</template>
<script lang="ts" setup>
import { Drawer } from '@macramejs/admin-vue3';
</script>
