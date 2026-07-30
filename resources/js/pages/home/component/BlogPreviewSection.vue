<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import SectionShell from '@/layouts/app/SectionShell.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';

defineProps<{
    articles: Array<{ title: string; description: string; image: string }>;
}>();
</script>

<template>
    <SectionShell
        overline="From the blog"
        heading="Ideas worth sharing"
        intro="Helpful reads for small business owners, more articles are on the way."
        wide
        centered
    >
        <div class="grid gap-6 md:grid-cols-3">
            <article
                v-for="article in articles"
                :key="article.title"
                class="marketing-card-hover overflow-hidden rounded-xl border border-border-default bg-surface-raised text-left"
            >
                <VisualFrame
                    :src="article.image"
                    :alt="article.title"
                    aspect="video"
                    class="rounded-none border-0 shadow-none"
                />
                <div class="p-5">
                    <h3 class="font-semibold leading-snug">
                        {{ article.title }}
                    </h3>
                    <p class="mt-2 line-clamp-2 text-sm text-[var(--text-muted-on-dark)]">
                        {{ article.description }}
                    </p>
                </div>
            </article>
        </div>
        <div class="mt-8 text-center">
            <Link
                href="/blog"
                class="inline-flex text-sm font-semibold text-brand-accent hover:underline"
                data-test="home-blog-link"
            >
                View all articles
            </Link>
        </div>
    </SectionShell>
</template>
