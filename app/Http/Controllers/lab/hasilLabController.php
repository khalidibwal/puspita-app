<?php

namespace App\Http\Controllers\lab;

use App\Models\lab\HasilLab;
use App\Models\Book_RM; // Model untuk tabel book_rm
use App\Models\lab\jenisPK; // Model untuk tabel jenis_penyakit
use App\Models\lab\HasilLabJenisPenyakit;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;

class hasilLabController extends Controller
{
    // Menampilkan daftar hasil lab
    public function index(Request $request)
{
    // Ambil query pencarian jika ada
    $search = $request->input('search');
    
    // Ambil data hasil lab dengan pencarian dan pagination
   // Eager load hasilLabJenisPenyakit and jenisPenyakit relationships
   $hasilLabs = HasilLab::with(['hasilLabJenisPenyakit.jenisPenyakit'])
   ->when($search, function ($query, $search) {
       return $query->where('idRekamMedis', 'like', "%{$search}%")
                    ->orWhereHas('hasilLabJenisPenyakit.jenisPenyakit', function ($q) use ($search) {
                        $q->where('jenisPK', 'like', "%{$search}%");
                    });
   })
   ->paginate(10);
    
    // Kirim data ke view
    return view('admin.Laboratorium.Hasil.index', compact('hasilLabs'));
}
public function show($id)
{
    // Retrieve the HasilLab and eager load related models
    $hasilLab = HasilLab::with(['hasilLabJenisPenyakit.jenisPenyakit'])
                        ->findOrFail($id);  // Make sure the ID exists
                        // Retrieve the sub_category (jenisPK) for the current result
    // Group jenisPenyakit by labCategory
    $groupedByCategory = $hasilLab->hasilLabJenisPenyakit->groupBy(function($hasilJenis) {
        return $hasilJenis->jenisPenyakit->labCategory->category_lab;
    });

    return view('admin.Laboratorium.hasil.show', compact('hasilLab','groupedByCategory'));
}

public function downloadPDF($id)
{
    $hasilLab = HasilLab::findOrFail($id);
    $groupedByCategory = HasilLabJenisPenyakit::groupByCategory($hasilLab); // Pastikan ini sesuai dengan query yang Anda gunakan
     // Convert the logo to a base64 string
     $path = public_path('img/logoMedika.png'); // Path to the image in the public directory
     $type = pathinfo($path, PATHINFO_EXTENSION); // Get the file extension (e.g., png)
     $data = file_get_contents($path); // Get the file content
     $base64Logo = 'data:image/' . $type . ';base64,' . base64_encode($data); // Convert to base64

    $pdf = PDF::loadView('pdf.detail_pdf', compact('hasilLab', 'groupedByCategory','base64Logo'));

    return $pdf->download('hasil_lab_' . $hasilLab->idRekamMedis . '.pdf');
}

    public function create()
{
    // Mendapatkan tahun dan tanggal sekarang
    $currentDate = Carbon::now();
    $year = $currentDate->format('Y');
    $date = $currentDate->format('md'); // Format tanggal (mmdd)
    
 

    // Mengambil data rekam medis (book_rm) dan jenis penyakit
    $bookRms = Book_RM::all();
    $jenisPenyakits = jenisPK::all();
    
    // Mengirim ID, rekam medis, dan jenis penyakit ke view
    return view('admin.Laboratorium.Hasil.create', compact('bookRms', 'jenisPenyakits'));
}

    

    // Menyimpan data hasil lab
    public function store(Request $request)
    {
        $request->validate([
            'idRekamMedis' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'usia' => 'required|string',
            'tglHasil' => 'required|date',
            'jenisPenyakitId' => 'required|array',
            'hasil' => 'required|array',
            'jenisPenyakitId.*' => 'exists:jenis_penyakit,id',
            'hasil.*' => 'string'
        ]);

        // Membuat entri hasil lab utama
        $hasilLab = HasilLab::create([
            'id' => $request->id,  // Asumsi ID di-generate sebelumnya
            'idRekamMedis' => $request->idRekamMedis,
            'penanggung_jawab' => $request->penanggung_jawab,
            'usia' => $request->usia,
            'tglHasil' => $request->tglHasil,
        ]);

        // Menyimpan relasi dengan jenis penyakit melalui model pivot
        foreach ($request->jenisPenyakitId as $key => $jenisPenyakitId) {
            // Menyimpan data ke tabel pivot dengan model pivot
            HasilLabJenisPenyakit::create([
                'hasil_lab_id' => $hasilLab->id,
                'jenis_penyakit_id' => $jenisPenyakitId,
                'hasil' => $request->hasil[$key] // Menyimpan hasil untuk setiap jenis penyakit
            ]);
        }

        return redirect()->route('hasil_lab.index')->with('success', 'Hasil Lab berhasil disimpan!');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'id' => 'required|string|max:20|unique:hasil_lab',
    //         'idRekamMedis' => 'required|string',
    //         'jenisPenyakitId' => 'required|array',
    //         'hasil' => 'required|array',
    //         'penanggung_jawab' => 'required|string',
    //         'usia' => 'required|string',
    //         'tglHasil' => 'required|date',
    //     ]);

    //     // Menyimpan data ke database
    //     HasilLab::create([
    //         'id' => $request->id,
    //         'idRekamMedis' => $request->idRekamMedis,
    //         'jenisPenyakitId' => $request->jenisPenyakitId,
    //         'hasil' => $request->hasil,
    //         'penanggung_jawab' => $request->penanggung_jawab,
    //         'usia' => $request->usia,
    //         'tglHasil' => $request->tglHasil,
    //     ]);

    //     // Redirect setelah berhasil
    //     return redirect()->route('hasil_lab.index')->with('success', 'Data hasil lab berhasil disimpan!');
    // }

    // Menampilkan form untuk mengedit data hasil lab
    public function edit($id)
    {
        $hasilLab = HasilLab::findOrFail($id); // Ambil data berdasarkan id
        $bookRms = Book_RM::all(); // Ambil data rekam medis
        $jenisPenyakits = jenisPK::all(); // Ambil data jenis penyakit
        return view('admin.Laboratorium.Hasil.edit', compact('hasilLab', 'bookRms', 'jenisPenyakits'));
    }

    // Mengupdate data hasil lab
    public function update(Request $request, $id)
    {
        $request->validate([
            'idRekamMedis' => 'required|string',
            'jenisPenyakitId' => 'required|integer',
            'hasil' => 'required|string',
            'penanggung_jawab' => 'required|string',
            'usia' => 'required|string',
            'tglHasil' => 'required|date',
        ]);

        $hasilLab = HasilLab::findOrFail($id); // Ambil data berdasarkan id
        $hasilLab->update([
            'idRekamMedis' => $request->idRekamMedis,
            'jenisPenyakitId' => $request->jenisPenyakitId,
            'hasil' => $request->hasil,
            'penanggung_jawab' => $request->penanggung_jawab,
            'usia' => $request->usia,
            'tglHasil' => $request->tglHasil,
        ]);

        // Redirect setelah berhasil update
        return redirect()->route('hasil_lab.index')->with('success', 'Data hasil lab berhasil diperbarui!');
    }

    // Menghapus data hasil lab
    public function destroy($id)
    {
        $hasilLab = HasilLab::findOrFail($id);
        $hasilLab->delete();

        // Redirect setelah berhasil dihapus
        return redirect()->route('hasil_lab.index')->with('success', 'Data hasil lab berhasil dihapus!');
    }
}
