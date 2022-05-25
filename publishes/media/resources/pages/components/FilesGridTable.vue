<template>
    <div
        v-for="file in mediaIndex.items"
        :key="file.id"
        class="relative flex items-center justify-center cursor-pointer col-span-full md:col-span-6 xl:col-span-3 aspect-square"
    >
        <label class="w-full h-full img-container">
            <input
                type="checkbox"
                :id="file.id"
                class="absolute opacity-0"
                :value="file"
                v-model="selection.files"
            />
            <div
                class="absolute top-0 left-0 w-full cursor-pointer h-full bg-black border-[3px] border-transparent bg-opacity-0 hover:bg-opacity-80"
            >
                <div
                    class="absolute img-checkbox top-0 left-0 hidden items-center justify-center w-5 h-5 rounded-br-[6px] text-white bg-orange"
                >
                    <svg
                        width="24"
                        height="24"
                        class="scale-75 -translate-x-[3px] -translate-y-px"
                        stroke-width="1"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="m5 13 4 4L19 7"
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />
                    </svg>
                </div>
                <span
                    class="absolute hidden text-base text-white top-2 right-4"
                >
                    {{ file.author }}
                </span>
                <div class="absolute btn-wrapper hidden right-4 bottom-2.5">
                    <SelectionMenu
                        :selection="useSelection([file])"
                        :collections="collections"
                    >
                        <template #button><ContextButton /></template>
                    </SelectionMenu>
                </div>
            </div>
            <img
                v-if="file.url"
                class="object-contain w-full h-full pointer-events-none"
                :src="file.url"
            />
        </label>
    </div>
</template>

<script lang="ts" setup>
import { PropType } from 'vue';
import { ContextButton } from '@macramejs/admin-vue3';
import SelectionMenu from './SelectionMenu.vue';
import { selection, useSelection } from '../modules';
import { mediaIndex } from '@admin/modules/media';
import { MediaCollection } from '@admin/types/resources';

const props = defineProps({
    collections: {
        type: Array as PropType<MediaCollection[]>,
        required: true,
    },
});
</script>

<style scoped>
.tab-height {
    height: calc(100vh - 230px);
}

.img-container:hover .btn-wrapper,
.img-container:hover span {
    display: block !important;
}
.img-container > input:checked + div {
    border-color: #fead5e !important;
}
.img-container > input:checked + div > .img-checkbox {
    display: flex !important;
}
</style>
