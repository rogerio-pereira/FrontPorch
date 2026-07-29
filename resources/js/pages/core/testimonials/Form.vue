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
                title: 'Testimonials',
                href: '/core/testimonials',
            },
        ],
    },
});

const props = defineProps<{
    testimonial: {
        id: string;
        person: string;
        testimonial: string;
        service_id: string;
        service: string | null;
    } | null;
    services: Array<{ id: string; title: string }>;
}>();

const action = computed(() => {
    if (props.testimonial === null) {
        return '/core/testimonials';
    }

    return `/core/testimonials/${props.testimonial.id}`;
});

const method = computed(() => {
    if (props.testimonial === null) {
        return 'post';
    }

    return 'put';
});

const title = computed(() => {
    if (props.testimonial === null) {
        return 'New testimonial';
    }

    return 'Edit testimonial';
});
</script>

<template>
    <Head :title="title" />

    <CoreFormShell
        :title="title"
        description="Every testimonial belongs to one service"
        back-href="/core/testimonials"
    >
        <Form
            :action="action"
            :method="method"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="person">Person</Label>
                <Input
                    id="person"
                    name="person"
                    :default-value="testimonial?.person"
                    required
                />
                <InputError :message="errors.person" />
            </div>

            <div class="grid gap-2">
                <Label for="testimonial">Testimonial</Label>
                <textarea
                    id="testimonial"
                    name="testimonial"
                    rows="5"
                    class="w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs outline-none focus-visible:border-ring"
                    required
                >{{ testimonial?.testimonial }}</textarea>
                <InputError :message="errors.testimonial" />
            </div>

            <div class="grid gap-2">
                <Label for="service_id">Service</Label>
                <select
                    id="service_id"
                    name="service_id"
                    class="h-9 w-full rounded-md border border-input bg-transparent px-3 text-sm shadow-xs outline-none focus-visible:border-ring"
                    required
                >
                    <option value="">Pick a service</option>
                    <option
                        v-for="service in services"
                        :key="service.id"
                        :value="service.id"
                        :selected="service.id === testimonial?.service_id"
                    >
                        {{ service.title }}
                    </option>
                </select>
                <InputError :message="errors.service_id" />
            </div>

            <Button
                type="submit"
                :disabled="processing"
                data-test="testimonial-submit"
            >
                Save
            </Button>
        </Form>
    </CoreFormShell>
</template>
