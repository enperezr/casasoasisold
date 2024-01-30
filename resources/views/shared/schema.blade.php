<?php
$list = [];
foreach($property->images as $image){
    $list[] = asset('images/properties/'.$property->id.'/30/'.$image->localization);
}
$schema = [];
$schema['@context'] = "https://schema.org/";
$schema['@type'] = "Product";
$schema['name'] = $property->getLabelName();
$schema['image'] = $list;
$schema['description'] = $property->description;
$schema['sku'] = $property->id;
$schema['mpn'] = $property->id;
$schema['brand'] = ['@type'=>"Thing", "name"=>"Habana Oasis"];
$schema['review'] = ['@type'=>"Review", "ReviewRating"=>['@type'=>"Rating", "ratingValue"=>$property->getRating(),"bestRating"=>"5"], "author"=>["@type"=>"Person", "name"=>($action->contact ? $action->contact->names : $action->gestor_user->name)]];
$schema['aggregateRating'] = ['@type'=>"AggregateRating", "ratingValue"=>$property->getRating(), "reviewCount"=>"1"];
if($action->action->id == 1){
    $schema["offers"] = [
        "@type"=> "Offer",
        "availability"=>"InStock",
        "url"=> Request::url(),
        "priceCurrency"=> "CUC",
        "price"=> $action->price == null ? 0 : $action->price,
        "priceValidUntil"=>\Carbon\Carbon::createFromFormat(\Carbon\Carbon::DEFAULT_TO_STRING_FORMAT, $property->date)->addYear(1)->format('Y-m-d'),
        "itemCondition"=> "https://schema.org/UsedCondition"
    ];
}else{

$schema["offers"] = [
        "@type"=> "Offer",
        "availability"=>"InStock",
        "url"=> Request::url(),
        "priceCurrency"=> "CUC",
        "price"=> 0,
        "priceValidUntil"=>\Carbon\Carbon::createFromFormat(\Carbon\Carbon::DEFAULT_TO_STRING_FORMAT, $property->date)->addYear(1)->format('Y-m-d'),
        "itemCondition"=> "https://schema.org/UsedCondition"
    ];

}
?>
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES) !!}
</script>