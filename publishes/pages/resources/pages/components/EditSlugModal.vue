<template>
    <div
        class="ml-2 p-2 px-2 bg-white cursor-pointer relative inline-flex items-center justify-center text-sm uppercase transition-all duration-300 focus:ring focus:outline-none rounded"
        @click="isOpen = true"
    >
        <IconEditPencil />
    </div>
    <Modal lg v-model:open="isOpen" title="Edit Slug">
        <div class="space-y-3">
            <Input
                label="Slug"
                :modelValue="form.slug"
                @update:modelValue="slug => (form.slug = slugify(slug))"
                @keyup.enter="isOpen = false"
            />
        </div>
        <template #footer>
            <Button @click="isOpen = false">Ok</Button>
        </template>
    </Modal>
</template>

<script lang="ts" setup>
import { ref, PropType } from 'vue';
import { Modal, Input, Button, IconEditPencil } from '@macramejs/admin-vue3';
import { slugify } from '@admin/modules/helpers';
import { PageContentForm } from '@admin/types/forms';

const isOpen = ref<boolean>(false);

const props = defineProps({
    form: {
        type: Object as PropType<PageContentForm>,
        required: false,
    },
});
</script>
