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
                    label="Route"
                    v-model="form.route"
                    :options="routeItems"
                    label-key="title"
                    value-key="name"
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
import { RouteItem } from '@{{ app }}/types/resources';
import { useNavItemForm } from '@{{ app }}/modules/nav';

const isOpen = ref<boolean>(false);

const props = defineProps({
    type: {
        type: String,
        required: true,
    },
    routeItems: {
        type: Object as PropType<RouteItem[]>,
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
