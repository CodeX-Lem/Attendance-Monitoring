<?php

namespace App\Http\Controllers;

use App\Models\StudentModel;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function download($id)
    {
        $student = StudentModel::findOrFail($id);

        if (!$student->accepted) {
            Alert::error('Error', "Student has not yet accepted");
            return redirect()->back();
        }

        $studentQrCode = $student->qr_code;
        $studentName = $student->fullname;
        $qrCode = QrCode::size(300)->generate($studentQrCode);

        $headers = [
            'Content-Type' => 'image/svg',
            'Content-Disposition' => 'attachment; filename="' . $studentName . '.svg"',
        ];

        return Response::make($qrCode, 200, $headers);
    }
}
