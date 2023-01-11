
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
          <h2><?= __('Editar') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                    <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> /

                <?php 
                    $this->loadHelper('Authentication.Identity');
                    if($this->Identity->isLoggedIn()){
                      $currentuser = $this->request->getAttribute('identity');
                      $currentuserRol=$currentuser->role;
                      $currentuserUsername=$currentuser->username;

                        if($currentuserRol=="admin" || $currentuserUsername==$addres->user->username){ ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $addres->id], ['confirm' => __('Estas seguro que quieres borrar al usuario {0}?', $addres->username), 'class' => 'side-nav-item']) ?> 
                
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
          <p><?= __('Editar') ?> <span><?= h($addres->user->username) ?></span></p>
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
            <?php 
            $user = $this->request->getAttribute('identity');
            $currentuserRol=$user->role;
            if($currentuserRol=="admin"){?>
            <div class="row">
                <div class="form-group">
                <?php 
                $opciones=['standar'=>__('estandar'),'shelter'=>__('protectora'),'admin'=>__('admin')];
                echo $this->Form->control('user.role',['class'=>'form-control','label'=> __('Rol'),'options'=>$opciones]); ?>
                </div>
            </div>
            <?php }?>

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
                    <?php echo $this->Form->control('postal_code',['class'=>'form-control','type'=>'number','label'=> __('Código Postal')]); ?>
                </div>
            </div>
            <div class="text-center"><?= $this->Form->button(__('Editar')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
