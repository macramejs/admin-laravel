<template>
    <div class="flex flex-col gap-1 p-2 border-b border-gray-400">
        <button
            :class="
                index.filters.types.value.includes('images')
                    ? 'bg-gray-100'
                    : ''
            "
            class="px-4 py-2 mb-1 rounded-[8px] transition-colors w-full text-left duration-300 hover:bg-gray-100"
            @click="index.filters.types.toggle('images')"
        >
            Images
        </button>
        <button
            :class="
                index.filters.types.value.includes('documents')
                    ? 'bg-gray-100'
                    : ''
            "
            class="px-4 py-2 mb-1 rounded-[8px] transition-colors w-full text-left duration-300 hover:bg-gray-100"
            @click="index.filters.types.toggle('documents')"
        >
            Documents
        </button>
    </div>
    <div class="flex flex-col gap-1 p-2 border-b border-gray-400">
        <div class="flex items-center gap-3 px-5 pt-16 pb-6 -mx-2">
            <svg
                width="24"
                stroke-width="1"
                height="24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M5 19.5V5a2 2 0 0 1 2-2h11.4a.6.6 0 0 1 .6.6V21M9 7h6M6.5 15H19M6.5 18H19M6.5 21H19"
                    stroke="currentColor"
                    stroke-linecap="round"
                />
                <path
                    d="M6.5 18c-1 0-1.5-.672-1.5-1.5S5.5 15 6.5 15M6.5 21c-1 0-1.5-.672-1.5-1.5S5.5 18 6.5 18"
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                />
            </svg>
            <span class="inline-block text-xl"> Collections </span>
            <button
                class="inline-flex items-center justify-center ml-auto text-white rounded-full h-9 w-9 bg-gradient-to-r from-indigo-900 focus:outline-none focus:ring-4 focus:ring-orange-100 active:from-indigo-500 active:to-indigo-500 to-indigo-900 hover:from-gradient-red-500 hover:to-gradient-orange-500"
                @click="showForm = !showForm"
            >
                <svg
                    width="24"
                    stroke-width="1"
                    height="24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M5 19.5V5a2 2 0 0 1 2-2h11.4a.6.6 0 0 1 .6.6V21M9 7h6M6.5 15H19M6.5 18H19M6.5 21H19"
                        stroke="currentColor"
                        stroke-linecap="round"
                    />
                    <path
                        d="M6.5 18c-1 0-1.5-.672-1.5-1.5S5.5 15 6.5 15M6.5 21c-1 0-1.5-.672-1.5-1.5S5.5 18 6.5 18"
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>
        </div>
        <AddCollectionForm class="mb-4" v-if="showForm" />
    </div>
    <div class="flex flex-col gap-1 p-2 border-b border-gray-400">
        <Link
            v-for="c in collections"
            :key="c.id"
            :class="c.id == collection?.id ? 'bg-gray-100' : ''"
            class="px-4 py-2 rounded-[8px] transition-colors text-left duration-300 hover:bg-gray-100"
            :href="
                c.id == collection?.id ? `/admin/files` : `/admin/files/${c.id}`
            "
        >
            <div class="flex justify-between">
                {{ c.title }}
                <span class="text-gray-300"> {{ c.files_count }}</span>
            </div>
        </Link>
    </div>
</template>

<script lang="ts" setup>
import { useForm } from '@macramejs/macrame-vue3';
import { Input } from '@macramejs/admin-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import { RadioGroup, RadioGroupOption } from '@headlessui/vue';
import { PropType, ref, computed } from 'vue';
import { FileCollection } from '@admin/modules/resources';
import AddCollectionForm from './AddCollectionForm.vue';
import { index } from '../modules';

const props = defineProps({
    collections: {
        type: Array as PropType<FileCollection[]>,
        required: true,
    },
    collection: {
        type: Object as PropType<FileCollection>,
        required: false,
    },
});

const showForm = ref(false);
</script>
