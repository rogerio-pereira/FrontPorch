<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import CoreDeleteButton from '@/pages/core/component/CoreDeleteButton.vue';
import CoreIndexShell from '@/pages/core/component/CoreIndexShell.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'FAQs',
                href: '/core/faqs',
            },
        ],
    },
});

defineProps<{
    faqs: Array<{
        id: string;
        question: string;
        answer: string;
        sort_order: number;
        service_id: string | null;
        service: {
            id: string;
            title: string;
        } | null;
    }>;
}>();
</script>

<template>
    <Head title="FAQs" />

    <CoreIndexShell
        title="FAQs"
        description="Questions answered on the home page and on service landings"
        create-href="/core/faqs/create"
        create-label="New FAQ"
        create-test-id="faqs-create"
    >
        <table class="w-full text-sm">
            <thead class="bg-muted/50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Sort order</th>
                    <th class="px-4 py-3 font-medium">Question</th>
                    <th class="px-4 py-3 font-medium">Service</th>
                    <th class="px-4 py-3" />
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="faq in faqs"
                    :key="faq.id"
                    class="border-t border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <td class="px-4 py-3 text-muted-foreground">{{ faq.sort_order }}</td>
                    <td class="px-4 py-3 font-medium">{{ faq.question }}</td>
                    <td class="px-4 py-3 text-muted-foreground">{{ faq.service?.title ?? 'Home' }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <Button as-child variant="ghost" size="sm">
                            <Link
                                :href="`/core/faqs/${faq.id}/edit`"
                                :data-test="`faq-edit-${faq.id}`"
                            >
                                Edit
                            </Link>
                        </Button>
                        <CoreDeleteButton
                            :action="`/core/faqs/${faq.id}`"
                            :test-id="`faq-delete-${faq.id}`"
                        />
                    </td>
                </tr>
                <tr v-if="faqs.length === 0">
                    <td
                        class="px-4 py-6 text-center text-muted-foreground"
                        colspan="4"
                        data-test="faqs-empty"
                    >
                        No FAQs yet.
                    </td>
                </tr>
            </tbody>
        </table>
    </CoreIndexShell>
</template>
