# Domain: Media / uploads

**Status:** Interview complete  
**Goal:** Simplify — avoid overengineering.  
**Depends on:** Blog main + inline images; case study gallery + content editor.

---

## Decisions (locked)

| # | Decision | Date | Source |
|---|----------|------|--------|
| D1 | **S3-compatible storage via MinIO in Sail/Docker** | 2026-07-29 | Blog interview |
| D2 | **Authenticated uploads only** | 2026-07-29 | Briefing |
| D3 | **Blog: main image + inline content images** | 2026-07-29 | Blog D5/D13. “Inline” = editor insert of a stored image URL (markdown/`<img>`), not base64 data URLs. |
| D4 | **Case study gallery (+ content) uses same storage** | 2026-07-29 | Case studies |
| D5 | **Simple `MediaUploader::store()` helper** | 2026-07-30 | Upload file → object storage → return URL. Editor flow: button → modal → upload → insert URL into content. No base64 inline parsing. |
| D6 | **Light image validation** | 2026-07-29 | Minimal Form Request rules (`image` / `mimes` / `max`); not a heavy custom policy. |
| D7 | **Paths by domain** | 2026-07-29 | e.g. `blog/…`, `case-studies/…` on the S3/MinIO disk. |
| D8 | **No object cleanup in MVP** | 2026-07-30 | Soft-delete / replace rows leave storage objects in place. `MediaUploader` returns URL only (no key). Cleanup is a follow-up — see [phase-01.md](../phase-01.md) Post–Phase 1. |

---

## Locked approach

- Sail **MinIO** + Laravel `s3` disk (env as in parent plan)
- Store public URL (or key + URL helper) on models (`image`, `case_study_images.url`, inline URLs in content)
- `MediaUploader` is a basic store helper only (no base64 / data-URL rewriting)
- Tests: `Storage::fake()`
- No Spatie in MVP
- **MVP:** deleting a gallery image or replacing a blog image updates the DB only; object storage cleanup is deferred (D8)

---

## Rejected / out of scope

- Base64 / data-URL scraping from editor HTML
- Heavy custom validation matrix
- Spatie Media Library
- Deleting S3/MinIO objects by parsing public URLs (fragile; wait for stored keys)

---

## Follow-up (not MVP)

When cleanup is implemented:

1. Persist storage **key/path** alongside (or instead of relying solely on) the public URL.
2. Add `MediaUploader::delete(string $key)` (or delete-by-url only if key is recoverable safely).
3. Call it from case study gallery remove / blog image replace flows.
4. Feature tests with `Storage::fake()`.

Tracked in [phase-01.md](../phase-01.md) → Post–Phase 1.

---

## Interview queue

| Q# | Topic | Status |
|----|--------|--------|
| Q1–Q4 | All | **Done** → D1–D7 |
| — | Object cleanup | **Deferred** → D8; checklist in [phase-01.md](../phase-01.md) |

---

## Interview log

### 2026-07-29

MinIO; submit-only uploads; light validation; domain folder prefixes.

**Applied:** D1–D7. Media interview complete.

### 2026-07-30

Case study admin PR: removing gallery images soft-deletes DB rows only. Object cleanup deferred until storage keys are persisted (D8).

**Applied:** D8. Follow-up checklist in parent Phase 1 plan.

### Next domain

Continue with **Shared platform** — see [shared.md](./shared.md).
