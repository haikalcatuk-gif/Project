<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen text-slate-800 p-4 font-[Inter]">
    <div class="bg-white p-8 md:p-10 rounded-3xl shadow-xl w-full max-w-md border border-slate-200">
        
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-inner border border-blue-100">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Login Admin</h2>
            <p class="text-slate-500 text-sm mt-2">Masuk untuk mengelola perpustakaan</p>
        </div>

        @if(session('error')) 
        <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm font-bold text-center border border-red-100">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ session('error') }}
        </div> 
        @endif
        
        @if(session('success')) 
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-xl mb-6 text-sm font-bold text-center border border-emerald-100">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
        </div> 
        @endif

        <form action="/login" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2 pl-1">Username</label>
                <div class="relative">
                    <i class="fa-solid fa-user absolute left-4 top-3.5 text-slate-400"></i>
                    <input type="text" name="username" required placeholder="admin" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none bg-slate-50 focus:bg-white transition-all">
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 mb-2 pl-1">Password</label>
                <div class="relative">
                    <i class="fa-solid fa-key absolute left-4 top-3.5 text-slate-400"></i>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none bg-slate-50 focus:bg-white transition-all">
                </div>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md hover:shadow-lg mt-4">
                Masuk Dashboard
            </button>
            <a href="/" class="block text-center text-sm font-semibold text-slate-500 hover:text-blue-600 mt-6 transition-colors">
                <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Beranda
            </a>
        </form>
    </div>
</body>
</html>