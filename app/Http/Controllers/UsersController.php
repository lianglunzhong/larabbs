<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Topic;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;
use DNS1D;
use DNS2D;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'downloadQrcode', 'barcode']]);
    }

    public function show(User $user)
    {
        $qrcode = $user->qrcode();

        $topics = $user->topics()->recent()->paginate(5);
        return view('users.show', compact('user', 'topics', 'qrcode'));
    }

    public function downloadQrcode(User $user)
    {
        return response()->stream(function () use ($user) {
            echo $user->qrcode();
        }, 200, [
            'Content-type' => 'image/png',
            'Content-Disposition' => "attachment; filename=user-{$user->id}-qrcode.png"
        ]);
    }

    public function edit(User $user)
    {
        try {
            $this->authorize('update', $user);
        } catch (\Exception $e) {
            return abort(403, '对不起，你无权访问此页面！');
        }

        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        try {
            $this->authorize('update', $user);
        } catch (\Exception $e) {
            return abort(403, '对不起，你无权访问此页面！');
        }

        $data = $request->all();

        if ($request->avatar) {
            $result = $uploader->save($request->avatar, 'avatars', $user->id, 362);
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);

        return redirect()->route('users.show', $user)->with('success', '个人资料更新成功！');
    }

    public function barcode(User $user)
    {
        $typesOf1d = [
            'C39', 'C39+', 'C39E', 'C39E+', 'C93', 'S25',
            'S25+', 'I25', 'I25+', 'C128', 'C128A', 'C128B',
            'EAN2', 'EAN5', 'EAN8','EAN13', 'UPCA',
            'UPCE', 'MSI', 'MSI+', 'POSTNET', 'PLANET','RMS4CC',
            'KIX', 'CODABAR', 'CODE11', 'PHARMA', 'PHARMA2T'
        ];

        $barcodeOf1d = [];
        foreach ($typesOf1d as $type) {
            $barcodeOf1d[$type] = DNS1D::getBarcodePNG((string) $user->id, $type);
        }

        $typesOf2d = [
            'QRCODE', 'QRCODE,L', 'QRCODE,M', 'QRCODE,Q', 'QRCODE,H',
            'DATAMATRIX', 'PDF417', 'PDF417,a,e',
        ];

        $barcodeOf2d = [];
        foreach ($typesOf2d as $type) {
            $barcodeOf2d[$type] = DNS2D::getBarcodePNG((string) $user->id, $type);
        }

        return view('users.barcode', compact('user', 'barcodeOf1d', 'barcodeOf2d'));
    }
}
