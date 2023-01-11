<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FosterList $fosterList
 * @var string[]|\Cake\Collection\CollectionInterface $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $fosterList->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $fosterList->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Foster List'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="fosterList form content">
            <?= $this->Form->create($fosterList) ?>
            <fieldset>
                <legend><?= __('Edit Foster List') ?></legend>
                <?php
                    echo $this->Form->control('user_id');
                    echo $this->Form->control('user._ids', ['options' => $user]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
