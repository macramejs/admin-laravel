<template>
    <form @submit.prevent="form.submit">
        <Input
            v-model="form.title"
            @keyup.enter="form.submit"
            placeholder="Enter new name"
        />
    </form>
</template>

<script lang="ts" setup>
import { useForm } from '@macramejs/macrame-vue3';
import { Input } from '@macramejs/admin-vue3';
import { FileCollection } from '@admin/modules/resources';

const form = useForm<FileCollection>(
    '/admin/files',
    { title: '' },
    {
        method: 'post',
        onSuccess: request => {
            form.reset();
        },
    }
);
</script>
