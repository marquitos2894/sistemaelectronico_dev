document.addEventListener("DOMContentLoaded", async function(){
    
        //     // your page initialization code here
        //     // the DOM will be available here
        
            // const datos = await new FormData();
            // await datos.append('id_alm', '1');
            // let response = await fetch('../ajax/almacenAjax.php',{
            //     method : 'POST',
            //     body :  datos
            // });
        
            // let data = await response.json();
            // await console.log(data);
            // await console.log("json");
        
        
            const datos = await new FormData();
            await datos.append('id_alm', '1');
            let response = await fetch('../ajax/almacenAjax.php',{
                method : 'POST',
                body :  datos
            });
        
            let data = await response.json();
            await console.log(data);
            await console.log("json");
        
            //      await  $('#dataTable').DataTable( {
        //         data: data,
        //         columns: [
        //             { data: 'id_ac' },
        //             { data: 'id_comp' },
        //             { data: 'descripcion' },
        //             { data: 'nparte1' }
        //         ]
        //     });

        
});
 

(async function() {

    var data1 = [
        [
            "Tiger Nixon",
            "System Architect",
            "Edinburgh",
            "5421",
            "2011/04/25",
            "$3,120"
        ],
        [
            "Garrett Winters",
            "Director",
            "Edinburgh",
            "8422",
            "2011/07/25",
            "$5,300"
        ]
    
    ];
    
    console.log(data1);

    const datos =  new FormData();
    datos.append('id_alm', '1');
    
    fetch('../ajax/almacenAjax.php', {
      method: 'POST', // or 'PUT'
      body: datos
    }).then(res => res.json())
    .catch(error => console.error('Error:', error))
    .then(response =>console.log(response));

       
            $('#dataTable').DataTable({
                    data: response,
                    columns: [
                        { data: 'id_ac' },
                        { data: 'id_comp' },
                        { data: 'nparte1' },
                        { data: 'nparte2' },
                        { data: 'nparte3' },
                        { data: 'nparte1' }
                    ]
                });
      

        console.log("primero en cargar");

         
    })();




 
 










