<?php

namespace Todo\ComBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TodoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null , array("label"=>"Ajouter une chose a faire"))
            ->add('description' , null , array("label"=> "Description de la chose a faire"))
            ->add('date', 'date', array("label"=>"Faire au plus tard" ,
		    'widget' => 'single_text',
		    // this is actually the default format for single_text
		    'format' => 'yyyy-MM-dd',
	));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Todo\ComBundle\Entity\Todo'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'todo_combundle_todo';
    }
}
