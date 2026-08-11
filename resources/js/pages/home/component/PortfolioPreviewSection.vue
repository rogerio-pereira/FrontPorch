<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import SectionShell from '@/layouts/app/SectionShell.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';

export type HomeCaseStudy = {
    title: string;
    description: string;
    slug: string;
    images: Array<{ url: string; alt: string }>;
    services: Array<{ title: string }>;
};

defineProps<{
    caseStudies: Array<HomeCaseStudy>;
}>();

function serviceTitles(caseStudy: HomeCaseStudy): string {
    return caseStudy.services
        .map((service) => service.title)
        .join(', ');
}
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
            <Link
                v-for="(caseStudy, index) in caseStudies"
                :key="caseStudy.slug"
                :href="`/portfolio/study-case/${caseStudy.slug}`"
                class="marketing-card-hover group overflow-hidden rounded-xl border border-border-default bg-surface-raised text-left"
                :data-test="`home-portfolio-case-${index}`"
            >
                <VisualFrame
                    :src="caseStudy.images[0].url"
                    :alt="caseStudy.images[0].alt"
                    aspect="video"
                    class="rounded-none border-0 shadow-none"
                />
                <div class="p-4">
                    <p
                        v-if="caseStudy.services.length > 0"
                        class="text-overline text-brand-accent"
                        :data-test="`home-portfolio-case-services-${index}`"
                    >
                        {{ serviceTitles(caseStudy) }}
                    </p>
                    <h3 class="mt-2 font-semibold group-hover:text-brand-accent">
                        {{ caseStudy.title }}
                    </h3>
                    <p class="mt-1 line-clamp-2 text-sm text-[var(--text-muted-on-dark)]">
                        {{ caseStudy.description }}
                    </p>
                </div>
            </Link>
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
