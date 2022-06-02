<template>
    <div class="my-6 space-y-4">
        <SelectImage v-model="form.attributes.header" />
        <Input label="H1" v-model="form.attributes.h1" />
    </div>
    <slot />
</template>

<script lang="ts" setup>
import { Input } from '@macramejs/admin-vue3';
import { PageContentForm } from '@admin/types/forms';
import { PropType } from 'vue';
import SelectImage from '../sections/components/SelectImage.vue';

const props = defineProps({
    form: {
        type: Object as PropType<PageContentForm>,
        required: true,
    },
});
</script>
