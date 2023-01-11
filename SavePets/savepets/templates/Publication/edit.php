<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Publication $publication
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $publication->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $publication->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Publication'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="publication form content">
            <?= $this->Form->create($publication) ?>
            <fieldset>
                <legend><?= __('Edit Publication') ?></legend>
                <?php
                    echo $this->Form->control('publication_date');
                    echo $this->Form->control('title');
                    echo $this->Form->control('message');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
