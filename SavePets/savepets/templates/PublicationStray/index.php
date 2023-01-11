<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PublicationStray> $publicationStray
 */

$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
  $currentuserUsername=$currentuser->username;

}
?>

<div class="publicationStray index content">
    
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2><?= __('PUBLICACIONES') ?></h2>
            <p> <span><?= __('ANIMALES PERDIDOS') ?></span></p>
            <?php 
                if($this->Identity->isLoggedIn() && ($currentuserRol=="admin" || $currentuserRol == "shelter")){ ?>
                <div>
                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add'],['escape' => false]) ?></button>                                    
                </div>
                <?php
                    
                }?>
            <?= 
                $this->Form->create(null, ['type' => 'get','class'=>'formsearchform']) ?>
                <?php 
                
                    $opciones=[''=>'','yes'=>__('Sí'),'No'=>__('No')];
                    echo $this->Form->control('keyUrgente',['class'=>'formsearch select','label' => __('Buscar Urgente: '), 'value' => $this->request->getQuery('keyUrgente'),'options'=>$opciones]) ?>
                <?php echo $this->Form->control('keyCiudad', ['class'=>'formsearch ani','label' => __('Buscar por ciudad: '), 'value' => $this->request->getQuery('keyCiudad'), 'autocomplete' => 'off']) ?>
                <?php echo $this->Form->control('keyProvincia', ['class'=>'formsearch ani','label' => __('Buscar por provincia: '), 'value' => $this->request->getQuery('keyProvincia'), 'autocomplete' => 'off']) ?>
                <?php echo $this->Form->control('keyPais', ['class'=>'formsearch ani','label' => __('Buscar por país: '), 'value' => $this->request->getQuery('keyPais'), 'autocomplete' => 'off']) ?>

                <div class="text-center"><?= $this->Form->button(__('Buscar')) ?></div>

            <?= $this->Form->end();?>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($publicationStray as $publicationStray): ?>
                <tr>        
                    <div class=" d-flex align-items-stretch publication" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member publication">
                        <div class="member-info">
                            <div class='member-info head'>
                                <?php 
                                if($publicationStray->user->role=='admin'){ ?>
                                    <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
                                <?php } elseif($publicationStray->user->role=='shelter'){ ?>
                                    <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
                                <?php }else{ ?>
                                    <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
                                <?php } ?>
                                <?php 
                                if($this->Identity->isLoggedIn() && ($currentuserRol=="admin" || $currentuserRol=="shelter" || $publicationStray->user->role =="shelter" ||$currentuserID==$publicationStray->user_id)){
                                    ?>
                                        <h3> <?= $publicationStray->has('user') ? $this->Html->link($publicationStray->user->username, ['controller' => 'User', 'action' => 'view', $publicationStray->user->id]) : '' ?></h3> 
                                <?php }else{?>
                                        <h3><b><?= h($publicationStray->user->username) ?></b></h3>
                                <?php } ?>
                                <h5 class="fechaformatocolor"><span><?php $fecha=$publicationStray->publication->publication_date;
                                echo $fecha->format('d/m/Y H:i:s'); ?></span></h5>
                                </div>
                            </div>
                            <h2><?= h($publicationStray->publication->title) ?></h2> 
                            <?php
                              if(!empty($publicationStray->image)&& !preg_match('/^strayanimal-img\/$/',$publicationStray->image)){ 
                                $dir='/img/'.$publicationStray->image;
                              ?>
                              <div class="foto">
                                <img src="<?php echo $dir ?>" class="img-fluid index" alt="imagen animal "> 
                                <p class="indexpublication adopcion"><?= h($publicationStray->publication->message) ?></p> 

                              </div>
                            <?php

                            }else{ ?>
                              <p class="indexpublication adopcion"><?= h($publicationStray->publication->message) ?></p> 
                            <?php } ?>

                            <div class="text-centerlist">

                            <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $publicationStray->id],['escape' => false]) ?></button>

                                <?php 

                                    if($this->Identity->isLoggedIn()){
                                    if($currentuserRol=="admin" || $currentuserUsername==$publicationStray->user->username){ ?>                                    
                                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $publicationStray->id],['escape' => false]) ?></button>
                                    <button type="submit" class="listbtn">
                                        <?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Publication"] )), ['action' => 'delete','controller' => 'Publication', $publicationStray->publication_id,'Stray'], 
                                       ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la publicación {0}?', $publicationStray->publication->title)],['escape' => false]) ?> </button>
                                <?php } 
                                }?>
                            </div>
                            <br>
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
