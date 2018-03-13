<?php

namespace AppBundle\Form\Search;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class KeywordSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('keyword', TextType::class, array('label' => false, 'placeholder' => 'Mot clé', 'attr' => array('class' => 'form-control')));
    }

    public function getBlockPrefix()
    {
        return 'keyword_search_type';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_admin_keyword_search';
    }
}