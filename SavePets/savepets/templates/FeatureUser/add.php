<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FeatureUser $featureUser
 * @var \Cake\Collection\CollectionInterface|string[] $user
 * @var \Cake\Collection\CollectionInterface|string[] $feature
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Feature User'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="featureUser form content">
            <?= $this->Form->create($featureUser) ?>
            <fieldset>
                <legend><?= __('Add Feature User') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $user]);
                    echo $this->Form->control('feature_id', ['options' => $feature]);
                    echo $this->Form->control('value');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
