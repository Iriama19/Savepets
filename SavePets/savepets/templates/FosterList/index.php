<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\FosterList> $fosterList
 */
$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
  $currentuserUsername=$currentuser->username;
}
?>
<div class="fosterList index content">
<div class="publicationAdoption index content">
    
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2><?= __('LISTAS') ?></h2>
            <p> <span><?= __('ACOGIDA') ?></span></p>
            <?php 
                if($this->Identity->isLoggedIn()){
                    if(($currentuserRol=="admin" || $currentuserRol == "shelter")){ ?>
                <div>
                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add'],['escape' => false]) ?></button>                                    
                </div><br>
                <?php
                    }?>
                    <button type="submit" class="listbtn unirsebtn"><?= $this->Html->link(__('Mis listas'), ['controller' => 'FosterListUser','action' => 'index'],['escape' => false]) ?></button>                                    
                <?php }?><br>
               <?= 
                $this->Form->create(null, ['type' => 'get','class'=>'formsearchform']) ?>
                    <?php echo $this->Form->control('keyCiudad', ['class'=>'formsearch ani','label' => __('Buscar por ciudad: '), 'value' => $this->request->getQuery('keyCiudad'), 'autocomplete' => 'off']) ?>
                    <?php echo $this->Form->control('keyProvincia', ['class'=>'formsearch ani','label' => __('Buscar por provincia: '), 'value' => $this->request->getQuery('keyProvincia'), 'autocomplete' => 'off']) ?>
                    <?php echo $this->Form->control('keyPais', ['class'=>'formsearch ani','label' => __('Buscar por país: '), 'value' => $this->request->getQuery('keyPais'), 'autocomplete' => 'off']) ?>
                    <div class="text-center"><?= $this->Form->button(__('Buscar')) ?></div>

            <?= $this->Form->end();?>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($fosterList as $fosterList): ?>
                <tr>        
                    <div class=" d-flex align-items-stretch publication" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member publication">
                        <div class="member-info">
                            <div class='member-info head'>
                                    <h3> <?= $fosterList->has('user') ? $this->Html->link($fosterList->user->username, ['controller' => 'User', 'action' => 'view', $fosterList->user->id]) : '' ?></h3>
                                </div>
                            </div>
                            <div class="text-centerlist">
                                <?php 
                                    if($this->Identity->isLoggedIn()){ ?>
                                        <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $fosterList->id],['escape' => false]) ?></button>                                   
                                        
                                        <?php if($currentuserRol=="admin" || $currentuserUsername==$fosterList->user->username){ ?>                                    
                                            <button type="submit" class="listbtn"><?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Foster List"] )), ['action' => 'delete','controller' => 'FosterList', $fosterList->id], 
                                            ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la lista de protectora {0}?', $fosterList->user->username)],['escape' => false]) ?> </button>
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
