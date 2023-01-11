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
          <h2><?= __('Consultar') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> 

                <?php 
                $this->loadHelper('Authentication.Identity');
                if($this->Identity->isLoggedIn()){
                  $user = $this->request->getAttribute('identity');
                  $currentuserRol=$user->role;
                  if($currentuserRol=="admin" || $currentuserRol=="shelter"){?>
                    /<?= $this->Html->link(__('Añadir'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                    <?php if($currentUserID==$user->id||$currentuserRol=="admin"){?>/
                    <?= $this->Html->link(__('Editar'), ['action' => 'edit', $animal->id], ['class' => 'side-nav-item']) ?>  / 

                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $animal->id], ['confirm' => __('Estas seguro que quieres borrar al animal {0}?', $animal->name), 'class' => 'side-nav-item']) ?>                 </div>
                    <?php }} ?>
                <?php }?> 
              </aside>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->
     <!-- ======= Individual Section ======= -->
 <section id="individual" class="individual">
  <div class="container" data-aos="fade-up">

    <div class="section-header">
      <h2><?= __('Los datos') ?></h2>
      <p><?= __('sobre') ?> <span><?= h($animal->name) ?></span>!!</p>
    </div>

    <div class="row g-0">
      <?php
        $imageAnimal=$animal->image;
        if(!empty($imageAnimal)&& !preg_match('/^animal-img\/$/',$imageAnimal)){ 
          $dir='/img/'.$imageAnimal;
      ?>
          <div class="col-lg-4 reservation-img" style="background-image: url(<?php echo $dir ?>);" data-aos="zoom-out" data-aos-delay="200"></div>
        <?php  }else{?>                  
          <div class="col-lg-4 reservation-img" style="background-image: url(/img/animalabout.png);" data-aos="zoom-out" data-aos-delay="200"></div>
      <?php } ?>

      <div class="col-lg-8 d-flex align-items-center reservation-form-bg">
        <form action="forms/individual.php" method="post" role="form" class="php-email-form" data-aos="fade-up" data-aos-delay="100">
          <div class="row gy-4">

            <div class="col-lg-4 col-md-6">
            <h5><?= __('Especie') ?>:</h5>
            <div hidden> <?= $especie=$animal->specie;?> </div> 
            <?php
             switch($especie){
                case "dog":
                    echo  __('Perro');
                    break;
                case "cat":
                    echo  __('Gato');
                    break;
                case "bunny":
                    echo  __('Conejo');
                    break;
                case "hamster":
                    echo  __('Hamster');
                    break;
                case "snake":
                    echo  __('Serpiente');
                    break;
                case "turtle":
                    echo  __('Tortuga');
                    break;
                case "other":
                    echo  __('Otro');
                    break;
                default:
                    echo  __(' ');
                    break;
                }?>
              
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Raza') ?>:</h5>
              <?= h($animal->race) ?>
              <div class="validate"></div>
            </div>

            <div class="col-lg-4 col-md-6">
            <h5><?= __('Estado') ?>:</h5>
            <div hidden> <?= $estadoanimal=$animal->state;?> </div> 
            <?php
             switch($estadoanimal){
                case "unknown":
                    echo  __('Desconocido');
                    break;
                case "healthy":
                    echo  __('Sano');
                    break;
                case "sick":
                    echo  __('Enfermo');
                    break;
                case "adopted":
                    echo  __('Adoptado');
                    break;
                case "dead":
                    echo  __('Muerto');
                    break;
                case "foster":
                    echo  __('Acogido');
                    break;
                case "vet":
                    echo  __('Veterinario');
                    break;
                case "other":
                    echo  __('Otro');
                    break;
                default:
                    echo  __(' ');
                    break;
                }?>              
                <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Sexo') ?>:</h5>
            <div hidden> <?= $sexo=$animal->sex;?> </div> 
            <?php
             switch($sexo){
                case "unknow":
                    echo  __('No se sabe');
                    break;
                case "intact_female":
                    echo  __('Hembra');
                    break;
                case "intact_male":
                    echo  __('Macho');
                    break;
                case "neutered_female":
                    echo  __('Hembra esterilizada');
                    break;
                case "castrated_male":
                    echo  __('Hembra');
                    break;
                case "intact_male":
                    echo  __('Macho castrado');
                    break;
                default:
                    echo  __(' ');
                    break;
                }?>                
            <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
            <h5><?= __('Edad') ?>:</h5>
              <?= h($animal->age) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Chip') ?>:</h5>
              <div hidden> <?= $llevachip=$animal->chip;?> </div> 
            <?php
             switch($llevachip){
                case "yes":
                    echo  __('Sí');
                    break;
                case "no":
                    echo  __('No');
                    break;
                case "unknown":
                    echo  __('No se sabe');
                    break;
                default:
                    echo  __(' ');
                    break;
                }?>              
            <div class="validate"></div>
            </div>

            <div class="col-lg-4 col-md-6">
              <h5><?= __('Fecha inicio') ?>:</h5>
              <?= h($animal->animal_shelter->start_date) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Fecha fin') ?>:</h5>
              <?= h($animal->animal_shelter->end_date) ?>
              <div class="validate"></div>
            </div>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Usuario') ?>:</h5>
              <?= 
              $this->Html->link($currentUserName, ['controller' => 'User', 'action' => 'view', $currentUserID]) ?>
              <div class="validate"></div>
            </div>
          </div><br>
          <div class="col-lg-4 col-md-6">
            <h5><?= __('Información') ?>:</h5>
              <?= h($animal->information) ?>
              <div class="validate"></div>
            </div>
        </form>
      </div><!-- End Form -->
      <br>
    <div>    
  </div>
 </div>
<br><br>