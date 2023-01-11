<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AnimalAdoption $animalAdoption
 * @var \Cake\Collection\CollectionInterface|string[] $user
 * @var \Cake\Collection\CollectionInterface|string[] $animal
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
          <p><?= __('Añadir nueva') ?> <span><?= __('adopción') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/animalabout.png" class="img-fluid" alt="">

          <?= $this->Form->create($animalAdoption,['class'=>'php-email-form p-3 p-md-4']) ?>

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
            <?php 
              $currentUser = $this->request->getAttribute('identity');
              $currentuserRol=$currentUser->role;
                if($currentuserRol=='admin'){?>
                  <div class="row select">
                    <?php echo $this->Form->control('user_id',['options' => $user,'label'=> __('Usuario')]); ?>
                  </div> 
                  <br>
              <?php
                }else{
                  $currentuserID=$currentUser->id;
                  echo $this->Form->control('user_id',['value'=>$currentuserID, 'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); 
                }
              ?>
              <div class="text-center"><?= $this->Form->button(__('Añadir')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
