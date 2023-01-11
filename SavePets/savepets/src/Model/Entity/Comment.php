<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Comment Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $comment_date
 * @property string $message
 * @property int $publication_id
 * @property int $user_id
 */
class Comment extends Entity
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
        'comment_date' => true,
        'message' => true,
        'publication_id' => true,
        'user_id' => true,
        'user' => true,

        'publication_help' => true,
        'publication_adoption' => true,
        'publication_stray' => true,
        'publication_stray_addres' => true,
    ];
}
