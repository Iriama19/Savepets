<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Feature> $feature
 */
?>


<div class="feature index content">

    
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2><?= __('LISTA') ?></h2>
          <p> <span><?= __('CARACTERÍSTICAS') ?></span></p>

          <?php 
          $this->loadHelper('Authentication.Identity');
          if($this->Identity->isLoggedIn()){
            $user = $this->request->getAttribute('identity');
            $currentuserRol=$user->role;
            if($currentuserRol=="admin"){?>
          <div>
            <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add'],['escape' => false]) ?></button>                                    
          </div>                            
          <?php
            }
           }
          ?>

        </div>

        <div class="row gy-4">

        <table>
            <tbody>
                <?php foreach ($feature as $feature): 
                  ?>
                <tr>        
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member">

                        <div class="member-info feature">
                            <h4><?= h($feature->key_feature) ?></h4>
                            <div class="text-centerlist">                                   
                                   <?php 
                                   $this->loadHelper('Authentication.Identity');
                                      if($this->Identity->isLoggedIn()){
                                        $user = $this->request->getAttribute('identity');
                                        $currentuserRol=$user->role;
                                          if($currentuserRol=="admin"){?>
                                            <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $feature->id],['escape' => false]) ?></button>
                                            <button type="submit" class="listbtn"><?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Feature"] )), ['action' => 'delete', $feature->id], 
                                              ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la característica {0}?', $feature->name)],['escape' => false]) ?></button>
                                  <?php }}?>
                            
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
