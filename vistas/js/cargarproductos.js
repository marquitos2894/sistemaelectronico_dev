(function(){
    function $(selector){
        return document.querySelector(selector);
    }
   
    function cargar(){
        this.constructor = async function(){
            if(!localStorage.getItem("BDproductos") || localStorage.getItem("BDproductos")=="[]"){
                const datos = new FormData();
                datos.append('id_alm', '1');
                let response = await fetch('../ajax/almacenAjax.php',{
                    method : 'POST',
                    body :  datos
                });
                let data = await response.json();
                localStorage.setItem('BDproductos',JSON.stringify(data)); 
                this.getBDproductos = JSON.parse(localStorage.getItem('BDproductos')); 
                render.Renderbd(this.getBDproductos);
            }else{
                this.getBDproductos = JSON.parse(localStorage.getItem('BDproductos'));
                render.Renderbd(this.getBDproductos);
            }  
        }

    }

    function render(){
        
       /* this.Renderbd = function (lista){
            let template = ``;
            let j = 1;
            for(i of lista){

            template += `
              <tr>
                <td>${j}</td>
                <td>${i.codigo}</td>
                <td>${i.descripcion}</td>
                <td>${i.nparte1}</td>
                <td>${i.nparte2}</td>
                <td>${i.nparte3}</td>
                <td>${i.stock}</td>
                <td>${i.unidad_med}</td>
                <td>${i.u_nombre}-${i.u_seccion}</td>
                <td>${i.Nombre_Equipo}</td>
              </tr>
                `;
                j++;
                console.log(i);
            }
            $("#bdcomponentes").innerHTML = template;       
        }*/
    }

    var cargar  = new cargar();
    var render = new render();

    document.addEventListener("DOMContentLoaded",function(){
        cargar.constructor();
        console.log("construct");
    });
    
})();