<template>
    <div class="flex py-4">
        <div class="container">
            <component
                v-if="page.template in templates"
                :is="templates[page.template]"
                :form="form"
            />
            <Sections v-model="form.content" :sections="sections" />
        </div>
    </div>
</template>

<script lang="ts" setup>
import { Form } from '@macramejs/macrame-vue3';
import { Sections } from '@macramejs/admin-vue3';
import { defineProps, PropType } from 'vue';
import { templates } from './content/templates';
import { sections } from './content/sections';
import { {{ model }}Resource } from '@{{ app }}/types/resources';
import { {{ model }}ContentForm } from '@{{ app }}/types/forms';

const props = defineProps({
    page: {
        type: Object as PropType<{{ model }}Resource>,
        required: true,
    },
    form: {
        type: Object as PropType<{{ model }}ContentForm>,
        required: true,
    },
});
</script>
