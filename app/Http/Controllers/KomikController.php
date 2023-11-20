<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Komik;
use App\Models\Laptop;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class KomikController extends Controller
{
    public function add(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'genre' => 'required|string',
            'rating' => 'required|string',
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'pdf_path' => 'required|file|mimes:pdf|max:50048',
        ]);

        $lastkomik = (int) Komik::max('id');
        $newkomikId = $lastkomik + 1;

        if ($request->File('image_path')) {
            // dd($request->file('image_path'));
            $image = $request->file('image_path');
            $imageName = $newkomikId . '.' . $image->getClientOriginalExtension();
            $tujuan_upload = public_path('assets/images/sampul');
            $image->move($tujuan_upload, $imageName);

            $validatedData['image_path'] = "assets/images/sampul/".$imageName;
        }

        if ($request->File('pdf_path')) {
            $pdf = $request->file('pdf_path');
            $pdfName = $newkomikId . '.' . $pdf->getClientOriginalExtension();
            $tujuan_upload = public_path('assets/dataKomik');
            $pdf->move($tujuan_upload, $pdfName);

            $validatedData['pdf_path'] = "assets/dataKomik/".$pdfName;
        }

        komik::create($validatedData);

        return redirect()->route('admin.komik')->with('success', 'komik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return view('admin.editkomik', [
            'komiks' => Komik::all()->where('id', $id)->first(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'genre' => 'required|string',
            'rating' => 'required|string',
        ]);
        $pd = Komik::findOrFail($id);
        $pd->update([
            'nama' => $request->nama,
            'genre' => $request->genre,
            'rating' => $request->rating,
        ]);
        return redirect()->route('admin.komik')->with('success', 'komik berhasil diupdate.');
    }


    public function delete($id)
    {
        $komik = komik::findOrFail($id);

        $imagePath = $komik->image_path;
        $pdfPath = $komik->pdf_path;

        if (!empty($imagePath)) {
            $imagePath = public_path('assets/images/komik/') . $imagePath;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if (!empty($pdfPath)) {
            $pdfPath = public_path('assets/dataKomik/') . $pdfPath;
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }

        $komik->delete();

        return redirect()->route('admin.komik')->with('success', 'komik berhasil dihapus.');
    }

    public function deleteakun($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()->route('admin.akun')->with('success', 'Akun berhasil dihapus.');
    }

    public function searchkomik(Request $request){
        if ($request->has('searchkomik')) {
            $komik = komik::where('nama', 'LIKE', "%".$request->searchkomik."%")->get();
        } else {
            $komik = komik::all();
        }
        return view("admin.komik", ['komik'=> $komik]);
    }

    public function searchakun(Request $request){
        if ($request->has('searchakun')) {
            $user = user::where('username', 'LIKE', "%".$request->searchakun."%")->get();
        } else {
            $user = user::all();
        }
        return view("admin.akun", ['user'=> $user]);
    }
}
