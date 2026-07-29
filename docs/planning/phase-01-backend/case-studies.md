# Domain: Case studies (Portfolio)

**Status:** Interview complete  
**Goal:** Simplify — avoid overengineering.  
**Public shells today:** `PortfolioController`, study-case detail, home portfolio preview.

---

## Decisions (locked)

| # | Decision | Date | Notes |
|---|----------|------|-------|
| D1 | **Full case study in DB (simplified schema)** | 2026-07-29 | CMS owns listing + detail. SoftDeletes on case studies and images. M:N services via `case_study_service`. Gallery via `case_study_images`. |
| D2 | **`slug` from title via Observer; `/portfolio/study-case/{slug}`** | 2026-07-29 | Observer from `title`. Controller create/update must comment that an Observer runs. |
| D3 | **List/home cover = first gallery image; skip it in carousel** | 2026-07-29 | Lowest `sort_order` = cover; omit from detail carousel. |
| D4 | **`content` same as blog** | 2026-07-29 | Same FOSS editor / single-format rules as blog. |
| D5 | **Home preview = 6 random** | 2026-07-29 | `inRandomOrder()->limit(6)`. |
| D6 | **Portfolio listing: 15/page, `created_at` desc** | 2026-07-29 | |
| D7 | **Admin: nested images + services on CaseStudy resource** | 2026-07-29 | `index/create/store/edit/update/destroy`; `show` → 404. Manage images and service links on Create/Edit. **No** separate `CaseStudyImageController` resource. |

---

## Locked model

### `case_studies`

| Column | Type | Notes |
|--------|------|--------|
| `id` | UUID PK | |
| `title` | string | |
| `slug` | string unique | Observer from `title` |
| `description` | text | |
| `client` | string | |
| `industry` | string | |
| `challenge` | text | |
| `content` | text | Same as blog content rules |
| `created_at` / `updated_at` | timestamps | |
| `deleted_at` | timestamp nullable | SoftDeletes |

### `case_study_service`

| Column | Type | Notes |
|--------|------|--------|
| `case_study_id` | UUID FK | |
| `service_id` | UUID FK | |
| `created_at` / `updated_at` | timestamps | |

Unique (`case_study_id`, `service_id`). No soft deletes on join.

### `case_study_images`

| Column | Type | Notes |
|--------|------|--------|
| `id` | UUID PK | |
| `case_study_id` | UUID FK | |
| `url` | string | S3/MinIO |
| `alt` | string | |
| `sort_order` | integer | First = cover |
| `created_at` / `updated_at` | timestamps | |
| `deleted_at` | timestamp nullable | SoftDeletes |

**Public:** `/portfolio` paginate 15 `created_at` desc; detail `/portfolio/study-case/{slug}`; home 6 random; cover = first image; carousel skips first.  
**Admin:** CaseStudy resource only; nested images + service sync on forms.

---

## Rejected / out of scope

- Hardcoded-only portfolio detail
- Dedicated cover column
- Separate CaseStudyImage admin resource
- Old mega demo field list as separate columns

---

## Interview queue

| Q# | Topic | Status |
|----|--------|--------|
| Q1–Q7 | All | **Done** → D1–D7 |

---

## Interview log

### 2026-07-29

Schema + slug route + cover/carousel + blog-like content + home 6 random + listing 15 desc + nested admin.

**Applied:** D1–D7. Case studies interview complete.

### Next domain

Continue with **Media** — see [media.md](./media.md).
