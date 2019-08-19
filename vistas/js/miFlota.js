

document.querySelector('#table_miFlota').addEventListener("click", async function(ev){
    if(ev.target.id == 'EditItem'){
        let id_equipounidad = ev.target.dataset.equipo;
        console.log(id_equipounidad);
        const datos = new FormData();
        datos.append('id_equipounidad_json',id_equipounidad);
        let response = await fetch('../ajax/equiposAjax.php',{
            method: 'POST',
            body : datos
        });
        let data = await response.json();
        console.log(data);

        //${data[0].id_dr}

        let template = `
            <input type="hidden" name="id_eu_edit" value="${data[0].id_equipounidad}"  />
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Alias</label>
                    <input type="text" name="alias_eu_edit" value="${data[0].alias_equipounidad}" class="form-control" placeholder="Email">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Estado</label>`;
                    if(data[0].estado_equipounidad=="Operativo"){
                        template +=`
                        <select name="estado_eu_edit" class="form-control">    
                            <option selected value="Operativo">Operativo</option>
                            <option value="Inoperativo">Inoperativo</option>
                        </select>`;
                    }else{
                        template +=`
                        <select name="estado_eu_edit" class="form-control">
                            <option selected value="Inoperativo">Inoperativo</option>    
                            <option value="Operativo">Operativo</option>
                        </select>`;
                    }
                    
                    template +=`
                </div>
            </div>
        `;
     document.querySelector('#modal-body').innerHTML=template;
    }
});


document.querySelector("#btnAddFlota").addEventListener("click", async function(ev){
ev.preventDefault();

let datos = new FormData();
datos.append("addFlota",true);
let response = await fetch("../ajax/equiposAjax.php",{
    method : "POST",
    body : datos
})
let data =  await response.text();

console.log(data);

let template = `
    <div class="form-row">
        <div class="form-group col-sm-10">
            <label for="inputEmail4">Equipo</label>
            <select id='chosen-select' data-placeholder='Seleccione Equipo' name='equipo_agregarF' class="chosen-select">
                <option value=""></option>
                    ${data}
            </select>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputEmail4">Alias</label>
            <input type="text" name="Alias_Equipo_agregarF" value="" class="form-control" placeholder="Ejem: JUA37/DS311,SCA141/R1600">
        </div>
        <div class="form-group col-md-6">
            <label for="inputPassword4">Estado</label>
            <select name="estado_equipo_agregarF" class="form-control" >
                <option selected value="Operativo" >Operativo</option>
                <option value="Inoperativo">Inoperativo</option>
            </select>
        </div>
    </div>
`;

document.querySelector("#modal-body-addFlota").innerHTML = template;



(async function($) 
{  
   await $('.chosen-select').chosen({width: "100%"});
 
})(jQuery);


});