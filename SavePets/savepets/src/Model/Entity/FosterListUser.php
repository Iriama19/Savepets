<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FosterListUser Entity
 *
 * @property int $id
 * @property int $foster_list_id
 * @property int $user_id
 * @property string|null $specie
 * @property \Cake\I18n\FrozenTime|null $foster_date
 */
class FosterListUser extends Entity
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
        'foster_list_id' => true,
        'user_id' => true,
        'specie' => true,
        'foster_date' => true,
    ];
}
