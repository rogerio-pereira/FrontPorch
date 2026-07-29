<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';
import SitePagination, { type SitePaginationState } from '@/layouts/app/SitePagination.vue';

export type PortfolioListItem = {
    id: string;
    title: string;
    excerpt: string;
    client: string;
    service: string;
    coverImage: string;
    href: string;
};

defineProps<{
    items: PortfolioListItem[];
    pagination: SitePaginationState;
}>();
</script>

<template>
    <Head title="Portfolio | Front Porch Creative" />

    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="glow" />
        <div class="section-y relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center stack-default">
                <p class="text-overline text-brand-accent">
                    Our work
                </p>
                <h1 class="text-h1 font-semibold" data-test="portfolio-heading">
                    Case studies that show the path from conversation to clarity
                </h1>
                <p class="text-body-lg text-[var(--text-muted-on-dark)]">
                    Real-feeling stories of how we help Central Florida businesses turn quiet websites into reliable growth systems.
                </p>
            </div>

            <div
                v-if="items.length > 0"
                class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-3"
            >
                <Link
                    v-for="(item, index) in items"
                    :key="item.id"
                    :href="item.href"
                    class="marketing-card-hover group overflow-hidden rounded-xl border border-border-default bg-surface-raised text-left"
                    :data-test="`portfolio-case-${index}`"
                >
                    <VisualFrame
                        :src="item.coverImage"
                        :alt="item.title"
                        aspect="video"
                        class="rounded-none border-0 shadow-none"
                    />
                    <div class="p-5">
                        <p class="text-overline text-brand-accent">
                            {{ item.service }}
                        </p>
                        <h2 class="mt-2 text-h4 font-semibold group-hover:text-brand-accent">
                            {{ item.title }}
                        </h2>
                        <p class="mt-2 text-sm text-[var(--text-muted-on-dark)]">
                            {{ item.client }}
                        </p>
                        <p class="mt-3 line-clamp-3 text-sm text-[var(--text-muted-on-dark)]">
                            {{ item.excerpt }}
                        </p>
                    </div>
                </Link>
            </div>

            <div
                v-else
                class="mt-12 rounded-xl border border-border-default bg-surface-raised p-10 text-center"
                data-test="portfolio-empty"
            >
                <h2 class="text-h3 font-semibold">
                    Case studies coming soon
                </h2>
                <p class="mx-auto mt-3 max-w-xl text-body text-[var(--text-muted-on-dark)]">
                    We are putting the finishing touches on our first public case studies. In the meantime, we would love to hear about your project.
                </p>
            </div>

            <SitePagination
                :pagination="pagination"
                test-id="portfolio-pagination"
            />

            <div class="mt-14 flex flex-col items-center gap-4 text-center">
                <p class="max-w-xl text-body text-[var(--text-muted-on-dark)]">
                    Have a project in mind? We would love to hear what you are working on.
                </p>
                <CtaButton
                    label="Book a discovery call"
                    test-id="portfolio-schedule"
                />
            </div>
        </div>
    </section>
</template>
