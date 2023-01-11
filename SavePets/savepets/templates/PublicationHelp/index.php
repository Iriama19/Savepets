<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PublicationHelp> $publicationHelp
 */
$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
}
?>

<div class="publicationHelp index content">
    
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2><?= __('PUBLICACIONES') ?></h2>
            <p> <span><?= __('AYUDA') ?></span></p>
            <?php 
                if($this->Identity->isLoggedIn()){ ?>
                <div>
                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add'],['escape' => false]) ?></button>                                    
                </div>
                <?php
                    
                }?>
            <?= 
                $this->Form->create(null, ['type' => 'get','class'=>'formsearchform']) ?>
                <?php 
                
                    $opciones=[''=>'','Textile'=>__('Textil'),'Medical devices'=>__('Medicamentos'),'Food'=>__('Comida'),'Cleaning products'=>__('Productos limpieza'),'Pet accessories'=>__('Accesorios para mascotas'),'Other'=>__('Otro')];
                    echo $this->Form->control('keyCategoria',['class'=>'formsearch select','label' => __('Buscar categoria: '), 'value' => $this->request->getQuery('keyCategoria'),'options'=>$opciones]) ?>

                <div class="text-center"><?= $this->Form->button(__('Buscar')) ?></div>

            <?= $this->Form->end();?>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($publicationHelp as $publicationHelp): ?>
                <tr>        
                    <div class=" d-flex align-items-stretch publication" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member publication">
                            <div class="member-info">
                                <div class='member-info head'>
                                    <?php 
                                        if($publicationHelp->user->role=='admin'){ ?>
                                            <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
                                    <?php } elseif($publicationHelp->user->role=='shelter'){ ?>
                                        <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
                                    <?php }else{ ?>
                                        <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
                                    <?php  } 
                                    if($this->Identity->isLoggedIn() && ($currentuserRol=="admin" || $currentuserRol=="shelter" || $publicationHelp->user->role =="shelter" ||$currentuserID==$publicationHelp->user_id)){
                                        ?>
                                            <h3> <?= $publicationHelp->has('user') ? $this->Html->link($publicationHelp->user->username, ['controller' => 'User', 'action' => 'view', $publicationHelp->user->id]) : '' ?></h3> 
                                       <?php }else{?>
                                            <h3><b><?= h($publicationHelp->user->username) ?></b></h3>
                                    <?php 
                                        }
                                    ?>                                
                                    <h5 class="fechaformatocolor"><span><?php $fecha=$publicationHelp->publication->publication_date;
                                   echo $fecha->format('d/m/Y H:i:s'); ?></span></h5>
                                </div>
                            </div>
                            <h2><?= h($publicationHelp->publication->title) ?></h2> 
                            <p class="indexpublication"><?= h($publicationHelp->publication->message) ?></p> 

                            <div class="text-centerlist">

                                <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $publicationHelp->id],['escape' => false]) ?></button>

                                <?php 
                                    if($this->Identity->isLoggedIn()){
                                        if($currentuserRol=="admin" || $currentuserUsername==$publicationHelp->user->username){ ?>                                    
                                        <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $publicationHelp->id],['escape' => false]) ?></button>
                                        <button type="submit" class="listbtn">
                                        <?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Publication"] )), ['controller' => 'Publication','action' => 'delete', $publicationHelp->publication_id,'Help'], 
                                        ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la publicación {0}?', $publicationHelp->publication->title)],['escape' => false]) ?> </button>
                                <?php  } 
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
