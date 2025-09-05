@php
    $currentLocale = app()->getLocale();
    $content = $page->getTranslation('content', $currentLocale, useFallbackLocale: true) ?? [];
@endphp

@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<section class="section send-main row justify-content-center">
    <div class=" send-main-container col-12 col-md-10">
        <div class="contact-component-container row g-0"> <div class="col-lg-6 contact-left-panel" style="background-image:linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(https://sai.malcacorp.com/public/storage/pages/May2021/IMG_7729_Large-1024x7681.jpg);">
                <div class="content-wrapper">
                    <h1 class="text-uppercase">{{ $content['h1_title'] ?? '' }}</h1>
                    <p>{{ $content['contact_text'] ?? '' }}</p>
                </div>
            </div>

            <div class="col-lg-6 contact-right-panel">
                <form action="#" method="post" class="contact-form">
                    <div class="mb-3">
                        <label for="nameSurname" class="form-label">{{ $content['name_label'] ?? '' }}</label>
                        <input type="text" class="form-control custom-input" id="nameSurname" name="nameSurname" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailAddress" class="form-label">{{ $content['email_label'] ?? '' }}</label>
                        <input type="email" class="form-control custom-input" id="emailAddress" name="emailAddress" required>
                    </div>
                    <div class="mb-3">
                        <label for="emailSubject" class="form-label">{{ $content['subject_label'] ?? '' }}</label>
                        <input type="text" class="form-control custom-input" id="emailSubject" name="emailSubject" required>
                    </div>
                    <div class="mb-4"> <label for="message" class="form-label">{{ $content['message_label'] ?? '' }}</label>
                        <textarea class="form-control custom-input" id="message" name="message" rows="5" required></textarea>
                    </div>
                    <div class="text-end"> <button type="submit" class="btn btn-submit">{{ $content['submit'] ?? '' }}</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
</section>

<section class="section row contacts-info-section justify-content-center py-5 red-top-shadow"> 
    <div class="col-12 col-md-9">
            <div class="row gy-4 gx-lg-5 align-items-start"> 
                <div class="col-12 col-md-6 col-lg-3 contact-main-title">
                    <h3>OUR CONTACTS INFO</h3>
                </div>
                <div class="col-12 col-md-6 col-lg-3 contact-detail-column">
                    <h4>Email Address</h4>
                    <p><a href="tel:800-563-6099" class="contact-link">800-563-6099</a></p>
                    <p><a href="mailto:Donate@sai.ngo" class="contact-link">Donate@sai.ngo</a></p>
                </div>
                <div class="col-12 col-md-6 col-lg-3 contact-detail-column">
                    <h4>Address</h4>
                    <p>
                        8211 W Broward Blvd Ste 410<br>
                        Plantation, FL 33324<br>
                        United States of America
                    </p>
                </div>
                <div class="col-12 col-md-6 col-lg-3 contact-detail-column">
                    <h4>Social Media Channels</h4>
                    <div class="social-icons-container">
                        <a href="#" class="social-icon social-placeholder color-1 d-flex align-items-center justify-content-center" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon social-placeholder color-2 d-flex align-items-center justify-content-center" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon social-placeholder color-3 d-flex align-items-center justify-content-center" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-icon social-placeholder color-4 d-flex align-items-center justify-content-center" aria-label="LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div> 
        </div> 
    </section>

<section class="section section-help row ">
    <div class="help-container col-12 col-md-9">
        <div class="help-bottom">
            <div class="contacs-cards">
                <h4>START VOLUNTEERING</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, saepe. Voluptatibus eos dolore.</p>
                <a href="" class="about-discover-btn red-transparent-btn">CONTACT US  &gt;</a>
            </div>
            <div class="contacs-cards">
                <h4>BECOME SPONSOR</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, saepe. Voluptatibus eos dolore.</p>
                <a href="" class="about-discover-btn red-transparent-btn">CONTACT US  &gt;</a>
            </div>
            <div class="contacs-cards">
                <h4>HELP MORE</h4>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloremque, saepe. Voluptatibus eos dolore.
                </p>
                <a href="" class="about-discover-btn red-transparent-btn">CONTACT US  &gt;</a>
        </div>
    </div>
</section>

<section class="section location-section row justify-content-center py-5"> 
    <div class="col-12 col-lg-10">
        <div class="location-component-container row g-0"> 
            <div class="col-lg-6 map-panel">
                <div class="map-container">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3582.290277703434!2d-80.26002284523008!3d26.12207677922172!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x88d907c6660a9a35%3A0x890b00d74fd105db!2s8211%20W%20Broward%20Blvd%20%23410%2C%20Plantation%2C%20FL%2033324%2C%20USA!5e0!3m2!1sen!2sve!4v1746038882818!5m2!1sen!2sve" width="100%"
                        height="100%"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Mapa de Google"></iframe>
                    </div>
            </div>

            <div class="col-lg-6 info-panel">
                <div class="address-block">
                    <h4>Our offices in the USA:</h4>
                    <p>8211 W Broward Blvd Ste 410 Plantation, FL 33324</p>
                    <p>Tel: 800-563-6099</p>
                    <p>Email: donate@sai.ngo</p>
                </div>
                <div class="address-block">
                    <h4>Our Offices in Venezuela:</h4>
                    <p>Valencia, Venezuela</p>
                    <p>Tel: 800-563-6099</p>
                    <p>Email: donate@sai.ngo</p>
                </div>
            </div>
        </div> 
    </div> 
</section>
@endsection

@push('styles')
    <style>
        /* Estilos para el contenedor principal del componente */
.contact-component-container {
    background-color: #c84c4c; /* Color de fondo rojo/terracota por defecto (se sobrescribe en el panel izquierdo) */
    border-radius: 15px; /* Bordes redondeados como en la imagen */
    overflow: hidden; /* Esencial para que el contenido respete los bordes redondeados */
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1); /* Sombra sutil opcional */
    display: flex; /* Usar flexbox para alinear paneles */
    flex-wrap: wrap;
    margin: 8rem 0;
}

/* Panel Izquierdo */
.contact-left-panel {
    background-size: cover; /* Cubre todo el espacio */
    background-position: center; /* Centra la imagen */
    color: #ffffff; /* Texto blanco */
    padding: 2.5rem; /* Espaciado interno */
    display: flex; /* Para centrar el contenido verticalmente */
    flex-direction: column;
    justify-content: center; /* Centra el contenido verticalmente */
    min-height: 400px; /* Altura mínima para asegurar visibilidad */
}

.contact-left-panel h1 {
    font-size: clamp(1.5rem, 3vw, 2rem); /* Tamaño de fuente responsivo */
    font-weight: bold;
    margin-bottom: 1rem;
    line-height: 1.3;
}

.contact-left-panel p {
    font-size: clamp(0.85rem, 2vw, 0.95rem);
    line-height: 1.6;
    opacity: 0.9; /* Texto ligeramente menos prominente */
}

/* Panel Derecho */
.contact-right-panel {
    background-color: #d94647; /* Color de fondo rojo/terracota */
    padding: 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    min-height: 400px;
}

/* Estilos del Formulario */
.contact-form .form-label {
    color: #ffffff;
    font-size: 0.8rem;
    font-weight: 500;
    margin-bottom: 0.3rem;
    display: block;
}

/* Estilos para los inputs minimalistas */
.contact-form .custom-input {
    background-color: #ffffff; /* Fondo blanco puro */
    border: none; /* Sin borde */
    border-radius: 0; /* Esquinas cuadradas */
    box-shadow: none; /* Sin sombra */
    padding: 0.8rem 1rem; /* Espaciado interno */
    color: #333; /* Color del texto dentro del input */
    width: 100%; /* Ancho completo */
    font-size: 0.9rem;
}

.contact-form .custom-input:focus {
    background-color: #ffffff;
    border: none;
    box-shadow: none; /* Sin sombra al enfocar */
    outline: none; /* Sin contorno al enfocar */
}

/* Ajuste específico para el textarea */
.contact-form textarea.custom-input {
    min-height: 100px; /* Altura mínima */
    resize: vertical; /* Permitir redimensionar solo verticalmente */
}

/* Estilos del Botón */
.contact-form .btn-submit {
    background-color: #f0eaea; /* Fondo claro como en la imagen */
    color: #666; /* Texto oscuro */
    border: 1px solid #ddd; /* Borde sutil */
    padding: 0.7rem 1.8rem;
    font-weight: bold;
    font-size: 0.85rem;
    border-radius: 4px; /* Ligero redondeo */
    text-transform: uppercase;
    transition: background-color 0.2s ease, border-color 0.2s ease;
}

.contact-form .btn-submit:hover {
    background-color: #e0dada;
    border-color: #ccc;
    color: #444;
}

/* Ajustes Responsivos */
@media (max-width: 991.98px) {
    /* Breakpoint lg de Bootstrap */
    .contact-left-panel,
    .contact-right-panel {
        min-height: auto; /* Quitar altura mínima fija en pantallas medianas/pequeñas */
        padding: 2rem; /* Reducir padding */
    }
    .contact-component-container {
        /* El sistema de columnas de Bootstrap ya se encarga de apilarlos */
    }
}

@media (max-width: 767.98px) {
    .contact-form .btn-submit {
        width: 100%;
        text-align: center;
    }

    .contact-component-container {
        margin: 0;
        border-radius: 0;
    }

    .send-main-container {
        margin: 0;
        padding: 0;
    }

    .text-end {
        width: 100%;
    }
}

/* OUR CONTACT */

/* Estilos para la sección de información de contactos */
.contacts-info-section {
    background-color: #ffffff; /* Fondo blanco o el que prefieras */
    border-top: 1px solid #eee; /* Separador superior sutil */
    border-bottom: 1px solid #eee; /* Separador inferior sutil */
}

/* Contenedor de la columna principal del título */
.contact-main-title h3 {
    color: #000000; /* Texto negro */
    font-weight: bold;
    font-size: clamp(1.4rem, 4vw, 1.8rem); /* Tamaño responsivo */
    line-height: 1.3;
    margin: 0; /* Quitar margen por defecto si es necesario */
    padding-right: 1rem; /* Espacio a la derecha para que no se pegue */
}

/* Estilos comunes para las columnas de detalle */
.contact-detail-column h4 {
    color: #d9534f; /* Color rojo/rosa como en la imagen */
    font-size: clamp(0.9rem, 2.5vw, 1rem);
    font-weight: bold;
    margin-bottom: 0.8rem;
}

.contact-detail-column p {
    color: #555; /* Texto gris oscuro */
    font-size: clamp(0.85rem, 2.5vw, 0.95rem);
    line-height: 1.6;
    margin-bottom: 0.3rem;
}

/* Estilo para los enlaces de contacto */
.contact-link {
    color: #555; /* Mismo color que el párrafo */
    text-decoration: none; /* Sin subrayado */
    transition: color 0.2s ease;
}

.contact-link:hover {
    color: #d9534f; /* Cambia al color del título al pasar el ratón */
    text-decoration: underline; /* Subrayado opcional al pasar el ratón */
}

/* Contenedor de los iconos sociales */
.social-icons-container {
    display: flex;
    flex-wrap: wrap; /* Permitir que los iconos pasen a la siguiente línea si no caben */
    gap: 0.8rem; /* Espacio entre iconos */
    margin-top: 0.2rem; /* Pequeño espacio sobre los iconos */
}

/* Estilo base de los iconos sociales (círculos contenedores <a>) */
.social-icon {
    display: inline-flex; /* Cambiado a inline-flex para que d-flex funcione bien */
    width: 35px; /* Ancho del círculo (un poco más grande para el icono) */
    height: 35px; /* Alto del círculo */
    border-radius: 50%; /* Hace que sea un círculo */
    text-decoration: none; /* Quita subrayado del enlace */
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    color: #ffffff; /* Color del icono (blanco por defecto) */
    font-size: 1rem; /* Tamaño del icono Font Awesome */
    /* align-items-center y justify-content-center vienen de Bootstrap */
}

.social-icon:hover {
    transform: scale(1.1); /* Efecto de zoom ligero al pasar el ratón */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Sombra sutil al pasar el ratón */
}

/* Colores de fondo para cada icono usando las clases color-* */
.social-icon.color-1 {
    background-color: #1877f2;
} /* Facebook Blue */
.social-icon.color-2 {
    background-color: #1da1f2;
} /* Twitter Blue */
.social-icon.color-3 {
    background-color: #e4405f;
} /* Instagram Pink/Gradient (usamos un sólido) */
.social-icon.color-4 {
    background-color: #0a66c2;
} /* LinkedIn Blue */

/* Estilo específico para los iconos Font Awesome <i> dentro de <a> */
.social-icon i {
    line-height: 1; /* Asegura que el icono no tenga altura extra */
}

/* Ajustes Responsivos */
@media (max-width: 991.98px) {
    /* Debajo de lg */
    .contact-main-title h3 {
        margin-bottom: 1.5rem; /* Añadir espacio debajo del título principal cuando no está en la misma fila que los detalles */
        padding-right: 0;
    }
    .contact-detail-column {
        /* El gap del row (gy-4) debería manejar el espacio vertical */
    }
}

@media (max-width: 767.98px) {
    /* Debajo de md */
    .contacts-info-section {
        text-align: center; /* Centrar todo el texto en móvil */
    }
    .contact-main-title h3 {
        margin-bottom: 2rem; /* Más espacio en móvil */
    }
    .contact-detail-column {
        /* El gap del row (gy-4) debería manejar el espacio vertical */
        text-align: center; /* Asegurar centrado */
    }
    .social-icons-container {
        justify-content: center; /* Centrar los iconos sociales en móvil */
    }
}

/* MEDIA QUERIE PARA SM */

@media (max-width: 575.98px) {
    .contact-main-title h3 {
        margin-bottom: 2rem; /* Más espacio en móvil */
        text-align: left;
    }
    .contact-detail-column {
        /* El gap del row (gy-4) debería manejar el espacio vertical */
        text-align: left; /* Asegurar centrado */
    }
}

/* MEDIA QUERIE PARA SM */

/* ANNUAL */

.section-help {
    background-color: #f4f4f4;
    padding: 3rem 0;
    position: relative;
    margin-bottom: 2rem;
}

/* ANNUAL */

/* Estilos generales para la sección de ubicación (opcional) */
.location-section {
}

/* Contenedor principal del componente de ubicación */
.location-component-container {
    background-color: #ffffff; /* Fondo blanco */
    overflow: hidden; /* Para que el iframe respete los bordes */
    display: flex;
    flex-wrap: wrap;
    min-height: 400px; /* Altura mínima similar al componente anterior */
}

/* Panel del Mapa (Izquierdo) */
.map-panel {
    padding: 0; /* Sin padding para que el mapa ocupe todo */
    display: flex; /* Para que el contenedor del mapa se estire */
}

.map-container {
    width: 100%;
    height: 100%;
    min-height: 350px; /* Altura mínima para el mapa en móviles */
    border: 1px solid #e0e0e0; /* Gris claro estándar */
    border-radius: 10px; /* Opcional: esquinas redondeadas */
}

.map-container iframe {
    display: block; /* Elimina espacio extra debajo del iframe */
    width: 100%;
    height: 100%;
    border: none; /* Asegura que no haya borde por defecto */
    border-radius: 10px; /* Opcional: esquinas redondeadas */
}

/* Panel de Información (Derecho) */
.info-panel {
    padding: 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.address-block {
    margin-bottom: 2rem; /* Espacio entre bloques de dirección */
}

.address-block:last-child {
    margin-bottom: 0; /* Sin margen inferior en el último bloque */
}

.address-block h4 {
    color: #d9534f; /* Color rojo/rosa para el título */
    font-size: clamp(1rem, 2.5vw, 1.1rem); /* Tamaño responsivo */
    font-weight: bold;
    margin-bottom: 0.8rem;
}

.address-block p {
    color: #555; /* Color de texto gris oscuro */
    font-size: clamp(0.85rem, 2vw, 0.95rem);
    line-height: 1.6;
    margin-bottom: 0.4rem; /* Espacio entre líneas de dirección */
}

/* Ajustes Responsivos */
@media (max-width: 991.98px) {
    /* Breakpoint lg de Bootstrap */
    .location-component-container {
        min-height: auto; /* Quitar altura mínima fija */
    }
    .map-panel {
        /* El mapa ocupará todo el ancho y estará arriba */
        min-height: 300px; /* Ajustar altura mínima en tablet */
    }
    .info-panel {
        padding: 2rem; /* Reducir padding */
        /* El texto estará debajo del mapa */
    }
}

    </style>
@endpush