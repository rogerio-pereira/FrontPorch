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
                title: 'FAQs',
                href: '/core/faqs',
            },
        ],
    },
});

const props = defineProps<{
    faq: {
        id: string;
        question: string;
        answer: string;
        sort_order: number;
        service_id: string | null;
        service: string | null;
    } | null;
    services: Array<{ id: string; title: string }>;
}>();

const action = computed(() => {
    if (props.faq === null) {
        return '/core/faqs';
    }

    return `/core/faqs/${props.faq.id}`;
});

const method = computed(() => {
    if (props.faq === null) {
        return 'post';
    }

    return 'put';
});

const title = computed(() => {
    if (props.faq === null) {
        return 'New FAQ';
    }

    return 'Edit FAQ';
});
</script>

<template>
    <Head :title="title" />

    <CoreFormShell
        :title="title"
        description="Leave the service empty to show the question on the home page"
        back-href="/core/faqs"
    >
        <Form
            :action="action"
            :method="method"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="question">Question</Label>
                <Input
                    id="question"
                    name="question"
                    :default-value="faq?.question"
                    required
                />
                <InputError :message="errors.question" />
            </div>

            <div class="grid gap-2">
                <Label for="answer">Answer</Label>
                <textarea
                    id="answer"
                    name="answer"
                    rows="6"
                    class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs outline-none focus-visible:border-ring"
                    required
                >{{ faq?.answer }}</textarea>
                <InputError :message="errors.answer" />
            </div>

            <div class="grid gap-2">
                <Label for="service_id">Service</Label>
                <select
                    id="service_id"
                    name="service_id"
                    class="h-9 w-full rounded-md border border-input bg-transparent px-3 text-sm shadow-xs outline-none focus-visible:border-ring"
                >
                    <option value="">Home page</option>
                    <option
                        v-for="service in services"
                        :key="service.id"
                        :value="service.id"
                        :selected="service.id === faq?.service_id"
                    >
                        {{ service.title }}
                    </option>
                </select>
                <InputError :message="errors.service_id" />
            </div>

            <div class="grid gap-2">
                <Label for="sort_order">Sort order</Label>
                <Input
                    id="sort_order"
                    name="sort_order"
                    type="number"
                    min="0"
                    :default-value="faq?.sort_order ?? 0"
                    required
                />
                <InputError :message="errors.sort_order" />
            </div>

            <Button
                type="submit"
                :disabled="processing"
                data-test="faq-submit"
            >
                Save
            </Button>
        </Form>
    </CoreFormShell>
</template>
