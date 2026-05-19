<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Berita — User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0d1117;
            color: #e6edf3;
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 230px;
            background: rgba(13, 17, 23, 0.98);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 1.4rem 1.2rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-logo .brand {
            font-size: 1.05rem;
            font-weight: 800;
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #10b981, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .brand-name span {
            background: linear-gradient(90deg, #34d399, #6ee7b7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-user {
            padding: 0.9rem 1.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .sidebar-user .user-name {
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
        }

        .user-level-badge {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 999px;
            background: rgba(52, 211, 153, 0.15);
            color: #6ee7b7;
            border: 1px solid rgba(52, 211, 153, 0.3);
            display: inline-block;
            margin-top: 2px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 0.8rem 0;
        }

        .nav-label {
            font-size: 0.68rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            padding: 0.5rem 1.2rem 0.3rem;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 1.2rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            border-left: 2px solid transparent;
            transition: all 0.15s;
        }

        .nav-item a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.04);
        }

        .nav-item a.active {
            color: #fff;
            background: rgba(52, 211, 153, 0.08);
            border-left-color: #10b981;
        }

        .nav-item a i {
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .sidebar-footer {
            padding: 0.8rem 1.2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .btn-logout-side {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            width: 100%;
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
        }

        .btn-logout-side:hover {
            background: rgba(239, 68, 68, 0.18);
            color: #fca5a5;
        }

        .main-content {
            margin-left: 230px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            padding: 0.85rem 1.8rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(13, 17, 23, 0.8);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-title {
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
        }

        .topbar-user {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .topbar-user strong {
            color: #34d399;
        }

        .read-only-badge {
            font-size: 0.72rem;
            padding: 3px 9px;
            border-radius: 999px;
            background: rgba(234, 179, 8, 0.12);
            color: #fde047;
            border: 1px solid rgba(234, 179, 8, 0.25);
            font-weight: 600;
        }

        .content-area {
            padding: 1.8rem;
            flex: 1;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h2 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.2rem;
        }

        .page-header h2.subtitle {
            font-size: 1.1rem;
        }

        .page-header p {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .card-dark {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            overflow: hidden;
        }

        .card-dark-pad {
            padding: 1.4rem;
        }

        .card-detail {
            max-width: 800px;
        }

        .table-dark-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .table-dark-custom thead tr {
            background: rgba(255, 255, 255, 0.04);
        }

        .table-dark-custom thead th {
            padding: 11px 14px;
            font-size: 0.75rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.4);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .table-dark-custom tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            transition: background 0.12s;
        }

        .table-dark-custom tbody tr:last-child {
            border-bottom: none;
        }

        .table-dark-custom tbody tr:hover {
            background: rgba(255, 255, 255, 0.025);
        }

        .table-dark-custom tbody td {
            padding: 11px 14px;
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.8);
            vertical-align: middle;
        }

        .aksi-btn {
            font-size: 0.76rem;
            padding: 4px 9px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-right: 3px;
            transition: background 0.15s;
        }

        .aksi-btn-md {
            padding: 5px 12px;
        }

        .btn-detail-sm {
            background: rgba(52, 211, 153, 0.12);
            color: #6ee7b7;
            border: 1px solid rgba(52, 211, 153, 0.3);
        }

        .btn-detail-sm:hover {
            background: rgba(52, 211, 153, 0.22);
            color: #6ee7b7;
        }

        .btn-back-sm {
            font-size: 0.82rem;
            padding: 6px 14px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 500;
        }

        .btn-back-sm:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }

        .img-thumb {
            width: 65px;
            height: 46px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .empty-state {
            text-align: center;
            padding: 3rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .empty-state i {
            font-size: 2rem;
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-icon-green {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: rgba(52, 211, 153, 0.15);
            color: #34d399;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: #fff;
        }

        .stat-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.4);
        }

        .info-card {
            height: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-card-icon {
            color: #60a5fa;
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .info-card-text {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.6;
        }

        .news-card-img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            display: block;
        }

        .news-card-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.4rem;
            line-height: 1.3;
        }

        .news-card-meta {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.35);
            margin-bottom: 0.8rem;
        }

        .detail-img {
            width: 100%;
            max-height: 380px;
            object-fit: cover;
            display: block;
        }

        .detail-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.8rem;
        }

        .detail-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.2rem;
            flex-wrap: wrap;
        }

        .detail-meta span {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.4);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .detail-meta i {
            color: #34d399;
        }

        .detail-body {
            font-size: 0.95rem;
            line-height: 1.85;
            color: rgba(255, 255, 255, 0.75);
        }

        .detail-footer {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .detail-footer-note {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            gap: 6px;
        }
    </style>
</head>
<body>