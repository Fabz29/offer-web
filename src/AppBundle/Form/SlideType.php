<?php

namespace AppBundle\Form;

use AppBundle\Entity\Slide;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;

class SlideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array('label' => "Titre", 'attr' => array('class' => 'form-control')));
        $builder->add('link', TextType::class, array(
            'label' => "Lien",
            'required' => false,
            'attr' => array(
                'class' => 'form-control',
                'placeholder' => 'www.example.com'
            )
        ));
        $builder->add('suiteNumber', HiddenType::class, array(
            'attr' => array(
                'class' => 'input-suite-number'
            ),
        ));
        $builder->add('media', MediaType::class, array(
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
        return 'slide_type';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Slide::class,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_admin_slide';
    }
}