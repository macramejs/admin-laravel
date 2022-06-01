<template>
    <Button square secondary @click="isOpen = true" @keyup.esc="isOpen = false">
        <IconPlus class="w-5 h-5" />
    </Button>
    <Modal :open="isOpen" @close="isOpen = false" v-bind="$attrs" md>
        <h2>Add Navigation Item</h2>
        <div>
            <FormField>
                <Input label="Title" v-model="form.title" />
            </FormField>
            <FormField>
                <Select
                    label="Link"
                    v-model="form.link"
                    :options="linkOptions"
                    label-key="title"
                    value-key="link"
                />
            </FormField>
        </div>
        <Button @click="form.submit()"> Save </Button>
    </Modal>
</template>

<script lang="ts" setup>
import { defineEmits, defineProps, PropType, ref } from 'vue';
import {
    Modal,
    Input,
    Select,
    Button,
    FormField,
    IconPlus,
} from '@macramejs/admin-vue3';
import { useForm } from '@macramejs/macrame-vue3';
import { LinkOption } from '@admin/types/resources';
import { useNavItemForm } from '@admin/modules/nav';

const isOpen = ref<boolean>(false);

const props = defineProps({
    type: {
        type: String,
        required: true,
    },
    linkOptions: {
        required: true,
        type: Array as PropType<LinkOption[]>,
    },
});

const emit = defineEmits(['itemAdded']);

const form = useNavItemForm(props.type, {
    onSuccess() {
        emit('itemAdded', this);
        isOpen.value = false;
    },
});
</script>
