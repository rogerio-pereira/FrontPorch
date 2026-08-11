<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import CoreDeleteButton from '@/pages/core/component/CoreDeleteButton.vue';
import CoreIndexShell from '@/pages/core/component/CoreIndexShell.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Case studies',
                href: '/core/case-studies',
            },
        ],
    },
});

defineProps<{
    caseStudies: Array<{
        id: string;
        title: string;
        slug: string;
        client: string;
        industry: string;
        images: Array<{ id: string; url: string; alt: string }>;
    }>;
}>();
</script>

<template>
    <Head title="Case studies" />

    <CoreIndexShell
        title="Case studies"
        description="The portfolio shown on the site and in the home preview"
        create-href="/core/case-studies/create"
        create-label="New case study"
        create-test-id="case-studies-create"
    >
        <table class="w-full text-sm">
            <thead class="bg-muted/50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Title</th>
                    <th class="px-4 py-3 font-medium">Client</th>
                    <th class="px-4 py-3 font-medium">Images</th>
                    <th class="px-4 py-3" />
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="caseStudy in caseStudies"
                    :key="caseStudy.id"
                    class="border-t border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <td class="px-4 py-3 font-medium">{{ caseStudy.title }}</td>
                    <td class="px-4 py-3 text-muted-foreground">{{ caseStudy.client }}</td>
                    <td class="px-4 py-3 text-muted-foreground">{{ caseStudy.images.length }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <Button as-child variant="ghost" size="sm">
                            <Link
                                :href="`/core/case-studies/${caseStudy.id}/edit`"
                                :data-test="`case-study-edit-${caseStudy.id}`"
                            >
                                Edit
                            </Link>
                        </Button>
                        <CoreDeleteButton
                            :action="`/core/case-studies/${caseStudy.id}`"
                            :test-id="`case-study-delete-${caseStudy.id}`"
                        />
                    </td>
                </tr>
                <tr v-if="caseStudies.length === 0">
                    <td
                        class="px-4 py-6 text-center text-muted-foreground"
                        colspan="4"
                        data-test="case-studies-empty"
                    >
                        No case studies yet.
                    </td>
                </tr>
            </tbody>
        </table>
    </CoreIndexShell>
</template>
