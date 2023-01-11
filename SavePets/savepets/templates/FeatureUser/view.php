<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FeatureUser $featureUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Feature User'), ['action' => 'edit', $featureUser->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Feature User'), ['action' => 'delete', $featureUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $featureUser->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Feature User'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Feature User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="featureUser view content">
            <h3><?= h($featureUser->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $featureUser->has('user') ? $this->Html->link($featureUser->user->username, ['controller' => 'User', 'action' => 'view', $featureUser->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Feature') ?></th>
                    <td><?= $featureUser->has('feature') ? $this->Html->link($featureUser->feature->id, ['controller' => 'Feature', 'action' => 'view', $featureUser->feature->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Value') ?></th>
                    <td><?= h($featureUser->value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($featureUser->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
