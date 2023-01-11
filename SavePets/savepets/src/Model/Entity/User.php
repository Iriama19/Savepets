<?php
declare(strict_types=1);

namespace App\Model\Entity;
use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $DNI_CIF
 * @property string $name
 * @property string|null $lastname
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $role
 * @property int $address
 *
 * @property \App\Model\Entity\Feature[] $feature
 * @property \App\Model\Entity\FosterList[] $foster_list
 * @property \App\Model\Entity\Profile[] $profile
 */
class User extends Entity
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
        'DNI_CIF' => true,
        'name' => true,
        'lastname' => true,
        'username' => true,
        'password' => true,
        'email' => true,
        'phone' => true,
        'role' => true,
        'birth_date' => true,
        'address' => true,
        'addres' => true,
        'comment' => true,

        // ,
         'feature_user' => true,
         'foster_list' => true,
        // 'profile' => true,
    ];
    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];
}
