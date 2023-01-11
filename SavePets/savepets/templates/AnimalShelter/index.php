<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AnimalShelter> $animalShelter
 */
?>

<div class="animalShelter index content">
   
    <!-- ======= Objetivos Section ======= -->
    <section id="objetiv list" class="objetiv section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2><?= __('LISTA') ?></h2>
          <p> <span><?= __('ESTANCIA EN PROTECTORA') ?></span></p>
          <div>
            <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add'],['escape' => false]) ?></button>                                    
          </div>
        </div>

        <div class="row gy-4">

        <table>
            <tbody>
            <?php foreach ($animalShelter as $animalShelter): ?>
                <tr>        
                    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
                        <div class="objetivo-member">
                        <div class="member-img">
                            <img src="/img/animalabout.png" class="img-fluid-user" alt="Foto">
                        </div>
                        <div class="member-info">
                            <p><?= $animalShelter->has('animal') ? $this->Html->link($animalShelter->animal->name, ['controller' => 'Animal', 'action' => 'view', $animalShelter->animal->id]) : '' ?></p><br>
                            <p><?= $animalShelter->has('user') ? $this->Html->link($animalShelter->user->name, ['controller' => 'Address', 'action' => 'view', $animalShelter->user->addres_id]) : '' ?></p><br>

                            <div class="text-centerlist">
                                <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("eye.png", ["alt" => "View"])), ['action' => 'view', $animalShelter->id],['escape' => false]) ?></button>                                    
                                <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['action' => 'edit', $animalShelter->id],['escape' => false]) ?></button>
                                <button type="submit" class="listbtn"><?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete User"] )), ['action' => 'delete', $animalShelter->id], 
                                    ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la estancia en la protectora {1} de {0}?', $animalShelter->animal->name, $animalShelter->user->name)],['escape' => false]) ?></button>

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
