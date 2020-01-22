(function(){


function Render(){

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


var render = new Render();

document.querySelector("#btnsave").addEventListener("click",function(ev){

    let cargo = document.querySelector("#cargo_in").value;

    if(cargo==""){
        ev.preventDefault();
        render.Alert("(*) Campo obligatorio: ","Seleccione cargo","mesanje"); 
    }

})


})()



