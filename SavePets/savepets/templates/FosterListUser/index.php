<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\FosterListUser> $fosterListUser
 */

$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
  $currentuserUsername=$currentuser->username;
}
?>
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2><?= __('MIS ') ?></h2>
            <p> <span><?= __('LISTAS ACOGIDA') ?></span></p>
            <?= 
                $this->Form->create(null, ['type' => 'get','class'=>'formsearchform']) ?>
                <?php 
                
                $opciones=[''=>'','cat' => __('Gato'),'dog' => __('Perro'),'bunny' => __('Conejo'),'hamster' => __('Hamster'),'snake' => __('Serpiente'),'turtles'=> __('Tortuga'),'other' => __('Otro') ,'indifferent'=> __('Indiferente')];
                echo $this->Form->control('keyEspecie',['class'=>'formsearch select','label' => __('Buscar por especie: '), 'value' => $this->request->getQuery('keyEspecie'),'options'=>$opciones]) ?>
                <div class="text-center"><?= $this->Form->button(__('Buscar')) ?></div>

            <?= $this->Form->end();?>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($fosterListUser as $fosterListUser): ?>
                <tr>        
                    <div class=" d-flex align-items-stretch publication" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member publication">
                            <div class="member-info">
                                <div class='member-info head'>
                                <h3><?= __('Protectora: ') ?></h3>

                                    <?php  
                                        ?>
                                        <h3> <?= $fosterListUser->has('foster_list') ? $this->Html->link($fosterListUser->foster_list->user->username, ['controller' => 'User', 'action' => 'view', $fosterListUser->foster_list->user->id]) : '' ?></h3> 
                                </div>
                            </div>                                
                            <h2><?= h($fosterListUser->user->username) ?></h2> 
                            <div class="text-centerlist">
                                <?php 
                                    if($this->Identity->isLoggedIn()){
                                        if($currentuserRol=="admin" || $currentuserRol=="shelter" || $currentuserUsername==$fosterListUser->user_id  ){ ?> 
                                            <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $fosterListUser->id],['escape' => false]) ?></button>                                   
                                            <?php if($currentuserRol=="admin" || $currentuserID==$fosterListUser->user_id ){ ?> 

                                                <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $fosterListUser->id],['escape' => false]) ?></button>
                                                <button type="submit" class="listbtn">
                                                <?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Foster List User"] )), ['action' => 'delete', $fosterListUser->id], 
                                                ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la participación en la protectora {0}?', $fosterListUser->foster_list->user->username)],['escape' => false]) ?> </button>
                                <?php       } 
                                        }
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
