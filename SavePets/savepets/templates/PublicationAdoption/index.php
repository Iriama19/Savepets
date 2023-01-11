<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PublicationAdoption> $publicationAdoption
 */
$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
}
?>

<div class="publicationAdoption index content">
    
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2><?= __('PUBLICACIONES') ?></h2>
            <p> <span><?= __('ADOPCIÓN') ?></span></p>
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
                    echo $this->Form->control('keyUrgente',['class'=>'formsearch select','label' => __('Buscar categoria: '), 'value' => $this->request->getQuery('keyUrgente'),'options'=>$opciones]) ?>

                <div class="text-center"><?= $this->Form->button(__('Buscar')) ?></div>

            <?= $this->Form->end();?>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($publicationAdoption as $publicationAdoption): ?>
                <tr>        
                    <div class=" d-flex align-items-stretch publication" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member publication">
                        <div class="member-info">
                            <div class='member-info head'>
                                <?php if($publicationAdoption->user->role=='admin'){ ?>
                                    <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
                                <?php } elseif($publicationAdoption->user->role=='shelter'){ ?>
                                    <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
                                <?php }else{ ?>
                                    <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
                                <?php } ?>
                                <?php 

                                if($this->Identity->isLoggedIn() && ($currentuserRol=="admin" || $currentuserRol=="shelter" || $publicationAdoption->user->role =="shelter"||$currentuserID==$publicationAdoption->user_id)){  
                                    ?>
                                        <h3> <?= $publicationAdoption->has('user') ? $this->Html->link($publicationAdoption->user->username, ['controller' => 'User', 'action' => 'view', $publicationAdoption->user->id]) : '' ?></h3> 
                                <?php }else{?>
                                        <h3><b><?= h($publicationAdoption->user->username) ?></b></h3>
                                <?php }  ?>
                                <h5 class="fechaformatocolor"><span><?php $fecha=$publicationAdoption->publication->publication_date;
                                echo $fecha->format('d/m/Y H:i:s'); ?></span></h5>
                                </div>
                            </div>
                            <h2><?= h($publicationAdoption->publication->title) ?></h2> 
                            <?php
                              if(!empty($publicationAdoption->animal->image)&& !preg_match('/^animal-img\/$/',$publicationAdoption->animal->image)){ 
                                $dir='/img/'.$publicationAdoption->animal->image;
                              ?>
                              <div class="foto">
                                <img src="<?php echo $dir ?>" class="img-fluid index" alt="imagen animal "> 
                                <p class="indexpublication adopcion"><?= h($publicationAdoption->publication->message) ?></p> 

                              </div>
                            <?php

                            }else{ ?>
                              <p class="indexpublication adopcion"><?= h($publicationAdoption->publication->message) ?></p> 
                            <?php } ?>

                            <div class="text-centerlist">

                                <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $publicationAdoption->id],['escape' => false]) ?></button>

                                <?php 

                                    if($this->Identity->isLoggedIn()){
                                    if($currentuserRol=="admin" || $currentuserUsername==$publicationAdoption->user->username){ ?>                                    
                                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $publicationAdoption->id],['escape' => false]) ?></button>
                                    <button type="submit" class="listbtn">
                                        <?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Publication"] )), ['action' => 'delete','controller' => 'Publication', $publicationAdoption->publication_id,'Adoption'], 
                                       ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la publicación {0}?', $publicationAdoption->publication->title)],['escape' => false]) ?> </button>
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
