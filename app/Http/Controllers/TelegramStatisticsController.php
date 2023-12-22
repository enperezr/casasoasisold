<?php

namespace App\Http\Controllers;

use App\TelegramLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TelegramStatisticsController extends Controller{

    const BOT_TOKEN = '834905284:AAFSZWHlX0udZjOz79-jGHpJEnKQWr2aeuo';
    const API_URL = 'https://api.telegram.org/bot'.TelegramController::BOT_TOKEN.'/';


    public function getIndex(Request $request){
        echo "It's alive";
    }

    public function postIndex(Request $request){
        $update = $request->json()->all();
        //dont proccess twice updates!
        $idupdate = $update['update_id'];
        $log = TelegramLog::find($idupdate);
        if($log)
          return '';
        $log = new TelegramLog;
        $log->id = $idupdate;
        $log->content = $request->getContent();
        
        //check only Quiz Bot forwarded messages
        $message = false;
        if(array_has($update, 'message')){
          $message = $update['message'];
          $user = $update['message']['from'];
          if(array_has($message, 'forward_from')){
            $forwarder = $message['forward_from'];
              if($forwarder['is_bot'] && $forwarder['username']=='QuizBot'){
                $response = $this->processMessageAsIndian($message);
                $log->response = $response;
                $log->save();
                return array('method'=>'sendMessage','chat_id' => $message['chat']['id'], "reply_to_message_id" => $message['message_id'], "text" => $response);
              }
          }
          else{
            //TODO should be a command
          }
        }
        return '';
    }

    function processMessage($message) {
        //check if forward date is registered
        $timestamp = $message['forward_date'];
        $result = DB::select(DB::raw("SELECT * FROM telegram_s WHERE date >= ".$timestamp));
        if($result){
          return 'Ese reporte es viejo!!';
        }
        else{
          //update database reports
          $text = mb_convert_encoding($message['text'], 'UTF-16LE');
          $id_s = DB::table('telegram_s')->insertGetId(['date'=>$timestamp, 'text'=>$text]);
          //parse text and update points
          $entities = $message['entities'];
          $current = false;
          foreach($entities as $entity){
            if($entity['type']== 'mention'){
              $current = mb_substr($text, $entity['offset']-4, $entity['length'], 'UTF-16LE');
            }
            else if($entity['type'] == 'bold' && $current){
              $points = mb_substr($text, $entity['offset']-4, $entity['length'], 'UTF-16LE');
              if(!DB::update('update telegram_points set points = points + ? where owner = ?', [intval($points), $current])){
                DB::table('telegram_points')->insert(['owner'=>$current, 'points'=>intval($points)]);
              }
              $current = false;
            }
          }
        }
        return 'OK';
    }

    function processMessageAsIndian($message){
      //check if forward date is registered
      $timestamp = $message['forward_date'];
      $result = DB::select(DB::raw("SELECT * FROM telegram_s WHERE date >= ".$timestamp));
      if($result){
        return 'Ese reporte es viejo!!';
      }
      else{
        $words = array_map('trim',explode(" ",$message['text']));
        echo(count($words));
        $points = [];
        $state = 0;
        $pointer = false;
        foreach($words as $word){
          if($words[0] == '@'){
            $pointer = $word;
            $state = 1;
          }
          else if($word == '–' && 'state' == 1){
            $state = 2;
          }
          else if(is_numeric($word) && $state == 2){
            $points[$pointer] = intval($word);
            $state = 0;
            $pointer = false;
          }
        }
        foreach($points as $mention=>$value){
          if(!DB::update('update telegram_points set points = points + ? where owner = ?', [$value, $mention])){
            DB::table('telegram_points')->insert(['owner'=>$mention, 'points'=>$value]);
          }
        }
        return 'OK';
      }
      
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

    
    //HELPERS
    function mbStringToArray($string, $encoding = 'UTF-8')
    {
        $array = [];
        $strlen = mb_strlen($string, $encoding);
        while ($strlen) {
            $array[] = mb_substr($string, 0, 1, $encoding);
            $string = mb_substr($string, 1, $strlen, $encoding);
            $strlen = mb_strlen($string, $encoding);
        }
        return $array;
    }





}
