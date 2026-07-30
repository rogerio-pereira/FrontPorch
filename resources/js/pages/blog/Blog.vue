<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import VisualFrame from '@/layouts/app/VisualFrame.vue';
import SitePagination, { type LaravelPaginator } from '@/layouts/app/SitePagination.vue';

export type BlogArticleListItem = {
    id: string;
    title: string;
    description: string;
    category: string;
    created_at: string;
    image: string;
    slug: string;
};

defineProps<{
    articles: LaravelPaginator<BlogArticleListItem>;
}>();
</script>

<template>
    <Head title="Blog | Front Porch Creative" />

    <section class="relative overflow-hidden bg-brand-bg text-[var(--text-on-dark)]">
        <DecorativeBackground variant="both" />
        <div class="section-y relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <VisualFrame
                    src="/images/blog/listing.png"
                    alt="Abstract preview for the Front Porch Creative blog"
                    aspect="video"
                />
                <div class="stack-loose">
                    <p class="text-overline text-brand-accent">
                        From the blog
                    </p>
                    <h1 class="text-h1 font-semibold" data-test="blog-heading">
                        Practical ideas for growing without the noise
                    </h1>
                    <p class="text-body-lg text-[var(--text-muted-on-dark)]">
                        Short reads for small business owners who want clearer websites, better follow-up, and less busywork.
                    </p>
                </div>
            </div>

            <div
                v-if="articles.data.length > 0"
                class="mt-14 grid gap-6 md:grid-cols-2 lg:grid-cols-3"
            >
                <Link
                    v-for="(article, index) in articles.data"
                    :key="article.id"
                    :href="`/blog/article/${article.slug}`"
                    class="marketing-card-hover group overflow-hidden rounded-xl border border-border-default bg-surface-raised text-left"
                    :data-test="`blog-article-${index}`"
                >
                    <VisualFrame
                        :src="article.image"
                        :alt="article.title"
                        aspect="video"
                        class="rounded-none border-0 shadow-none"
                    />
                    <div class="p-5">
                        <div class="flex flex-wrap items-center gap-3 text-xs text-[var(--text-subtle-on-dark)]">
                            <span class="rounded-sm border border-brand-accent/40 px-2 py-0.5 text-brand-accent">
                                {{ article.category }}
                            </span>
                            <span>{{ article.created_at }}</span>
                        </div>
                        <h2 class="mt-3 text-h4 font-semibold leading-snug group-hover:text-brand-accent">
                            {{ article.title }}
                        </h2>
                        <p class="mt-2 line-clamp-3 text-sm text-[var(--text-muted-on-dark)]">
                            {{ article.description }}
                        </p>
                    </div>
                </Link>
            </div>

            <div
                v-else
                class="mt-14 rounded-xl border border-border-default bg-surface-raised p-10 text-center"
                data-test="blog-empty"
            >
                <h2 class="text-h3 font-semibold">
                    Articles are on the way
                </h2>
                <p class="mx-auto mt-3 max-w-xl text-body text-[var(--text-muted-on-dark)]">
                    We are drafting the first posts. Check back soon, or book a discovery call if you want to talk through a topic now.
                </p>
            </div>

            <SitePagination
                :paginator="articles"
                test-id="blog-pagination"
            />

            <div class="mt-14 flex flex-col items-center gap-4 text-center">
                <p class="max-w-xl text-body text-[var(--text-muted-on-dark)]">
                    Prefer to talk it through? Book a discovery call and we will walk through your goals together.
                </p>
                <CtaButton
                    label="Book a discovery call"
                    test-id="blog-schedule"
                />
            </div>
        </div>
    </section>
</template>
