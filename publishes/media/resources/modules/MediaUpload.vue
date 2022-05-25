<template>
    <FileUpload inline :url="url" @success="success" multiple :maxFiles="10" />
</template>

<script lang="ts" setup>
import { MediaCollection } from '@admin/types';
import { FileUpload } from '@macramejs/admin-vue3';
import { PropType } from 'vue';
import { mediaIndex } from '@admin/modules/media';

const emit = defineEmits(['uploaded']);

const props = defineProps({
    collection: {
        type: Object as PropType<MediaCollection>,
        required: false,
    },
});

const success = function () {
    mediaIndex.reload();
    emit('uploaded');
};

const url = props.collection
    ? `/admin/media/${props.collection.id}/upload`
    : `/admin/media/upload`;
</script>
