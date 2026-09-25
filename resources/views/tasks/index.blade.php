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
            margin: 20px auto;
        }

        .header {
            background: white;
            padding: 25px;
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            box-shadow: 0 8px 25px rgba(120, 70, 150, 0.10);
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
            padding: 13px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: bold;
            white-space: nowrap;
        }

        .add-btn:hover {
            opacity: 0.9;
        }

        /* STATISTICS */

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin: 25px 0;
        }

        .stat-card {
            background: white;
            padding: 22px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(120, 70, 150, 0.10);
        }

        .stat-card h3 {
            color: #6b21a8;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .stat-card p {
            color: #a855f7;
            font-size: 32px;
            font-weight: bold;
        }

        /* SUCCESS MESSAGE */

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        /* TASKS */

        .tasks {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .task-card {
            background: white;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(120, 70, 150, 0.10);
        }

        .task-card h2 {
            color: #7e22ce;
            margin-bottom: 12px;
        }

        .description {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .status {
            display: inline-block;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .completed {
            background: #dcfce7;
            color: #166534;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .info {
            color: #666;
            margin-bottom: 18px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .btn {
            border: none;
            padding: 9px 13px;
            border-radius: 10px;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
        }

        .edit {
            background: #e9d5ff;
            color: #6b21a8;
        }

        .complete {
            background: #dcfce7;
            color: #166534;
        }

        .delete {
            background: #ffe4e6;
            color: #be123c;
        }

        .btn:hover {
            opacity: 0.85;
        }

        /* EMPTY */

        .empty {
            background: white;
            padding: 50px;
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(120, 70, 150, 0.10);
        }

        .empty h2 {
            color: #8e44ad;
            margin-bottom: 10px;
        }

        .empty p {
            color: #777;
        }

        @media (max-width: 750px) {

            body {
                padding: 15px;
            }

            .header {
                flex-direction: column;
                text-align: center;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .tasks {
                grid-template-columns: 1fr;
            }

        }
    </style>
</head>

<body>

<div class="container">

    <!-- HEADER -->

    <div class="header">

        <div>
            <h1>💜 Personal Task Manager</h1>
            <p>Organize your tasks and stay productive.</p>
        </div>

        <a href="/tasks/create" class="add-btn">
            + Add New Task
        </a>

    </div>


    <!-- STATISTICS -->

    <div class="stats">

        <div class="stat-card">
            <h3>Total Tasks</h3>
            <p>{{ $tasks->count() }}</p>
        </div>

        <div class="stat-card">
            <h3>Pending</h3>
            <p>{{ $tasks->where('status', 'Pending')->count() }}</p>
        </div>

        <div class="stat-card">
            <h3>Completed</h3>
            <p>{{ $tasks->where('status', 'Completed')->count() }}</p>
        </div>

    </div>


    <!-- SUCCESS MESSAGE -->

    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    <!-- TASK LIST -->

    @if($tasks->count() > 0)

        <div class="tasks">

            @foreach($tasks as $task)

                <div class="task-card">

                    <h2>
                        {{ $task->task_name }}
                    </h2>


                    @if($task->description)

                        <p class="description">
                            {{ $task->description }}
                        </p>

                    @else

                        <p class="description">
                            No description provided.
                        </p>

                    @endif


                    <!-- STATUS -->

                    @if($task->status === 'Completed')

                        <span class="status completed">
                            ✓ Completed
                        </span>

                    @else

                        <span class="status pending">
                            ⏳ Pending
                        </span>

                    @endif


                    <!-- DUE DATE -->

                    <div class="info">

                        <strong>Due Date:</strong>

                        @if($task->due_date)

                            {{ \Carbon\Carbon::parse($task->due_date)->format('F d, Y') }}

                        @else

                            No due date

                        @endif

                    </div>


                    <!-- ACTIONS -->

                    <div class="actions">

                        <!-- EDIT -->

                        <a href="/tasks/{{ $task->id }}/edit"
                           class="btn edit">

                            ✏️ Edit

                        </a>


                        <!-- STATUS BUTTON -->

                        @if($task->status === 'Pending')

                            <form action="/tasks/{{ $task->id }}/status"
                                  method="POST"
                                  style="display:inline;">

                                @csrf

                                @method('PATCH')

                                <input type="hidden"
                                       name="status"
                                       value="Completed">

                                <button type="submit"
                                        class="btn complete">

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

                                <button type="submit"
                                        class="btn complete">

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

                            <button type="submit"
                                    class="btn delete">

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