<template>
    <div>
        <Button @click="init()">Link</Button>
        <Modal v-model:open="isOpen" sm>
            <div class="space-y-5 mb-4">
                <Input v-model="model.text" class="w-full" label="Linktext" />

                <div class="flex items-center space-x-2">
                    <span> Externer link </span><Toggle v-model="external" />
                </div>
                <Select
                    v-if="!external"
                    label="Link"
                    v-model="model.link"
                    :options="linkOptions.data"
                    label-key="title"
                    value-key="link"
                />

                <Input
                    v-else
                    v-model="model.link"
                    class="w-full"
                    label="Externer Link"
                />

                <div class="flex items-center space-x-2">
                    <span> In neuem Tab öffnen </span>
                    <Toggle v-model="model.new_tab" />
                </div>
            </div>
            <Button @click="submit()">Übernehmen</Button>
        </Modal>
    </div>
</template>

<script lang="ts" setup>
import { PropType, ref, watch } from "vue";
import { Input, Button, Modal, Select, Toggle } from "@macramejs/admin-vue3";
import { linkOptions } from "@admin/modules/links";

const emit = defineEmits(["update:modelValue"]);

interface Link {
    link: string;
    text: string;
    new_tab: string;
}

const props = defineProps({
    modelValue: {
        type: Object as PropType<Link>,
    },
});

const external = ref<boolean>(props.modelValue.link?.startsWith("http"));
watch(
    () => external.value,
    (val) => {
        model.value.link = null;
    }
);

const model = ref<Link>();
const isOpen = ref<boolean>(false);

const init = () => {
    model.value = props.modelValue;
    isOpen.value = true;
};

const submit = () => {
    emit("update:modelValue", model.value);
    isOpen.value = false;
};
</script>
