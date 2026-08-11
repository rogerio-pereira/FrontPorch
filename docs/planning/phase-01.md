# Phase 1 — Static pages and conversion

**References:** [Briefing.md](../Briefing.md) (§5 sitemap, §6 functional requirements, §18 next steps) · [Design-System.md](../Design-System.md) · [phase-01-backend.md](./phase-01-backend.md) (CMS — delivered)

**Current state (2026-08-11):** Stages **0 (code), 1, 2, 3, 4, 5, 6, 7, 8, 9, and 10 (code QA)** are done. **Briefing Phase 2 CMS** is also delivered: Eloquent models, `/core` admin, seeders, and public wiring for services, FAQs, testimonials, case studies, and blog. **Six** service landings (original five + `content-creation`). Landing **copy** stays hardcoded in Vue; list/detail/nav data comes from the DB. Site chrome via `config/site.php` + Inertia (`CONTACT_EMAIL`). Stage **7** revised: booking CTAs go to the contact form; `CALENDAR_URL` is emailed to the lead after submit (local/fictional URL is enough to prove the flow). Stage **3** publishes `/privacy` and `/terms` with footer links. **Locked:** no cookie consent banner ([decision](./decisions/2026-08-05-no-cookie-consent-banner.md)); Privacy copy updated. Stage **8** injects GA4 + Meta Pixel when IDs are set (no consent gate). Stage **9** ships OG tags, home JSON-LD, `sitemap.xml`, `robots.txt`, and `llms.txt` (SEO + LLMO/GEO, kept simple). Stage **10** automated gates green (build + 329 tests @ 100% coverage + Pint + type coverage). **Still open:** founder sign-off (10.3), mobile visual check (10.2), Stage 0.1 ops. Local `.env`: `CONTACT_EMAIL` still placeholder-like; `GOOGLE_ANALYTICS_ID` / `META_PIXEL_ID` empty (scripts correctly stay off until set).

**Phase goal:** A launch-ready site that generates qualified leads — long-form home, service landing pages, legal pages, contact form, Calendar scheduling, and analytics (GA / Meta) when configured.

---

## How this plan is organized

The Briefing (§18) lists **8 checklist items** for Phase 1. This plan maps **one stage per checklist item**, plus:

| Stage | Maps to | Role | Status |
|-------|---------|------|--------|
| **Stage 0** | Briefing §18 “Immediate (Pre-Development)” | Technical foundation | Code done; ops (0.1) open |
| **Stages 1–2** | Checklist items 1–2 | Marketing copy | **Done** (inline Vue) |
| **Stages 4–5** | Checklist items 4–5 | Home + service pages | **Done** |
| **Stage 6** | Checklist item 6 | Lead form (defines personal data collected) | **Done** |
| **Stage 7** | Checklist item 7 | Scheduling via contact form + email link | Code done; production URL is ops |
| **Stage 3** | Checklist item 3 | Privacy + Terms (describes live form + upcoming analytics) | **Done** |
| **Stage 8** | Checklist item 8 | GA + Meta scripts (no consent banner) | **Done** |
| **Stage 9** | Briefing §10 SEO + polish | Cross-cutting technical SEO + LLMO/GEO | **Done** |
| **Stage 10** | Definition of Done | Final QA and founder sign-off | Code QA done; founder/ops open |
| **CMS (Phase 2)** | Briefing §18 Phase 2 | Admin + public Eloquent wiring | **Done** — see [phase-01-backend.md](./phase-01-backend.md) |

Each stage is broken into **small steps** (numbered `X.Y`). Treat one step ≈ one focused commit (or a tiny group). Tests + Pint green at the end of each stage.

### Precedence (why this order)

Legal pages must describe **real** site behavior. Drafting Privacy/Terms before the contact form and analytics either invents practices or forces a rewrite. Therefore:

1. **Stage 6** ships the lead form → Privacy can list name, email, optional phone, website accurately.
2. **Stage 7** (code) — booking CTAs → contact form; scheduling email when `CALENDAR_URL` is set (ops sets production URL later).
3. **Stage 3** publishes Privacy + Terms + footer links → describes the live form and analytics (no consent banner — [decision](./decisions/2026-08-05-no-cookie-consent-banner.md)).
4. **Stage 8** adds GA / Meta script injection when IDs are set (no consent gating).
5. **Stages 9–10** polish and accept.

Do **not** parallelize Stage 3 with Stage 6/8. Stages 1–2 (copy) and Stage 0 (foundation) were correctly parallel with early UI work; legal is not “content-only” in the same sense once it must mirror product behavior.

```mermaid
flowchart TB
    S0[Stage 0 Foundation]
    S1[Stage 1 Home copy]
    S2[Stage 2 Service copy]
    S4[Stage 4 Home page]
    S5[Stage 5 Service pages]
    S6[Stage 6 Lead form]
    S7[Stage 7 Calendar]
    S3[Stage 3 Legal pages]
    S8[Stage 8 GA + Meta scripts]
    S9[Stage 9 SEO polish]
    S10[Stage 10 QA]

    S0 --> S4
    S0 --> S5
    S1 --> S4
    S2 --> S5
    S4 --> S6
    S4 --> S7
    S6 --> S3
    S7 --> S9
    S3 --> S8
    S8 --> S9
    S5 --> S9
    S6 --> S9
    S9 --> S10

    S1 -. parallel .- S2
    S1 -. parallel .- S0
```

### Content workflow

**Original plan:** copy in `docs/content/` Markdown for founder review, then loaded via `App\Support\MarketingContent`.

**As implemented:** marketing **page copy** is **inlined** in Vue templates (home sections + each service landing). Dynamic lists (services, FAQs, testimonials, case studies, blog) load from Eloquent. `docs/content/home-copy.md` was removed after sync. Do **not** reintroduce a Markdown loader unless product needs founder-editable landing files again.

| Stage | Review artifact (plan) | As implemented / locked decision |
|-------|------------------------|----------------------------------|
| 1 | `docs/content/home-copy.md` | Inline in `resources/js/pages/home/**`; home lists from Eloquent |
| 2 | `docs/content/services/{slug}.md` | Inline in each `resources/js/pages/service-*/**`; FAQs/testimonials from DB |
| 3 | `docs/content/legal/*.md` (old preference) | **Locked:** inline Vue pages (same pattern as marketing); after Stage 6 |

**Copy tone (confirmed):** Friendly and approachable (Design System §4.3) — not cold or overly technical. **Geo/SEO specifics** (service area, radius, city lists) belong in **meta tags, service landing pages, and FAQ** — not in hero or main section body copy.

**Contact email / calendar:** `CONTACT_EMAIL` and `CALENDAR_URL` in `.env` → `config/site.php` → Inertia shared `site` props. UI falls back to `contact@example.com` / `#schedule` when unset. **Legal pages:** do not hardcode the current test placeholder; render the shared `site.contactEmail` (production env will hold the real address) or point readers to the footer contact when unset.

---

## Scope and boundaries

### In scope

- Stage 0 through Stage 10 (below)
- Portfolio and Blog public pages (now DB-backed; originally planned as stubs)

### Delivered early (Briefing Phase 2 CMS)

Already in the repo (see [phase-01-backend.md](./phase-01-backend.md)):

- Admin CRUD under `/core/*` (Users, Services, FAQs, Testimonials, Case studies, Blog articles)
- `GET /portfolio` — paginated case studies from DB
- `GET /portfolio/study-case/{caseStudy:slug}` — study case detail
- `GET /blog` — paginated articles from DB
- `GET /blog/article/{article:slug}` — article detail
- Home previews + service landing FAQs/testimonials from Eloquent
- Sixth catalog service: `content-creation`

**Still Phase 3 (content, not code):** founder photography, real client portfolio/testimonials, published launch articles.

### Out of scope (remaining Phases / post-launch)

- CRM, newsletter, live chat, payments
- Google Ads / Meta Ads campaigns
- DNS/production deploy (operational; Stage 0 + Stage 10 checklists)
- Object-storage image cleanup on soft-delete (deferred; see follow-up below)

---

## Shared architecture (reference)

### Routes (`routes/web.php`) — as implemented

| Route | Inertia page | Status |
|-------|--------------|--------|
| `GET /` | `home/Home` | Done (Stage 4; Eloquent props) |
| `GET /services/lead-generation` | `service-lead-generation/ServiceLeadGeneration` | Done |
| `GET /services/email-marketing` | `service-email-marketing/ServiceEmailMarketing` | Done |
| `GET /services/website-design-and-development` | `service-website-design-and-development/ServiceWebsiteDesignAndDevelopment` | Done |
| `GET /services/content-creation` | `service-content-creation/ServiceContentCreation` | Done (added after original five) |
| `GET /services/business-automations` | `service-business-automations/ServiceBusinessAutomations` | Done |
| `GET /services/custom-software-development` | `service-custom-software-development/ServiceCustomSoftwareDevelopment` | Done |
| `GET /portfolio` | `portfolio/Portfolio` | Done (DB, paginated) |
| `GET /portfolio/study-case/{caseStudy:slug}` | `portfolio-study-case/PortfolioStudyCase` | Done (DB) |
| `GET /blog` | `blog/Blog` | Done (DB, paginated) |
| `GET /blog/article/{article:slug}` | `blog-article/BlogArticle` | Done (DB) |
| `GET /privacy` | `privacy/Privacy` | Done (Stage 3) |
| `GET /terms` | `terms/Terms` | Done (Stage 3) |
| `POST /contact` | ContactController | **Done** (Stage 6) |
| `/core/*` | `core/**` | Done (CMS admin; `routes/core.php`) |

**Service slugs:** `lead-generation` · `email-marketing` · `website-design-and-development` · `content-creation` · `business-automations` · `custom-software-development`

### Architecture notes (plan vs code)

| Planned | As implemented |
|---------|----------------|
| `MarketingLayout.vue` / `marketing/*` pages | `AppLayout` + `layouts/app/SiteHeader.vue` / `SiteFooter.vue` |
| Single `MarketingController` + `MarketingContent` | Per-page invokable controllers + `RendersServiceLanding` trait |
| `docs/content/` Markdown loader | Inline landing copy in Vue; lists from Eloquent |
| `GET /services/{slug}` dynamic | Explicit routes per slug |
| Empty `/portfolio` and `/blog` stubs | Full DB-backed listing + detail pages + `/core` admin |
| `config/marketing.php` | **`config/site.php`** (`contact_email`, `calendar_url`, `google_analytics_id`, `meta_pixel_id`) |

### Target / actual file structure

```
public/fonts/                          # Montserrat — DONE
public/images/branding/                # logos — DONE
docs/branding/                         # source fonts + logos — DONE
docs/content/                          # DROPPED — marketing + legal copy are inline Vue
resources/js/pages/privacy/            # Privacy — DONE (Stage 3)
resources/js/pages/terms/              # Terms — DONE (Stage 3)
resources/css/app.css                  # brand tokens — DONE
resources/js/layouts/AppLayout.vue     # marketing shell — DONE
resources/js/layouts/app/              # SiteHeader, SiteFooter, SectionShell, CtaBand, CtaButton, …
resources/js/pages/home/               # Home + section components — DONE
resources/js/pages/service-*/          # six service pages — DONE
resources/js/pages/portfolio*/         # portfolio listing + study case — DONE (DB)
resources/js/pages/blog*/              # blog listing + article — DONE (DB)
resources/js/pages/core/               # admin CMS pages — DONE
config/site.php                        # DONE (calendar, contact email, analytics IDs)
app/Http/Controllers/ContactController.php  # Stage 6
tests/Feature/ContactFormTest.php      # Stage 6
docs/planning/decisions/               # Locked product decisions (e.g. no cookie banner)
tests/Browser/… / Feature              # smoke/feature for existing public + core pages — largely DONE
```

---

# Stage 0 — Technical foundation

**Briefing ref:** §18 “Immediate (Pre-Development)” · §8 Branding  
**Goal:** Brand assets and design tokens in code so Stages 4–8 build on a consistent base.  
**Prerequisites:** None (start here or in parallel with Stages 1–2).  
**Status:** Code complete; founder/ops items open.

### Step 0.1 — Operational setup (founders, non-code)

- [ ] DNS plan: `frontporchcreative.io` canonical; `.agency` / `.marketing` → 301 to `.io`
- [ ] Create GA4, Meta Business/Pixel, Search Console accounts (IDs go in `.env` later)
- [ ] Create Google Calendar scheduling link
- [ ] Basic competitor + keyword research (informs Stages 1–2)
- [ ] Decide on Google Business Profile (Phase 3; note decision)

### Step 0.2 — Brand assets in repo

- [x] Commit `docs/branding/` (fonts + optimized PNG logos)
- [x] Copy fonts → `public/fonts/`
- [x] Copy logos → `public/images/branding/`

### Step 0.3 — Typography and color tokens

- [x] `@font-face` for Montserrat Alt Thin, Light, SemiBold in `resources/css/app.css`
- [x] Remove Instrument Sans / Inter CDN from starter pages (active marketing pages use brand fonts)
- [x] Tokens: `brand-bg` `#192630`, `brand-accent` `#72887b`, surfaces, borders, semantic colors
- [x] Expose pending Design System options A–D and L1–L4 as CSS vars; defaults: `--text-on-dark-b`, `--section-light-l1`

### Step 0.4 — Base UI components

- [x] Customize Reka `Button` variants (primary accent, secondary outline, tertiary link)
- [x] Install shadcn-vue: `Textarea`, `Accordion` (FAQ in Stage 4)
- [x] Smoke test: `/` still loads after theme swap

### Stage 0 — Done when

- [x] Fonts and logos served from `public/`
- [x] No Instrument Sans / yellow in marketing CSS tokens
- [x] Button + Textarea + Accordion available for marketing pages
- [ ] Step 0.1 founder/ops items (not blocking further code stages)

---

# Stage 1 — Home page copy (16 sections)

**Briefing checklist:** “Write home page copy (all 16 sections)”  
**Goal:** Complete English copy for every home section, ready to wire into Vue.  
**Prerequisites:** Briefing §4 (audience), §9 (content), Design System §4.3 (tone). Keyword research (Step 0.1) helps but is not blocking.  
**Status:** Done in app (inline). Markdown review file removed.

**Output location (as implemented):** `resources/js/pages/home/**` + `app/Http/Controllers/HomeController.php`

### Step 1.1 — Page-level SEO and meta

- [x] `<title>` and meta description (may include region for SEO)
- [ ] Open Graph title, description, placeholder OG image note (home still lighter than service pages)

### Step 1.2 — Section 1: Hero + scheduling CTA

- [x] Headline (primary value proposition — warm, human)
- [x] Subhead (benefits in plain language — no ad-style geo/radius copy)
- [x] Primary CTA label → scheduling (generic: “Book a discovery call” until duration finalized)
- [x] Secondary CTA label → contact anchor

### Step 1.3 — Section 2: Problems

- [x] 4–6 pain points (outdated site, no leads, manual processes, fragmented tools)
- [x] Short intro line tying problems to target audience (Briefing §4)

### Step 1.4 — Section 3: Services

- [x] One card per service (5 items) with title, 1–2 sentence teaser, link slug
- [x] Order aligned with SEO priority (Briefing §10) or sitemap order

### Step 1.5 — Section 4: CTA band

- [x] Headline + body + button label (reusable pattern for sections 7, 10, 13, 15)

### Step 1.6 — Section 5: Portfolio (placeholder content)

- [x] Section heading + intro
- [x] Placeholder project cards (static / demo)
- [x] “See more” link label → `/portfolio`

### Step 1.7 — Section 6: Testimonials (placeholder)

- [x] Placeholder / process-focused quotes (no fake client claims required)
- [x] Section heading

### Step 1.8 — Section 7: CTA band

- [x] Variant copy (different angle from §4)

### Step 1.9 — Section 8: How it works

- [x] Numbered steps (discovery → strategy → build → measure → iterate)

### Step 1.10 — Section 9: FAQ

- [x] Q&A pairs from Briefing §4 objections — geo/service area in FAQ, not hero
- [x] Accordion-only on home (no dedicated FAQ page)

### Step 1.11 — Section 10: CTA band

- [x] Variant copy

### Step 1.12 — Section 11: Why Front Porch

- [x] USP bullets from Briefing §2

### Step 1.13 — Section 12: Who we are

- [x] Founder story summary (human, Plant City, front porch metaphor)
- [x] Placeholder photo alt text

### Step 1.14 — Section 13: CTA band

- [x] Variant copy

### Step 1.15 — Section 14: Contact

- [x] Section intro + expectation (response time, what happens next)
- [x] Calendar mention (generic wording; form still Stage 6)

### Step 1.16 — Section 15: CTA band

- [x] Final pre-footer CTA variant

### Step 1.17 — Section 16: Blog preview (placeholder)

- [x] Section heading
- [x] Placeholder article cards + link → `/blog`

### Step 1.18 — Copy review

- [ ] Founder pass: tone, claims, no aggressive hard-sell
- [x] Consistency check: service names match slugs and Briefing §5

### Stage 1 — Done when

- [x] All 16 sections have English copy in the app
- [x] FAQ covers main objections
- [x] CTA band copy defined for reuse (5 variants on home)
- [ ] Founder formal sign-off (Stage 10.3)

---

# Stage 2 — Service landing page copy (×6 catalog)

**Briefing checklist:** “Write 5 service landing page copies” _(catalog later grew to six with content-creation)_  
**Goal:** One complete landing page per service for paid + organic traffic.  
**Prerequisites:** Stage 1 service names aligned; Briefing §10 keyword template.  
**Status:** Done — copy inlined per service Vue page (+ assets). Sixth service `content-creation` added after the original five.

**Output location (as implemented):** `resources/js/pages/service-{slug}/**`

### Step 2.1 — Shared template definition

Document required fields for every service page:

- [x] H1 (service + benefit)
- [x] Hero subhead
- [x] Benefit bullets / sections
- [x] Process / how we deliver
- [x] Social proof placeholder line (honest, no fake stats)
- [x] Primary CTA (schedule or contact)
- [x] SEO: `title`, `description`; OG tags on service pages
- [x] Service-specific body content pattern shared across five pages

### Step 2.2 — `lead-generation` (SEO priority 1)

- [x] Full copy per template

### Step 2.3 — `email-marketing` (priority 2)

- [x] Full copy per template

### Step 2.4 — `website-design-and-development` (priority 3)

- [x] Full copy per template

### Step 2.5 — `business-automations` (priority 4)

- [x] Full copy per template

### Step 2.6 — `custom-software-development` (priority 5)

- [x] Full copy per template

### Step 2.6b — `content-creation` (added to catalog)

- [x] Full copy per template + OG + seeder/FAQs

### Step 2.7 — Cross-page review

- [x] No duplicate H1/meta across pages (unique per service)
- [x] CTAs consistent with home patterns
- [ ] Founder review

### Stage 2 — Done when

- [x] Catalog service pages live with complete copy + SEO meta
- [ ] Founder formal sign-off (Stage 10.3)

---

# Stage 3 — Privacy Policy and Terms of Service

**Briefing checklist:** “Draft Privacy Policy and Terms of Service”  
**Goal:** Legal pages published as readable shells with inline Vue copy that matches live product behavior.  
**Prerequisites:** Stage 0 tokens; **Stage 6 complete** (so Privacy lists the real contact-form fields and email delivery). Analytics language reflects the locked no-banner model ([decision](./decisions/2026-08-05-no-cookie-consent-banner.md)).  
**Status:** **Done** — `/privacy` and `/terms` live with inline Vue copy; footer Legal links; Feature + Browser coverage.

**Output location (locked):** inline Vue pages (`resources/js/pages/privacy/**`, `resources/js/pages/terms/**`) — same pattern as marketing copy. No Markdown loader.

**Company facts (locked):** Front Porch Creative · domain `frontporchcreative.io` · contact via shared `site.contactEmail` (do not bake in local test placeholders).

### Step 3.1 — Privacy Policy draft

- [x] AI draft covering: data collected (contact form — after Stage 6), email delivery, analytics cookies (GA/Meta, no consent banner), US/Florida baseline, contact email from shared site props, last updated date
- [x] Sections: Introduction, Information we collect, How we use it, Cookies, Third parties, Your rights, Contact

### Step 3.2 — Terms of Service draft

- [x] AI draft covering: acceptance, services description, no guarantee of results, limitation of liability, governing law (Florida), contact

### Step 3.3 — Founder legal review

- [ ] Founders may request edits after publish (optional attorney review per Briefing §17)
- [x] Ship AI draft as published text when Stage 3 is implemented (founder will iterate in-product)

### Step 3.4 — Routes and page shells

- [x] `GET /privacy` → legal Privacy page (light bg, `max-w-3xl`, prose styling)
- [x] `GET /terms` → legal Terms page
- [x] Controllers render Inertia pages; copy lives inline in Vue
- [x] Footer links to both (`SiteFooter.vue`)

### Step 3.5 — Browser smoke test

- [x] Add `/privacy` and `/terms` to browser/route smoke coverage

### Stage 3 — Done when

- [x] Both legal pages render readable content
- [x] Routes publicly accessible
- [x] Privacy reflects Stage 6 form behavior; cookie/analytics language matches the locked no-banner model ([decision](./decisions/2026-08-05-no-cookie-consent-banner.md))

---

# Stage 4 — Design and implement home page

**Briefing checklist:** “Design and implement home page (Inertia + Vue)”  
**Goal:** Long-form home with all 16 sections, marketing layout, portfolio/blog stubs.  
**Prerequisites:** Stage 0 complete; Stage 1 copy available. Footer Privacy/Terms links come later with Stage 3 (after Stage 6).  
**Status:** **Done** (layout + 16 sections). Footer includes Privacy/Terms. Portfolio/blog are DB-backed (CMS delivered), not empty stubs.

### Step 4.1 — Marketing layout and navigation

- [x] Marketing shell via `AppLayout` + sticky `SiteHeader` / `SiteFooter`
- [x] Header: horizontal logo, Services dropdown, Portfolio, Blog, Contact `#contact`, Schedule CTA
- [x] Footer: logo, links, Central Florida service area, Privacy/Terms
- [x] Mobile: drawer/sheet (Dialog)
- [x] `data-test` on nav items and primary CTAs

### Step 4.2 — Shared section primitives

- [x] `SectionShell.vue` (overline, heading, body, slot, optional CTA)
- [x] `CtaBand.vue` (reusable for sections 4, 7, 10, 13, 15)
- [x] `CtaButton.vue` wrapper for schedule / anchor links

### Step 4.3 — Home page scaffold

- [x] `resources/js/pages/home/Home.vue` — composes section components
- [x] Content via controller props + inline section copy (no Markdown loader)
- [x] `HomeController` passes content to `Home.vue`
- [x] Route `GET /` → home (Welcome no longer the public landing)

### Step 4.4 — Section 1: Hero

- [x] `home/component/HeroSection.vue` — display type, gradient, primary + secondary CTAs
- [x] Hero motion via `motion-safe:*`; respects reduced motion utilities

### Step 4.5 — Section 2: Problems

- [x] `home/component/ProblemsSection.vue`

### Step 4.6 — Section 3: Services

- [x] `home/component/ServicesSection.vue` — cards linking to `/services/{slug}`

### Step 4.7 — Sections 4, 7, 10, 13, 15: CTA bands

- [x] Five `CtaBand` instances with distinct copy

### Step 4.8 — Section 5: Portfolio preview

- [x] `home/component/PortfolioPreviewSection.vue` — “See more” → `/portfolio`

### Step 4.9 — Section 6: Testimonials

- [x] `home/component/TestimonialsSection.vue` — light section + placeholder copy

### Step 4.10 — Section 8: How it works

- [x] `home/component/ProcessSection.vue`

### Step 4.11 — Section 9: FAQ

- [x] `home/component/FaqSection.vue` — Accordion

### Step 4.12 — Section 11: Why Front Porch

- [x] `home/component/WhySection.vue`

### Step 4.13 — Section 12: Who we are

- [x] `home/component/AboutSection.vue` — placeholder image + copy

### Step 4.14 — Section 14: Contact (shell only)

- [x] `home/component/ContactSection.vue` — intro + contact form + schedule CTA
- [x] Footer/contact email from Inertia `site.contactEmail` (fallback placeholder)
- [x] `id="contact"` anchor for nav

### Step 4.15 — Section 16: Blog preview

- [x] `home/component/BlogPreviewSection.vue` → `/blog` (latest 3 from DB)

### Step 4.16 — Scroll motion

- [x] Hero / key sections use `motion-safe` enter animations
- [ ] Optional: broader scroll-reveal on all sections (nice-to-have)

### Step 4.17 — Portfolio and blog pages

- [x] `GET /portfolio` — DB listing (paginated)
- [x] `GET /blog` — DB listing (paginated)
- [x] Study case + article detail by **slug**
- [x] Browser/Feature coverage for these controllers
- [x] Admin CMS under `/core` (Briefing Phase 2 — delivered early)

### Step 4.18 — Home browser test

- [x] Home browser/feature smoke (`HomeControllerTest`, `SmokeHomeTest`, etc.)

### Stage 4 — Done when

- [x] `/` renders all 16 sections with Stage 1 copy
- [x] Marketing layout on home; mobile nav works
- [x] Portfolio/blog reachable (DB-backed)
- [x] Home browser tests pass
- [x] Footer Privacy/Terms

---

# Stage 5 — Service landing pages

**Briefing checklist:** “Implement service landing pages”  
**Goal:** SEO/paid-traffic landing pages from one template.  
**Prerequisites:** Stage 0, Stage 2 copy, Stage 4 layout (header/footer).  
**Status:** **Done** — explicit per-slug routes/controllers/pages + tests. Catalog now has **six** services (original five + `content-creation`). Landing body copy remains in Vue; FAQs/testimonials/related services from DB (`RendersServiceLanding`).

### Step 5.1 — Config and slug validation

- [x] Site chrome config lives in `config/site.php` (not required for explicit service routes)
- [x] Invalid / unknown service paths → 404 (`ReturnsNotFoundForUnknownServiceSlugsTest`)

### Step 5.2 — Controller and route

- [x] Per-service invokable controllers (e.g. `ServiceLeadGenerationController`)
- [x] Explicit `GET /services/{slug}` routes for all catalog slugs

### Step 5.3 — Page template

- [x] Shared landing pattern: H1, hero, benefits, process, CTA, Inertia `Head` + OG
- [x] Paid-traffic pattern: primary CTA above fold + repeat lower on page
- [x] “Also explore” related services from catalog

### Step 5.4 — Implement service pages (content wiring)

- [x] `lead-generation`
- [x] `email-marketing`
- [x] `website-design-and-development`
- [x] `content-creation`
- [x] `business-automations`
- [x] `custom-software-development`

### Step 5.5 — Navigation integration

- [x] Services dropdown in header from Eloquent `servicesNav`
- [x] Home service cards link to services (covered in tests)

### Step 5.6 — Browser test

- [x] Browser tests per service controller (incl. `lead-generation`, `content-creation`)
- [x] Feature test: unknown slug 404

### Stage 5 — Done when

- [x] All catalog service URLs live with Stage 2-style copy (+ content-creation)
- [x] One H1 per page; meta unique per page

---

# Stage 6 — Lead form with email delivery

**Briefing checklist:** “Implement lead form with email delivery”  
**Goal:** Contact form submits to Laravel and sends email notification (Slack optional; CRM TBD).  
**Prerequisites:** Stage 4 contact section shell; `.env` mail config.  
**Status:** **Done (code)** — form on home; Turnstile (fail closed); email to `CONTACT_EMAIL` with retry; Slack skipped when unset; CRM placeholder comment. Toast feedback on marketing layout. Completing this unblocks Stage 3.

### Step 6.1 — Form request validation

- [x] `StoreContactRequest` — name + email required; phone optional (US format); Turnstile token required
- [x] No `message` field (product decision)

### Step 6.2 — Controller and route

- [x] `POST /contact` → `ContactController@store`
- [x] Rate limit (5/min per IP)
- [x] Cloudflare Turnstile via `ryangjchandler/laravel-cloudflare-turnstile` (see `docs/integration/TURNSTILE_SETUP.md`)

### Step 6.3 — Mailable and integrations

- [x] `LeadNotification` mailable
- [x] `resources/views/emails/lead-notification.blade.php`
- [x] Recipient: `CONTACT_EMAIL` (`config/site.php` → `site.contactEmail`)
- [x] Single `LeadSubmissionService` — Turnstile verify, email retry, optional Slack
- [x] Slack via `SLACK_BOT_USER_OAUTH_TOKEN` + `SLACK_BOT_USER_DEFAULT_CHANNEL` (skip when empty; log failures)
- [x] CRM: comment only — under development (user success does not depend on CRM yet)

### Step 6.4 — Frontend form

- [x] `ContactForm.vue` — Reka Input/Label + Turnstile widget
- [x] `data-test="contact-name"`, `contact-email`, `contact-phone`, `contact-submit`
- [x] Success toast (`AppLayout` Toaster); validation errors inline
- [x] Wired into `ContactSection.vue`; keep “Book a discovery call” CTA

### Step 6.5 — Tests

- [x] `tests/Feature/ContactFormTest.php` — validation, Mail::fake, Slack, throttle
- [x] Browser test — happy path submit (Turnstile mocked / testing token)

### Stage 6 — Done when

- [x] Form on home submits and sends email
- [x] Validation and throttle verified by tests

---

# Stage 7 — Scheduling via contact form + Calendar email

**Briefing checklist:** “Integrate Google Calendar redirect”  
**Goal:** Booking CTAs send visitors to the contact form; after submit, the lead receives an email with the Google Calendar scheduling link (`CALENDAR_URL`).  
**Prerequisites:** Step 0.1 Calendar link; Stage 6 contact form.  
**Status:** **Mostly done (code)** — CTAs point to `/#contact`; `SendLeadSchedulingEmail` mails the lead when `CALENDAR_URL` is set. **Still open:** production `CALENDAR_URL` value.

### Step 7.1 — Config

- [x] `config/site.php` → `'calendar_url' => env('CALENDAR_URL')` (used by the scheduling email, not public CTAs)
- [x] Document in `.env.example` (`CALENDAR_URL`)
- [x] Document in `.env.example` (`CONTACT_EMAIL`)

### Step 7.2 — CTA wiring

- [x] Header / hero / service / portfolio / blog “Book a call” CTAs → `/#contact` (or `#contact` when label includes the anchor)
- [x] No direct public redirect to Google Calendar from marketing CTAs

### Step 7.3 — Lead scheduling email

- [x] `SendLeadSchedulingEmail` listener on `ContactLeadSubmitted`
- [x] `LeadSchedulingEmail` mailable → lead’s email with `CALENDAR_URL` button
- [x] Skip (with log warning) when `CALENDAR_URL` is unset
- [x] Generic “Book a discovery call” wording in place (duration TBD)

### Step 7.4 — Test

- [x] Feature tests: scheduling email sent / skipped / retries
- [x] Browser test: schedule CTAs `href` is `/#contact`

### Stage 7 — Done when

- [ ] Production `CALENDAR_URL` set so leads receive a real booking link
- [x] Booking CTAs route to the contact form
- [x] Contact submit emails the lead a Calendar link when configured
- [x] Href assertion covered by a test

---

# Stage 8 — GA and Meta Pixel (no consent banner)

**Briefing checklist:** “Add GA and Meta Pixel” (cookie consent banner dropped for US / Florida MVP)  
**Goal:** Inject GA4 and Meta Pixel when measurement IDs are configured — without a consent banner.  
**Prerequisites:** Stage 0; Stage 4 layout; GA/Meta IDs in `.env`; Stage 3 Privacy discloses analytics without consent gating.  
**Status:** **Done** (scripts). Consent UI **cancelled** — [decision](./decisions/2026-08-05-no-cookie-consent-banner.md). IDs live in `config/site.php` (same pattern as calendar/email).

### Step 8.1 — Config

- [x] `google_analytics_id`, `meta_pixel_id` in `config/site.php` (+ Inertia shared `site` props)
- [x] `.env.example` entries (`GOOGLE_ANALYTICS_ID`, `META_PIXEL_ID`)

### Step 8.2 — Cookie consent UI

- [x] **Cancelled** — no banner, no `localStorage` consent choice ([decision](./decisions/2026-08-05-no-cookie-consent-banner.md))

### Step 8.3 — Analytics loader

- [x] Inject GA4 + Meta Pixel in `resources/views/app.blade.php` when IDs are set
- [x] Do **not** gate on consent

### Step 8.4 — Tests

- [x] Feature test: unset IDs → no analytics scripts in response
- [x] Feature test: mocked IDs set → tags/IDs present in HTML
- [x] Browser test: configured IDs appear in page source

### Stage 8 — Done when

- [x] Scripts load when IDs are configured; nothing loads when unset
- [x] Privacy Policy copy stays aligned (no consent-banner claims)

---

# Stage 9 — Technical SEO and polish

**Goal:** Search engines and social previews see a complete, branded site.  
**Prerequisites:** Stages 4–5 complete for most items; Stage 3 for legal Head/sitemap entries; Stages 6–8 (analytics scripts optional before SEO close-out) before final SEO close-out.  
**Status:** **Done** (KISS: Vue `Head` OG tags, home JSON-LD, static `robots.txt` / `llms.txt`, dynamic `sitemap.xml`).

### Step 9.1 — Per-page Head audit

- [x] Unique `<title>` + meta description on home and service landings (incl. content-creation)
- [x] Privacy, terms (title + meta description)
- [x] Portfolio / blog pages have titles

### Step 9.2 — Open Graph

- [x] Service pages: `og:title`, `og:description`, `og:image`
- [x] Home + remaining pages: OG title/description/image (shared default image where needed)

### Step 9.3 — Structured data + LLMO / GEO

- [x] JSON-LD on home: `Organization`, `ProfessionalService` (local), `WebSite`, `FAQPage`
- [x] `public/llms.txt` — plain-language entity summary for LLM / generative engines
- [x] `robots.txt` allows common AI crawlers and points to the sitemap

### Step 9.4 — Crawling

- [x] `public/robots.txt` (allow-all + AI crawlers + sitemap)
- [x] `GET /sitemap.xml` — Phase 1 public URLs (home, services, portfolio, blog, legal + DB articles/case studies)

### Step 9.5 — Favicon and cleanup

- [x] Favicon present (`public/favicon.ico`, `favicon.svg`)
- [x] Remove unused `Welcome.vue` / starter references
- [x] CTA contrast review (accent button uses `text-brand-bg` on `bg-brand-accent`)
- [x] Branded error pages (404, 500, 503)

### Step 9.6 — Open design decisions

- [x] Defaults in CSS: text-on-dark B, light section L1
- [ ] Confirm with founders (text-on-dark B, light L1, mobile logo scale) — Stage 10 sign-off

### Stage 9 — Done when

- [x] sitemap lists all public routes
- [x] No Laravel starter branding remains on public surfaces (`Welcome.vue` removed)
- [x] JSON-LD + OG audit complete (home structured data; OG on marketing pages)
- [x] `llms.txt` published for LLMO / GEO
---

# Stage 10 — QA and acceptance

**Goal:** Phase 1 meets Briefing success criteria and repo quality gates.  
**Status:** Code QA done (2026-08-11). Blocked only on founder sign-off + production ops (0.1 / env IDs).

### Step 10.1 — Automated gates

```bash
./vendor/bin/sail npm run build
./vendor/bin/sail artisan test --parallel --coverage --min=90
./vendor/bin/sail exec laravel.test vendor/bin/pint --parallel
```

- [x] `npm run build` green
- [x] Full suite green (329 tests, coverage 100% ≥ 90)
- [x] Pint green (247 files)
- [x] Type coverage green (100% ≥ 90)

### Step 10.2 — Manual smoke checklist

- [x] Home: all 16 sections; portfolio/blog reachable
- [x] Service landings live (6 catalog slugs)
- [x] Legal pages (Feature + Browser: `/privacy`, `/terms`)
- [x] Contact form → email flow covered (Feature + Mail::fake / listeners; Mailpit available locally)
- [x] Schedule path → contact form → Calendar email when `CALENDAR_URL` set (Feature + Browser CTAs → `/#contact`)
- [x] Analytics scripts load when IDs set; absent when unset (Feature + Browser; no consent banner)
- [ ] Mobile header + contact form usable — **founder visual check** (no dedicated viewport E2E)

### Step 10.3 — Founder sign-off

- [ ] Marketing copy approved
- [ ] Privacy + Terms approved
- [ ] `.env` production values documented (not committed)

### Phase 1 — Definition of Done

- [ ] All Stage 1–10 checklists complete (remaining: 0.1 ops, founder 10.2 mobile + 10.3, production analytics IDs)
- [x] Browser tests: public marketing routes for home, services, portfolio, blog
- [x] Admin CMS + public Eloquent wiring (Briefing Phase 2 — done early)
- [x] Browser tests: contact form + schedule CTAs point to `/#contact`
- [x] Brand theme applied throughout marketing surfaces

---

## Risks and mitigation

| Risk | Mitigation |
|------|------------|
| No real portfolio/testimonials yet | Seeded / honest placeholders; strong FAQ and Who we are; Phase 3 content |
| Copy blocks implementation | Stages 1–2 delivered inline; Stage 3 legal waits on Stage 6 |
| Brand assets missing | Stage 0.2 done |
| No staging environment | Stage 10 automated tests + production build before deploy |
| Gmail for leads | Acceptable MVP; WorkMail later |
| Plan drift (Markdown loader / empty stubs) | Documented above; follow precedence 8 → 9 → 10 |
| Legal drafted before product behavior | Mitigated by Stage 3 after Stage 6; Privacy re-aligned when consent banner was cancelled |
| Orphaned MinIO/S3 objects | Deferred cleanup follow-up below |

---

## Suggested next implementation order

1. **Stage 10** — automated + founder QA  
2. **Ops (parallel)** — production `CALENDAR_URL`, `CONTACT_EMAIL`, analytics IDs, Turnstile, Slack

---

## Post–Phase 1 / CMS status

**Briefing Phase 2 (CMS) is delivered** — persistence, `/core` admin, and public list/detail wiring. See [phase-01-backend.md](./phase-01-backend.md).

**Briefing Phase 3** owns real content: founder photography, launch portfolio items, real testimonials, initial blog posts, ads, GBP, organic social.

### Open follow-up — object storage image cleanup

Admin CMS uploads (case study gallery, blog main/inline images) go through `MediaUploader::store()` and persist a **public URL** on the model. Soft-deleting a gallery row, soft-deleting a blog article, or replacing a blog image **does not** delete the object from MinIO/S3 today.

**Why deferred:** the uploader returns only a URL, not a durable storage key. Deleting by parsing the URL is fragile across disks (local vs S3/MinIO).

**Follow-up (when building CMS polish):**

- [ ] Persist the storage **key/path** (or return both key + URL from `MediaUploader`)
- [ ] Add `MediaUploader::delete()` (or equivalent) and call it when:
  - [ ] A case study gallery image is removed on update
  - [ ] A case study is hard-deleted / permanently purged (if ever)
  - [ ] A blog main image is replaced on update (`BlogArticleController::update`)
  - [ ] A blog article is soft-deleted (`BlogArticleController::destroy`) and its cover image is cleaned up
  - [ ] Orphaned inline content images are cleaned up (optional; harder)
- [ ] Cover with `Storage::fake()` feature tests
- [ ] Record the locked approach in [phase-01-backend/media.md](./phase-01-backend/media.md)

Until then, orphaned objects in object storage are acceptable for MVP.

---

## Operational checklist (founders — production go-live)

Non-code items (overlap with Step 0.1; re-verify before launch):

- [ ] DNS live: `.io` canonical; redirects from `.agency` / `.marketing`
- [ ] `GOOGLE_ANALYTICS_ID`, `META_PIXEL_ID`, `CALENDAR_URL`, `CONTACT_EMAIL`, Turnstile + Slack keys set in production
- [ ] Search Console verified
- [ ] Google Business Profile (if decided)
- [ ] Founder review: copy + legal (Stage 10.3)
