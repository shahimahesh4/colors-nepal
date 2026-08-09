# Proposed Routes

No application routes exist in Phase 01. These routes are proposed for later implementation.

## Public routes

| Method | Path | Purpose |
| --- | --- | --- |
| GET | `/` | Homepage |
| GET | `/about` | About page |
| GET | `/services` | Service listing |
| GET | `/services/{service:slug}` | Service details |
| GET | `/portfolio` | Portfolio listing |
| GET | `/portfolio/{project:slug}` | Case study |
| GET | `/blog` | Published posts |
| GET | `/blog/{post:slug}` | Published post details |
| GET | `/hosting` | Hosting information |
| GET | `/domains` | Domain pricing information |
| GET | `/contact` | Contact form |
| POST | `/contact` | Rate-limited contact submission |
| GET | `/request-quote` | Quote form |
| POST | `/request-quote` | Rate-limited quote submission |

## Authentication and customer routes

Authentication routes should use Laravel's approved foundation when Phase 16 is reached. `/dashboard` and `/profile` require authentication. Any customer-resource route must use authorization policies and scoped route-model binding where appropriate.

## Administration

`/admin` is reserved for Filament. Access must be denied unless the authenticated user explicitly qualifies as an administrator.

## SEO/system routes

- `/sitemap.xml`
- `/robots.txt`

Canonical behavior, redirects, locale strategy, legal pages, and route names will be finalized before implementation.
