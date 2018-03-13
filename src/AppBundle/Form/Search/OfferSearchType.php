<?php

namespace AppBundle\Form\Search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Offer;
use AppBundle\Repository\OfferRepository;

class OfferSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('offer', EntityType::class, array(
                    'required' => false,
                    'label' => false,
                    'class' => Offer::class,
                    'placeholder' => 'Toutes les offres',
                    'query_builder' => function (OfferRepository $or) {
                        return $or->createQueryBuilder('o')
                            ->orderBy('o.name', 'ASC');
                    },
                    'choice_label' => 'name',
                    'choice_value' => 'id',
                    'attr' => array(
                        'class' => 'form-control'
                    )
                )
            );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_admin_thematic_search';
    }
}
