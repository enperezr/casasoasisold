<?php

namespace App;

use App\Property;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Feed\FeedItem;

class PropertyFb extends Property implements FeedItem
{
    protected $table = 'properties';

    public function getFeedItemTitle() : string
    {
        $title = 'Ojo: Para más información tocar o dar click sobre la foto

';
        $title.= $this->getLabelName($this->actions[0]);
        /*$title .= trans('messages.property.type.locality.feed', [
            'type'=>trans_choice('messages.db.property.'.$this->typeProperty->slugged, 1),
            'municipio'=>$this->municipio->name,
            'province'=>', '.$this->province->name
        ]);*/
        $title.='.

Información del Inmueble:

';
        
        //--------------- Datos de la casa --------------------------------------
        $title.=$this->rooms.' '.trans_choice('messages.words.room', $this->rooms);
        $title.=', '.$this->baths.' '.trans_choice('messages.words.bath', $this->baths).'. ';
        
        //--------------- contact ------------------------------------------------
        $contact = $this->getContact();
        $title.='
Nombre: '.$contact->names.'
Teléfono: '.$contact->phones;
        
        //--------------- Action -------------------------------------------------
        $title.='

';
        $actions = $this->getThisAction(Action::ACTION_ALL);
        for($i = 0; $i < count($actions); $i++){
            if($i > 0)
                $title.=' o ';
            if($actions[$i]->action_id == 1){
                $title.='Precio: '.($actions[$i]->price ? '$'.$actions[$i]->price : 'Precio Oculto');
            }
            if($actions[$i]->action_id == 2){
                $title.='Permuta: '.$actions[$i]->condition;
            }
        }
        //---------------- Advertisement -------------------------------------------
        $title.='

🌴¿Quieres vender tu casa más rápido, sin pagar comisión y sin intermediarios?🌴 😃Lo hacemos realidad😃, solo levanta el teléfono y llama 78685262 y 58421441. __ 👉 Deja tu # y te contactamos. 👈

.
.
.
.
.
.
.
habana #oasis #venta #compra #casas #apartamento #permuta #inmobiliaria #oferta #comisiones #intermediarios#intermediarios';
        
        return $title;
    }

    public function getFeedItemSummary() : string
    {
        $description = str_replace('<span style="mso-spacerun:yes">&nbsp; </span>', '', $this->description);
        $description = str_replace('<o:p>', '', $description);
        $description = str_replace('</o:p>', '', $description);
        return ($description ? $description : 'No description');
    }

}
