<?php

namespace App\Http\Controllers;

use App\TelegramLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TelegramController extends Controller{

    const BOT_TOKEN = '998086719:AAFzCc_kGy5MsXzIaExnuzlpVeef9_yKZIc';
    const API_URL = 'https://api.telegram.org/bot'.TelegramController::BOT_TOKEN.'/';


    public function getIndex(Request $request){
        echo "It's alive";
    }

    public function postIndex(Request $request){
        $update = $request->json()->all();
        $idupdate = $update['update_id'];
        $log = TelegramLog::find($idupdate);
        if($log)
          return '';
        $log = new TelegramLog;
        $log->id = $idupdate;
        $log->content = $request->getContent();
        $params = false;
        if(array_has($update, 'message')){
          $params = $this->processMessage($update['message']);
        }
        else if(array_has($update, 'edited_message')){
          $params = $this->processMessage($update['edited_message']);
        }
        else if(array_has($update, 'channel_post')){
          $params = $this->processMessage($update['channel_post']);
        }
        else{
          $log->response = '';
          $log->save();
          return '';
        }
        if($params){
          $log->response = json_encode($params);
          $log->save();
          return response()->json($params);
        }
    }

    function processMessage($message) {
        // process incoming message
        $message_id = $message['message_id'];
        $chat_id = $message['chat']['id'];
        if (isset($message['text'])) {
          // incoming text message
            $text = $message['text'];
            $text = str_replace(['/', '@HabanaOasisMasterBot', 'ask', 'find', 'reserve'], '', $text);
            $result = DB::select(DB::raw("SELECT * FROM telegram_q WHERE MATCH(question) AGAINST('$text' IN NATURAL LANGUAGE MODE)"));
            if(!$result)
                $text = $text.'? No conozco la respuesta a esa pregunta, aun estoy en desarrollo';
            else
                $text = $result['0']->answer;
            return array('method'=>'sendMessage','chat_id' => $chat_id, "reply_to_message_id" => $message_id, "text" => $text);
          }
        return '';
    }

    function exec_curl_request($handle) {
        $response = curl_exec($handle);
      
        if ($response === false) {
          $errno = curl_errno($handle);
          $error = curl_error($handle);
          error_log("Curl returned error $errno: $error\n");
          curl_close($handle);
          return false;
        }
      
        $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
        curl_close($handle);
      
        if ($http_code >= 500) {
          // do not wat to DDOS server if something goes wrong
          sleep(10);
          return false;
        } else if ($http_code != 200) {
          $response = json_decode($response, true);
          error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
          if ($http_code == 401) {
            throw new Exception('Invalid access token provided');
          }
          return false;
        } else {
          $response = json_decode($response, true);
          if (isset($response['description'])) {
            error_log("Request was successful: {$response['description']}\n");
          }
          $response = $response['result'];
        }
      
        return $response;
    }

    function apiRequestJson($method, $parameters) {
        if (!is_string($method)) {
          error_log("Method name must be a string\n");
          return false;
        }
      
        if (!$parameters) {
          $parameters = array();
        } else if (!is_array($parameters)) {
          error_log("Parameters must be an array\n");
          return false;
        }
      
        $parameters["method"] = $method;
      
        $handle = curl_init(TelegramController::API_URL);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 60);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
      
        return $this->exec_curl_request($handle);
    }

    function apiRequestWebhook($method, $parameters) {
        if (!is_string($method)) {
          error_log("Method name must be a string\n");
          return false;
        }
      
        if (!$parameters) {
          $parameters = array();
        } else if (!is_array($parameters)) {
          error_log("Parameters must be an array\n");
          return false;
        }
      
        $parameters["method"] = $method;
      
        header("Content-Type: application/json");
        echo json_encode($parameters);
        return true;
      }
}
