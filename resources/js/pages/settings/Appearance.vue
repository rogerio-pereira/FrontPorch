<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { edit } from '@/routes/appearance';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Appearance settings',
                href: edit(),
            },
        ],
    },
});
</script>

<template>
    <Head title="Appearance settings" />

    <h1 class="sr-only">Appearance settings</h1>

    <div class="space-y-6">
        <Heading
            variant="small"
            title="Appearance settings"
            description="The admin panel uses the Front Porch dark brand theme"
        />
        <p
            class="text-sm text-muted-foreground"
            data-test="appearance-dark-only"
        >
            Light and system appearance preferences are not available in the CMS.
            The panel stays on the brand dark palette for consistency with the
            public site.
        </p>
    </div>
</template>
