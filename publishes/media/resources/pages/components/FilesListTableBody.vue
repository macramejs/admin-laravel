<template>
    <Tr v-for="(file, trKey) in table.items" :key="`th-${trKey}`">
        <Td slim>
            <div class="h-[50px] w-[50px]">
                <img
                    v-if="file.mimetype.includes('image')"
                    :src="file.url"
                    alt=""
                    class="object-contain w-full h-full"
                />
                <div
                    v-else
                    class="flex items-center justify-center object-contain w-full h-full rounded-[8px] bg-gray-200"
                >
                    <svg
                        width="24"
                        height="24"
                        stroke-width="1"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M4 21.4V2.6a.6.6 0 0 1 .6-.6h11.652a.6.6 0 0 1 .424.176l3.148 3.148A.6.6 0 0 1 20 5.75V21.4a.6.6 0 0 1-.6.6H4.6a.6.6 0 0 1-.6-.6Z"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                        <path
                            d="M16 5.4V2.354a.354.354 0 0 1 .604-.25l3.292 3.292a.353.353 0 0 1-.25.604H16.6a.6.6 0 0 1-.6-.6Z"
                            fill="currentColor"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>
            </div>
        </Td>
        <Td> {{ file.filename }} </Td>
        <Td> {{ file.size }} Bytes</Td>
        <Td slim> {{ file.created_at }} </Td>
        <Td class="flex justify-end">
            <FileMenu />
        </Td>
    </Tr>
</template>

<script setup lang="ts">
import { PropType } from 'vue';
import { FileIndex } from '../modules/index';
import { Tr, Td } from '@macramejs/admin-vue3';
import FileMenu from './FileMenu.vue';

defineProps({
    table: Object as PropType<FileIndex>,
});
</script>
s
