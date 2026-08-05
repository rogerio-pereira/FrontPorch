# Decision — No cookie consent banner (US / Florida MVP)

**Date:** 2026-08-05  
**Status:** Locked  
**Affects:** Stage 8 (analytics), Privacy Policy copy, Briefing §12, Design System §9.10  
**References:** [phase-01.md](../phase-01.md) · [Briefing.md](../../Briefing.md) §12

## Context

Stage 8 originally required a cookie consent banner that gated Google Analytics and the Meta Pixel (GDPR-style opt-in). The Privacy Policy published in Stage 3 described that model.

The product audience is **United States / Florida only** (Central Florida service area). GDPR and Brazil’s LGPD do not drive MVP requirements. US state privacy laws that matter most for this footprint are transparency-oriented; there is no federal US requirement to obtain opt-in consent before loading analytics cookies for a Florida-focused marketing site.

## Decision

1. **Do not implement a cookie consent banner** for Phase 1 / MVP.
2. **Stage 8** delivers GA4 + Meta Pixel script injection when IDs are set in env/`config/site.php`, **without** consent gating.
3. **Privacy Policy** discloses analytics cookies and states explicitly that no consent banner is shown (US / Florida baseline).
4. Revisit only if the audience expands to jurisdictions that require prior consent (e.g. significant EU/EEA/UK traffic) or if counsel advises otherwise for California “sale/share” advertising flows.

## Consequences

- Design System §9.10 cookie-banner pattern is **out of MVP scope** (kept as deferred reference only).
- Stage 10 smoke no longer checks a consent banner.
- Founders still create GA / Meta accounts and set `GOOGLE_ANALYTICS_ID` / `META_PIXEL_ID` in production (ops / Stage 0.1).
