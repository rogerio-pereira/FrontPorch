# Domain: FAQs

**Status:** Interview complete  
**Goal:** Simplify — avoid overengineering.  
**Public shells today:** home FAQ demo; service landings to gain FAQ sections.

---

## Decisions (locked)

| # | Decision | Date | Notes |
|---|----------|------|-------|
| D1 | **Home + per-service FAQs** | 2026-07-29 | Nullable `service_id`: **null** = home; **set** = service landing. Wire FAQs into service landings. **Hide the entire FAQ section** when that service has zero FAQs. |
| D2 | **No publish flag; SoftDeletes** | 2026-07-29 | Same as blog/services. No `is_published`. |
| D3 | **Fields: `question`, `answer`, `sort_order` (+ `service_id`)** | 2026-07-29 | No extra FAQ-specific columns. |
| D4 | **Admin resource like Blog/Services** | 2026-07-29 | `index`, `create`, `store`, `edit`, `update`, `destroy`; `show` → 404. |
| D5 | **UUID primary key** | 2026-07-29 | `id` is UUID PK. |

---

## Locked model

Table: `faqs`

| Column | Type | Notes |
|--------|------|--------|
| `id` | UUID PK | |
| `service_id` | UUID FK nullable → `services` | null = home; set = service landing |
| `question` | string | |
| `answer` | text | |
| `sort_order` | integer | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |
| `deleted_at` | timestamp nullable | SoftDeletes |

**Explicitly not in schema:** `is_published`.

**Public:** home loads FAQs where `service_id` is null; service landings load FAQs for that service and hide the section if empty.  
**Admin:** resource under `/core/…` like blog (`show` → 404).  
**Seeder:** home FAQs from current demo (per-service optional).

---

## Rejected / out of scope

- Home-only or service-only FAQ scopes
- `is_published` / draft visibility

---

## Interview queue

| Q# | Topic | Status |
|----|--------|--------|
| Q1 | Scope | **Done** → D1 |
| Q2 | Publish / soft delete | **Done** → D2 |
| Q3 | Fields | **Done** → D3 |
| Q4 | Admin | **Done** → D4 |
| Q5 | UUID PK | **Done** → D5 |

---

## Interview log

### 2026-07-29 — Q1–Q5

- Home + per-service; hide empty FAQ sections on landings.
- DB + SoftDeletes; no publish flag.
- `question`, `answer`, `sort_order`.
- Admin resource like blog (`show` → 404).
- UUID PK.

**Applied:** D1–D5. FAQs interview complete.

### Next domain

Continue with **Testimonials** — see [testimonials.md](./testimonials.md).
