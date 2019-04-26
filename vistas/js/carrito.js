(function(){
    //funcion reutilizable para seleccionar elementos del dom
    function $(selector){
        return document.querySelector(selector);
    }


    function Carrito() {

        /*this.catalogo = [{id:'P01',nombre:'Lapiz',precio:5,imagen:'lapiz.jpg',descripcion:'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'},
                        {id:'P02',nombre:'Colores',precio:50,imagen:'colores.jpg',descripcion:'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'},
                        {id:'P03',nombre:'Libreta',precio:30,imagen:'libreta.jpg',descripcion:'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'},
                        {id:'P04',nombre:'Mochila',precio:500,imagen:'mochila.jpg',descripcion:'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'},
                        {id:'P06',nombre:'Pluma',precio:7.50,imagen:'pluma.jpg',descripcion:'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'},
                        {id:'P07',nombre:'Plumon',precio:20,imagen:'plumon.jpg',descripcion:'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'},
                        {id:'P08',nombre:'Regla',precio:10,imagen:'regla.png',descripcion:'Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'}];*/
    
       
        this.constructor = function(){
            if(!localStorage.getItem("carrito")){
                localStorage.setItem('carrito','[]');
            }
        }

        this.getCarrito = JSON.parse(localStorage.getItem("carrito"));

        this.agregarItem = function(item,componentes,valor){
                
                for(i of componentes){
                    if(i.id == item){
                    var registro = i;
                    var stock = i.stock;
                    }
                }
                if(!registro){
                    return;
                }

                for(i of this.getCarrito){
                     
                    if(i.id == item){
                        if(parseFloat(valor) > parseFloat(i.stock)){
                            i.cantidad = i.stock;
                        }else{
                            i.cantidad=valor;                           
                        }

                        i.solicitado = valor;
                        //registro.solicitado = valor;
                        //i.cantidad=parseFloat(i.cantidad) + parseFloat(valor);
                        localStorage.setItem("carrito", JSON.stringify(this.getCarrito));
                        return;
                    }
                }

                if(parseFloat(valor) > parseFloat(i.stock)){
                    registro.cantidad=stock
                }else{
                    registro.cantidad=valor                                 
                }

                registro.solicitado = valor;
                //registro.cantidad = valor;
                this.getCarrito.push(registro);
                localStorage.setItem("carrito", JSON.stringify(this.getCarrito));
                return;
            }

        this.eliminarItem = function(item){
            for(i in this.getCarrito){
                if(this.getCarrito[i].id_comp == item){
                    this.getCarrito.splice(i,1);
                    console.log("eliminado")
                }
            }
            localStorage.setItem("carrito", JSON.stringify(this.getCarrito));
        }
    }
    
    // esta funcion me simula una clase
    function Carrito_View(){
        //simula un metod o es u metodo
        /*this.renderCatalogo = function(componentes){
            console.log(componentes);
            let template = `<table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Descriocion</th>
                                        <th scope="col">Nparte</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Agregras</th>
                                    </tr>
                                </thead>
                                <tbody>`;
             let j=1;                   
            for(let i in componentes){
                //console.log(i);
               template += `
                    
                        <tr>
                            <th scope="row">${j}</th>
                            <td>${componentes[i].descripcion}</td>
                            <td>${componentes[i].nparte1}</td>
                            <td>${componentes[i].stock}</td>
                            <td> <a href="#" class="card-footer-item" id="addItem" data-producto="${componentes[i].id_comp}">+</a></td>
                        </tr>       
                `;
                j++;
            }
            template  += `</tbody></table>`;

            $('#catalogo').innerHTML = template;
        }*/

        /*this.showModal = function(){
            $("#modal").classList.toggle('is-active');
            this.renderCarrito();        
        }

        this.hideModal = function(ev){
            if(ev.target.classList.contains("toggle")){
                //$("#modal").classList.toggle('is-active');
                this.showModal();
            }
        }*/

        this.renderCarrito = function(){

            if(carrito.getCarrito.length <= 0){
                var template = `<div class="is-12"><p class="title is-1 has-text-centered">El carrito esta vacio</p></div><br>`;
                $("#productosCarrito").innerHTML = template;
            }else{
                $("#productosCarrito").innerHTML = "";   
                let template = `<div class="table-responsive"><table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
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
                for(i of carrito.getCarrito){
                    template += `
                        <tr>
                            <td>${j}</td>
                            <td>${i.descripcion}</td>
                            <td>${i.nparte1}</td>
                            <td>${i.u_nombre}-${i.u_seccion}</td>
                            <td><strong>${i.stock}</strong></td>
                            <td>${i.solicitado}</td>
                            <td>${i.cantidad}</td>
                            <td><p class="field"><a href="#" class="button is-danger" id="deleteProducto" data-producto="${i.id_comp}">delete</a></p></td>
                        </tr>
                        <div style="display:none; "><input type="hidden" name="id[]" value="${i.id_comp}">
                        <tr><input type="hidden" name="dv_descripcion[]" value="${i.descripcion}">
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

        this.TotalProductos = function(){
            var total = carrito.getCarrito.length;
            //$('#totalProductos> strong').innerHTML = total;
        }
    }


    //instaciamos la funcion Carrito
    var carrito = new Carrito();
    var carrito_view = new Carrito_View();

    document.addEventListener('DOMContentLoaded',function(){

                const datos = new FormData();
                datos.append('id_alm', '1');
                fetch('../ajax/almacenAjax.php',{
                    method : 'POST',
                    body :  datos
                })
                .then(res => res.json())
                .then(data =>{
                    //console.log(this.componentes = data);
                    for(i in data){
                        var reg = data;
                    }
                
                    //carrito_view.renderCatalogo(reg);
                    console.log(carrito.getCarrito);

                        $("#catalogo").addEventListener("click",function(ev){
                                if(ev.target.id=="addItem"){
                                console.log(ev.target)                          
                                cant=document.getElementById("salida"+ev.target.dataset.producto).value;
                                carrito.agregarItem(ev.target.dataset.producto,reg,cant);
                                carrito_view.renderCarrito();
                                //carrito_view.TotalProductos();
                                //console.log(ev.target.value) 
                                }
                        })
            
                    
                    $("#productosCarrito").addEventListener("click",function(ev){
                        ev.preventDefault();
                        if(ev.target.id == "deleteProducto"){
                            carrito.eliminarItem(ev.target.dataset.producto);
                            carrito_view.renderCarrito();
                            //carrito_view.TotalProductos();
                        }
                    });
                
                });
                carrito.constructor();
                carrito_view.renderCarrito();
    
    });



})();