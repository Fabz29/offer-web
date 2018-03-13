<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Entity\Offer;
use AppBundle\Repository\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    protected $userIds;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->userIds = $options['userIds'];

        $builder->add('name', TextType::class, array('label' => "Nom de l'offre", 'attr' => array('class' => 'form-control')));
        $builder->add('users', EntityType::class, array(
            'class' => User::class,
            'multiple' => true,
            'attr' => array('class' => 'form-control'),
            'label' => 'Clients',
            'query_builder' => function (UserRepository $ur) {
                return $ur->createQueryBuilder('u')
                    ->leftJoin('u.offer', 'o')
                    ->where("u.enabled = 1 AND u.username != 'admin' AND (u.id IN (:userIds) OR u.offer IS NULL)")
                    ->setParameter('userIds', $this->userIds)
                    ;
            }
        ));
        $builder->add('logo', MediaType::class, array(
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            )
        );
        $builder->add('background', MediaType::class, array(
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            )
        );
        $builder->add('fileDownload', MediaType::class, array(
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            )
        );
    }

    public function getBlockPrefix()
    {
        return 'offer_type';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'userIds' => null,
            'data_class' => Offer::class,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_admin_offer';
    }
}