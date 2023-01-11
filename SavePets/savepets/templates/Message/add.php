<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 * @var \Cake\Collection\CollectionInterface|string[] $user
 */
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
          <p><?= __('Enviar') ?> <span><?= __('Mensaje') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/about-2.jpg" class="img-fluid" alt="">

          <?= $this->Form->create($message,['class'=>'php-email-form p-3 p-md-4','type'=>'file']) ?>

            <div class="row">
              <div class="col-xl-6 form-group">
                   <?php echo $this->Form->control('title',['class'=>'form-control','label'=> __('Título')]); ?>
              </div>
            <div class="row select">
                    <?php echo $this->Form->control('receiver_user_id',['options' => $user,'label'=> __('Destinatario')]); ?>
            </div> 
            <div class="row">
                <?php echo $this->Form->control('content',['class'=>'form-control big','type'=>'textarea' ,'label'=> __('Mensaje')]); ?>
            </div>
            <?php 
              $this->loadHelper('Authentication.Identity');
              if($this->Identity->isLoggedIn()){
                $currentuser = $this->request->getAttribute('identity');
                $currentuserID=$currentuser->id;
                echo $this->Form->control('transmitter_user_id',['type'=>'text','class'=>'form-control elemoculto', 'label' =>'','value'=>$currentuserID]); 
              }  
              
              $actualdate=date('Y-m-d H:i:s');
              echo $this->Form->control('message_date',['type'=>'text','class'=>'form-control elemoculto', 'label' =>'','value'=>$actualdate]);

              echo $this->Form->control('readed',['value'=> 'no','type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); 
              ?>
              
            <div class="text-center"><?= $this->Form->button(__('Enviar')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
