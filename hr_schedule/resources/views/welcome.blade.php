<!DOCTYPE html>
<html>
<head>
    <title>HR Shift Swap</title>

    <style>
        body{
            font-family: Arial;
            padding: 20px;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-top:20px;
        }

        table, th, td{
            border:1px solid #ccc;
        }

        th, td{
            padding:10px;
            text-align:left;
        }

        input, button{
            padding:10px;
            margin:5px;
        }

        .box{
            border:1px solid #ddd;
            padding:20px;
            margin-bottom:30px;
        }
    </style>
</head>
<body>

<h1>HR Shift Swap System</h1>

<div class="box">
    <h2>Post Shift</h2>

    <form action="{{ route('shift.store') }}" method="POST">
        @csrf

        <input type="text" name="employee_name" placeholder="Employee Name" required>

        <input type="text" name="day" placeholder="Day" required>

        <input type="text" name="time" placeholder="Time" required>

        <button type="submit">Post Shift</button>
    </form>
</div>

<div class="box">
    <h2>Available Shifts</h2>

    <table>
        <tr>
            <th>Employee</th>
            <th>Day</th>
            <th>Time</th>
            <th>Action</th>
        </tr>

        @foreach($shifts as $shift)
        <tr>
            <td>{{ $shift->employee_name }}</td>
            <td>{{ $shift->day }}</td>
            <td>{{ $shift->time }}</td>

            <td>
                <form action="{{ route('shift.take', $shift->id) }}" method="POST">
                    @csrf

                    <input type="text"
                           name="swapped_with"
                           placeholder="Your Name"
                           required>

                    <button type="submit">
                        Take Shift
                    </button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>
</div>

<div class="box">
    <h2>Completed Swaps</h2>

    <table>
        <tr>
            <th>Original Employee</th>
            <th>Swapped With</th>
            <th>Day</th>
            <th>Time</th>
        </tr>

        @foreach($swaps as $swap)
        <tr>
            <td>{{ $swap->original_employee }}</td>
            <td>{{ $swap->swapped_with }}</td>
            <td>{{ $swap->day }}</td>
            <td>{{ $swap->time }}</td>
        </tr>
        @endforeach

    </table>
</div>

</body>
</html>