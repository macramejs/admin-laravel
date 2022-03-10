<template>
    <div class="flex flex-col w-full h-full px-6 py-8">
        <TabGroup :defaultIndex="1">
            <TabList class="flex justify-end w-full gap-2">
                <Tab v-slot="{ selected }">
                    <button
                        class="p-1 transition-colors focus:outline-none focus:ring-4 focus:ring-orange-100 duration-300 rounded-[8px]"
                        :class="{
                            'bg-indigo-900 !text-white': selected,
                            'hover:bg-gray-200': !selected,
                        }"
                    >
                        <svg
                            width="24"
                            height="24"
                            stroke-width="1"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M8 6h12M4 6.01l.01-.011M4 12.01l.01-.011M4 18.01l.01-.011M8 12h12M8 18h12"
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </button>
                </Tab>
                <Tab v-slot="{ selected }">
                    <button
                        class="p-1 transition-colors focus:outline-none focus:ring-4 focus:ring-orange-100 duration-300 rounded-[8px]"
                        :class="{
                            'bg-indigo-900 !text-white': selected,
                            'hover:bg-gray-200': !selected,
                        }"
                    >
                        <svg
                            width="24"
                            height="24"
                            stroke-width="1"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M14 20.4v-5.8a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6h-5.8a.6.6 0 0 1-.6-.6ZM3 20.4v-5.8a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6H3.6a.6.6 0 0 1-.6-.6ZM14 9.4V3.6a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6h-5.8a.6.6 0 0 1-.6-.6ZM3 9.4V3.6a.6.6 0 0 1 .6-.6h5.8a.6.6 0 0 1 .6.6v5.8a.6.6 0 0 1-.6.6H3.6a.6.6 0 0 1-.6-.6Z"
                                stroke="currentColor"
                            />
                        </svg>
                    </button>
                </Tab>
            </TabList>
            <TabPanels>
                <TabPanel>
                    <FilesListTable :collection="collection" />
                </TabPanel>
                <TabPanel>
                    <FilesGrid :collection="collection" />
                </TabPanel>
            </TabPanels>
        </TabGroup>
    </div>
</template>

<script lang="ts" setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';
import FilesListTable from './FilesListTable.vue';
import FilesGrid from './FilesGrid.vue';
import { PropType } from 'vue';
import { FileCollection } from '@admin/modules/resources';

const props = defineProps({
    collection: {
        type: Object as PropType<FileCollection>,
        requried: true,
    },
});
</script>
