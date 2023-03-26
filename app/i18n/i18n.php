<?php
class i18n{
    private static $predefinedLocales = [
        'tr-tr'=>'tr-tr',
        'en-us'=>'en-us'
    ];
    protected static $locale=null;
    public static function setLocale($locale){
        if(array_key_exists($locale,self::$predefinedLocales)){
            self::$locale = $locale;
        }else{
            //throw new Error("");
        }
    } 
}
?>