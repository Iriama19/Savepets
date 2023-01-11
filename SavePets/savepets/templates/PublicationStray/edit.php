<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationStray $publicationStray
 * @var string[]|\Cake\Collection\CollectionInterface $address
 */
?>
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

                        if($currentuserRol=="admin" || $currentuserID==$publicationStray->user->id){ ?>
                            /  <?= $this->Form->postLink(__('Eliminar'), ['controller' => 'Publication','action' => 'delete', $publicationStray->publication_id,'Stray'], 
                            ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la publicación {0}?', $publicationStray->publication->title)],['escape' => false]) ?> 
                
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
          <p><?= __('Editar publicación ') ?> <span><?= __('animales perdidos') ?></span></p>
        </div>
        <div class="section-content-form">

            <?php
            $imageAnimal=$publicationStray->image;
              if(!empty($imageAnimal)&& !preg_match('/^strayanimal-img\/$/',$imageAnimal)){ 
                $dir='/img/'.$imageAnimal;
            ?>
                <img src="<?php echo $dir ?>" class="img-fluid" alt="imagen animal "> 
              <?php
                }else{?>                  
                  <img src="/img/about-2.jpg" class="img-fluid" alt="">
              <?php } ?>
          <?= $this->Form->create($publicationStray,['type'=>'file','class'=>'php-email-form p-3 p-md-4']) ?>
          <div class="row">
              <div class="col-xl-6 form-group">
                   <?php echo $this->Form->control('publication.title',['class'=>'form-control','label'=> __('Título')]); ?>
              </div>
              <div class="col-xl-6 form-group">
                <?php 
                    $opciones=['yes'=>__('Si'),'no'=>__('No')];
                    echo $this->Form->control('urgent',['class'=>'form-control','label'=> __('Urgente'),'options'=>$opciones, 'value'=>$publicationStray->urgent]); 
                ?>
                </div>
            </div><br>
            <div class="row">
                <?php echo $this->Form->control('change_image',['type'=>'file','class'=>'form-control','label'=> __('Imagen')]); ?>
            </div> 
            <br>
            <div class="row">
                <?php echo $this->Form->control('publication.message',['class'=>'form-control big','type'=>'textarea' ,'label'=> __('Mensaje')]); ?>
            </div><br>
            <div class="text-center"><?= $this->Form->button(__('Editar')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
