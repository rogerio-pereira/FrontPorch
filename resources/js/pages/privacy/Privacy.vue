<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const contactEmail = computed(() => page.props.site.contactEmail);

const lastUpdated = 'August 12, 2026';
</script>

<template>
    <Head title="Privacy Policy | Front Porch Creative">
        <meta
            name="description"
            content="How Front Porch Creative collects, uses, and protects information when you use frontporchcreative.io."
        />
        <meta property="og:title" content="Privacy Policy | Front Porch Creative" />
        <meta
            property="og:description"
            content="How Front Porch Creative collects, uses, and protects information when you use frontporchcreative.io."
        />
    </Head>

    <article
        class="bg-[var(--section-light-bg)] text-[var(--text-primary-on-light)]"
        data-test="privacy-page"
    >
        <div class="section-y mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <p class="text-overline text-[var(--text-accent-on-light)]">
                Legal
            </p>
            <h1 class="mt-3 text-h1 font-semibold" data-test="privacy-heading">
                Privacy Policy
            </h1>
            <p class="mt-3 text-sm text-[var(--text-muted-on-light)]">
                Last updated: {{ lastUpdated }}
            </p>

            <div class="legal-prose mt-10" data-test="privacy-content">
                <h2>Introduction</h2>
                <p>
                    Front Porch Creative (“we,” “us,” or “our”) operates the website
                    frontporchcreative.io (the “Site”). This Privacy Policy explains what
                    information we collect when you visit the Site or contact us, how we
                    use it, and the choices you have. We serve small businesses in and
                    around Central Florida, and this policy is written for a United States
                    / Florida baseline.
                </p>

                <h2>Information we collect</h2>
                <p>
                    When you submit our contact form, we collect:
                </p>
                <ul>
                    <li>Your name</li>
                    <li>Your email address</li>
                    <li>Your phone number (optional)</li>
                    <li>Your website URL (optional)</li>
                    <li>The service(s) you are interested in</li>
                </ul>
                <p>
                    We also use Cloudflare Turnstile on the form as a security check to
                    reduce spam and automated abuse. Turnstile may process technical
                    signals about your browser session according to Cloudflare’s own
                    privacy practices.
                </p>
                <p>
                    Like most websites, our servers and hosting provider may automatically
                    log basic technical data such as IP address, browser type, and pages
                    requested for security and reliability.
                </p>

                <h2>How we use it</h2>
                <p>
                    We use contact-form information to:
                </p>
                <ul>
                    <li>Respond to your inquiry and follow up about our services</li>
                    <li>
                        Send you an email with a link to book a discovery call
                    </li>
                    <li>
                        Notify our team by email and Slack that a new lead was submitted
                    </li>
                </ul>
                <p>
                    We do not sell your personal information. We do not use the contact
                    form to subscribe you to a marketing newsletter.
                </p>

                <h2>Cookies and analytics</h2>
                <p>
                    We may use Google Analytics and the Meta (Facebook) Pixel to understand
                    how visitors use the Site and to measure advertising performance.
                    These tools can set cookies or similar technologies and collect
                    usage data when their measurement IDs are configured on the Site.
                </p>
                <p>
                    Because we primarily serve businesses in the United States / Florida,
                    we do not show a cookie consent banner before loading these tools.
                    You can change your browser settings to block or delete cookies at any
                    time; some Site features may still work without analytics cookies.
                </p>

                <h2>Third parties</h2>
                <p>
                    We rely on service providers to operate the Site and handle inquiries,
                    which may include:
                </p>
                <ul>
                    <li>Hosting and application infrastructure</li>
                    <li>Email delivery for lead notifications and scheduling links</li>
                    <li>Cloudflare Turnstile for form abuse protection</li>
                    <li>Slack for internal lead alerts</li>
                    <li>Google Analytics and Meta</li>
                    <li>Google Calendar (or a similar scheduler) when we email a booking link</li>
                </ul>
                <p>
                    Those providers process data under their own terms and privacy policies.
                    We share only what is needed to provide the service you requested or to
                    run the Site securely.
                </p>

                <h2>Your rights</h2>
                <p>
                    Depending on applicable law, you may request access to, correction of,
                    or deletion of personal information we hold about you. To make a
                    request, contact us using the details below. We may need to verify your
                    identity before responding.
                </p>

                <h2>Contact</h2>
                <p>
                    Questions about this Privacy Policy or your data:
                </p>
                <p v-if="contactEmail">
                    Email:
                    <a :href="`mailto:${contactEmail}`" data-test="privacy-contact-email">
                        {{ contactEmail }}
                    </a>
                </p>
                <p v-else>
                    Use the
                    <Link href="/#contact">contact form</Link>
                    or the email address shown in the Site footer.
                </p>
                <p>
                    Front Porch Creative · Plant City, Florida · Central Florida service area
                </p>
                <p>
                    See also our
                    <Link href="/terms">Terms of Service</Link>.
                </p>
            </div>
        </div>
    </article>
</template>
