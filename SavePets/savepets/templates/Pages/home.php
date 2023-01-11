<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;
use Cake\I18n\I18n;

$this->disableAutoLayout();

$checkConnection = function (string $name) {
    $error = null;
    $connected = false;
    try {
        $connection = ConnectionManager::get($name);
        $connected = $connection->connect();
    } catch (Exception $connectionError) {
        $error = $connectionError->getMessage();
        if (method_exists($connectionError, 'getAttributes')) {
            $attributes = $connectionError->getAttributes();
            if (isset($attributes['message'])) {
                $error .= '<br />' . $attributes['message'];
            }
        }
    }

    return compact('connected', 'error');
};

if (!Configure::read('debug')) :
    throw new NotFoundException(
        'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
    );
endif;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Savepets - Home</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="img/logo.png" rel="icon">
  <link href="img/logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="plantilla/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="plantilla/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="plantilla/aos/aos.css" rel="stylesheet">
  <link href="plantilla/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="plantilla/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="css/home.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Yummy - v1.2.1
  * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<?php $this->loadHelper('Authentication.Identity'); 

if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserUsername=$currentuser->username;
  $currentuserID=$currentuser->id;
  $currentuserRol=$currentuser->role;

} ?>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container-fluid">
        <h1 class="navbar-brand"><div class="juntosmensajes">
              <?= $this->Html->link(__($this->Html->image("logo.png", ["alt" => "Logo",'class'=>'logonavsavepeta'])), ['action' => 'index','controller'=>'Pagess'],['escape' => false]) ?>
              <span id="idlogosave">SAVE</span><span id="idlogopets">PETS</span></div></h1>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

              <li class="nav-item">
              <?= $this->Html->link(__('Animal'), ['controller'=>'Animal','action' => 'index'], ['class' => 'nav-link']) ?>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span><?= __('Publicaciones') ?></span>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><?= $this->Html->link(__('Publicaciones de Adopción'), ['controller'=>'PublicationAdoption','action' => 'index'], ['class' => 'dropdown-item']) ?></li>
                  <li><?= $this->Html->link(__('Publicaciones de Ayuda'), ['controller'=>'PublicationHelp','action' => 'index'], ['class' => 'dropdown-item']) ?></li>
                  <li><?= $this->Html->link(__('Publicaciones de Perdidos'), ['controller'=>'PublicationStray','action' => 'index'], ['class' => 'dropdown-item']) ?></li>
                </ul>
              </li>
              <li class="nav-item">
                <?= $this->Html->link(__('Eventos'), ['controller'=>'Event','action' => 'index'], ['class' => 'nav-link']) ?>
              </li>
                       
              <?php if($this->Identity->isLoggedIn()){
                  if($currentuserRol=="admin" || $currentuserRol =="shelter"){?>
                      <li class="nav-item"><?= $this->Html->link(__('Usuarios'), ['controller'=>'User','action' => 'index'], ['class' => 'nav-link']) ?></li>
                    <?php }else{ ?>
                      <li class="nav-item"><?= $this->Html->link(__('Protectoras'), ['controller'=>'User','action' => 'index'], ['class' => 'nav-link']) ?></li>
                    <?php } ?>
                    <li class="nav-item">
                      <?= $this->Html->link(__($currentuserUsername), ['controller'=>'User','action' => 'edit',$currentuserID], ['class' => 'nav-link ']) ?>
                    </li>
                      <li class="nav-item">
                      <div class="juntosmensajes"><?= $this->Html->link(__($this->Html->image("mail.png", ["alt" => "Mensajes",'class'=>'mensajesnav'])), ['action' => 'index','controller'=>'Message'],[ 'class'=>'nav-link ','escape' => false]) ?><p class="numeromensajes"><?php echo $nummessage ?></p></div>
                    </li>

                <?php }else{?>
                      <li class="nav-item"><?= $this->Html->link(__('Protectoras'), ['controller'=>'User','action' => 'index'], ['class' => 'nav-link']) ?></li>

                <?php } ?>

                    <li class="nav-item">
                      <?php 
                      if (I18n::getLocale() !== 'en_US'){ 
                      ?>              
                        <?= $this->Html->link('EN', ['action' => 'changeLang'], ['class' => 'nav-link ']); ?>
                        <?php
                      }else{ ?>
                        <?= $this->Html->link('ES', ['action' => 'changeLang'], ['class' => 'nav-link ']); ?>
                      <?php    } ?>
                    </li>     
                    <?php if($this->Identity->isLoggedIn()){?>
                    <li class="nav-item log">
                      
                    <a class="btn-login nav-link" href="<?= \Cake\Routing\Router::url(['controller' => 'User', 'action' => 'logout']) ?>">LOGOUT</a>
                    </li>
                    <?php }else{ ?>
                      <li class="nav-item log in"><a class="btn-login nav-link" href="<?= \Cake\Routing\Router::url(['controller' => 'User', 'action' => 'login']) ?>">LOGIN</a></li>
                <?php } ?>
            </ul>
          </div>
        </div>
      </nav>
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center section-bg">
    <div class="container">
      <div class="row justify-content-between gy-5">
        <div class="col-lg-5 order-2 order-lg-1 d-flex flex-column justify-content-center align-items-center align-items-lg-start text-center text-lg-start">
          <h2 data-aos="fade-up"><?= __('Bienvenid@ a ') ?><br> SAVEPETS</h2>
          <p data-aos="fade-up" data-aos-delay="100"><?= __('La nueva red de protectoras de animales.') ?> </p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
          <?php 
          if(!$this->Identity->isLoggedIn()){?>
            <a class="btn-login" href="<?= \Cake\Routing\Router::url(['controller' => 'User', 'action' => 'login']) ?>">LOGIN</a>
            <a href="" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-person"></i><span><a class="button float-right registrarsehome" href="<?= \Cake\Routing\Router::url(['controller' => 'User', 'action' => 'add']) ?>">Registrarse</a> </a>
      <?php } else{
                 ?>        
        <a class="btn-login" href="<?= \Cake\Routing\Router::url(['controller' => 'User', 'action' => 'logout']) ?>">LOGOUT</a>
        <?php } ?>
             
          </div>
        </div>
        <div class="col-lg-5 order-1 order-lg-2 text-center text-lg-start">
          <img src="img/hero-img.png" class="img-fluid" alt="" data-aos="zoom-out" data-aos-delay="300">
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->

  <main id="main">
    <!-- ======= Stats Counter Section ======= -->
    <section id="stats-counter" class="stats-counter">
      <div class="container" data-aos="zoom-out">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="285.000" data-purecounter-duration="2" class="purecounter"></span>
              <p><?= __('Abandonos en España en 2021') ?> </p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="70000000" data-purecounter-duration="3" class="purecounter"></span>
              <p><?= __('Millones de Abandonos en Estados Unidos en 2021') ?></p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="" data-purecounter-end="700000000" data-purecounter-duration="4" class="purecounter"></span>
              <p><?= __('Abandonos en el mundo') ?></p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-md-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="50" data-purecounter-duration="1" class="purecounter"></span>
              <p><?= __('Porcentaje Adoptados') ?></p>
            </div>
          </div><!-- End Stats Item -->

        </div>

      </div>
    </section><!-- End Stats Counter Section -->
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2><?= __('Sobre SAVEPETS') ?></h2>
          <p><?= __('¿Qué es ') ?><span>SAVEPETS</span>?</p>
        </div>

        <div class="row gy-4">
          <div class="col-lg-7 position-relative about-img" style="background-image: url(img/about.png) ;" data-aos="fade-up" data-aos-delay="150">
            <div class="call-us position-absolute">
              <h4><?= __('PARTICIPA') ?></h4>
              <p><?= __('NO LO DUDES') ?></p>
            </div>
          </div>
          <div class="col-lg-5 d-flex align-items-end" data-aos="fade-up" data-aos-delay="300">
            <div class="content ps-0 ps-lg-5">
              <p class="fst-italic">
              <?= __('SAVEPETS es una red de comunicación tanto entre diferentes protectoras de animales como entre protectoras y aquellas personas interesadas en adoptar o ayudar animales. 
                Entre las posibilidades que ofrece SAVEPETS está:') ?>
              </p>
              <ul>
                <li><i class="bi bi-check2-all"></i> <?= __('Estar informado sobre los animales en adopción y ponerse en contacto para realizar la adopción.') ?></li>
                <li><i class="bi bi-check2-all"></i> <?= __('Realizar publicaciones para pedir u ofrecer ayuda para los animales (ejemplo mantas, medicamentos,et). También hay publicaciones sobre los animales perdidos.') ?></li>
                <li><i class="bi bi-check2-all"></i> <?= __('Comunicarse por mensaje privado con las protectoras.') ?></li>
                <li><i class="bi bi-check2-all"></i> <?= __('Estar informado sobre las actividades que llevarán a cabo las protectoras.') ?></li>
                <li><i class="bi bi-check2-all"></i> <?= __('Apuntarte a la lista de acogida de una protectora.') ?></li>
              </ul>
              <p>
              <?= __('Toda ayuda es importante y será agradecida.') ?> 
              </p>

              <div class="position-relative mt-4">
                <img src="img/about-2.jpg" class="img-fluid" alt="">
              </div>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2><?= __('NUESTROS') ?></h2>
          <p><span><?= __('OBJETIVOS') ?></span></p>
        </div>

        <div class="row gy-4">

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
            <div class="objetivo-member">
              <div class="member-img">
                <img src="img/Objetivos/objetivo-1.jpg" class="img-fluid" alt="">
              </div>
              <div class="member-info">
                <h4><?= __('BUSCAR HOGAR') ?></h4>
                <span></span>
                <p><?= __('El principal objetivo de SAVEPETS es encontrar un buen hogar a todos los animales que carecen de uno.
                  Para poder llevarlo a cabo se publican los animales que están buscando una nueva casa. Además, se facilita la comunicación con la protectora en la que se encuentran.') ?>
                </p>
              </div>
            </div>
          </div><!-- End Objetivo -->

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
            <div class="objetivo-member">
              <div class="member-img">
                <img src="img/Objetivos/objetivo-2.jpg" class="img-fluid" alt="">
              </div>
              <div class="member-info">
                <h4><?= __('COMUNIDAD SOLIDARIA') ?></h4>
                <p><?= __('Todos los usuarios pueden ofrecer y pedir ayuda a los demás usuarios. Esta ayuda sería de medicamentos, mantas, comida, etc. ') ?></p>
              </div>
            </div>
          </div><!-- End Objetivo -->

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
            <div class="objetivo-member">
              <div class="member-img">
                <img src="img/Objetivos/objetivo-3.jpg" class="img-fluid" alt="">

              </div>
              <div class="member-info">
                <h4><?= __('DIFUSIÓN') ?></h4>
                <p><?= __('Se difunde no unicamente los animales a los que se le busca hogar, sino que también se informa sobre los animales perdidos y los eventos que realizan las protectoras. De esta forma se busca que la información llegue a un mayor número de personas.') ?></p>
              </div>
            </div>
          </div><!-- End Objetivo -->

        </div>

      </div>
    </section><!-- End objetiv Section -->


    <!-- ======= noticias Section ======= -->
    <section id="noticias" class="noticias">
      <div class="container-fluid" data-aos="fade-up">

        <div class="section-header">
          <h2><?= __('NOTICIAS') ?></h2>
          <p><?= __('¿QUÉ HA PASADO EN ') ?><span>SAVEPETS</span><?= __('ÚLTIMAMENTE?') ?></p>
        </div>

        <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url(img/noticias-1.jpg)">
              <h3><?= __('FIN DE LA CREACIÓN') ?></h3>
              <div class="date align-self-start"><?= __('Febrero 2023') ?></div>
              <p class="description">
              <?= __('Después de meses de trabajo SAVEPETS está finalizado, cumpliendo con todos los requisitos y funcionalidades previstas.') ?>
              </p>
            </div><!-- End Event item -->

            <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url(img/noticias-2.jpg)">
              <h3><?= __('EMPIEZA LA CREACIÓN') ?></h3>
              <div class="date align-self-start"><?= __('Septiembre 2022') ?></div>
              <p class="description">
              <?= __('Se empieza a llevar a cabo la idea planteada y esta irá evolucionando con el paso del tiempo.') ?>
              </p>
            </div><!-- End Event item -->

            <div class="swiper-slide event-item d-flex flex-column justify-content-end" style="background-image: url(img/noticias-3.jpg)">
              <h3><?= __('Surge la idea de SAVEPETS') ?></h3>
              <div class="date align-self-start"><?= __('Agosto 2022') ?></div>
              <p class="description">
              <?= __('Mientras se buscaba ideas para el trabajo fin de máster y se debatían ideas a la hora de la comida con otros miembros de la familia, surge la idea de la creación de una página web para las protectoras de animales. Esta idea evolucionó hasta la idea actual de SAVEPETS.') ?>              
              </p>
            </div><!-- End Event item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End noticias Section -->



  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Yummy</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer><!-- End Footer -->
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="plantilla/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="plantilla/aos/aos.js"></script>
  <script src="plantilla/glightbox/js/glightbox.min.js"></script>
  <script src="plantilla/purecounter/purecounter_vanilla.js"></script>
  <script src="plantilla/swiper/swiper-bundle.min.js"></script>
  <script src="plantilla/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="js/main.js"></script>

</body>

</html>