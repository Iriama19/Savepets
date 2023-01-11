<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationStrayAddres $publicationStrayAddres
 * @var \Cake\Collection\CollectionInterface|string[] $publicationStray
 * @var \Cake\Collection\CollectionInterface|string[] $address
 * @var \Cake\Collection\CollectionInterface|string[] $user
 */
?>

   <!-- ======= Breadcrumbs ======= -->
   <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Añadir') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index', $CurrentPublicationStray_id], ['class' => 'side-nav-item']) ?> 
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
          <p><?= __('Añadir dirección de ') ?> <span><?= __('animal perdido') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/about-2.jpg" class="img-fluid" alt="">

          <?= $this->Form->create($publicationStrayAddres,['type'=>'file','class'=>'php-email-form p-3 p-md-4']) ?>
          <div class="row">

              <div class="row">
                    <?php echo $this->Form->control('image_file',['type'=>'file','class'=>'form-control','label'=> __('Imagen')]); ?>
                </div> 
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
                    <?php echo $this->Form->control('addres.postal_code',['type'=>'number','class'=>'form-control','label'=> __('Código Postal')]); ?>
                </div>
            </div>
            <?php 
              echo $this->Form->control('publication_stray_id',['type'=>'text','class'=>'form-control elemoculto', 'label' =>'','value'=> $CurrentPublicationStray_id]); 
            ?>
            <?php 
              $actualdate=date('Y-m-d H:i:s');
              echo $this->Form->control('publication_date',['type'=>'text','class'=>'form-control elemoculto', 'label' =>'','value'=>$actualdate]); 
            ?>
            <?php 
              $this->loadHelper('Authentication.Identity');
              if($this->Identity->isLoggedIn()){
                $currentuser = $this->request->getAttribute('identity');
                $currentuserID=$currentuser->id;
                echo $this->Form->control('user_id',['type'=>'text','class'=>'form-control elemoculto', 'label' =>'', 'value'=>$currentuserID]); 
             }  ?>
            <div class="text-center"><?= $this->Form->button(__('Añadir')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
