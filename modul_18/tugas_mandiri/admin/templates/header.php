<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — Portal Berita</title>
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
            width: 240px;
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
            font-size: 1.1rem;
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
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
        }

        .brand-name span {
            background: linear-gradient(90deg, #60a5fa, #818cf8);
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

        .user-level {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 999px;
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, 0.3);
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
            background: rgba(59, 130, 246, 0.1);
            border-left-color: #3b82f6;
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
            margin-left: 240px;
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
            color: #60a5fa;
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

        .card-max-md {
            max-width: 700px;
        }

        .card-max-sm {
            max-width: 600px;
        }

        .card-max-xs {
            max-width: 500px;
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

        .btn-primary-dark {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            border: none;
            border-radius: 9px;
            padding: 8px 16px;
            color: #fff;
            font-size: 0.85rem;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn-primary-dark:hover {
            opacity: 0.88;
            transform: translateY(-1px);
            color: #fff;
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

        .aksi-btn-lg {
            padding: 7px 14px;
            font-size: 0.82rem;
        }

        .btn-detail-sm {
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .btn-detail-sm:hover {
            background: rgba(59, 130, 246, 0.25);
            color: #93c5fd;
        }

        .btn-edit-sm {
            background: rgba(234, 179, 8, 0.15);
            color: #fde047;
            border: 1px solid rgba(234, 179, 8, 0.3);
        }

        .btn-edit-sm:hover {
            background: rgba(234, 179, 8, 0.25);
            color: #fde047;
        }

        .btn-hapus-sm {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-hapus-sm:hover {
            background: rgba(239, 68, 68, 0.25);
            color: #fca5a5;
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

        .form-label-dark {
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: 0.03em;
            margin-bottom: 6px;
            display: block;
        }

        .form-label-hint {
            color: rgba(255, 255, 255, 0.3);
            font-size: 0.75rem;
            font-weight: 400;
        }

        .form-control-dark {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 9px;
            padding: 9px 13px;
            color: #fff;
            font-size: 0.875rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            width: 100%;
        }

        textarea.form-control-dark {
            resize: vertical;
            min-height: 110px;
        }

        select.form-control-dark option {
            background: #1a2234;
        }

        .img-thumb {
            width: 65px;
            height: 46px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .img-preview {
            height: 80px;
            border-radius: 8px;
            margin-bottom: 8px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: block;
        }

        .badge-admin {
            background: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
            border: 1px solid rgba(99, 102, 241, 0.3);
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
        }

        .badge-user {
            background: rgba(34, 197, 94, 0.15);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 999px;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 2px 8px;
        }

        .alert-success-dark {
            background: rgba(34, 197, 94, 0.12);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.85rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-danger-dark {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.85rem;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
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

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-icon-blue {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
        }

        .stat-icon-green {
            background: rgba(34, 197, 94, 0.15);
            color: #86efac;
        }

        .stat-icon-indigo {
            background: rgba(99, 102, 241, 0.15);
            color: #a5b4fc;
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

        .detail-img {
            width: 100%;
            max-height: 360px;
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
            color: #60a5fa;
        }

        .detail-body {
            font-size: 0.95rem;
            line-height: 1.85;
            color: rgba(255, 255, 255, 0.75);
        }

        .detail-actions {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            display: flex;
            gap: 8px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            flex-shrink: 0;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 800;
            color: #fff;
        }

        .user-profile-name {
            font-size: 1.1rem;
            font-weight: 800;
            color: #fff;
        }

        .user-profile-username {
            font-size: 0.82rem;
            color: #60a5fa;
        }

        .username-mono {
            font-family: monospace;
            font-size: 0.82rem;
            color: #60a5fa;
        }

        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }

        .detail-table tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .detail-table tr:last-child {
            border-bottom: none;
        }

        .detail-table td {
            padding: 10px 0;
        }

        .detail-table .td-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.4);
            width: 40%;
        }

        .detail-table .td-value {
            font-size: 0.875rem;
            color: #fff;
        }

        .detail-user-actions {
            margin-top: 1.5rem;
            display: flex;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>