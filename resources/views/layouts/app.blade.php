<!DOCTYPE html>
<html>
<head>
    <title>Personal Task Manager</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { text-align: left; padding: 10px; border-bottom: 1px solid #ddd; }
        .btn { display: inline-block; padding: 6px 12px; border-radius: 4px; text-decoration: none; color: white; font-size: 14px; border: none; cursor: pointer; }
        .btn-add { background: #28a745; margin-bottom: 15px; }
        .btn-edit { background: #007bff; }
        .btn-delete { background: #dc3545; }
        .status-pending { color: #e67e22; font-weight: bold; }
        .status-completed { color: #28a745; font-weight: bold; }
        .alert { padding: 10px; background: #d4edda; color: #155724; border-radius: 4px; margin-bottom: 15px; }
        form.inline { display: inline; }
        input[type=text], textarea, input[type=date], select { width: 100%; padding: 8px; margin: 6px 0 12px 0; box-sizing: border-box; }
        label { font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>