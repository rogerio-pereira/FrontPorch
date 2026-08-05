<script setup lang="ts">
import { Toaster } from '@/components/ui/sonner';
import AnalyticsScripts from '@/layouts/app/AnalyticsScripts.vue';
import SiteFooter from '@/layouts/app/SiteFooter.vue';
import SiteHeader from '@/layouts/app/SiteHeader.vue';
</script>

<template>
    <div class="min-h-screen bg-brand-bg font-sans">
        <AnalyticsScripts />
        <SiteHeader />
        <main>
            <slot />
        </main>
        <SiteFooter />
        <Toaster
            theme="dark"
            position="bottom-center"
            close-button
            :duration="6000"
            :toast-options="{
                classNames: {
                    toast: 'shadow-lg',
                    success:
                        '!bg-[#1e2f28] !text-[#f5f5f5] !border-[#8fa894]',
                    title: '!text-[#f5f5f5] !font-semibold',
                    description: '!text-[#e8f0ea]',
                    icon: '!text-[#8fa894]',
                },
            }"
        />
    </div>
</template>
