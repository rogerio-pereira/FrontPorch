<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import SectionShell from '@/layouts/app/SectionShell.vue';

defineProps<{
    services: Record<string, string>;
    light?: boolean;
}>();
</script>

<template>
    <SectionShell
        v-if="Object.keys(services).length > 0"
        overline="Also explore"
        heading="Other ways we can help"
        intro="Each service stands alone, and they work even better together."
        :light="light"
        wide
        centered
    >
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <Link
                v-for="(title, slug) in services"
                :key="slug"
                :href="`/services/${slug}`"
                :class="[
                    light ? 'bg-white hover:shadow-md' : 'bg-surface-raised hover:border-brand-accent/50',
                    'rounded-xl border border-border-default p-5 text-left transition hover:border-brand-accent/50',
                ]"
                :data-test="`service-related-${slug}`"
            >
                <h3
                    :class="light ? 'text-[var(--text-primary-on-light)]' : 'text-[var(--text-on-dark)]'"
                    class="font-semibold"
                >
                    {{ title }}
                </h3>
                <p class="mt-2 text-sm text-brand-accent">
                    Learn more →
                </p>
            </Link>
        </div>
    </SectionShell>
</template>
