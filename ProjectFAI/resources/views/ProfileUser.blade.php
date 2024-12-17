
<!DOCTYPE html>
<html>
<head>
    <title>Profile User</title>
    <style>
        .profile-picture {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .profile-initials {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: orange;
            text-align: center;
            line-height: 100px;
            font-size: 40px;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Profile User</h1>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <label>Nama:</label>
        <input type="text" name="nama" value="{{ $user->nama }}" required><br>
        
        <label>Profile Picture:</label>
        <input type="file" name="img"><br>
        
        @if ($user->img)
            <img src="{{ asset('images/' . $user->img) }}" alt="Profile Picture" class="profile-picture"><br>
        @else
            <div class="profile-initials">
                {{ strtoupper(substr(explode(' ', $user->nama)[0], 0, 1)) }}{{ isset(explode(' ', $user->nama)[1]) ? strtoupper(substr(explode(' ', $user->nama)[1], 0, 1)) : strtoupper(substr($user->nama, 1, 1)) }}
            </div>
        @endif
        
        <button type="submit">Update Profile</button>
        
    </form>
    <form action="{{ route('profile.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
        @csrf
        <button type="submit">Delete Account</button>
    </form>
</body>
</html>
