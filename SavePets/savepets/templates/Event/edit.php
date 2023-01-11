<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 */
?>
   <!-- ======= Breadcrumbs ======= -->
   <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Editar') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> 

                <?php 
                    $this->loadHelper('Authentication.Identity');
                    if($this->Identity->isLoggedIn()){
                      $currentuser = $this->request->getAttribute('identity');
                      $currentuserRol=$currentuser->role;
                      $currentuserUsername=$currentuser->username;
                      if($currentuserRol=="admin" || $currentuserRol=="shelter"){ ?>
                            /<?= $this->Html->link(__('Añadir'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                        <?php if($currentuserRol=="admin" || $currentuserUsername==$user->username){ ?>
                           / <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete','controller' => 'Address', $event->addres_id,'Event',NULL], 
                                    ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar el evento {0}?', $event->title)],['escape' => false]) ?> 
                
                <?php 
                            } 
                        } 
                    } 
                ?>
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
          <p><?= __('Editar') ?> <span><?= h($event->title) ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/event.png" class="img-fluid" alt="">

          <?= $this->Form->create($event,['class'=>'php-email-form p-3 p-md-4']) ?>
          <div class="row">
                   <?php echo $this->Form->control('title',['class'=>'form-control','label'=> __('Titulo')]); ?>
            </div>
            
              <div class="row">

                <div class="col-xl-6 form-group">
                <?php 
                    echo $this->Form->control('start_date',['class'=>'form-control','label'=> __('Inicio')]); 
                ?>
                </div>
                <div class="col-xl-6 form-group">
                <?php 
                    echo $this->Form->control('end_date',['class'=>'form-control','label'=> __('Fin')]); 
                ?>
                </div>
            </div>
            <div class="row">
                <?php echo $this->Form->control('message',['class'=>'form-control big','type'=>'textarea' ,'label'=> __('Mensaje')]); ?>
            </div>
                        <div class="row">
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('addres.country',['class'=>'form-control','label'=> __('País')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                <?php echo $this->Form->control('addres.province',['class'=>'form-control','label'=> __('Provincia')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 form-group">
                   <?php echo $this->Form->control('addres.city',['class'=>'form-control','label'=> __('Ciudad')]); ?>
                                     </div>
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('addres.street',['class'=>'form-control','label'=> __('Calle')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('addres.postal_code',['type'=>'number','class'=>'form-control','label'=> __('Código Postal')]); ?>
                </div>
                
            </div>
            <br>
            <div class="text-center"><?= $this->Form->button(__('Editar')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->





