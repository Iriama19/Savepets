<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PublicationHelp $publicationHelp
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
                      if($currentuserRol=="admin" || $currentuserID==$publicationHelp->user_id){ ?>
                        / <?= $this->Html->link(__('Editar'), ['action' => 'edit', $publicationHelp->id], ['class' => 'side-nav-item']) ?>  / 
                       
                      <?= $this->Form->postLink(__('Eliminar'), ['controller' => 'Publication','action' => 'delete', $publicationHelp->publication_id, 'Help'], 
                        ['confirm' => __('Estas seguro de querer eliminar la publicación {0}?', $publicationHelp->publication->title)]) ?>
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
              <?php if($publicationHelp->user->role=='admin'){ ?>
                <img src="/img/logo.jpg" class="img-perfil" alt="Admin icon">
              <?php } elseif($publicationHelp->user->role=='shelter'){ ?>
                <img src="/img/shelterrol.png" class="img-perfil" alt="Shelter icon">
              <?php }else{ ?>
                <img src="/img/useronly.png" class="img-perfil" alt="Standar icon">
              <?php } 
                if($this->Identity->isLoggedIn()&& ($currentuserRol=="admin" || $currentuserRol=="shelter" || $publicationHelp->user->role =="shelter" ||$currentuserID==$publicationHelp->user_id)){
              ?>
                  <h3> <?= $publicationHelp->has('user') ? $this->Html->link($publicationHelp->user->username, ['controller' => 'User', 'action' => 'view', $publicationHelp->user->id]) : '' ?></h3> 
                <?php }else{?>
                  <h3><b><?= h($publicationHelp->user->username) ?></b></h3>
                <?php  
               } ?>                
              <h5 class="fechaformatocolor"><span><?php $fecha=$publicationHelp->publication->publication_date;
              echo $fecha->format('d/m/Y H:i:s'); ?></span></h5>
            </div>
          </div>
          <h2 class="titulocentrado"><?= h($publicationHelp->publication->title) ?></h2> 
          <div class="esjuntop"><?= __('Categoría: ') ?>
          <div hidden> <?= $categoria=$publicationHelp->categorie?> </div> 
            <?php
             switch($categoria){
                case "textile":
                    echo  __('Textil');
                    break;
                case "medical devices":
                    echo  __('Medicamentos');
                    break;
                case "food":
                  echo  __('Comida');
                  break;
                case "cleaning products":
                  echo  __('Productos limpieza');
                  break;
                case "pet accessories":
                  echo  __('Accesorios para mascotas');
                  break;
                case "other":
                  echo  __('Otro');
                  break;                  
                default:
                    echo  __(' ');
                    break;
                }?>               
        
            </p>
          <p><?= h($publicationHelp->publication->message) ?></p> 
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
            <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['controller' => 'Comment', 'action' => 'add', $publicationHelp->publication_id,$publicationHelp->id,'Help'],['escape' => false]) ?></button>                                    
        </div>
<?php } 
?>
</div>

<div class="row gy-4">
    <table>
        <tbody>
            <?php foreach ($publicationHelp->comment as $publicationcomments): 
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
                                    if($this->Identity->isLoggedIn() && ($currentuserRol=="admin" || $currentuserRol=="shelter"|| $publicationcomments->user->role =="shelter"  ||$currentuserID==$publicationcomments->user->id)){

                                ?>
                                        <h3> <?= $publicationcomments->has('user') ? $this->Html->link($publicationcomments->user->username, ['controller' => 'User', 'action' => 'view', $publicationcomments->user->id, $publicationcomments->id,$publicationHelp->publication_id,$publicationHelp->id,'Help']) : '' ?></h3> 
                                <?php }else{?>
                                        <h3><b><?= h($publicationcomments->user->username) ?></b></h3>
                                    <?php 
                                    } 
                               
                                ?>                                
                                <h5 class="fechaformatocolor"><span><?php $fecha=$publicationcomments->comment_date;
                                    echo $fecha->format('d/m/Y H:i:s'); ?></span>
                                </h5>
                            </div>
                        </div><br>
                        <p ><?= h($publicationcomments->message) ?></p> 

                        <div class="text-centerlist">
                                    
                            <?php 
                                if($this->Identity->isLoggedIn()){
                                    if($currentuserRol=="admin"){ ?>                                    
                                    <button type="submit" class="listbtn"><?= $this->Html->link(__($this->Html->image("pencil.png", ["alt" => "View"])), ['controller' => 'Comment','action' => 'edit', $publicationcomments->id,$publicationHelp->publication_id,$publicationHelp->id,'Help'],['escape' => false]) ?></button>
                                    <button type="submit" class="listbtn">
                                    <?= $this->Form->postLink(__($this->Html->image("trash.png", ["alt" => "Delete Comment"] )), ['controller' => 'Comment','action' => 'delete', $publicationcomments->id,$publicationHelp->publication_id,$publicationHelp->id,'Help'], 
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


