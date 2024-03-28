var urlBase ="..";
//ESTA VARIABLE HAY QEU DEFINIRLA SI SE USA ESTE SCRIPT
//ES TAN SENCILLO COMO EJECUTAR defineUrlBase("<?= DEPLOY_PATH?>"); en tu path
// por defecto url relativa subiendo un directorio


function defineUrlBase(newUrl){
    urlBase=newUrl;
}

async function lanzarLikeDislike(idReceta,tipo) {
    // URL del servicio REST
    const url = urlBase+ '/services/likes/index.php'; // la URL real de tu servicio REST
    
    // Configuración para la solicitud POST
    const requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({'id-receta': idReceta,'tipo': tipo})
    };
    
    // Realizar la solicitud fetch al servicio REST
    try {
        const response = await fetch(url, requestOptions);
        // Verificar si la respuesta es exitosa (código 200)
        if (!response.ok) {
            throw new Error('Error al obtener el número de likes');
        }
        var responseString= await response.text();
        console.log(responseString );
        const data = JSON.parse(responseString);
        return data['num-likes'];
    } catch (error) {
        // Manejar errores
        console.error('Error:', error);
        throw error;
    }
}


async function eliminarLikeDislike(idReceta,tipo) {
    // URL del servicio REST
    const url = urlBase+ '/services/likes/delete.php'; // la URL real de tu servicio REST
    
    // Configuración para la solicitud POST
    const requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({'id-receta': idReceta,'tipo': tipo})
    };
    
    // Realizar la solicitud fetch al servicio REST
    try {
        const response = await fetch(url, requestOptions);
        // Verificar si la respuesta es exitosa (código 200)
        if (!response.ok) {
            throw new Error('Error al obtener el número de likes');
        }
        var responseString= await response.text();
        console.log(responseString );
        const data = JSON.parse(responseString);
        return data['num-likes'];
    } catch (error) {
        // Manejar errores
        console.error('Error:', error);
        throw error;
    }
}

async function obtenerLikeODislikes(idReceta,tipo) {
    // URL del servicio REST
    const url = urlBase+ '/services/likes?id-receta='+idReceta+"&tipo="+tipo; // la URL real de tu servicio REST
    
    // Configuración para la solicitud POST
    const requestOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    };
    
    // Realizar la solicitud fetch al servicio REST
    try {
        const response = await fetch(url, requestOptions);
        // Verificar si la respuesta es exitosa (código 200)
        if (!response.ok) {
            throw new Error('Error al obtener el número de likes');
        }
        const data = await response.json();

        return data['num-likes'];
    } catch (error) {
        // Manejar errores
        console.error('Error:', error);
        throw error;
    }
}

async function obtenerEleccionUsuario(idReceta) {
    // URL del servicio REST    
    const url = urlBase+ '/services/likes/user-choice.php?id-receta='+idReceta; // la URL real de tu servicio REST
    
    // Configuración para la solicitud POST
    const requestOptions = {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    };
    
    // Realizar la solicitud fetch al servicio REST
    try {
        const response = await fetch(url, requestOptions);
        // Verificar si la respuesta es exitosa (código 200)
        if (!response.ok) {
            throw new Error('Error al obtener el número de likes');
        }
        const data = await response.json();
        return data['tipo'];
    } catch (error) {
        // Manejar errores
        console.error('Error:', error);
        throw error;
    }
}
// Ejemplo de uso

function recalcularLikes(idReceta){
    //hay que saber la preferencia del usuario
    obtenerEleccionUsuario(idReceta).then(tipo => {
        console.log('tipo:', tipo);               
        const elementoLike = document.getElementById("boton-like");
        const elementoDisLike = document.getElementById("boton-dislike");      
        tipoLikeUser=tipo;
        if (tipo!=null && tipo=='D'){
           elementoLike.classList.remove("boton-marcado");
           elementoDisLike.classList.add("boton-marcado");
        }else if (tipo!=null && tipo=='L'){
           elementoDisLike.classList.remove("boton-marcado");
           elementoLike.classList.add("boton-marcado");
        }else{
           elementoDisLike.classList.remove("boton-marcado");
           elementoLike.classList.remove("boton-marcado");
        }
   })
   .catch(error => {
       console.error('Error al obtener el número de likes:', error);
   });
}

/*
const idReceta = 'ID_DE_LA_RECETA'; // Reemplaza 'ID_DE_LA_RECETA' por el ID real de la receta
obtenerNumLikes(idReceta)
    .then(numLikes => {
        console.log('Número de likes:', numLikes);
    })
    .catch(error => {
        console.error('Error al obtener el número de likes:', error);
    });
*/