<template>
    <div>
        <span>Media</span>

        <Badge v-if="mediaIndex.filters.collection.value" class="ml-2">
            {{ mediaIndex.filters.collection.value }}
        </Badge>

        <Badge
            v-for="(type, key) in mediaIndex.filters.types.value"
            :key="key"
            class="ml-2"
        >
            {{ type }}
        </Badge>
    </div>
</template>

<script lang="ts" setup>
import { Badge } from '@macramejs/admin-vue3';
import { mediaIndex } from '@admin/modules/media';
</script>
