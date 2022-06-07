<template>
    <SidebarSecondaryHeader title="Collections">
        <ButtonRound white sm @click="emit('update:showForm', !showForm)">
            <IconPlus class="w-4 h-4" />
        </ButtonRound>
    </SidebarSecondaryHeader>
</template>

<script lang="ts" setup>
import {
    SidebarSecondaryHeader,
    ButtonRound,
    IconPlus,
} from '@macramejs/admin-vue3';

const emit = defineEmits(['update:showForm']);

defineProps({
    showForm: {
        type: Boolean,
        required: true,
    },
});
</script>
