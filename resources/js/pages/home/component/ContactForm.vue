<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const page = usePage();

const turnstileSiteKey = computed(() => {
    return page.props.site.turnstileSiteKey ?? '';
});

const turnstileTesting = computed(() => {
    return page.props.site.turnstileTesting === true;
});
</script>

<template>
    <Form
        action="/contact"
        method="post"
        class="stack-default w-full text-left"
        data-test="contact-form"
        v-slot="{ errors, processing }"
    >
        <div class="grid gap-2">
            <Label for="contact-name">Name</Label>
            <Input
                id="contact-name"
                name="name"
                type="text"
                required
                autocomplete="name"
                placeholder="Your name"
                data-test="contact-name"
            />
            <InputError :message="errors.name" />
        </div>

        <div class="grid gap-2">
            <Label for="contact-email">Email</Label>
            <Input
                id="contact-email"
                name="email"
                type="email"
                required
                autocomplete="email"
                placeholder="you@example.com"
                data-test="contact-email"
            />
            <InputError :message="errors.email" />
        </div>

        <div class="grid gap-2">
            <Label for="contact-phone">
                Phone
                <span class="font-normal text-[var(--text-muted-on-light)]">(optional)</span>
            </Label>
            <Input
                id="contact-phone"
                name="phone"
                type="tel"
                autocomplete="tel"
                placeholder="(555) 555-5555"
                data-test="contact-phone"
            />
            <InputError :message="errors.phone" />
        </div>

        <div class="grid gap-2">
            <input
                v-if="turnstileTesting"
                type="hidden"
                name="cf-turnstile-response"
                value="testing-token"
                data-test="contact-turnstile-token"
            />
            <div
                v-else-if="turnstileSiteKey !== ''"
                class="cf-turnstile"
                :data-sitekey="turnstileSiteKey"
                data-test="contact-turnstile"
            />
            <p
                v-else
                class="text-sm text-red-600"
                data-test="contact-turnstile-missing"
            >
                The contact form is temporarily unavailable. Please try again later.
            </p>
            <InputError :message="errors['cf-turnstile-response']" />
        </div>

        <Button
            type="submit"
            class="w-full sm:w-auto"
            :disabled="processing"
            data-test="contact-submit"
        >
            Send message
        </Button>
    </Form>
</template>
