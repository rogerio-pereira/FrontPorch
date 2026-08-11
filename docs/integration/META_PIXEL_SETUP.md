# Meta Pixel Setup

This document explains how to create a Meta (Facebook) Pixel and wire the Pixel ID into the Front Porch marketing site.

## What Meta Pixel does

Meta Pixel supports advertising measurement and audience building on Meta (Facebook / Instagram). It is **optional**. The Pixel script loads only when `META_PIXEL_ID` is set. An empty value means no Meta tags are injected.

Google Analytics is configured separately — see [Google Analytics 4 Setup](./GOOGLE_ANALYTICS_SETUP.md).

## Cookie consent (MVP)

This project does **not** show a cookie consent banner before loading analytics. That is intentional for the US / Florida MVP audience — see [decision: no cookie consent banner](../planning/decisions/2026-08-05-no-cookie-consent-banner.md).

The Privacy Policy discloses analytics cookies and states that no consent banner is shown. Revisit only if the audience expands to jurisdictions that require prior consent.

## How the app loads the Pixel

When `META_PIXEL_ID` is set, `resources/views/app.blade.php` injects `fbevents.js`, then runs `fbq('init', …)` and `fbq('track', 'PageView')`.

Config mapping:

```php
// config/site.php
'meta_pixel_id' => env('META_PIXEL_ID', null),
```

You only need to set the env var. No package install is required.

---

## How to get a Pixel ID

### 1. Open Meta Events Manager

1. Go to [https://business.facebook.com/events_manager](https://business.facebook.com/events_manager)
2. Sign in with the Meta / Facebook account that should own the Pixel
3. Select (or create) a **Meta Business** portfolio if prompted

### 2. Create a Pixel (dataset)

1. In Events Manager, choose **Connect data sources** → **Web** (or **Create a dataset** / **Pixel**, depending on the current Meta UI)
2. Name it clearly (for example, `Front Porch Creative website`)
3. Enter the website URL when asked (`https://frontporchcreative.io`)

### 3. Copy the Pixel ID

After creation, open the Pixel / dataset settings and copy the numeric **Pixel ID**. It looks like:

```text
123456789012345
```

That value is what you put in `.env` as `META_PIXEL_ID`.

### 4. Base code only (MVP)

This project injects the standard Pixel base code and a `PageView` event. Custom events (Lead, Contact, etc.) can be added later if advertising needs them — they are **not** required for the Phase 1 MVP.

### 5. (Optional) Staging Pixel

Prefer a **separate** Pixel for staging so test traffic does not pollute production ads data. Use a different Pixel ID in non-production `.env` files.

---

## Laravel configuration

### 1. Environment variable

Add to `.env` (production first; leave empty locally if you do not want the Pixel in development):

```env
META_PIXEL_ID=123456789012345
```

**Important:**

- Never commit `.env`
- Prefer different IDs for production and staging
- After changing env values, clear cached config if needed: `./vendor/bin/sail artisan config:clear`

### 2. Confirm `config/site.php`

This key should already exist:

```php
'meta_pixel_id' => env('META_PIXEL_ID', null),
```

### 3. Confirm Blade injection

`resources/views/app.blade.php` reads `config('site.meta_pixel_id')` and outputs the Meta snippet when the value is non-empty.

No frontend rebuild is required for env-only changes.

---

## Verification checklist

1. Set `META_PIXEL_ID` in `.env` and clear config cache if needed
2. Open the home page (or any public Inertia page) in a browser
3. View page source (or DevTools → Network / Elements) and confirm `connect.facebook.net/.../fbevents.js` and your Pixel ID
4. In Meta Events Manager: **Test events** (or Pixel diagnostics) — confirm `PageView` arrives

Automated coverage:

- Feature: `tests/Feature/Site/AnalyticsScriptsTest.php`
- Browser: `tests/Browser/Site/AnalyticsScriptsTest.php`

---

## Troubleshooting

### Script does not appear in the HTML

- Confirm `META_PIXEL_ID` is set (not an empty string in a cached config)
- Run `./vendor/bin/sail artisan config:clear`
- Confirm you are looking at a full page load of an Inertia response (script lives in `app.blade.php` `<head>`)

### Pixel does not receive events

- Confirm the Pixel ID is numeric and correct
- Use Meta’s **Test events** / Pixel Helper browser extension
- Disable ad blockers for the test
- Confirm the browser is not blocking `facebook.net` / `facebook.com`

### Wrong Pixel receiving data

- You likely reused a staging ID in production (or the reverse)
- Create separate Pixels and keep env files distinct

---

## Resources

- [Meta Events Manager](https://business.facebook.com/events_manager)
- [Meta Pixel documentation](https://developers.facebook.com/docs/meta-pixel/get-started)
- Project decision: [No cookie consent banner](../planning/decisions/2026-08-05-no-cookie-consent-banner.md)
- Related: [Google Analytics 4 Setup](./GOOGLE_ANALYTICS_SETUP.md)
- Related: [Cloudflare Turnstile Setup](./TURNSTILE_SETUP.md)
