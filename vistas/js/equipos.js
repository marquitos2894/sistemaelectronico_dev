(function(){


   
 
    document.addEventListener("DOMContentLoaded",  function(){
       //await render.renderComponentes();
    })


    document.querySelector('#table_equipos').addEventListener("click", async function(ev){

        if(ev.target.id == 'DeleteItem'){
            document.querySelector('#frmDeleteComp').submit();
        }

        if(ev.target.id == 'EditItem'){
            let id_equipo = ev.target.dataset.equipo;
            //console.log(id_comp);
            const datos = new FormData();
            datos.append('id_equipo_json',id_equipo);
            let response = await fetch('../ajax/equiposAjax.php',{
                method: 'POST',
                body : datos
            });
            let data = await response.json();
            console.log(data);

            //${data[0].id_dr}

            let template = `
                <input type="hidden" name="Id_Equipo_edit" value="${data[0].Id_Equipo}"  />
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Modelo</label>
                        <input type="text" name="Modelo_Equipo_edit" value="${data[0].Modelo_Equipo}" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Tipo</label>
                        <input type="text" name="Tipo_Equipo_edit" value="${data[0].Tipo_Equipo}" class="form-control"  placeholder="Password">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Aplicacion</label>
                        <input type="text" name="Aplicacion_Equipo_edit" value="${data[0].Aplicacion_Equipo}" class="form-control"  placeholder="Password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Marca</label>
                        <input type="text" name="Marca_Equipo_edit" value="${data[0].Marca_Equipo}" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">N°Serie</label>
                        <input type="text" name="NSerie_Equipo_edit" value="${data[0].NSerie_Equipo}" class="form-control placeholder="Password">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Capacidad</label>
                        <input type="text" name="Capacidad_Equipo_edit" value="${data[0].Capacidad_Equipo}" class="form-control" placeholder="Password">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Año Fabricacion</label>
                        <input type="text" name="AnoFab_Equipo_edit" value="${data[0].AnoFab_Equipo}" class="form-control"  placeholder="Password">
                    </div>
                </div>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><strong>Datos del motor</strong></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputEmail4">Motor</label>
                        <input type="text" name="ModeloMotor_Equipo_edit" value="${data[0].ModeloMotor_Equipo}" class="form-control"  placeholder="Email">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Marca</label>
                        <input type="text" name="MarcaMotor_Equipo_edit" value="${data[0].MarcaMotor_Equipo}" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">N°Serie</label>
                        <input type="text" name="SerieMotor_Equipo_edit" value="${data[0].SerieMotor_Equipo}" class="form-control" placeholder="Password">
                    </div>
                </div>         
            `;
         document.querySelector('#modal-body').innerHTML=template;
        }
    });
    
})();

