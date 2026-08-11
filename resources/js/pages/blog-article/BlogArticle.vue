<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';

defineProps<{
    article: {
        title: string;
        description: string;
        category: string;
        created_at: string;
        published_by: string;
        image: string;
        content: string;
    };
}>();
</script>

<template>
    <Head :title="`${article.title} | Blog | Front Porch Creative`">
        <meta name="description" :content="article.description" />
        <meta property="og:title" :content="article.title" />
        <meta property="og:description" :content="article.description" />
        <meta property="og:image" :content="article.image" />
        <meta property="og:type" content="article" />
    </Head>

    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="glow" />
        <div class="section-y relative mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <Link
                href="/blog"
                class="inline-flex text-sm font-semibold text-brand-accent hover:underline"
                data-test="article-back"
            >
                Back to blog
            </Link>

            <div class="mt-8 stack-default">
                <div class="flex flex-wrap items-center gap-3 text-xs text-[var(--text-subtle-on-dark)]">
                    <span class="rounded-sm border border-brand-accent/40 px-2 py-0.5 text-brand-accent">
                        {{ article.category }}
                    </span>
                    <span>{{ article.created_at }}</span>
                    <span>{{ article.published_by }}</span>
                </div>
                <h1 class="text-h1 font-semibold" data-test="article-heading">
                    {{ article.title }}
                </h1>
                <p class="text-body-lg text-[var(--text-muted-on-dark)]">
                    {{ article.description }}
                </p>
            </div>

            <img
                :src="article.image"
                :alt="article.title"
                class="mt-8 aspect-video w-full rounded-xl border border-brand-accent/25 object-cover"
                data-test="article-visual"
            />
        </div>
    </section>

    <article class="bg-[var(--section-light-bg)] text-[var(--text-primary-on-light)]">
        <div class="section-y mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <div
                class="prose prose-lg max-w-none text-[var(--text-muted-on-light)] prose-headings:text-[var(--text-primary-on-light)] prose-a:text-[var(--text-accent-on-light)]"
                data-test="article-content"
                v-html="article.content"
            />

            <div class="mt-12 flex flex-col gap-3 border-t border-brand-accent/20 pt-10 sm:flex-row sm:items-center">
                <CtaButton
                    label="Book a discovery call"
                    test-id="article-schedule"
                />
                <Link
                    href="/blog"
                    class="inline-flex items-center text-sm font-semibold text-[var(--text-accent-on-light)] hover:underline"
                >
                    More articles
                </Link>
            </div>
        </div>
    </article>
</template>
