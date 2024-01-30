<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Municipio;
use App\Property;


class TestController extends Controller
{

    public function getTest(){
        $actions = DB::select('select * from user_actions where id = ?', [376]);
        return $actions;
    }
    
    public function getSetSinLocality(){
        $municipios = Municipio::all();
        foreach($municipios as $mun){
            DB::insert('INSERT INTO localities(name, slugged, municipio_id) VALUES ("sin localidad", ?, ?)',["sin-localidad-".$mun->slugged,$mun->id]);
        }
        DB::update('UPDATE properties SET locality_id = (SELECT id FROM localities WHERE municipio_id = properties.municipio_id and localities.slugged like "sin-localidad%") WHERE locality_id is null');
        return 'Ya lo hice';
    }
    
    public function getArreglaLaMierda(){
        $all = Property::all();
        foreach($all as $p){
            $images = $p->images;
            echo("Procesando ".$images->count()." de la propiedad ".$p->id."<br/>");
            foreach($images as $img){
                if(!file_exists(base_path('/public/images/properties/'.$p->id.'/'.$img->localization))){
                    echo($img->localization.'<br/>');
                    echo("Ahora voyy a borrar pk me da la gana");
                    $img->delete();
                }
                if(!file_exists(base_path('/public/images/properties/'.$p->id.'/70/'.$img->localization))){
                    echo($img->localization.' falta en 70<br/>');
                }
                if(!file_exists(base_path('/public/images/properties/'.$p->id.'/50/'.$img->localization))){
                    echo($img->localization.' falta en 50<br/>');
                }
                if(!file_exists(base_path('/public/images/properties/'.$p->id.'/30/'.$img->localization))){
                   echo($img->localization.' falta en 30<br/>');
                }
                 
            }
        }
    }
}