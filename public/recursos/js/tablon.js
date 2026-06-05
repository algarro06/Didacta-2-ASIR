document.addEventListener("DOMContentLoaded", () => {

const noticias = [
  { titulo: "GeoGebra y su uso en el aprendizaje matemático interactivo", descripcion: "GeoGebra sigue siendo una de las herramientas más utilizadas en educación para representar funciones y geometría de forma dinámica en el aula.", link: "https://dialnet.unirioja.es/servlet/articulo?codigo=10440411" },
  { titulo: "PhET amplía sus simulaciones para enseñanza de ciencias", descripcion: "La Universidad de Colorado continúa desarrollando simulaciones interactivas para mejorar la comprensión de física y química en estudiantes.", link: "https://phet.colorado.edu/es/" },
  { titulo: "Khan Academy refuerza el aprendizaje digital personalizado", descripcion: "La plataforma educativa mejora su sistema de ejercicios adaptativos para matemáticas y ciencias, permitiendo aprendizaje autónomo.", link: "https://es.khanacademy.org/" },
  { titulo: "El uso de simuladores virtuales mejora el aprendizaje en ciencias naturales", descripcion: "Un estudio analiza cómo herramientas como PhET permiten comprender mejor conceptos complejos en biología, química y física mediante laboratorios digitales.", link: "https://neosapiencia.com/index.php/neosapiencia/article/view/53" },
  { titulo: "Las herramientas digitales aumentan la motivación en matemáticas en secundaria", descripcion: "Investigaciones demuestran que el uso de plataformas interactivas mejora la participación del alumnado en clases de matemáticas.", link: "https://ciencialatina.org/index.php/cienciala/article/view/19967" },
  { titulo: "Educación STEM y herramientas digitales en el aula", descripcion: "El uso de tecnología en ciencias, ingeniería y matemáticas está transformando la forma de enseñar en educación secundaria.", link: "https://revistas.um.es/red/article/view/410011" },
  { titulo: "Las TIC mejoran la autonomía del estudiante en el aprendizaje de matemáticas", descripcion: "El uso de herramientas digitales favorece el aprendizaje autónomo y la resolución de problemas.", link: "https://revistahorizontes.org/index.php/revistahorizontes/article/view/2251" },
  { titulo: "El uso de software matemático en el aprendizaje de aritmética y cálculo", descripcion: "Un estudio analiza el impacto del uso de programas informáticos en la mejora del rendimiento académico en matemáticas.", link: "https://revistahorizontes.org/index.php/revistahorizontes/article/view/1770" },
  { titulo: "Herramientas digitales en la resolución de problemas matemáticos en educación básica", descripcion: "Investigación centrada en el uso de software educativo y recursos digitales para mejorar la resolución de problemas matemáticos en estudiantes.", link: "https://revistahorizontes.org/index.php/revistahorizontes/article/view/1968" },
  { titulo: "Google Classroom se actualiza en 2026 con nuevas funciones de IA para profesores y alumnos", descripcion: "Google Classroom ha incorporado nuevas funciones dentro de Google for Education, incluyendo herramientas de inteligencia artificial (Gemini) para ayudar a crear actividades, generar contenido educativo y mejorar la gestión del aula digital.", link: "https://www.educaciontrespuntocero.com/tecnologia/google-classroom-crear-una-clase-y-entregar-una-tarea-paso-a-paso/" },
  { titulo: "Google Classroom añade mejoras para la creación de tareas, comunicación y seguimiento del alumnado", descripcion: "La plataforma educativa de Google continúa evolucionando con nuevas funciones que permiten una mejor organización de clases, envío de tareas y seguimiento del progreso de los estudiantes desde un mismo entorno digital.", link: "https://www.larazon.es/tecnologia-consumo/aplicaciones/guia-de-google-classroom-que-es-como-utilizarlo-y-sus-principales-funciones_2025100169941e0f9243cc133c4d9500.html" }
];

const tablon = document.getElementById("tablon");

noticias.forEach(noticia => {
  const tarjeta = document.createElement("div");
  tarjeta.classList.add("tarjeta");
  tarjeta.innerHTML = `
    <h3>${noticia.titulo}</h3>
    <p>${noticia.descripcion}</p>
    <a href="${noticia.link}" target="_blank">Leer más →</a>
  `;
  tablon.appendChild(tarjeta);
});

});