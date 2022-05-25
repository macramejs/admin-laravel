<template>
    <div class="p-4">
        <Input v-model.debounce="mediaIndex.search" />
        <div class="pt-4">
            <Checkbox v-model="mediaIndex.filters.types.value" value="images">
                Images
            </Checkbox>
            <Checkbox
                v-model="mediaIndex.filters.types.value"
                value="documents"
            >
                Documents
            </Checkbox>
        </div>
    </div>
</template>
<script lang="ts" setup>
import { ContentSidebar, Input, Checkbox } from '@macramejs/admin-vue3';
import { mediaIndex } from '@admin/modules/media';

const props = defineProps();
</script>
