<template>
    <div class="w-full mt-10">
        <div class="mb-8">
            <FileUpload :collection="collection" />
        </div>
        <div>
            <Index :table="mediaIndex">
                <Table :table="mediaIndex">
                    <template v-slot:thead>
                        <FilesListTableHead :table="mediaIndex" />
                    </template>
                    <template v-slot:tbody>
                        <FilesListTableBody :table="mediaIndex" />
                    </template>
                </Table>
            </Index>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { {{ page }}Collection } from '@{{ app }}/types';
import { Index, Table } from '@macramejs/admin-vue3';
import { PropType } from 'vue';
import { mediaIndex } from './{{ app }}/modules/{{ name }}';
import FilesListTableBody from './FilesListTableBody.vue';
import FilesListTableHead from './FilesListTableHead.vue';
import FileUpload from './FileUpload.vue';

const props = defineProps({
    collection: {
        type: Object as PropType<{{ page }}Collection>,
    },
});
</script>

<style scoped>
.tab-height {
    height: calc(100vh - 230px);
}
</style>
