(function(){
  
    function $1(selector){
        return document.querySelector(selector);
    }

    function BDcomponentes(){

        this.constructor = async function(){

            if(!localStorage.getItem("carritoGen")){
                localStorage.setItem("carritoGen","[]");    
            }

            if(!localStorage.getItem("BDcomp_gen")){
                localStorage.setItem("BDcomp_gen","[]");
            }
      
            const datos = new FormData();
            datos.append('comp_gen','true');
            let response = await fetch('../ajax/componentesAjax.php',{
                method: 'POST',
                body : datos
            });

            let data = await response.json();
      
            await localStorage.setItem("BDcomp_gen", JSON.stringify(data))
            this.getBDcomp_gen = await JSON.parse(localStorage.getItem("BDcomp_gen"));

            this.carrito = JSON.parse(localStorage.getItem("carritoGen"));
  

        }

        this.agregarItem =  function(item,u_nom,u_sec,id_equi,referencia,nom_equipo){

            //nom_equipo = await consultaBD.validarEquipo(id_equi);
            //nom_equipo = nom_equipo[0]['Nombre_Equipo'];

            for (i of this.getBDcomp_gen){
                if(i.id_comp == item){
                    i.u_nom = u_nom;
                    i.u_sec = u_sec;
                    i.id_equipo = id_equi;
                    i.nom_equipo = nom_equipo 
                    i.referencia = referencia;
                    var datos = i;
                }
            }
            
    
           
            this.carrito.push(datos);
            localStorage.setItem("carritoGen",JSON.stringify(this.carrito))

        }

        this.eliminarItem = function(item){
            for(i of this.carrito){
                if( i.id_comp == item){
                    this.carrito.splice(i,1);
                    console.log("eliminado")
                }
            }
            localStorage.setItem("carritoGen",JSON.stringify(this.carrito));
        }

        this.varciarCarrito = function(){
            this.carrito.splice(0);
            localStorage.setItem('carritoGen','[]');
        }  
    }

    function consultaBD(){

        /*this.validarEquipo = async function(id){
            const datos = new FormData();
            datos.append("id_equipo",id);
            let response = await fetch('../ajax/componentesAjax.php',{
                method : 'POST',
                body : datos
            });
            let data = await response.json();
            return data;
            //console.log(data);
        }*/
    }

    function Render(){

        this.renderCarrito =  function(){
            //console.log(bdcomp.carrito.length);
            //productosCarrito
            if(bdcomp.carrito.length<=0){
                var template = `<div class="alert alert-primary" role="alert">
                El carrito esta vacio !!
                </div><br>`;
                $1("#productosCarrito").innerHTML = template;
            }else{
                
                $1("#productosCarrito").innerHTML = "";
                let template = `<div class="table-responsive"><table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cod.Interno</th>
                        <th scope="col">Descriocion</th>
                        <th scope="col">Nparte1</th>
                        <th scope="col">Nparte2</th>
                        <th scope="col">Ubicacion</th>
                        <th scope="col">Equipo</th>
                        <th scope="col">Referencia</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead><tbody>`;
                let j=1;
                for(i of bdcomp.carrito){
                    template +=`
                    <tr class="alert alert-primary">
                        <td>${j}</td>
                        <td>${i.id_comp}</td>
                        <td>${i.descripcion}</td>
                        <td>${i.nparte1}</td>
                        <td>${i.nparte2}</td>
                        <td>${i.u_nom}-${i.u_sec}</td>
                        <td>${i.nom_equipo}</td>
                        <td>${i.referencia}</td>
                        <td><p class="field"><a href="#" class="button is-danger" id="deleteProducto" data-producto="${i.id_comp}">x</a></p></td>
                    </tr>
                    <div style="display:none;">
                        <tr>
                            <input type="hidden" name="id_comp[]" value="${i.id_comp}">
                            <input type="hidden" name="d_descripcion[]" value="${i.descripcion}">
                            <input type="hidden" name="d_nparte1[]" value="${i.nparte1}">
                            <input type="hidden" name="d_nparte2[]" value="${i.nparte2}">
                            <input type="hidden" name="d_u_nom[]" value="${i.u_nom}">
                            <input type="hidden" name="d_u_sec[]" value="${i.u_sec}">
                            <input type="hidden" name="d_id_equipo[]" value="${i.id_equipo}">
                            <input type="hidden" name="d_nom_equipo[]" value="${i.nom_equipo}">
                            <input type="hidden" name="d_referencia[]" value="${i.referencia}">
                        </tr>
                    <div>`;
                j+=1;
                }
                $1("#productosCarrito").innerHTML = template;
            }

        }

        this.RenderTableComp = async function(page){
            let buscar = document.querySelector('#buscador_comp_text').value;
            let vista = document.querySelector('#vista').value
            let privilegio = document.querySelector('#privilegio').value
    
            const datos = new FormData();
            datos.append('buscarcompajax',buscar);
            datos.append('paginadorajax',page);
            datos.append('vistaajax',vista);
            datos.append('privilegioajax',privilegio);

            let response = await fetch('../ajax/componentesAjax.php',{
                method : 'POST',
                body : datos
            })
            let data = await response.text();
            //console.log(data);
    

            document.querySelector('#componentesin').innerHTML = data;
        }
    }

     var bdcomp = new BDcomponentes();
     var render = new Render();
     var consultaBD = new consultaBD();

    document.addEventListener("DOMContentLoaded", async function(){
        await bdcomp.constructor();
        await render.renderCarrito();
        await render.RenderTableComp();
            
    });

    document.querySelector('#buscador_comp_text').addEventListener("keyup", async function(ev){
        render.RenderTableComp();
    });


    $1('#componentesin').addEventListener("click", async function(ev){
        ev.preventDefault();

        if(ev.target.id=='page'){
            render.RenderTableComp(ev.target.dataset.page);
        }
        if(ev.target.id=="addItem"){
            let iditem = ev.target.dataset.producto;
            let descripcion = $1('#descripcion'+iditem).value;
            let nparte= $1('#nparte'+iditem).value;

            console.log();
            let id_unidad = document.querySelector("#session_idunidad").value;

            //equipos
            const datos = new FormData();
            datos.append('idunidad_compgen','true');
            let response = await fetch('../ajax/componentesAjax.php',{
                method : 'POST',
                body : datos
            });
            let data = await response.text();
               
            //referencia
            const datosDR = new FormData();
            datosDR.append('dataReferencia','true');
            let responseDR = await fetch('../ajax/componentesAjax.php',{
                method : 'POST',
                body : datosDR
            });
            let dataDR = await responseDR.text();
            //console.log(dataDR);

            let template = `<input type="hidden" id="iditem" value="${iditem}" />
            <div class="form-group col-md-8">
            <h5>${descripcion} <span class="badge badge-primary">${nparte}</span></h5>  
            </div> 
            <div class="form-row">
                <div class="form-group col-sm-6">
                <label for="inputEmail4">Ubicacion</label>
                <input type="text" name="unidad_med" id="u_nom" class="form-control" id="inputEmail4" placeholder="Ubicacion">
                </div>
                <div class="form-group col-sm-6">
                <label for="inputPassword4">Seccion</label>
                <input type="text" name="medida" id="u_sec" class="form-control" id="inputPassword4" placeholder="Seccion">
                </div>
            </div>`;
            template += `
            <div class="progress" style="height:1px;">
                <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>`;    
            template += `
            <div class="form-row">
                <div class="form-group col-sm-6">`;
            template +=`
                <label for="inputEmail4">Equipo</label>
                    <select id='chosen-select' data-placeholder='Seleccione Equipo' name='equipo' class="chosen-select">
                        <option value="1">SIN EQUIPO</option>
                            ${data}
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label for="inputEmail4">Referencia</label>
                    <select id='chosen-select_DR' data-placeholder='Seleccione referencia' class="chosen-select">
                    <option value="#Sin especificar">#Sin especificar</option>
                        ${dataDR}
                    </select>
                </div>
            </div>`;    
           //$1('#modal-body').innerHTML = await template;
            $1('#modal-body').innerHTML = await  template;
    
            (async function($) 
            {  
               await $('.chosen-select').chosen({width: "100%"});
               await $('.chosen-select_DR').chosen({width: "100%"});
            })(jQuery);
        
            
            //$1('#cboequipo').classList.add("chosen-select");
        }
    });

    $1('#btnAgregar').addEventListener("click", function(ev){
        //agregar desde el modal
        ev.preventDefault();
        iditem = $1('#iditem').value;
        u_nom = $1('#u_nom').value;
        u_sec = $1('#u_sec').value;
        id_equi = $1('#chosen-select').value;
        referencia = $1('#chosen-select_DR').value;
        nom_equipo = $1('#chosen-select').selectedOptions;
        nom_equipo = nom_equipo[0].label;
        bdcomp.agregarItem(iditem,u_nom,u_sec,id_equi,referencia,nom_equipo);
        render.renderCarrito();
    });

    $1('#productosCarrito').addEventListener("click",function(ev){
        ev.preventDefault();
        if(ev.target.id == "deleteProducto"){
            bdcomp.eliminarItem(ev.target.dataset.producto);
            render.renderCarrito();
        }   
    });


    $1("#varciarCarrito").addEventListener("click",function(ev){
        ev.preventDefault();
        bdcomp.varciarCarrito();
        render.renderCarrito();
    });

})();