<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 */
$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
}
?>
<div class="row">
   <!-- ======= Breadcrumbs ======= -->
   <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Consultar') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> 
                <?php 
                    if($this->Identity->isLoggedIn()){
                        if($currentuserRol=="admin" || $currentuserRol=="shelter"){ ?>
                            /<?= $this->Html->link(__('Añadir'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>

                            <?php if($currentuserRol=="admin" || $currentuserID==$event->user_id){ ?>
                                / <?= $this->Html->link(__('Editar'), ['action' => 'edit', $event->id], ['class' => 'side-nav-item']) ?>  / 
                       
                                <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete','controller' => 'Address', $event->addres_id,'Event',NULL], 
                                ['confirm' => __('Estas seguro de querer eliminar el evento {0}?', $event->title)]) ?>
                            <?php }
                         }
                    } ?>
                </div>
            </aside>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->
     <!-- ======= Individual Section ======= -->
 <section id="individual" class="individual">
  <div class="container" data-aos="fade-up">

    <div class="section-header">
      <h2><?= __('Los datos sobre el ') ?></h2>
      <p><?= __('evento ') ?> <span><?= h($event->title) ?></span>!!</p>
    </div>

    <div class="row g-0">
    <div class="col-lg-4 reservation-img" style="background-image: url(/img/event.png);" data-aos="zoom-out" data-aos-delay="200"></div>

      <div class="col-lg-8 d-flex align-items-center reservation-form-bg">
        <form action="forms/individual.php" method="post" role="form" class="php-email-form" data-aos="fade-up" data-aos-delay="100">
          <div class="row gy-4">
            <div class="row">
              <h5><?= __('Protectora') ?></h5>
                  <h3> <?= $event->has('user') ? $this->Html->link($event->user->username, ['controller' => 'User', 'action' => 'view', $event->user_id]) : '' ?></h3> 
                  <div class="validate"></div>
                </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Inicio') ?>:</h5>
              <?php $fecha=$event->start_date;
                    echo $fecha->format('d/m/Y H:i:s'); ?>
                <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Fin') ?>:</h5>
              <?php $fechafin=$event->end_date;
                    echo $fechafin->format('d/m/Y H:i:s'); ?>
              <div class="validate"></div>
              </div>
              <div class="row mensajeevento">
              <h5><?= __('Mensaje') ?>:</h5>
              <p><?= h($event->message) ?></p> 
              <div class="validate"></div>
                </div>
              <br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('País') ?>:</h5>
              <?= h($event->addres->country) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Provincia') ?>:</h5>
              <?= h($event->addres->province) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Ciudad') ?>:</h5>
              <?= h($event->addres->city) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Calle') ?>:</h5>
              <?= h($event->addres->street) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Código Postal') ?>:</h5>
              <?= h($event->addres->postal_code) ?>
              <div class="validate"></div>
            </div><br><br>
          </div>
        </form>
      </div><!-- End Form -->
      <div>    
  </div>
 </div>
 <br>
<br>
