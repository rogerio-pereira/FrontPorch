<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import InputError from '@/components/InputError.vue';
import RichTextEditor from '@/components/RichTextEditor.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import CoreFormShell from '@/pages/core/component/CoreFormShell.vue';

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

const props = defineProps<{
    article: {
        id: string;
        title: string;
        slug: string;
        description: string;
        category: string;
        content: string;
        image: string;
        published_by: string;
    } | null;
}>();

const action = computed(() => {
    if (props.article === null) {
        return '/core/blog/articles';
    }

    return `/core/blog/articles/${props.article.id}`;
});

const method = computed(() => {
    if (props.article === null) {
        return 'post';
    }

    return 'put';
});

const title = computed(() => {
    if (props.article === null) {
        return 'New article';
    }

    return 'Edit article';
});
</script>

<template>
    <Head :title="title" />

    <CoreFormShell
        :title="title"
        description="The slug and the author are filled in automatically"
        back-href="/core/blog/articles"
    >
        <Form
            :action="action"
            :method="method"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="grid gap-2">
                    <Label for="title">Title</Label>
                    <Input
                        id="title"
                        name="title"
                        :default-value="article?.title"
                        required
                    />
                    <InputError :message="errors.title" />
                </div>
                <div class="grid gap-2">
                    <Label for="category">Category</Label>
                    <Input
                        id="category"
                        name="category"
                        :default-value="article?.category"
                        required
                    />
                    <InputError :message="errors.category" />
                </div>
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs outline-none focus-visible:border-ring"
                    required
                >{{ article?.description }}</textarea>
                <InputError :message="errors.description" />
            </div>

            <div class="grid gap-2">
                <Label for="content">Content</Label>
                <RichTextEditor
                    id="content"
                    name="content"
                    directory="blog"
                    :default-value="article?.content ?? ''"
                    required
                    placeholder="Write the article body…"
                />
                <InputError :message="errors.content" />
            </div>

            <div class="grid gap-2">
                <Label for="image">Image</Label>
                <img
                    v-if="article"
                    :src="article.image"
                    :alt="article.title"
                    class="max-w-xs rounded-md border border-sidebar-border/70"
                />
                <input
                    id="image"
                    type="file"
                    name="image"
                    accept="image/*"
                    class="text-sm"
                    :required="article === null"
                    data-test="article-image"
                />
                <p v-if="article" class="text-sm text-muted-foreground">
                    Leave empty to keep the current image.
                </p>
                <InputError :message="errors.image" />
            </div>

            <Button
                type="submit"
                :disabled="processing"
                data-test="article-submit"
            >
                Save
            </Button>
        </Form>
    </CoreFormShell>
</template>
