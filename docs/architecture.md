# Proposed Architecture

## Architectural approach

Use a Laravel monolith with server-rendered Blade pages. Add Livewire only for interactions that benefit from server-driven state, and use Filament only for authenticated content administration. This keeps hosting requirements and JavaScript usage low.

## Layers

- Public website: Blade layouts, pages, and reusable view components
- Interactive UI: Livewire only where a normal POST/redirect flow is insufficient
- Application layer: controllers, form requests, policies, notifications, and small focused services
- Content management: Filament resources and settings after the database foundation exists
- Persistence: MySQL/MariaDB with Eloquent, foreign keys, indexes, and simple relational models
- Assets: Vite and Tailwind CSS; Alpine.js only when required by UI behavior

## Planned modules

1. Site settings and public navigation
2. Services and service FAQs/features
3. Portfolio and categories
4. Testimonials and team
5. Blog and categories
6. Contact and quote requests
7. Hosting plans and domain pricing as informational content
8. Customer authentication and owned dashboard records
9. SEO metadata, sitemap, robots, breadcrumbs, and valid structured data

## Free-first and low-resource constraints

- Do not add a package when Laravel or a small local implementation is sufficient.
- Prefer database or file cache initially; Redis is optional, not required.
- Use the database queue driver only when asynchronous work becomes necessary.
- Use local/publicly licensed optimized images; no paid image service is required.
- Keep hosting and domain registrar integration out of the first release.
- Keep payments out of scope until a real checkout requirement is approved.
- Use Laravel logging and basic server monitoring before considering paid observability.
- Avoid third-party analytics and chat widgets during the performance baseline.
- Use coupons or promotional credits only if the user later selects a paid provider; the application must not depend on them.

## Security boundaries

- Public users can submit rate-limited contact and quote forms.
- Customers can access only their own private records.
- Admin access requires an explicit role/permission check.
- Uploaded files require authorization, MIME validation, size limits, safe names, and non-public storage where appropriate.
- Secrets remain in environment configuration and are never committed.

## Delivery sequence

Follow the approved roadmap one phase at a time. The next phase should scaffold and verify the Laravel foundation only after this architecture and missing business inputs are reviewed.
