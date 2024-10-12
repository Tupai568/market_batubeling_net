<?php

namespace App\Http\Controllers\reseller;

use App\Models\User;
use App\Models\DataUser;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificationController;

class DataResellerController extends Controller
{

    //tampilan setting
    public function setting()
    {
        $user = Auth::user();
        $dataUser = DataUser::where('user_id', $user->id)->first();

        return view('vendor.setting', [
            "Title" => "Setting",
            "Data" => $dataUser,
            "Notifications" => NotificationController::notifReseller(),
        ]);
    }

    //upload data
    public function uploadData(Request $request)
    {
        $user = User::find(Auth::user()->id); // Pastikan Anda mengimpor model User


        if ($this->isDataUserExists($user->id)) {
            return back()->with('error', 'Data Sudah Terisi');
        }

        // Validasi data dan proses penyimpanan
        $validatedData = $this->validateUploadData($request);
        // Ubah nomor WhatsApp jika angka pertama adalah 0
        $validatedData['whatsapp'] = $this->formatWhatsappNumber($validatedData['whatsapp']);
        $validatedData['image'] = $this->handleImageUpload($request->file('image'), 'img/ktp');

        DataUser::create($validatedData);
        if ($user->profie == null) {
            $user->profile = Str::uuid();
            $user->save();
        }
        return back()->with('success', 'Success Upload Data!');
    }



    // start function pendukung
    private function isDataUserExists($userId)
    {
        return DataUser::where('user_id', $userId)->exists();
    }


    private function validateUploadData($request)
    {
        return $request->validate([
            'user_id' => 'required|exists:users,id',
            'nik' => 'required|digits:16|unique:data_users,nik',
            'image' => 'required|image|mimes:jpg,jpeg,png|file|max:1024',
            'whatsapp' => 'required',
            'alamat' => 'required',
        ], [
            'user_id.required' => 'User ID harus diisi.',
            'user_id.exists' => 'User ID tidak ditemukan.',
            'nik.digits' => 'Nik harus 16 digits',
            'image.required' => 'Gambar harus diunggah.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.max' => 'Ukuran gambar maksimum adalah 1 MB.',
            'whatsapp.required' => 'Whatsapp harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
        ]);
    }


    private function handleImageUpload($file, $destination)
    {
        $destinationPath = public_path($destination);
        $fileName = 'ktp' . Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);

        return $fileName;
    }


    private function formatWhatsappNumber($number)
    {
        // Jika angka pertama adalah '0', ubah menjadi '62'
        if (substr($number, 0, 1) === '0') {
            return '62' . substr($number, 1);
        }
        return $number;
    }
    // end function pendukung

}
