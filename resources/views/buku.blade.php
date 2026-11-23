<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - {{ $book->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-100 text-slate-800 font-[Inter] flex items-center justify-center min-h-screen p-4">
    <div class="bg-white p-8 md:p-12 rounded-3xl shadow-xl w-full max-w-2xl border border-slate-200">
        <a href="/" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-blue-600 transition-colors mb-6">
            <i class="fa-solid fa-arrow-left mr-2"></i>Kembali ke Beranda
        </a>
        <div class="space-y-4">
            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold uppercase">Detail Buku</span>
            <h1 class="text-3xl font-bold text-slate-800">{{ $book->title }}</h1>
            <p class="text-slate-500 text-lg font-medium"><i class="fa-solid fa-pen-nib mr-2"></i>{{ $book->author }}</p>
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase">Stok Tersedia</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ $book->stock }}</p>
                </div>
                <a href="/" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-all shadow-md">
                    Pinjam Buku Ini
                </a>
            </div>
        </div>
    </div>
</body>
</html>