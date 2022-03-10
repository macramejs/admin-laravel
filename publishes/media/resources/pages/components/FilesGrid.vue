<template>
    <div class="w-full mt-10">
        <div class="grid grid-cols-12 gap-5">
            <div
                class="flex justify-center col-span-full md:col-span-6 xl:col-span-3"
            >
                <FileUpload :collection="collection" />
            </div>
            <FilesGridTable />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref, toRefs, watch } from 'vue';
import { Index } from '@macramejs/admin-vue3';
import FileMenu from './FileMenu.vue';
import { PropType } from 'vue';
import { index, updateCollectionFilter } from '../modules';
import { FileCollection } from '@admin/modules/resources';
import FilesGridTable from './FilesGridTable.vue';
import FileUpload from './FileUpload.vue';

const props = defineProps({
    collection: {
        type: Object as PropType<FileCollection>,
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
