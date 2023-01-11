<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AnimalAdoption Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $start_date
 * @property \Cake\I18n\FrozenTime|null $end_date
 * @property int $user_id
 * @property int $animal_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Animal $animal
 */
class AnimalAdoption extends Entity
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
        'start_date' => true,
        'end_date' => true,
        'user_id' => true,
        'animal_id' => true,
        'user' => true,
        'animal' => true,
    ];
}
