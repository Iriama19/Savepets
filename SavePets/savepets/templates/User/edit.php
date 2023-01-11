<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var string[]|\Cake\Collection\CollectionInterface $feature
 * @var string[]|\Cake\Collection\CollectionInterface $fosterList
 * @var string[]|\Cake\Collection\CollectionInterface $profile
 */
$this->loadHelper('Authentication.Identity');
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
                    if($this->Identity->isLoggedIn()){
                      $currentuser = $this->request->getAttribute('identity');
                      $currentuserRol=$currentuser->role;
                      $currentuserUsername=$currentuser->username;

                        if($currentuserRol=="admin" || $currentuserUsername==$user->username){ ?>
                    <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete','controller' => 'User', $user->id], 
                                    ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar el usuario {0}?', $user->username)],['escape' => false]) ?> 
                
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
          <p><?= __('Editar') ?> <span><?= h($user->username) ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/about-2.jpg" class="img-fluid" alt="">

          <?= $this->Form->create($user,['class'=>'php-email-form p-3 p-md-4']) ?>
            <div class="row">
              <div class="col-xl-6 form-group">
                   <?php echo $this->Form->control('DNI_CIF',['class'=>'form-control','label'=> __('DNI/NIE/CIF')]); ?>
              </div>
              <div class="col-xl-6 form-group">
                <?php echo $this->Form->control('username',['class'=>'form-control' ,'label'=> __('Alias usuario')]); ?>
              </div>
            </div>
            <div class="row">
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('name',['class'=>'form-control','label'=> __('Nombre')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('user.lastname',['class'=>'form-control','label'=> __('Apellido')]); ?>
                </div>
            </div>
            <div class="row">
            <div class="col-xl-6 form-group">
            <?php echo $this->Form->control('password',['class'=>'form-control','label'=> __('Contraseña')]); ?>
            </div>
                <div class="col-xl-6 form-group">
                    <?php echo $this->Form->control('phone',['class'=>'form-control','label'=> __('Teléfono')]); ?>
                </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $this->Form->control('email',['class'=>'form-control','label'=> __('Email')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <?php echo $this->Form->control('birth_date',['type'=>'date','class'=>'form-control','label'=> __('Fecha Nacimiento')]); ?>
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
                echo $this->Form->control('role',['class'=>'form-control','label'=> __('Rol'),'options'=>$opciones, 'value'=>$user->role]); ?>
                </div>
            </div>
            <?php }?>

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
            </div>
            <br><br><span class="avisofeature"><em><?= __('* Los siguientes campos son opcionales, pero nos permitirán mejorar tu experiencia') ?></em></span></em>
            <div class="row">
                <div class="col-xl-6 form-group">
                  <?php echo $this->Form->control('feature_user.0.value',['class'=>'form-control','label'=> __('Trabajo')]); ?>
                  </div>
                  <div class="col-xl-6 form-group">
                  <?php echo $this->Form->control('feature_user.1.value',['class'=>'form-control','label'=> __('Estudios')]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 form-group">
                  <?php 
                  $opcionesEstadoCivil=['single'=>__('Soltero'),'married'=>__('Casado'),'divorced'=>__('Divorciado'),'separated'=>__('Separado'),'relationship'=>__('Relación')];
                  echo $this->Form->control('feature_user.2.value',['class'=>'form-control','options'=>$opcionesEstadoCivil,'label'=> __('Estado Civil')]); ?>
                  </div>
                  <div class="col-xl-6 form-group">
                  <?php echo $this->Form->control('feature_user.3.value',['type'=>'number','class'=>'form-control','max'=>20,'label'=> __('Hijos')]); ?>
                </div>
            </div>
            <div class="row">
                  <div class="col-xl-6 form-group">
                  <?php 
                  $opcionesVivienda=['detached house'=>__('Casa independiente'),'semi-detached house'=>__('Chalet pareado'),'terraced house'=>__('Chalet adosado'),'bungalows'=>__('Bungalows'),'studio'=>__('Estudio'),'apartment'=>__('Apartamento'),'flat'=>__('Piso'),'attic'=>__('Ático'),'ground floor'=>__('Bajo'),'ground floor with garden'=>__('Bajo con jardín'),'loft'=>__('Loft'),'duplex'=>__('Dúplex'),'triplex'=>__('Triplex'),'quadplex'=>__('Quadplex')];
                  echo $this->Form->control('feature_user.4.value',['class'=>'form-control','options'=>$opcionesVivienda,'label'=> __('Tipo de vivienda')]); ?>
                </div>
                <div class="col-xl-6 form-group">
                  <?php 
                    $opcionesEspecie=['dog'=>__('Perro'),'cat'=>__('Gato'),'bunny'=>__('Conejo'),'hamster'=>__('Hamster'),'snake'=>__('Serpiente'),'turtle'=>__('Tortuga'),'other'=>__('Otro')];
                    echo $this->Form->control('feature_user.5.value',['class'=>'form-control','label'=> __('Otras mascotas'),'options'=>$opcionesEspecie]); 
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6 form-group">
                  <?php echo $this->Form->control('feature_user.6.value',['class'=>'form-control','label'=> __('Número mascotas'),'type'=>'number']); ?>
                </div>
                <div class="col-xl-6 form-group">
                  <?php 
                    $opcionesGenero=['male'=>__('Hombre'),'female'=>__('Mujer'),'nobinary'=>__('No binario'),'other'=>__('Otro')];
                    echo $this->Form->control('feature_user.7.value',['class'=>'form-control','label'=> __('Genero'),'options'=>$opcionesGenero]); 
                    ?>
                </div>
            </div>
            <div class="espaciofeature">
              <?php echo $this->Form->control('feature_user.0.feature_id',['class'=>'form-control','value'=> 1,'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); ?>
              <?php echo $this->Form->control('feature_user.1.feature_id',['class'=>'form-control','value'=> 2,'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); ?>
              <?php echo $this->Form->control('feature_user.2.feature_id',['class'=>'form-control','value'=> 3,'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); ?>
              <?php echo $this->Form->control('feature_user.3.feature_id',['class'=>'form-control','value'=> 4,'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); ?>
              <?php echo $this->Form->control('feature_user.4.feature_id',['class'=>'form-control','value'=> 5,'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); ?>
              <?php echo $this->Form->control('feature_user.5.feature_id',['class'=>'form-control','value'=> 6,'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); ?>
              <?php echo $this->Form->control('feature_user.6.feature_id',['class'=>'form-control','value'=> 7,'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); ?>
              <?php echo $this->Form->control('feature_user.7.feature_id',['class'=>'form-control','value'=> 8,'type'=>'text','class'=>'form-control elemoculto', 'label' =>'']); ?>

            </div>
            <div class="text-center"><?= $this->Form->button(__('Editar')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->













