<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;

class BorrowingController extends Controller
{
    public function index() {
        $books = Book::all();
        $borrowings = Borrowing::with('book')->whereIn('status', ['Dipinjam', 'Menunggu Konfirmasi'])->latest()->get();
        return view('welcome', compact('books', 'borrowings'));
    }
    
    public function showBuku($id) {
        $book = Book::findOrFail($id);
        return view('buku', compact('book'));
    }

    public function store(Request $request) {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'borrower_name' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $book = Book::findOrFail($request->book_id);
        if ($book->stock <= 0) return back()->with('error', 'Stok buku habis!');

        $book->decrement('stock');
        $identitas_peminjam = $request->borrower_name . ' (' . $request->kelas . ' - ' . $request->jurusan . ')';

        Borrowing::create([
            'book_id' => $request->book_id,
            'borrower_name' => $identitas_peminjam,
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'status' => 'Dipinjam',
        ]);

        return back()->with('success', 'Buku berhasil dipinjam!');
    }

    public function ajukanKembali($id) {
        $borrowing = Borrowing::findOrFail($id);
        if($borrowing->status == 'Dipinjam') {
            $borrowing->update(['status' => 'Menunggu Konfirmasi']);
        }
        return back()->with('success', 'Pengajuan berhasil! Menunggu Admin memproses pengembalian.');
    }

    public function kembalikan($id) {
        if(!session('is_admin')) return redirect('/login'); 
        
        $borrowing = Borrowing::findOrFail($id);
        if($borrowing->status == 'Dipinjam' || $borrowing->status == 'Menunggu Konfirmasi') {
            $borrowing->update(['status' => 'Dikembalikan']);
            $borrowing->book->increment('stock');
        }
        return back()->with('success', 'Buku berhasil dikonfirmasi dan stok telah dikembalikan!');
    }

    public function login() {
        if(session('is_admin')) return redirect('/admin');
        return view('login');
    }

    public function authenticate(Request $request) {
        if($request->username == 'admin' && $request->password == 'rahasia123') {
            session(['is_admin' => true]);
            return redirect('/admin')->with('success', 'Selamat datang, Admin!');
        }
        return back()->with('error', 'Username atau password salah!');
    }

    public function logout() {
        session()->forget('is_admin');
        return redirect('/login')->with('success', 'Berhasil logout!');
    }

    public function admin(Request $request) {
        if(!session('is_admin')) return redirect('/login')->with('error', 'Akses ditolak!');
        
        $books = Book::all();
        $query = Borrowing::with('book');
        
        if($request->has('search') && $request->search != '') {
            $query->where('borrower_name', 'like', '%' . $request->search . '%');
        }

        if($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('borrow_date', date('m', strtotime($request->bulan)))
                  ->whereYear('borrow_date', date('Y', strtotime($request->bulan)));
        }
        
        $borrowings = $query->latest()->paginate(10)->withQueryString();

        return view('admin', compact('books', 'borrowings'));
    }

    public function tambahBuku(Request $request) {
        if(!session('is_admin')) return redirect('/login');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'stock' => 'required|integer|min:1'
        ]);

        Book::create($request->only('title', 'author', 'stock'));

        return back()->with('success', 'Buku baru berhasil ditambahkan!');
    }

    public function hapusBuku($id) {
        if(!session('is_admin')) return redirect('/login');
        Book::findOrFail($id)->delete();
        return back()->with('success', 'Buku berhasil dihapus!');
    }

    public function hapusRiwayat($id) {
        if(!session('is_admin')) return redirect('/login');
        Borrowing::findOrFail($id)->delete();
        return back()->with('success', 'Riwayat dihapus!');
    }
}