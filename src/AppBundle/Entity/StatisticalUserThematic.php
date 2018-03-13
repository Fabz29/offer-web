<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * StatisticalUserThematic
 *
 * @ORM\Table(name="statistical_user_thematic")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StatisticalUserThematicRepository")
 */
class StatisticalUserThematic
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
