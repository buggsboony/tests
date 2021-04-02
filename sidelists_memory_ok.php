
<style>
    .sideselects_buttons
    {
       /* background: chocolate; */
 
        width:auto;
 
  margin: 0;
  position: relative;
  top: 50%;
 
    }


    .container_sideselects
    {
        /*background: cadetblue;*/
        width: 400px;   
        display: inline-flex;

        
    }
</style>




<?php
var_dump( $_POST);
extract($_POST);

/*

<form method="POST">
        <div id="<?php echo $componentId;s" class="container_sideselects">

            <select id="sideselect_source" size="3" >
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>        
            </select>
            
            <div class="sideselects_buttons">
                <button type="button" lists="sideselect_source=>sideselect_dest"  onclick="sideSelectsSwap(this);"> &gt;&gt; </button>
                <button type="button" onclick="sideSelectsSwap(this);" lists="sideselect_dest=>sideselect_source" >&lt;&lt;</button>
            </div>


            <select id="sideselect_dest" size="3" >
            <option value="mercedes">Mercedes</option>
            <option value="Cadiac">Cadiac</option>
            </select>

            <input type="hidden" lists="sideselect_source=>sideselect_dest"  id="sideselect_state" name="sideselect_state" value="<?php echo $sideselect_state; ?>">
            <input type="text" id="sideselect_values" name="sideselect_values" value="<?php echo $sideselect_values; ?>">
        </div>
        <input type="submit" value="submit" />
</form>

*/

$componentId="sideSelectVoitures";
$componentSize=4;
?>



<form method="POST">
        <div id="<?php echo $componentId;?>_wrap" class="container_sideselects">

            <select id="<?php echo $componentId;?>_source" size="<?php echo $componentSize;?>" >
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>        
            </select>
            
            <div class="sideselects_buttons">
                <button type="button" lists="<?php echo $componentId;?>_source=><?php echo $componentId;?>_dest"  onclick="sideSelectsSwap(this);"> &gt;&gt; </button>
                <button type="button" onclick="sideSelectsSwap(this);" lists="<?php echo $componentId;?>_dest=><?php echo $componentId;?>_source" >&lt;&lt;</button>
            </div>


            <select id="<?php echo $componentId;?>_dest" size="<?phpecho $componentSize;?>" >
            <option value="mercedes">Mercedes</option>
            <option value="Cadiac">Cadiac</option>
            </select>

            <input type="hidden" lists="<?php echo $componentId;?>_source=><?php echo $componentId;?>_dest"  id="<?php echo $componentId;?>state" name="<?php echo $componentId;?>state" value="<?php echo $sideselect_state; ?>">
            <input type="text" id="<?php echo $componentId;?>_values" name="<?php echo $componentId;?>_values" value="<?php echo $sideselect_values; ?>">
        </div>
        <input type="submit" value="submit" />
</form>

















<script>
//------------------------------------- sideSelect script ------------------------------------
//Met à jour le champ de valeurs 
    function updateSideSelectsValue(area_id)
    {
          var separator = ";";
          var separator = ";";
        if( area_id===undefined) area_id = "sideselect_state";
        var area=document.getElementById(area_id);      

        var id_select=area.getAttribute("lists");
        var parts = id_select.split("=>");
        var source = parts[0];var dest = parts[1];
        var select_dest = document.getElementById( dest );
        //récupérer toutes les options
        var values=[];
        for(var i=0; i<select_dest.options.length; i++){ var opt =select_dest.options[i]; values.push(opt.value); }
        var input_values = document.getElementById("sideselect_values");
        
        input_values.value = JSON.stringify( values );
    }


    function sideSelectsSwap(btn)
    {
       var id_select=btn.getAttribute("lists");
       var parts = id_select.split("=>");
       var source = parts[0];var dest = parts[1];
       var select_source = document.getElementById( source );
       if( select_source.selectedOptions.length<=0)
       {
           return;
       }
       var opt = select_source.selectedOptions[0];       
       var select_dest = document.getElementById( dest );
       
       var option = document.createElement("option");
       option.text = opt.text;
       option.value = opt.value;
        select_dest.add(option);
        opt.remove();

        var area=document.getElementById("sideselect_state");
        var mem = [ 
            {id:source,  v: select_source.innerHTML }
            , {id:dest, v:select_dest.innerHTML}
        ];
        var jsonstr=JSON.stringify(mem,null,4);        
        area.value= encodeURIComponent(jsonstr);

        updateSideSelectsValue();
    }//sideSelectSwap

    function sideSelectsLoad(area_id)
    {
      
        if( area_id===undefined) area_id = "sideselect_state";
        var area=document.getElementById(area_id);        
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

        updateSideSelectsValue();
    }

    sideSelectsLoad();
//------------------------------------------ /   sideSelect script -------------------------------
</script>

