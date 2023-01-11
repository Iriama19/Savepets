<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Message> $message
 */
$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
}
?>
<div class="message index content">
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2><?= __('MIS') ?></h2>
            <p> <span><?= __('MENSAJES') ?></span></p>
            <?php 
                if($this->Identity->isLoggedIn()){ ?>
                <div>
                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add'],['escape' => false]) ?></button>                                    
                </div>
                <?php
                    
                }?>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($message as $message): ?>
                <tr>        
                <div class=" d-flex align-items-stretch publication view" data-aos="fade-up" data-aos-delay="100">
                    <?php 
                    if($message->readed =='no'){ ?>
                        <div class="objetivo-member publication noread">
                    <?php }else{ ?>
                        <div class="objetivo-member publication ">
                    <?php } ?>
                    <div class="member-info">

                        <div class='member-info head'>
                            <?php if($message->transmitter->role=='admin'){ ?>
                            <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
                            <?php } elseif($message->transmitter->role=='shelter'){ ?>
                            <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
                            <?php }else{ ?>
                            <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
                            <?php } 
                            if($this->Identity->isLoggedIn() && ($currentuserRol=="admin" || $currentuserRol=="shelter")){?>
                                <h3> <?= $message->has('transmitter') ? $this->Html->link($message->transmitter->username, ['controller' => 'User', 'action' => 'view', $message->transmitter_user_id]) : '' ?></h3> 
                            <?php }else{?>
                                <h3><b><?= h($message->transmitter->username) ?></b></h3>
                            <?php 
                            } ?>                
                            <h5 class="fechaformatocolor"><span><?php $fecha=$message->message_date;
                            echo $fecha->format('d/m/Y H:i:s'); ?></span></h5>
                        </div>
                        </div>
                        <h2 class="titulocentrado"><?= h($message->title) ?></h2> 
                
                            <div class="text-centerlist">
                                <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $message->id],['escape' => false]) ?></button>
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
