<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PublicationStrayAddres> $publicationStrayAddress
 */

$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
}
?>   

<div class="publicationStrayAddress index content">
    
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2><?= __('DIRECCIONES ') ?></h2>
            <p> <span><?= __('ANIMALES PERDIDOS') ?></span></p>
            <?php 
                if($this->Identity->isLoggedIn()){ ?>
                <div>
                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add',$CurrentPublicationStray_id],['escape' => false]) ?></button>                                    
                </div>
                <?php
                    
                }?>
                
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($publicationStrayAddress as $publicationStrayAddress): ?>
                <tr>        
                    <div class=" d-flex align-items-stretch publication" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member publication">
                            <div class="member-info">
                                <div class='member-info head'>
                                    <?php 
                                    if($publicationStrayAddress->user->role=='admin'){ ?>
                                        <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
                                    <?php } elseif($publicationStrayAddress->user->role=='shelter'){ ?>
                                        <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
                                    <?php }else{ ?>
                                        <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
                                    <?php  } 
                                    if($this->Identity->isLoggedIn()){
                                        if($currentuserRol=="admin" || $currentuserRol=="shelter"  || $publicationStrayAddres->user->role =="shelter" ||$currentuserID==$publicationStrayAddress->user_id){
                                        ?>
                                            <h3> <?= $publicationStrayAddress->has('user') ? $this->Html->link($publicationStrayAddress->user->username, ['controller' => 'User', 'action' => 'view', $publicationStrayAddress->user->id]) : '' ?></h3> 
                                       <?php } }else{?>
                                            <h3><b><?= h($publicationStrayAddress->user->username) ?></b></h3>
                                        <?php } 
                                    ?>                                
                                    <h5 class="fechaformatocolor"><span><?php $fecha=$publicationStrayAddress->publication_date;
                                   echo $fecha->format('d/m/Y H:i:s'); ?></span></h5>
                                </div>
                            </div>
                            <?php
                              if(!empty($publicationStrayAddress->image)&& !preg_match('/^addresstrayanimal-img\/$/',$publicationStrayAddress->image)){ 
                                $dir='/img/'.$publicationStrayAddress->image;
                              ?>
                              <div class="foto">
                                <img src="<?php echo $dir ?>" class="img-fluid index" alt="imagen animal "> 
                              </div>
                            <?php }?>

                            <p class="indexpublication"> <?= h($publicationStrayAddress->addres->city)?>, <?= h($publicationStrayAddress->addres->province) ?> , <?= h($publicationStrayAddress->addres->country) ?> </p> 

                            <div class="text-centerlist">

                                <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $publicationStrayAddress->id],['escape' => false]) ?></button>

                                <?php 
                                    if($this->Identity->isLoggedIn()){
                                        if($currentuserRol=="admin" || $currentuserUsername==$publicationStrayAddress->user->username){ 
                                            ?>                                    
                                        <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $publicationStrayAddress->id],['escape' => false]) ?></button>
                                        <button type="submit" class="listbtn">
                                        <?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Publication"] )), ['action' => 'delete', 'controller' => 'Address',$publicationStrayAddress->addres_id, 'PublicationStrayAddress', $CurrentPublicationStray_id], 
                                        ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la dirección {0}, {1}?', $publicationStrayAddress->addres->street,$publicationStrayAddress->addres->city)],['escape' => false]) ?> </button>
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
