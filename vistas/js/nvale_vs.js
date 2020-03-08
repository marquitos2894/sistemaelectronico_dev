(function(){

// In your Javascript (external .js resource or <script> tag)
   var personal=document.querySelector("#personal");
   var turno=document.querySelector("#turno");
   var fecha_despacho=document.querySelector("#fec_despacho");
   var id_almacen = document.querySelector('#id_alm').value;

   var id_usuario = document.querySelector('#id_usuario').value;

   var ls_CarritoVs = "CarritoVs"+"-"+id_usuario+"-"+id_almacen;
   var ls_BDproductos = "BDproductos"+"-"+id_usuario+"-"+id_almacen;
    
    function Carrito(){

        this.constructor = async function(){
            if(!localStorage.getItem(ls_CarritoVs)){
                localStorage.setItem(ls_CarritoVs,"[]")
            }

            
            const datos = new FormData();
            datos.append('id_alm_consulta', id_almacen);
            let response = await fetch('../ajax/almacenAjax.php',{
                method : 'POST',
                body :  datos
            });
            let data = await response.json();
            //console.log(data);

            await localStorage.setItem(ls_BDproductos,JSON.stringify(data)); 
            this.getBDproductos = await JSON.parse(localStorage.getItem(ls_BDproductos)); 
        
            this.getCarritoVs = JSON.parse(localStorage.getItem(ls_CarritoVs));
            render.renderCarrito();
            this.numrowsCarrito();
            render.render_fila(); 
        }

        this.AgregarProductos = function(id_ac,equipo,equipo_nom,cant,cambio,horometro,motivo){
            
            var existe = false;
            var dato = {};
            var cant =parseFloat(cant);
        
            for(i of this.getBDproductos){
                if(i.id_ac == id_ac){
                    var dato = i;
                    var stock = i.stock;
                    existe=true;         
                }
            }

            //console.log(this.getCarritoVs);

            if(existe == false){
                location.reload();
                return;
            }

            /* para obtener un identificador unico por cada item(nolinea) */
            var lineas = []; j=0;
            for(i in this.getCarritoVs){
                lineas[j] = this.getCarritoVs[i].nolinea;
                j++;
            }
           
            var max = Math.max(... lineas);
            if(max == '-Infinity'){
                max=0;
            }else{
                max = max+1;
            }

          
            
            localStorage.setItem('id_pintarrow_vs',max);
            
            //fin

            //Verificar el total de productos por item(id_ac) para validar el stock
            var tot=0;
            for(c of this.getCarritoVs){
                if(c.id_ac==id_ac){
                    tot+=parseFloat(c.cant);
                }
            }
            totalA=parseFloat(tot)+parseFloat(cant)
            //console.log(totalA);
            //fin

            /* ---- */
            /** item repetidos */    
            for(c of this.getCarritoVs){
               if(c.id_ac==id_ac){
                /*c.cant += c.cant;
                console.log(c.cant);*/
                var datoN = {};
                    for (var key in c) {
                        datoN[key] = c[key];                        
                    }
                    //
                    //Tcant = parseFloat(c.cant)+parseFloat(cant);

                    if(parseFloat(cant) > parseFloat(c.stock)){
                        datoN.cant  = c.stock;
                    }else{
                        datoN.cant=cant;                           
                    }
                    
                    //Valida el acumulado de la suma de los item en el carrito vs el stock
                    if(parseFloat(totalA)>parseFloat(c.stock)){
                        let dif = stock - totalA;
                        cant_valida=parseFloat(cant)  + parseFloat(dif);
                        console.log(cant_valida);
                        cant_valida = (cant_valida<=0)?cant_valida=0:cant_valida=cant_valida;
                        render.Alert(`Stock insuficiente: `,`La suma de las cantidades del item ${c.id_comp} superan el stock:(${c.stock}) , 
                        en el carrito tienes : ${totalA-cant} e intentas ingresar ${cant}, un total de ${totalA} ${c.abreviado}, 
                        cantidad valida para retirar es ${cant_valida}`,'msgmodal');
                        return;
                    }
                    
                    datoN.nolinea = max;
                    datoN.nequipo = equipo;
                    datoN.nequipo_nom = equipo_nom;
                    datoN.horometro = horometro;
                    datoN.motivo = motivo;
                    datoN.solicitado = cant;
                    datoN.cambio = cambio;
              
                    this.getCarritoVs.push(datoN);
                    localStorage.setItem(ls_CarritoVs,JSON.stringify(this.getCarritoVs));
                    datoN = {};
                    return;
                }
            }
            /***fin */
         
            /* Validar cantidad solicitada*/
            if(parseFloat(stock)==0){
                render.Alert(`Stock insuficiente: `,`producto fuera de stock`,'msgmodal');
                return;
            }
            else if(parseFloat(cant) > parseFloat(stock)){
                dato.cant=stock
            }else{
                dato.cant=cant;                                 
            }

            dato.nolinea = max;
            dato.nequipo = equipo;
            dato.nequipo_nom = equipo_nom;
            dato.horometro = horometro;
            dato.motivo = motivo;
            dato.solicitado = cant;
            dato.cambio = cambio;
            var datoX = dato;
            this.getCarritoVs.push(datoX);

            localStorage.setItem(ls_CarritoVs,JSON.stringify(this.getCarritoVs));
            
            return;
        }

        this.eliminarItem = function(item){
            for(i in this.getCarritoVs){
               
                if(this.getCarritoVs[i].nolinea == item){
                    this.getCarritoVs.splice(i,1);
                    
                }
            }
            localStorage.setItem("CarritoVs", JSON.stringify(this.getCarritoVs));
            return;
        }

        this.varciarCarrito = function(){
            this.getCarritoVs.splice(0);
            localStorage.setItem(ls_CarritoVs,'[]');
        }

        this.numrowsCarrito = function(){
            if(this.getCarritoVs.length>0){
                document.querySelector('#btnvale').setAttribute("style","display:true");
            }else{
                document.querySelector('#btnvale').setAttribute("style","display:none");
            }
        }
        
    }

    function Render(){
        this.renderCarrito = function(){
            let template = ``;

            let j=1;
            for(i of carrito.getCarritoVs){
                let cambio_t=(i.cambio==true)?`<i class="fas fa-exchange-alt"></i>`:``;
                template += `
            
                <tr id='row${i.nolinea}'>
                  <th scope="row">${j}</th>
                  <td>${i.id_comp}</td>
                  <td>${i.descripcion}</td>
                  <td>${i.nparte1}</td>
                  <td>${i.nserie}</td>
                  <td>${i.nequipo_nom}</td>
                  <td>${i.u_nombre}-${i.u_seccion}</td>
                  <td>${i.stock}</td>
                  <td>${i.cant}</td>
                  <td>${i.solicitado}</td>
                  <td>${cambio_t}</td>
                  <td><p  class="field"><a href="#" class="fas fa-minus-circle" style="font-size: 1em; color: red;" id="deleteProducto" data-producto="${i.nolinea}"></a></p></td>
                </tr>
                <div style="display:none;">
                    <tr>
                    <input type="hidden" name="id_ac_vale_salida[]" value="${i.id_ac}">
                    <input type="hidden" name="dv_codigo[]" value="${i.id_comp}">
                    <input type="hidden" name="dv_descripcion[]" value="${i.descripcion}">
                    <input type="hidden" name="dv_nparte1[]" value="${i.nparte1}">
                    <input type="hidden" name="dv_stock[]" value="${i.stock}">
                    <input type="hidden" name="dv_solicitado[]" value="${i.solicitado}">
                    <input type="hidden" name="dv_entregado[]" value="${i.cant}">
                    <input type="hidden" name="dv_unombre[]" value="${i.u_nombre}">
                    <input type="hidden" name="dv_useccion[]" value="${i.u_seccion}">
                    <input type="hidden" name="dv_idflota[]" value="${i.nequipo}">
                    <input type="hidden" name="dv_horometro[]" value="${i.horometro}">
                    <input type="hidden" name="dv_motivo[]" value="${i.motivo}">
                    <input type="hidden" name="dv_cambio[]" value="${i.cambio}">
                    </tr>
                <div>
                `;
                j+=1;
            }
            document.querySelector("#productos_carrito").innerHTML = template;
            render.render_fila(); 
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

        this.Alert = function (title,mensaje,div){
            let template = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>${title}</strong>${mensaje}.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            `;
            document.querySelector("#"+div).setAttribute("style","display:true");    
            document.querySelector("#"+div).innerHTML = template;
        }

        this.render_fila = function(){
            if(document.querySelector("#row"+localStorage.getItem('id_pintarrow_vs'))){
                document.querySelector("#row"+localStorage.getItem('id_pintarrow_vs')).className='alert alert-success';
            }
           
        }
    }
    function Consultas(){
        
        this.ConsultaStock = async function(id_ac){
            if(id_ac!=0){
                var datos = new FormData();
                datos.append("id_ac_consultastock",id_ac);
                let response = await fetch('../ajax/almacenAjax.php',{
                    method: 'POST',
                    body : datos
                });

                let data = await response.json();
                //console.log(data);
                document.querySelector("#stock").value = data[0].stock;
            }else{
                document.querySelector("#stock").value = 0; 
            }
        }

    }

    consultas = new Consultas();
    carrito = new Carrito();
    render = new Render();

    document.addEventListener("DOMContentLoaded", async function(){
       carrito.constructor();
       document.querySelector("#fec_despacho").value= render.fechaA();
       
    });

    //boton abrir modal
    $("#btnagregar").on('click',function(ev){
        
        //consultas.ConsultaStock(id_ac);
        document.querySelector("#Cantidad").value='1';
        document.querySelector("#horometro").value='0';
        document.querySelector("#motivo").value='';
        document.querySelector("#cambio").checked=false;
        document.querySelector("#stock").value = 0
        
        if(document.querySelector("#check_equipo").checked==false){
            $('#Equipo').val('0').change();  
        }

        document.querySelector('#btnadd').setAttribute("style","display:none");

        if(document.querySelector("#check_producto").checked==false){
            $('#Producto').val('0').change();
        }else{
            document.querySelector('#btnadd').setAttribute("style","display:true");
            let id_ac=document.querySelector("#Producto").value;
            consultas.ConsultaStock(id_ac);
        }
        carrito.numrowsCarrito();
        document.querySelector('#div_horometro').setAttribute("style","display:none");
        
        document.querySelector('#msgmodal').setAttribute("style","display:none");

    });

    document.querySelector("#modalProductos").addEventListener("click",function(ev){
        if(ev.target.id=="btnadd"){
            id_ac=document.querySelector("#Producto").value;
            equipo = document.querySelector("#Equipo").value;
            id_flota = equipo;
            nom_equipo = document.querySelector("#Equipo").selectedOptions;
            nom_equipo = nom_equipo[0].label;
            cant= document.querySelector("#Cantidad").value;
            cambio=document.querySelector("#cambio").checked;
            horometro=document.querySelector("#horometro").value;
            motivo=document.querySelector("#motivo").value;

            if(document.querySelector("#Equipo").value==0){
                render.Alert(`Campor obligatorio(*): `,`Seleccione un equipo`,'msgmodal');
                return;
            }

            if(document.querySelector("#Producto").value==0){
                render.Alert(`Campor obligatorio(*): `,`Seleccione un Producto`,'msgmodal');
                return;
            }
            
            if(document.querySelector("#check_equipo").checked==false){
                $('#Equipo').val('0').change();
                document.querySelector("#horometro").value=0; 
            }

            if(document.querySelector("#check_producto").checked==false){
                $('#Producto').val('0').change();
            }else{
                let id_ac=document.querySelector("#Producto").value;
                consultas.ConsultaStock(id_ac);
            }
      
            document.querySelector('#msgmodal').setAttribute("style","display:none");
            carrito.AgregarProductos(id_ac,id_flota,nom_equipo,cant,cambio,horometro,motivo);
            carrito.numrowsCarrito();
            render.renderCarrito();   
        }
    })

    document.querySelector("#productos_carrito").addEventListener("click",function(ev){

        if(ev.target.id=="deleteProducto"){
            carrito.eliminarItem(ev.target.dataset.producto);
            render.renderCarrito(); 
            carrito.numrowsCarrito(); 
        }

    })
    
    document.querySelector("#varciarCarrito").addEventListener("click",function(ev){
        ev.preventDefault();
        carrito.varciarCarrito();
        carrito.numrowsCarrito();
        render.renderCarrito();

    });


    $('#Producto').on('change', function (ev) {
        let id_ac=document.querySelector("#Producto").value;
        consultas.ConsultaStock(id_ac);
        document.querySelector('#btnadd').setAttribute("style","display:true");
        document.querySelector('#msgmodal').setAttribute("style","display:none");
        if(id_ac==0){
            document.querySelector('#btnadd').setAttribute("style","display:none");
        }else{
            document.querySelector('#btnadd').setAttribute("style","display:true");
        }
    });

    $('#Equipo').on('change', function (ev) {
        document.querySelector('#div_horometro').setAttribute("style","display:true");
        equipo = document.querySelector("#Equipo").value;
        if(equipo==1 || equipo==0){
            document.querySelector('#div_horometro').setAttribute("style","display:none");
        }
        document.querySelector('#msgmodal').setAttribute("style","display:none");
    });

    document.querySelector("#btnvale").addEventListener("click",function(ev){
        console.log(personal.value);

        if(personal.value==0){
            render.Alert("Campo obligatorio: ","Seleccione personal","RespuestaAjax");
            ev.preventDefault();
        }

        if(turno.value==0){
            render.Alert("Campo obligatorio: ","Seleccione turno","RespuestaAjax");
            ev.preventDefault();
        }


        if(fecha_despacho.value>render.fechaA()){
         
            render.Alert("Dato invalido: ","fecha despacho no pueder ser mayor a fecha actual "+render.fechaA(),"RespuestaAjax");
            ev.preventDefault();
        }
        
    })

    document.querySelector("#cancelar").addEventListener("click",function(ev){
        carrito.varciarCarrito();
        setTimeout(function(){
            window.location.reload(1);
         }, 500);
    });

    
})();

