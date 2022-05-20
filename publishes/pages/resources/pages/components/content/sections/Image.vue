<template>
    <img :src="image?.url" class="w-full" v-if="image" />
</template>

<script lang="ts" setup>
import { getMediaById } from '@admin/modules/media';
import { Media } from '@admin/types';
import { defineProps, ref, onBeforeMount } from 'vue';

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
});

const image = ref<Media | null>(null);

onBeforeMount(async () => {
    image.value = await getMediaById(props.id);
});
</script>
