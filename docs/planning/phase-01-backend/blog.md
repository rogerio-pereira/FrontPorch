# Domain: Blog

**Status:** Interview complete (pending final sync into parent plan implementation slices)  
**Goal:** Simplify — avoid overengineering.  
**Public shells today:** `BlogController`, `BlogArticleController`, `Blog.vue`, `BlogArticle.vue`, home `BlogPreviewSection`.

---

## Decisions (locked)

| # | Decision | Date | Notes |
|---|----------|------|-------|
| D1 | **No category taxonomy table** | 2026-07-29 | No `BlogCategory`, `blog_categories`, or category CRUD resource. Free-text `category` **string** on the article is OK (label only, not a relation). |
| D2 | **Single content format** | 2026-07-29 | **One** storage format only — not dual Markdown+HTML. Prefer **Markdown** for easier writing. If Markdown would require adding a dedicated markdown parser solely for public rendering, **use HTML instead**. No `format` column. |
| D3 | **No drafts** | 2026-07-29 | If the row exists in the DB (and is not soft-deleted), it is **published**. No `is_published`, no `published_at`. |
| D4 | **`published_by` via Observer** | 2026-07-29 | Stores the user **name**. Observer sets it on create. Controller `store` must include a comment that the method triggers the observer. |
| D5 | **Main image + inline content images** | 2026-07-29 | Form **requires** a main `image` (URL after S3/MinIO upload) used on listings/home. Editor can upload additional images inserted **inline** into `content`. |
| D6 | **Soft deletes** | 2026-07-29 | `deleted_at` — SoftDeletes. Soft-deleted articles must not appear on public listing/detail. |
| D7 | **Primary key = UUID** | 2026-07-29 | Table id is UUID (not bigint + separate uuid column for this model). |
| D8 | **Locked schema** | 2026-07-29 | See “Locked model” below. |
| D9 | **`slug` from title via Observer; public route `/blog/article/{slug}`** | 2026-07-29 | Column `slug` unique. Observer generates from `title`. Public detail: `/blog/article/{slug}`. |
| D10 | **Home preview = latest 3 by `created_at`** | 2026-07-29 | No featured flag. `orderByDesc('created_at')->limit(3)`. Soft-deleted excluded. |
| D11 | **Public listing paginated, 15 per page** | 2026-07-29 | `/blog`: `orderByDesc('created_at')`, paginate 15. Soft-deleted excluded. |
| D12 | **Admin: resource without Show** | 2026-07-29 | Actions: `index`, `create`, `store`, `edit`, `update`, `destroy`. Resource controller OK; `show` empty or **404**. No dedicated Show page. |
| D13 | **Rich text editor (FOSS, no phone-home)** | 2026-07-29 | Toolbar: bold, italic, link, blockquote, code, image (upload), ordered/bullet lists, headings. External packages allowed only if **free**, **open source**, and **no phone-home**. Storage format follows D2 (Markdown preferred; HTML if that avoids a dedicated public MD parser). |

---

## Locked model

Table: `blog_articles`

| Column | Type | Notes |
|--------|------|--------|
| `id` | UUID PK | |
| `title` | string | |
| `slug` | string unique | Generated from `title` by Observer |
| `description` | string | Listing/teaser text |
| `category` | string | Free-text label only — not FK |
| `content` | text | Single format per D2 (Markdown preferred, else HTML) |
| `image` | string | Required main image URL (S3/MinIO); used on listings |
| `published_by` | string | User name; set by Observer on create |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |
| `deleted_at` | timestamp nullable | SoftDeletes |

**Explicitly not in schema:** `excerpt`, `cover_alt`, `author`, `body` JSON, `format`, `is_published`, `published_at`, `blog_category_id`.

**Observer responsibilities (create):** set `published_by` from auth user name; set `slug` from `title` (unique — handle collisions, e.g. suffix).  
**Controller `store`:** comment that the method triggers the observer (for `published_by` and `slug`).

**Admin:** resource under `/core/…` — `index`, `create`, `store`, `edit`, `update`, `destroy`; **`show` → 404** (or empty). No Show Vue page. Form: required main image + rich editor for `content`.  
**Public listing:** `/blog` — paginated **15**, `created_at` desc.  
**Public detail:** `/blog/article/{slug}`; soft-deleted → not listed / 404; render `content` per D2.  
**Home preview:** latest **3** by `created_at`.  
**Uploads:** main + inline images → MinIO/S3 (see [media.md](./media.md)).

---

## Rejected / out of scope (for this domain)

- `BlogCategory` model / table / admin CRUD / filtering taxonomy
- Draft workflow / `published_at` null = draft
- Dual content types / `format` column / JSON body-block editor
- Public routes `/blog/{slug}` or `/blog/article/{uuid}` as canonical (use `/blog/article/{slug}`)
- Proprietary or phone-home editor SaaS
- Spatie media library (unless Media domain forces otherwise)

---

## Interview queue

| Q# | Topic | Status |
|----|--------|--------|
| Q1 | Body format | **Done** → D2 (revised Q10) |
| Q2 | Publish workflow | **Done** → D3 |
| Q3 | Author / published_by | **Done** → D4 |
| Q4 | Cover / main image + upload | **Done** → D5 |
| Q5 | Soft deletes / PK | **Done** → D6, D7 |
| Q6 | Public URL + slug | **Done** → D9 |
| Q7 | Home preview | **Done** → D10 |
| Q8 | Listing order + pagination | **Done** → D11 |
| Q9 | Admin UI surface | **Done** → D12 |
| Q10 | Single format + editor requirements | **Done** → D2 (final), D5 (clarified), D13 |

---

## Interview log

### 2026-07-29 — Kickoff

- User: prior iteration overengineered; simplify by domain; start with blog + blog category.
- User: remove blog category first, then interview one question at a time.
- User: keep per-domain docs updated every interaction; fix contradictions in docs.

**Applied:** D1 (taxonomy removed); parent plan + Briefing Phase 2 updated.

### 2026-07-29 — Q1 + schema dump (user)

- Initial answer allowed Markdown or free HTML; later superseded by single-format rule (Q10).
- Editor must upload images → S3 via MinIO in local Docker.
- Schema: `id` (uuid), `title`, `description`, `category` (string), `content` (text), `image` (URL), `published_by` (observer; comment on `store`), timestamps, softDeletes.
- No drafts — if it is in the DB, it is published.
- First message draft had `published_at` nullable as draft; superseded by “no drafts”.

**Applied:** D3–D8 (D2 revised later); Media + parent plan updated.

### 2026-07-29 — Q6 (user)

- Add `slug` column; extract from `title`; Observer generates it.
- Public route: `/blog/article/{slug}`.

**Applied:** D9; Briefing sitemap + parent plan synced.

### 2026-07-29 — Q7 (user)

- Home preview: latest 3 by `created_at`.

**Applied:** D10.

### 2026-07-29 — Q8 (user)

- Public `/blog`: paginate 15 per page, newest first (`created_at` desc).

**Applied:** D11.

### 2026-07-29 — Q9 (user)

- Admin: `index`, `create`, `store`, `edit`, `update`, `destroy`.
- Resource controller OK; `show` empty or 404.

**Applied:** D12.

### 2026-07-29 — Language fix + Q10 (user)

- Not two content types — **one** format only.
- Prefer Markdown for writing; if that forces a dedicated markdown parser just for rendering, use HTML instead.
- Form requires a **main image** for listings; editor uploads insert **inline** images into `content`.
- Editor toolbar: bold, italic, link, blockquote, code, image (upload), ordered/bullet lists, headings.
- External packages: free, open source, no phone-home.

**Applied:** D2 (final), D5 (clarified), D13; file rewritten in English; parent plan + media synced.

### Next domain

Blog interview queue complete. Continue with **Services** — see [services.md](./services.md).
