<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FosterListUser $fosterListUser
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
                <?= $this->Html->link(__('Listar'), ['action' => 'index'], ['class' => 'side-nav-item']) ?> 
                <?php 
                    if($this->Identity->isLoggedIn()){
                      if($currentuserRol=="admin" || $currentuserID==$fosterListUser->user_id){ ?>
                        / <?= $this->Html->link(__('Editar'), ['action' => 'edit', $fosterListUser->id], ['class' => 'side-nav-item']) ?>  / 
                       
                        <?= $this->Form->postLink(__('Eliminar'), ['action' => 'delete', $fosterListUser->id], 
                        ['confirm' => __('Estas seguro de querer eliminar la participación en la lista de acogida de la protectora {0}?', $fosterListUser->foster_list->user->username), 'class' => 'side-nav-item']) ?>                 </div>
            
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
            <h3> <?= $fosterListUser->has('foster_list') ? $this->Html->link($fosterListUser->foster_list->user->username, ['controller' => 'User', 'action' => 'view', $fosterListUser->foster_list->user->id]) : '' ?></h3> 
              <?php if($fosterListUser->foster_date!=NULL){?>
                <h5 class="fechaformatocolor"><span>
                <?php
                  $fecha=$fosterListUser->foster_date;
                  echo $fecha->format('d/m/Y H:i:s'); ?>   
                </span></h5>
              <?php }  ?>
              </div>
          </div><br>
          <h2><?= h($fosterListUser->user->username) ?></h2> 
          <div class="esjuntop"><?= __('Especie: ') ?>
          <div hidden> <?= $especie=$fosterListUser->specie?> </div> 
            <?php
             switch($especie){
                case "cat":
                    echo  __('Gato');
                    break;
                case "dog":
                    echo  __('Perro');
                    break;
                case "bunny":
                  echo  __('Conejo');
                  break;
                case "hamster":
                    echo  __('Hamster');
                    break;
                case "snake":
                    echo  __('Serpiente');
                    break;
                case "turtles":
                        echo  __('Tortuga');
                        break;
                case "other":
                    echo  __('Otro');
                    break;
                case "indifferent":
                    echo  __('Indiferente');
                    break;
                  
                default:
                    echo  __(' ');
                    break;
                }?>               
        
            </p>
          <br>
        </div>
      </div>

    </div><!-- End Objetivo -->