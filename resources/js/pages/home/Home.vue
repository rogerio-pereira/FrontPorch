<script setup lang="ts">
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

defineProps<{
    // TODO: remove demo arrays in HomeController once these come from real models/CMS
    faq: Array<{ question: string; answer: string }>;
    services: Array<{ slug: string; title: string; teaser: string }>;
    testimonials: Array<{ quote: string; attribution: string }>;
    portfolioPreview: Array<{ title: string; description: string; image: string }>;
}>();
</script>

<template>
    <Head title="Front Porch Creative | Marketing & Technology for Small Businesses">
        <meta
            name="description"
            content="A Plant City agency helping small businesses grow with websites, lead generation, email marketing, automations, and custom software, all working together, not in pieces."
        />
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
    <PortfolioPreviewSection :items="portfolioPreview" />
    <TestimonialsSection :quotes="testimonials" />
    <CtaBand
        heading="A little clarity goes a long way"
        body="Even one good conversation can change how you think about your marketing. We would love to hear what you are working toward."
        button="Schedule a free call"
        test-id="home-cta-2"
    />
    <ProcessSection />
    <FaqSection :items="faq" />
    <CtaBand
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
    <BlogPreviewSection />
</template>
