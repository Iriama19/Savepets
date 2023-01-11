<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Publication Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $publication_date
 * @property string $title
 * @property string $message
 */
class Publication extends Entity
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
        'publication_date' => true,
        'title' => true,
        'message' => true,
        'publication_help' => true,
        'publication_adoption' => true,
        'publication_stray' => true,
        'publication_stray_addres' => true,
        'comment' => true,


    ];
}
