<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Addres> $address
 */
?>
<div class="address index content">
    
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
            <h2><?= __('LISTA') ?></h2>
            <p> <span><?= __('USUARIOS') ?></span></p>
            <?php
            
            $this->loadHelper('Authentication.Identity');

            if($this->Identity->isLoggedIn()){
                ?>
            <?= 
                $this->Form->create(null, ['type' => 'get','class'=>'formsearchform']) ?>
                <?php echo $this->Form->control('key', ['class'=>'formsearch','label' => __('Buscar por alias: '), 'value' => $this->request->getQuery('keyUsername'), 'autocomplete' => 'off']) ?>
                <?php 
                $opciones=[''=>'','standar'=>__('estandar'),'shelter'=>__('protectora'),'admin'=>__('admin')];

                echo $this->Form->control('keyRole',['class'=>'formsearch select','label' => __('Buscar rol: '), 'value' => $this->request->getQuery('keyRol'),'options'=>$opciones]) ?>
                <div class="text-center"><?= $this->Form->button(__('Buscar')) ?></div>

            <?= $this->Form->end();
            ?><?php }?>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($address as $addres): ?>
                <tr>        
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member">
                        <div class="member-img">
                            <img src="/img/useronly.png" class="img-fluid-user" alt="">
                        </div>
                        <div class="member-info">
                            <h4><?= h($addres->user->username) ?></h4>
                            <span></span>
                            <p><?= h($addres->user->name) ?> <?= h($addres->user->lastname) ?></p> 
                            <p><?= h($addres->user->email) ?></p><br>

                            <div class="text-centerlist">

                                <?php 
                                    $this->loadHelper('Authentication.Identity');

                                    if($this->Identity->isLoggedIn()){
                                    $currentuser = $this->request->getAttribute('identity');
                                    $currentuserRol=$currentuser->role;
                                    $currentuserUsername=$currentuser->username;

                                    if($currentuserRol=="admin" || $currentuserUsername==$addres->user->username){ ?>
                                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $addres->id],['escape' => false]) ?></button>
                                    
                                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $addres->id],['escape' => false]) ?></button>
                                    <button type="submit" class="listbtn"><?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete User"] )), ['action' => 'delete', $addres->id], 
                                    ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar el usuario {0}?', $addres->user->username)],['escape' => false]) ?></button>
                                <?php } 
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
