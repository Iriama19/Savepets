<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\I18n\I18n;

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Savepets</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <?php echo $this->Html->meta('icon', 'img/logo.png', ['type'=>'image/png'])?>
  <!-- <link href="/var/www/html/savepets/webroot/img/logo.png" rel="icon">
  <link href="/var/www/html/savepets/webroot/img/logo.png" rel="apple-touch-icon">-->

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Vendor CSS Files -->


  <!-- Template Main CSS File -->
      <?= $this->Html->css(['bootstrap.min','aos','glightbox.min','swiper-bundle.min','cake']) ?>

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

            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
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


  <!-- Vendor JS Files -->


  <!-- Template Main and vendor JS File -->

  <?= $this->Html->script(['bootstrap.bundle.min','aos','glightbox.min','purecounter_vanilla','swiper-bundle.min','main']) ?>

</body>

</html>