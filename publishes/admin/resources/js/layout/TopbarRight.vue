<template>
    <div>
        <slot />
        <Button :disabled="!saveQueue.isDirty" @click="saveQueue.save()">
            Save
        </Button>
    </div>
</template>

<script lang="ts" setup>
import { Button } from '@macramejs/admin-vue3';
import { saveQueue, saveKeyboardShortcut } from '@admin/modules/save-queue';
saveKeyboardShortcut();
</script>
