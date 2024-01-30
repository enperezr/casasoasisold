<?php

namespace app\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class DownloadsController extends Controller
{

    public function getIndex(){
        return view('downloads.index');
    }

    public function getUpdateFile(Request $request){
        $updater = new UpdateController;
        $content = $updater->getUpdateApp($request);
        return response($content)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Accept-Ranges', 'bytes')
            ->header('Content-Disposition', 'attachment; filename="update.file"')
            ->header('Cache-Control', 'public');
    }

    public function getImageFile(Request $request){
        $path = $request->input('path');
        if(str_contains($path, '.'))
            abort(403);
        $path = str_replace('-','/',$path);
        $image = public_path('images/properties/'.$path);
        if (file_exists($image)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($image));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($image));
            ob_clean();
            flush();
            readfile($image);
            exit;
        }
        else{
            abort(404);
        }

    }

}