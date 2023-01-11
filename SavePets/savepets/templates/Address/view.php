<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Addres $addres
 */
?>
   <!-- ======= Breadcrumbs ======= -->
   <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Consultar') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> /
                <?php 
                    $this->loadHelper('Authentication.Identity');
                    if($this->Identity->isLoggedIn()){
                      $currentuser = $this->request->getAttribute('identity');
                      $currentuserRol=$currentuser->role;
                      $currentuserUsername=$currentuser->username;

                        if($currentuserRol=="admin" || $currentuserUsername==$addres->user->username){ ?>
                          <?= $this->Html->link(__('Editar'), ['action' => 'edit', $addres->id], ['class' => 'side-nav-item']) ?>  / 
                          <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $addres->id], ['confirm' => __('Estas seguro que quieres borrar al usuario {0}?', $addres->username), 'class' => 'side-nav-item']) ?> 
                <?php }
              }?>
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
      <h2><?= __('Los datos') ?></h2>
      <p><?= __('sobre') ?> <span><?= h($addres->user->username) ?></span>!!</p>
    </div>

    <div class="row g-0">

      <div class="col-lg-4 reservation-img" style="background-image: url(/img/userphoto.png);" data-aos="zoom-out" data-aos-delay="200"></div>

      <div class="col-lg-8 d-flex align-items-center reservation-form-bg">
        <form action="forms/individual.php" method="post" role="form" class="php-email-form" data-aos="fade-up" data-aos-delay="100">
          <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
              <h5><?= __('DNI/CIF/NIE') ?></h5>
              <?= h($addres->user->DNI_CIF) ?>
                <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Nombre') ?>:</h5>
              <?= h($addres->user->name) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Apellido') ?>:</h5>
              <?= h($addres->user->lastname) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Email') ?>:</h5>
              <?= h($addres->user->email) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Teléfono') ?>:</h5>
              <?= h($addres->user->phone) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('País') ?>:</h5>
              <?= h($addres->country) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Provincia') ?>:</h5>
              <?= h($addres->province) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Ciudad') ?>:</h5>
              <?= h($addres->city) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Ciudad') ?>:</h5>
              <?= h($addres->street) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Código Postal') ?>:</h5>
              <?= h($addres->postal_code) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Rol') ?></h5>
              <div hidden> <?= $rolusuario=$addres->user->role;?> </div> 
            <?php
             switch($rolusuario){
                case "standar":
                    echo  __('Estandar');
                    break;
                case "shelter":
                    echo  __('Protectora');
                    break;
                case "admin":
                    echo  __('Admin');
                    break;
                default:
                    echo  __(' ');
                    break;
                }?>            
              <div class="validate"></div>
            </div>
          </div>
        </form>
      </div><!-- End Form -->
      <div>    
  </div>
 </div>
 <br>
<br>
