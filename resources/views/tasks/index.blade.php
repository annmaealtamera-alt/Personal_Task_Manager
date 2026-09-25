<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Personal Task Manager</title>

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
            max-width: 1100px;
            margin: auto;
        }

        .header {
            background: white;
            padding: 30px;
            border-radius: 22px;
            box-shadow: 0 8px 25px rgba(120, 70, 150, 0.12);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .header h1 {
            color: #8e44ad;
            font-size: 32px;
            margin-bottom: 8px;
        }

        .header p {
            color: #777;
        }

        .add-btn {
            background: linear-gradient(135deg, #a855f7, #ec4899);
            color: white;
            text-decoration: none;
            padding: 13px 20px;
            border-radius: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .add-btn:hover {
            opacity: 0.9;
        }

        .success {
            background: #f0d9ff;
            color: #6b21a8;
            padding: 15px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .tasks {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .task-card {
            background: white;
            padding: 22px;
            border-radius: 18px;
            box-shadow: 0 7px 20px rgba(120, 70, 150, 0.10);
            border-left: 6px solid #c084fc;
        }

        .task-card h2 {
            color: #7e22ce;
            margin-bottom: 10px;
            font-size: 21px;
        }

        .description {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .info {
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .pending {
            background: #ffe4f1;
            color: #be185d;
        }

        .completed {
            background: #e9d5ff;
            color: #7e22ce;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .btn {
            border: none;
            padding: 9px 13px;
            border-radius: 9px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            font-size: 13px;
        }

        .edit {
            background: #e9d5ff;
            color: #6b21a8;
        }

        .complete {
            background: #fbcfe8;
            color: #9d174d;
        }

        .delete {
            background: #ffe4e6;
            color: #be123c;
        }

        .empty {
            background: white;
            padding: 50px 20px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 7px 20px rgba(120, 70, 150, 0.10);
        }

        .empty h2 {
            color: #8e44ad;
            margin-bottom: 10px;
        }

        @media (max-width: 650px) {
            body {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header h1 {
                font-size: 26px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>💜 Personal Task Manager</h1>
            <p>Organize your tasks and stay productive.</p>
        </div>

        <a href="/tasks/create" class="add-btn">
            + Add New Task
        </a>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($tasks->count() > 0)

        <div class="tasks">

            @foreach($tasks as $task)

                <div class="task-card">

                    <h2>{{ $task->task_name }}</h2>

                    @if($task->description)
                        <p class="description">
                            {{ $task->description }}
                        </p>
                    @else
                        <p class="description">
                            No description provided.
                        </p>
                    @endif

                    @if($task->status === 'Completed')
                        <span class="status completed">
                            ✓ Completed
                        </span>
                    @else
                        <span class="status pending">
                            ⏳ Pending
                        </span>
                    @endif

                    <div class="info">
                        <strong>Due Date:</strong>

                        @if($task->due_date)
                            {{ \Carbon\Carbon::parse($task->due_date)->format('F d, Y') }}
                        @else
                            No due date
                        @endif
                    </div>

                    <div class="actions">

                        <!-- EDIT -->
                        <a href="/tasks/{{ $task->id }}/edit"
                           class="btn edit">
                            ✏️ Edit
                        </a>

                        <!-- STATUS -->
                        @if($task->status === 'Pending')

                            <form action="/tasks/{{ $task->id }}/status"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('PATCH')

                                <input type="hidden"
                                       name="status"
                                       value="Completed">

                                <button type="submit" class="btn complete">
                                    ✓ Complete
                                </button>

                            </form>

                        @else

                            <form action="/tasks/{{ $task->id }}/status"
                                  method="POST"
                                  style="display:inline;">

                                @csrf
                                @method('PATCH')

                                <input type="hidden"
                                       name="status"
                                       value="Pending">

                                <button type="submit" class="btn complete">
                                    ↩ Pending
                                </button>

                            </form>

                        @endif

                        <!-- DELETE -->
                        <form action="/tasks/{{ $task->id }}"
                              method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('Are you sure you want to delete this task?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn delete">
                                🗑 Delete
                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty">

            <h2>🌸 No Tasks Yet</h2>

            <p>
                You don't have any tasks yet.
                Click "Add New Task" to create one.
            </p>

        </div>

    @endif

</div>

</body>
</html>