<template>
    <div class="flex py-4">
        <div>Hi</div>
    </div>
</template>

<script lang="ts" setup>
import { Form } from '@macramejs/macrame-vue3';
import { Sections } from '@macramejs/admin-vue3';
import { defineProps, PropType } from 'vue';
import { templates } from './content/templates';
import { sections } from './content/sections';
import { {{ model }}Resource } from '@{{ app }}/types/resources';
import { {{ model }}MetaForm } from '@{{ app }}/types/forms';

const props = defineProps({
    page: {
        type: Object as PropType<{{ model }}Resource>,
        required: true,
    },
    form: {
        type: Object as PropType<{{ model }}MetaForm>,
        required: true,
    },
});
</script>
