<template>
    <div class="w-full mt-10">
        <div class="mb-8">
            <FileUpload :collection="collection" />
        </div>
        <div>
            <Index :table="index">
                <Table :table="index">
                    <template v-slot:thead>
                        <FilesListTableHead :table="index" />
                    </template>
                    <template v-slot:tbody>
                        <FilesListTableBody :table="index" />
                    </template>
                </Table>
            </Index>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { FileCollection } from '@admin/modules/resources';
import { Index, Table } from '@macramejs/admin-vue3';
import { PropType } from 'vue';
import { index } from '../modules/index';
import FilesListTableBody from './FilesListTableBody.vue';
import FilesListTableHead from './FilesListTableHead.vue';
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
</style>
