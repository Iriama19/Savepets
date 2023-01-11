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
            <?= $this->Html->link(__('Edit Publication'), ['action' => 'edit', $publication->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Publication'), ['action' => 'delete', $publication->id], ['confirm' => __('Are you sure you want to delete # {0}?', $publication->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Publication'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Publication'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="publication view content">
            <h3><?= h($publication->title) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($publication->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Message') ?></th>
                    <td><?= h($publication->message) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($publication->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Publication Date') ?></th>
                    <td><?= h($publication->publication_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
