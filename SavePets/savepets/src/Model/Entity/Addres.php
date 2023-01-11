<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Addres Entity
 *
 * @property int $id
 * @property string $province
 * @property int $postal_code
 * @property string $city
 * @property string $street
 *
 * @property \App\Model\Entity\PublicationStray[] $publication_stray
 */
class Addres extends Entity
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
        'province' => true,
        'postal_code' => true,
        'city' => true,
        'street' => true,
        'country' => true,
        'publication_stray' => true,
        'user' => true,
        'event' => true,

    ];
}
