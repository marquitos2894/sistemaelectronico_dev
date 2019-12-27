(function(){



    document.querySelector('#table_unidadmed').addEventListener("click", async function(ev){

        if(ev.target.id == 'EditItem'){
            let id_unidad_med = ev.target.dataset.item;
            console.log(id_unidad_med);
            const datos = new FormData();
            datos.append('id_unidad_med_json',id_unidad_med);
            let response = await fetch('../ajax/unidadmedidaAjax.php',{
                method: 'POST',
                body : datos
            });
            let data = await response.json();

            console.log(data[0].descripcion);

            /*for(data of row){
                console.log(row.descripcion);
            }*/

            let template = `
                <input type="hidden" value="${data[0].id_unidad_med}" name="id_um_formEdit" />
                <div class="form-group">
                    <label for="inputAddress">Descripcion</label>
                    <input type="text" value="${data[0].descripcion}" name="descripcion_formEdit"   class="form-control" placeholder="Descripcion" maxlength="15">
                </div>
                <div class="form-group">
                    <label for="inputAddress">Abreviado</label>
                    <input type="text" value="${data[0].abreviado}" name="abrev_formEdit"  class="form-control" placeholder="Abreviado" maxlength="10">
                </div>              
            `;
         document.querySelector('#modal-body').innerHTML=template;   
        }
    });



})();