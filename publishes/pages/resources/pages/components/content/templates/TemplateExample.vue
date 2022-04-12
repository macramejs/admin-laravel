<template>
    <Card>
        <Input label="Test" v-model="form.attributes.test" />
    </Card>
</template>

<script lang="ts" setup>
import { Card, Input } from '@macramejs/admin-vue3';
import { PageContentForm } from '@admin/types/forms';
import { PropType } from 'vue';

const props = defineProps({
    form: {
        type: Object as PropType<PageContentForm>,
        required: true,
    },
});
</script>
