<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FosterList $fosterList
 */

$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
}
?>

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
                      if($currentuserRol=="admin" || $currentuserID==$fosterList->user_id){ ?>

                        / <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $fosterList->id], 
                        ['confirm' => __('Estas seguro de querer eliminar la lista de acogida ?'), 'class' => 'side-nav-item']) ?>
                 </div>
            
                <?php }
              }?>
                </div>
            </aside>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->
     <!-- ======= Individual Section ======= -->

     <div class=" d-flex align-items-stretch publication view" data-aos="fade-up" data-aos-delay="100">
        <div class="objetivo-member publication view">
          <div class="member-info">
            <div class='member-info head'>
            <h3> <?= $fosterList->has('user') ? $this->Html->link($fosterList->user->username, ['controller' => 'User', 'action' => 'view', $fosterList->user->id]) : '' ?></h3> 
              </div>
          </div><br>
          <div class="col-lg-4 col-md-6">
              <h5><?= __('País') ?>:</h5>
              <?= h($address->country) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Provincia') ?>:</h5>
              <?= h($address->province) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Ciudad') ?>:</h5>
              <?= h($address->city) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Calle') ?>:</h5>
              <?= h($address->street) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Código Postal') ?>:</h5>
              <?= h($address->postal_code) ?>
              <div class="validate"></div>
            </div><br>
          <?php if($existe==NULL && $currentuserRol != 'shelter'){?>
                <button type="submit" class="listbtn unirsebtn"><?= $this->Html->link(__('Unirse'), ['controller' => 'FosterListUser','action' => 'add', $fosterList->id],['escape' => false]) ?></button>                                    
            <?php } ?>
        </div>
      </div>

    </div><!-- End Objetivo -->