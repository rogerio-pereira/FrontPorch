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
                title: 'Services',
                href: '/core/services',
            },
        ],
    },
});

const props = defineProps<{
    service: {
        id: string;
        title: string;
        description: string;
        slug: string;
        sort_order: number;
    } | null;
}>();

const action = computed(() => {
    if (props.service === null) {
        return '/core/services';
    }

    return `/core/services/${props.service.id}`;
});

const method = computed(() => {
    if (props.service === null) {
        return 'post';
    }

    return 'put';
});

const title = computed(() => {
    if (props.service === null) {
        return 'New service';
    }

    return 'Edit service';
});
</script>

<template>
    <Head :title="title" />

    <CoreFormShell
        :title="title"
        description="The slug is generated from the title"
        back-href="/core/services"
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
                    :default-value="service?.title"
                    required
                />
                <InputError :message="errors.title" />
                <InputError :message="errors.slug" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input
                    id="description"
                    name="description"
                    :default-value="service?.description"
                    required
                />
                <InputError :message="errors.description" />
            </div>

            <div class="grid gap-2">
                <Label for="sort_order">Sort order</Label>
                <Input
                    id="sort_order"
                    name="sort_order"
                    type="number"
                    min="0"
                    :default-value="service?.sort_order ?? 0"
                    required
                />
                <InputError :message="errors.sort_order" />
            </div>

            <Button
                type="submit"
                :disabled="processing"
                data-test="service-submit"
            >
                Save
            </Button>
        </Form>
    </CoreFormShell>
</template>
