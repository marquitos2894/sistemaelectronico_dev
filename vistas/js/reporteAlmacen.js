(function(){


function render(){


    this.renderTablelog = async function(page,tipo,array){

        let buscar = document.querySelector('#buscador_text').value;
        
        let vista = document.querySelector('#vista').value
        let id_alm = document.querySelector('#id_alm').value
        let privilegio = document.querySelector('#privilegio').value


        const datos = new FormData();
        datos.append('buscadorlogajax',buscar);
        datos.append('paginadorlogajax',page);
        datos.append('vistalogajax',vista);
        datos.append('almacenlogajax',id_alm);
        datos.append('privilegiologajax',privilegio);
        datos.append('tipologajax',tipo);
        datos.append('array',array);

        let response = await fetch('../ajax/almacenAjax.php',{
            method : 'POST',
            body : datos
        })
        let data = await response.text();
        //console.log(data);

        document.querySelector('#log_in_out').innerHTML = data;

    }
}

render = new render();

    document.addEventListener("DOMContentLoaded", async function(){
        console.log("constructor");
        let tipo = document.querySelector('#tipo_logalm').value
        render.renderTablelog(1,tipo);
    });


    document.querySelector("#log_in_out").addEventListener("click",function(ev){
        let equipo = document.querySelector('#equipo').value;
        let ref = document.querySelector('#referencia').value;
        let fec_ini = document.querySelector('#fec_ini').value;
        let fec_fin = document.querySelector('#fec_fin').value;

        console.log(equipo);
        console.log(ref);
        console.log(fec_ini);
        console.log(fec_fin);

        if(ev.target.id=='salida'){
            render.renderTablelog(1,'salida');
            document.querySelector('#tipo_logalm').value = "salida";
        }
        
        if(ev.target.id=='ingreso'){
            render.renderTablelog(1,'ingreso');
            document.querySelector('#tipo_logalm').value = "ingreso";
        }
        if(ev.target.id=='ambos'){
            render.renderTablelog(1,'ambos');
            document.querySelector('#tipo_logalm').value = "ambos";
        }

        if(ev.target.id=='page'){
            let tipo = document.querySelector('#tipo_logalm').value;
            render.renderTablelog(ev.target.dataset.page,tipo);
        }

    });

    document.querySelector('#buscador_text').addEventListener("keyup", async function(ev){
        let tipo = document.querySelector('#tipo_logalm').value
        render.renderTablelog(1,tipo);
        
    });

    document.querySelector('#btnFiltrar').addEventListener("click", function(ev){
        let equipo = document.querySelector('#equipo').value;
        let ref = document.querySelector('#referencia').value;
        let fec_ini = document.querySelector('#fec_ini').value;
        let fec_fin = document.querySelector('#fec_fin').value;

        console.log(equipo);
        console.log(ref);
        console.log(fec_ini);
        console.log(fec_fin);

        //let obj = {equipo: equipo,referencia:ref,fec_ini:fec_ini,fec_fin:fec_fin};
        let array = [equipo,ref,fec_ini,fec_fin];
        console.log(array);
        let tipo = document.querySelector('#tipo_logalm').value
        render.renderTablelog(1,tipo,array);

    })


})();