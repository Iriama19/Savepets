<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AnimalShelter $animalShelter
 * @var string[]|\Cake\Collection\CollectionInterface $user
 * @var string[]|\Cake\Collection\CollectionInterface $animal
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
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> /
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $animalShelter->id], ['confirm' => __('Estas seguro que quieres borrar la estancia en la protectora {1} de {0}?', $animalShelter->animal_id,$animalShelter->user_id), 'class' => 'side-nav-item']) ?> 
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
          <p><?= __('Editar') ?>  <span><?= __('adopción') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/animalabout.png" class="img-fluid" alt="">

          <?= $this->Form->create($animalShelter,['class'=>'php-email-form p-3 p-md-4']) ?>
           
             <div class="row select">
                <?php echo $this->Form->control('user_id',['options' => $user,'label'=> __('Usuario')]); ?><br>
            </div>
            <br>
            <div class="row select">
                <?php echo $this->Form->control('animal_id',['options' => $animal,'label'=> __('Animal')]); ?>
            </div> 
            <br>
            <div class="row">
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('start_date',['class'=>'form-control','label'=> __('Fecha inicio')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php 
                        echo $this->Form->control('end_date',['empty' => true,'class'=>'form-control','label'=> __('Fecha fin')]); 
                    ?>
                </div>
          </div>
            <br>
            <br>
            <div class="text-center"><?= $this->Form->button(__('Editar')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
