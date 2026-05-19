<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            display: flex;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #2c3e50;
            color: white;
            min-height: 100vh;
        }

        .sidebar h2 {
            text-align: center;
            padding: 15px 0;
        }

        .sidebar a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        .active {
            background: #1abc9c;
        }

        /* Main layout */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Content */
        .content {
            flex: 1;
            padding: 20px;
        }

        /* Footer */
        .footer {
            background: #eee;
            padding: 10px;
            text-align: center;
        }
    </style>
</head>

</html>