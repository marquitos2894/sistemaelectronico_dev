(function(){
  
    function $1(selector){
        return document.querySelector(selector);
    }

    function BDcomponentes(){

        this.constructor = async function(){

            if(!localStorage.getItem("carritoGen")){
                localStorage.setItem("carritoGen","[]");  
                
            }

            if(!localStorage.getItem("carritoIn2")){
                localStorage.setItem("carritoIn2","[]");  
            }

            if(!localStorage.getItem("BDcomp_gen")){
                localStorage.setItem("BDcomp_gen","[]");
            }
            
            $valor='true'
            datos = new FormData();
            datos.append('comp_gen',$valor);
            let response = await fetch('../ajax/componentesAjax.php',{
                method: 'POST',
                body : datos
            });
            let data = await response.json();
            
            await localStorage.setItem("BDcomp_gen", JSON.stringify(data))
            this.getBDcomp_gen = await JSON.parse(localStorage.getItem("BDcomp_gen"));

            this.carrito = JSON.parse(localStorage.getItem("carritoGen"));
            console.log(this.carrito);
            await render.renderCarrito();
            await this.numrowsCarrito();
        }

        this.agregarItem = function(item,u_nom,u_sec,id_equi,referencia,nom_equipo,cant){

            //nom_equipo = await consultaBD.validarEquipo(id_equi);
            //nom_equipo = nom_equipo[0]['Nombre_Equipo'];
            var existe = false;
            

            console.log(item);
            var dato = {};

            for (var i in this.getBDcomp_gen){
                if(this.getBDcomp_gen[i].id_comp == item){
                    dato = this.getBDcomp_gen[i];
                    existe = true;
                    break;
                }  
            }
           
            console.log(dato);
            
            if(existe == false){
                location.reload();
                return;
            }

            /* para obtener un identificador unico por cada item(nolinea) */
            var lineas = []; j=0;
            for(i in this.carrito){
                lineas[j] = this.carrito[i].nolinea;
                j++;
            }
            console.log(lineas);
            var max = Math.max(... lineas);
            if(max == '-Infinity'){
                max=0;
            }else{
                max = max+1;
            }

            console.log(max);
            
            /* ---- */

            

            for(c of this.carrito){
               if(c.id_comp==item){  
                var datoN = {};
                    for (var key in c) {
                        datoN[key] = c[key];                        
                    }

                    /*datoN.id_comp = c.id_comp;
                    datoN.descripcion = c.descripcion;
                    datoN.est = c.est;
                    datoN.est_baja = c.est_baja;
                    datoN.fk_idcategoria = c.fk_idcategoria;
                    datoN.fk_idunidad_med = c.id_comp;
                    datoN.id_equipo = c.id_equipo;
                    datoN.marca = c.marca;
                    datoN.medida = c.medida;
                    datoN.nparte1 = c.nparte1;
                    datoN.nparte2 = c.nparte2;
                    datoN.nparte3 = c.nparte3;
                    datoN.nserie = c.nserie;*/
                    // console.log(this.carrito);



                    datoN.nolinea = max;
                    datoN.u_nom = u_nom;
                    datoN.u_sec = u_sec;
                    datoN.id_equipo = id_equi;
                    datoN.nom_equipo = nom_equipo; 
                    datoN.referencia = referencia;
                    datoN.cant =cant;
                    
        
                    this.carrito.push(datoN);
                    console.log(this.carrito);
                    localStorage.setItem("carritoGen",JSON.stringify(this.carrito));
                    datoN = {};
                    return;
                }
            }
            

            console.log(dato);
            dato.nolinea = max;
            dato.u_nom = u_nom;
            dato.u_sec = u_sec;
            dato.id_equipo = id_equi;
            dato.nom_equipo = nom_equipo; 
            dato.referencia = referencia;
            dato.cant = cant;

            var datoX = dato;
            this.carrito.push(datoX);
            
            console.log(this.carrito);
            localStorage.setItem("carritoGen",JSON.stringify(this.carrito));
            

            
            //console.log(this.carrito);
            
        }

        this.eliminarItem = function(item){

            for(i in this.carrito){
                if(this.carrito[i].nolinea == item){
                    this.carrito.splice(i,1);
                    console.log("eliminado")
                }
                //console.log(this.carrito);
            }
            
            localStorage.setItem("carritoGen",JSON.stringify(this.carrito));
            return;
        }

        this.varciarCarrito = function(){
            this.carrito.splice(0);
            localStorage.setItem('carritoGen','[]');
        }

        this.numrowsCarrito = function(){
            if(this.carrito.length>0){
                document.querySelector('#submit').disabled = false;
            }else{
                document.querySelector('#submit').disabled = true;
            }
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
                        <th scope="col">NSerie</th>
                        <th scope="col">Ubicacion</th>
                        <th scope="col">Cant</th>
                        <th scope="col">Equipo</th>
                        <th scope="col">Referencia</th>
                        <th scope="col">Quitar</th>
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
                        <td>${i.nserie}</td>
                        <td>${i.u_nom}-${i.u_sec}</td>
                        <td>${i.cant}</td>
                        <td>${i.nom_equipo}</td>
                        <td>${i.referencia}</td>
                        <td><p class="field"><a href="#" class="button is-danger" id="deleteProducto" data-producto="${i.nolinea}">x</a></p></td>
                    </tr>
                    <div style="display:none;">
                        <tr>
                            <input type="hidden" name="id_comp[]" value="${i.id_comp}">
                            <input type="hidden" name="d_descripcion[]" value="${i.descripcion}">
                            <input type="hidden" name="d_nparte1[]" value="${i.nparte1}">
                            <input type="hidden" name="d_nparte2[]" value="${i.nparte2}">
                            <input type="hidden" name="d_nserie[]" value="${i.nserie}">
                            <input type="hidden" name="d_u_nom[]" value="${i.u_nom}">
                            <input type="hidden" name="d_u_sec[]" value="${i.u_sec}">
                            <input type="hidden" name="d_cant[]" value="${i.cant}">
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

        
        this.Alert = function (title,mensaje,div){
            let template = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>${title}</strong>${mensaje}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `;
            document.querySelector("#"+div).innerHTML = template;
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
        //await render.renderCarrito();
        render.RenderTableComp();
            
    });

    document.querySelector('#box_select').addEventListener("click",function(ev){
        ev.target.id;
        //console.log(ev.target.id);
        // Enviar a vale = 1
        //Registrar stock incial = 0
        if(ev.target.id=='box_valeI'){
            console.log(ev.target.id);
            document.querySelector('#box_valeI_S').className='card text-white bg-success';
            document.querySelector('#box_stockI_S').className='card';
            document.querySelector('#submit').className='btn btn-success btn-lg btn-block';
            document.querySelector('#submit').value="Enviar datos a vale ingreso";
            document.querySelector('#t_reg').value=1;
        }

        if(ev.target.id=='box_stockI'){
            console.log(ev.target.id);
            document.querySelector('#box_stockI_S').className='card text-white bg-danger';
            document.querySelector('#box_valeI_S').className='card';
            document.querySelector('#submit').className='btn btn-danger btn-lg btn-block';
            document.querySelector('#submit').value="Registrar como stock inicial";
            document.querySelector('#t_reg').value=0;
        }

    })

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
            let nserie= $1('#nserie'+iditem).value;

            console.log();
            let id_unidad = document.querySelector("#session_idunidad").value;

            //equipos
            const datos = new FormData();
            datos.append('idunidad_compgen',id_unidad);
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
            <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group col-md-8">
                                    <h5><span class="badge badge-danger">${iditem} »</span>${descripcion} <span class="badge badge-primary">NP:${nparte} | NS:${nserie} </span></h5>  
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                
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
                        
                                    <div class="form-row">
                                        <div class="form-group col-sm-6">
                                            <label for="inputEmail4">(*)Cantidad</label>
                                            <input type="number" id="cant" name="cant" value="1"  class="form-control"  placeholder="Cantidad" min="0" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
        cant = $1('#cant').value;
        id_equi = $1('#chosen-select').value;
        referencia = $1('#chosen-select_DR').value;
        nom_equipo = $1('#chosen-select').selectedOptions;
        nom_equipo = nom_equipo[0].label;
        if(cant==''){
            render.Alert("(*) Campo obligatorio: ","Ingrese cantidad","alert_modal");
            ev.preventDefault();
            //return;
        }
        else if(cant<0){
            render.Alert("(*) Campo obligatorio: ","Solo numeros postivos","alert_modal");
            ev.preventDefault();
        }else{
            bdcomp.agregarItem(iditem,u_nom,u_sec,id_equi,referencia,nom_equipo,cant);
            render.renderCarrito();
            bdcomp.numrowsCarrito();
            $('#exampleModalCenter').modal('hide');
        }

        //console.log(bdcomp.carrito.length);
    });

    $1('#productosCarrito').addEventListener("click",function(ev){
        ev.preventDefault();
        if(ev.target.id == "deleteProducto"){
            bdcomp.eliminarItem(ev.target.dataset.producto);
            render.renderCarrito();
            bdcomp.numrowsCarrito();
        }   
    });

    $1("#varciarCarrito").addEventListener("click",function(ev){
        ev.preventDefault();
        bdcomp.varciarCarrito();
        render.renderCarrito();
        bdcomp.numrowsCarrito();
    });

    $1("#submit").addEventListener("click",function(ev){
        let t_reg = $1("#t_reg").value;
        console.log(t_reg);
        if(t_reg == ""){
            ev.preventDefault();
            render.Alert("(*) Campo obligatorio: ","Seleccione tipo de registro","alert");     
        } 
     
    });

})();