<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';

defineProps<{
    action: string;
    testId: string;
}>();
</script>

<template>
    <Form
        :action="action"
        method="delete"
        class="inline"
        v-slot="{ processing }"
    >
        <Button
            type="submit"
            variant="ghost"
            size="sm"
            class="text-red-600 hover:text-red-700 dark:text-red-500"
            :disabled="processing"
            :data-test="testId"
        >
            Delete
        </Button>
    </Form>
</template>
