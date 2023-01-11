<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AnimalAdoption> $animalAdoption
 */
?>

<div class="animalAdoption index content">
   
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2><?= __('LISTA') ?></h2>
          <p> <span><?= __('ADOPCIONES') ?></span></p>
          <?php 
          $this->loadHelper('Authentication.Identity');
          if($this->Identity->isLoggedIn()){
            $user = $this->request->getAttribute('identity');
            $currentuserRol=$user->role;
            if($currentuserRol=="admin" || $currentuserRol=="shelter"){?>
          <div>
            <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add'],['escape' => false]) ?></button>                                    
          </div>
          <?php
            }
           }?>
            <?= 
              $this->Form->create(null, ['type' => 'get','class'=>'formsearchform']) ?>
              <?php echo $this->Form->control('keyAnimal', ['class'=>'formsearch ani','label' => __('Buscar por nombre animal: '), 'value' => $this->request->getQuery('keyAnimal'), 'autocomplete' => 'off']) ?>
              <?php echo $this->Form->control('keyUsuario', ['class'=>'formsearch ani','label' => __('Buscar por alias de usuario: '), 'value' => $this->request->getQuery('keyUsuario'), 'autocomplete' => 'off']) ?>
              <br>
                <div class="text-center"><?= $this->Form->button(__('Buscar')) ?></div>

            <?= $this->Form->end();?>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
            <?php foreach ($animalAdoption as $animalAdoption): ?>
                <tr>        
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member">
                        <div class="member-img">
                          <?php
                            $imageAnimal=$animalAdoption->animal->image;
                            if(!empty($imageAnimal)&& !preg_match('/^animal-img\/$/',$imageAnimal)){ 
                            $dir='/img/'.$imageAnimal;
                          ?>
                            <img src="<?php echo $dir ?>" class="img-fluid index" alt="imagen animal "> 
                          <?php

                          }else{ ?>
                              
                            <img src="/img/animalabout.png" class="img-fluid index" alt="imagen animal vacia"> 
                          <?php } ?>
                        </div>
                        <div class="member-info">
                            <p><?= $animalAdoption->has('animal') ? $this->Html->link($animalAdoption->animal->name, ['controller' => 'Animal', 'action' => 'view', $animalAdoption->animal->id]) : '' ?></p><br>
                            <p><?= $animalAdoption->has('user') ? $this->Html->link($animalAdoption->user->name, ['controller' => 'Address', 'action' => 'view', $animalAdoption->user->addres_id]) : '' ?></p><br>

                            <div class="text-centerlist">
                                <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $animalAdoption->id],['escape' => false]) ?></button>                                    
                                
                                <?php 
                                  $this->loadHelper('Authentication.Identity');
                                  $isLogged=$this->Identity->isLoggedIn();
                                  if($isLogged){
                                    $userIdentity=$this->request->getAttribute('identity');
                                    $currentuserRol=$userIdentity->role;
                                    if($currentuserRol=="admin" || $currentuserRol=="shelter"){
                                        $currentuserId=$userIdentity->id;

                                        if($currentuserId==$animalAdoption->user->id || $currentuserRol=="admin" ){
                                          ?>
                                        <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $animalAdoption->id],['escape' => false]) ?></button>
                                        <button type="submit" class="listbtn"><?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Adoption"] )), ['action' => 'delete', $animalAdoption->id], 
                                            ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la adopcion de {0} por parte de {1}?', $animalAdoption->animal->name, $animalAdoption->user->name)],['escape' => false]) ?></button>
                                <?php
                                        }
                                    }
                                  }?>
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
