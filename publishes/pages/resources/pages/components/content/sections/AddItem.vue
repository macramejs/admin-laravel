<template>
    <button
        class="bg-gray-200 hover:bg-gray-300 text-gray uppercase text-black whitespace-nowrap px-6 py-3 flex items-center tracking-wider font-semibold rounded text-sm"
    >
        <IconPlus class="w-5 h-5 mr-4" />
        <slot> Add </slot>
    </button>
</template>

<script lang="ts" setup>
import { IconPlus } from "@macramejs/admin-vue3";
</script>
