<template>
    <div class="my-6">
        <Input label="H1" v-model="form.attributes.h1" />
    </div>
    <slot />
</template>

<script lang="ts" setup>
import { Input } from "@macramejs/admin-vue3";
import { PageContentForm } from "@admin/types/forms";
import { PropType } from "vue";

const props = defineProps({
    form: {
        type: Object as PropType<PageContentForm>,
        required: true,
    },
});
</script>
