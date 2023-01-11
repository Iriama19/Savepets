<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 * @var string[]|\Cake\Collection\CollectionInterface $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $message->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $message->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Message'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="message form content">
            <?= $this->Form->create($message) ?>
            <fieldset>
                <legend><?= __('Edit Message') ?></legend>
                <?php
                    echo $this->Form->control('message_date');
                    echo $this->Form->control('title');
                    echo $this->Form->control('content');
                    echo $this->Form->control('transmitter_user_id');
                    echo $this->Form->control('receiver_user_id', ['options' => $user]);
                    echo $this->Form->control('readed');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
