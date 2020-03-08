(function(){

    //var buscar = document.querySelector('#buscador_comp_text').value;
    var vista = document.querySelector('#vista').value;
    var id_alm = document.querySelector('#id_alm').value;
    var privilegio = document.querySelector('#privilegio').value;
    var unidad = document.querySelector('#session_idunidad').value;
    //var codigo = document.querySelector('#codigo').value;
    


    function kardex(){
        this.constructor = function(){
        }

        this.fechaA = function(dia,mes){
            date = new Date();
            dia=(dia>0)?+dia:-dia;
            mes=(mes>0)?+mes:-mes;
            y=date.getFullYear();
            m=date.getMonth()-(mes)+1;
            d=date.getDate()-dia;
            if(m<10){m='0'+m;}
            if(d<10){d='0'+d;}
            fecha = `${y}-${m}-${d}`;
            return fecha;
        }


    }

    function render(){
        this.render_kardex = async function(page,codigo,fecha_ini,fecha_fin){
            let datos = new FormData();
            datos.append('buscarcompajax_kardex',codigo);
            datos.append('paginadorajax_kardex',page);
            datos.append('vistaajax_kardex',vista);
            datos.append('almacenajax_kardex',id_alm);
            datos.append('privilegioajax_kardex',privilegio);
            datos.append('unidadajax_kardex',unidad);
            datos.append('fecha_ini_kardex',fecha_ini);
            datos.append('fecha_fin_kardex',fecha_fin);

            try{
                let response = await fetch('../ajax/almacenAjax.php',{
                    method : 'POST',
                    body : datos
                });
                let data = await response.text();
                //console.log(data);
                document.querySelector('#contenido_kardex').innerHTML=data;
            }catch(err){
                console.log('fetch failed');
            }


        }

    }

    render = new render();
    kardex = new kardex();

    document.addEventListener("DOMContentLoaded", function(){
        render.render_kardex();
        document.querySelector('#fecha_ini').value=kardex.fechaA(0,-1);
        document.querySelector('#fecha_fin').value=kardex.fechaA(0,0);
    });

    document.querySelector("#contenido_kardex").addEventListener("click",function(ev){         
        if(ev.target.id=='page'){
            codigo = document.querySelector('#codigo').value;
            render.render_kardex(ev.target.dataset.page,codigo);
        }
    });

    document.querySelector("#btnbuscar").addEventListener("click",function(ev){
        codigo = document.querySelector('#codigo').value;
        fecha_ini=document.querySelector('#fecha_ini').value
        fecha_fin=document.querySelector('#fecha_fin').value
        render.render_kardex(1,codigo,fecha_ini,fecha_fin);
    })


    
    
})();