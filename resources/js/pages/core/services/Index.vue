<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import CoreDeleteButton from '@/pages/core/component/CoreDeleteButton.vue';
import CoreIndexShell from '@/pages/core/component/CoreIndexShell.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Services',
                href: '/core/services',
            },
        ],
    },
});

defineProps<{
    services: Array<{
        id: string;
        title: string;
        description: string;
        slug: string;
        sort_order: number;
    }>;
}>();
</script>

<template>
    <Head title="Services" />

    <CoreIndexShell
        title="Services"
        description="The catalog shown on the home page and in the navigation"
        create-href="/core/services/create"
        create-label="New service"
        create-test-id="services-create"
    >
        <table class="w-full text-sm">
            <thead class="bg-muted/50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Sort order</th>
                    <th class="px-4 py-3 font-medium">Title</th>
                    <th class="px-4 py-3 font-medium">Slug</th>
                    <th class="px-4 py-3" />
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="service in services"
                    :key="service.id"
                    class="border-t border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <td class="px-4 py-3 text-muted-foreground">{{ service.sort_order }}</td>
                    <td class="px-4 py-3 font-medium">{{ service.title }}</td>
                    <td class="px-4 py-3 text-muted-foreground">{{ service.slug }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <Button as-child variant="ghost" size="sm">
                            <Link
                                :href="`/core/services/${service.id}/edit`"
                                :data-test="`service-edit-${service.id}`"
                            >
                                Edit
                            </Link>
                        </Button>
                        <CoreDeleteButton
                            :action="`/core/services/${service.id}`"
                            :test-id="`service-delete-${service.id}`"
                        />
                    </td>
                </tr>
                <tr v-if="services.length === 0">
                    <td
                        class="px-4 py-6 text-center text-muted-foreground"
                        colspan="4"
                        data-test="services-empty"
                    >
                        No services yet.
                    </td>
                </tr>
            </tbody>
        </table>
    </CoreIndexShell>
</template>
