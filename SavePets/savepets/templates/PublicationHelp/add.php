<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationHelp $publicationHelp
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
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> 
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
          <p><?= __('Realizar publicación') ?> <span><?= __('ayuda') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/about-2.jpg" class="img-fluid" alt="">

          <?= $this->Form->create($publicationHelp,['class'=>'php-email-form p-3 p-md-4']) ?>
            <div class="row">
              <div class="col-xl-6 form-group">
                   <?php echo $this->Form->control('publication.title',['class'=>'form-control','label'=> __('Título')]); ?>
              </div>
              <div class="col-xl-6 form-group">
                    <?php 
                        $opciones=['textile'=>__('Textil'),'medical devices'=>__('Medicamentos'),'food'=>__('Comida'),'cleaning products'=>__('Productos limpieza'),'pet accessories'=>__('Accesorios para mascotas'),'other'=>__('Otro')];
                        echo $this->Form->control('categorie',['class'=>'form-control','label'=> __('Categoria'),'options'=>$opciones]); 
                    ?>
              </div>
            </div>
            <div class="row">
                <?php echo $this->Form->control('publication.message',['class'=>'form-control big','type'=>'textarea' ,'label'=> __('Mensaje')]); ?>
            </div>
            <?php 
              $this->loadHelper('Authentication.Identity');
              if($this->Identity->isLoggedIn()){
                $currentuser = $this->request->getAttribute('identity');
                $currentuserID=$currentuser->id;
                echo $this->Form->control('user_id',['type'=>'text','class'=>'form-control elemoculto', 'label' =>'', 'value'=>$currentuserID]); 
              }  

              $actualdate=date('Y-m-d H:i:s');
              echo $this->Form->control('publication.publication_date',['type'=>'text','class'=>'form-control elemoculto', 'label' =>'','value'=>$actualdate]); 
            ?>
            <div class="text-center"><?= $this->Form->button(__('Publicar')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
