async function lanzarLikeDislike(idReceta,tipo) {
    // URL del servicio REST
    const url = '../services/likes'; // la URL real de tu servicio REST
    
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
        const data = await response.json();
        return data['num-likes'];
    } catch (error) {
        // Manejar errores
        console.error('Error:', error);
        throw error;
    }
}


async function eliminarLikeDislike(idReceta,tipo) {
    // URL del servicio REST
    const url = '../services/likes/delete.php'; // la URL real de tu servicio REST
    
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
        const data = await response.json();
        return data['num-likes'];
    } catch (error) {
        // Manejar errores
        console.error('Error:', error);
        throw error;
    }
}

async function obtenerLikeODislikes(idReceta,tipo) {
    // URL del servicio REST
    const url = '../services/likes?id-receta='+idReceta+"&tipo="+tipo; // la URL real de tu servicio REST
    
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
    const url = '../services/likes/user-choice.php?id-receta='+idReceta; // la URL real de tu servicio REST
    
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