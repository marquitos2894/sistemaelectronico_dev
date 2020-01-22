(function(){

    function Carrito(){

        this.contructor = async function(){
            if(!localStorage.getItem("carritoOC")){
                localStorage.setItem("carritoOC","[]");
            }

            if(!localStorage.getItem("BDcomp_gen")){
                localStorage.setItem("BDcomp_gen","[]");
            }

            valor='true';
            let datos = new FormData();
            datos.append('comp_gen',valor);
            try{
                let response = await fetch('../ajax/componentesAjax.php',{
                    method:'POST',
                    body:datos
                });
                var data = await response.json();
            }catch(err){
                console.log('fetch failed', err);
            }

            await localStorage.setItem("BDcomp_gen", JSON.stringify(data));
            this.getBDcomp_gen = JSON.parse(localStorage.getItem("BDcomp_gen"));
            this.carritoOC = JSON.parse(localStorage.getItem("carritoOC")); 
            console.log(this.getBDcomp_gen);
            console.log(this.carritoOC);
            this.renderCarritoOC();

        }

        this.agregar = function(item,cant,precio,desc,nparte1,nparte2){
            
            var existe = false;
            //var registro = {};

            /* para obtener un identificador unico por cada item(nolinea) */
            var lineas = []; j=0;
            for(i in this.carritoOC){
                lineas[j] = this.carritoOC[i].nolinea;
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

            if(item==1){
                
                existe = true;

                registro.nolinea = max;
                registro.id_comp=item;
                registro.descripcion = desc;
                registro.nparte1 = nparte1;
                registro.nparte2=nparte2;
                registro.cant=cant;
                registro.precio=precio;
                registro.total=cant*precio;

                this.carritoOC.push(registro);
                console.log(this.carritoOC);
                localStorage.setItem("carritoOC",JSON.stringify(this.carritoOC));
                return;

            }else{
                for(var i in this.getBDcomp_gen){
                    if(this.getBDcomp_gen[i].id_comp==item){
                        registro = this.getBDcomp_gen[i];
                        existe = true;
                        break;
                    }
                }
            }

            if(existe == false){
                location.reload();
                return;
            }

            for(c of this.carritoOC){
                if(c.id_comp == item){

                    //c.cant++;
                    c.cant= parseFloat(c.cant) + parseFloat(cant);
                    //c.precio=parseFloat(c.precio);
                    c.total = parseFloat(c.cant) * parseFloat(c.precio);
                    console.log(this.carritoOC);
                    localStorage.setItem("carritoOC",JSON.stringify(this.carritoOC));
                    return;
                }
            }

            registro.nolinea = max;
            registro.cant=cant;
            registro.precio=precio;
            registro.total=cant*precio;

            this.carritoOC.push(registro);
            console.log(this.carritoOC);
            localStorage.setItem("carritoOC",JSON.stringify(this.carritoOC));

        }

        this.renderCarritoOC = function(){
            var template = ``;
            if(this.carritoOC.length<=0){
                template = `<div class="alert alert-primary" role="alert">
                El carrito esta vacio !!
                </div><br>`;
                document.querySelector("#productos").innerHTML = template;
            }else{
                document.querySelector("#productos").innerHTML = "";
                template = `<div class="table-responsive"><table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Codigo</th>
                        <th scope="col">Descripcion</th>
                        <th scope="col">Npartes</th>
                        <th scope="col">Cant</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Total</th>
                        <th scope="col">Quitar</th>
                    </tr>
                </thead><tbody>`;
                let j=1;
                for(i of this.carritoOC){
                    template +=`
                    <tr class="alert alert-primary">
                    <td>${j}</td>
                    <td>${i.id_comp}</td>
                    <td>${i.descripcion}</td>
                    <td>${i.nparte1}</td>
                    <td>${i.cant}</td>
                    <td>${i.precio}</td>
                    <td>${i.total}</td>
                    <td><p class="field"><a href="#" class="button is-danger" id="deleteProducto" data-producto="${i.nolinea}">x</a></p></td>
                    </tr>
                    <div style="display:none;">
                        <tr>
                            <input type="hidden" name="id_comp[]" value="${i.id_comp}">
                            <input type="hidden" name="d_descripcion[]" value="${i.descripcion}">
                            <input type="hidden" name="d_nparte1[]" value="${i.nparte1}">
         
                        </tr>
                    <div>`;
                    j++;
                    document.querySelector("#productos").innerHTML = template;  
                }

            }
        }
        
    
    }

    function Consulta(){
        
        this.RenderTableComp = async function(page){
           
            let buscar = document.querySelector('#buscador_comp_text').value;
            let vista = document.querySelector('#vista').value
            let privilegio = document.querySelector('#privilegio').value
            let id_alm = document.querySelector('#id_alm').value
            const datos = new FormData();
            datos.append('buscarcompajax',buscar);
            datos.append('paginadorajax',page);
            datos.append('vistaajax',vista);
            datos.append('privilegioajax',privilegio);
            datos.append('fk_idalmajax',id_alm)

            let response = await fetch('../ajax/componentesAjax.php',{
                method : 'POST',
                body : datos
            })
            let data = await response.text();
            //console.log(data);


            document.querySelector('#componentes').innerHTML = data;
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

        
    }

    var Carrito = new Carrito();
    var Consulta = new Consulta(); 

    document.addEventListener("DOMContentLoaded", function(){

        Carrito.contructor();
       
        Consulta.RenderTableComp();

    })


    document.querySelector('#componentes').addEventListener("click",function(ev){

        if(ev.target.id=="addItem"){
            let id_comp = ev.target.dataset.producto;
            let cant = document.querySelector("#cant"+id_comp).value;
            let precio = document.querySelector("#precio"+id_comp).value;
            Carrito.agregar(id_comp,cant,precio);
            Carrito.renderCarritoOC();
        }

        if(ev.target.id=='page'){
            Consulta.RenderTableComp(ev.target.dataset.page);
        }

        if(ev.target.id=="addItem2"){
            let desc = document.querySelector("#desc").value;
            let nparte = document.querySelector("#nparte").value;
            let nparte2 = document.querySelector("#nparte2").value;
            let cant = document.querySelector("#cant").value;
            let precio = document.querySelector("#precio").value;


            console.log(desc);
            console.log(nparte);
            console.log(nparte2);
            console.log(cant);
            console.log(precio);

            Carrito.agregar(1,cant,precio,desc,nparte,nparte2);
            Carrito.renderCarritoOC();
        }

    })

    document.querySelector('#buscador_comp_text').addEventListener("keyup", async function(ev){
        Consulta.RenderTableComp();
    });


    
    
})();