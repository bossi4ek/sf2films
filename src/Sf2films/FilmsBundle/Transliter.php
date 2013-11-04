<?php

namespace Sf2films\FilmsBundle;


class Transliter {

    public function getTranslit($value) {
        $rus_ukr = array(
            "ый","ё","й","ю","ь","ч","щ","ц","у","к","е","н","г","ш","з","х","ъ","ф","ы","і","в","а","п","р","о","л",
            "д","ж","э","ґ","я","с","м","и","т","б","Ё","Й","Ю","Ч","Ь","Щ","Ц","У","К","Е","Н","Г","Ш","З","Х","Ъ",
            "Ф","Ы","І","В","А","П","Р","О","Л","Д","Ж","Э","Ґ","Я","С","М","И","Т","Б"
        );
        $eng = array(
            "iy","yo","y","yu","","ch","sch","ts","u","k","e","n","g","sh","z","h","","f","y","i","v","a","p","r","o","l",
            "d","zh","e","g","ya","s","m","i","t","b","Yo","Y","Yu","Ch","","Sch","Ts","U","K","E","N","G","Sh","Z","H","",
            "F","Y","I","V","A","P","R","O","L","D","Zh","E","G","Ya","S","M","I","T","B"
        );
        $value = str_replace($rus_ukr, $eng,  $value);
        $value = strtolower($value);

        return !empty($value) ?  $value : false;
    }

}