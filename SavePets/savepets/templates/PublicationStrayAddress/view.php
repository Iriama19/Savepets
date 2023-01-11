<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationStrayAddres $publicationStrayAddres
 */

$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
}
?>
   <!-- ======= Breadcrumbs ======= -->
   <div class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2><?= __('Consultar') ?></h2>
          <ol>
            <aside class="column">
                <div class="side-nav">
                <?= $this->Html->link(__('Listar'), ['action' => 'index',$publicationStrayAddres->publication_stray_id], ['class' => 'side-nav-item']) ?>
                <?php 

                  if($this->Identity->isLoggedIn()){

                    if($currentuserRol=="admin" || $currentuserID==$publicationStrayAddres->user_id){ 
                      ?>
                      / <?= $this->Html->link(__('Editar'), ['action' => 'edit', $publicationStrayAddres->id], ['class' => 'side-nav-item']) ?>  / 
                      <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', 'controller' => 'Address',$publicationStrayAddres->addres_id, 'PublicationStrayAddress' ,$publicationStrayAddres->publication_stray_id], 
                          ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar la publicación {0}, {1}?', $publicationStrayAddres->addres->street,$publicationStrayAddres->addres->city)],['escape' => false]) ?> 
                <?php }
              }?>
                </div>
            </aside>
          </ol>
        </div>

      </div>
    </div><!-- End Breadcrumbs -->
     <!-- ======= Individual Section ======= -->

     <div class=" d-flex align-items-stretch publication view" data-aos="fade-up" data-aos-delay="100">
        <div class="objetivo-member publication view">
          <div class="member-info">
            <div class='member-info head'>
              <?php 

                    if( $publicationStrayAddres->user->role=='admin'){ ?>
                    <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
                <?php } elseif($publicationStrayAddres->user->role=='shelter'){ ?>
                    <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
                <?php }else{ ?>
                    <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
                <?php } 
                if($this->Identity->isLoggedIn()){
                 if($currentuserRol=="admin" || $currentuserRol=="shelter" || $publicationStrayAddres->user->role =="shelter"  ||$currentuserID==$publicationStrayAddres->user_id){
                  ?>
                  <h3> <?= $publicationStrayAddres->has('user') ? $this->Html->link($publicationStrayAddres->user->username, ['controller' => 'User', 'action' => 'view', $publicationStrayAddres->user_id]) : '' ?></h3> 

                  <?php } } else{ ?>
                    <h3><b><?= h($publicationStrayAddres->user->username) ?></b></h3>
                  <?php } 
                  ?>
              <h5 class="fechaformatocolor"><span>
                <?php $fecha=$publicationStrayAddres->publication_date; 
                echo $fecha->format('d/m/Y H:i:s'); ?></span></h5> 
            </div>
          </div>
            <?php
              if(!empty($publicationStrayAddres->image)&& !preg_match('/^addresstrayanimal-img\/$/',$publicationStrayAddres->image)){ 
                 $dir='/img/'.$publicationStrayAddres->image;
            ?>
                  <img src="<?php echo $dir ?>" class="img-fluid index publicacionfotoanimalview" alt="imagen animal "> 
            <?php } ?><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('País') ?>:</h5>
              <?= h($publicationStrayAddres->addres->country) ?>
              <div class="validate"></div>
            </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Provincia') ?>:</h5>
              <?= h($publicationStrayAddres->addres->province) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Ciudad') ?>:</h5>
              <?= h($publicationStrayAddres->addres->city) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Calle') ?>:</h5>
              <?= h($publicationStrayAddres->addres->street) ?>
              <div class="validate"></div>
              </div><br>
            <div class="col-lg-4 col-md-6">
              <h5><?= __('Código Postal') ?>:</h5>
              <?= h($publicationStrayAddres->addres->postal_code) ?>
              <div class="validate"></div>
            </div>
          <br>
        </div>
      </div>

    </div><!-- End Objetivo -->