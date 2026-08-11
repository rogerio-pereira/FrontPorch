<script setup lang="ts">
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import CtaBand from '@/layouts/app/CtaBand.vue';
import AboutSection from '@/pages/home/component/AboutSection.vue';
import BlogPreviewSection from '@/pages/home/component/BlogPreviewSection.vue';
import ContactSection from '@/pages/home/component/ContactSection.vue';
import FaqSection from '@/pages/home/component/FaqSection.vue';
import HeroSection from '@/pages/home/component/HeroSection.vue';
import PortfolioPreviewSection from '@/pages/home/component/PortfolioPreviewSection.vue';
import ProblemsSection from '@/pages/home/component/ProblemsSection.vue';
import ProcessSection from '@/pages/home/component/ProcessSection.vue';
import ServicesSection from '@/pages/home/component/ServicesSection.vue';
import TestimonialsSection from '@/pages/home/component/TestimonialsSection.vue';
import WhySection from '@/pages/home/component/WhySection.vue';

const props = defineProps<{
    faqs: Array<{ question: string; answer: string }>;
    services: Array<{ slug: string; title: string; description: string }>;
    testimonials: Array<{ testimonial: string; person: string }>;
    caseStudies: Array<{
        title: string;
        description: string;
        slug: string;
        images: Array<{ url: string; alt: string }>;
        services: Array<{ title: string }>;
    }>;
    articles: Array<{
        title: string;
        description: string;
        image: string;
        slug: string;
    }>;
}>();

const homeDescription =
    'A Plant City agency helping small businesses grow with websites, lead generation, email marketing, automations, and custom software, all working together, not in pieces.';

const jsonLd = computed(() => {
    const graph: Array<Record<string, unknown>> = [
        {
            '@type': 'Organization',
            name: 'Front Porch Creative',
            url: '/',
            logo: '/images/branding/logo-horizontal.png',
            description: homeDescription,
            address: {
                '@type': 'PostalAddress',
                addressLocality: 'Plant City',
                addressRegion: 'FL',
                addressCountry: 'US',
            },
            areaServed: 'Central Florida',
        },
        {
            '@type': 'ProfessionalService',
            name: 'Front Porch Creative',
            url: '/',
            image: '/images/branding/logo-horizontal.png',
            description: homeDescription,
            address: {
                '@type': 'PostalAddress',
                addressLocality: 'Plant City',
                addressRegion: 'FL',
                addressCountry: 'US',
            },
            areaServed: 'Central Florida',
        },
        {
            '@type': 'WebSite',
            name: 'Front Porch Creative',
            url: '/',
            inLanguage: 'en-US',
        },
    ];

    if (props.faqs.length > 0) {
        graph.push({
            '@type': 'FAQPage',
            mainEntity: props.faqs.map((faq) => ({
                '@type': 'Question',
                name: faq.question,
                acceptedAnswer: {
                    '@type': 'Answer',
                    text: faq.answer,
                },
            })),
        });
    }

    return JSON.stringify({
        '@context': 'https://schema.org',
        '@graph': graph,
    });
});
</script>

<template>
    <Head title="Front Porch Creative | Marketing & Technology for Small Businesses">
        <meta name="description" :content="homeDescription" />
        <meta property="og:title" content="Front Porch Creative | Marketing & Technology for Small Businesses" />
        <meta property="og:description" :content="homeDescription" />
        <meta property="og:image" content="/images/home/hero.png" />
        <meta property="og:type" content="website" />
        <meta name="twitter:card" content="summary_large_image" />
        <component :is="'script'" type="application/ld+json">
            {{ jsonLd }}
        </component>
    </Head>

    <HeroSection />
    <ProblemsSection />
    <ServicesSection :services="services" />
    <CtaBand
        heading="Not sure where to start?"
        body="That is okay. Tell us what is on your mind, we will help you figure out a sensible first step, with no pressure and no jargon."
        button="Book a discovery call"
        test-id="home-cta-1"
    />
    <PortfolioPreviewSection :case-studies="caseStudies" />
    <TestimonialsSection :testimonials="testimonials" />
    <CtaBand
        v-if="caseStudies.length > 0 || testimonials.length > 0"
        heading="A little clarity goes a long way"
        body="Even one good conversation can change how you think about your marketing. We would love to hear what you are working toward."
        button="Schedule a free call"
        test-id="home-cta-2"
    />
    <ProcessSection />
    <FaqSection :faqs="faqs" />
    <CtaBand
        v-if="faqs.length > 0"
        heading="You should not need a tech degree to grow your business"
        body="We handle the complicated parts and explain things in plain English, you stay in the loop without getting lost in the details."
        button="Let's talk → #contact"
        test-id="home-cta-3"
    />
    <WhySection />
    <AboutSection />
    <CtaBand
        heading="We are in your corner"
        body="We work with owners who want a real partner, someone who listens, tells the truth, and sticks around after launch day."
        button="Book a discovery call"
        test-id="home-cta-4"
    />
    <ContactSection />
    <CtaBand
        heading="Pull up a chair"
        body="Whether you need a new site, more leads, or less busywork, it starts with a simple conversation."
        button="Get in touch → #contact"
        test-id="home-cta-5"
    />
    <BlogPreviewSection :articles="articles" />
</template>
