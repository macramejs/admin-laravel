<template>
    <ContextMenu placement="bottom" customButton>
        <template #button>
            <Button secondary :disabled="selectedFiles.length == 0">
                Edit Selection
            </Button>
        </template>
        <div class="flex flex-col">
            <button
                class="w-full py-2.5 px-[14px] text-left hover:bg-white hover:bg-opacity-20 rounded-[8px]"
            >
                Edit
            </button>
            <button
                class="w-full py-2.5 px-[14px] text-left hover:bg-white hover:bg-opacity-20 rounded-[8px]"
            >
                Duplicate
            </button>
            <div class="bg-white w-full my-1.5 h-px bg-opacity-20"></div>
            <button
                class="w-full py-2.5 px-[14px] text-left hover:bg-white hover:bg-opacity-20 rounded-[8px]"
            >
                Archive
            </button>
            <button
                class="w-full py-2.5 px-[14px] text-left hover:bg-white hover:bg-opacity-20 rounded-[8px]"
            >
                Move
            </button>
            <div class="bg-white w-full my-1.5 h-px bg-opacity-20"></div>
            <button
                class="w-full flex items-center text-red-signal gap-2 py-2.5 px-[14px] text-left hover:bg-red-signal hover:bg-opacity-20 rounded-[8px]"
            >
                <svg
                    width="24"
                    height="24"
                    class="origin-left scale-75"
                    stroke-width="1.5"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M19 11v9.4a.6.6 0 0 1-.6.6H5.6a.6.6 0 0 1-.6-.6V11M10 17v-6M14 17v-6M21 7h-5M3 7h5m0 0V3.6a.6.6 0 0 1 .6-.6h6.8a.6.6 0 0 1 .6.6V7M8 7h8"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
                <span>Delete</span>
            </button>
        </div>
    </ContextMenu>
</template>

<script lang="ts" setup>
import { Button, ContextMenu } from '@macramejs/admin-vue3';
import { selectedFiles } from '../modules';
</script>
