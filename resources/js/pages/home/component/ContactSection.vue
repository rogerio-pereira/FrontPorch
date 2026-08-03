<script setup lang="ts">
import { Form, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';

const page = usePage();

const turnstileSiteKey = computed(() => {
    return page.props.site.turnstileSiteKey ?? '';
});

const turnstileTesting = computed(() => {
    return page.props.site.turnstileTesting === true;
});
</script>

<template>
    <SectionShell
        id="contact"
        overline="Contact"
        heading="We would love to hear from you"
        light
        wide
    >
        <template #background>
            <DecorativeBackground variant="grid" />
        </template>

        <div class="mx-auto max-w-2xl stack-loose rounded-xl border border-border-default bg-white p-8 lg:p-10">
            <p class="text-center text-body-lg text-[var(--text-muted-on-light)]">
                Share a little about your business and what you are hoping to improve. We usually reply within one business day.
            </p>

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
                    <Label for="contact-website">Website</Label>
                    <Input
                        id="contact-website"
                        name="website"
                        type="url"
                        required
                        autocomplete="url"
                        placeholder="https://yourbusiness.com"
                        data-test="contact-website"
                    />
                    <InputError :message="errors.website" />
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

                <p class="text-sm text-[var(--text-muted-on-light)]" data-test="contact-email-notice">
                    <strong>We will email you the discovery-call link.</strong>
                    A real email address is required so we can avoid fake submissions.
                </p>

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

                <div class="flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <Button
                        type="submit"
                        class="w-full sm:w-auto"
                        :disabled="processing"
                        data-test="contact-submit"
                    >
                        Book a discovery call
                    </Button>
                </div>
            </Form>
        </div>
    </SectionShell>
</template>
