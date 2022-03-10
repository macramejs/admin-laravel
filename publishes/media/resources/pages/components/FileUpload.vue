<template>
    <FileUpload
        inline
        :url="url"
        @success="index.reload()"
        multiple
        maxFiles="10"
    />
</template>

<script lang="ts" setup>
import { FileCollection } from '@admin/modules/resources';
import { FileUpload } from '@macramejs/admin-vue3';
import { PropType } from 'vue';
import { index } from '../modules';

const props = defineProps({
    collection: {
        type: Object as PropType<FileCollection>,
        required: false,
    },
});

const url = props.collection
    ? `/admin/files/${props.collection.id}/upload`
    : `/admin/files/upload`;
</script>
