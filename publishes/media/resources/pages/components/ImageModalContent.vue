<template>
    <Index :table="allFiles" :isTable="false">
        <div class="grid grid-cols-12 gap-5">
            <div
                class="flex items-center justify-center col-span-full lg:col-span-6 xl:col-span-3"
            >
                <div
                    class="flex items-center justify-center h-[200px] w-[200px]"
                >
                    <FileUpload
                        :url="url"
                        @success="reload"
                        multiple
                        maxFiles="10"
                    />
                </div>
            </div>
            <div
                v-for="file in allFiles.items"
                class="flex items-center justify-center cursor-pointer col-span-full lg:col-span-6 xl:col-span-3"
            >
                <label
                    class="relative flex justify-center items-center img-container h-[200px] w-[200px] xl:h-[200px] xl:w-[200px]"
                >
                    <input
                        type="checkbox"
                        :id="file.id"
                        class="absolute opacity-0"
                        :value="file"
                        v-model="selected"
                    />
                    <div
                        class="absolute top-0 left-0 w-full z-10 cursor-pointer h-full bg-black border-[3px] border-transparent bg-opacity-0 hover:bg-opacity-80"
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
                            class="absolute hidden text-sm max-w-[150px] text-white truncate top-2 right-4"
                            >{{ file.filename }}
                        </span>
                        <div
                            class="absolute btn-wrapper hidden right-4 bottom-2.5"
                        >
                            <FileMenu />
                        </div>
                    </div>
                    <img
                        v-if="file.mimetype.includes('image')"
                        class="z-0 object-contain w-full h-full"
                        :src="file.url"
                    />
                    <div
                        v-else
                        class="flex items-center justify-center w-[200px] h-[200px] rounded-[8px] bg-gray-200"
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
                </label>
            </div>
        </div>
    </Index>
</template>

<script lang="ts" setup>
import { ref, toRefs, watch } from 'vue';
import { FileUpload, Index } from '@macramejs/admin-vue3';
import FileMenu from './FileMenu.vue';
import { index } from '../modules/index';

const emit = defineEmits(['update:modelValue']);

const props = defineProps({
    modelValue: {
        type: Array,
    },

    url: {
        type: String,
        default: '/admin/files',
    },
});

index.loadItems();

const reload = () => {
    index.reload();
};

const selected = ref([]);
const { modelValue } = toRefs(props);

watch(modelValue, () => {
    selected.value = modelValue.value;
});

watch(selected, () => {
    emit('update:modelValue', selected.value);
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
