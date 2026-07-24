<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import SectionShell from '@/layouts/app/SectionShell.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';
defineProps<{
    // TODO: remove demo portfolio preview in HomeController once CaseStudy listings exist
    items: Array<{ title: string; description: string; image: string }>;
}>();
</script>

<template>
    <SectionShell
        overline="Our work"
        heading="Case studies coming soon"
        intro="We are a new agency, and our public case studies are still taking shape. Until then, here is the kind of work we love doing with small businesses."
        wide
        centered
    >
        <template #background>
            <div class="marketing-grid-bg absolute inset-0 opacity-20" />
        </template>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <article
                v-for="item in items"
                :key="item.title"
                class="marketing-card-hover overflow-hidden rounded-xl border border-border-default bg-surface-raised"
            >
                <VisualFrame
                    :src="item.image"
                    :alt="item.title"
                    aspect="video"
                    class="rounded-none border-0 shadow-none"
                />
                <div class="p-4">
                    <h3 class="font-semibold">
                        {{ item.title }}
                    </h3>
                    <p class="mt-1 line-clamp-2 text-sm text-[var(--text-muted-on-dark)]">
                        {{ item.description }}
                    </p>
                </div>
            </article>
        </div>

        <div class="mt-8 text-center">
            <Link
                href="/portfolio"
                class="inline-flex items-center gap-2 rounded-full border border-brand-accent/40 px-5 py-2 text-sm font-semibold text-brand-accent hover:bg-brand-accent/10"
                data-test="home-portfolio-link"
            >
                See full portfolio
            </Link>
        </div>
    </SectionShell>
</template>
