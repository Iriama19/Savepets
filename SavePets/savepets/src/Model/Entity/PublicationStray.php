<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PublicationStray Entity
 *
 * @property int $id
 * @property int $publication_id
 * @property string|null $img
 * @property string $urgent
 * @property int $user_id
 *
 * @property \App\Model\Entity\Addres[] $address
 */
class PublicationStray extends Entity
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
        'publication_id' => true,
        'image' => true,
        'urgent' => true,
        'user_id' => true,
        'address' => true,
        'publication' => true,
        'comment' => true,

    ];
}
