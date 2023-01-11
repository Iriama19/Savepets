<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $message_date
 * @property string $title
 * @property string $content
 * @property int $transmitter_user_id
 * @property int $receiver_user_id
 * @property string|null $readed
 *
 * @property \App\Model\Entity\User $user
 */
class Message extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'message_date' => true,
        'title' => true,
        'content' => true,
        'transmitter_user_id' => true,
        'receiver_user_id' => true,
        'readed' => true,
        'user' => true,
    ];
}
