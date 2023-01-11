<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PublicationStrayAddres Entity
 *
 * @property int $id
 * @property int $publication_stray_id
 * @property int $addres_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $publication_date
 * @property string|null $image
 *
 * @property \App\Model\Entity\PublicationStray $publication_stray
 * @property \App\Model\Entity\Addres $addres
 * @property \App\Model\Entity\User $user
 */
class PublicationStrayAddres extends Entity
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
        'publication_stray_id' => true,
        'addres_id' => true,
        'user_id' => true,
        'publication_date' => true,
        'image' => true,
        'publication_stray' => true,
        'addres' => true,
        'user' => true,
        'publication' => true,

    ];
}
