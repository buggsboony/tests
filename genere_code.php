<?php

  
    //genererCode("hydrobase","PT","N") 
    //genererCode("rSOBERT mouillage","PS") 
    //genererCode("marin","PS")
    //genererCode("Californie","A")
   // genererCode("bellefontaine","PS") 
  function genererCode($designation, $code_zone,$local="")
    {
        if(count($code_zone)==1) $output=$code_zone[0]; // P=> P (Port)
        else $output=$code_zone[1]; //PS=> S (secondaire)
        
            $mots = explode(" ",trim($designation));
            if(count($mots)===1 )
            {
                $output.=substr($designation, 0,3);
            }//endif un seul mot
            else foreach($mots as $mot)
            {
                $output.=$mot[0]; //la premiere de chaque
            }//next mot
        $output.=$local[0];
        
        return strtoupper( $output );
    }
 
  
   

//Premiere  lettre de chaque mots, pour un total de 3 lettres
function generer_code($nom, $len=4)
{
    $voyelles = ['a','à','ä','â','e','é','è','ê','ë','i','ï','o','u','ù','y'];    

    $str=strtolower($nom);
    
    //Conserver la premiere voyelle
    //parcourir et repérer les voyelles
    $chars = str_split($str);
    $n=0;$output =""; $premVoyelle=false; $first=true;
    foreach($chars as $c)
    {
        //récupérer le premier caractere
        if($first){ $output.=$c;} $first=false;
       if( ($premVoyelle) && strlen( $output) === 2 )
        {
            $output.=$c; //prendre le char apres la premiere voyelle
            die($output);
        }
     
    
    
        $index = array_search($c,$voyelles);
        if( $index===false)
        {}
        else
        {
        $n++;
            echo "voyelle trouvée: $c\n";  
            if($n==1)//premiere voyelle:
            {
                $output.=$c;
                $premVoyelle=true;
                die( $output);
            }
        }        
    }//next char
    //Conserver les consonnes consécutives
    
    return $output;
}//generer_code




var_dump(

generer_code("Hdrobase")
);

?>
