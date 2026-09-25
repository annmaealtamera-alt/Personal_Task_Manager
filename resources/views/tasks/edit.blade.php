<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Task | Personal Task Manager</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f3e8ff, #ffe4f1);
            color: #3f3151;
            padding: 30px;
        }

        .container {
            max-width: 750px;
            margin: 40px auto;
        }

        .form-card {
            background: white;
            padding: 35px;
            border-radius: 22px;
            box-shadow: 0 8px 25px rgba(120, 70, 150, 0.12);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #8e44ad;
            font-size: 32px;
            margin-bottom: 8px;
        }

        .header p {
            color: #777;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #6b21a8;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 13px 15px;
            border: 2px solid #eadcff;
            border-radius: 12px;
            outline: none;
            font-size: 15px;
            background: #fffaff;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #c084fc;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .error-box {
            background: #ffe4e6;
            color: #be123c;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .error-box ul {
            margin-left: 20px;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .btn {
            border: none;
            padding: 13px 20px;
            border-radius: 12px;
            font-weight: bold;
            text-decoration: none;
            cursor: pointer;
            font-size: 15px;
        }

        .update-btn {
            flex: 1;
            background: linear-gradient(135deg, #a855f7, #ec4899);
            color: white;
        }

        .back-btn {
            background: #e9d5ff;
            color: #6b21a8;
        }

        .update-btn:hover,
        .back-btn:hover {
            opacity: 0.9;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }

            .form-card {
                padding: 25px 20px;
            }

            .buttons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="form-card">

        <div class="header">
            <h1>💜 Edit Task</h1>
            <p>Update your task information below.</p>
        </div>

        @if($errors->any())
            <div class="error-box">
                <strong>Please fix the following:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/tasks/{{ $task->id }}" method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="task_name">Task Name</label>

                <input
                    type="text"
                    id="task_name"
                    name="task_name"
                    value="{{ old('task_name', $task->task_name) }}"
                    placeholder="Enter your task name"
                    required
                >
            </div>

            <div class="form-group">
                <label for="description">Description</label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Enter task description"
                >{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="status">Status</label>

                <select id="status" name="status" required>
                    <option value="Pending"
                        {{ old('status', $task->status) == 'Pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="Completed"
                        {{ old('status', $task->status) == 'Completed' ? 'selected' : '' }}>
                        Completed
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="due_date">Due Date</label>

                <input
                    type="date"
                    id="due_date"
                    name="due_date"
                    value="{{ old('due_date', $task->due_date) }}"
                >
            </div>

            <div class="buttons">

                <a href="/tasks" class="btn back-btn">
                    ← Back to Tasks
                </a>

                <button type="submit" class="btn update-btn">
                    ✨ Update Task
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>