<template>
    <Card>
        <Input label="Test" v-model="form.attributes.test" />
    </Card>
</template>

<script lang="ts" setup>
import { ref, onBeforeMount } from 'vue';
import { Card, Input } from '@macramejs/admin-vue3';

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
});
</script>
