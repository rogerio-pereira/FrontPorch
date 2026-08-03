<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner';
import SiteFooter from '@/layouts/app/SiteFooter.vue';
import SiteHeader from '@/layouts/app/SiteHeader.vue';
</script>

<template>
    <div class="min-h-screen bg-brand-bg font-sans">
        <SiteHeader />
        <main>
            <slot />
        </main>
        <SiteFooter />
        <Toaster />
    </div>
</template>
