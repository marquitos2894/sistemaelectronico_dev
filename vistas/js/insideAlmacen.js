(function(){

    function render(){

        this.renderEdit= async function(id_ac,id_alm){

        try{
            
            let datos = new FormData();
            datos.append('id_ac',id_ac);
            let response = await fetch("../ajax/almacenAjax.php",{
                    method : "POST",
                    body: datos
            });
            let data = await response.json();
            console.log(data);

            const datosEquipo = new FormData();
            datosEquipo.append('combo_eq',data[0].Nombre_Equipo);
            let responseEquipo = await fetch('../ajax/almacenAjax.php',{
                method : 'POST',
                body : datosEquipo
            });
            let dataEquipo = await responseEquipo.text();
            //console.log(dataEquipo);
           
           var template =  `         
            <div class="form-row">
               <div class="form-group col-md-6">
                   <label for="inputEmail4">Ubicacion</label>
                   <input type="text" value="${data[0].u_nombre}" name="nparte1" id="nparte1"  class="form-control"  placeholder="Nparte 1">
               </div>
               <div class="form-group col-md-6">
                   <label for="inputPassword4">Seccion</label>
                   <input type="text" value="${data[0].u_seccion}" name="nparte2" id="nparte2"  class="form-control" placeholder="Nparte 2" >
               </div>
            </div>
            <div class="form-row">

               <div class="form-group col-md-6">
                    <label for="inputEmail4">Equipo</label>
                    <select id='chosen-select' data-placeholder='Seleccione Equipo' name='equipo' class="chosen-select">
                        <option value="${data[0].Id_equipo}">${data[0].Nombre_Equipo}</option>
                        ${dataEquipo}
                    </select>
               </div>
      
               <div class="form-group col-md-6">
                   <label for="inputPassword4">Referencia</label>
                   <select name="referencia" class="form-control" >
                       <option value="${data[0].Referencia}">${data[0].Referencia}</option>
                   </select>
               </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputPassword4">Control Stock</label>
                <select name="unidad_med" class="form-control" >
                        <option value="${data[0].control_stock}">${(data[0].control_stock==1)?"activado":"desactivado"}</option>
                        <option value="${(data[0].control_stock==1)?1:0}">${(data[0].control_stock==0)?"activado":"desactivado"}</option>
                </select>
                </div>
            </div>`;
            if(data[0].control_stock==1){

                let datosCS = new FormData();
                datosCS.append('id_comp_cs',data[0].id_comp);
                datosCS.append('id_alm_cs',id_alm);
                let responseCS = await fetch("../ajax/almacenAjax.php",{
                        method : "POST",
                        body: datosCS
                });
                let dataCS = await responseCS.json();
                console.log(dataCS);

                template +=  ` 
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Stock Min.</label>
                        <input type="text" value="${dataCS[0].stock_min}" name="smin" id="nparte1"  class="form-control"  placeholder="Stock Min">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Stock Max.</label>
                        <input type="text" value="${dataCS[0].stock_max}"name="smax" id="nparte2"  class="form-control" placeholder="Stock Max" >
                    </div>
                </div> `;
            }
      
       
            document.querySelector('#modal-body').innerHTML =  template;

            (async function($) 
            {  
                await $('.chosen-select').chosen({width: "100%"});
            })(jQuery);

        }catch(err){
            console.log('fetch failed', err);
        }

        

        }

    }

    render = new render();

 document.querySelector('#dtbody').addEventListener("click",function(ev){
  
    if(ev.target.id=='controlstock'){
        console.log(ev.target.dataset.producto);
        let id_ac = ev.target.dataset.producto;
        let id_alm = document.querySelector('#id_alm_session').value;
        console.log(id_ac);
        console.log(id_alm);
        render.renderEdit(id_ac,id_alm);

    }

 });
    


})();