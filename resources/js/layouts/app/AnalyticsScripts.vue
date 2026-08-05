<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

declare global {
    interface Window {
        dataLayer?: unknown[];
        gtag?: (...args: unknown[]) => void;
        fbq?: ((...args: unknown[]) => void) & {
            callMethod?: (...args: unknown[]) => void;
            queue: unknown[];
            push: (...args: unknown[]) => void;
            loaded: boolean;
            version: string;
        };
        _fbq?: Window['fbq'];
    }
}

const page = usePage();

const googleAnalyticsId = computed((): string | null => {
    const value = page.props.site.googleAnalyticsId;

    if (typeof value !== 'string') {
        return null;
    }

    if (value === '') {
        return null;
    }

    return value;
});

const metaPixelId = computed((): string | null => {
    const value = page.props.site.metaPixelId;

    if (typeof value !== 'string') {
        return null;
    }

    if (value === '') {
        return null;
    }

    return value;
});

function injectGoogleAnalytics(measurementId: string): void {
    if (document.getElementById('ga-gtag-js') !== null) {
        return;
    }

    const script = document.createElement('script');
    script.id = 'ga-gtag-js';
    script.async = true;
    script.src = `https://www.googletagmanager.com/gtag/js?id=${encodeURIComponent(measurementId)}`;
    document.head.appendChild(script);

    window.dataLayer = window.dataLayer ?? [];

    window.gtag = function gtag(...args: unknown[]): void {
        window.dataLayer?.push(args);
    };

    window.gtag('js', new Date());
    window.gtag('config', measurementId);
}

function injectMetaPixel(pixelId: string): void {
    if (document.getElementById('meta-pixel-js') !== null) {
        return;
    }

    if (typeof window.fbq !== 'function') {
        const fbq = function (...args: unknown[]): void {
            if (fbq.callMethod) {
                fbq.callMethod(...args);

                return;
            }

            fbq.queue.push(args);
        } as NonNullable<Window['fbq']>;

        fbq.queue = [];
        fbq.loaded = true;
        fbq.version = '2.0';
        fbq.push = fbq;

        window.fbq = fbq;
        window._fbq = fbq;
    }

    const script = document.createElement('script');
    script.id = 'meta-pixel-js';
    script.async = true;
    script.src = 'https://connect.facebook.net/en_US/fbevents.js';
    document.head.appendChild(script);

    window.fbq?.('init', pixelId);
    window.fbq?.('track', 'PageView');
}

onMounted(() => {
    if (googleAnalyticsId.value !== null) {
        injectGoogleAnalytics(googleAnalyticsId.value);
    }

    if (metaPixelId.value !== null) {
        injectMetaPixel(metaPixelId.value);
    }
});
</script>

<template>
    <!-- Analytics scripts are injected into document.head on mount when IDs are set. -->
</template>
