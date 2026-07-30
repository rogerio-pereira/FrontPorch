# Domain: Services

**Status:** Interview complete  
**Goal:** Simplify — avoid overengineering.  
**Public shells today:** home service cards/nav; five service landing Vue pages with hardcoded copy.

---

## Decisions (locked)

| # | Decision | Date | Notes |
|---|----------|------|-------|
| D1 | **CMS = catalog only; landing copy stays in Vue** | 2026-07-29 | Long-form service landing body remains hardcoded in frontend. DB drives listing/nav catalog (+ FKs for other domains later). |
| D2 | **Fields: `title`, `description`, `slug`, `sort_order`** | 2026-07-29 | Renamed planned `teaser` → `description`. **No `nav_label`** — header/nav uses `title`. Keep `sort_order`. |
| D3 | **`slug` from `title` via Observer** | 2026-07-29 | Observer generates `slug` from `title`. Controller create/update must comment that an Observer runs (same pattern as blog). |
| D4 | **Full admin CRUD like Blog; seed the current five** | 2026-07-29 | Resource: `index`, `create`, `store`, `edit`, `update`, `destroy`; `show` empty or **404**. The **five current services** must exist via a seeder. |
| D5 | **No publish flag; SoftDeletes** | 2026-07-29 | No `is_published`. Row in DB and not soft-deleted ⇒ visible on home/nav. |
| D6 | **UUID primary key** | 2026-07-29 | `id` is UUID PK, same as blog articles. |

---

## Locked model

Table: `services`

| Column | Type | Notes |
|--------|------|--------|
| `id` | UUID PK | |
| `title` | string | Home cards + header nav label |
| `description` | string | Short blurb on home service cards (was `teaser`) |
| `slug` | string unique | From `title` via Observer; public URL `/services/{slug}` |
| `sort_order` | integer | Order of cards and nav |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |
| `deleted_at` | timestamp nullable | SoftDeletes |

**Explicitly not in schema:** `teaser`, `nav_label`, `is_published`, CMS-managed landing body/copy.

**Observer:** set `slug` from `title` via `Str::slug`.  
**Uniqueness:** Form Request `Rule::unique` on the derived slug + DB unique index (no collision suffixes).  
**Controller:** comment on create/update that the Observer runs.  
**Admin:** full resource like Blog (`show` → 404).  
**Seeder:** five current services.  
**Frontend:** landing copy hardcoded in Vue; home cards + nav from DB.

---

## Rejected / out of scope

- Editing landing page body via CMS
- Separate `nav_label` column
- Admin limited to “edit five only”
- `is_published` / draft-style visibility

---

## Interview queue

| Q# | Topic | Status |
|----|--------|--------|
| Q1 | CMS vs Vue + field set | **Done** → D1–D3 |
| Q2 | CRUD + seeder | **Done** → D4 |
| Q3 | Publish flag | **Done** → D5 |
| Q4 | Soft deletes | **Done** → D5 |
| Q5 | UUID PK | **Done** → D6 |

---

## Interview log

### 2026-07-29 — Start (after Blog complete)

Blog domain locked; starting Services interview.

### 2026-07-29 — Clarification (catalog fields)

Documented intended uses of title/teaser/nav/slug/order (see prior revision history). Landing body not driven by catalog fields.

### 2026-07-29 — Q1 (user)

- `teaser` → `description`; no nav field (use `title`); `slug` via Observer + controller comment; keep `title` + `sort_order`; copy hardcoded in frontend.

**Applied:** D1–D3.

### 2026-07-29 — Q2 (user)

- Full CRUD like Blog (`show` → 404); seed the five current services.

**Applied:** D4.

### 2026-07-29 — Q3 (user)

- No `is_published` — presence in DB + soft delete only.

**Applied:** D5.

### 2026-07-29 — Q5 (user)

- UUID as primary key, same as blog.

**Applied:** D6. Services interview complete.

### Next domain

Continue with **FAQs** — see [faqs.md](./faqs.md).
