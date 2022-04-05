<template>
    <Modal :open="true" v-bind="$attrs" md>
        <h2>Add Navigation Item</h2>
        <div>
            <Input label="Title" v-model="form.title" />
        </div>
        <Button @click="submit"> Save </Button>
    </Modal>
</template>

<script lang="ts" setup>
import { defineEmits, defineProps } from 'vue';
import { Modal, Input, Select, Button } from '@macramejs/admin-vue3';
import { useForm } from '@macramejs/macrame-vue3';

const props = defineProps({
    type: {
        type: String,
        required: true,
    },
});

const emit = defineEmits(['itemAdded', 'close']);

const form = useForm({
    route: `/{{ app }}/{{ route }}/${props.type}`,
    data: {
        title: '',
        route: '',
    },
    method: 'post',
    onSuccess() {
        emit('itemAdded', this);
        emit('close');
    },
});

const submit = function () {
    form.submit();
};
</script>
