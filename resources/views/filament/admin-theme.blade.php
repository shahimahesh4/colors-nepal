<style id="colors-nepal-admin-theme">
    :root {
        --cn-pink: #e63980;
        --cn-orange: #ff8a00;
        --cn-yellow: #ffc107;
        --cn-teal: #00b4a6;
        --cn-blue: #0066cc;
        --cn-ink: #0d1b2a;
    }

    .fi-body {
        background:
            radial-gradient(circle at 96% 2%, rgb(0 180 166 / .11), transparent 24rem),
            radial-gradient(circle at 12% 94%, rgb(230 57 128 / .08), transparent 26rem),
            #f8fafc;
        color: var(--cn-ink);
    }

    .fi-sidebar {
        border-right: 0;
        background:
            radial-gradient(circle at 0 15%, rgb(230 57 128 / .2), transparent 16rem),
            radial-gradient(circle at 100% 85%, rgb(0 180 166 / .16), transparent 18rem),
            var(--cn-ink);
        box-shadow: 10px 0 30px rgb(13 27 42 / .08);
    }

    .fi-sidebar-header,
    .fi-topbar nav {
        position: relative;
        border-color: rgb(0 102 204 / .14);
        box-shadow: 0 8px 24px rgb(13 27 42 / .06);
    }

    .fi-sidebar-header {
        background: rgb(13 27 42 / .92);
    }


    .fi-sidebar .fi-logo {
        color: white !important;
        font-size: 1.35rem;
        font-weight: 800;
    }

    .fi-sidebar-item-icon {
        width: 1.75rem !important;
        height: 1.75rem !important;
    }

    .fi-sidebar-group-label,
    .fi-sidebar-item-label {
        color: #cbd5e1;
    }

    .fi-sidebar-item-button:hover {
        background: rgb(255 255 255 / .09);
    }

    .fi-sidebar-item-button:hover .fi-sidebar-item-label,
    .fi-sidebar-item-active .fi-sidebar-item-label {
        color: white;
    }

    .fi-sidebar-item-active .fi-sidebar-item-button {
        background: linear-gradient(110deg, rgb(230 57 128 / .95), rgb(255 138 0 / .92));
        box-shadow: 0 10px 25px rgb(230 57 128 / .2);
    }

    .fi-sidebar-item-button svg,
    .fi-sidebar-group-button svg {
        color: var(--cn-teal);
    }

    .fi-sidebar-item-active .fi-sidebar-item-button svg {
        color: white;
    }

    .fi-header-heading {
        color: var(--cn-ink);
        letter-spacing: -.025em;
    }

    .fi-section,
    .fi-ta-ctn,
    .fi-wi-stats-overview-stat {
        overflow: hidden;
        border-color: rgb(0 102 204 / .13);
        box-shadow: 0 12px 32px rgb(13 27 42 / .07);
    }

.fi-btn.fi-color-primary:not(.fi-outlined),
    .fi-btn-color-primary:not(.fi-outlined) {
        border: 0;
        color: white;
        background: linear-gradient(110deg, var(--cn-pink), var(--cn-orange));
        box-shadow: 0 9px 20px rgb(230 57 128 / .2);
    }

    .fi-btn.fi-color-primary:not(.fi-outlined):hover,
    .fi-btn-color-primary:not(.fi-outlined):hover {
        filter: brightness(1.04);
        transform: translateY(-1px);
    }

    .fi-ta-header-cell,
    .fi-ta-header {
        background: linear-gradient(90deg, rgb(0 102 204 / .07), rgb(0 180 166 / .07));
    }

    .fi-fo-field-wrp-label,
    .fi-section-header-heading {
        color: var(--cn-ink);
    }

    .fi-footer,
    .fi-simple-footer {
        border-top: 3px solid transparent;
        border-image: linear-gradient(90deg, var(--cn-pink), var(--cn-orange), var(--cn-yellow), var(--cn-teal), var(--cn-blue)) 1;
    }

    .dark .fi-body {
        background: var(--cn-ink);
        color: #e2e8f0;
    }

    .dark .fi-header-heading,
    .dark .fi-fo-field-wrp-label,
    .dark .fi-section-header-heading {
        color: white;
    }

    .cn-content-lists {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1.5rem;
        width: 100%;
    }

    .cn-content-list-card {
        min-width: 0;
        overflow: hidden;
        border-radius: 1rem;
        background: white;
        box-shadow: 0 10px 28px rgb(13 27 42 / .08);
        border: 1px solid rgb(13 27 42 / .07);
    }

    .cn-content-list-header,
    .cn-content-list-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: .875rem;
        padding: 1rem 1.25rem;
    }

    .cn-content-list-header {
        border-bottom: 1px solid rgb(226 232 240);
    }

    .cn-content-list-item {
        text-decoration: none;
        border-bottom: 1px solid rgb(241 245 249);
        transition: background-color .2s ease;
    }

    .cn-content-list-item:last-child { border-bottom: 0; }
    .cn-content-list-item:hover { background: rgb(248 250 252); }
    .cn-content-list-empty { padding: 2rem 1.25rem; text-align: center; color: rgb(100 116 139); }

    @media (max-width: 1199px) {
        .cn-content-lists { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 767px) {
        .cn-content-lists { grid-template-columns: minmax(0, 1fr); gap: 1rem; }
        .cn-content-list-header, .cn-content-list-item { padding: .875rem 1rem; }
    }

    .dark .cn-content-list-card { background: rgb(24 24 27); border-color: rgb(255 255 255 / .1); }
    .dark .cn-content-list-header, .dark .cn-content-list-item { border-color: rgb(255 255 255 / .08); }
    .dark .cn-content-list-item:hover { background: rgb(255 255 255 / .05); }
    .fi-wi-stats-overview-stat {
        --cn-stat-accent: var(--cn-blue);
        position: relative;
        isolation: isolate;
        transition: transform .22s ease, box-shadow .22s ease, border-color .22s ease;
    }

    .fi-wi-stats-overview-stat::before {
        content: '';
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, var(--cn-stat-accent), color-mix(in srgb, var(--cn-stat-accent) 45%, white));
    }

    .fi-wi-stats-overview-stat:nth-child(2) { --cn-stat-accent: var(--cn-orange); }
    .fi-wi-stats-overview-stat:nth-child(3) { --cn-stat-accent: var(--cn-pink); }
    .fi-wi-stats-overview-stat:nth-child(4) { --cn-stat-accent: var(--cn-teal); }
    .fi-wi-stats-overview-stat:nth-child(5) { --cn-stat-accent: var(--cn-yellow); }
    .fi-wi-stats-overview-stat:nth-child(6) { --cn-stat-accent: #7c3aed; }

    .fi-wi-stats-overview-stat:hover {
        transform: translateY(-3px);
        border-color: color-mix(in srgb, var(--cn-stat-accent) 30%, transparent);
        box-shadow: 0 18px 38px rgb(13 27 42 / .12);
    }

    .fi-wi-stats-overview-stat-icon {
        width: 2.25rem !important;
        height: 2.25rem !important;
        padding: .5rem;
        border-radius: .75rem;
        color: var(--cn-stat-accent) !important;
        background: color-mix(in srgb, var(--cn-stat-accent) 11%, white);
    }

    .fi-wi-stats-overview-stat-value {
        font-size: 2.25rem !important;
        font-weight: 800 !important;
        color: var(--cn-ink) !important;
    }

    .cn-content-list-card {
        position: relative;
        transition: transform .22s ease, box-shadow .22s ease;
    }

    .cn-content-list-card::before {
        content: '';
        position: absolute;
        inset: 0 0 auto;
        height: 4px;
        background: linear-gradient(90deg, var(--cn-pink), var(--cn-orange));
        z-index: 1;
    }

    .cn-content-list-card:nth-child(2)::before { background: linear-gradient(90deg, var(--cn-orange), var(--cn-teal)); }
    .cn-content-list-card:nth-child(3)::before { background: linear-gradient(90deg, var(--cn-teal), var(--cn-blue)); }
    .cn-content-list-card:hover { transform: translateY(-2px); box-shadow: 0 18px 40px rgb(13 27 42 / .12); }
    .cn-content-list-header { padding-top: 1.2rem; background: linear-gradient(135deg, rgb(255 255 255), rgb(248 250 252)); }

    .dark .fi-wi-stats-overview-stat-icon { background: color-mix(in srgb, var(--cn-stat-accent) 18%, rgb(24 24 27)); }
    .dark .fi-wi-stats-overview-stat-value { color: white !important; }
    .dark .cn-content-list-header { background: linear-gradient(135deg, rgb(24 24 27), rgb(13 27 42)); }</style>
