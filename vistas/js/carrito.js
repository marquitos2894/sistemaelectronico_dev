(function(){
    //funcion reutilizable para seleccionar elementos del dom
    function $(selector){
        return document.querySelector(selector);
    }

    function Carrito1(){

        this.constructor = async function(){
                if(!localStorage.getItem("carritoS")){
                    localStorage.setItem('carritoS','[]');
                }

                let id_almacen = $('#id_alm_vs').value;
                const datos = new FormData();
                datos.append('id_alm_consulta', id_almacen);
                let response = await fetch('../ajax/almacenAjax.php',{
                    method : 'POST',
                    body :  datos
                });
                let data = await response.json();
                                    
                await localStorage.setItem('BDproductos',JSON.stringify(data)); 
                this.getBDproductos = await JSON.parse(localStorage.getItem('BDproductos')); 
            
                this.getCarritoS = JSON.parse(localStorage.getItem("carritoS"));
                await view.renderCarritoS();            
                await this.numrowsCarrito();
        }

        this.agregarItemCarritoS = function(item,valor){
            var existe = false;
            if(!this.getBDproductos || this.getCarritoS==null ){
                location.reload();
            }

            for(i of this.getBDproductos){
                if(i.id_ac == item){
                    var registro = i;
                    var stock = i.stock;
                    existe=true;         
                }
            }
            
            if(existe == false){
                location.reload();
                return;
            }
      
            if(!registro){
                return;
            }
           
            for(i of this.getCarritoS){                   
                if(i.id_ac == item){                     
                    if(parseFloat(valor) > parseFloat(i.stock)){
                        i.cantidad = i.stock;
                    }else if(valor==""){
                        if(i.cantidad<stock){  
                        i.cantidad = parseFloat(i.cantidad) + 1;
                        valor = i.cantidad;
                        }else{
                            i.cantidad = i.stock;
                            valor = parseFloat(i.cantidad)+parseFloat(registro.j);                        
                            registro.j = registro.j +1;
                        }                         
                    }else{
                        i.cantidad=valor;                           
                    }                       
                    i.solicitado = valor;
                    //registro.solicitado = valor;
                    //i.cantidad=parseFloat(i.cantidad) + parseFloat(valor);
                    localStorage.setItem("carritoS", JSON.stringify(this.getCarritoS));
                    return;
                }
            }
            
            if(parseFloat(stock)==0){
                alert("Item fuera de stock");
                return;
            }
            else if(parseFloat(valor) > parseFloat(stock)){
                registro.cantidad=stock
            }else if(valor==""){
                registro.cantidad=1
                registro.j=1;
                valor = 1;
            }else{
                registro.cantidad=valor                                 
            }

            registro.solicitado = valor;
            //registro.cantidad = valor;
            this.getCarritoS.push(registro);
            localStorage.setItem("carritoS", JSON.stringify(this.getCarritoS));
            return;
        }

        this.eliminarItemCS = function(item){
            for(i in this.getCarritoS){
                if(this.getCarritoS[i].id_ac == item){
                    this.getCarritoS.splice(i,1);
                    console.log("eliminado")
                }
            }
            localStorage.setItem("carritoS", JSON.stringify(this.getCarritoS));
            return;
        }

        this.varciarCarrito = function(){
            this.getCarritoS.splice(0);
            localStorage.setItem('carritoS','[]');
        }
        
        this.numrowsCarrito = function(){
                let personal = document.querySelector("#personal").value;
                console.log(personal.length);
            if(this.getCarritoS.length>0){
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
            //console.log(data);
    
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

        this.renderCarritoS = function(){
            if(carrito.getCarritoS.length <= 0){
                var template = `<div class="alert alert-danger" role="alert">
                El carrito esta vacio !!
                </div><br>`;
                $("#productosCarrito").innerHTML = template;
            }else{
                $("#productosCarrito").innerHTML = "";   
                let template = `<div class="table-responsive"><table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cod</th>
                        <th scope="col">Descriocion</th>
                        <th scope="col">Nparte</th>
                        <th scope="col">NSerie</th>
                        <th scope="col">Referencia</th>
                        <th scope="col">Ubicacion</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Solicitado</th>
                        <th scope="col">Entregado</th>
                        <th scope="col">Quitar</th>
                    </tr>
                </thead><tbody>`;
                let j=1;
                for(i of carrito.getCarritoS){
                    template += `
                        <tr class="alert alert-danger">
                            <td>${j}</td>
                            <td>${i.id_comp}</td>
                            <td>${i.descripcion}</td>
                            <td>${i.nparte1}</td>
                            <td>${i.nserie}</td>
                            <td>${i.Referencia}</td>
                            <td>${i.u_nombre}-${i.u_seccion}</td>
                            <td><strong>${i.stock} ${i.abreviado}</strong></td>
                            <td>${i.solicitado}</td>
                            <td>${i.cantidad}</td>
                            <td><p class="field"><a href="#" class="button is-danger" id="deleteProducto" data-producto="${i.id_ac}">x</a></p></td>
                        </tr>
                        <div style="display:none;">
                        <tr>
                        <input type="hidden" name="id_ac_vale_salida[]" value="${i.id_ac}">
                        <input type="hidden" name="dv_codigo[]" value="${i.codigo}">
                        <input type="hidden" name="dv_descripcion[]" value="${i.descripcion}">
                        <input type="hidden" name="dv_nparte1[]" value="${i.nparte1}">
                        <input type="hidden" name="dv_stock[]" value="${i.stock}">
                        <input type="hidden" name="dv_solicitado[]" value="${i.solicitado}">
                        <input type="hidden" name="dv_entregado[]" value="${i.cantidad}">
                        <input type="hidden" name="dv_unombre[]" value="${i.u_nombre}">
                        <input type="hidden" name="dv_useccion[]" value="${i.u_seccion}"></tr><div>
                    `;
                    j++;
                }
                template  += `</tbody></table></div>`;    
                $('#productosCarrito').innerHTML=template;
            }
     
        }

    }

    var carrito = new Carrito1();
    var view = new CarritoView();
    var render = new render();

    document.addEventListener("DOMContentLoaded", async function(){
        carrito.constructor();
        console.log("constructor");
        render.RenderTableComp();
        //carrito.numrowsCarrito();
 
    });


    document.querySelector('#buscador_comp_text').addEventListener("keyup", async function(ev){
        render.RenderTableComp();
        carrito.numrowsCarrito();
    });
    

    $("#catalogo").addEventListener("click",function(ev){

        if(ev.target.id=='page'){
            render.RenderTableComp(ev.target.dataset.page);
        }

        if(ev.target.id=="addItem"){
        console.log(ev.target);                    
        cant=document.getElementById("salida"+ev.target.dataset.producto).value;
        carrito.agregarItemCarritoS(ev.target.dataset.producto,cant);
        view.renderCarritoS();
        carrito.numrowsCarrito();   
        }   
    }); 

    $('#productosCarrito').addEventListener("click",function(ev){
        ev.preventDefault();
        if(ev.target.id == "deleteProducto"){
            carrito.eliminarItemCS(ev.target.dataset.producto);
            view.renderCarritoS();
            carrito.numrowsCarrito();
        }

    });


    $("#btnvale").addEventListener("click",function(ev){
        
        let personal = $("#personal").value;
        if(personal.length==0){
            ev.preventDefault();
            render.Alert("(*) Campo obligatorio: ","Seleccione la persona que solicita el repuesto");     
        } 
     
    });

    $("#varciarCarrito").addEventListener("click",function(ev){
        ev.preventDefault();
        carrito.varciarCarrito();
        view.renderCarritoS();
        carrito.numrowsCarrito();
    });

})();