<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;

class AdminQrCodeController extends Controller
{
    /**
     * Nén và chuyển đổi ảnh sang Base64
     */
    private function compressImageToBase64($file, $maxWidth = 800, $quality = 80)
    {
        if (!extension_loaded('gd')) {
            return 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $imageInfo = @getimagesize($file->getRealPath());
        if (!$imageInfo) {
            return 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $mime = $imageInfo['mime'];
        $width = $imageInfo[0];
        $height = $imageInfo[1];

        try {
            switch ($mime) {
                case 'image/jpeg': case 'image/jpg': $image = @imagecreatefromjpeg($file->getRealPath()); break;
                case 'image/png':  $image = @imagecreatefrompng($file->getRealPath()); break;
                case 'image/webp': $image = @imagecreatefromwebp($file->getRealPath()); break;
                default: $image = false;
            }

            if (!$image) {
                return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
            }

            if ($width > $maxWidth) {
                $newWidth = $maxWidth;
                $newHeight = floor($height * ($maxWidth / $width));
                $tmp = imagecreatetruecolor($newWidth, $newHeight);
                imagecopyresampled($tmp, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                $image = $tmp;
            }

            ob_start();
            imagejpeg($image, null, $quality);
            $binaryData = ob_get_clean();
            imagedestroy($image);

            return 'data:image/jpeg;base64,' . base64_encode($binaryData);
        } catch (\Throwable $e) {
            return 'data:' . $mime . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }
    }

    public function index()
    {
        $qrCodes = QrCode::latest()->paginate(10);
        return view('qr_codes.index', compact('qrCodes'));
    }

    public function create()
    {
        return view('qr_codes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_owner' => 'required|string|max:255',
            'images' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('images')) {
            $data['images'] = $this->compressImageToBase64($request->file('images'));
        }

        // Nếu kích hoạt mã này, hủy kích hoạt các mã khác
        if ($request->has('is_active') && $request->is_active) {
            QrCode::query()->update(['is_active' => false]);
        }

        QrCode::create($data);

        return redirect()->route('admin.qr_codes.index')->with('success', 'Tạo mã QR thành công!');
    }

    public function edit(QrCode $qrCode)
    {
        return view('qr_codes.edit', compact('qrCode'));
    }

    public function update(Request $request, QrCode $qrCode)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_owner' => 'required|string|max:255',
            'images' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->all();

        if ($request->hasFile('images')) {
            $data['images'] = $this->compressImageToBase64($request->file('images'));
        }

        if ($request->has('is_active') && $request->is_active) {
            QrCode::where('id', '!=', $qrCode->id)->update(['is_active' => false]);
        }

        $qrCode->update($data);

        return redirect()->route('admin.qr_codes.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy(QrCode $qrCode)
    {
        $qrCode->delete();
        return redirect()->route('admin.qr_codes.index')->with('success', 'Xóa thành công!');
    }
}