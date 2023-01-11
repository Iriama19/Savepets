<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feature $feature
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
          <p><?= __('Añadir nueva') ?> <span><?= __('Característica') ?></span></p>
        </div>
        <div class="section-content-form">

          <img src="/img/animalabout.png" class="img-fluid" alt="">

          <?= $this->Form->create($feature,['class'=>'php-email-form p-3 p-md-4','type'=>'file']) ?>
            <div class="row">
                <?php echo $this->Form->control('key_feature',['class'=>'form-control','label'=> __('Clave')]); ?><br>
            </div>
            <br>
            <div class="text-center"><?= $this->Form->button(__('Añadir')) ?></div>
            <?= $this->Form->end() ?>
          <!--End Form -->
        </div>

      </div>
    </section><!-- End Form Section -->
