<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FosterList $fosterList
 * @var \Cake\Collection\CollectionInterface|string[] $user
 */
$this->loadHelper('Authentication.Identity');

if($this->Identity->isLoggedIn()){
    $currentuser = $this->request->getAttribute('identity');
    $currentuserID=$currentuser->id;
    $currentuserUsername=$currentuser->username;

}
?>
<!-- ======= Breadcrumbs ======= -->
   <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Añadir') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> 
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
          <p><?= __('Realizar publicación') ?> <span><?= __('adopción') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/about-2.jpg" class="img-fluid" alt="">

          <?= $this->Form->create($fosterList,['class'=>'php-email-form p-3 p-md-4']) ?>
            <div class="row">
            <h3 class="preguntaaddfosterlist"><span>¿ <?php echo $currentuserUsername?></span> <?= __(' quieres crear una lista de acogida?') ?></h3>
            <?php 
              if($this->Identity->isLoggedIn()){
                echo $this->Form->control('user_id',['type'=>'text','class'=>'form-control elemoculto', 'label' =>'', 'value'=>$currentuserID]); 
              }
            ?>
            <div class="text-center"><?= $this->Form->button(__('Crear')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
