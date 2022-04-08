<template>
    <Button
        round
        dark
        @click="isOpen = true"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="-4.5 -4.5 24 24"
            class="w-4 h-4 fill-white"
        >
            <path
                d="M8.9 6.9v-5a1 1 0 1 0-2 0v5h-5a1 1 0 1 0 0 2h5v5a1 1 0 1 0 2 0v-5h5a1 1 0 1 0 0-2h-5z"
            ></path>
        </svg>
    </Button>
    <Modal lg v-model:open="isOpen" title="New Page">
        <div class="space-y-3 ">
            <Input label="Name" v-model="form.name" />
            <Select
                label="Template"
                :options="templateOptions"
                v-model="form.template"

            />
        </div>
        <template v-slot:footer>
            <Button @click="submit"> Save </Button>
        </template>
    </Modal>
</template>

<script lang="ts" setup>
import { defineEmits, ref } from 'vue';
import { Modal, Input, Select, Button } from '@macramejs/admin-vue3';
import { useForm } from '@macramejs/macrame-vue3';
import { templateOptions } from './content/templates';

const isOpen = ref<boolean>(false);

const emit = defineEmits(['pageAdded', 'close']);

const form = useForm({
    route: `/{{ app }}/{{ route }}`,
    data: {
        name: '',
        template: '',
    },
    method: 'post',
    onSuccess() {
        emit('pageAdded', this);
        emit('close');
    },
});

const submit = function () {
    form.submit();
};
</script>
