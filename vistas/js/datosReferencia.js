(function(){


   
 
    document.addEventListener("DOMContentLoaded",  function(){
       //await render.renderComponentes();
    })



    document.querySelector('#table_dr').addEventListener("click", async function(ev){

        if(ev.target.id == 'DeleteItem'){
            document.querySelector('#frmDeleteComp').submit();
        }

        if(ev.target.id == 'EditItem'){
            let id_dr = ev.target.dataset.idreferencia;
            //console.log(id_comp);
            const datos = new FormData();
            datos.append('id_dr_datosReferencia',id_dr);
            let response = await fetch('../ajax/componentesAjax.php',{
                method: 'POST',
                body : datos
            });
            let data = await response.json();
            console.log(data);


            let template = `
                <input type="hidden" value="${data[0].id_dr}" name="id_dr_formEdit" />
                <div class="form-group">
                    <label for="inputAddress">Descripcion</label>
                    <input type="text" value="${data[0].dato_referencia}" name="dato_referencia_formEdit"  id="descripcion"  class="form-control" placeholder="Descripcion" maxlength="35">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Descripcion</label>
                    <textarea  name="descripcion_dr_formEdit" value="${data[0].descripcion_dr}"  class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="80">${data[0].descripcion_dr}</textarea>
                </div>
                
                        
            `;
         document.querySelector('#modal-body').innerHTML=template;
        }
    });
    
})();

