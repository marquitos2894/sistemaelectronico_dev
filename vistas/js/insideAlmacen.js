(function(){

    function render(){

        this.renderEdit= async function(id_ac,id_alm,id_unidad){

        try{
            
            let datos = new FormData();
            datos.append('id_ac',id_ac);
            let response = await fetch("../ajax/almacenAjax.php",{
                    method : "POST",
                    body: datos
            });
            let data = await response.json();
           

            const datosEquipo = new FormData();
            datosEquipo.append('id_equipo_insideAlm',data[0].Id_Equipo);
            datosEquipo.append('id_unidad_insideAlm',id_unidad);
            let responseEquipo = await fetch('../ajax/almacenAjax.php',{
                method : 'POST',
                body : datosEquipo
            });
            let dataEquipo = await responseEquipo.text();
            console.log(data[0].Referencia);
           
                     //referencia
                     const datosDR = new FormData();
                     datosDR.append('dataReferencia',data[0].Referencia);
                     let responseDR = await fetch('../ajax/almacenAjax.php',{
                         method : 'POST',
                         body : datosDR
                     });
                     let dataDR = await responseDR.text();
                     console.log(dataDR);

           var template =  `         
            <div class="form-row">
                <input type="hidden" name="id_comp_almacen" value="${data[0].id_comp}">
                <input type="hidden" name="fk_idalm_almacen" value="${data[0].fk_idalm}">
                <input type="hidden" name="id_ac_almacen" value="${data[0].id_ac}">
                <input type="hidden" name="cs_inicial" id="cs_inicial" value="${data[0].control_stock}">
                <div class="form-group col-md-8">
                    <h5>${data[0].descripcion} <span class="badge badge-primary">${data[0].nparte1}</span></h5>  
                </div>   
               <div class="form-group col-md-6">
                   <label for="inputEmail4">Ubicacion</label>
                   <input type="text" value="${data[0].u_nombre}" name="u_nombre" class="form-control"  placeholder="Nparte 1">
               </div>
               <div class="form-group col-md-6">
                   <label for="inputPassword4">Seccion</label>
                   <input type="text" value="${data[0].u_seccion}" name="u_seccion" class="form-control" placeholder="Nparte 2" >
               </div>
            </div>
            <div class="form-row">

               <div class="form-group col-md-6">
                    <label for="inputEmail4">Equipo</label>
                    <select id='chosen-select' data-placeholder='Seleccione Equipo' name="equipo" class="chosen-select">
                        <option value="${data[0].Id_Equipo}">${data[0].alias_equipounidad}</option>
                        ${dataEquipo}
                    </select>
               </div>
      
               <div class="form-group col-md-6">
                    <label for="inputEmail4">Referencia</label>
                    <select name="referencia" id='chosen-select_DR' data-placeholder='Seleccione referencia' class="chosen-select">
                        <option value="${data[0].Referencia}">${data[0].Referencia}</option>
                        ${dataDR}
                    </select>
               </div>

            </div>
            
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Control Stock</label>
                    <select name="control_stock" id="control_stock" class="form-control" >
                            <option value="${data[0].control_stock}">${(data[0].control_stock==1)?"activado":"desactivado"}</option>
                            <option value="${(data[0].control_stock==1)?0:1}">${(data[0].control_stock==0)?"activado":"desactivado"}</option>
                    </select>
                </div> 
            </div>
            <!--control stock con estado 0-->
            <div id='div_cs_est0'></div>`;
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
                <!--control stock con estado 1--> 
                <div id='div_cs_est1' class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Stock Min.</label>
                        <input type="text"  value="${dataCS[0].stock_min}" name="smin" id="smin"  class="form-control"  placeholder="Stock Min">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Stock Max.</label>
                        <input type="text" value="${dataCS[0].stock_max}"name="smax" id="smax"  class="form-control" placeholder="Stock Max" >
                    </div>
                </div> `;
            }
      
       
            document.querySelector('#modal-body').innerHTML =  template;

            (async function($) 
            {  
                await $('.chosen-select').chosen({width: "100%"});
                await $('.chosen-select_DR').chosen({width: "100%"});
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
        let id_unidad = document.querySelector('#session_idunidad').value;
        console.log(id_ac);
        console.log(id_alm);
        console.log(id_unidad);
        render.renderEdit(id_ac,id_alm,id_unidad);
    }

 });

 document.querySelector('#modal-body').addEventListener("click",function(ev){

    //console.log(document.querySelector('#cs_inicial').value);
    if(document.querySelector('#cs_inicial').value==0){
        if(ev.target.id=="control_stock"){
            document.querySelector('#control_stock').addEventListener("change",function(ev){      
                //console.log(document.querySelector('#control_stock').value);
                let cs = document.querySelector('#control_stock').value;
                let template= ``;
                if(cs==1){
                    template +=  ` 
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Stock Min.</label>
                            <input type="text" value="" name="smin" id="nparte1"  class="form-control"  placeholder="Stock Min" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">Stock Max.</label>
                            <input type="text" value="" name="smax" id="nparte2"  class="form-control" placeholder="Stock Max" required >
                        </div>
                    </div> `;
                }

                document.querySelector('#div_cs_est0').innerHTML=template;
            });
        }
    }else{
        if(ev.target.id=="control_stock"){
            document.querySelector('#control_stock').addEventListener("change",function(ev){
                ev.preventDefault();
                let cs = document.querySelector('#control_stock').value;
                if(cs==0){
                    document.querySelector('#div_cs_est1').setAttribute("style","display:none");
                }else{
                    document.querySelector('#div_cs_est1').setAttribute("style","display:true");
                }
            });
        }    

    }
        
 });


    


})();