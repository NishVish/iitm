<!DOCTYPE html>
<html>

<head>
    <title>Master Backend</title>

    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: #0f172a;
            color: white;
        }

        /* PIN SCREEN */
        .center {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .box {
            background: #1f2937;
            padding: 25px;
            width: 320px;
            border-radius: 12px;
        }

        input,
        button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
        }

        button {
            background: #2563eb;
            border: none;
            color: white;
            cursor: pointer;
        }

        /* DASHBOARD */
        .topbar {
            background: #1e293b;
            padding: 15px;
            display: flex;
            justify-content: space-between;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #334155;
        }

        .container {
            padding: 20px;
        }

        .logout {
            color: white;
        }
    </style>
</head>

<body>

    {{-- 🔐 PIN SCREEN --}}
    @if($screen == 'pin')

        <div class="center">
            <div class="box">

                <h2>Enter PIN</h2>

                @if(session('error'))
                    <p style="color:red;">{{ session('error') }}</p>
                @endif

                <form method="POST" action="{{ url('/masterbackend/check-pin') }}">
                    @csrf
                    <input type="password" name="pin" placeholder="Enter PIN">
                    <button>Submit</button>
                </form>

            </div>
        </div>

    @endif

    {{-- 👥 DASHBOARD --}}
    @if($screen == 'dashboard')

        <div class="topbar">
            <div>Master Backend</div>
            <a class="logout" href="{{ url('/masterbackend/logout') }}">Logout</a>
        </div>

        <div class="container">

            <h2>Users</h2>

            {{-- CREATE USER --}}
            <form method="POST" action="{{ url('/masterbackend/users/store') }}">
                @csrf
                <input name="name" placeholder="Name">
                <input name="email" placeholder="Email">
                <input name="phone" placeholder="Phone">
                <input name="password" placeholder="Password">
                <button>Add User</button>
            </form>

            {{-- USERS TABLE --}}
            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>

                @foreach($users as $user)
                    <tr>
                        <form method="POST" action="{{ url('/masterbackend/users/update/' . $user->id) }}">
                            @csrf

                            <td><input name="name" value="{{ $user->name }}"></td>
                            <td><input name="email" value="{{ $user->email }}"></td>
                            <td><input name="phone" value="{{ $user->phone }}"></td>

                            <td>
                                <button>Update</button>
                                <a href="{{ url('/masterbackend/users/delete/' . $user->id) }}" style="color:red;">Delete</a>
                            </td>
                        </form>
                    </tr>
                @endforeach

            </table>

        </div>

    @endif

</body>

</html>