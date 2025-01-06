<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Cafe Theme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4e1d2;
            color: #5a3e2b;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background-color: #fff5eb;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #d2a679;
        }
        .profile-initials {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: #d2691e;
            text-align: center;
            line-height: 120px;
            font-size: 50px;
            color: white;
            margin: auto;
        }
        .btn-cafe {
            background-color: #8b4513;
            color: white;
        }
        .btn-cafe:hover {
            background-color: #5a3e2b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Update Profile</h2>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $user->nama }}" required>
            </div>

            <div class="mb-3">
                <label for="img" class="form-label">Profile Picture:</label>
                <input class="form-control" type="file" id="img" name="img">
            </div>
            
            <div class="text-center mb-3">
                @if ($user->img)
                    <img src="{{ asset('images/' . $user->img) }}" alt="Profile Picture" class="profile-picture">
                @else
                    <div class="profile-initials">
                        {{ strtoupper(substr(explode(' ', $user->nama)[0], 0, 1)) }}{{ isset(explode(' ', $user->nama)[1]) ? strtoupper(substr(explode(' ', $user->nama)[1], 0, 1)) : strtoupper(substr($user->nama, 1, 1)) }}
                    </div>
                @endif
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-cafe">Update Profile</button>
            </div>
        </form>

        <form action="{{ route('profile.delete') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');" class="mt-3">
            @csrf
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-danger">Delete Account</button>
            </div>
        </form>

        <div class="text-center mt-4">
            <a href="/index" class="btn btn-secondary">Back</a>
        </div>
    </div>
</body>
</html>
