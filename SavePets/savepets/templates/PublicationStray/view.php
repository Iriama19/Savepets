<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationStray $publicationStray
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

                    if($currentuserRol=="admin" || $currentuserID==$publicationStray->user_id){ ?>
                      / <?= $this->Html->link(__('Editar'), ['action' => 'edit', $publicationStray->id], ['class' => 'side-nav-item']) ?>  / 

                       <?= $this->Form->postLink(__('Eliminar'), ['controller' => 'Publication','action' => 'delete', $publicationStray->publication_id,'Stray'], 
                            ['confirm' => __('Estas seguro de querer eliminar la publicación {0}?', $publicationStray->publication->title)],['escape' => false]);
                    }
                  } ?>
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
              <?php if($publicationStray->user->role=='admin'){ ?>
                <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
              <?php } elseif($publicationStray->user->role=='shelter'){ ?>
                <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
              <?php }else{ ?>
                <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
              <?php } 
              if($this->Identity->isLoggedIn() && ($currentuserRol=="admin" || $currentuserRol=="shelter" || $publicationStray->user->role =="shelter" ||$currentuserID==$publicationStray->user_id)){

                ?>
                  <h3> <?= $publicationStray->has('user') ? $this->Html->link($publicationStray->user->username, ['controller' => 'User', 'action' => 'view', $publicationStray->user->id]) : '' ?></h3> 
              <?php 
              }else{ ?>
                  <h3><b><?= h($publicationStray->user->username) ?></b></h3>
                <?php } 
              ?>
              <h5 class="fechaformatocolor"><span><?php $fecha=$publicationStray->publication->publication_date;
              echo $fecha->format('d/m/Y H:i:s'); ?></span></h5> 
            </div>
          </div>
          <h2 class="titulocentrado"><?= h($publicationStray->publication->title) ?></h2> 
          <div class="esjuntop"><?= __('Urgente') ?>:
          <div hidden> <?= $urgente=$publicationStray->urgent?> </div> 
            <?php
             switch($urgente){
                case "yes":
                    echo  __('Sí');
                    break;
                case "no":
                    echo  __('No');
                    break;
                default:
                    echo  __(' ');
                    break;
                }?>               
        
              </div>

            <?php
              if(!empty($publicationStray->image)&& !preg_match('/^strayanimal-img\/$/',$publicationStray->image)){ 
                 $dir='/img/'.$publicationStray->image;
            ?>
                  <img src="<?php echo $dir ?>" class="img-fluid index publicacionfotoanimalview" alt="imagen animal "> 
                  <p class="publication adopcion"><?= h($publicationStray->publication->message) ?></p> 
            <?php
              }else{ ?>
                <p class="publication adopcion"><?= h($publicationStray->publication->message) ?></p> 
            <?php } 
              $CurrentPublicationStray_id=$publicationStray->id;
            ?>
            <button type="submit" class="listbtn verdirecciones"><?= $this->Html->link(__('Ver Direcciones'), ['action' => 'index','controller'=>'PublicationStrayAddress',$CurrentPublicationStray_id]) ?></button>

          <br>
        </div>
      </div>

    </div><!-- End Objetivo -->

<!-- Comentarios -->
<div class="comentarioshead">

<h3><?= __('Comentarios') ?></h3>

    <?php 

    if($this->Identity->isLoggedIn()){ ?>
        <div>
        <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['controller' => 'Comment', 'action' => 'add', $publicationStray->publication_id,$publicationStray->id,'Stray'],['escape' => false]) ?></button>                                    
        </div>
<?php } 
?>
</div>

<div class="row gy-4">
    <table>
        <tbody>
            <?php foreach ($publicationStray->comment as $publicationcomments): 
              ?>
            <tr>        
            <div class=" d-flex align-items-stretch publication view comment" data-aos="fade-up" data-aos-delay="100">
              <div class="objetivo-member publication view comment">
                <div class="member-info">
                  <div class='member-info head'>
                                <?php 
                                    if($publicationcomments->user->role=='admin'){ ?>
                                        <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
                                <?php } elseif($publicationcomments->user->role=='shelter'){ ?>
                                    <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
                                <?php }else{ ?>
                                    <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
                                <?php  } 
                                    if($this->Identity->isLoggedIn() && ($currentuserRol=="admin" || $currentuserRol=="shelter" || $publicationcomments->user->role =="shelter" ||$currentuserID==$publicationcomments->user->user_id)){
                                ?>
                                        <h3> <?= $publicationcomments->has('user') ? $this->Html->link($publicationcomments->user->username, ['controller' => 'User', 'action' => 'view', $publicationcomments->user->id, $publicationcomments->id,$publicationStray->publication_id,$publicationStray->id,'Stray']) : '' ?></h3> 
                                <?php  }else{?>
                                        <h3><b><?= h($publicationcomments->user->username) ?></b></h3>
                                    <?php 
                                    } 
                               
                                ?>                                
                                <h5 class="fechaformatocolor"><span><?php $fecha=$publicationcomments->comment_date;
                                    echo $fecha->format('d/m/Y H:i:s'); ?></span>
                                </h5>
                            </div>
                        </div>
                        <p class="indexpublication"><?= h($publicationcomments->message) ?></p> 

                        <div class="text-centerlist">

                            <?php 
                                if($this->Identity->isLoggedIn()){
                                  if($currentuserRol=="admin"){ ?>                                    
                                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['controller' => 'Comment','action' => 'edit', $publicationcomments->id,$publicationStray->publication_id,$publicationStray->id,'Stray'],['escape' => false]) ?></button>
                                    <button type="submit" class="listbtn">
                                    <?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Comment"] )), ['controller' => 'Comment','action' => 'delete', $publicationcomments->id,$publicationStray->publication_id,$publicationStray->id,'Stray'], 
                                    ['escape'=>false,'confirm' => __('Estas seguro de querer eliminar el comentario ?')],['escape' => false]) ?> </button>
                            <?php  } 
                            }?>
                        </div>
                        <br>
                    </div>
                    </div>

                </div><!-- End Objetivo -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


