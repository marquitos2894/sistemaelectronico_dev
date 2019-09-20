(function(){


function render(){


    this.renderTablelog = async function(page){

        let buscar = document.querySelector('#buscador_text').value;
        //let paginador = document.querySelector('#paginador').value
        let vista = document.querySelector('#vista').value
        let id_alm = document.querySelector('#id_alm').value
        let privilegio = document.querySelector('#privilegio').value


        const datos = new FormData();
        datos.append('buscadorlogajax',buscar);
        datos.append('paginadorlogajax',page);
        datos.append('vistalogajax',vista);
        datos.append('almacenlogajax',id_alm);
        datos.append('privilegiologajax',privilegio);
        datos.append('tipologajax',"ambos");

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
        render.renderTablelog();
        //carrito.numrowsCarrito();

    });


    document.querySelector("#log_in_out").addEventListener("click",function(ev){

        if(ev.target.id=='page'){
            render.renderTablelog(ev.target.dataset.page);
        }
    });

})();