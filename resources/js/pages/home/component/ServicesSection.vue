<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Code2, Cog, Layout, Mail, Target } from '@lucide/vue';
import type { Component } from 'vue';
import SectionShell from '@/layouts/app/SectionShell.vue';

defineProps<{
    services: Array<{ slug: string; title: string; description: string }>;
}>();

const iconBySlug: Record<string, Component> = {
    'lead-generation': Target,
    'email-marketing': Mail,
    'website-design-and-development': Layout,
    'business-automations': Cog,
    'custom-software-development': Code2,
};
</script>

<template>
    <SectionShell
        overline="What we do"
        heading="Everything you need to grow, in one place"
        intro="Pick what you need now. Add more as you grow. It all fits together."
        light
        wide
        centered
    >
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            <Link
                v-for="service in services"
                :key="service.slug"
                :href="`/services/${service.slug}`"
                class="marketing-card-hover group relative overflow-hidden rounded-xl border border-border-default bg-white p-6"
                :data-test="`home-service-${service.slug}`"
            >
                <div class="mb-4 flex size-12 items-center justify-center rounded-xl bg-brand-accent/10 text-brand-accent">
                    <component :is="iconBySlug[service.slug] ?? Target" class="size-5" />
                </div>
                <h3 class="text-lg font-semibold text-[var(--text-primary-on-light)]">
                    {{ service.title }}
                </h3>
                <p class="mt-2 line-clamp-2 text-sm text-[var(--text-muted-on-light)]">
                    {{ service.description }}
                </p>
                <span class="mt-4 inline-flex text-sm font-semibold text-brand-accent group-hover:underline">
                    Learn more →
                </span>
            </Link>
        </div>
    </SectionShell>
</template>
