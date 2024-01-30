<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\TelegramLog;
use App\TelegramQuestion;

class TelegramAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('access:admin|moderador|agente|comercial');
    }
    
    public function getIndex()
    {
        $questions = TelegramQuestion::all();
        $logs = TelegramLog::orderBy('response', 'desc')->paginate(25);
        return view('admin.telegram', ['logs'=>$logs, 'questions'=>$questions]);
    }
}
