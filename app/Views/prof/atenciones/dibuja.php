<?php

function dibuja() {
    echo('<div id="odontograma-container">');
    echo('<img src= "'. base_url() . 'img/odontograma.png" alt="Odontograma" width="600" height="276">');

    //diente-numero-letra     numero: 11/12/13/... (numero de diente) 
    //                        letra: es la cara--> T(todo el diente), S(sin diente), V (Vesibular), P(Palatina)   

 
        //sin diente
        echo ('<div class="diente odonto" id="diente-00-S" style="top: 145px; left: 20px; width: 25px; height: 20px;" ></div>');


        //18 a 11
        $inc = 0;
        for ($i = 18; $i >= 11; $i= $i-1) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-T" style="top: 5px; left: '. $inc+20 . 'px; width: 20px; height: 20px;" ></div>');
            $inc = $inc+ 35;
        }

        //21 a 28
        $inc = 0;
        for ($i = 21; $i <= 28; $i++) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-T" style="top: 5px; left: '. $inc+310 . 'px; width: 20px; height: 20px;" ></div>');
            $inc = $inc+ 35;
        }


        //48 a 41
        $inc = 0;
        for ($i = 48; $i >= 41; $i= $i-1) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-T" style="top: 113px; left: '. $inc+20 . 'px; width: 20px; height: 20px;" ></div>');
            $inc = $inc+ 35;
        }

        //21 a 28
        $inc = 0;
        for ($i = 31; $i <= 38; $i++) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-T" style="top: 113px; left: '. $inc+310 . 'px; width: 20px; height: 20px;" ></div>');
            $inc = $inc+ 35;
        }

        //55 a 51
        $inc = 0;
        for ($i = 55; $i >= 51; $i= $i-1) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-T" style="top: 143px; left: '. $inc+124 . 'px; width: 20px; height: 20px;" ></div>');
            $inc = $inc+ 35;
        }

        //61 a 65
        $inc = 0;
        for ($i = 61; $i <= 65; $i++) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-T" style="top: 143px; left: '. $inc+310 . 'px; width: 20px; height: 20px;" ></div>');
            $inc = $inc+ 35;
        }


        //85 a 81
        $inc = 0;
        for ($i = 85; $i >= 81; $i= $i-1) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-T" style="top: 251px; left: '. $inc+124 . 'px; width: 20px; height: 20px;" ></div>');
            $inc = $inc+ 35;
        }

        //71 a 75
        $inc = 0;
        for ($i = 71; $i <= 75; $i++) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-T" style="top: 251px; left: '. $inc+310 . 'px; width: 20px; height: 20px;" ></div>');
            $inc = $inc+ 35;
        }
       
    
    
        //dibuja cara superior e inferior dientes de arriba
        //Cara Superior Diente 18-11 cara V
        $inc = 0;
        for ($i = 18; $i >= 11; $i= $i-1) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-V" style="top: 25px; left: '. $inc+24 . 'px; width: 18px; height: 13px;" ></div>');
            $inc = $inc+ 34.5;
        }

        ////Cara Superior Diente 21 a 28 cara V
        $inc = 0;
        for ($i = 21; $i <= 28; $i++) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-V" style="top: 25px; left: '. $inc+314 . 'px; width: 18px; height: 13px;" ></div>');
            $inc = $inc+ 34.5;
        }

     //Inferior Diente 18-11 cara P
     $inc = 0;
     for ($i = 18; $i >= 11; $i= $i-1) {
         echo ('<div class="diente odonto" id="diente-' . $i . '-P" style="top: 52px; left: '. $inc+24 . 'px; width: 18px; height: 13px;" ></div>');
         $inc = $inc+ 34.5;
     }

     //Cara inferior Diente 21 a 28 cara P
     $inc = 0;
     for ($i = 21; $i <= 28; $i++) {
         echo ('<div class="diente odonto" id="diente-' . $i . '-P" style="top: 52px; left: '. $inc+314 . 'px; width: 18px; height: 13px;" ></div>');
         $inc = $inc+ 34.5;
     }

    
    //dibuja cara superior e inferior dientes de abajo
        //Cara Superior Diente 48-41 cara L
        $inc = 0;
        for ($i = 48; $i >= 41; $i= $i-1) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-L" style="top: 70px; left: '. $inc+24 . 'px; width: 18px; height: 13px;" ></div>');
            $inc = $inc+ 34.5;
        }

        ////Cara Superior Diente 31 a 38 cara L
        $inc = 0;
        for ($i = 31; $i <= 38; $i++) {
            echo ('<div class="diente odonto" id="diente-' . $i . '-L" style="top: 70px; left: '. $inc+314 . 'px; width: 18px; height: 13px;" ></div>');
            $inc = $inc+ 34.5;
        }

     //Inferior Diente 48-41 cara V
     $inc = 0;
     for ($i = 48; $i >= 41; $i= $i-1) {
         echo ('<div class="diente odonto" id="diente-' . $i . '-V" style="top: 97px; left: '. $inc+24 . 'px; width: 18px; height: 13px;" ></div>');
         $inc = $inc+ 34.5;
     }

     //Cara inferior Diente 31 a 38 cara V
     $inc = 0;
     for ($i = 31; $i <= 38; $i++) {
         echo ('<div class="diente odonto" id="diente-' . $i . '-V" style="top: 97px; left: '. $inc+314 . 'px; width: 18px; height: 13px;" ></div>');
         $inc = $inc+ 34.5;
     }

        //dibuja cara lateral(D y M) 
            //Diente 18-11 
            $inc = 0;
            for ($i = 18; $i >= 11; $i= $i-1) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-D" style="top: 35px; left: '. $inc+18 . 'px; width: 10px; height: 18px;" ></div>');
                echo ('<div class="diente odonto" id="diente-' . $i . '-M" style="top: 35px; left: '. $inc+40 . 'px; width: 10px; height: 18px;" ></div>');
                $inc = $inc+ 34.5;
            }

            $inc = 0;
            for ($i = 21; $i <= 28; $i++) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-M" style="top: 35px; left: '. $inc+304 . 'px; width: 10px; height: 18px;" ></div>');
                echo ('<div class="diente odonto" id="diente-' . $i . '-D" style="top: 35px; left: '. $inc+328 . 'px; width: 10px; height: 18px;" ></div>');
                $inc = $inc+ 34.6;
            }
   
            //Diente 48-41 
            $inc = 0;
            for ($i = 48; $i >= 41; $i= $i-1) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-D" style="top: 80px; left: '. $inc+18 . 'px; width: 10px; height: 18px;" ></div>');
                echo ('<div class="diente odonto" id="diente-' . $i . '-M" style="top: 80px; left: '. $inc+40 . 'px; width: 10px; height: 18px;" ></div>');
                $inc = $inc+ 34.5;
            }

            $inc = 0;
            for ($i = 31; $i <= 38; $i++) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-M" style="top: 80px; left: '. $inc+304 . 'px; width: 10px; height: 18px;" ></div>');
                echo ('<div class="diente odonto" id="diente-' . $i . '-D" style="top: 80px; left: '. $inc+328 . 'px; width: 10px; height: 18px;" ></div>');
                $inc = $inc+ 34.6;
            }
    


        //dibuja cara central(O y I) 
            //Diente 18-28 
            $inc = 0;
            for ($i = 18; $i >= 14; $i= $i-1) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-O" style="top: 37px; left: '. $inc+25 . 'px; width: 16px; height: 16px;" ></div>');
                $inc = $inc+ 34.5;
            }
            
            for ($i = 13; $i >= 11; $i= $i-1) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-I" style="top: 37px; left: '. $inc+25 . 'px; width: 16px; height: 16px;" ></div>');
                $inc = $inc+ 34.5;
            }
            
            $inc = $inc + 15;
            for ($i = 21; $i <= 23; $i++) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-I" style="top: 37px; left: '. $inc+25 . 'px; width: 16px; height: 16px;" ></div>');
                $inc = $inc+ 34.5;
            }
            for ($i = 24; $i <= 28; $i++) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-O" style="top: 37px; left: '. $inc+25 . 'px; width: 16px; height: 16px;" ></div>');
                $inc = $inc+ 34.5;
            }

            //Diente 48-38 
            $inc = 0;
            for ($i = 48; $i >= 44; $i= $i-1) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-O" style="top: 82px; left: '. $inc+25 . 'px; width: 16px; height: 16px;" ></div>');
                $inc = $inc+ 34.5;
            }
            
            for ($i = 43; $i >= 41; $i= $i-1) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-I" style="top: 82px; left: '. $inc+25 . 'px; width: 16px; height: 16px;" ></div>');
                $inc = $inc+ 34.5;
            }
            
            $inc = $inc + 15;
            for ($i = 31; $i <= 33; $i++) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-I" style="top: 82px; left: '. $inc+25 . 'px; width: 16px; height: 16px;" ></div>');
                $inc = $inc+ 34.5;
            }
            for ($i = 34; $i <= 38; $i++) {
                echo ('<div class="diente odonto" id="diente-' . $i . '-O" style="top: 82px; left: '. $inc+25 . 'px; width: 16px; height: 16px;" ></div>');
                $inc = $inc+ 34.5;
            }

        echo('</div>');

    
    } //fin dibuja


?>