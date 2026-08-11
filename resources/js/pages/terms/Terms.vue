<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const contactEmail = computed(() => page.props.site.contactEmail);

const lastUpdated = 'August 4, 2026';
</script>

<template>
    <Head title="Terms of Service | Front Porch Creative">
        <meta
            name="description"
            content="Terms of Service for Front Porch Creative and the frontporchcreative.io website."
        />
        <meta property="og:title" content="Terms of Service | Front Porch Creative" />
        <meta
            property="og:description"
            content="Terms of Service for Front Porch Creative and the frontporchcreative.io website."
        />
    </Head>

    <article
        class="bg-[var(--section-light-bg)] text-[var(--text-primary-on-light)]"
        data-test="terms-page"
    >
        <div class="section-y mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
            <p class="text-overline text-[var(--text-accent-on-light)]">
                Legal
            </p>
            <h1 class="mt-3 text-h1 font-semibold" data-test="terms-heading">
                Terms of Service
            </h1>
            <p class="mt-3 text-sm text-[var(--text-muted-on-light)]">
                Last updated: {{ lastUpdated }}
            </p>

            <div class="legal-prose mt-10" data-test="terms-content">
                <h2>Acceptance</h2>
                <p>
                    By accessing or using frontporchcreative.io (the “Site”) operated by
                    Front Porch Creative (“we,” “us,” or “our”), you agree to these Terms
                    of Service. If you do not agree, please do not use the Site.
                </p>

                <h2>Our services</h2>
                <p>
                    Front Porch Creative is a marketing and technology agency based in
                    Plant City, Florida. Through the Site we describe services such as
                    lead generation, email marketing, website design and development,
                    content creation, business automations, and custom software
                    development, and we invite you to contact us or book a discovery call.
                </p>
                <p>
                    Submitting the contact form or booking a call does not create a
                    client engagement by itself. Any paid work is governed by a separate
                    agreement we enter into with you.
                </p>

                <h2>No guarantee of results</h2>
                <p>
                    Marketing and technology outcomes depend on many factors outside our
                    control, including your industry, offer, budget, and follow-through.
                    Content on the Site—including case studies, examples, and testimonials—
                    is illustrative and does not promise specific leads, revenue, rankings,
                    or other results.
                </p>

                <h2>Site content and intellectual property</h2>
                <p>
                    Text, branding, graphics, and other materials on the Site belong to
                    Front Porch Creative or our licensors. You may view and share links to
                    public pages for personal or internal business use. You may not copy,
                    scrape, or reuse Site content for commercial purposes without our
                    prior written permission.
                </p>

                <h2>Acceptable use</h2>
                <p>
                    You agree not to misuse the Site, including by submitting false
                    information, attempting to disrupt or probe our systems, bypassing
                    security checks (such as Turnstile), or using automated tools to
                    overload the contact form.
                </p>

                <h2>Limitation of liability</h2>
                <p>
                    To the fullest extent permitted by law, Front Porch Creative and its
                    owners are not liable for any indirect, incidental, special,
                    consequential, or punitive damages, or for any loss of profits, data,
                    or business opportunity, arising from your use of the Site or reliance
                    on Site content. Our total liability related to the Site will not
                    exceed one hundred U.S. dollars (USD $100).
                </p>
                <p>
                    The Site is provided “as is” without warranties of any kind, express
                    or implied, including merchantability, fitness for a particular
                    purpose, or non-infringement.
                </p>

                <h2>Governing law</h2>
                <p>
                    These Terms are governed by the laws of the State of Florida, without
                    regard to conflict-of-law rules. Courts located in Florida have
                    exclusive jurisdiction over disputes arising from these Terms or the
                    Site, unless applicable law requires otherwise.
                </p>

                <h2>Changes</h2>
                <p>
                    We may update these Terms from time to time. The “Last updated” date
                    at the top of this page will change when we do. Continued use of the
                    Site after changes means you accept the revised Terms.
                </p>

                <h2>Contact</h2>
                <p>
                    Questions about these Terms:
                </p>
                <p v-if="contactEmail">
                    Email:
                    <a :href="`mailto:${contactEmail}`" data-test="terms-contact-email">
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
                    <Link href="/privacy">Privacy Policy</Link>.
                </p>
            </div>
        </div>
    </article>
</template>
