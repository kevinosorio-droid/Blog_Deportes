<?php
session_start();
include("php/conexion.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>

<body>

    <?php include("includes/header.php");?>

    <div id="principal">
        <h1>Sobre Mi</h1>

        <div class="sobre">
            ¡Hola! Somos un grupo apasionado del deporte en todas sus formas. Desde pequeño, he estado inmerso en el mundo del fútbol, el baloncesto, el atletismo y muchas otras disciplinas que despiertan emoción y competitividad. Con el tiempo, mi amor por el deporte me llevó a crear este blog, un espacio dedicado a compartir noticias, análisis, curiosidades y todo lo relacionado con el universo deportivo. 
            <br>
            <br>
            ¿Por qué este blog?
            <br>
            <br>
            El deporte no es solo entretenimiento; es pasión, esfuerzo y disciplina. Para quienes vibramos con cada partido, carrera o jugada, estar informados y compartir opiniones es parte de nuestra identidad. Este blog nace con el propósito de ser un punto de encuentro para todos los que viven el deporte con intensidad, brindando contenido de calidad, opiniones fundamentadas y análisis detallados.
            <br>
            <br>
            La importancia del deporte en nuestra vida
            El deporte no solo nos entretiene, sino que también nos enseña valores como el trabajo en equipo, la perseverancia y el espíritu de superación. Nos une, nos inspira y nos ayuda a llevar una vida más saludable. A través de este blog, quiero transmitir la emoción del deporte y su impacto en nuestra sociedad, conectando con personas que, al igual que yo, sienten que cada competencia es una historia que vale la pena contar.
            <br>
            <br>
            ¡Bienvenido a este espacio donde la pasión por el deporte nunca se detiene!
    </div>

        <div class="gti">
        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-brand-github"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5.315 2.1c.791 -.113 1.9 .145 3.333 .966l.272 .161l.16 .1l.397 -.083a13.3 13.3 0 0 1 4.59 -.08l.456 .08l.396 .083l.161 -.1c1.385 -.84 2.487 -1.17 3.322 -1.148l.164 .008l.147 .017l.076 .014l.05 .011l.144 .047a1 1 0 0 1 .53 .514a5.2 5.2 0 0 1 .397 2.91l-.047 .267l-.046 .196l.123 .163c.574 .795 .93 1.728 1.03 2.707l.023 .295l.007 .272c0 3.855 -1.659 5.883 -4.644 6.68l-.245 .061l-.132 .029l.014 .161l.008 .157l.004 .365l-.002 .213l-.003 3.834a1 1 0 0 1 -.883 .993l-.117 .007h-6a1 1 0 0 1 -.993 -.883l-.007 -.117v-.734c-1.818 .26 -3.03 -.424 -4.11 -1.878l-.535 -.766c-.28 -.396 -.455 -.579 -.589 -.644l-.048 -.019a1 1 0 0 1 .564 -1.918c.642 .188 1.074 .568 1.57 1.239l.538 .769c.76 1.079 1.36 1.459 2.609 1.191l.001 -.678l-.018 -.168a5.03 5.03 0 0 1 -.021 -.824l.017 -.185l.019 -.12l-.108 -.024c-2.976 -.71 -4.703 -2.573 -4.875 -6.139l-.01 -.31l-.004 -.292a5.6 5.6 0 0 1 .908 -3.051l.152 -.222l.122 -.163l-.045 -.196a5.2 5.2 0 0 1 .145 -2.642l.1 -.282l.106 -.253a1 1 0 0 1 .529 -.514l.144 -.047l.154 -.03z" /></svg>
            <a href="https://github.com/kevinosorio-droid/Blog_Deportes">GitHUb
            </a>
        </div>
    </div>

    <?php
        include("includes/sidebar.php");
        include("includes/footer.php");
    ?>
</body>
</html>