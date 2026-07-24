<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import SectionShell from '@/layouts/app/SectionShell.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';

const articles = [
    {
        title: 'Your website works when you are not',
        description: 'Most customers look you up before they call. Here is how to make that first impression count.',
        image: '/images/home/blog-website.png',
    },
    {
        title: 'Getting more inquiries from people who are actually interested',
        description: 'A simple way to think about turning online attention into real conversations.',
        image: '/images/home/blog-inquiries.png',
    },
    {
        title: 'Small automations that save big chunks of time',
        description: 'Start with the tasks you do every week, the relief is often immediate.',
        image: '/images/home/blog-automations.png',
    },
];
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
