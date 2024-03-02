<?php
//Configuraciones globales seteadas como constantes

// Las config deben ser constantes para evitar que se reescriban
// las declaracionesd e constantes deberia hacerse en la carpeta config y solo en esa carpeta.

//ejemplo
//define("DB_SERVER","sql.freedb.tech");

//nombre que se le da en el array de sesion a los datos del usuario logado.
define("SESSION_USER","usuario");

//contexto de despliegue, es la subruta de despliegue dentro de localhost. Se usa en redirecciones por cabecera que no puedan ser relativas
define("DEPLOY_PATH",'/code_recetas_php');
?>