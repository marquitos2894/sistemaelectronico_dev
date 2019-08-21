

document.querySelector('#table_personal').addEventListener("click", async function(ev){
    if(ev.target.id == 'EditItem'){
        let id_per = ev.target.dataset.item;
        console.log(id_per);
        const datos = new FormData();
        datos.append('id_per_json',id_per);
        let response = await fetch('../ajax/personalAjax.php',{
            method: 'POST',
            body : datos
        });
        let data = await response.json();
        console.log(data);

   
        const datosC = new FormData();
        datosC.append('idcargo_json',data[0].id_cargo);
        let responseC = await fetch('../ajax/personalAjax.php',{
            method: 'POST',
            body : datosC
        });
        let datacargo = await responseC.text();
        console.log(datacargo);

        //${data[0].id_dr}

        let template = `
            <input type="hidden" name="id_per_edit" value="${data[0].id_per}"  />
            <input type="text" name="unidad_edit" value="${data[0].idunidad}"  />
            <div class="form-row">
            <div class="form-group col-md-6">
              <label for="inputEmail4">Nombres</label>
              <input type="text" name="nom_per_edit" value="${data[0].Nom_per}" class="form-control" id="inputEmail4" placeholder="Nombres">
            </div>
            <div class="form-group col-md-6">
              <label for="inputPassword4">Apellidos</label>
              <input type="text" name="ape_per_edit" value="${data[0].Ape_per}" class="form-control" id="inputPassword4" placeholder="Apellidos" >
            </div>
          </div>
          <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputCity">DNI</label>
                <input type="text" name="dni_per_edit" value="${data[0].Dni_per}" class="form-control" id="inputCity">
              </div>
              <div class="form-group col-md-4">
                <label for="inputCity">Brevete</label>
                <input type="text" name="brevete_edit" value="${data[0].brevete}" class="form-control" id="inputCity">
              </div>
              <div class="form-group col-md-4">
                <label for="inputZip">Telefono</label>
                <input type="text" name="telefono_edit" value="${data[0].Telefono_per}"  class="form-control" id="inputZip">
              </div>
          </div>
          <div class="form-group">
              <label for="inputAddress">Direccion</label>
              <input type="text" name="direccion_edit" value="${data[0].Direccion_per}" class="form-control" id="inputAddress" placeholder="1234 Main St">
          </div>
          <div class="form-row">
              <div class="form-group col-md-4">
                <label for="inputCity">Region</label>
                <input type="text" name="region_edit" value="${data[0].Region_per}" class="form-control" id="inputCity">
              </div>
              <div class="form-group col-md-4">
                <label for="inputCity">Ciudad</label>
                <input type="text" name="ciudad_edit" value="${data[0].Ciudad_per}" class="form-control" id="inputCity">
              </div>
              <div class="form-group col-md-4">
                <label for="inputZip">Distrito</label>
                <input type="text" name="distrito_edit" value="${data[0].Distrito_per}"  class="form-control" id="inputZip">
              </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="inputCity">Correo @</label>
              <input type="text" name="correo_per_edit" value="${data[0].Correoe_per}" class="form-control" id="inputCity">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputAddress">Cargo</label>
                <select name="cargo_edit"  class="form-control" placeholder="">
                  <option value="${data[0].id_cargo}">${data[0].cargo}</option>
                  ${datacargo}
                </select>
            </div>
          </div>
        `;
     document.querySelector('#modal-body').innerHTML=template;
    }
});

