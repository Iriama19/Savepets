<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment $comment
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
                <?= $this->Html->link(__('Listar'), ['action' => 'view','controller'=>'publication-'.$currenTypePublicacion,$currenTypeIDPublicacion], ['class' => 'side-nav-item']) ?> 

                <?php 
                    $this->loadHelper('Authentication.Identity');
                    if($this->Identity->isLoggedIn()){
                      $currentuser = $this->request->getAttribute('identity');
                      $currentuserRol=$currentuser->role;
                      $currentuserID=$currentuser->id;

                        if($currentuserRol=="admin"){ ?>
                    /<?= $this->Form->postLink(__('ELiminar'), ['controller' => 'Comment','action' => 'delete', $comment->id, $comment->publication_id, $currenTypeIDPublicacion,$currenTypePublicacion], 
                                    ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar el comentario ?')],['escape' => false]) ?> </button>
                
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
          <p><?= __('Editar publicación') ?> <span><?= __('Ayuda') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/about-2.jpg" class="img-fluid" alt="">

          <?= $this->Form->create($comment,['class'=>'php-email-form p-3 p-md-4']) ?>

            <div class="row">
                <?php echo $this->Form->control('message',['class'=>'form-control big','type'=>'textarea' ,'label'=> __('Mensaje')]); ?>
            </div><br>
            <div class="text-center"><?= $this->Form->button(__('Editar')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
