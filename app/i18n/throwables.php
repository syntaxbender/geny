<?php
require_once(I18N_DIR.'/i18n.php');
class i18nThrowables extends i18n{
    public static function ThrowableMessage($context,$type){
        return "err";
        //self::$locale;
    }
}