<template>
    <slot name="button" :open="() => (isOpen = true)">
        <IconDuplicatePage class="w-4 h-4"></IconDuplicatePage>
    </slot>
    <Modal lg v-model:open="isOpen" title="Duplicate Page">
        <form @submit.prevent="form.submit">
            <div class="space-y-3">
                <Input label="New Page Name" v-model="form.name" />
            </div>
            <input type="submit" class="hidden" />
        </form>
        <template v-slot:footer>
            <Button @click="form.submit"> Duplizieren </Button>
        </template>
    </Modal>
</template>

<script lang="ts" setup>
import { ref, PropType } from 'vue';
import { Modal, Input, Button } from '@macramejs/admin-vue3';
import { useForm } from '@macramejs/macrame-vue3';
import { Page } from '@admin/types/resources';
import { Inertia } from '@inertiajs/inertia';

const isOpen = ref<boolean>(false);

const props = defineProps({
    page: {
        type: Object as PropType<Page>,
        required: true,
    },
});

const form = useForm({
    route: `/admin/pages/${props.page.id}/duplicate`,
    data: {
        name: props.page.name,
    },
    method: 'post',
    onSuccess(response) {
        isOpen.value = false;
        form.reset();

        // // Visit the recently created page, to refresh the Page/Show component
        // // when currently already on a page.
        Inertia.visit(`/admin/pages/${response.props.page.data.id}`, {
            only: ['page'],
        });
    },
});
</script>
