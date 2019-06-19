(function(){
    //funcion reutilizable para seleccionar elementos del dom
    function $(selector){
        return document.querySelector(selector);
    }




/*    async function ver(){

        //const datos = new FormData();
        //datos.append('id_alm', '1');
        /*let response1 =  await fetch('../ajax/almacenAjax.php?id_alm=1');
        let user = await response1.json();
        return user;

        const datos = new FormData();
        datos.append('id_alm', '1');
        let response = await fetch('../ajax/almacenAjax.php',{
            method : 'POST',
            body :  datos
        });
        let data = await response.json();
       
}*/

    function Carrito1(){

        this.constructor = async function(){

                if(!localStorage.getItem("carritoS")){
                    localStorage.setItem('carritoS','[]');
                }

                if(!localStorage.getItem("BDproductos") || localStorage.getItem("BDproductos")=="[]"){
                    const datos = new FormData();
                    datos.append('id_alm', '1');
                    let response = await fetch('../ajax/almacenAjax.php',{
                        method : 'POST',
                        body :  datos
                    });
                    let data = await response.json();
                    console.log("json")
                    await localStorage.setItem('BDproductos',JSON.stringify(data)); 
                    this.getBDproductos = await JSON.parse(localStorage.getItem('BDproductos')); 
                    console.log("localStorage")
                    await render.Renderbd(this.getBDproductos);
                    console.log("render")

                    this.getBDproductos = JSON.parse(localStorage.getItem('BDproductos'));
                    this.getCarritoS = JSON.parse(localStorage.getItem("carritoS"));
                    
                    view.renderCarritoS(); 
                    console.log("carritoin");
                    console.log(this.getBDproductos);
                    console.log(this.getCarritoS);
            

                }else{

                    this.getBDproductos = await JSON.parse(localStorage.getItem('BDproductos'));
                    render.Renderbd(this.getBDproductos);

                    this.getBDproductos = JSON.parse(localStorage.getItem('BDproductos'));
                    this.getCarritoS = JSON.parse(localStorage.getItem("carritoS"));
                    
                    view.renderCarritoS(); 
                    console.log("carritoin");
                    console.log(this.getBDproductos);
                    console.log(this.getCarritoS);
                }
                
                
                /*if(!localStorage.getItem("BDproductos") || localStorage.getItem("BDproductos")=="[]"){
                    /* Promisse */
                    /*const datos = new FormData();
                    datos.append('id_alm', '1');
                    let response = await fetch('../ajax/almacenAjax.php',{
                        method : 'POST',
                        body :  datos
                    }) 
                    .then(res =>  res.json())
                    .then(data =>{                      
                        localStorage.setItem('BDproductos',JSON.stringify(data));
                    });*/
                    
                    /* Async await */
                    /*const datos = new FormData();
                    datos.append('id_alm', '1');
                    let response = await fetch('../ajax/almacenAjax.php',{
                        method : 'POST',
                        body :  datos
                    });
                    let data = await response.json();
                    localStorage.setItem('BDproductos',JSON.stringify(data));           
            } */
        }

  




        this.agregarItemCarritoS = function(item,valor){
            
            if(!this.getBDproductos || this.getCarritoS==null ){
                location.reload();
            }

    

            for(i of this.getBDproductos){
                if(i.id_ac == item){
                    var registro = i;
                    var stock = i.stock;      
                }
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
        
    }
    function render(){
        
        this.Renderbd = function (lista){
            let template = ``;
            let j = 1;
            for(i of lista){

            template += `
              <tr>
                <td>${j}</td>
                <td>${i.codigo}</td>
                <td>${i.descripcion}</td>
                <td>${i.nparte1}</td>
                <td>${i.Nombre_Equipo}</td>
                <td>${i.u_nombre}-${i.u_seccion}</td>
                <td>${i.unidad_med}</td>
                <td>${i.stock}</td>
                <td><input type='number' id='salida${i.id_ac}' /></td>
                <td> <a href='#' class='card-footer-item' id='addItem' data-producto='${i.id_ac}'>+</a></td>
              </tr>
                `;
                j++;
            }
            $("#bdcomponentes").innerHTML = template;       
        }
    }

    function CarritoView(){

        this.renderCarritoS = function(){
            if(carrito.getCarritoS.length <= 0){
                var template = `<div class="alert alert-danger" role="alert">
                El carrito esta vacio !!
                </div><br>`;
                $("#productosCarritoS").innerHTML = template;
            }else{
                $("#productosCarritoS").innerHTML = "";   
                let template = `<div class="table-responsive"><table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cod.Interno</th>
                        <th scope="col">Descriocion</th>
                        <th scope="col">Nparte</th>
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
                            <td>${i.codigo}</td>
                            <td>${i.descripcion}</td>
                            <td>${i.nparte1}</td>
                            <td>${i.u_nombre}-${i.u_seccion}</td>
                            <td><strong>${i.stock}</strong></td>
                            <td>${i.solicitado}</td>
                            <td>${i.cantidad}</td>
                            <td><p class="field"><a href="#" class="button is-danger" id="deleteProducto" data-producto="${i.id_ac}">x</a></p></td>
                        </tr>
                        <div style="display:none;">
                        <tr>
                        <input type="hidden" name="id_ac[]" value="${i.id_ac}">
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
                $('#productosCarritoS').innerHTML=template;
            }
     
        }

    }


    var carrito = new Carrito1();
    var view = new CarritoView();
    var render = new render();

    document.addEventListener("DOMContentLoaded",function(){
        carrito.constructor();
        //view.renderCarritoS(); 
    });


    $("#catalogo").addEventListener("click",function(ev){
        if(ev.target.id=="addItem"){
        console.log(ev.target);                    
        cant=document.getElementById("salida"+ev.target.dataset.producto).value;
        carrito.agregarItemCarritoS(ev.target.dataset.producto,cant);
        view.renderCarritoS();
        //carrito_view.TotalProductos();
        //console.log(ev.target.value) 
        }   
    }); 

    $('#productosCarritoS').addEventListener("click",function(ev){
        ev.preventDefault();
        if(ev.target.id == "deleteProducto"){
            carrito.eliminarItemCS(ev.target.dataset.producto);
            view.renderCarritoS();
        }

    });

})();