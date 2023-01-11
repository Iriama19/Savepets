<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AnimalAdoption $animalAdoption
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
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $animalAdoption->id], ['confirm' => __('Estas seguro que quieres borrar la adopción de {0} por parte de {1}?', $animalAdoption->animal_id, $animalAdoption->user_id), 'class' => 'side-nav-item']) ?> 
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

          <?php
            if(!empty($AnimalImg)&& !preg_match('/^animal-img\/$/',$AnimalImg)){ 
              $dir='/img/'.$AnimalImg;
          ?>
            <img src="<?php echo $dir ?>" class="img-fluid" alt="imagen animal "> 
          <?php
            }else{ ?>
              <img src="/img/animalabout.png" class="img-fluid" alt="imagen animal vacia"> 
          <?php } ?>
          <?= $this->Form->create($animalAdoption,['class'=>'php-email-form p-3 p-md-4']) ?>
           
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
