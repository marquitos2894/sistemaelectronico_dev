(function(){
 
    document.addEventListener("DOMContentLoaded",  function(){
       //await render.renderComponentes();
    })


    

    document.querySelector('#cbocategoria').addEventListener("change",function(ev){
        ev.preventDefault();
        let categoriaoption =document.querySelector('#cbocategoria').selectedOptions
        console.log(document.querySelector('#cbocategoria').value);
        let template = ` 
        <label for="inputEmail4">Medida</label>
        <input type="text" name="medida_simple" class="form-control" id="inputEmail4" placeholder="Medida" maxlength="15">`;
        //valor inicial en BD 2=>neumaticos
        if(document.querySelector('#cbocategoria').value==2){
            template = ``;
            document.querySelector('#cbomedida_neumatico').required=true;
            document.querySelector('#medida_neumatico').setAttribute("style","display:true");
            document.querySelector('#medida_simple').setAttribute("style","display:none");

            document.querySelector('#medida_simple').innerHTML = template;
        }else{
            document.querySelector('#cbomedida_neumatico').required=false;
            document.querySelector('#medida_simple').setAttribute("style","display:true");
            document.querySelector('#medida_neumatico').setAttribute("style","display:none");
            
            document.querySelector('#medida_simple').innerHTML = template;
        }

    });


})();

