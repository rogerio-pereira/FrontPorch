<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import CoreDeleteButton from '@/pages/core/component/CoreDeleteButton.vue';
import CoreIndexShell from '@/pages/core/component/CoreIndexShell.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Testimonials',
                href: '/core/testimonials',
            },
        ],
    },
});

defineProps<{
    testimonials: Array<{
        id: string;
        person: string;
        testimonial: string;
        service_id: string;
        service: {
            id: string;
            title: string;
        } | null;
    }>;
}>();
</script>

<template>
    <Head title="Testimonials" />

    <CoreIndexShell
        title="Testimonials"
        description="Quotes sampled on the home page and on service landings"
        create-href="/core/testimonials/create"
        create-label="New testimonial"
        create-test-id="testimonials-create"
    >
        <table class="w-full text-sm">
            <thead class="bg-muted/50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Person</th>
                    <th class="px-4 py-3 font-medium">Testimonial</th>
                    <th class="px-4 py-3 font-medium">Service</th>
                    <th class="px-4 py-3" />
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="testimonial in testimonials"
                    :key="testimonial.id"
                    class="border-t border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <td class="px-4 py-3 font-medium">{{ testimonial.person }}</td>
                    <td class="px-4 py-3 text-muted-foreground">{{ testimonial.testimonial }}</td>
                    <td class="px-4 py-3 text-muted-foreground">{{ testimonial.service?.title }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <Button as-child variant="ghost" size="sm">
                            <Link
                                :href="`/core/testimonials/${testimonial.id}/edit`"
                                :data-test="`testimonial-edit-${testimonial.id}`"
                            >
                                Edit
                            </Link>
                        </Button>
                        <CoreDeleteButton
                            :action="`/core/testimonials/${testimonial.id}`"
                            :test-id="`testimonial-delete-${testimonial.id}`"
                        />
                    </td>
                </tr>
                <tr v-if="testimonials.length === 0">
                    <td
                        class="px-4 py-6 text-center text-muted-foreground"
                        colspan="4"
                        data-test="testimonials-empty"
                    >
                        No testimonials yet.
                    </td>
                </tr>
            </tbody>
        </table>
    </CoreIndexShell>
</template>
