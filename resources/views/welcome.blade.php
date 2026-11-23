<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpus Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 font-[Inter]">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
            <a href="/" class="flex items-center gap-2">
                <i class="fa-solid fa-book-open text-blue-600 text-2xl"></i>
                <span class="font-bold text-slate-800 text-xl tracking-tight">Perpus <span class="text-blue-600">Digital</span></span>
            </a>
            <div class="hidden md:flex space-x-8 text-sm font-semibold text-slate-600">
                <a href="#" class="hover:text-blue-600 transition-colors">Beranda</a>
                <a href="#katalog" class="hover:text-blue-600 transition-colors">Katalog Buku</a>
                <a href="#peminjaman" class="hover:text-blue-600 transition-colors">Peminjaman Aktif</a>
            </div>
            <a href="/login" class="bg-slate-900 text-white px-5 py-2 rounded-xl text-sm font-bold shadow-md hover:bg-blue-600 transition-all">Login Admin</a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto space-y-8 p-4 md:p-8">
        <div class="text-center py-8">
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 tracking-tight mb-3">Pinjam Buku Lebih Mudah 🚀</h2>
            <p class="text-slate-500 max-w-2xl mx-auto">Telusuri katalog kami, pilih buku favoritmu, dan isi form peminjaman langsung.</p>
        </div>

        @if(session('success')) <div class="bg-emerald-100 text-emerald-700 p-4 rounded-xl font-bold shadow-sm max-w-5xl mx-auto"><i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}</div> @endif
        @if(session('error')) <div class="bg-red-100 text-red-700 p-4 rounded-xl font-bold shadow-sm max-w-5xl mx-auto"><i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ session('error') }}</div> @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-5xl mx-auto" id="katalog">
            <!-- Form Peminjaman -->
            <div class="lg:col-span-5 bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-xl mb-6 text-slate-800">Form Peminjaman</h3>
                <form action="{{ route('borrowings.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-4 text-slate-400"></i>
                        <input type="text" name="borrower_name" required placeholder="Nama Lengkap Anda" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="relative">
                            <i class="fa-solid fa-users absolute left-4 top-4 text-slate-400"></i>
                            <input type="text" name="kelas" required placeholder="Kelas (Ex: XII)" class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:outline-none">
                        </div>
                        <div class="relative">
                            <select name="jurusan" required class="w-full pl-4 pr-4 py-3 rounded-xl border border-slate-200 bg-white focus:border-blue-500 focus:outline-none text-slate-600">
                                <option value="">-- Jurusan --</option>
                                <option value="Broadcasting">Broadcasting</option>
                                <option value="PPLG">PPLG</option>
                                <option value="TPFL">TPFL</option>
                                <option value="Otomotif">Otomotif</option>
                                <option value="Animasi">Animasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="relative">
                        <i class="fa-solid fa-book absolute left-4 top-4 text-slate-400"></i>
                        <select name="book_id" required class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-200 bg-white focus:border-blue-500 focus:outline-none">
                            <option value="">-- Pilih Buku --</option>
                            @foreach($books as $book) @if($book->stock > 0) <option value="{{ $book->id }}">{{ $book->title }}</option> @endif @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1 ml-1">Tgl Pinjam</label>
                            <input type="date" name="borrow_date" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:outline-none text-slate-600">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 mb-1 ml-1">Tgl Kembali</label>
                            <input type="date" name="return_date" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:outline-none text-slate-600">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl transition-all shadow-md"><i class="fa-solid fa-paper-plane mr-2"></i>Pinjam Sekarang</button>
                </form>
            </div>

            <!-- Katalog Buku (Dengan Kotak Ikon Buku Biru) -->
            <div class="lg:col-span-7 bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200">
                <h3 class="font-bold text-xl mb-6 text-slate-800">Katalog Buku</h3>
                <div class="space-y-3 max-h-[420px] overflow-y-auto pr-2">
                    @foreach($books as $book)
                    <a href="/buku/{{ $book->id }}" class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex justify-between items-center group hover:border-blue-400 hover:bg-blue-50/50 transition-all cursor-pointer block">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-14 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors shrink-0 shadow-sm">
                                <i class="fa-solid fa-book-bookmark text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-700 text-sm md:text-base group-hover:text-blue-700 transition-colors">{{ $book->title }}</h4>
                                <p class="text-xs text-slate-500">{{ $book->author }}</p>
                            </div>
                        </div>
                        <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-xs font-bold shrink-0">Stok: {{ $book->stock }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="peminjaman" class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200 max-w-5xl mx-auto">
            <h3 class="font-bold text-xl mb-6 text-slate-800"><i class="fa-solid fa-list-check mr-2 text-blue-500"></i>Buku yang Sedang Dipinjam</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-slate-500 border-b border-slate-200 bg-slate-50">
                            <th class="pb-3 pt-3 pl-4 font-semibold rounded-tl-xl">Peminjam</th>
                            <th class="pb-3 pt-3 font-semibold">Buku</th>
                            <th class="pb-3 pt-3 font-semibold text-blue-500">Pinjam</th>
                            <th class="pb-3 pt-3 font-semibold text-orange-500">Kembali</th>
                            <th class="pb-3 pt-3 pr-4 font-semibold text-right rounded-tr-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($borrowings as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 pl-4 font-bold text-slate-700">
                                {{ $item->borrower_name }}
                                @if($item->status == 'Menunggu Konfirmasi')
                                <span class="block mt-1 text-[10px] bg-amber-100 text-amber-600 px-2 py-0.5 rounded w-max">Menunggu ACC</span>
                                @endif
                            </td>
                            <td class="py-4 font-medium text-slate-600">{{ $item->book->title }}</td>
                            <td class="py-4 text-slate-500">{{ \Carbon\Carbon::parse($item->borrow_date)->format('d/m/Y') }}</td>
                            <td class="py-4 text-slate-500">{{ \Carbon\Carbon::parse($item->return_date)->format('d/m/Y') }}</td>
                            <td class="py-4 pr-4 text-right">
                                @if($item->status == 'Dipinjam')
                                    <form action="/ajukan-kembali/{{ $item->id }}" method="POST">
                                        @csrf 
                                        <button class="bg-blue-100 text-blue-600 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg text-xs font-bold transition-all shadow-sm">
                                            Ajukan Kembali
                                        </button>
                                    </form>
                                @else
                                    <span class="text-amber-500 text-xs font-bold italic">Diproses...</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>