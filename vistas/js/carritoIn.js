(async function(){

    var id_almacen = $('#id_alm_vi').value;
    var id_usuario = $('#id_usuario').value;

    var ls_carritoIn = "carritoIn"+"-"+id_usuario+"-"+id_almacen;
    var ls_carritoIn2 = "carritoIn2"+"-"+id_usuario+"-"+id_almacen;
    var ls_BDproductos = "BDproductos"+"-"+id_usuario+"-"+id_almacen;
    //funcion reutilizable para seleccionar elementos del dom
    function $(selector){
        return document.querySelector(selector);
    }

    function Carrito1(){

        this.constructor = async function(){

                
                if(!localStorage.getItem(ls_carritoIn)){
                    localStorage.setItem(ls_carritoIn,"[]");                  
                }

                if(!localStorage.getItem(ls_carritoIn2)){
                    localStorage.setItem(ls_carritoIn2,"[]");  
                }

                
                const datos = new FormData();
                datos.append('id_alm_consulta', id_almacen);
                let response = await fetch('../ajax/almacenAjax.php',{
                    method : 'POST',
                    body :  datos
                });
                let data = await response.json();
                
                await localStorage.setItem(ls_BDproductos,JSON.stringify(data));
                this.getBDproductos = await JSON.parse(localStorage.getItem(ls_BDproductos));

                this.getCarritoIn = await JSON.parse(localStorage.getItem(ls_carritoIn));
                await view.renderCarritoIn();

                this.getCarritoIn2 = await JSON.parse(localStorage.getItem(ls_carritoIn2));
                await view.renderCarritoIn2();
            
                await this.numrowsCarrito();
                view.render_fila();
        }

        this.update_listas= async function(){
            this.getCarritoIn = await JSON.parse(localStorage.getItem(ls_carritoIn));
            await view.renderCarritoIn();

            this.getCarritoIn2 = await JSON.parse(localStorage.getItem(ls_carritoIn2));
            await view.renderCarritoIn2();
        
            await this.numrowsCarrito();
            view.render_fila();
        }

        this.agregarItem = function(item,cant){

            var existe = false;
            for(i of this.getBDproductos){
                if(i.id_ac == item){
                   var datos = i;          
                   //i.cant = parseFloat(i.cant) + 1;
                   existe=true;   
                }
            }

            if(existe == false){
                location.reload();
                return;
            }

            for(i of this.getCarritoIn){
                if(i.id_ac == item){
                     
                    if(cant == ""){
                        i.cantidad = parseFloat(i.cantidad)+1;
                    }else{
                        i.cantidad = cant;
                    }

                    if(i.nserie!=""){
                        i.cantidad=1;
                    }
                  
                     localStorage.setItem(ls_carritoIn,JSON.stringify(this.getCarritoIn)); 
                     return;
                }
            }

            if(cant == ""){
                datos.cantidad = 1;
            }else{
            datos.cantidad = cant;
            }

            if(datos.nserie!=""){
                datos.cantidad = 1;
            }

            this.getCarritoIn.push(datos);
            localStorage.setItem(ls_carritoIn,JSON.stringify(this.getCarritoIn));          
        }


        this.eliminarItemCI = function(item){
            for(i in this.getCarritoIn){
                if(this.getCarritoIn[i].id_ac == item){
                    this.getCarritoIn.splice(i,1);
                    //console.log("eliminado")
                }
            }
            localStorage.setItem(ls_carritoIn, JSON.stringify(this.getCarritoIn));     
        }

        this.eliminarItemCI2 = function(item){
            for(i in this.getCarritoIn2){
                if(this.getCarritoIn2[i].d_id_ac == item){
                    this.getCarritoIn2.splice(i,1);
                    console.log("eliminado")
                }
            }
            localStorage.setItem(ls_carritoIn2, JSON.stringify(this.getCarritoIn2));     
        }

        this.varciarCarrito = function(){
            this.getCarritoIn.splice(0);
            localStorage.setItem(ls_carritoIn,'[]');
        }

        this.varciarCarrito2 = function(){
            this.getCarritoIn2.splice(0);
            localStorage.setItem(ls_carritoIn2,'[]');
        }

        this.numrowsCarrito = function(){
            if(this.getCarritoIn.length>0 || this.getCarritoIn2.length>0){
                document.querySelector('#btnvale').disabled = false;
            }else{
                document.querySelector('#btnvale').disabled = true;
            }        
        }

        this.validar_registro = function(parametro){
            localStorage.setItem("validar_registro",parametro);       
        }
          
    }

    function render(){

        this.RenderTableComp = async function(page){
            let buscar = document.querySelector('#buscador_comp_text').value;
            //let paginador = document.querySelector('#paginador').value
            let vista = document.querySelector('#vista').value
            let id_alm = document.querySelector('#id_alm').value
            let privilegio = document.querySelector('#privilegio').value
    
            const datos = new FormData();
            datos.append('buscarcompajax',buscar);
            datos.append('paginadorajax',page);
            datos.append('vistaajax',vista);
            datos.append('almacenajax',id_alm);
            datos.append('privilegioajax',privilegio);
            datos.append('tipoajax',"vale");
            let response = await fetch('../ajax/almacenAjax.php',{
                method : 'POST',
                body : datos
            })
            let data = await response.text();
    
            document.querySelector('#catalogo').innerHTML = data;
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

        this.fechaA = function(){
            date = new Date();
            y=date.getFullYear();
            m=date.getMonth()+1;
            d=date.getDate();
            if(m<10){m='0'+m;}
            if(d<10){d='0'+d;}
            fecha = `${y}-${m}-${d}`;
            return fecha;
        }
    }

    function CarritoView(){

        this.renderCarritoIn = function(){
            if(carrito.getCarritoIn.length<=0){
                var template = `<tr class="alert alert-primary" role="alert">
               <td colspan="11"> El carrito esta vacio !!</td>
                </tr>`;
                $("#productosCarrito").innerHTML = template;
            }else {
                $("#productosCarrito").innerHTML = "";   
                var template = ``;
                let j = 1;
                //console.log(carrito.getCarritoIn);
                for(i of carrito.getCarritoIn){
                  template +=`
                    <tr id='row${i.id_ac}'>
                        <th scope="row">${j}</th>
                        <td>${i.id_comp}</td>
                        <td>${i.descripcion}</td>
                        <td>${i.nparte1}</td>
                        <td>${i.nserie}</td>
                        <td>${i.u_nombre}-${i.u_seccion}</td>
                        <td>${i.stock} ${i.abreviado}</td>
                        <td>${i.alias_equipounidad}</td>
                        <td>${i.Referencia}</td>
                        <td>${i.cantidad}</td>
                        <td><p class="field"><a href="#" class="button is-danger" id="deleteProducto" data-producto="${i.id_ac}">x</a></p></td></tr>
                        <div style="display:none;">
                        <tr>
                        <input type="hidden" name="id_ac_carritoin[]" value="${i.id_ac}">
                        <input type="hidden" name="dv_codigo[]" value="${i.id_comp}">
                        <input type="hidden" name="dv_descripcion[]" value="${i.descripcion}">
                        <input type="hidden" name="dv_nparte1[]" value="${i.nparte1}">
                        <input type="hidden" name="dv_stock[]" value="${i.stock}">
                        <input type="hidden" name="dv_ingreso[]" value="${i.cantidad}">
                        <input type="hidden" name="dv_id_equipo[]" value="${i.id_equipounidad}">
                        <input type="hidden" name="dv_nom_equipo[]" value="${i.alias_equipounidad}">
                        <input type="hidden" name="dv_referencia[]" value="${i.Referencia}">
                        <input type="hidden" name="dv_unombre[]" value="${i.u_nombre}">
                        <input type="hidden" name="dv_useccion[]" value="${i.u_seccion}"></tr><div>`;
                j+=1;
                }
                $("#productosCarrito").innerHTML = template;            
            }

            
        }

        this.renderCarritoIn2 = function(){
            if(carrito.getCarritoIn2.length<=0){
                var template = ``;
                $("#productosCarrito2").innerHTML = template;
            }else {
                $("#productosCarrito2").innerHTML = "";   
                var template = `
                <div class="card">
                    <div class="card-header text-white bg-primary mb-3">productos recibidos</div>
                    <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered" id='carrito2'>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Cod.Interno</th>
                                <th scope="col">Descriocion</th>
                                <th scope="col">Nparte</th>
                                <th scope="col">NSerie</th>
                                <th scope="col">Ubicacion</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Equipo</th>
                                <th scope="col">Referencia</th>
                                <th scope="col">Ingreso</th>
                                <th scope="col">Quitar</th>
                            </tr>
                        </thead>
                        <tbody>`;
                let j = 1;
                console.log(carrito.getCarritoIn2);
                for(i of carrito.getCarritoIn2){
                  template +=`
                            <tr class="alert alert-primary">
                                <th scope="row">${j}</th>
                                <td>${i.id_comp}</td>
                                <td>${i.d_descripcion}</td>
                                <td>${i.d_nparte}</td>
                                <td>${i.d_nserie}</td>
                                <td>${i.d_u_nom}-${i.d_u_sec}</td>
                                <td>${i.d_stock}</td>
                                <td>${i.d_nom_equipo}</td>
                                <td>${i.d_referencia}</td>
                                <td>${i.d_cant}</td>
                                <td><p class="field"><a href="#" class="button is-danger" id="deleteProductoc2" data-productoc2="${i.d_id_ac}">x</a></p></td></tr>
                                <div style="display:none;">
                                <tr>
                                <input type="hidden" name="id_ac_carritoin[]" value="${i.d_id_ac}">
                                <input type="hidden" name="dv_codigo[]" value="${i.id_comp}">
                                <input type="hidden" name="dv_descripcion[]" value="${i.d_descripcion}">
                                <input type="hidden" name="dv_nparte1[]" value="${i.d_nparte}">
                                <input type="hidden" name="dv_stock[]" value="${i.d_stock}">
                                <input type="hidden" name="dv_ingreso[]" value="${i.d_cant}">
                                <input type="hidden" name="dv_id_equipo[]" value="${i.d_fk_idflota}">
                                <input type="hidden" name="dv_nom_equipo[]" value="${i.d_nom_equipo}">
                                <input type="hidden" name="dv_referencia[]" value="${i.d_referencia}">
                                <input type="hidden" name="dv_unombre[]" value="${i.u_d_u_nom}">
                                <input type="hidden" name="dv_useccion[]" value="${i.d_u_sec}">
                            </tr>`;
                        j+=1;
                    }
                    template +=`
                        </tbody>
                    </table> 
                    <div>
                    <a href="#" id="varciarCarrito2" class="btn btn-primary"><i class="far fa-trash-alt"></i> Vaciar</a>
                    </div>
                </div>`;
             
                $("#productosCarrito2").innerHTML = template;            
            }
        }

        this.render_fila = function(){
            if(document.querySelector("#row"+localStorage.getItem('id_pintarrow_vi'))){
                document.querySelector("#row"+localStorage.getItem('id_pintarrow_vi')).className='alert alert-success';
            }  
        }

    }

    var carrito = new Carrito1();
    var view = new CarritoView();
    var render = new render();

    document.addEventListener("DOMContentLoaded", async function(){
        await carrito.constructor();
    
        render.RenderTableComp();
        document.querySelector("#fec_llegada").value= render.fechaA();
        
    });

    document.querySelector('#buscador_comp_text').addEventListener("keyup", async function(ev){
        render.RenderTableComp();
  
    });
    
    $('#catalogo').addEventListener("click", async function(ev){
        await carrito.update_listas();
        await  view.renderCarritoIn();
        await view.renderCarritoIn2();
        view.render_fila(); 
        
        if(ev.target.id=='page'){
            render.RenderTableComp(ev.target.dataset.page);
            carrito.constructor();
            //view.render_fila();
        }

        if(ev.target.id=="addItem"){
            cant=document.getElementById("salida"+ev.target.dataset.producto).value;
            if(cant>0 || cant==""){
                carrito.agregarItem(ev.target.dataset.producto,cant);
            }else{
                render.Alert("Campo restringido: ","cantidad mayor a cero, verificar ","alert2");  
            }
            view.renderCarritoIn();
            view.renderCarritoIn2();
            carrito.numrowsCarrito();
            //Pintar fila agregada
            localStorage.setItem('id_pintarrow_vi',ev.target.dataset.producto);
            view.render_fila();  
        }

    });
  
    $('#productosCarrito').addEventListener("click",function(ev){
        ev.preventDefault();
        if(ev.target.id == "deleteProducto"){
            carrito.eliminarItemCI(ev.target.dataset.producto);
            carrito.constructor();
            view.renderCarritoIn();
            view.renderCarritoIn2();
            carrito.numrowsCarrito();
            view.render_fila();
        }
    });

    $('#productosCarrito2').addEventListener("click",function(ev){
        ev.preventDefault();
        if(ev.target.id == "deleteProductoc2"){
            carrito.eliminarItemCI2(ev.target.dataset.productoc2);
            view.renderCarritoIn2();
            carrito.numrowsCarrito();
        }
        if(ev.target.id == "varciarCarrito2"){
            console.log(ev.target.id);
            carrito.varciarCarrito2();
            view.renderCarritoIn2();
            carrito.numrowsCarrito();
            localStorage.setItem("validar_carrito2",'false');
        }
    });

    $("#varciarCarrito").addEventListener("click",function(ev){
        ev.preventDefault();
        carrito.varciarCarrito();
        view.renderCarritoIn();
        carrito.numrowsCarrito();
        view.render_fila();
    });

 
    $('#documento').addEventListener("change",function(ev){
        ev.preventDefault();
        console.log(document.querySelector('#documento').value);
        let documento=document.querySelector('#documento').value;
        if(documento==1){
            document.querySelector('#card_remitente').setAttribute("style","visibility:hidden"); 
        }else if(documento==2){
            document.querySelector('#card_remitente').setAttribute("style","visibility:true");
        }else{
            document.querySelector('#card_remitente').setAttribute("style","visibility:hidden"); 
        }
    });

    
    $("#btnvale").addEventListener("click",function(ev){
        let personal = $("#personal").value;
        let documento=document.querySelector('#documento').value;
        console.log(documento);
        if(documento == ""){
            ev.preventDefault();
            render.Alert("(*) Campo obligatorio: ","Seleccione documento","alert1");     
        }
        if(personal.length==0 && documento == 2){
            ev.preventDefault();
            render.Alert("(*) Campo obligatorio: ","Seleccione la persona que remite la devolucion","alert1");     
        }
        if(document.querySelector('#carrito2')==null && localStorage.getItem(ls_carritoIn2)!='[]' ){
            ev.preventDefault();
            view.renderCarritoIn2();
            carrito.update_listas();
            render.Alert("Datos pendientes: "," ;) tenias una lista pendiente, prosigue","alert3"); 
        }

        if(localStorage.getItem(ls_carritoIn)=='[]' && localStorage.getItem(ls_carritoIn2)=='[]'){
            ev.preventDefault();
            view.renderCarritoIn();
            view.renderCarritoIn2();
            carrito.update_listas(); 
            render.Alert("Vale existente: ","Los productos han sido registrados en otra pagina, se vaciará el carrito y se actualizara la pagina","alert1");
            setTimeout(function(){
                window.location.reload(1);
             }, 4000);
        }
    });
})();