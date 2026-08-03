<script setup lang="ts">
import DecorativeBackground from '@/layouts/app/DecorativeBackground.vue';
import CtaButton from '@/layouts/app/CtaButton.vue';
import SectionShell from '@/layouts/app/SectionShell.vue';
import ContactForm from '@/pages/home/component/ContactForm.vue';
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

            <ContactForm />

            <div class="flex flex-col items-center justify-center gap-3 sm:flex-row">
                <CtaButton
                    label="Book a discovery call"
                    test-id="home-contact-schedule"
                />
            </div>
        </div>
    </SectionShell>
</template>
