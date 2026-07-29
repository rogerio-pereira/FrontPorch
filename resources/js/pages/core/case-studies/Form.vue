<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { computed } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import CoreFormShell from '@/pages/core/component/CoreFormShell.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Case studies',
                href: '/core/case-studies',
            },
        ],
    },
});

const props = defineProps<{
    caseStudy: {
        id: string;
        title: string;
        slug: string;
        description: string;
        client: string;
        industry: string;
        challenge: string;
        content: string;
        services: string[];
        images: Array<{ id: string; url: string; alt: string }>;
    } | null;
    services: Array<{ id: string; title: string }>;
}>();

const action = computed(() => {
    if (props.caseStudy === null) {
        return '/core/case-studies';
    }

    return `/core/case-studies/${props.caseStudy.id}`;
});

const method = computed(() => {
    if (props.caseStudy === null) {
        return 'post';
    }

    return 'put';
});

const title = computed(() => {
    if (props.caseStudy === null) {
        return 'New case study';
    }

    return 'Edit case study';
});

function isSelected(serviceId: string): boolean {
    if (props.caseStudy === null) {
        return false;
    }

    return props.caseStudy.services.includes(serviceId);
}
</script>

<template>
    <Head :title="title" />

    <CoreFormShell
        :title="title"
        description="The first gallery image is used as the cover on listings"
        back-href="/core/case-studies"
    >
        <Form
            :action="action"
            :method="method"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="title">Title</Label>
                <Input
                    id="title"
                    name="title"
                    :default-value="caseStudy?.title"
                    required
                />
                <InputError :message="errors.title" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs outline-none focus-visible:border-ring"
                    required
                >{{ caseStudy?.description }}</textarea>
                <InputError :message="errors.description" />
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="grid gap-2">
                    <Label for="client">Client</Label>
                    <Input
                        id="client"
                        name="client"
                        :default-value="caseStudy?.client"
                        required
                    />
                    <InputError :message="errors.client" />
                </div>
                <div class="grid gap-2">
                    <Label for="industry">Industry</Label>
                    <Input
                        id="industry"
                        name="industry"
                        :default-value="caseStudy?.industry"
                        required
                    />
                    <InputError :message="errors.industry" />
                </div>
            </div>

            <div class="grid gap-2">
                <Label for="challenge">Challenge</Label>
                <textarea
                    id="challenge"
                    name="challenge"
                    rows="4"
                    class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs outline-none focus-visible:border-ring"
                    required
                >{{ caseStudy?.challenge }}</textarea>
                <InputError :message="errors.challenge" />
            </div>

            <div class="grid gap-2">
                <Label for="content">Content</Label>
                <textarea
                    id="content"
                    name="content"
                    rows="10"
                    class="w-full rounded-md border border-input bg-transparent px-3 py-2 font-mono text-sm shadow-xs outline-none focus-visible:border-ring"
                    required
                >{{ caseStudy?.content }}</textarea>
                <p class="text-sm text-muted-foreground">
                    HTML is allowed; paragraphs and blockquotes render on the public page.
                </p>
                <InputError :message="errors.content" />
            </div>

            <fieldset class="grid gap-2">
                <legend class="mb-2 text-sm font-medium">Services</legend>
                <label
                    v-for="service in services"
                    :key="service.id"
                    class="flex items-center gap-2 text-sm"
                >
                    <input
                        type="checkbox"
                        name="services[]"
                        :value="service.id"
                        :checked="isSelected(service.id)"
                        :data-test="`case-study-service-${service.id}`"
                    />
                    {{ service.title }}
                </label>
                <InputError :message="errors.services" />
            </fieldset>

            <div
                v-if="caseStudy && caseStudy.images.length > 0"
                class="grid gap-2"
            >
                <p class="text-sm font-medium">Current images</p>
                <label
                    v-for="image in caseStudy.images"
                    :key="image.id"
                    class="flex items-center gap-2 text-sm text-muted-foreground"
                >
                    <input
                        type="checkbox"
                        name="remove_images[]"
                        :value="image.id"
                        :data-test="`case-study-remove-image-${image.id}`"
                    />
                    Remove {{ image.alt }}
                </label>
            </div>

            <div class="grid gap-2">
                <Label for="images">Images</Label>
                <input
                    id="images"
                    type="file"
                    name="images[]"
                    multiple
                    accept="image/*"
                    class="text-sm"
                    data-test="case-study-images"
                />
                <InputError :message="errors.images" />
            </div>

            <Button
                type="submit"
                :disabled="processing"
                data-test="case-study-submit"
            >
                Save
            </Button>
        </Form>
    </CoreFormShell>
</template>
