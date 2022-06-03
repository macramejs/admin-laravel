<template>
    <div>
        <Button @click="init()">Link</Button>
        <Modal v-model:open="isOpen" sm>
            <div class="space-y-5 mb-4">
                <Input v-model="model.text" class="w-full" label="Linktext" />
                <Select
                    label="Link"
                    v-model="model.link"
                    :options="linkOptions.data"
                    label-key="title"
                    value-key="link"
                />
            </div>
            <Button @click="submit()">Übernehmen</Button>
        </Modal>
    </div>
</template>

<script lang="ts" setup>
import { PropType, ref } from 'vue';
import { Input, Button, Modal, Select } from '@macramejs/admin-vue3';
import { linkOptions } from '@admin/modules/links';

const emit = defineEmits(['update:modelValue']);

interface Link {
    link: string;
    text: string;
    target: string;
}

const props = defineProps({
    modelValue: {
        type: Object as PropType<Link>,
    },
});

const model = ref<Link>();
const isOpen = ref<boolean>(false);

const init = () => {
    model.value = props.modelValue;
    isOpen.value = true;
};

const submit = () => {
    emit('update:modelValue', model.value);
    isOpen.value = false;
};
</script>
