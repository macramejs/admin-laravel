<template>
    <form @submit.prevent="form.submit">
        <Input
            v-model="form.title"
            @keyup.enter="form.submit"
            placeholder="Enter new name"
            class="!text-gray-100"
        />
    </form>
</template>

<script lang="ts" setup>
import { useForm } from '@macramejs/macrame-vue3';
import { Input } from '@macramejs/admin-vue3';
import { MediaCollection } from '@admin/types';

const form = useForm<MediaCollection>({
    route: '/admin/media',
    data: { title: '' },
    method: 'post',
    onSuccess: request => {
        form.reset();
    },
});
</script>
