<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Script Buat Export ke Excel -->
    <script>
        function exportExcel(tableID, filename = ''){
            var downloadLink;
            var dataType = 'application/vnd.ms-excel';
            var tableSelect = document.getElementById(tableID);
            var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
            filename = filename?filename+'.xls':'laporan_perpustakaan.xls';
            downloadLink = document.createElement("a");
            document.body.appendChild(downloadLink);
            
            if(navigator.msSaveOrOpenBlob){
                var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
                navigator.msSaveOrOpenBlob( blob, filename);
            } else {
                downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
                downloadLink.download = filename;
                downloadLink.click();
            }
        }
    </script>
    
    <style>
        /* Sembunyikan elemen pas di-print/PDF */
        @media print {
            .no-print { display: none !important; }
            body { background: white; color: black; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid black; padding: 8px; }
        }
    </style>
</head>
<body class="bg-slate-900 text-slate-200 p-4 md:p-8 min-h-screen font-[Inter]">
    <div class="max-w-7xl mx-auto space-y-6">
        
        <div class="flex justify-between items-center bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow no-print">
            <h1 class="text-2xl font-bold text-white"><i class="fa-solid fa-shield-halved text-blue-500 mr-2"></i>Admin Panel</h1>
            <div class="flex space-x-3">
                <a href="/" class="bg-slate-700 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-slate-600">Lihat Web</a>
                <a href="/logout" class="bg-red-500/15 text-red-400 border border-red-500/30 px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-500 hover:text-white">Logout</a>
            </div>
        </div>

        @if(session('success')) <div class="bg-emerald-500/20 text-emerald-400 border border-emerald-500/50 p-4 rounded-xl font-bold no-print"><i class="fa-solid fa-check mr-2"></i>{{ session('success') }}</div> @endif

        <!-- Form Tambah Buku -->
        <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow no-print">
            <h3 class="font-bold text-white mb-4"><i class="fa-solid fa-plus-circle mr-2 text-emerald-400"></i>Tambah Buku Baru</h3>
            <form action="/tambah-buku" method="POST" class="flex flex-wrap lg:flex-nowrap gap-4">
                @csrf
                <input type="text" name="title" required placeholder="Judul Buku..." class="w-full lg:w-2/5 px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-blue-500 focus:outline-none">
                <input type="text" name="author" required placeholder="Penulis..." class="w-full lg:w-2/5 px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-blue-500 focus:outline-none">
                <input type="number" name="stock" value="5" required placeholder="Stok" class="w-full lg:w-32 px-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-white focus:border-blue-500 focus:outline-none">
                <button type="submit" class="w-full lg:w-auto bg-blue-600 hover:bg-blue-500 text-white font-bold py-2.5 px-6 rounded-xl transition-colors">Simpan</button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Tabel Riwayat, Search, Filter & Export -->
            <div class="lg:col-span-8 bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow">
                
                <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 mb-6 no-print">
                    <h3 class="font-bold text-white"><i class="fa-solid fa-clock-rotate-left mr-2 text-blue-400"></i>Laporan Peminjaman</h3>
                    
                    <!-- Search & Filter Bulan -->
                    <form method="GET" action="/admin" class="flex flex-wrap gap-2 w-full xl:w-auto">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari peminjam..." class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500">
                        <input type="month" name="bulan" value="{{ request('bulan') }}" class="px-3 py-1.5 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold">Cari</button>
                        @if(request('bulan') || request('search'))
                            <a href="/admin" class="bg-slate-700 hover:bg-slate-600 text-slate-300 px-3 py-1.5 rounded-lg text-xs font-bold">Reset</a>
                        @endif
                    </form>

                    <!-- Tombol Export PDF & Excel -->
                    <div class="flex gap-2">
                        <button onclick="window.print()" class="bg-rose-600 hover:bg-rose-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold"><i class="fa-solid fa-file-pdf mr-1"></i> PDF</button>
                        <button onclick="exportExcel('tabel-laporan', 'Laporan_Bulan_{{ request('bulan') }}')" class="bg-emerald-600 hover:bg-emerald-500 text-white px-3 py-1.5 rounded-lg text-xs font-bold"><i class="fa-solid fa-file-excel mr-1"></i> Excel</button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="tabel-laporan" class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-slate-400 border-b border-slate-700">
                                <th class="pb-2 text-center w-10">No</th>
                                <th class="pb-2">Nama & Kelas</th>
                                <th class="pb-2 text-blue-400">Pinjam</th>
                                <th class="pb-2 text-orange-400">Kembali</th>
                                <th class="pb-2 text-red-400">Denda</th>
                                <th class="pb-2 text-right no-print">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700">
                            @foreach($borrowings as $index => $item)
                            @php
                                $denda = 0;
                                if(($item->status == 'Dipinjam' || $item->status == 'Menunggu Konfirmasi') && \Carbon\Carbon::parse($item->return_date)->isPast()) {
                                    $denda = \Carbon\Carbon::parse($item->return_date)->diffInDays(now()) * 1000;
                                }
                            @endphp
                            <tr>
                                <!-- Nomor urut -->
                                <td class="py-3 text-center text-slate-500 font-bold">{{ $borrowings->firstItem() + $index }}</td>
                                <td class="py-3 font-semibold text-emerald-300">
                                    {{ $item->borrower_name }}
                                    <div class="text-xs text-slate-500 mt-1">Buku: {{ $item->book->title }}</div>
                                </td>
                                <td class="py-3 text-blue-300">{{ \Carbon\Carbon::parse($item->borrow_date)->format('d M Y') }}</td>
                                <td class="py-3 text-orange-300">{{ \Carbon\Carbon::parse($item->return_date)->format('d M Y') }}</td>
                                <td class="py-3 text-red-400 font-mono font-bold">Rp {{ number_format($denda, 0, ',', '.') }}</td>
                                <td class="py-3 text-right flex justify-end gap-2 no-print">
                                    @if($item->status == 'Dipinjam' || $item->status == 'Menunggu Konfirmasi')
                                        <form action="/kembalikan/{{ $item->id }}" method="POST">
                                            @csrf 
                                            <button class="{{ $item->status == 'Menunggu Konfirmasi' ? 'bg-amber-500 hover:bg-amber-400' : 'bg-blue-600 hover:bg-blue-500' }} px-3 py-1.5 rounded-lg text-xs font-bold text-white transition-colors">
                                                @if($item->status == 'Menunggu Konfirmasi') ACC @else Kembali @endif
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-emerald-500 text-xs font-bold bg-emerald-500/10 px-3 py-1.5 rounded-lg">Selesai</span>
                                    @endif
                                    
                                    <form action="/hapus-riwayat/{{ $item->id }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Yakin hapus riwayat ini?')" class="bg-red-500/15 text-red-400 hover:bg-red-500 hover:text-white px-2.5 py-1.5 rounded-lg text-xs font-bold"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Navigasi Halama / Pagination -->
                <div class="mt-4 pt-4 border-t border-slate-700 no-print">
                    {{ $borrowings->links() }}
                </div>
            </div>

            <!-- Manage Katalog -->
            <div class="lg:col-span-4 bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow no-print">
                <h3 class="font-bold text-white mb-4"><i class="fa-solid fa-book mr-2 text-purple-400"></i>Manage Katalog</h3>
                <div class="space-y-2 max-h-96 overflow-y-auto pr-2">
                    @foreach($books as $book)
                    <div class="flex justify-between items-center bg-slate-900 p-3 rounded-lg border border-slate-700">
                        <div class="pr-2">
                            <h4 class="text-sm font-bold text-white line-clamp-1">{{ $book->title }}</h4>
                            <p class="text-xs text-slate-400">Penulis: {{ $book->author }} | Stok: {{ $book->stock }}</p>
                        </div>
                        <form action="/hapus-buku/{{ $book->id }}" method="POST">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin hapus buku ini?')" class="text-red-400 hover:text-red-300 text-sm font-bold p-2 transition-colors"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</body>
</html>