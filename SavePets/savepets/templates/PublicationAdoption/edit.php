<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationAdoption $publicationAdoption
 * @var string[]|\Cake\Collection\CollectionInterface $publication
 * @var string[]|\Cake\Collection\CollectionInterface $animal
 * @var string[]|\Cake\Collection\CollectionInterface $user
 */
?>

   <!-- ======= Breadcrumbs ======= -->
   <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Editar') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> 

                <?php 
                    $this->loadHelper('Authentication.Identity');
                    if($this->Identity->isLoggedIn()){
                      $currentuser = $this->request->getAttribute('identity');
                      $currentuserRol=$currentuser->role;
                      $currentuserID=$currentuser->id;

                        if($currentuserRol=="admin" || $currentuserID==$publicationAdoption->user->id){ ?>
                            /<?= $this->Form->postLink(__('Eliminar'), ['controller' => 'Publication','action' => 'delete', $publicationAdoption->publication_id, 'Adoption'], 
                            ['confirm' => __('Estas seguro de querer eliminar la publicación {0}?', $publicationAdoption->publication->title)]) ?>
                <?php } }?>
                  </div>
            </aside>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->
    <!-- ======= Form Section ======= -->
    <section id="formsec" class="formsec">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <p><?= __('Editar publicación ') ?> <span><?= __('adopción') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/about-2.jpg" class="img-fluid" alt="">

          <?= $this->Form->create($publicationAdoption,['class'=>'php-email-form p-3 p-md-4']) ?>
          <div class="row">
              <div class="col-xl-6 form-group">
                   <?php echo $this->Form->control('publication.title',['class'=>'form-control','label'=> __('Título')]); ?>
              </div>
              <div class="col-xl-6 form-group">
                <?php 
                    $opciones=['yes'=>__('Si'),'no'=>__('No')];
                    echo $this->Form->control('urgent',['class'=>'form-control','label'=> __('Urgente'),'options'=>$opciones, 'value'=>$publicationAdoption->urgent]); 
                ?>
                </div>
            </div>
            <div class="row select">
                <?php echo $this->Form->control('animal_id',['options' => $animal,'label'=> __('Animal')]); ?>
            </div> 
            <div class="row">
                <?php echo $this->Form->control('publication.message',['class'=>'form-control big','type'=>'textarea' ,'label'=> __('Mensaje')]); ?>
            </div><br>
            <div class="text-center"><?= $this->Form->button(__('Editar')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
