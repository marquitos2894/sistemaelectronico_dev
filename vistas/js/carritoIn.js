(async function(){
    //funcion reutilizable para seleccionar elementos del dom
    function $(selector){
        return document.querySelector(selector);
    }


    function Carrito1(){

        this.constructor = async function(){

                if(!localStorage.getItem("carritoIn") ){
                    localStorage.setItem("carritoIn","[]");             
                }
  
                let id_almacen = $('#id_alm_vi').value;
                const datos = new FormData();
                datos.append('id_alm_consulta', id_almacen);
                let response = await fetch('../ajax/almacenAjax.php',{
                    method : 'POST',
                    body :  datos
                });
                let data = await response.json();
            
                await localStorage.setItem('BDproductos',JSON.stringify(data));
                this.getBDproductos = await JSON.parse(localStorage.getItem('BDproductos'));

                this.getCarritoIn = await JSON.parse(localStorage.getItem('carritoIn'));
                await view.renderCarritoIn();

                await this.numrowsCarrito();
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
                     console.log(cant);
                    if(cant == ""){
                     i.cantidad = parseFloat(i.cantidad)+1;
                    }else{
                        i.cantidad = cant;
                    }
                     localStorage.setItem("carritoIn",JSON.stringify(this.getCarritoIn)); 
                     return;
                }
            }

            if(cant == ""){
                datos.cantidad = 1;
            }else{
            datos.cantidad = cant;
            }

            this.getCarritoIn.push(datos);
            localStorage.setItem("carritoIn",JSON.stringify(this.getCarritoIn));          
        }


        this.eliminarItemCI = function(item){
            for(i in this.getCarritoIn){
                if(this.getCarritoIn[i].id_ac == item){
                    this.getCarritoIn.splice(i,1);
                    console.log("eliminado")
                }
            }
            localStorage.setItem("carritoIn", JSON.stringify(this.getCarritoIn));     
        }

        this.varciarCarrito = function(){
            this.getCarritoIn.splice(0);
            localStorage.setItem('carritoIn','[]');
        }

        this.numrowsCarrito = function(){
            if(this.getCarritoIn.length>0){
                document.querySelector('#btnvale').disabled = false;
            }else{
                document.querySelector('#btnvale').disabled = true;
            }
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

        this.Alert = function (title,mensaje){
            let template = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>${title}</strong>${mensaje}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `;
            document.querySelector("#alert").innerHTML = template;
        }

        
    }

    function CarritoView(){

        this.renderCarritoIn = function(){
            if(carrito.getCarritoIn.length<=0){
                var template = `<div class="alert alert-success" role="alert">
                El carrito esta vacio !!
                </div><br>`;
                $("#productosCarrito").innerHTML = template;
            }else {
                $("#productosCarrito").innerHTML = "";   
                var template = `<div class="table-responsive"><table class="table table-bordered">
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
                </thead><tbody>`;
                let j = 1;
                for(i of carrito.getCarritoIn){
                  template +=`
                    <tr class="alert alert-success">
                        <td>${j}</td>
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
                        <input type="hidden" name="dv_codigo[]" value="${i.codigo}">
                        <input type="hidden" name="dv_descripcion[]" value="${i.descripcion}">
                        <input type="hidden" name="dv_nparte1[]" value="${i.nparte1}">
                        <input type="hidden" name="dv_stock[]" value="${i.stock}">
                        <input type="hidden" name="dv_ingreso[]" value="${i.cantidad}">
                        <input type="hidden" name="dv_id_equipo[]" value="${i.Id_Equipo}">
                        <input type="hidden" name="dv_nom_equipo[]" value="${i.alias_equipounidad}">
                        <input type="hidden" name="dv_referencia[]" value="${i.Referencia}">
                        <input type="hidden" name="dv_unombre[]" value="${i.u_nombre}">
                        <input type="hidden" name="dv_useccion[]" value="${i.u_seccion}"></tr><div>`;
                j+=1;
                }
                $("#productosCarrito").innerHTML = template;            
            }
        }

    }


    var carrito = new Carrito1();
    var view = new CarritoView();
    var render = new render();

    document.addEventListener("DOMContentLoaded", async function(){
        await carrito.constructor();
        await console.log("constructor");
        render.RenderTableComp();
    });

    
    document.querySelector('#buscador_comp_text').addEventListener("keyup", async function(ev){
        render.RenderTableComp();
        //carrito.numrowsCarrito();
    });
    
    $('#catalogo').addEventListener("click",function(ev){
        if(ev.target.id=='page'){
            render.RenderTableComp(ev.target.dataset.page);
        }

        if(ev.target.id=="addItem"){
            //console.log(ev.target);
            cant=document.getElementById("salida"+ev.target.dataset.producto).value;
            carrito.agregarItem(ev.target.dataset.producto,cant);
            view.renderCarritoIn();
            carrito.numrowsCarrito();          
        }
    });
  
    $('#productosCarrito').addEventListener("click",function(ev){
        ev.preventDefault();
        if(ev.target.id == "deleteProducto"){
            carrito.eliminarItemCI(ev.target.dataset.producto);
            view.renderCarritoIn();
            carrito.numrowsCarrito();
        }
    });

    $("#varciarCarrito").addEventListener("click",function(ev){
        ev.preventDefault();
        carrito.varciarCarrito();
        view.renderCarritoIn();
        carrito.numrowsCarrito();
    });

    //card_remitente
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
            render.Alert("(*) Campo obligatorio: ","Seleccione documento");     
        } 
     

        if(personal.length==0 && documento == 2){
            ev.preventDefault();
            render.Alert("(*) Campo obligatorio: ","Seleccione la persona que remite la devolucion");     
        } 
     
    });


   /*window.addEventListener("onload", async function(e) {
        
        //await carrito.constructor();
        //$("#bdcomponentes").innerHTML = await render.Renderbd();
        console.log(this.getBDproductos = await JSON.parse(localStorage.getItem('BDproductos')) );
        await render.Renderbd(this.getBDproductos);
        console.log("window");
    });*/



})();