<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import CoreDeleteButton from '@/pages/core/component/CoreDeleteButton.vue';
import CoreIndexShell from '@/pages/core/component/CoreIndexShell.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Blog',
                href: '/core/blog/articles',
            },
        ],
    },
});

defineProps<{
    articles: Array<{
        id: string;
        title: string;
        slug: string;
        category: string;
        published_by: string;
    }>;
}>();
</script>

<template>
    <Head title="Blog articles" />

    <CoreIndexShell
        title="Blog articles"
        description="Everything published on the blog, newest first"
        create-href="/core/blog/articles/create"
        create-label="New article"
        create-test-id="articles-create"
    >
        <table class="w-full text-sm">
            <thead class="bg-muted/50 text-left">
                <tr>
                    <th class="px-4 py-3 font-medium">Title</th>
                    <th class="px-4 py-3 font-medium">Category</th>
                    <th class="px-4 py-3 font-medium">Published by</th>
                    <th class="px-4 py-3" />
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="article in articles"
                    :key="article.id"
                    class="border-t border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <td class="px-4 py-3 font-medium">{{ article.title }}</td>
                    <td class="px-4 py-3 text-muted-foreground">{{ article.category }}</td>
                    <td class="px-4 py-3 text-muted-foreground">{{ article.published_by }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <Button as-child variant="ghost" size="sm">
                            <Link
                                :href="`/core/blog/articles/${article.id}/edit`"
                                :data-test="`article-edit-${article.id}`"
                            >
                                Edit
                            </Link>
                        </Button>
                        <CoreDeleteButton
                            :action="`/core/blog/articles/${article.id}`"
                            :test-id="`article-delete-${article.id}`"
                        />
                    </td>
                </tr>
                <tr v-if="articles.length === 0">
                    <td
                        class="px-4 py-6 text-center text-muted-foreground"
                        colspan="4"
                        data-test="articles-empty"
                    >
                        No articles yet.
                    </td>
                </tr>
            </tbody>
        </table>
    </CoreIndexShell>
</template>
