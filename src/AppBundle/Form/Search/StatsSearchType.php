<?php

namespace AppBundle\Form\Search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\StatsOffer;
use AppBundle\Repository\StatsOfferRepository;

class StatsSearchType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('statsOffer', EntityType::class, array(
                'required' => false,
                'label' => false,
                'class' => StatsOffer::class,
                'placeholder' => 'Global',
                'query_builder' => function (StatsOfferRepository $or) {
                    return $or->createQueryBuilder('s')
                        ->orderBy('s.offerName', 'ASC');
                },
                'choice_label' => 'offerName',
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
        return 'app_admin_stats_search';
    }
}
