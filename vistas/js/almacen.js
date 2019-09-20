(function(){
    //funcion reutilizable para seleccionar elementos del dom
    function $1(selector){
        return document.querySelector(selector);
    }

    $1('#table_almacen').addEventListener("click", async function(ev){
        ev.preventDefault();
        if(ev.target.id=="almacen"){
            console.log(ev.target.dataset.almacen);
            let id_alm = ev.target.dataset.almacen;
            let nom_almacen=$1('#nom_almacen'+id_alm).value;
            console.log("click");
            datos = new FormData();
            datos.append('id_alm',id_alm);
            datos.append('nom_almacen',nom_almacen);
            let response = await fetch('../ajax/almacenAjax.php',{
                method : 'POST',
                body : datos
            });
            //let data = await response.json();
            //await localStorage.setItem('BDproductos',JSON.stringify(data));
            //this.getBDproductos = await JSON.parse(localStorage.getItem('BDproductos'));
            //console.log("localStorage"); 
            //console.log(data);
            //console.log(this.getBDproductos);
            window.location='almacen';
        }
    });





})();

/*document.querySelector('#card-almacen').addEventListener("click",function(ev){
    ev.preventDefault();
    //idalmacen
    console.log(ev.target.dataset.almacen);
    var variablejs = "<?php echo $variablephp; ?>" ;
    alert("category = " + variablejs);

    });*/