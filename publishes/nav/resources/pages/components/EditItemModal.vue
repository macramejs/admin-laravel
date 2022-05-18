<template>
    <slot name="button" :open="() => (isOpen = true)">
        <span @click="isOpen = true" @keyup.esc="isOpen = false">Edit </span>
    </slot>
    <Modal v-model:open="isOpen" md>
        <h2>Edit Navigation Item</h2>
        <div>
            <FormField>
                <Input label="Title" v-model="form.title" />
            </FormField>
            <FormField>
                <Select
                    v-if="routeItems"
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
    ContextButton,
} from '@macramejs/admin-vue3';
import { useForm } from '@macramejs/macrame-vue3';
import { useNavItemForm } from '@{{ app }}/modules/nav';
import { NavItem, RouteItem } from '@admin/types/resources';

const isOpen = ref<boolean>(false);

const props = defineProps({
    navItem: {
        type: Object as PropType<NavItem>,
        required: true,
    },
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
    route: `/{{ app }}/nav/${props.type}/${props.navItem.id}`,
    method: 'put',
    data: {
        title: props.navItem.title,
        route: props.navItem.route,
    },
    onSuccess() {
        emit('itemAdded', this);
        isOpen.value = false;
    },
});
</script>
