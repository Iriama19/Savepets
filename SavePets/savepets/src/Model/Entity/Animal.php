<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Animal Entity
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $image
 * @property string $specie
 * @property string|null $chip
 * @property string $sex
 * @property string|null $race
 * @property int|null $age
 * @property string|null $information
 * @property string $state
 */
class Animal extends Entity
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
        'name' => true,
        'image' => true,
        'specie' => true,
        'chip' => true,
        'sex' => true,
        'race' => true,
        'age' => true,
        'information' => true,
        'state' => true,
        'animal_shelter' => true,
    ];
}
