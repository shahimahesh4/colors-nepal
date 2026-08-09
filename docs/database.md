# Provisional Database Plan

No migrations are created in Phase 01. The schema below is a planning baseline and should be reduced to the content actually approved for the first release.

## Core entities

- `users`: customers and administrators; role strategy to be chosen before migration
- `site_settings`: small set of validated global values
- `services`: title, slug, summary, content, status, order, and SEO fields
- `service_features`: ordered features belonging to a service
- `service_faqs`: ordered questions and answers belonging to a service
- `portfolio_categories`: category name and slug
- `portfolio_projects`: case-study content, category, status, featured flag, dates, URLs, and SEO fields
- `testimonials`: genuine customer feedback with approval/status fields
- `team_members`: public team profiles and display order
- `blog_categories`: category name and slug
- `blog_posts`: author, category, slug, content, publish state/date, and SEO fields
- `contact_messages`: contact details, subject, message, status, and request metadata
- `quote_requests`: customer/project details, budget/timeline ranges, status, and optional owner
- `hosting_plans`: informational package content and display order
- `domain_tlds`: extension and display pricing; no registrar automation initially
- `faqs`: general questions, answers, grouping, status, and display order

## Schema rules

- Use foreign keys for true ownership and category relationships.
- Index slugs, publish/status fields, display order, foreign keys, and frequently filtered dates.
- Add unique constraints to slugs and other genuine identifiers.
- Use nullable columns only where absence is valid.
- Prefer normalized records over JSON when data must be filtered, related, or edited independently.
- Store money in integer minor units plus currency, not floating point.
- Use soft deletes only where recovery is a confirmed business requirement.
- Do not create tables for speculative integrations.

## Open decisions

- Whether registration is required for the first release
- What private records customers will own in the dashboard
- Single administrator flag versus a fuller role/permission model
- Whether newsletter subscriptions are in scope and what consent record is required
- Supported currency and whether listed prices include tax
- File/media requirements for projects, posts, and team profiles
