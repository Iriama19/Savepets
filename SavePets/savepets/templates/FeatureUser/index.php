<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\FeatureUser> $featureUser
 */
?>
<div class="featureUser index content">
    <?= $this->Html->link(__('New Feature User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Feature User') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('feature_id') ?></th>
                    <th><?= $this->Paginator->sort('value') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($featureUser as $featureUser): ?>
                <tr>
                    <td><?= $this->Number->format($featureUser->id) ?></td>
                    <td><?= $featureUser->has('user') ? $this->Html->link($featureUser->user->username, ['controller' => 'User', 'action' => 'view', $featureUser->user->id]) : '' ?></td>
                    <td><?= $featureUser->has('feature') ? $this->Html->link($featureUser->feature->id, ['controller' => 'Feature', 'action' => 'view', $featureUser->feature->id]) : '' ?></td>
                    <td><?= h($featureUser->value) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $featureUser->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $featureUser->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $featureUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $featureUser->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
