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
| D3 | **Blog: main image + inline content images** | 2026-07-29 | Blog D5/D13 |
| D4 | **Case study gallery (+ content) uses same storage** | 2026-07-29 | Case studies |
| D5 | **Uploads on parent form submit only** | 2026-07-29 | No dedicated `POST /core/media`. Multipart on parent `store`/`update`. |
| D6 | **Light image validation** | 2026-07-29 | Minimal Form Request rules (`image` / `mimes` / `max`); not a heavy custom policy. |
| D7 | **Paths by domain** | 2026-07-29 | e.g. `blog/…`, `case-studies/…` on the S3/MinIO disk. |

---

## Locked approach

- Sail **MinIO** + Laravel `s3` disk (env as in parent plan)
- Store public URL (or key + URL helper) on models (`image`, `case_study_images.url`, inline URLs in content)
- Upload during parent resource save; no `MediaUploadController`
- Tests: `Storage::fake('s3')`
- No Spatie in MVP

---

## Rejected / out of scope

- Dedicated media upload API for mid-edit inserts
- Heavy custom validation matrix
- Spatie Media Library

---

## Interview queue

| Q# | Topic | Status |
|----|--------|--------|
| Q1–Q4 | All | **Done** → D1–D7 |

---

## Interview log

### 2026-07-29

MinIO; submit-only uploads; light validation; domain folder prefixes.

**Applied:** D1–D7. Media interview complete.

### Next domain

Continue with **Shared platform** — see [shared.md](./shared.md).
