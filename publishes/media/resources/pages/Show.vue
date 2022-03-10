<template>
    <BaseLayout v-bind="$attrs" :collection="collection">
        <FilesTabs :collection="collection.data" />
    </BaseLayout>
</template>

<script lang="ts" setup>
import BaseLayout from './Index.vue';
import FilesTabs from './components/FilesTabs.vue';
import { PropType } from 'vue';
import { {{ model }}CollectionResource } from '@{{ app }}/types';
import { index } from './modules';

const props = defineProps({
    collection: {
        type: Object as PropType<{{ model }}CollectionResource>,
        requried: true,
    },
});
</script>
