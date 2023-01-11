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
          <h2><?= __('Editar') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> /
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $animal->id], ['confirm' => __('Estas seguro que quieres borrar al animal {0}?', $animal->name), 'class' => 'side-nav-item']) ?>                 </div>
            </aside>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->
    <!-- ======= Form Section ======= -->
    <section id="formsec" class="formsec">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <p><?= __('Editar') ?> <span><?= h($animal->name) ?></span></p>
        </div>
        <div class="section-content-form">
        <?php

          $imageAnimal=$animal->image;
          if(!empty($imageAnimal)&& !preg_match('/^animal-img\/$/',$imageAnimal)){ 
            $dir='/img/'.$imageAnimal;
        ?>
            <img src="<?php echo $dir ?>" class="img-fluid" alt="imagen animal "> 
          <?php
            }else{?>                  
              <img src="/img/animalabout.png" class="img-fluid" alt="">
          <?php } ?>

          <?= $this->Form->create($animal,['type'=>'file','class'=>'php-email-form p-3 p-md-4']) ?>
           
          <div class="row">
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('name',['class'=>'form-control','label'=> __('Nombre')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php 
                        $opcionesEspecie=['dog'=>__('Perro'),'cat'=>__('Gato'),'bunny'=>__('Conejo'),'hamster'=>__('Hamster'),'snake'=>__('Serpiente'),'turtle'=>__('Tortuga'),'other'=>__('Otro')];
                        echo $this->Form->control('specie',['class'=>'form-control','label'=> __('Especie'),'options'=>$opcionesEspecie, 'value'=>$animal->specie]); 
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
                        echo $this->Form->control('state',['class'=>'form-control','label'=> __('Estado'),'options'=>$opcionesEstado, 'value'=>$animal->state]); 
                    ?>
                </div>
                <div class="col-xl-6 form-group">
                <?php 
                  $opcionesSex=['unknow'=>__('No se sabe'),'intact_female'=>__('Hembra'),'intact_male'=>__('Macho'),'neutered_female'=>__('Hembra esterilizada'),'castrated_male'=>__('Macho castrado')];
                  echo $this->Form->control('sex',['class'=>'form-control','label'=> __('Sexo'),'options'=>$opcionesSex, 'value'=>$animal->sex]); 
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
                    echo $this->Form->control('chip',['class'=>'form-control','label'=> __('Chip'),'options'=>$opcionesChip, 'value'=>$animal->chip]); ?>
                </div>
            </div> 
            <br>
            <div class="row">
                <?php echo $this->Form->control('change_image',['type'=>'file','class'=>'form-control','label'=> __('Imagen')]); ?>
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
                $userIdentity = $this->request->getAttribute('identity');
                $currentuserRol=$userIdentity->role;
                if($currentuserRol=="admin"){?>
                   <div class="row select">
                <?php
                  echo $this->Form->control('animal_shelter.user_id',['options' => $user,'label'=> __('Usuario')]); 
   
                }else{ ?>
                  <div class="row">
                  <p><?= __('Protectora') ?> </p>

                    <p><?php echo $userName ?></p>
                      <?php 
                      echo $this->Form->control('animal_shelter.user_id',['disabled'=>'true','type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); ?>
                  </div> 
                <?php  } ?>
            <br>
            <div class="text-center"><?= $this->Form->button(__('Editar')) ?></div>

            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
