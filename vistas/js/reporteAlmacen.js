(function(){


function render(){


    this.renderTablelog = async function(page,tipo){

        let buscar = document.querySelector('#buscador_text').value;
        
        let vista = document.querySelector('#vista').value
        let id_alm = document.querySelector('#id_alm').value
        let privilegio = document.querySelector('#privilegio').value
        
        //array
        let codigo = document.querySelector('#codigo').value;
        let equipo = document.querySelector('#equipo').value;
        let ref = document.querySelector('#referencia').value;
        let fec_ini = document.querySelector('#fec_ini').value;
        let fec_fin = document.querySelector('#fec_fin').value;
        let filtro = document.querySelector('#customSwitch1').checked;

        let array = [codigo,equipo,ref,fec_ini,fec_fin,filtro];

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

    this.Alert = function (title,mensaje){
        let template = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>${title} </strong>${mensaje}.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        `;
        document.querySelector("#alert").innerHTML = template;
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

render = new render();

    document.addEventListener("DOMContentLoaded", async function(){
        console.log("constructor");
        let tipo = document.querySelector('#tipo_logalm').value;
        render.renderTablelog(1,tipo);

    });


    document.querySelector("#log_in_out").addEventListener("click",function(ev){

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

        document.querySelector('#tipo_form').value = document.querySelector('#tipo_logalm').value;
    });

    document.querySelector('#buscador_text').addEventListener("keyup", async function(ev){
        let tipo = document.querySelector('#tipo_logalm').value
        render.renderTablelog(1,tipo);
        
    });

    document.querySelector('#btnFiltrar').addEventListener("click", function(ev){

        let fec_ini=document.querySelector('#fec_ini').value
        let fec_fin=document.querySelector('#fec_fin').value
       
        if(fec_ini>fec_fin){
           render.Alert('Validacion','La fecha inicial no puede ser mayor a la fecha final');
           document.querySelector('#btnreport').disabled=true;
            ev.preventDefault();
            
        }else{
            document.querySelector('#btnreport').disabled=false;
            let tipo = document.querySelector('#tipo_logalm').value;
            render.renderTablelog(1,tipo);
            // CREAR REPORTE
            let codigo = document.querySelector('#codigo').value;
            let equipo = document.querySelector('#equipo').value;
            let ref = document.querySelector('#referencia').value;
            let fec_ini = document.querySelector('#fec_ini').value;
            let fec_fin = document.querySelector('#fec_fin').value;
            let filtro = document.querySelector('#customSwitch1').checked;
            let array = [codigo,equipo,ref,fec_ini,fec_fin,filtro];
    
            document.querySelector('#datos_form').value=array;
            document.querySelector('#tipo_form').value=tipo;
        }
    })

    document.querySelector('#customSwitch1').addEventListener("change", function(ev){
   
        document.querySelector('#fec_ini').value=render.fechaA();
        document.querySelector('#fec_fin').value=render.fechaA();

        
        let vdisabled = document.querySelector('#customSwitch1').checked;
        document.querySelector('#buscador_text').disabled=vdisabled;

        vdisabled = (vdisabled==true)?vdisabled=false:vdisabled=true;
        document.querySelector('#equipo').disabled=vdisabled;   
        document.querySelector('#fec_ini').disabled=vdisabled;
        document.querySelector('#fec_fin').disabled=vdisabled;
        document.querySelector('#btnFiltrar').disabled=vdisabled;
        document.querySelector('#codigo').disabled=vdisabled;
       
        if(document.querySelector('#customSwitch1').checked==false){
            let tipo = document.querySelector('#tipo_logalm').value;
            document.querySelector('#btnreport').disabled=true;
            render.renderTablelog(1,tipo);

        }
            
    });


})();