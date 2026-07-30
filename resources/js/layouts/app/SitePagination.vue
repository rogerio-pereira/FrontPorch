<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

export type LaravelPaginator<T> = {
    data: T[];
    current_page: number;
    last_page: number;
    prev_page_url: string | null;
    next_page_url: string | null;
};

defineProps<{
    paginator: LaravelPaginator<unknown>;
    testId: string;
}>();
</script>

<template>
    <nav
        v-if="paginator.last_page > 1"
        class="mt-10 flex items-center justify-center gap-4 text-sm"
        :data-test="testId"
    >
        <Link
            v-if="paginator.prev_page_url"
            :href="paginator.prev_page_url"
            class="font-semibold text-brand-accent hover:underline"
            :data-test="`${testId}-previous`"
        >
            Previous
        </Link>
        <span class="text-[var(--text-muted-on-dark)]">
            Page {{ paginator.current_page }} of {{ paginator.last_page }}
        </span>
        <Link
            v-if="paginator.next_page_url"
            :href="paginator.next_page_url"
            class="font-semibold text-brand-accent hover:underline"
            :data-test="`${testId}-next`"
        >
            Next
        </Link>
    </nav>
</template>
