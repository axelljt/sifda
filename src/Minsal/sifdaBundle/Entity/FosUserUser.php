<?php

namespace Minsal\sifdaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * FosUserUser
 *
 * @ORM\Table(name="fos_user_user")
 * @ORM\Entity
 */
class FosUserUser extends BaseUser
{    
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

}
