<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="flex gap-2 flex-wrap content-start">
        <div class="w-full h-16 bg-blue-500 text-white p-4">Header</div>
        <div class="w-1/4 h-[calc(100vh-64px)] bg-gray-200 p-4">Sidebar</div>
        <div class="flex-grow h-[calc(100vh-64px)] bg-gray-100 p-4">
            <h1 class="text-xl font-bold">Welcome, {{ Auth::user()->name }}</h1>
            <form action="{{ route('logout') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-red-500 text-white p-2 rounded">Logout</button>
            </form>
        </div>
        <div class="w-full h-16 bg-blue-500 text-white p-4">Footer</div>
    </div>

    {{-- <script src="{{ mix('js/app.js') }}"></script> --}}
</body>
</html>