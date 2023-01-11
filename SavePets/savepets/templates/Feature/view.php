<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Feature $feature
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Feature'), ['action' => 'edit', $feature->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Feature'), ['action' => 'delete', $feature->id], ['confirm' => __('Are you sure you want to delete # {0}?', $feature->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Feature'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Feature'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="feature view content">
            <h3><?= h($feature->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Key Feature') ?></th>
                    <td><?= h($feature->key_feature) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($feature->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
