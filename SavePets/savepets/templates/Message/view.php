<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 */
$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
    $currentuser = $this->request->getAttribute('identity');
    $currentuserRol=$currentuser->role;
    $currentuserID=$currentuser->id;
  }
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
               </div>
           </aside>
         </ol>
       </div>
  
     </div>
   </div><!-- End Breadcrumbs -->
    <!-- ======= Individual Section ======= -->
  
    <div class=" d-flex align-items-stretch publication view" data-aos="fade-up" data-aos-delay="100">
       <div class="objetivo-member publication view ">
         <div class="member-info">
           <div class='member-info head'>
             <?php if($message->transmitter->role=='admin'){ ?>
               <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
             <?php } elseif($message->transmitter->role=='shelter'){ ?>
               <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
             <?php }else{ ?>
               <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
             <?php } 
             if($this->Identity->isLoggedIn()&&($currentuserRol=="admin" || $currentuserRol=="shelter")){ ?>
  
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
  
         <p><?= h($message->content) ?></p> 
         <br>
       </div>
     </div>
  
   </div><!-- End Objetivo -->
  