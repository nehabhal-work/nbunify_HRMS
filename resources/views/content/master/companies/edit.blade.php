<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile — Acme Technologies Pvt. Ltd.</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --ink: #0f1117;
            --ink-soft: #4a5568;
            --ink-muted: #94a3b8;
            --surface: #ffffff;
            --surface-2: #f8fafc;
            --surface-3: #f1f5f9;
            --border: #e2e8f0;
            --border-active: #6366f1;
            --accent: #6366f1;
            --accent-2: #0ea5e9;
            --accent-light: #eef2ff;
            --success: #10b981;
            --success-light: #d1fae5;
            --danger: #ef4444;
            --danger-light: #fee2e2;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
            --radius: 12px;
            --radius-sm: 8px;
            --shadow: 0 1px 3px rgba(0, 0, 0, 0.06), 0 4px 16px rgba(0, 0, 0, 0.04);
            --shadow-md: 0 4px 24px rgba(0, 0, 0, 0.08), 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #f0f4f8;
            color: var(--ink);
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.6;
        }

        /* ── Layout ── */
        .page-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px;
            background: var(--ink);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .logo-mark {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 20px;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .logo-mark span {
            color: var(--accent);
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.3);
            padding: 12px 8px 6px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.55);
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.18s;
            margin-bottom: 2px;
            text-decoration: none;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.07);
            color: rgba(255, 255, 255, 0.9);
        }

        .nav-item.active {
            background: var(--accent);
            color: #fff;
        }

        .nav-icon {
            font-size: 16px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        /* ── Main ── */
        .main-content {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* ── Topbar ── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .breadcrumb-trail {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--ink-muted);
        }

        .breadcrumb-trail a {
            color: var(--ink-muted);
            text-decoration: none;
        }

        .breadcrumb-trail a:hover {
            color: var(--accent);
        }

        .breadcrumb-trail .sep {
            opacity: 0.4;
        }

        .breadcrumb-trail .current {
            color: var(--ink);
            font-weight: 600;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.18s;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            background: #4f46e5;
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--ink-soft);
            border: 1px solid var(--border);
        }

        .btn-outline:hover {
            background: var(--surface-3);
            border-color: var(--ink-soft);
        }

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-danger:hover {
            background: #dc2626;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12.5px;
        }

        .btn-xs {
            padding: 4px 10px;
            font-size: 11.5px;
            border-radius: 6px;
        }

        /* ── Page body ── */
        .page-body {
            padding: 28px 32px 48px;
        }

        /* ── Company Header Card ── */
        .company-hero {
            background: var(--surface);
            border-radius: 16px;
            box-shadow: var(--shadow);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .hero-cover {
            height: 96px;
            background: linear-gradient(135deg, #6366f1 0%, #0ea5e9 60%, #10b981 100%);
            position: relative;
        }

        .hero-cover::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-body {
            padding: 0 32px 24px;
            display: flex;
            align-items: flex-end;
            gap: 20px;
        }

        .company-avatar {
            width: 80px;
            height: 80px;
            border-radius: 16px;
            background: var(--surface);
            border: 3px solid var(--surface);
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-top: -36px;
            flex-shrink: 0;
            overflow: hidden;
        }

        .company-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-meta {
            flex: 1;
            padding-top: 12px;
        }

        .company-name {
            font-family: 'Syne', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--ink);
            line-height: 1.2;
        }

        .company-sub {
            color: var(--ink-muted);
            font-size: 13px;
            margin-top: 2px;
        }

        .hero-badges {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-active {
            background: var(--success-light);
            color: #065f46;
        }

        .badge-inactive {
            background: var(--danger-light);
            color: #991b1b;
        }

        .badge-type {
            background: var(--accent-light);
            color: #3730a3;
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .hero-actions {
            display: flex;
            align-items: flex-end;
            gap: 8px;
            padding-top: 24px;
        }

        /* ── Mode Toggle Bar ── */
        .mode-toggle-bar {
            display: flex;
            align-items: center;
            gap: 4px;
            background: var(--surface-3);
            border-radius: var(--radius-sm);
            padding: 4px;
            width: fit-content;
        }

        .mode-btn {
            padding: 6px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.18s;
            border: none;
            background: transparent;
            color: var(--ink-soft);
            font-family: 'DM Sans', sans-serif;
        }

        .mode-btn.active {
            background: var(--surface);
            color: var(--ink);
            box-shadow: var(--shadow);
        }

        /* ── Tab Nav ── */
        .tab-nav {
            display: flex;
            gap: 0;
            border-bottom: 1px solid var(--border);
            margin-bottom: 24px;
            overflow-x: auto;
        }

        .tab-btn {
            padding: 12px 20px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--ink-muted);
            cursor: pointer;
            border: none;
            background: none;
            border-bottom: 2px solid transparent;
            transition: all 0.18s;
            white-space: nowrap;
            font-family: 'DM Sans', sans-serif;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .tab-btn:hover {
            color: var(--ink);
        }

        .tab-btn.active {
            color: var(--accent);
            border-bottom-color: var(--accent);
        }

        .tab-count {
            background: var(--accent-light);
            color: var(--accent);
            border-radius: 20px;
            padding: 1px 7px;
            font-size: 11px;
            font-weight: 700;
        }

        /* ── Section Cards ── */
        .section-card {
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-bottom: 20px;
            overflow: hidden;
        }

        .section-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: var(--ink);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: var(--accent-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .section-body {
            padding: 24px;
        }

        /* ── View Mode: Info Grid ── */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px 32px;
        }

        .info-item {}

        .info-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: var(--ink-muted);
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 500;
            color: var(--ink);
            word-break: break-all;
        }

        .info-value.empty {
            color: var(--ink-muted);
            font-style: italic;
            font-weight: 400;
        }

        .info-link {
            color: var(--accent);
            text-decoration: none;
        }

        .info-link:hover {
            text-decoration: underline;
        }

        /* ── Address Grid ── */
        .address-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1px;
            background: var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
        }

        .address-block {
            background: var(--surface);
            padding: 20px;
        }

        .address-tag {
            font-size: 10.5px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 10px;
        }

        .address-text {
            font-size: 13.5px;
            color: var(--ink);
            line-height: 1.7;
        }

        /* ── Reg Badges ── */
        .reg-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
        }

        .reg-chip {
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            transition: border-color 0.18s;
        }

        .reg-chip:hover {
            border-color: var(--accent);
        }

        .reg-chip-label {
            font-size: 10.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--ink-muted);
            margin-bottom: 4px;
        }

        .reg-chip-value {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--ink);
        }

        .reg-chip-value.empty {
            font-size: 12px;
            color: var(--ink-muted);
            font-style: italic;
            font-weight: 400;
        }

        /* ── Bank Card ── */
        .bank-card {
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 16px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            margin-bottom: 10px;
            transition: all 0.18s;
        }

        .bank-card:hover {
            border-color: var(--accent);
            box-shadow: 0 2px 12px rgba(99, 102, 241, 0.07);
        }

        .bank-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--accent-light), #dbeafe);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .bank-info {
            flex: 1;
        }

        .bank-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--ink);
        }

        .bank-branch {
            color: var(--ink-muted);
            font-size: 12.5px;
        }

        .bank-meta {
            display: flex;
            gap: 16px;
            margin-top: 8px;
            flex-wrap: wrap;
        }

        .bank-meta-item {
            font-size: 12px;
            color: var(--ink-soft);
        }

        .bank-meta-label {
            font-weight: 600;
            color: var(--ink-muted);
        }

        .bank-primary-tag {
            background: var(--success-light);
            color: #065f46;
            font-size: 10.5px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            margin-left: 8px;
        }

        /* ── Doc Gallery ── */
        .doc-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 14px;
        }

        .doc-tile {
            border: 1.5px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.22s;
            position: relative;
            background: var(--surface-2);
        }

        .doc-tile:hover {
            border-color: var(--accent);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.1);
        }

        .doc-tile.has-doc {
            border-color: var(--success);
            background: #f0fdf4;
        }

        .doc-tile-icon {
            font-size: 26px;
            margin-bottom: 8px;
        }

        .doc-tile-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .doc-status-dot {
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            margin-right: 4px;
        }

        .doc-status-dot.green {
            background: var(--success);
        }

        .doc-status-dot.red {
            background: var(--danger);
        }

        .doc-status-label {
            font-size: 11px;
            font-weight: 600;
        }

        .doc-status-label.ok {
            color: var(--success);
        }

        .doc-status-label.missing {
            color: var(--danger);
        }

        .doc-corner-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .doc-corner-badge.ok {
            background: var(--success-light);
            color: #065f46;
        }

        .doc-corner-badge.missing {
            background: var(--danger-light);
            color: #991b1b;
        }

        /* ── EDIT MODE ── */
        #edit-panel {
            display: none;
        }

        #view-panel {
            display: block;
        }

        .form-section {
            margin-bottom: 24px;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px 20px;
        }

        .form-row-2 {
            grid-template-columns: 1fr 1fr;
        }

        .form-row-3 {
            grid-template-columns: repeat(3, 1fr);
        }

        .form-row-4 {
            grid-template-columns: repeat(4, 1fr);
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-soft);
            letter-spacing: 0.2px;
        }

        .form-label .req {
            color: var(--danger);
        }

        .form-control {
            width: 100%;
            padding: 9px 13px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            color: var(--ink);
            background: var(--surface);
            transition: all 0.18s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .form-control:read-only {
            background: var(--surface-3);
            color: var(--ink-muted);
        }

        .form-select {
            width: 100%;
            padding: 9px 13px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 13.5px;
            color: var(--ink);
            background: var(--surface);
            cursor: pointer;
            outline: none;
            transition: all 0.18s;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg width='16' height='16' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M4 6l4 4 4-4' stroke='%2394a3b8' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .input-prefix {
            display: flex;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            overflow: hidden;
            transition: border-color 0.18s, box-shadow 0.18s;
        }

        .input-prefix:focus-within {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
        }

        .prefix-text {
            padding: 9px 12px;
            background: var(--surface-3);
            border-right: 1.5px solid var(--border);
            color: var(--ink-muted);
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
        }

        .input-prefix .form-control {
            border: none;
            border-radius: 0;
            box-shadow: none;
        }

        .input-prefix .form-control:focus {
            box-shadow: none;
        }

        .addr-split {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .addr-col {
            padding: 20px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }

        .addr-col-title {
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: var(--accent);
            margin-bottom: 14px;
        }

        /* ── Doc Upload (Edit) ── */
        .doc-upload-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 14px;
        }

        .doc-upload-tile {
            border: 1.5px dashed var(--border);
            border-radius: var(--radius);
            padding: 16px 12px;
            text-align: center;
            cursor: pointer;
            transition: all 0.22s;
            position: relative;
            background: var(--surface-2);
        }

        .doc-upload-tile:hover {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .doc-upload-tile.uploaded {
            border-style: solid;
            border-color: var(--success);
            background: #f0fdf4;
        }

        .doc-upload-tile-icon {
            font-size: 24px;
            margin-bottom: 6px;
        }

        .doc-upload-tile-label {
            font-size: 11.5px;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 4px;
        }

        .doc-upload-hint {
            font-size: 10.5px;
            color: var(--ink-muted);
        }

        /* ── Bank rows (Edit) ── */
        .bank-row-edit {
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px;
            margin-bottom: 14px;
            position: relative;
        }

        .bank-row-number {
            position: absolute;
            top: -10px;
            left: 16px;
            background: var(--accent);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 10px;
        }

        .bank-row-remove {
            position: absolute;
            top: 12px;
            right: 12px;
        }

        /* ── Divider ── */
        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 20px 0;
        }

        /* ── Audit row ── */
        .audit-row {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            padding-top: 12px;
            border-top: 1px solid var(--border);
            margin-top: 20px;
        }

        .audit-item {
            font-size: 12px;
            color: var(--ink-muted);
        }

        .audit-item strong {
            color: var(--ink-soft);
            font-weight: 600;
        }

        /* ── Alert ── */
        .alert-success {
            background: var(--success-light);
            border: 1px solid #6ee7b7;
            color: #065f46;
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Sticky save bar ── */
        .save-bar {
            position: sticky;
            bottom: 0;
            background: var(--surface);
            border-top: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            z-index: 40;
            margin-left: -32px;
            margin-right: -32px;
        }

        /* ── Timeline ── */
        .timeline {
            position: relative;
            padding-left: 20px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 4px;
            bottom: 4px;
            width: 1.5px;
            background: var(--border);
        }

        .timeline-item {
            position: relative;
            padding-bottom: 18px;
        }

        .timeline-dot {
            position: absolute;
            left: -20px;
            top: 4px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: var(--surface);
            border: 2px solid var(--accent);
        }

        .timeline-time {
            font-size: 11px;
            color: var(--ink-muted);
            margin-bottom: 2px;
        }

        .timeline-event {
            font-size: 13px;
            color: var(--ink-soft);
        }

        .timeline-event strong {
            color: var(--ink);
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--ink-muted);
        }

        /* ── Tab panels ── */
        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }

            .addr-split {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="page-shell">

        <!-- ── Sidebar ── -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="logo-mark">Corp<span>Desk</span></div>
                <div style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:2px;">Enterprise Suite</div>
            </div>
            <nav class="sidebar-nav">
                <div class="nav-section-label">Main</div>
                <a class="nav-item" href="#"><span class="nav-icon">🏠</span> Dashboard</a>
                <a class="nav-item active" href="#"><span class="nav-icon">🏢</span> Companies</a>
                <a class="nav-item" href="#"><span class="nav-icon">👥</span> Contacts</a>
                <a class="nav-item" href="#"><span class="nav-icon">📦</span> Products</a>
                <div class="nav-section-label">Finance</div>
                <a class="nav-item" href="#"><span class="nav-icon">🧾</span> Invoices</a>
                <a class="nav-item" href="#"><span class="nav-icon">💳</span> Payments</a>
                <a class="nav-item" href="#"><span class="nav-icon">📊</span> Reports</a>
                <div class="nav-section-label">Settings</div>
                <a class="nav-item" href="#"><span class="nav-icon">⚙️</span> Configuration</a>
                <a class="nav-item" href="#"><span class="nav-icon">🔐</span> Roles & Access</a>
            </nav>
        </aside>

        <!-- ── Main ── -->
        <div class="main-content">

            <!-- Topbar -->
            <div class="topbar">
                <div class="breadcrumb-trail">
                    <a href="#">Master</a>
                    <span class="sep">/</span>
                    <a href="#">Company</a>
                    <span class="sep">/</span>
                    <span class="current">Acme Technologies Pvt. Ltd.</span>
                </div>
                <div class="topbar-right">
                    <div class="mode-toggle-bar">
                        <button class="mode-btn active" id="viewModeBtn" onclick="setMode('view')">👁 View</button>
                        <button class="mode-btn" id="editModeBtn" onclick="setMode('edit')">✏️ Edit</button>
                    </div>
                    <button class="btn btn-outline btn-sm">⬇ Export</button>
                </div>
            </div>

            <!-- Page Body -->
            <div class="page-body">

                <!-- Company Hero -->
                <div class="company-hero">
                    <div class="hero-cover"></div>
                    <div class="hero-body">
                        <div class="company-avatar">🏢</div>
                        <div class="hero-meta">
                            <div class="company-name">Acme Technologies Pvt. Ltd.</div>
                            <div class="company-sub">Legal: Acme Technologies Private Limited &nbsp;·&nbsp; Est. 12 Jan
                                2010</div>
                            <div class="hero-badges">
                                <span class="badge badge-active"><span class="badge-dot"></span> Active</span>
                                <span class="badge badge-type">Private Limited</span>
                                <span class="badge" style="background:#fef3c7;color:#92400e;">CIN:
                                    U72900MH2010PTC205678</span>
                            </div>
                        </div>
                        <div class="hero-actions">
                            <button class="btn btn-outline btn-sm">📞 Call</button>
                            <button class="btn btn-outline btn-sm">📧 Email</button>
                        </div>
                    </div>
                </div>

                <!-- Tab Nav -->
                <div class="tab-nav">
                    <button class="tab-btn active" onclick="switchTab('basic', this)">📋 Basic Info</button>
                    <button class="tab-btn" onclick="switchTab('address', this)">📍 Addresses</button>
                    <button class="tab-btn" onclick="switchTab('registration', this)">🔖 Registration</button>
                    <button class="tab-btn" onclick="switchTab('bank', this)">🏦 Bank Details <span
                            class="tab-count">2</span></button>
                    <button class="tab-btn" onclick="switchTab('docs', this)">📂 Documents <span
                            class="tab-count">7</span></button>
                    <button class="tab-btn" onclick="switchTab('activity', this)">🕑 Activity</button>
                </div>

                <!-- ════════════════ VIEW PANEL ════════════════ -->
                <div id="view-panel">

                    <!-- BASIC INFO -->
                    <div class="tab-panel active" id="view-basic">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">🏢</div> Basic Information
                                </div>
                            </div>
                            <div class="section-body">
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Company Name</div>
                                        <div class="info-value">Acme Technologies Pvt. Ltd.</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Legal Name</div>
                                        <div class="info-value">Acme Technologies Private Limited</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Company Type</div>
                                        <div class="info-value">Private Limited</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Status</div>
                                        <div class="info-value"><span class="badge badge-active"><span
                                                    class="badge-dot"></span> Active</span></div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Website</div>
                                        <div class="info-value"><a href="#"
                                                class="info-link">https://acmetechnologies.in</a></div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Email</div>
                                        <div class="info-value"><a href="mailto:info@acme.in"
                                                class="info-link">info@acme.in</a></div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Mobile Number</div>
                                        <div class="info-value">+91 9876543210</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Establishment Date</div>
                                        <div class="info-value">12 January 2010</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ADDRESS -->
                    <div class="tab-panel" id="view-address">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">📍</div> Addresses
                                </div>
                            </div>
                            <div class="section-body">
                                <div class="address-grid">
                                    <div class="address-block">
                                        <div class="address-tag">Registered Address</div>
                                        <div class="address-text">
                                            B-204, Techno Park, MG Road<br>
                                            Near Juhu Circle<br>
                                            Mumbai, Maharashtra — 400 049<br>
                                            India
                                        </div>
                                    </div>
                                    <div class="address-block">
                                        <div class="address-tag">Operational / Correspondence Address</div>
                                        <div class="address-text">
                                            3rd Floor, Lotus Tower, BKC<br>
                                            Bandra Kurla Complex<br>
                                            Mumbai, Maharashtra — 400 051<br>
                                            India
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- REGISTRATION -->
                    <div class="tab-panel" id="view-registration">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">🔖</div> Registration & Legal Numbers
                                </div>
                            </div>
                            <div class="section-body">
                                <div class="reg-grid">
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">CIN No</div>
                                        <div class="reg-chip-value">U72900MH2010PTC205678</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">PAN No</div>
                                        <div class="reg-chip-value">AABCA1234C</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">TAN No</div>
                                        <div class="reg-chip-value">MUMA12345A</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">GSTIN</div>
                                        <div class="reg-chip-value">27AABCA1234C1Z3</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">Udyam Aadhar</div>
                                        <div class="reg-chip-value">UDYAM-MH-10-0012345</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">MSME No</div>
                                        <div class="reg-chip-value">MH/2010/0056789</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">ROC No</div>
                                        <div class="reg-chip-value">ROC-205678</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">Partnership Reg. No</div>
                                        <div class="reg-chip-value empty">Not provided</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">CKYC</div>
                                        <div class="reg-chip-value">10012345678901</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">Gumasta No</div>
                                        <div class="reg-chip-value">MH/GU/2010/2345</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">Watermark No</div>
                                        <div class="reg-chip-value empty">Not provided</div>
                                    </div>
                                    <div class="reg-chip">
                                        <div class="reg-chip-label">Copyright No</div>
                                        <div class="reg-chip-value empty">Not provided</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BANK -->
                    <div class="tab-panel" id="view-bank">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">🏦</div> Bank Details
                                </div>
                            </div>
                            <div class="section-body">
                                <div class="bank-card">
                                    <div class="bank-icon">🏦</div>
                                    <div class="bank-info">
                                        <div class="bank-name">HDFC Bank <span class="bank-primary-tag">★
                                                Primary</span></div>
                                        <div class="bank-branch">Bandra Kurla Complex, Mumbai</div>
                                        <div class="bank-meta">
                                            <div class="bank-meta-item"><span class="bank-meta-label">Account No:
                                                </span>50100234567890</div>
                                            <div class="bank-meta-item"><span class="bank-meta-label">IFSC:
                                                </span>HDFC0001234</div>
                                            <div class="bank-meta-item"><span class="bank-meta-label">Type:
                                                </span>Current Account</div>
                                            <div class="bank-meta-item"><span class="bank-meta-label">Code:
                                                </span>HDFC</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bank-card">
                                    <div class="bank-icon">🏦</div>
                                    <div class="bank-info">
                                        <div class="bank-name">ICICI Bank</div>
                                        <div class="bank-branch">Andheri West, Mumbai</div>
                                        <div class="bank-meta">
                                            <div class="bank-meta-item"><span class="bank-meta-label">Account No:
                                                </span>000501234567</div>
                                            <div class="bank-meta-item"><span class="bank-meta-label">IFSC:
                                                </span>ICIC0000501</div>
                                            <div class="bank-meta-item"><span class="bank-meta-label">Type:
                                                </span>Savings Account</div>
                                            <div class="bank-meta-item"><span class="bank-meta-label">Code:
                                                </span>ICICI</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DOCUMENTS -->
                    <div class="tab-panel" id="view-docs">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">📂</div> Documents
                                </div>
                                <span style="font-size:12px;color:var(--success);font-weight:600;">7 / 10
                                    Uploaded</span>
                            </div>
                            <div class="section-body">
                                <div class="doc-gallery">
                                    <div class="doc-tile has-doc">
                                        <span class="doc-corner-badge ok">✓ Done</span>
                                        <div class="doc-tile-icon">🪪</div>
                                        <div class="doc-tile-label">PAN Card</div>
                                        <div><span class="doc-status-dot green"></span><span
                                                class="doc-status-label ok">Uploaded</span></div>
                                    </div>
                                    <div class="doc-tile has-doc">
                                        <span class="doc-corner-badge ok">✓ Done</span>
                                        <div class="doc-tile-icon">📋</div>
                                        <div class="doc-tile-label">TAN Certificate</div>
                                        <div><span class="doc-status-dot green"></span><span
                                                class="doc-status-label ok">Uploaded</span></div>
                                    </div>
                                    <div class="doc-tile has-doc">
                                        <span class="doc-corner-badge ok">✓ Done</span>
                                        <div class="doc-tile-icon">📄</div>
                                        <div class="doc-tile-label">GST Certificate</div>
                                        <div><span class="doc-status-dot green"></span><span
                                                class="doc-status-label ok">Uploaded</span></div>
                                    </div>
                                    <div class="doc-tile has-doc">
                                        <span class="doc-corner-badge ok">✓ Done</span>
                                        <div class="doc-tile-icon">🏢</div>
                                        <div class="doc-tile-label">MSME Certificate</div>
                                        <div><span class="doc-status-dot green"></span><span
                                                class="doc-status-label ok">Uploaded</span></div>
                                    </div>
                                    <div class="doc-tile">
                                        <span class="doc-corner-badge missing">Missing</span>
                                        <div class="doc-tile-icon">🪪</div>
                                        <div class="doc-tile-label">Udyam Aadhar</div>
                                        <div><span class="doc-status-dot red"></span><span
                                                class="doc-status-label missing">Not Uploaded</span></div>
                                    </div>
                                    <div class="doc-tile has-doc">
                                        <span class="doc-corner-badge ok">✓ Done</span>
                                        <div class="doc-tile-icon">📄</div>
                                        <div class="doc-tile-label">Gumasta License</div>
                                        <div><span class="doc-status-dot green"></span><span
                                                class="doc-status-label ok">Uploaded</span></div>
                                    </div>
                                    <div class="doc-tile">
                                        <span class="doc-corner-badge missing">Missing</span>
                                        <div class="doc-tile-icon">📄</div>
                                        <div class="doc-tile-label">CKYC Document</div>
                                        <div><span class="doc-status-dot red"></span><span
                                                class="doc-status-label missing">Not Uploaded</span></div>
                                    </div>
                                    <div class="doc-tile has-doc">
                                        <span class="doc-corner-badge ok">✓ Done</span>
                                        <div class="doc-tile-icon">🏦</div>
                                        <div class="doc-tile-label">Cancelled Cheque</div>
                                        <div><span class="doc-status-dot green"></span><span
                                                class="doc-status-label ok">Uploaded</span></div>
                                    </div>
                                    <div class="doc-tile has-doc">
                                        <span class="doc-corner-badge ok">✓ Done</span>
                                        <div class="doc-tile-icon">👤</div>
                                        <div class="doc-tile-label">Proprietor Photo</div>
                                        <div><span class="doc-status-dot green"></span><span
                                                class="doc-status-label ok">Uploaded</span></div>
                                    </div>
                                    <div class="doc-tile">
                                        <span class="doc-corner-badge missing">Missing</span>
                                        <div class="doc-tile-icon">🏷️</div>
                                        <div class="doc-tile-label">Company Logo</div>
                                        <div><span class="doc-status-dot red"></span><span
                                                class="doc-status-label missing">Not Uploaded</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACTIVITY -->
                    <div class="tab-panel" id="view-activity">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">🕑</div> Activity Log
                                </div>
                            </div>
                            <div class="section-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-time">02 Apr 2026, 10:34 AM</div>
                                        <div class="timeline-event"><strong>Rahul Sharma</strong> updated bank details
                                            — added ICICI Bank account.</div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-time">28 Mar 2026, 03:15 PM</div>
                                        <div class="timeline-event"><strong>Priya Mehta</strong> uploaded GST
                                            Certificate document.</div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-time">15 Mar 2026, 11:00 AM</div>
                                        <div class="timeline-event"><strong>Admin</strong> changed company status from
                                            <strong>Inactive</strong> to <strong>Active</strong>.</div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div class="timeline-time">12 Jan 2026, 09:00 AM</div>
                                        <div class="timeline-event"><strong>Rahul Sharma</strong> created company
                                            record.</div>
                                    </div>
                                </div>
                                <div class="audit-row">
                                    <div class="audit-item">Created: <strong>12 Jan 2026</strong> by Rahul Sharma</div>
                                    <div class="audit-item">Last Updated: <strong>02 Apr 2026</strong> by Rahul Sharma
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- END VIEW PANEL -->


                <!-- ════════════════ EDIT PANEL ════════════════ -->
                <div id="edit-panel">

                    <div class="alert-success">✅ You are in edit mode. Modify the details below and click <strong>Save
                            Changes</strong> to update.</div>

                    <!-- BASIC INFO -->
                    <div class="tab-panel active" id="edit-basic">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">🏢</div> Basic Information
                                </div>
                                <small style="color:var(--ink-muted)">Company Primary Details</small>
                            </div>
                            <div class="section-body">
                                <div class="form-row" style="grid-template-columns: repeat(4, 1fr);">
                                    <div class="form-group" style="grid-column: span 2;">
                                        <label class="form-label">Company Name <span class="req">*</span></label>
                                        <input class="form-control" type="text"
                                            value="Acme Technologies Pvt. Ltd." placeholder="Enter company name">
                                    </div>
                                    <div class="form-group" style="grid-column: span 2;">
                                        <label class="form-label">Legal Name</label>
                                        <input class="form-control" type="text"
                                            value="Acme Technologies Private Limited"
                                            placeholder="Legal registered name">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Company Type <span class="req">*</span></label>
                                        <select class="form-select">
                                            <option>Private Limited</option>
                                            <option>Public Limited</option>
                                            <option>LLP</option>
                                            <option>Partnership</option>
                                            <option>Proprietorship</option>
                                            <option>OPC</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Status</label>
                                        <select class="form-select">
                                            <option selected>Active</option>
                                            <option>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group" style="grid-column: span 2;">
                                        <label class="form-label">Website</label>
                                        <div class="input-prefix">
                                            <span class="prefix-text">https://</span>
                                            <input class="form-control" type="text" value="acmetechnologies.in">
                                        </div>
                                    </div>
                                    <div class="form-group" style="grid-column: span 2;">
                                        <label class="form-label">Email</label>
                                        <input class="form-control" type="email" value="info@acme.in"
                                            placeholder="Company email">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Mobile Number</label>
                                        <input class="form-control" type="text" value="9876543210"
                                            maxlength="10">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Establishment Date</label>
                                        <input class="form-control" type="date" value="2010-01-12">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ADDRESS -->
                    <div class="tab-panel" id="edit-address">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">📍</div> Address Details
                                </div>
                                <label
                                    style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--ink-soft);cursor:pointer;">
                                    <input type="checkbox" id="sameAddr" onchange="copySameAddr(this)"
                                        style="accent-color:var(--accent);width:15px;height:15px;">
                                    Same as Registered Address
                                </label>
                            </div>
                            <div class="section-body">
                                <div class="addr-split">
                                    <div class="addr-col">
                                        <div class="addr-col-title">📌 Registered Address</div>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label">Address Line 1 <span
                                                    class="req">*</span></label>
                                            <input class="form-control" id="reg_addr1" type="text"
                                                value="B-204, Techno Park, MG Road"
                                                placeholder="Building No., Street, Area">
                                        </div>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label">Address Line 2</label>
                                            <input class="form-control" id="reg_addr2" type="text"
                                                value="Near Juhu Circle" placeholder="Floor, Suite, Landmark">
                                        </div>
                                        <div class="form-row"
                                            style="grid-template-columns:1fr 1fr;margin-bottom:12px;">
                                            <div class="form-group">
                                                <label class="form-label">City</label>
                                                <input class="form-control" id="reg_city" type="text"
                                                    value="Mumbai">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">State</label>
                                                <select class="form-select" id="reg_state">
                                                    <option selected>Maharashtra</option>
                                                    <option>Delhi</option>
                                                    <option>Karnataka</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row" style="grid-template-columns:1fr 1fr;">
                                            <div class="form-group">
                                                <label class="form-label">Postal Code</label>
                                                <input class="form-control" id="reg_pin" type="text"
                                                    value="400049" maxlength="6">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Country</label>
                                                <select class="form-select" id="reg_country">
                                                    <option>India</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="addr-col" id="opAddrCol">
                                        <div class="addr-col-title">🗺️ Operational / Correspondence Address</div>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label">Address Line 1</label>
                                            <input class="form-control" id="op_addr1" type="text"
                                                value="3rd Floor, Lotus Tower, BKC"
                                                placeholder="Building No., Street, Area">
                                        </div>
                                        <div class="form-group" style="margin-bottom:12px;">
                                            <label class="form-label">Address Line 2</label>
                                            <input class="form-control" id="op_addr2" type="text"
                                                value="Bandra Kurla Complex" placeholder="Floor, Suite, Landmark">
                                        </div>
                                        <div class="form-row"
                                            style="grid-template-columns:1fr 1fr;margin-bottom:12px;">
                                            <div class="form-group">
                                                <label class="form-label">City</label>
                                                <input class="form-control" id="op_city" type="text"
                                                    value="Mumbai">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">State</label>
                                                <select class="form-select" id="op_state">
                                                    <option selected>Maharashtra</option>
                                                    <option>Delhi</option>
                                                    <option>Karnataka</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row" style="grid-template-columns:1fr 1fr;">
                                            <div class="form-group">
                                                <label class="form-label">Postal Code</label>
                                                <input class="form-control" id="op_pin" type="text"
                                                    value="400051" maxlength="6">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Country</label>
                                                <select class="form-select" id="op_country">
                                                    <option>India</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- REGISTRATION -->
                    <div class="tab-panel" id="edit-registration">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">🔖</div> Registration Details
                                </div>
                                <small style="color:var(--ink-muted)">Legal & Tax Numbers</small>
                            </div>
                            <div class="section-body">
                                <div class="form-row" style="grid-template-columns:repeat(4,1fr);">
                                    <div class="form-group">
                                        <label class="form-label">CIN No</label>
                                        <input class="form-control" type="text" value="U72900MH2010PTC205678"
                                            maxlength="21" placeholder="CIN Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">PAN No</label>
                                        <input class="form-control" type="text" value="AABCA1234C" maxlength="10"
                                            placeholder="ABCDE1234F">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">TAN No</label>
                                        <input class="form-control" type="text" value="MUMA12345A" maxlength="10"
                                            placeholder="TAN Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">GSTIN</label>
                                        <input class="form-control" type="text" value="27AABCA1234C1Z3"
                                            maxlength="15" placeholder="27ABCDE1234F1Z5">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Udyam Aadhar</label>
                                        <input class="form-control" type="text" value="UDYAM-MH-10-0012345"
                                            maxlength="19" placeholder="Udyam Registration No">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">MSME No</label>
                                        <input class="form-control" type="text" value="MH/2010/0056789"
                                            maxlength="100" placeholder="MSME Certificate No">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">ROC No</label>
                                        <input class="form-control" type="text" value="ROC-205678"
                                            maxlength="100" placeholder="ROC Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Partnership Reg. No</label>
                                        <input class="form-control" type="text" value="" maxlength="100"
                                            placeholder="Registration No">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">CKYC</label>
                                        <input class="form-control" type="text" value="10012345678901"
                                            maxlength="14" placeholder="CKYC Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Gumasta No</label>
                                        <input class="form-control" type="text" value="MH/GU/2010/2345"
                                            maxlength="100" placeholder="Gumasta License No">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Watermark No</label>
                                        <input class="form-control" type="text" value="" maxlength="100"
                                            placeholder="Watermark Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Copyright No</label>
                                        <input class="form-control" type="text" value="" maxlength="100"
                                            placeholder="Copyright Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Establishment Date</label>
                                        <input class="form-control" type="date" value="2010-01-12">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BANK -->
                    <div class="tab-panel" id="edit-bank">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">🏦</div> Bank Details
                                </div>
                            </div>
                            <div class="section-body">
                                <div id="bankEditWrapper">

                                    <!-- Bank Row 1 -->
                                    <div class="bank-row-edit">
                                        <span class="bank-row-number">Bank 1</span>
                                        <div class="form-row" style="grid-template-columns:repeat(4,1fr);">
                                            <div class="form-group">
                                                <label class="form-label">IFSC Code</label>
                                                <input class="form-control" type="text" value="HDFC0001234"
                                                    placeholder="IFSC Code">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Account No</label>
                                                <input class="form-control" type="text" value="50100234567890"
                                                    maxlength="15" placeholder="Account Number">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Account Type</label>
                                                <select class="form-select">
                                                    <option>Saving Account</option>
                                                    <option selected>Current Account</option>
                                                    <option>Overdraft/CC</option>
                                                    <option>NRE</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Bank Name</label>
                                                <input class="form-control" type="text" value="HDFC Bank"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Branch Name</label>
                                                <input class="form-control" type="text"
                                                    value="Bandra Kurla Complex, Mumbai" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Bank Code</label>
                                                <input class="form-control" type="text" value="HDFC" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Primary Account</label>
                                                <div style="padding-top:8px;display:flex;align-items:center;gap:8px;">
                                                    <input type="checkbox" checked
                                                        style="accent-color:var(--accent);width:16px;height:16px;">
                                                    <span style="font-size:13px;color:var(--ink-soft);">Set as
                                                        primary</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bank Row 2 -->
                                    <div class="bank-row-edit">
                                        <span class="bank-row-number">Bank 2</span>
                                        <button class="btn btn-danger btn-xs bank-row-remove"
                                            style="position:absolute;top:12px;right:12px;"
                                            onclick="removeBankRow(this)">✕ Remove</button>
                                        <div class="form-row" style="grid-template-columns:repeat(4,1fr);">
                                            <div class="form-group">
                                                <label class="form-label">IFSC Code</label>
                                                <input class="form-control" type="text" value="ICIC0000501"
                                                    placeholder="IFSC Code">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Account No</label>
                                                <input class="form-control" type="text" value="000501234567"
                                                    maxlength="15" placeholder="Account Number">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Account Type</label>
                                                <select class="form-select">
                                                    <option selected>Saving Account</option>
                                                    <option>Current Account</option>
                                                    <option>Overdraft/CC</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Bank Name</label>
                                                <input class="form-control" type="text" value="ICICI Bank"
                                                    readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Branch Name</label>
                                                <input class="form-control" type="text"
                                                    value="Andheri West, Mumbai" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Bank Code</label>
                                                <input class="form-control" type="text" value="ICICI" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Primary Account</label>
                                                <div style="padding-top:8px;display:flex;align-items:center;gap:8px;">
                                                    <input type="checkbox"
                                                        style="accent-color:var(--accent);width:16px;height:16px;">
                                                    <span style="font-size:13px;color:var(--ink-soft);">Set as
                                                        primary</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-outline btn-sm" onclick="addBankRow()"
                                    style="margin-top:4px;">
                                    ＋ Add More Bank
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- DOCUMENTS -->
                    <div class="tab-panel" id="edit-docs">
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-title">
                                    <div class="section-icon">📂</div> Documents
                                </div>
                                <small style="color:var(--ink-muted)">PDF, JPG, PNG, JPEG, WEBP · max 5MB each</small>
                            </div>
                            <div class="section-body">
                                <div class="doc-upload-grid">
                                    <div class="doc-upload-tile uploaded" onclick="triggerUpload('f1')">
                                        <div class="doc-upload-tile-icon">🪪</div>
                                        <div class="doc-upload-tile-label">PAN Card</div>
                                        <div class="doc-upload-hint" style="color:var(--success);font-weight:600;">✓
                                            Uploaded</div>
                                        <input type="file" id="f1" class="d-none"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp" style="display:none"
                                            onchange="markUploaded(this)">
                                    </div>
                                    <div class="doc-upload-tile uploaded" onclick="triggerUpload('f2')">
                                        <div class="doc-upload-tile-icon">📋</div>
                                        <div class="doc-upload-tile-label">TAN Certificate</div>
                                        <div class="doc-upload-hint" style="color:var(--success);font-weight:600;">✓
                                            Uploaded</div>
                                        <input type="file" id="f2" class="d-none"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp" style="display:none"
                                            onchange="markUploaded(this)">
                                    </div>
                                    <div class="doc-upload-tile uploaded" onclick="triggerUpload('f3')">
                                        <div class="doc-upload-tile-icon">📄</div>
                                        <div class="doc-upload-tile-label">GST Certificate</div>
                                        <div class="doc-upload-hint" style="color:var(--success);font-weight:600;">✓
                                            Uploaded</div>
                                        <input type="file" id="f3" class="d-none"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp" style="display:none"
                                            onchange="markUploaded(this)">
                                    </div>
                                    <div class="doc-upload-tile uploaded" onclick="triggerUpload('f4')">
                                        <div class="doc-upload-tile-icon">🏢</div>
                                        <div class="doc-upload-tile-label">MSME Certificate</div>
                                        <div class="doc-upload-hint" style="color:var(--success);font-weight:600;">✓
                                            Uploaded</div>
                                        <input type="file" id="f4" class="d-none"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp" style="display:none"
                                            onchange="markUploaded(this)">
                                    </div>
                                    <div class="doc-upload-tile" onclick="triggerUpload('f5')">
                                        <div class="doc-upload-tile-icon">🪪</div>
                                        <div class="doc-upload-tile-label">Udyam Aadhar</div>
                                        <div class="doc-upload-hint">Click to upload</div>
                                        <input type="file" id="f5" class="d-none"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp" style="display:none"
                                            onchange="markUploaded(this)">
                                    </div>
                                    <div class="doc-upload-tile uploaded" onclick="triggerUpload('f6')">
                                        <div class="doc-upload-tile-icon">📄</div>
                                        <div class="doc-upload-tile-label">Gumasta License</div>
                                        <div class="doc-upload-hint" style="color:var(--success);font-weight:600;">✓
                                            Uploaded</div>
                                        <input type="file" id="f6" class="d-none"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp" style="display:none"
                                            onchange="markUploaded(this)">
                                    </div>
                                    <div class="doc-upload-tile" onclick="triggerUpload('f7')">
                                        <div class="doc-upload-tile-icon">📄</div>
                                        <div class="doc-upload-tile-label">CKYC Document</div>
                                        <div class="doc-upload-hint">Click to upload</div>
                                        <input type="file" id="f7" class="d-none"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp" style="display:none"
                                            onchange="markUploaded(this)">
                                    </div>
                                    <div class="doc-upload-tile uploaded" onclick="triggerUpload('f8')">
                                        <div class="doc-upload-tile-icon">🏦</div>
                                        <div class="doc-upload-tile-label">Cancelled Cheque</div>
                                        <div class="doc-upload-hint" style="color:var(--success);font-weight:600;">✓
                                            Uploaded</div>
                                        <input type="file" id="f8" class="d-none"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp" style="display:none"
                                            onchange="markUploaded(this)">
                                    </div>
                                    <div class="doc-upload-tile uploaded" onclick="triggerUpload('f9')">
                                        <div class="doc-upload-tile-icon">👤</div>
                                        <div class="doc-upload-tile-label">Proprietor Photo</div>
                                        <div class="doc-upload-hint" style="color:var(--success);font-weight:600;">✓
                                            Uploaded</div>
                                        <input type="file" id="f9" class="d-none"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp" style="display:none"
                                            onchange="markUploaded(this)">
                                    </div>
                                    <div class="doc-upload-tile" onclick="triggerUpload('f10')">
                                        <div class="doc-upload-tile-icon">🏷️</div>
                                        <div class="doc-upload-tile-label">Company Logo</div>
                                        <div class="doc-upload-hint">Click to upload</div>
                                        <input type="file" id="f10" class="d-none"
                                            accept=".pdf,.jpg,.jpeg,.png,.webp" style="display:none"
                                            onchange="markUploaded(this)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sticky Save Bar -->
                    <div class="save-bar">
                        <button class="btn btn-outline" onclick="setMode('view')">✕ Cancel</button>
                        <button class="btn btn-primary" onclick="saveChanges()">💾 Save Changes</button>
                    </div>

                </div>
                <!-- END EDIT PANEL -->

            </div>
        </div>
    </div>

    <script>
        // ── Mode toggle ──
        let currentMode = 'view';
        let currentTab = 'basic';

        function setMode(mode) {
            currentMode = mode;
            document.getElementById('view-panel').style.display = mode === 'view' ? 'block' : 'none';
            document.getElementById('edit-panel').style.display = mode === 'edit' ? 'block' : 'none';
            document.getElementById('viewModeBtn').classList.toggle('active', mode === 'view');
            document.getElementById('editModeBtn').classList.toggle('active', mode === 'edit');
            // sync tab
            showTabPanel(currentTab, mode);
        }

        // ── Tabs ──
        function switchTab(tab, btn) {
            currentTab = tab;
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            showTabPanel(tab, currentMode);
        }

        function showTabPanel(tab, mode) {
            const prefix = mode === 'view' ? 'view' : 'edit';
            // Hide all in both panels
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            const target = document.getElementById(`${prefix}-${tab}`);
            if (target) target.classList.add('active');
        }

        // ── Same address ──
        function copySameAddr(cb) {
            const fields = ['addr1', 'addr2', 'city', 'pin'];
            if (cb.checked) {
                document.getElementById('op_addr1').value = document.getElementById('reg_addr1').value;
                document.getElementById('op_addr2').value = document.getElementById('reg_addr2').value;
                document.getElementById('op_city').value = document.getElementById('reg_city').value;
                document.getElementById('op_pin').value = document.getElementById('reg_pin').value;
                document.getElementById('op_state').value = document.getElementById('reg_state').value;
                document.getElementById('op_country').value = document.getElementById('reg_country').value;
                document.getElementById('opAddrCol').style.opacity = '0.6';
                document.getElementById('opAddrCol').style.pointerEvents = 'none';
            } else {
                document.getElementById('opAddrCol').style.opacity = '1';
                document.getElementById('opAddrCol').style.pointerEvents = 'auto';
            }
        }

        // ── Bank rows ──
        let bankCount = 2;

        function addBankRow() {
            bankCount++;
            const wrapper = document.getElementById('bankEditWrapper');
            const div = document.createElement('div');
            div.className = 'bank-row-edit';
            div.innerHTML = `
      <span class="bank-row-number">Bank ${bankCount}</span>
      <button class="btn btn-danger btn-xs" style="position:absolute;top:12px;right:12px;" onclick="removeBankRow(this)">✕ Remove</button>
      <div class="form-row" style="grid-template-columns:repeat(4,1fr);">
        <div class="form-group"><label class="form-label">IFSC Code</label><input class="form-control" type="text" placeholder="IFSC Code"></div>
        <div class="form-group"><label class="form-label">Account No</label><input class="form-control" type="text" maxlength="15" placeholder="Account Number"></div>
        <div class="form-group"><label class="form-label">Account Type</label>
          <select class="form-select"><option>Saving Account</option><option>Current Account</option><option>Overdraft/CC</option><option>NRE</option></select>
        </div>
        <div class="form-group"><label class="form-label">Bank Name</label><input class="form-control" type="text" readonly placeholder="Auto-filled"></div>
        <div class="form-group"><label class="form-label">Branch Name</label><input class="form-control" type="text" readonly placeholder="Auto-filled"></div>
        <div class="form-group"><label class="form-label">Bank Code</label><input class="form-control" type="text" readonly placeholder="Auto-filled"></div>
        <div class="form-group"><label class="form-label">Primary Account</label>
          <div style="padding-top:8px;display:flex;align-items:center;gap:8px;">
            <input type="checkbox" style="accent-color:var(--accent);width:16px;height:16px;">
            <span style="font-size:13px;color:var(--ink-soft);">Set as primary</span>
          </div>
        </div>
      </div>`;
            wrapper.appendChild(div);
            div.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }

        function removeBankRow(btn) {
            btn.closest('.bank-row-edit').remove();
        }

        // ── Doc upload ──
        function triggerUpload(id) {
            document.getElementById(id).click();
        }

        function markUploaded(input) {
            const tile = input.closest('.doc-upload-tile');
            if (input.files && input.files[0]) {
                tile.classList.add('uploaded');
                tile.querySelector('.doc-upload-hint').textContent = '✓ ' + input.files[0].name;
                tile.querySelector('.doc-upload-hint').style.color = 'var(--success)';
                tile.querySelector('.doc-upload-hint').style.fontWeight = '600';
            }
        }

        // ── Save ──
        function saveChanges() {
            const btn = document.querySelector('.save-bar .btn-primary');
            btn.textContent = '⏳ Saving...';
            btn.disabled = true;
            setTimeout(() => {
                btn.textContent = '✅ Saved!';
                btn.style.background = 'var(--success)';
                setTimeout(() => {
                    btn.textContent = '💾 Save Changes';
                    btn.style.background = '';
                    btn.disabled = false;
                    setMode('view');
                }, 1200);
            }, 1000);
        }
    </script>

</body>

</html>
