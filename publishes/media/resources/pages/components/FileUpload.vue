<template>
    <FileUpload
        inline
        :url="url"
        @success="mediaIndex.reload()"
        multiple
        maxFiles="10"
    />
</template>

<script lang="ts" setup>
import { MediaCollection } from "@admin/types";
import { FileUpload } from "@macramejs/admin-vue3";
import { PropType } from "vue";
import { mediaIndex } from "@admin/modules/media";

const props = defineProps({
    collection: {
        type: Object as PropType<MediaCollection>,
        required: false,
    },
});

const url = props.collection
    ? `/admin/media/${props.collection.id}/upload`
    : `/admin/media/upload`;
</script>
