<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Animal $animal
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
          <p><?= __('Añadir nuevo') ?> <span><?= __('animal') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/animalabout.png" class="img-fluid" alt="">

          <?= $this->Form->create($animal,['class'=>'php-email-form p-3 p-md-4','type'=>'file']) ?>

            <div class="row">
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('name',['class'=>'form-control','label'=> 'Nombre']); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php 
                        $opcionesEspecie=['dog'=>__('Perro'),'cat'=>__('Gato'),'bunny'=>__('Conejo'),'hamster'=>__('Hamster'),'snake'=>__('Serpiente'),'turtle'=>__('Tortuga'),'other'=>__('Otro')];
                        echo $this->Form->control('specie',['class'=>'form-control','label'=> __('Especie'),'options'=>$opcionesEspecie]); 
                    ?>
                </div>
            </div>
            <br>
            <div class="row">
                <?php echo $this->Form->control('race',['class'=>'form-control','label'=> __('Raza')]); ?><br>
            </div>
            <br>
            <div class="row">
                <div class="col-xl-6 form-group">
                    <?php 
                        $opcionesEstado=['unknown'=>__('Desconocido'),'healthy'=>__('Sano'),'sick'=>__('Enfermo'),'adopted'=>__('Adoptado'),'dead'=>__('Muerto'),'foster'=>__('Acogido'),'vet'=>__('Veterinario'),'other'=>__('Otro')];
                        echo $this->Form->control('state',['class'=>'form-control','label'=> __('Estado'),'options'=>$opcionesEstado]); 
                    ?>
                </div>
                <div class="col-xl-6 form-group">
                <?php 
                  $opcionesSex=['unknow'=>__('No se sabe'),'intact_female'=>__('Hembra'),'intact_male'=>__('Macho'),'neutered_female'=>__('Hembra esterilizada'),'castrated_male'=>__('Macho castrado')];
                  echo $this->Form->control('sex',['class'=>'form-control','label'=> __('Sexo'),'options'=>$opcionesSex]); 
                ?>
                </div>
            </div> 
            <br>
            <div class="row">
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('age',['class'=>'form-control','label'=> __('Edad')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                <?php 
                    $opcionesChip=['yes'=>__('Sí'),'no'=>__('No'),'unknown'=>__('No se sabe')];
                    echo $this->Form->control('chip',['class'=>'form-control','label'=> __('Chip'),'options'=>$opcionesChip]); ?>
                </div>
            </div> 
            <br>
            <div class="row">
                <?php echo $this->Form->control('image_file',['type'=>'file','class'=>'form-control','label'=> __('Imagen')]); ?>
            </div> 
            <br>
            <div class="row">
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('animal_shelter.start_date',['class'=>'form-control','label'=> __('Fecha inicio')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php 
                        echo $this->Form->control('animal_shelter.end_date',['empty' => true,'class'=>'form-control','label'=> __('Fecha fin'),]); 
                    ?>
                </div>
            </div>
            <br>
            <div class="row">
                <?php echo $this->Form->control('information',['class'=>'form-control','label'=> __('Información')]); ?>
            </div> 
            <br>
            <?php 
              $currentUser = $this->request->getAttribute('identity');
              $currentuserRol=$currentUser->role;
                if($currentuserRol=='admin'){?>
                  <div class="row select">
                    
                    <?php 

                    echo $this->Form->control('animal_shelter.user_id',['options' => $user,'label'=> __('Usuario')]); ?>
                  </div> 
                  <br>
              <?php
                }else{
                  $currentuserID=$currentUser->id;
                  echo $this->Form->control('animal_shelter.user_id',['value'=>$currentuserID,'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); 
                }
              ?>
            <div class="text-center"><?= $this->Form->button(__('Añadir')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
