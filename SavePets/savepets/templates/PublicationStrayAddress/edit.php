<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationStrayAddres $publicationStrayAddres
 * @var string[]|\Cake\Collection\CollectionInterface $publicationStray
 * @var string[]|\Cake\Collection\CollectionInterface $address
 * @var string[]|\Cake\Collection\CollectionInterface $user
 */
?>

<div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Editar') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                    <?=                     
                    $this->Html->link(__('Listar'), ['action' => 'index',$publicationStrayAddres->publication_stray_id], ['class' => 'side-nav-item']) ?> 

                <?php 
                    $this->loadHelper('Authentication.Identity');
                    if($this->Identity->isLoggedIn()){
                      $currentuser = $this->request->getAttribute('identity');
                      $currentuserRol=$currentuser->role;
                      $currentuserID=$currentuser->id;

                        if($currentuserRol=="admin" || $currentuserID==$publicationStray->user->id){ ?>
                            /  <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', 'controller' => 'Address',$publicationStrayAddres->addres_id, 'PublicationStrayAddress',$publicationStrayAddres->publication_stray_id], 
                            ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la publicación {0}, {1}?', $publicationStrayAddres->addres->street,$publicationStrayAddres->addres->city)],['escape' => false]) ?> 
                
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
          <p><?= __('Editar direcciones ') ?> <span><?= __('animales perdidos') ?></span></p>
        </div>
        <div class="section-content-form">

        <?php
            $imageAnimal=$publicationStrayAddres->image;
              if(!empty($imageAnimal)&& !preg_match('/^addresstrayanimal-img\/$/',$imageAnimal)){ 
                $dir='/img/'.$imageAnimal;
            ?>
                <img src="<?php echo $dir ?>" class="img-fluid" alt="imagen animal "> 
              <?php
                }else{?>    
                  <img src="/img/about-2.jpg" class="img-fluid" alt="">
              <?php } ?>
          <?= $this->Form->create($publicationStrayAddres,['type'=>'file','class'=>'php-email-form p-3 p-md-4']) ?>

            <div class="row">
                <?php echo $this->Form->control('change_image',['type'=>'file','class'=>'form-control','label'=> __('Imagen')]); ?>
            </div> 
            <br>
            <div class="row">
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('addres.country',['class'=>'form-control','label'=> __('País')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                <?php echo $this->Form->control('addres.province',['class'=>'form-control','label'=> __('Provincia')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 form-group">
                   <?php echo $this->Form->control('addres.city',['class'=>'form-control','label'=> __('Ciudad')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('addres.street',['class'=>'form-control','label'=> __('Calle')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('addres.postal_code',['class'=>'form-control','type'=>'number','label'=> __('Código Postal')]); ?>
                </div>
            </div><br>
            <div class="text-center"><?= $this->Form->button(__('Editar')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->

