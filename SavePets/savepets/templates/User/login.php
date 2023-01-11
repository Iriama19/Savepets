




<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \Cake\Collection\CollectionInterface|string[] $feature
 * @var \Cake\Collection\CollectionInterface|string[] $fosterList
 * @var \Cake\Collection\CollectionInterface|string[] $profile
 */
?>

   <!-- ======= Breadcrumbs ======= -->
   <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Login') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                    <a class="button float-right registrarsehome" href="<?= \Cake\Routing\Router::url(['controller' => 'User', 'action' => 'add']) ?>"><?= __('Registrarse') ?></a>
                </div>
            </aside>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->
    <!-- ======= Form Section ======= -->
    <section id="formsec" class="formsec">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <p><span><?= __('LOGIN') ?></span></p>
        </div>
        <div class="section-content-form login">

          <img src="/img/about-2.jpg" class="img-fluid" alt="">

          <?= $this->Form->create();?>

            <div class="row">
                <div class="form-group">
                    <?php echo $this->Form->control('DNI_CIF',['required' => true,'class'=>'form-control','label'=> __('DNI/NIE/CIF')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                <?php echo $this->Form->control('password',['required' => true,'class'=>'form-control','label'=> __('Contraseña')]); ?>
                </div>
            </div>
            <div class="loginbtn">
                <div class="text-center"><?= $this->Form->button(__('Login')) ?>          
                    <a class="button float-right registrarsehome" href="<?= \Cake\Routing\Router::url(['controller' => 'User', 'action' => 'add']) ?>"><?= __('Registrarse') ?></a> 
                </div>
            </div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
