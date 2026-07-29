# Domain: Testimonials

**Status:** Interview complete  
**Goal:** Simplify — avoid overengineering.  
**Public shells today:** home testimonials; service landings to gain testimonial sections.

---

## Decisions (locked)

| # | Decision | Date | Notes |
|---|----------|------|-------|
| D1 | **Every testimonial belongs to a service** | 2026-07-29 | `service_id` **required** FK → `services`. No home-only testimonials. |
| D2 | **Home = 10 random** | 2026-07-29 | `inRandomOrder()->limit(10)` across all services (not soft-deleted). |
| D3 | **Service pages = 5 random; no `sort_order`** | 2026-07-29 | Landing: `inRandomOrder()->limit(5)` for that `service_id`. No `sort_order`. |
| D4 | **Locked schema** | 2026-07-29 | `person`, `testimonial`, required `service_id`; SoftDeletes; UUID PK; no publish flag. |
| D5 | **Admin resource like Blog/Services/FAQs** | 2026-07-29 | `index`, `create`, `store`, `edit`, `update`, `destroy`; `show` → 404. |
| D6 | **Hide empty testimonials sections** | 2026-07-29 | Hide the **entire** block on service landings **and on home** when there are no testimonials to show. |

---

## Locked model

Table: `testimonials`

| Column | Type | Notes |
|--------|------|--------|
| `id` | UUID PK | |
| `person` | string | Who said it (was `attribution`) |
| `testimonial` | text | Quote body (was `quote`) |
| `service_id` | UUID FK required → `services` | |
| `created_at` | timestamp | |
| `updated_at` | timestamp | |
| `deleted_at` | timestamp nullable | SoftDeletes |

**Explicitly not in schema:** `quote`, `attribution`, `sort_order`, `is_published`.

**Public:** home 10 random (hide section if none); service landing 5 random for that service (hide section if none).  
**Admin:** resource under `/core/…` (`show` → 404).

---

## Rejected / out of scope

- Nullable `service_id` / home-only testimonials
- `sort_order`, `is_published`
- Extra fields (photo, rating, separate company, etc.)

---

## Interview queue

| Q# | Topic | Status |
|----|--------|--------|
| Q1–Q5 | All topics | **Done** → D1–D6 |

---

## Interview log

### 2026-07-29

- Required `service_id`; home 10 / landing 5 via `inRandomOrder()`; no `sort_order`.
- Schema: uuid, `person`, `testimonial`, `service_id`, timestamps, SoftDeletes.
- Admin like blog (`show` → 404).
- Hide empty section on landings **and home**.

**Applied:** D1–D6. Testimonials interview complete.

### Next domain

Continue with **Case studies** — see [case-studies.md](./case-studies.md).
