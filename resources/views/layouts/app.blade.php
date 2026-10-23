<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Student Management</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    
    <div class="navbar">
        
        <div class="logo">
            College Management
        </div>

        <div>
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('admin.login') }}">Admin Login</a>
            <a href="{{ route('student.login') }}">Student Login</a>
        </div> 
        
    </div>

    @yield('content')

    <div class="footer">

        <p>
            &copy; 2026 College Student Management System
        </p>
    </div>

</body>
</html>