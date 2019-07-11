(async function(){
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

                if(!localStorage.getItem("carritoIn") ){
                    localStorage.setItem("carritoIn","[]");             
                }
  
               /*if(!localStorage.getItem("BDproductos") ){
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
                    
                    /*Async await*/
                    /*const datos = new FormData();
                    datos.append('id_alm', '1');
                    let response = await fetch('../ajax/almacenAjax.php',{
                        method : 'POST',
                        body :  datos
                    });
                    let data = await response.json();
                    console.log(data);
                    //render.Renderbd(data);
                    render.Renderbd(this.getBDproductos);
                    localStorage.setItem('BDproductos',JSON.stringify(data));      
                }*/

                //if(!localStorage.getItem("carritoIn") || localStorage.getItem("carritoIn")=="[]"){
                if(!localStorage.getItem("BDproductos") || localStorage.getItem("BDproductos")=="[]"){

                    let id_almacen = $('#id_alm_vi').value;
                    console.log(id_almacen);
                    const datos = new FormData();
                    datos.append('id_alm', id_almacen);
                    let response = await fetch('../ajax/almacenAjax.php',{
                        method : 'POST',
                        body :  datos
                    });
                    let data = await response.json();
                    console.log(data);
                    console.log("json");
                    await localStorage.setItem('BDproductos',JSON.stringify(data));
                    
                    this.getBDproductos = await JSON.parse(localStorage.getItem('BDproductos')); 
                    console.log("localStorage");
                  
                    //render.Renderbd(data);
                    //await render.Renderbd(this.getBDproductos);
                    //await console.log("render");
           
                    //this.getBDproductos = JSON.parse(localStorage.getItem('BDproductos'));
                    this.getCarritoIn = await JSON.parse(localStorage.getItem('carritoIn'));
                    
                    await view.renderCarritoIn();
                    await console.log("carritoin");
                    await  console.log(this.getBDproductos);
                    await  console.log(this.getCarritoIn);

                    //await  console.log(this.getBDproductos.length);

                }else{

                    this.getBDproductos = await JSON.parse(localStorage.getItem('BDproductos'));
                    //await  render.Renderbd(this.getBDproductos);
                    //console.log("render")
                    //render.Renderbd(data);
                    console.log(this.getBDproductos.length);

                    //this.getBDproductos = JSON.parse(localStorage.getItem('BDproductos'));
                    this.getCarritoIn =  JSON.parse(localStorage.getItem('carritoIn'));

                    view.renderCarritoIn();
                    console.log("carritoin");
                    //console.log(this.getBDproductos);
                    console.log(this.getCarritoIn);
                }
                
        }

        this.agregarItem = function(item,cant){
            /*if(!this.getBDproductos || this.getCarritoIn==null){
                location.reload();
            }*/
        
            for(i of this.getBDproductos){
                if(i.id_ac == item){
                   var datos = i;          
                   //i.cant = parseFloat(i.cant) + 1;
                }
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
          
    }

    function render(){

            this.Renderbd =  function (lista){ 
                console.log("render dentro");  
                var template = `
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cod.Interno</th>
                            <th>Descripcion</th>
                            <th>Nparte1</th>
                            <th>Equipo</th>
                            <th>Ubicacion</th>
                            <th>U.M</th>
                            <th>Stock</th>
                            <th>Ingreso</th>
                            <th>Add</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Cod.Interno</th>
                            <th>Descripcion</th>
                            <th>Nparte1</th>
                            <th>Equipo</th>
                            <th>U.M</th>
                            <th>Stock</th>
                            <th>Ingreso</th>
                            <th>Add</th>
                        </tr>
                    </tfoot>
                    <tbody>`;
                let j = 1;
                for(i of lista){
                    template += `
                    <tr>
                        <td>${j}</td>
                        <td>${i.id_comp}</td>
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
                template += `
                    </tbody>
                </table>`;
                $("#tablecomp").innerHTML = template;

                //return template;
            
            }
        
    }

    function CarritoView(){

        this.renderCarritoIn = function(){

            if(carrito.getCarritoIn.length<=0){
                var template = `<div class="alert alert-success" role="alert">
                El carrito esta vacio !!
                </div><br>`;
                $("#productosCarritoIn").innerHTML = template;
            }else {
                $("#productosCarritoIn").innerHTML = "";   
                var template = `<div class="table-responsive"><table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Cod.Interno</th>
                        <th scope="col">Descriocion</th>
                        <th scope="col">Nparte</th>
                        <th scope="col">Ubicacion</th>
                        <th scope="col">Stock</th>
                        <th scope="col">U.M</th>
                        <th scope="col">Equipo</th>
                        <th scope="col">Ingreso</th>
                        
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
                        <td>${i.u_nombre}-${i.u_seccion}</td>
                        <td>${i.stock}</td>
                        <td>${i.unidad_med}</td>
                        <td>${i.Nombre_Equipo}</td>
                        <td>${i.cantidad}</td>
                        <td><p class="field"><a href="#" class="button is-danger" id="deleteProducto" data-producto="${i.id_ac}">x</a></p></td></tr>
                        <div style="display:none;">
                        <tr>
                        <input type="hidden" name="id_ac[]" value="${i.id_ac}">
                        <input type="hidden" name="dv_codigo[]" value="${i.codigo}">
                        <input type="hidden" name="dv_descripcion[]" value="${i.descripcion}">
                        <input type="hidden" name="dv_nparte1[]" value="${i.nparte1}">
                        <input type="hidden" name="dv_stock[]" value="${i.stock}">
                        <input type="hidden" name="dv_ingreso[]" value="${i.cantidad}">
                        <input type="hidden" name="dv_id_equipo[]" value="${i.Id_Equipo}">
                        <input type="hidden" name="dv_nom_equipo[]" value="${i.Nombre_Equipo}">
                        <input type="hidden" name="dv_unombre[]" value="${i.u_nombre}">
                        <input type="hidden" name="dv_useccion[]" value="${i.u_seccion}"></tr><div>`;
                j+=1;
                }
                $("#productosCarritoIn").innerHTML = template;            
            }
        }

    }


    var carrito = new Carrito1();
    var view = new CarritoView();
    var render = new render();



    document.addEventListener("DOMContentLoaded", async function(){
        await carrito.constructor();
        await console.log("constructor");

    });

 
    $('#productosin').addEventListener("click",function(ev){
        if(ev.target.id=="addItem"){
            //console.log(ev.target);
            cant=document.getElementById("salida"+ev.target.dataset.producto).value;
            carrito.agregarItem(ev.target.dataset.producto,cant);
            view.renderCarritoIn();          
        }
    });
  
    $('#productosCarritoIn').addEventListener("click",function(ev){
        ev.preventDefault();
        if(ev.target.id == "deleteProducto"){
            carrito.eliminarItemCI(ev.target.dataset.producto);
            view.renderCarritoIn();
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