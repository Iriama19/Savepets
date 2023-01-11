
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Addres $addres
 * @var \Cake\Collection\CollectionInterface|string[] $publicationStray
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
          <h2><?= __('Registrate') ?>!!</h2>
          <p><?= __('Introduce tus datos para') ?> <span><?= __('registrate') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/about-2.jpg" class="img-fluid" alt="">

          <?= $this->Form->create($addres,['class'=>'php-email-form p-3 p-md-4']) ?>
            <div class="row">
              <div class="col-xl-6 form-group">
                   <?php echo $this->Form->control('user.DNI_CIF',['class'=>'form-control','label'=> __('DNI/NIE/CIF')]); ?>
              </div>
              <div class="col-xl-6 form-group">
                <?php echo $this->Form->control('user.username',['class'=>'form-control' ,'label'=> __('Alias usuario')]); ?>
              </div>
            </div>
            <div class="row">
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('user.name',['class'=>'form-control','label'=> __('Nombre')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('user.lastname',['class'=>'form-control','label'=> __('Apellido')]); ?>
                </div>
            </div>
            <div class="row">
            <div class="col-xl-6 form-group">
            <?php echo $this->Form->control('user.password',['class'=>'form-control','label'=> __('Contraseña')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('user.phone',['class'=>'form-control','label'=> __('Teléfono')]); ?>
                </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $this->Form->control('user.email',['class'=>'form-control','label'=> __('Email')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('country',['class'=>'form-control','label'=> __('País')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                <?php echo $this->Form->control('province',['class'=>'form-control','label'=> __('Provincia')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 form-group">
                   <?php echo $this->Form->control('city',['class'=>'form-control','label'=> __('Ciudad')]); ?>
                                     </div>
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('street',['class'=>'form-control','label'=> __('Calle')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('postal_code',['type'=>'number','class'=>'form-control','label'=> __('Código Postal')]); ?>
                </div>
            </div>
            <?php echo $this->Form->control('user.role',['value'=> 'standar','type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); ?>
            <div class="text-center"><?= $this->Form->button(__('Registrarse')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
