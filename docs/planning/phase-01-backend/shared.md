# Domain: Shared platform

**Status:** Interview complete  
**Covers:** auth/admin shell, UUID strategy, site config via `.env`, route prefix, policies, admin Users CRUD.

---

## Decisions (locked)

| # | Decision | Date | Notes |
|---|----------|------|-------|
| D1 | **Admin prefix `/core/*` + `App\Http\Controllers\Core`** | 2026-07-29 | Route names `core.*`. Controllers under `App\Http\Controllers\Core`. |
| D2 | **`users.id` = UUID PK** | 2026-07-29 | Migrate existing `users` primary key to UUID. Backfill existing rows. |
| D3 | **Env site config (narrow)** | 2026-07-29 | `FOOTER_CONTACT_EMAIL`, `CALENDAR_URL`. Footer tagline + location stay hardcoded in Vue. |
| D4 | **Auth only — no ACL** | 2026-07-29 | Middleware: **`auth` only**. No RBAC/policies. Fortify registration disabled. |
| D5 | **Admin Users CRUD under `/core`** | 2026-07-29 | Manage users in the admin area. |
| D6 | **Users fields = existing User model; no SoftDeletes** | 2026-07-29 | `name`, `email`, `password` (+ password confirmation on forms). Hard delete. |
| D7 | **Users admin resource like other CMS resources** | 2026-07-29 | `index`, `create`, `store`, `edit`, `update`, `destroy`; `show` → 404. |

---

## Locked summary

- Branch: `feat/admin-cms`
- Admin: `/core/*`, `core.*`, `App\Http\Controllers\Core`, `auth` only
- Sidebar includes **Users**
- UUID PK on User + all CMS content models
- Env: `FOOTER_CONTACT_EMAIL`, `CALENDAR_URL` (wired via config / Inertia when implementing)

---

## Rejected / out of scope

- `/code` prefix
- `verified` middleware for CMS
- ACL / RBAC / policies in MVP
- SoftDeletes on User
- `FOOTER_TAGLINE` / `LOCATION_LINE` env keys

---

## Interview queue

| Q# | Topic | Status |
|----|--------|--------|
| Q1–Q7 | All | **Done** → D1–D7 |

---

## Interview log

### 2026-07-29

`/core` + Core; users UUID PK; env email/calendar only; auth-only; Users CRUD with existing fields + password confirmation; no SoftDeletes; resource without Show.

**Applied:** D1–D7. Shared interview complete.

### Next

All domain interviews complete. Sync parent plan [../phase-01-backend.md](../phase-01-backend.md) as the implementation source of truth, then implement on `feat/admin-cms`.
