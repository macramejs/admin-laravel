<template>
    <div>
        <slot />
        <Button :disabled="!saveQueue.isDirty" @click="saveQueue.save()">
            Save
        </Button>
    </div>
</template>

<script setup lang="ts">
import { Button } from '@macramejs/admin-vue3';
import { saveQueue } from '@admin/modules/save-queue';
</script>
