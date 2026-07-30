<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import SectionShell from '@/layouts/app/SectionShell.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';

defineProps<{
    caseStudies: Array<{
        title: string;
        description: string;
        images: Array<{ url: string; alt: string }>;
    }>;
}>();
</script>

<template>
    <SectionShell
        v-if="caseStudies.length > 0"
        overline="Our work"
        heading="A few projects we are proud of"
        intro="Real-feeling stories of how we help small businesses turn quiet websites into reliable growth systems."
        wide
        centered
    >
        <template #background>
            <div class="marketing-grid-bg absolute inset-0 opacity-20" />
        </template>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <article
                v-for="caseStudy in caseStudies"
                :key="caseStudy.title"
                class="marketing-card-hover overflow-hidden rounded-xl border border-border-default bg-surface-raised"
            >
                <VisualFrame
                    :src="caseStudy.images[0].url"
                    :alt="caseStudy.images[0].alt"
                    aspect="video"
                    class="rounded-none border-0 shadow-none"
                />
                <div class="p-4">
                    <h3 class="font-semibold">
                        {{ caseStudy.title }}
                    </h3>
                    <p class="mt-1 line-clamp-2 text-sm text-[var(--text-muted-on-dark)]">
                        {{ caseStudy.description }}
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
