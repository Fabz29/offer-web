<?php

namespace AppBundle\Form;

use AppBundle\Entity\Thematic;
use AppBundle\Entity\Offer;
use AppBundle\Repository\SlideRepository;
use AppBundle\Repository\ThematicRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ThematicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
            'label' => "Titre",
            'attr' => array(
                'class' => 'form-control'
            )
        ));
        $builder->add('isTemplate', CheckboxType::class, array(
            'label' => "Définir cette thématique en tant que modèle ?",
            'required' => false,
        ));
        $builder->add('parentThematic', EntityType::class, array(
            'required' => false,
            'label' => 'Choisir une thématique parent',
            'class' => Thematic::class,
            'attr' => array(
                'class' => 'form-control',
            ),
            'choice_label' => function ($thematic) {
                $label =  ($thematic->getOffer() ? $thematic->getOffer()->getName() . ' - ' : 'Sans offre - '). $thematic->getTitle() . ($thematic->getIsTemplate() ? ' - modèle' : '');
                return $label;
            },
            'query_builder' => function (ThematicRepository $tr) {
                return $tr->createQueryBuilder('t')
                    ->leftJoin('t.offer', 'o')
                    ->where("t.parentThematic IS NULL")
                    ->orderBy('t.title', 'DESC');
            }
        ));
        $builder->add('offer', EntityType::class, array(
            'required' => false,
            'label' => 'Offre associé',
            'class' => Offer::class,
            'attr' => array(
                'class' => 'form-control',
            ),
            'choice_label' => function ($offer) {
                return $offer->getName();
            },
        ));
        $builder->add('thumbnail', MediaType::class, array(
                'label' => false,
                'required' => false,
                'error_bubbling' => true,
                'attr' => array(
                    'class' => 'form-control',
                ),
            )
        );
        $builder->add('slides', CollectionType::class, array(
            'entry_type'   => SlideType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'required' => false,
            'label' => false,
        ));
    }

    public function getBlockPrefix()
    {
        return 'thematic_type';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Thematic::class,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_admin_thematic';
    }

    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        usort($view['slides']->children, function (FormView $a, FormView $b) {
            /** @var Photo $objectA */
            $objectA = $a->vars['data'];
            /** @var Photo $objectB */
            $objectB = $b->vars['data'];

            $posA = $objectA->getSuiteNumber();
            $posB = $objectB->getSuiteNumber();

            if ($posA == $posB) {
                return 0;
            }

            return ($posA < $posB) ? -1 : 1;
        });
    }
}