<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Animal> $animal
 */
?>
<div class="animal index content">

    
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2><?= __('LISTA') ?></h2>
          <p> <span><?= __('ANIMALES') ?></span></p>

          <?php 
          $this->loadHelper('Authentication.Identity');
          if($this->Identity->isLoggedIn()){
            $user = $this->request->getAttribute('identity');
            $currentuserRol=$user->role;
            if($currentuserRol=="admin" || $currentuserRol=="shelter"){?>
          <div>
            <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add'],['escape' => false]) ?></button>                                    
          </div>
          <button type="submit" class="listbtn unirsebtn"><?= $this->Html->link(__('Mis Adopciones'), ['controller' => 'AnimalAdoption','action' => 'index'],['escape' => false]) ?></button>                                    

          <?php
            }?>
            <button type="submit" class="listbtn unirsebtn"><?= $this->Html->link(__('Listas Acogida'), ['controller' => 'FosterList','action' => 'index'],['escape' => false]) ?></button>                                    
          <?php
           }
          ?>

          <?= 
            $this->Form->create(null, ['type' => 'get','class'=>'formsearchform']) ?>
              <?php $opcionesEspecie=[''=>'','dog'=>__('Perro'),'cat'=>__('Gato'),'bunny'=>__('Conejo'),'hamster'=>__('Hamster'),'snake'=>__('Serpiente'),'turtle'=>__('Tortuga'),'other'=>__('Otro')];
                echo $this->Form->control('keyEspecie',['class'=>'formsearch select ani','label' => __('Buscar por especie: '), 'value' => $this->request->getQuery('keyEspecie'),'options'=>$opcionesEspecie]) ?>
              <?php echo $this->Form->control('keyRaza', ['class'=>'formsearch ani','label' => __('Buscar por raza: '), 'value' => $this->request->getQuery('keyRaza'), 'autocomplete' => 'off']) ?>
              <?php $opcionesSexo=[''=>'','unknow'=>__('No se sabe'),'intact_female'=>__('Hembra'),'intact_male'=>__('Macho'),'neutered_female'=>__('Hembra esterilizada'),'castrated_male'=>__('Macho castrado')];
                echo $this->Form->control('keySexo',['class'=>'formsearch select ani','label' => __('Buscar por sexo: '), 'value' => $this->request->getQuery('keySexo'),'options'=>$opcionesSexo]) ?>
              <br>
                <div class="text-center"><?= $this->Form->button(__('Buscar')) ?></div>

            <?= $this->Form->end();?>
          <?php 
          $this->loadHelper('Authentication.Identity');
          if($this->Identity->isLoggedIn()){
            $user = $this->request->getAttribute('identity');
            $currentuserUsername=$user->username;
            if($currentuserRol=="admin" || $currentuserRol=="standar"){
            ?>
            <button type="submit" class="listbtn unirsebtn recomendar"><?= $this->Html->link(__('Recomendaciones'), ['controller' => 'Animal','action' => 'index',$currentuserUsername],['escape' => false]) ?></button>                                    
            <span><?=  __('* Las recomendaciones pueden tardar un poco.') ?></span>

            <?php } 
          }?>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($animal as $animal): 
                  @$this->Html->image($user->image, ['style' => 'max-width:50px;height:50px;border-radius:50%;']);

                  ?>
                <tr>        
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member">
                        <div class="member-img">
                            <?php
                              if(!empty($animal->image)&& !preg_match('/^animal-img\/$/',$animal->image)){ 
                                $dir='/img/'.$animal->image;
                              ?>
                                <img src="<?php echo $dir ?>" class="img-fluid index" alt="imagen animal "> 
                            <?php

                            }else{ ?>
                              
                              <img src="/img/animalabout.png" class="img-fluid index" alt="imagen animal vacia"> 
                            <?php } ?>
                        </div>
                        <div class="member-info">
                            <h4><?= h($animal->name) ?></h4>
                            <span></span>
                            <?php if($animal->animal_shelter != NULL){ ?>
                            <p><?= h($animal->animal_shelter->start_date) ?> - <?= h($animal->animal_shelter->end_date) ?></p> 
                            <?php } ?>
                            <br>
                            <div class="text-centerlist">

                                   <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $animal->id],['escape' => false]) ?></button>  
                                   
                                   <?php 
                                   $this->loadHelper('Authentication.Identity');
                                      if($this->Identity->isLoggedIn()){
                                        $user = $this->request->getAttribute('identity');
                                        $currentuserRol=$user->role;
                                        $currentuserId=$user->id;

                                          if($currentuserRol=="admin" || ($currentuserRol=="shelter" && $currentuserId==$animal->animal_shelter->user_id)){?>
                                            <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $animal->id],['escape' => false]) ?></button>
                                            <button type="submit" class="listbtn"><?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Animal"] )), ['action' => 'delete', $animal->id], 
                                              ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar el animal {0}?', $animal->name)],['escape' => false]) ?></button>
                                  <?php }}?>
                            
                            </div>
                        </div>
                        </div>

                    </div><!-- End Objetivo -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
      </div>
      <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primera')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('siguiente') . ' >') ?>
            <?= $this->Paginator->last(__('última') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrandese {{current}} de {{count}}.')) ?></p>
    </div>
    </section><!-- End objetiv Section -->

  </main><!-- End #main -->
