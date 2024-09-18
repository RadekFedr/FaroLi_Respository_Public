<?php
//Creates object from input fields of components/input_form.php for recording into DB using functions/write_webobject.php
class box_webobject {
    public $url_web_w;
    public $favicon_url_w;
    public $title_w;
    public $descript_w;
    public $keywords_w;
    public $insert_date_w;
    public $checkbox_w;
    public function __construct($url_web_w, $favicon_url_w, $title_w, $descript_w, $keywords_w, $insert_date_w, $checkbox_w){
      $this->url_web_w = (string) $url_web_w;
      $this->favicon_url_w = (string) $favicon_url_w;
      $this->title_w = (string) $title_w;
      $this->descript_w = (string) $descript_w;
      $this->keywords_w = (string) $keywords_w;
      $this->insert_date_w = (string) $insert_date_w;
      $this->checkbox_w = $checkbox_w;
    }
}
?>