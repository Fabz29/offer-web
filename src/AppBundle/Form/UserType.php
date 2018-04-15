<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Entity\Offer;
use AppBundle\Repository\OfferRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', TextType::class, array(
            'label' => "Email",
            'attr' => array(
                'class' => 'form-control'
            )
        ));
        $builder->add('civility', ChoiceType::class, array(
                'choices' => array(
                    'Madame' => 'Madame',
                    'Monsieur' => 'Monsieur',
                ),
                'label' => 'Civilité',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            )
        );
        if ($options['isChange']) {
            $builder->add('plainPassword', TextType::class, array(
                'label' => "Mot de passe",
                'required' => false,
                'attr' => array(
                    'class' => 'form-control'
                )
            ));
        } else {
            $builder->add('plainPassword', TextType::class, array(
                'label' => "Mot de passe",
                'required' => true,
                'attr' => array(
                    'class' => 'form-control'
                )
            ));
        }
        $builder->add('lastName', TextType::class, array(
            'label' => "Nom",
            'attr' => array(
                'class' => 'form-control'
            )
        ));
        $builder->add('firstName', TextType::class, array(
            'label' => "Prénom",
            'attr' => array(
                'class' => 'form-control'
            )
        ));
        $builder->add('accessStartAt', DateType::class, array(
                'label' => "Date d'ouverture",
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy ',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'jj/mm/aaaa',
                    'class' => "form-control datepicker",
                ),
            )
        );
        $builder->add('accessEndAt', DateType::class, array(
                'label' => "Date de fermeture",
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy ',
                'required' => false,
                'attr' => array(
                    'placeholder' => 'jj/mm/aaaa',
                    'class' => "form-control datepicker",
                ),
            )
        );
        $builder->remove('username');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
            'isChange' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user_registration';
    }
}