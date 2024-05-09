<?php

include_once("abstract.databoundobject.php");
include_once("class.pdofactory.php");

class filtrarinformacion extends DataBoundObject {

    protected $ID;
    protected $url;
    protected $author_name;
    protected $provider_name;
    protected $photo;

    protected function DefineTableName() {
        return("datosTwitter");
    }

    protected function DefineRelationMap() {
        return(array(
            "id" => "ID",
            "url" => "Url",
            "author_name" => "AuthorName",
            "provider_name" => "ProviderName",
            "photo" => "Photo",
        ));
    }
}

?>
