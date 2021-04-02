<?php
$lamaneurs_all = \App\Models\User::parFonction("lamaneur");
//dump($lamaneurs_all);



$componentId="sideSelectMarins";
$componentSize=4;
 
${$componentId."_values"} = old($componentId."_values");
if($prevision->lamaneurs)
{
    $field='lamaneurs'; $oldOrValue=old($field)??$prevision->{$field};
    $sideSelectMarins_values = $prevision->lamaneurs;
}

//dump( $prevision->lamaneurs );

?>
 


 <div id="<?php echo $componentId;?>_wrap" class="container_sideselects" style="width: 800px; display: inline-flex; filter:blur(1px);">

<select multiple id="<?php echo $componentId;?>_source" size="<?php echo $componentSize;?>" style="width:300px;" lists="<?php echo $componentId;?>_source=><?php echo $componentId;?>_dest"  ondblclick="sideSelectsSwap(this,true);">>
    @foreach( $lamaneurs_all as $lamaneur)                                    
                    <option value="{{ $lamaneur->code }}"> {{$lamaneur->toString() }}</option>
    @endforeach
</select>

<div class="sideselects_buttons" style=" margin: 0;  position: relative;  top: 50%; ">
    <button style="    font-size: 4em; width: 54px;" type="button" class="button btn-dark" for="<?php echo $componentId;?>" 
     lists="<?php echo $componentId;?>_source=><?php echo $componentId;?>_dest"  onclick="sideSelectsSwap(this);"> &raquo; </button>
    
    <button  style="    font-size: 4em; width: 54px;" type="button" class="button btn-dark" for="<?php echo $componentId;?>"
     lists="<?php echo $componentId;?>_dest=><?php echo $componentId;?>_source"  onclick="sideSelectsSwap(this);">&laquo;</button>
</div>


<select multiple id="<?php echo $componentId;?>_dest" size="<?php echo $componentSize;?>"  style="width: 300px; " lists="<?php echo $componentId;?>_dest=><?php echo $componentId;?>_source"  ondblclick="sideSelectsSwap(this,true);">
</select>


    <input type="hidden" lists="{{$componentId}}_source=>{{$componentId}}_dest"  id="{{$componentId}}_state" name="{{$componentId}}_state" value="{{old($componentId."_state")}}" />
    <input type="hidden" id="{{$componentId}}_values" name="{{$componentId}}_values" value="{{$oldOrValue}}">




<script type="application/javascript" defer="defer">
var componentId ="<?php echo $componentId;?>";
var server_values='<?php echo $oldOrValue;?>';
//------------------------------------- sideSelect script ------------------------------------
//Met à jour le champ de valeurs 
    function updateSideSelectsValue(componentId)
    {
        var separator = ";";          
         area_id = componentId+"_state";
        var area=document.getElementById(area_id);      

        var id_select=area.getAttribute("lists");
        var parts = id_select.split("=>");
        var source = parts[0];var dest = parts[1];
        var select_dest = document.getElementById( dest );
        //récupérer toutes les options
        var values=[];
        for(var i=0; i<select_dest.options.length; i++){ var opt =select_dest.options[i]; values.push(opt.value); }
        var input_values = document.getElementById(componentId+"_values");
        
        input_values.value = JSON.stringify( values );
    }


    function sideSelectsSwap(btn_or_select, isSelect, updateValues)
    {
        if(updateValues==undefined) updateValues=true;
        if(isSelect==undefined) isSelect=false;
        var componentId = btn_or_select.getAttribute("for"); //parent component
        if(isSelect)
        {
            componentId = btn_or_select.id;
            componentId=componentId.split("_")[0];
        }
       var id_select=btn_or_select.getAttribute("lists");
       var parts = id_select.split("=>");
       var source = parts[0];var dest = parts[1];
       var select_source = document.getElementById( source );
       var select_dest = document.getElementById( dest );
       
       var removeList=[]; //Store options 
       for(var io=0; io<select_source.selectedOptions.length; io++)
       {    //si ya pas d'option sélectionnées.    
            var opt = select_source.selectedOptions[io];       

            var option = document.createElement("option");
            option.text = opt.text;
            option.value = opt.value;
            select_dest.add(option);
            removeList.push(opt); //remove this option later                                
        }//loop through selected options        
        //remove now :
        for(var i in removeList)
        {
            removeList[i].remove();
        }
        //After removing, save the state 
        var area=document.getElementById(componentId+"_state");
        var mem = [             {id:source,  v: select_source.innerHTML }
                            , {id:dest, v:select_dest.innerHTML}            ]; 
        var jsonstr=JSON.stringify(mem,null,4);        
        area.value= encodeURIComponent(jsonstr);     
            //update values 
        if(updateValues){ updateSideSelectsValue(componentId);}
    }//sideSelectSwap

    function sideSelectsLoad(componentId)
    {              
        area_id = componentId+"_state";
        var area=document.getElementById(area_id);
        if(!area){ console.warn("Erreur introuveble ${area_id}"); return false;}        
        if(area.value)
        {
            var mem = decodeURIComponent( area.value );
            var objs = JSON.parse( mem );
            //console.log(objs);
            for(var i=0; i< objs.length; i++)
            {
                var obj = objs[i];
                var select = document.getElementById( obj.id );
                select.innerHTML= obj.v;
            }
        }else
        { //empty input, means first page load


        }
        updateSideSelectsValue(componentId);
    }//sideSelectsLoad


    //Mise à jour des selects en fonction de la valeur
    function updateSideSelectsFromValue(componentId,force_value)
    { 
        var elstate = document.getElementById(componentId+"_state");
        var el = document.getElementById(componentId+"_values");
        if(elstate.value)
        {
            console.log("skip go, state exits");
            return false;
        }
        if(force_value)
        {   
            el.value=force_value;
        }
        
        var codes = JSON.parse(el.value);
        //Parcourir la source et si le code correspond, l'envoyer en dest
        var src_select = document.getElementById(componentId+"_source");

        for( var io=0; io<src_select.options.length; io++)
        {
            var opt = src_select.options[io];
            if( codes.indexOf(opt.value) >=0)
            {
                //console.log(opt, "<= option found");
                opt.selected=true; //Option trouvée, alors on lasélectionne.
            }
        }//next option
        var  isSelect =true , updateValues = false;
        sideSelectsSwap(src_select, isSelect , updateValues);                
    }//updateSideSelectsFromValue




    window.onload=function()
    {
        sideSelectsLoad(componentId);        
        //alert("update will "+server_values);
        updateSideSelectsFromValue(componentId,server_values);    
        
       var container = document.getElementById(componentId+"_wrap");
       container.style.filter="";     //remove filter:blur()
    }

//------------------------------------------ /   sideSelect script -------------------------------
</script>

