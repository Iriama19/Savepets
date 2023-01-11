<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Event> $event
 */
$this->loadHelper('Authentication.Identity');
if($this->Identity->isLoggedIn()){
  $currentuser = $this->request->getAttribute('identity');
  $currentuserRol=$currentuser->role;
  $currentuserID=$currentuser->id;
}
use Cake\I18n\I18n;

?>
<div class="hidden" id="listaeventos" style="display: none"><?php echo json_encode($event) ?></div>
<?php 
  if($this->Identity->isLoggedIn() && ($currentuserRol=='admin'||$currentuserRol=='shelter')){ ?>
        <div>
            <button type="submit" class="listbtn event"><?= $this->Html->link(__($this->Html->image("addnew.png", ["alt" => "Nuevo"])), ['action' => 'add'],['escape' => false]) ?></button>                                    
        </div>
<?php } ?>
    <?= $this->Html->script(['calendar/main','calendar/es','calendar/locales-all']) ?>
    <?= $this->Html->css(['calendar/main']) ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var arrayeventos=document.getElementById("listaeventos");
        var arrayeventoslist=arrayeventos.innerHTML;
        var arrayevent=JSON.parse(arrayeventoslist);
    
        <?php if (I18n::getLocale() !== 'en_US'){ ?>
  
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          timeZone: 'Europe/Madrid',
          locale:'es',
          eventClick: function(info) {
                window.location.href= 'http://localhost:8765/event/view/'+(info.event.id).toString();
            },
            events:
            $.map(arrayevent,function(item){
              return{
                id: item.id,
                title: item.title,
                start: item.start_date,
                end: item.end_date,            
              }
            })
              
            
        });
        <?php }else{?>
          var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          timeZone: 'Europe/Madrid',
          locale:'en',
          eventClick: function(info) {
                window.location.href= 'http://localhost:8765/event/view/'+(info.event.id).toString();
            },
            events:
            $.map(arrayevent,function(item){
              return{
                id: item.id,
                title: item.title,
                start: item.start_date,
                end: item.end_date,            
              }
            })
              
            
        });
        <?php }?>
        calendar.render();
      });

    </script>
    <div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col-9"><div id='calendar'></div></div>
            <div class="col"></div>
        </div>
    </div>
