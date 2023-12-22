<?php

/**
 * Created by PhpStorm.
 * User: Alejandro
 * Date: 29/10/2015
 * Time: 14:30
 */

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;

class Helper
{
    /**
     * Resolve ids for queries IN and WHERE
     * @param $modelClass
     *          The model class of the $value
     * @param $column
     *          The column used for comparisons
     * @param $value
     *          The value cold be a an array of strings or integers,  an string, o an integer
     * @return mixed
     *          the ids for the query, can be an integer or a Collection object with just the ids or null
     */
    public static function resolveForQuery($modelClass, $column, $value)
    {
        if (!empty($value) && is_array($value) && !is_numeric($value[0]))
            return $modelClass::whereIn($column, $value)->get()->pluck('id');
        if (!empty($value) && !is_numeric($value) && is_string($value))
            return $modelClass::where($column, $value)->first()->id;
        if (!empty($value) && (is_numeric($value) || (is_array($value) && is_numeric($value[0]))))
            return $value;
        return null;
    }
    /**
     * Add a where clause to a command and return it, it can chose if use where in or where only
     * @param $command
     * @param $column
     * @param $comparator
     * @param $value
     * @return mixed
     */
    public static function addWhereToCommand($command, $column, $value, $comparator = '=')
    {
        if ($value) {
            if ((is_object($value) && get_class($value) == Collection::class) || is_array($value)) {
                $command->whereIn($column, $comparator, $value);
            } else {
                if ($value == 'zero')
                    $value = 0;
                $command->where($column, $comparator, $value);
            }
        }
        return $command;
    }
    public static function checkMail()
    {
    }
    private static function processData($data)
    {
    }
    /**
     * @param $string
     * @return array
     *
     * this ini string has to have n lines
     * every line different from empty has to be in the form "param=valor"
     * if param already exist in array result, then result is an array and new values will be added
     *
     * TODO implement support for multiline in string, Big problems with newlines in UTF-8
     */
    public static function parse_fake_ini_string($string)
    {
        $lines = explode('\n', $string);
        $errors = [];
        $return = [];
        foreach ($lines as $line) {
            $parts = explode('=', trim($line));
            if (count($parts) != 2) {
                if (count($parts) != 1 || $parts[0] != '') {
                    if (!isset($errors['parse_errors']))
                        $errors['parse_errors'] = [$line];
                    else
                        $errors['parse_errors'][] = $line;
                }
            } else {
                if (!isset($return[$parts[0]])) {
                    $return[$parts[0]] = trim($parts[1]);
                } else {
                    if (!is_array($return[$parts[0]])) {
                        $return[$parts[0]] = [$return[$parts[0]]];
                    }
                    $return[$parts[0]][] = trim($parts[1]);
                }
            }
        }
        return [$return, $errors];
    }
    public static function languages4Route()
    {
        return implode('|', Config::get('app.languages'));
    }
    public static function getPathFor($path)
    {
        return url((App::getLocale() == 'es' || !in_array(App::getLocale(), Config::get('app.languages')) ? 'es' : App::getLocale()) . '/' . $path);
    }

    public static function getPathForPlace($province, $municipio, $locality, $action, $typeProperty)
    {

        if ($locality) {
           return  \App\Helper::getPathFor($action . '/' . $typeProperty . '/' . $province->slugged . '/' . $municipio->slugged . '/' . $locality->slugged);
        } elseif ($municipio) {
            return  \App\Helper::getPathFor($action . '/' . $typeProperty . '/' . $province->slugged . '/' . $municipio->slugged);
        } else {
            return \App\Helper::getPathFor($action . '/' . $typeProperty . '/' . $province->slugged );
        }
    }


    public static function getGradeSuffix($grade)
    {
        switch ($grade) {
            case 1:
                return trans('messages.words.grade.suffix.1');
            case 2:
                return trans('messages.words.grade.suffix.2');
            default:
                return trans('messages.words.grade.suffix.all');
        }
    }
    public static function dateToDBFormat($date)
    {
        $format = Config::get('app.dateFormats')[App::getLocale()];
        $d = date_parse_from_format($format, $date);
        return $d['year'] . '-' . $d['month'] . '-' . $d['day'];
    }
    public static function getHeaderImages()
    {
    }
    public static function formatPrice($price)
    {
        $r = '';
        $price = strval($price);
        for ($j = 1, $i = strlen($price) - 1; $i >= 0; $i--, $j++) {
            $r = $price[$i] . $r;
            if ($j % 3 == 0 && $i != 0)
                $r = ',' . $r;
        }
        return $r;
    }
    /**
     * @param $obj
     * @param $data
     * @param $ignore
     * @param $translation
     * Tries to initialize the object $obj with info from the associative array $data,
     * Ignore $data keys included in $ignore array
     * use $translation array values as properties from $obj preferred to $data keys if availables.
     * Not set empty values on $obj
     * @return Object
     */
    public static function arrToObject($obj, $data, $ignore = [], $translation = [])
    {
        foreach ($data as $k => $v) {
            if (in_array($k, $ignore)) {
                continue;
            }
            if ($v != '') { // 0 is not an empty value
                if (array_has($translation, $k)) {
                    $obj->$translation[$k] = $v;
                } else {
                    $obj->$k = $v;
                }
            }
        }
        return $obj;
    }
    /**
     * @param $string
     * @param int $loops
     * @return string
     *
     * make substitutions, and interchanges character with a noise string to protect its original content by the algorithm
     */
    public static function ravelString($string, $loops = 1)
    {
        //1st: substitute characters
        $dictionary = [
            'A' => 't', 'B' => '.', 'C' => 'U', 'D' => 'l', 'E' => 'P', 'F' => 'k', 'G' => 'a', 'H' => 'D', 'I' => 'o', 'J' => 'r',
            'K' => '"', 'L' => '4', 'M' => 'g', 'N' => 's', 'O' => '2', 'P' => 'p', 'Q' => '9', 'R' => '8', 'S' => 'T', 'T' => 'y', 'U' => '[',
            'V' => '}', 'X' => ']', 'Y' => '7', 'Z' => '0', 'a' => 'E', 'b' => ';', 'c' => 'Z', 'd' => 'F', 'e' => '6', 'f' => 'X', 'g' => '1',
            'h' => 'R', 'i' => 'M', 'j' => 'I', 'k' => 'j', 'l' => "'", 'm' => '{', 'n' => 'x', 'o' => 'N', 'p' => 'Q', 'q' => 'B', 'r' => 'S',
            's' => 'L', 't' => 'q', 'u' => 'V', 'v' => 'c', 'x' => 'A', 'y' => 'H', 'z' => 'W', '"' => 'e', "'" => 'd', ':' => 'G', ',' => ':',
            ';' => '3', '.' => 'm', ' ' => 'z', '[' => 'u', ']' => 'h', '{' => 'O', '}' => 'J', '0' => 'K', '1' => 'n', '2' => 'v', '3' => 'C',
            '4' => ',', '5' => 'w', '6' => 'f', '7' => 'Y', '8' => 'b', '9' => 'i', 'w' => '5', 'W' => ' '
        ];
        $len = strlen($string);
        if ($len < 600) {
            $string .= str_random(600 - $len);
        }
        $string = strtr($string, $dictionary);
        $len = strlen($string);
        $total = intval($len / 2);
        //2nd: intersect last half with first
        $result = '';
        for ($i = 0; $i < $total; $i++) {
            $result .= $string[$i] . $string[$i + $total];
        }
        if ($len % 2)
            $result .= $string[$len - 1];
        $string = $result;
        //3rd: introduce noise
        $noise = str_random(40);
        $result = '';
        for ($i = 0, $j = 0; $i < $len; $i++) {
            $result .= $string[$i];
            if ($i % 6 == 0) {
                $result .= $noise[$j];
                if ($j == 39)
                    $j = -1;
                $j++;
            }
        }
        $string = $result;
        //4th: intersect 2nd third, 1st third, 3rd third
        $len = strlen($string);
        $total = intval($len / 3);
        $result = '';
        for ($i = 0; $i < $total; $i++) {
            $result .= $string[$i + $total] . $string[$i] . $string[$i + 2 * $total];
        }
        if ($len % 3 == 1)
            $result .= $string[$len - 1];
        if ($len % 3 == 2)
            $result .= $string[$len - 2] . $string[$len - 1];
        $string = $result;
        //encode noise string in result
        $string = substr($noise, 0, 10) . substr($string, 0, 165) . substr($noise, 10, 10)
            . substr($string, 165, 378) . substr($noise, 20, 10) . substr($string, 165 + 378) . substr($noise, 30);
        return $string;
    }
    /**
     * @param $email
     * get avatar url from gravatar hashing the email
     */
    public static function getGravatar($email)
    {
        $hash = md5(strtolower(trim($email)));
        echo 'http://www.gravatar.com/avatar/' . $hash;
    }
    public static function getLangUrl($lang)
    {
        $path = Request::path();
        // if(starts_with($path, Config::get('app.languages'))){
        $parts = explode('/', $path);
        $parts[0] = $lang;
        $path = implode('/', $parts);
        //}
        /*else{
            $parts = explode('/',$path);
            $parts = array_merge([$lang], $parts);
            $path = implode('/', $parts);
        }*/
        return url($path);
    }
    public static function getSpanishUrl()
    {
        $path = Request::path();
        if (starts_with($path, Config::get('app.languages'))) {
            $parts = explode('/', $path);
            $path = implode('/', array_slice($parts, 1));
        }
        return url($path);
    }
    public static function timeStamptToFormat($timestamp, $format)
    {
        return strftime($format, strtotime($timestamp));
    }
    public static function rrmdir($dir)
    {
        if (!$dir)
            return;
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file))
                rrmdir($file);
            else
                unlink($file);
        }
        rmdir($dir);
    }
    /**
     * @param $collection
     * @param $value
     * @return bool
     * returns true if $value is an element of collection
     */
    public static function contains($collection, $value)
    {
        foreach ($collection as $item) {
            if ($item == $value)
                return true;
        }
        return false;
    }
    /**
     * @param $path
     * @return string
     * Change \ by / for ms systems
     */
    public static function normalizePath($path)
    {
        return str_replace('\\', '/', $path);
    }
}
