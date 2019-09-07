(function(){

    /*$(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTableComp tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });*/

    function render(){
        
        /*this.renderComponentes = async function(){
            const datos = new FormData();
            datos.append('comp_gen','true');
            let response = await fetch('../ajax/componentesAjax.php',{
                method: 'POST',
                body : datos
            });
            let data = await  response.json();
            console.log(data);

            //datables json example
            $(document).ready(function() {
                $('#DTComponentes').DataTable( {
                    data: data,
                    columns: [
                        { data: 'id_comp' },
                        { data: 'descripcion' },
                        { data: 'nparte1' },
                        { data: 'nparte2' },
                        { data: 'nparte3' },
                        { data: 'marca' },
                        { data: 'unidad_med' },
                        { data: 'control_stock' },
                        {
                        data: 'id_comp',
                        render: function ( data, type, row, meta ) {
                            return `<a href="#" id='EditItem' data-producto='${data}' data-toggle="modal" data-target="#ModalEdit">Editar</a>`;
                          }
                        }
                    ]
                });
            });
            //let template = ``;
            /*for(i of data){ 
                template += `
                    <tr class="pd-list-grid">
                        <td>${i.id_comp}</td>
                        <td>${i.descripcion}</td>
                        <td>${i.nparte1}</td>
                        <td>${i.nparte2}</td>
                        <td>${i.nparte3}</td>
                        <td>${i.marca}</td>
                        <td>editar</td>
                    </tr>  
                `;   
            }*/
            //document.querySelector('#myTableComp').innerHTML=template;
            //$('#data-container').html(template);    
        //}


    }
    

    render = new render();
 
    document.addEventListener("DOMContentLoaded",  function(){
       //await render.renderComponentes();
    })



    document.querySelector('#table_componente').addEventListener("click", async function(ev){
      

        if(ev.target.id == 'DeleteItem'){
            document.querySelector('#frmDeleteComp').submit();
        }

        if(ev.target.id == 'EditItem'){
            let id_comp = ev.target.dataset.producto;
            //console.log(id_comp);
            const datos = new FormData();
            datos.append('id_comp',id_comp);
            let response = await fetch('../ajax/componentesAjax.php',{
                method: 'POST',
                body : datos
            });
            let data = await response.json();
            console.log(data);

            const datos0 = new FormData();
            datos0.append('combounidad',data[0].id_unidad_med);
            let response0 = await fetch('../ajax/unidadmedidaAjax.php',{
                method: 'POST',
                body : datos0
            });
            let data0 = await response0.text();
            //console.log(data0);
            
            const datoscat = new FormData();
            datoscat.append('categoriacat',data[0].id_categoria);
            let responsecat = await fetch('../ajax/categoriacompAjax.php',{
                method: 'POST',
                body : datoscat
            });
            let datacat = await responsecat.text();
            console.log(datacat);


            const datosneu = new FormData();
            datosneu.append('medida_neumatico',data[0].medida);
            let responseneu = await fetch('../ajax/componentesAjax.php',{
                method: 'POST',
                body : datosneu
            });
            let dataneu = await responseneu.text();
            console.log(dataneu);


            let template = `
                <input type="hidden" value="${data[0].id_comp}" name="id_comp_formEdit" />
                <input type="hidden" name="categoria_inicial" id="categoria_inicial" value="${data[0].id_categoria}">
                <div class="form-group">
                    <label for="inputAddress">Descripcion</label>
                    <input type="text" value="${data[0].descripcion}" name="descripcion_formEdit"  id="descripcion"  class="form-control" placeholder="Descripcion">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nparte1</label>
                        <input type="text" value="${data[0].nparte1}" name="nparte1" id="nparte1"  class="form-control"  placeholder="Nparte 1">
                        <input type="hidden" value="${data[0].nparte1}" name="nparte1_respaldo">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Nparte2</label>
                        <input type="text" value="${data[0].nparte2}" name="nparte2" id="nparte2"  class="form-control" placeholder="Nparte 2" >
                        <input type="hidden" value="${data[0].nparte2}" name="nparte2_respaldo">
                    </div>
                    <div style="display:none" class="form-group col-md-4">
                        <label for="inputPassword4">Nparte3</label>
                        <input type="hidden" value="${data[0].nparte3}" name="nparte3"  id="nparte3"  class="form-control" placeholder="Nparte 3" >
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Nserie</label>
                        <input type="text" value="${data[0].nserie}" name="nserie" id="nserie" class="form-control"   placeholder="N° Serie">
                        <input type="hidden" value="${data[0].nserie}" name="nserie_respaldo">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Marca</label>
                        <input type="text" value="${data[0].marca}" name="marca" id="marca" class="form-control"   placeholder="Marca">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Unidad Medida</label>
                        <select name="unidad_med" class="form-control" >
                            <option value="${data[0].id_unidad_med}">${data[0].abreviado}</option>
                            ${data0}
                        </select>
                    </div>
                </div>`;

                template +=`  
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Categoria</label>
                        <select name="categoria_edit" id="cbocategoria" class="form-control" >
                        <option value="${data[0].id_categoria}">${data[0].nombre}</option>
                            ${datacat}
                        </select>
                    </div>`;
                    /*   let display_MN = 'none';
                       let display_MS = true;
                    if(data[0].id_categoria==2){
                        display_MN = true;
                        display_MS = 'none';
                    }*/
                    
                    if(data[0].id_categoria==2){
                        template +=` 
                        <div style="display:true" id="medida_neumatico" class="form-group col-md-6">
                            <label for="inputPassword4">Medida</label>
                            <select name="medida_neumatico_edit" id="cbomedida" class="form-control" required>
                                <option value="${data[0].medida}">${data[0].medida}</option>
                                ${dataneu}
                            </select>
                        </div>`;
                        template +=` 
                        <div style="display:none" id="medida_simple" class="form-group col-md-6">
                            <label for="inputEmail4">Medida</label>
                            <input type="text" name="medida_simple_edit" class="form-control" value="" id="inputEmail4" placeholder="Medida">
                        </div>`;
                    }else{
                        template +=` 
                        <div style="display:none" id="medida_neumatico" class="form-group col-md-6">
                            <label for="inputPassword4">Medida</label>
                            <select name="medida_neumatico_edit" id="cbomedida" class="form-control">
                                <option value="">Seleccione medida</option>
                                ${dataneu}
                            </select>
                        </div>`;
                        template +=` 
                        <div style="display:true" id="medida_simple" class="form-group col-md-6">
                            <label for="inputEmail4">Medida</label>
                            <input type="text" name="medida_simple_edit" class="form-control" value="${data[0].medida}" id="inputEmail4" placeholder="Medida">
                        </div>`;
                    }
       
                    
     
                
                template +=`
                </div>`;
         document.querySelector('#modal-body').innerHTML=template;   
        }
    });

    document.querySelector('#modal-body').addEventListener("click",function(ev){
  

        if(ev.target.id=='cbocategoria'){
            document.querySelector('#cbocategoria').addEventListener("change",function(){
                console.log(document.querySelector('#cbocategoria').value);
                if(document.querySelector('#cbocategoria').value==2){
                    document.querySelector('#medida_neumatico').setAttribute("style","display:true");
                    document.querySelector('#medida_simple').setAttribute("style","display:none");
                    document.querySelector('#cbomedida').required=true;
                }else{
                    document.querySelector('#medida_neumatico').setAttribute("style","display:none");
                    document.querySelector('#medida_simple').setAttribute("style","display:true");
                    document.querySelector('#cbomedida').required=false;
                }

            });
        }


    });

})();

