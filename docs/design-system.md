# Frontend Design System

## Direction

Colors Nepal uses an original, modern digital-agency identity: a dark ink foundation, confident indigo actions, and restrained cyan accents. The system is mobile-first, accessible, fast, and intentionally independent from the Niwax reference assets and branding.

## Color tokens

- Ink: `#0b1220` for high-emphasis headings
- Brand 600: `#4f46e5` for primary actions and focus
- Brand 700: `#4338ca` for primary hover states
- Accent 500: `#06b6d4` for selective highlights
- Neutral surfaces: white and Tailwind slate
- Feedback: emerald success, amber warning, and red danger

Use semantic roles consistently. Do not use accent colors for long body text.

## Typography

Use the system sans-serif stack to avoid remote font requests. Body text starts at 16px with approximately 1.6 line height.

- Hero: 52-64px on large screens, reduced responsively
- H1: 40-52px
- H2: 32-48px
- H3: 20-24px
- Body large: 18px
- Body: 16px
- Supporting text: 14px

Headings use tight tracking and strong weight. Body copy should stay readable and concise.

## Spacing and layout

- Spacing rhythm: 4, 8, 12, 16, 24, 32, 48, 64, and 96px
- Default content maximum: 72rem
- Mobile gutter: 1rem
- Tablet gutter: 1.5rem
- Desktop gutter: 2rem
- Section spacing: 64px mobile, 96px desktop

## Shape and elevation

- Controls: 8px radius
- Cards: 16px radius
- Feature surfaces: 24px radius
- Shadows are reserved for interactive or elevated cards
- Borders provide the default separation between surfaces

## Components

Reusable anonymous Blade components live in `resources/views/components/ui/`.

- `button`: primary, secondary, ghost, and danger variants; 40-48px heights
- `section-heading`: eyebrow, title, description, and alignment
- `card`: standard surface with optional interactive treatment
- `badge`: brand, neutral, success, warning, and danger variants
- `alert`: accessible informational and error feedback
- `input`, `textarea`, `select`: persistent labels, help text, validation state, and 44px minimum controls

## Responsive rules

Tailwind's mobile-first breakpoints remain unchanged: `sm`, `md`, `lg`, `xl`, and `2xl`. Design mobile composition deliberately, then enhance layout at larger breakpoints. Avoid horizontal overflow and overly wide text lines.

## Accessibility

- Maintain visible labels; placeholders never replace labels
- All interactive targets are at least 44px where practical
- Use a visible 2px indigo focus outline with offset
- Preserve semantic heading order
- Error messages are connected with `aria-describedby`
- Invalid fields use `aria-invalid`
- Respect `prefers-reduced-motion`
- Maintain WCAG AA contrast for normal text

## Animation

Use 150-250ms transitions for hover and focus feedback only. Avoid decorative continuous motion, excessive parallax, and unnecessary carousels. Reduced-motion preferences disable nonessential animation.

## Usage rule

Use Blade for content-driven UI and Livewire only when interaction requires server-managed state. Do not duplicate these primitives in page-specific markup unless the design role is genuinely different.
