<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PublicationAdoption Entity
 *
 * @property int $id
 * @property int $publication_id
 * @property int $animal_id
 * @property string|null $urgent
 * @property int $user_id
 *
 * @property \App\Model\Entity\Publication $publication
 * @property \App\Model\Entity\Animal $animal
 * @property \App\Model\Entity\User $user
 */
class PublicationAdoption extends Entity
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
        'animal_id' => true,
        'urgent' => true,
        'user_id' => true,
        'publication' => true,
        'animal' => true,
        'user' => true,
        'comment' => true,

    ];
}
